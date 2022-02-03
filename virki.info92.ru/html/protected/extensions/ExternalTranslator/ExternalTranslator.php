<?php

class ExternalTranslator extends CComponent
{

    private $_bingTranslateBaseUrl = 'http://api.microsofttranslator.com/';
    private $_bingTranslateBaseUrl_azure = 'https://api.datamarket.azure.com/Bing/MicrosoftTranslator/v1/Translate';
    private $_success = false;
    private $_translatedText;
    private $_yandexTranslateBaseUrl_json = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
    private $_yandexTranslateBaseUrl_xml = 'https://translate.yandex.net/api/v1.5/tr/translate';
    private $source = '';
    private $useHTMLDom = false;
    public $lastRowId = 0;
    private static $_KeyTranslator = false;
    private static $_curlObject = false;
    private static $_keysExpired = false;

    private function logTranslation($key, $query, $result)
    {

        $i_key = $key;
        $i_query = mb_strlen($query, 'UTF-8');
//    $i_crc =md5($query);
//    $i_squery = $query;
        if ($result) {
            $i_result = 1;
        } else {
            $i_result = 0;
        }
        try {
            $command = Yii::app()->db->createCommand(
              "INSERT INTO log_translator_keys (\"date\",\"keyid\",\"result\",\"chars\",\"function\")
VALUES (Now(), (SELECT tk.id FROM translator_keys tk WHERE tk.\"key\"=:key LIMIT 1),
        :result,:chars,NULL)"
            );
            $command->execute(
              [
                ':key'    => $i_key,
                ':result' => $i_result,
                ':chars'  => $i_query,
              ]
            );
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    private function normalizeLanguage($language)
    {
        $result = substr(strtolower($language), 0, 2);
        return $result;
    }

    private function normalizeText($text)
    {
        if (!$text) {
            return $text;
        }
        $result = $text;
        if ($this->useHTMLDom && preg_match('/[<>]+/', $result)) {
            $dom = @str_get_html($result);
            if ($dom) {
                $result = $dom->plaintext;
                $dom->clear();
                unset($dom);
            }
        }
        $result = trim($result);
        return $result;
    }

    private function saveTranslation($message, $translation, $source, $language, $category = 'default')
    {
        $_message = $this->normalizeText($message);
        $_translation = $this->normalizeText($translation);
        $_source = $this->normalizeLanguage($source);
        $_language = $this->normalizeLanguage($language);
        $_category = $category;
        $_insertIfNotFound = true;
        if ((strlen($message) <= 0) || (strlen($translation) <= 0) || (strlen($source) <= 0) || (strlen(
              $language
            ) <= 0) || (strlen($category) <= 0)
        ) {
            return 0;
        }
        if ($_category == 'category') {
            $t_source = 't_source_category';
            $t_message = 't_category';
        } elseif ($_category == 'top10000') {
            $t_source = 't_source_sentences';
            $t_message = 't_sentences';
            $_insertIfNotFound = false;
        } else {
            if (mb_strlen($_message, 'UTF-8') <= 32 && (!in_array($_category, ['item_title', 'item_comment']))) {
                $t_source = 't_source_dictionary';
                $t_message = 't_dictionary';
            } else {
                $t_source = 't_source_dictionary_long';
                $t_message = 't_dictionary_long';
            }
        }
        if ($_category == '*') {
            $_category = 'default';
        }
        $source_dictionary_id_command = Yii::app()->db->createCommand(
          "select sd.id from {$t_source} sd where
       (sd.category=:in_category) and sd.language =:in_source and message_md5=md5(:in_message) LIMIT 1"
        );
        $source_dictionary_id = $source_dictionary_id_command->queryScalar(
          [
            ':in_category' => $_category,
            ':in_source'   => $_source,
            ':in_message'  => $_message,
          ]
        );
        if (!$source_dictionary_id && $_insertIfNotFound) {
            $result = Yii::app()->db->createCommand(
              "insert into {$t_source} (language, category, message, message_md5" .
              (($t_source == 't_source_dictionary_long') ? ', message_length' : '') .
              ")
              values(:in_source,:in_category,:in_message,md5(:in_message)" .
              (($t_source == 't_source_dictionary_long') ? ',char_length(:in_message)' : '') .
              ")
              ON CONFLICT ON CONSTRAINT {$t_source}_constr 
                            DO NOTHING"
            )->execute(
              [
                ':in_category' => $_category,
                ':in_source'   => $_source,
                ':in_message'  => $_message,
              ]
            );
            $source_dictionary_id = $source_dictionary_id_command->queryScalar(
              [
                ':in_category' => $_category,
                ':in_source'   => $_source,
                ':in_message'  => $_message,
              ]
            );
            if (!$source_dictionary_id) {
                return 0;
            }
        }
        if ($source_dictionary_id) {
            $result = Yii::app()->db->createCommand(
              "insert into {$t_message} (id,language,translation,freq,status)
                                          values(:id,:language,:translation,1,0)
                         ON CONFLICT ON CONSTRAINT {$t_message}_constr
                                              DO UPDATE SET
                                          translation=:translation, freq=freq+1"
            )->execute(
              [
                ':id'          => $source_dictionary_id,
                ':language'    => $_language,
                ':translation' => $_translation,
              ]
            );
            $this->lastRowId = $source_dictionary_id;
            return $source_dictionary_id;
        } else {
            return 0;
        }
    }

    private function saveTranslationMultiple($message, $translation, $source, $language, $category = 'default')
    {
        $resMessage = preg_match_all('/<\s*[p]\s*>(.*?)<\s*\/\s*[p]\s*>/i', $message, $messages);
        $resTranslation = preg_match_all('/<\s*[p]\s*>(.*?)<\s*\/\s*[p]\s*>/i', $translation, $translations);
        if (!$resMessage ||
          !$resTranslation ||
          ($resMessage != $resTranslation) ||
          !isset($messages[1]) ||
          !isset($translations[1])) {
            return;
        }
        foreach ($messages[1] as $i => $_message) {
            $res = $this->saveTranslation($_message, $translations[1][$i], $source, $language, $category);
        }
    }

    function init()
    {
        $path = Yii::getPathOfAlias('application.extensions.simple_html_dom.simple_html_dom') . '.php';
        if (file_exists($path)) {
            try {
                include_once($path);
                $this->useHTMLDom = true;
            } catch (Exception $e) {
                $this->useHTMLDom = false;
            }
        }
    }

    public function translateText(
      $query = '',
      $from = 'zh-CHS',
      $to = '',
      $category = 'default',
      $rawResult = false,
      $multiple = false
    ) {
        $this->_success = false;
        $this->source = ($multiple ? $query : $this->normalizeText($query));
        if ($this->source == '' || $to == '' || $from == '') {
            return false;
        } else {
            if (self::$_KeyTranslator == false) {
                self::$_KeyTranslator = self::getKeyTranslator('Yandex');
            }
            $KeyTranslator = self::$_KeyTranslator;
            if ($KeyTranslator == false) {
                $this->_success = false;
                if (class_exists('Profiler', false)) {
                    Profiler::message('ExtTranslator', 'no keys available');
                }
                return false;
            }
            if (self::$_keysExpired) {
                $this->_success = false;
                if (class_exists('Profiler', false)) {
                    Profiler::message('ExtTranslator', 'error or key expired');
                }
                return false;
            }
            try {
                if ($KeyTranslator->type == 'BingV1') {
//====================================================================
                    $url = "V2/Http.svc/Translate?appId=" . $KeyTranslator->appId . "&from=" . $from .
                      "&to=" . $to . "&text=" . urlencode($this->source);
//            echo $url; die;

                    try {
                        $ch = self::getCurl(false);
                    } catch (Exception $e) {
                        throw new CHttpException (500, Yii::t('main', 'System error: curl not installed or inited.'));
                    }
                    curl_setopt($ch, CURLOPT_URL, $this->_bingTranslateBaseUrl . $url);
                    curl_setopt($ch, CURLOPT_REFERER, $this->_bingTranslateBaseUrl);

                    $contents = curl_exec($ch);
                    if (curl_errno($ch) > 0) {
                        throw new CHttpException(500, curl_error($ch));
                    }
                    if (!empty($contents)) {
                        $xmlData = @simplexml_load_string($contents);
                        if ($xmlData->body->h1 == "Argument Exception") {
                            $this->_success = false;
                            $this->logTranslation($KeyTranslator->appId, $url, false);
                            if (class_exists('Profiler', false)) {
                                Profiler::message('ExtTranslator', 'error');
                            }
                            return false;
                        } else {
                            $this->_success = true;
                            $this->logTranslation($KeyTranslator->appId, $url, true);
                            if ($rawResult) {
                                $this->_translatedText = $contents;
                                return $this->_translatedText;
                            } else {
                                $this->_translatedText = ($multiple ? (string) $xmlData : $this->normalizeText(
                                  (string) $xmlData
                                ));
                            }
                            if ($multiple) {
                                $this->lastRowId = 0;
                                $this->saveTranslationMultiple(
                                  $this->source,
                                  $this->_translatedText,
                                  $from,
                                  $to,
                                  $category
                                );
                            } else {
                                $this->lastRowId = $this->saveTranslation(
                                  $this->source,
                                  $this->_translatedText,
                                  $from,
                                  $to,
                                  $category
                                );
                            }
                            return $this->_translatedText;
                        }
                    } else {
                        throw new CHttpException(500, '(1) Error communcating with Bing Translate.');
                    }
                } elseif ($KeyTranslator->type == 'BingV2') {
//====================================================================
                    //$texts = json_encode($query);
                    $langs = [
                      'en-US'  => 'en',
                      'ru-RU'  => 'ru',
                      'zh-CN'  => 'zh',
                      'zh-CHS' => 'zh',
                    ];
                    $langsArray = explode(
                      '|',
                      'az|sq|am|en|ar|hy|af|eu|ba|be|bn|my|bg|bs|cy|hu|vi|ht|gl|nl|el|ka|gu|da|he|yi|id|ga|it|is|es|kk|kn|ca|ky|zh|ko|xh|km|lo|la|lv|lt|lb|mg|ms|ml|mt|mk|mi|mr|mn|de|ne|no|pa|fa|pl|pt|ro|ru|sr|si|sk|sl|sw|su|tg|th|tl|ta|tt|te|tr|uz|uk|ur|fi|fr|hi|hr|cs|sv|gd|et|eo|jv|ja'
                    );//DSConfig::getVal('site_language_supported'));
                    foreach ($langsArray as $langVal) {
                        if (!isset($langs[$langVal])) {
                            $langs[$langVal] = $langVal;
                        }
                    }

                    if ((!isset($langs[$to])) || (!isset($langs[$from]))) {
                        //    echo '(2) Error communcating with Bing Translate.';
                        throw new CHttpException(500, '(2) Error communcating with Bing Translate.');
                    }

                    $url = $this->_bingTranslateBaseUrl_azure;
                    $url .= "?Text=%27" . urlencode($this->source) . "%27";
                    $url .= "&To=%27" . $langs[$to] . "%27";
                    $url .= "&From=%27" . $langs[$from] . "%27";
                    $url .= "&\$top=1";
                    $url .= "&\$format=json";

                    try {
                        $ch = self::getCurl(false);
                    } catch (Exception $e) {
                        throw new CHttpException (500, Yii::t('main', 'System error: curl not installed or inited.'));
                    }

//--------
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_USERPWD, "$KeyTranslator->appId:$KeyTranslator->appId"); //$key.':'.$key);

// Get the response from Bing
                    try {
                        $contents = curl_exec($ch);
                        // curl_close($ch);
                    } catch (Exception $e) {
                        // echo $e->getMessage();
                        if (class_exists('Profiler', false)) {
                            Profiler::message('ExtTranslator', 'error curl');
                        }
                        if (class_exists('LogSiteErrors', false)) {
                            LogSiteErrors::logError('ExtTranslator', 'Curl error: BingTranslator.php line 216');
                        }
                        //logError($error_label,$error_message=false,$error_description=false,$custom_data=false)
                        return false;
                    }

//            }
//      $contents = $this->_remoteQuery($url);
                    if (!empty($contents) && ($contents != 'Parameter: To has an invalid pattern of characters')) //
                    {
                        $jsonData = json_decode($contents);
                        if (!(isset($jsonData->d->results[0]->Text))) {
                            $this->_success = false;
                            $this->logTranslation($KeyTranslator->appId, $url, false);
                            self::$_keysExpired = true;
                            if (class_exists('Profiler', false)) {
                                Profiler::message('ExtTranslator', 'Bing error or key expired!');
                            }
                            if (preg_match('/Insufficient balance/i', $contents)) {
                                $command = Yii::app()->db->createCommand(
                                  "UPDATE translator_keys tk
                                 SET tk.banned=1,
                                     tk.banned_date=NOW()
                               WHERE tk.key = :key"
                                );
                                $command->execute([':key' => $KeyTranslator->appId]);
                            }
                            return false;
                        } else {
                            $this->_success = true;
                            $this->logTranslation($KeyTranslator->appId, $url, true);
                            if ($rawResult) {
                                $this->_translatedText = $contents;
                                return $this->_translatedText;
                            } else {
                                $this->_translatedText =
                                  ($multiple ? (string) $jsonData->d->results[0]->Text : $this->normalizeText(
                                    (string) $jsonData->d->results[0]->Text
                                  ));
                            }
                            if ($multiple) {
                                $this->lastRowId = 0;
                                $this->saveTranslationMultiple(
                                  $this->source,
                                  $this->_translatedText,
                                  $from,
                                  $to,
                                  $category
                                );
                            } else {
                                $this->lastRowId = $this->saveTranslation(
                                  $this->source,
                                  $this->_translatedText,
                                  $from,
                                  $to,
                                  $category
                                );
                            }
                            return $this->_translatedText;
                        }
                    } else {
//              echo ('To has an invalid pattern of characters.');
                        throw new CHttpException(
                          500,
                          '(3) Error communcating with Bing Translate. To has an invalid pattern of characters.'
                        );
                    }

//====================================================================
                } elseif ($KeyTranslator->type == 'Yandex') {
//====================================================================
                    //$texts = json_encode($query);
                    $langs = [
                      'en-US'  => 'en',
                      'ru-RU'  => 'ru',
                      'zh-CN'  => 'zh',
                      'zh-CHS' => 'zh',
                      'zh'     => 'zh',
                    ];
                    $langsArray = explode(
                      ',',
                      'az,sq,am,en,ar,hy,af,eu,ba,be,bn,my,bg,bs,cy,hu,vi,ht,gl,nl,mrj,el,ka,gu,da,he,yi,id,ga,it,is,es,kk,kn,ca,ky,zh,ko,xh,km,lo,la,lv,lt,lb,mg,ms,ml,mt,mk,mi,mr,mhr,mn,de,ne,no,pa,pap,fa,pl,pt,ro,ru,ceb,sr,si,sk,sl,sw,su,tg,th,tl,ta,tt,te,tr,udm,uz,uk,ur,fi,fr,hi,hr,cs,sv,gd,et,eo,jv,ja'
                    );//DSConfig::getVal('site_language_supported'));
                    foreach ($langsArray as $langVal) {
                        if (!isset($langs[$langVal])) {
                            $langs[$langVal] = $langVal;
                        }
                    }

                    if ((!isset($langs[$to])) || (!isset($langs[$from]))) {
                        throw new CHttpException(500, '(2) Error communcating with Yandex Translate.');
                    }

                    $url = $this->_yandexTranslateBaseUrl_json;
                    /*
                    https://translate.yandex.net/api/v1.5/tr.json/translate ?
                    key=<API-ключ>
                    & text=<переводимый текст>
                    & lang=<направление перевода>
                    & [format=<формат текста>]
                    & [options=<опции перевода>]
                    & [callback=<имя callback-функции>]
                    */
                    $url .= '?key=' . $KeyTranslator->appId;
                    $url .= '&text=' . urlencode($this->source);
                    $url .= '&lang=' . $langs[$from] . '-' . $langs[$to];
                    $url .= '&format=html';
                    $url .= "&options=0";

                    try {
                        $ch = self::getCurl(false);
                    } catch (Exception $e) {
                        throw new CHttpException (500, Yii::t('main', 'System error: curl not installed or inited.'));
                    }

//--------
                    curl_setopt($ch, CURLOPT_URL, $url);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    //curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    //curl_setopt($ch, CURLOPT_USERPWD, "$KeyTranslator->appId:$KeyTranslator->appId"); //$key.':'.$key);

// Get the response from Yandex
                    try {
                        $contents = curl_exec($ch);
                        // curl_close($ch);
                    } catch (Exception $e) {
                        // echo $e->getMessage();
                        if (class_exists('Profiler', false)) {
                            Profiler::message('ExtTranslator', 'error curl');
                        }
                        if (class_exists('LogSiteErrors', false)) {
                            LogSiteErrors::logError('ExtTranslator', 'Curl error: ExtTranslator.php line 395');
                        }
                        return false;
                    }
                    $curlInfo = curl_getinfo($ch);
//            }
                    /*
                    200 Операция выполнена успешно
                    401 Неправильный API-ключ
                    402 API-ключ заблокирован
                    404 Превышено суточное ограничение на объем переведенного текста
                    413 Превышен максимально допустимый размер текста
                    422 Текст не может быть переведен
                    501 Заданное направление перевода не поддерживается
                    */
                    if (!empty($contents)) //
                    {
                        $jsonData = json_decode($contents);
                        if (!isset($jsonData->text[0])) {
                            $this->_success = false;
                            $this->logTranslation($KeyTranslator->appId, $this->source, false);
                            self::$_keysExpired = true;
                            if (class_exists('Profiler', false)) {
                                Profiler::message('ExtTranslator', 'Yandex error or key expired!');
                            }
                            if (isset($jsonData->code)) {
                                if (in_array($jsonData->code, [401, 402, 404])) {
                                    $command = Yii::app()->db->createCommand(
                                      "UPDATE translator_keys tk
                                 SET tk.banned=1,
                                     tk.banned_date=NOW()
                               WHERE tk.key = :key"
                                    );
                                    $command->execute([':key' => $KeyTranslator->appId]);
                                }
                                LogSiteErrors::logError('ExtTranslator', 'Yandex error: ' . $jsonData->code);
                            }
                            return false;
                        } else {
                            $this->_success = true;
                            $this->logTranslation($KeyTranslator->appId, $this->source, true);
                            if ($rawResult) {
                                $this->_translatedText = $contents;
                                return $this->_translatedText;
                            } else {
                                $this->_translatedText =
                                  ($multiple ? (string) $jsonData->text[0] : $this->normalizeText(
                                    (string) $jsonData->text[0]
                                  ));
                            }
                            if ($multiple) {
                                $this->lastRowId = 0;
                                $this->saveTranslationMultiple(
                                  $this->source,
                                  $this->_translatedText,
                                  $from,
                                  $to,
                                  $category
                                );
                            } else {
                                $this->lastRowId = $this->saveTranslation(
                                  $this->source,
                                  $this->_translatedText,
                                  $from,
                                  $to,
                                  $category
                                );
                            }
                            return $this->_translatedText;
                        }
                    } else {
//              echo ('To has an invalid pattern of characters.');
                        throw new CHttpException(
                          500,
                          '(3) Error communcating with Bing Translate. To has an invalid pattern of characters.'
                        );
                    }

//====================================================================
                } else {
                    if (class_exists('Profiler', false)) {
                        Profiler::message('ExtTranslator', 'error');
                    }
                    return false;
                }

            } catch (Exception $e) {
                if (class_exists('Profiler', false)) {
                    Profiler::message('ExtTranslator', 'error');
                }
                //echo $e->getMessage();
                if (class_exists('LogSiteErrors', false)) {
                    LogSiteErrors::logError('ExtTranslator', 'Error: BingTranslator.php line 256');
                }
                //logError($error_label,$error_message=false,$error_description=false,$custom_data=false)
                return false;
            }
        }
    }

    /**
     * Translate the given text
     * @param string $text text to translate
     * @param string $from language to translate to
     * @param string $to   language to translate from
     * @return boolean | string
     */
    public function translateTextEx(
      $key,
      $type,
      $query = '',
      $from = 'zh-CHS',
      $to = '',
      $category = 'default',
      $plainRes = false
    ) {
        self::$_KeyTranslator = new stdClass();
        self::$_KeyTranslator->type = $type;
        self::$_KeyTranslator->appId = $key;
        return $this->translateText($query, $from, $to, $category, $plainRes);
    }

    /**
     * Возвращает ресурс curl c базовыми настройкми
     **/
    private static function getCurl($secure = false)
    {
        try {
            if (gettype(self::$_curlObject) != 'resource') {
                $ch = curl_init();
                self::$_curlObject = $ch;
            } else {
                $ch = self::$_curlObject;
            }

            curl_setopt(
              $ch,
              CURLOPT_USERAGENT,
              'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
            );
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//      curl_setopt($ch, CURLOPT_HEADER, TRUE); // Ото ж выводить ли хэдер в контент
            curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 7);
            curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
            //curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
            curl_setopt($ch, CURLOPT_NOPROGRESS, true);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
//---------
            $header = [];
            $header[] = "Connection: keep-alive";
            $header[] = "Keep-Alive: 30";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            return $ch;
        } catch (Exception $e) {
            throw new CHttpException (500, Yii::t('main', 'System error: curl not installed or inited.'));
        }
    }

    private static function getKeyTranslator($type = false)
    {
        //TODO Поменять на ивент снимающий бан раз в месяц 1-го числа
        /*    if (((int) date('j') == 1) && (((int) date('i')) / 2 == intval(((int) date('i')) / 2))) {
              $command = Yii::app()->db->createCommand("update LOW_PRIORITY translator_keys tk
        set tk.banned=0
        where DATE_FORMAT(NOW() ,'%Y-%m-01')=DATE_FORMAT(CURDATE(),'%Y-%m-%d')
        and tk.banned_date<CAST(DATE_ADD(NOW(), INTERVAL -10 MINUTE) AS DATETIME)");
              $command->execute();
            }
        */
        // Бан ключа, если за последние 10 мин. (м.б 10 раз подряд) ключ выдал некорректные результаты
        /*    if (((int) date('i')) / 2 == intval(((int) date('i')) / 2)) {
              $command = Yii::app()->db->createCommand("update LOW_PRIORITY translator_keys tk
        set tk.banned=1,
        tk.banned_date=CAST(NOW() AS DATETIME)
        where (select count(0) from log_translator_keys lt where lt.keyid=tk.id and tk.banned<>1
        and lt.date>CAST(DATE_ADD(NOW(), INTERVAL -15 MINUTE) AS DATETIME)
        and lt.result=0)>20");
              $command->execute();
            }
        */
        //TODO Сделать равномерную выборку ключей (варианты - счетчик или лог)
        $command = Yii::app()->db->createCommand(
          "SELECT tk1.id, tk1.\"key\",tk1.type FROM translator_keys tk1
WHERE tk1.id > (SELECT FLOOR( MAX(tk2.id) * random()) FROM translator_keys tk2 WHERE (tk2.type =:type || :type IS NULL) 
AND tk2.enabled=1 AND tk2.banned=0)
 AND (tk1.type =:type || :type IS NULL)
 AND tk1.enabled=1 AND tk1.banned=0
ORDER BY tk1.id LIMIT 1"
        );
        $row = $command->queryRow(true, [':type' => ($type ? $type : null)]);
        if ($row != false) {
            $key = new stdClass();
            $key->type = $row['type'];
            $key->appId = $row['key'];
        } else {
            $key = false;
        }
        return $key;
    }
}