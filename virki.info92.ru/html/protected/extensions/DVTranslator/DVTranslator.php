<?php

class DVTranslator extends CComponent
{
    private $DSGLog = [];
    private $_categoryTranslations = [];
    private $_success = false;
    private $_translatedText;
    private $callFromBlockMode = false;
    private $useHTMLDom = false;
    private $useTFunction = null;
    public $editableByRole = false;
    public $memCacheTtl = 7200;
    public $translator_block_mode_enabled = false;
    public $translator_clear_text_in_params = false;
    public $translator_edit_url = 'pim.mall92.ru/site/translate';
    public $useSplitTranslation = true;
    public static $chineseDigits = '\d\.\-〇零一壹二贰三叁四肆五六陆七柒八捌九玖十拾廿念卅卌百佰皕千仟万亿兆';
    public static $chineseStopChars = '`_=\?\|\{\}<>\&\^\@!~:;\+—－。、：；！·？“”［］●　【】《》，,★！’\/\\\(\)\[\]\s（）"\'\*\$#%';
    public static $chineseStopPhrase = '(?:韩[版]*)';
    public static $chineseStopWords = '女男的一不在人有是为以于上他而后之来及了因下可到由这与也此但并个其已无小我们起最再今去好只又或很亦某把那你乃它吧被比别趁当从到得打凡儿尔该各给跟和何还即几既看据距靠啦了另么每们嘛拿哪那您凭且却让仍啥如若使谁虽随同所她哇嗡往哪些向沿哟用于咱则怎曾至致着诸自';

    private function _collectLexic($source, $translation, $from, $to, $type, $attributes)
    {
        try {
            if (Yii::app()->db->cache(3600)->createCommand(
              "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 't_lexic_collector'"
            )->queryRow()) {
                if (in_array($type, ['item_title', 'item_comment'])) {
                    if ($from == 'zh' and $to == 'ru') {
                        if (isset($attributes['cid'])) {
                            if (is_array($source)) {
                                $sourceText = implode(' ', $source);
                            } else {
                                $sourceText = $source;
                            }
                            if (is_array($translation)) {
                                foreach ($translation as $i => $val) {
                                    $translation[$i] = $this->removeOnlineTranslation($val);
                                }
                                $translationText = implode(' ', $translation);
                            } else {
                                $translationText = $this->removeOnlineTranslation($translation);
                            }
                            $res = Yii::app()->db->createCommand(
                              "
                 INSERT INTO t_lexic_collector (cid,zh,ru,zh_md5,cnt)
                 VALUES (:cid,:zh,:ru,md5(:zh),1)
                   ON CONFLICT ON CONSTRAINT t_lexic_collector_constr 
                                          DO UPDATE SET cnt=cnt+1
                 "
                            )->execute(
                              [
                                ':cid' => $attributes['cid'],
                                ':zh'  => $sourceText,
                                ':ru'  => $translationText,
                              ]
                            );
                        }
                    }
                }
            }
        } catch (Exception $e) {
            return;
        }
    }

    private function attributesToString($attribures)
    {
        $res = ' ';
        foreach ($attribures as $name => $value) {
            if ($name[0] != '_') {
                $res = $res . $name . '="' . $value . '"' . ' ';
            }
        }
        return $res;
    }

    private function getAttributes($translation)
    {
        $res = preg_match('/<translation\s.*?>/isu', $translation, $attributesSection);
        if (!$res) {
            return false;
        }
        $res = preg_match_all('/\s([\w\d_-]+)=["](.+?)["]/isu', $attributesSection[0], $searchAttrinbutes);
        if (!$res) {
            return false;
        }
        $attributes = [];
        foreach ($searchAttrinbutes[1] as $j => $attribute) {
            $attributes[$attribute] = $searchAttrinbutes[2][$j];
        }
        if (!isset($attributes['from'])) {
            $attributes['from'] = 'zh-CHS';
        }
        if (!isset($attributes['to'])) {
            $attributes['to'] = 'ru';
        }
        return $attributes;
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

    private function sourceDataFromDB($message, $source, $category = '*')
    {
        $result = new stdClass();
        $result->message_id = 0;
        $result->category = $category;
        $result->use_long = 'S';
        if ($this->translator_block_mode_enabled && !$this->callFromBlockMode) { // || (!$this->_success)
            return $result;
        }
        $_message = $this->normalizeText($message);
        $_source = $this->normalizeLanguage($source);
        $_category = $category;
        if ($_category == 'category') {
            $t_source = 't_source_category';
            $t_message = 't_category';
        } elseif (in_array($_category, ['item_title', 'item_comment'])) {
            $t_source = 't_source_dictionary_long';
            $t_message = 't_dictionary_long';
        } elseif ($_category == 'top10000') {
            $t_source = 't_source_sentences';
            $t_message = 't_sentences';
        } else {
            if (mb_strlen($_message, 'UTF-8') <= 32) {
                $t_source = 't_source_dictionary';
                $t_message = 't_dictionary';
            } else {
                $t_source = 't_source_dictionary_long';
                $t_message = 't_dictionary_long';
            }
        }
        $sourceDataRec = Yii::app()->db->createCommand(
          "select sd.id, sd.category from {$t_source} sd where
            (sd.category=:category or :category='*') and
            sd.language =:source and
            message_md5=md5(:message) LIMIT 1"
        )->queryRow(
          true,
          [
            ':category' => $_category,
            ':message'  => $_message,
            ':source'   => $_source,
          ]
        );
        if ($sourceDataRec) {
            $result->message_id = $sourceDataRec['id'];
            $result->category = $sourceDataRec['category'];
            $result->use_long = ($t_source == 't_source_dictionary_long' ? 'L' : 'S');
        }
        return $result;
    }

    private function translateFromDB($message, $source, $language, $category = '*', $withId = true)
    {
        /*
                 if (in_array($from, array('zh-CHS', 'zh-CN', 'zh'))) {
        //---------- Очищаем значения свойств от мусора в скобках
        //【比图片深点】
        // （换码运费自理）
                    $clear_query = trim(preg_replace('/【.*?】/u', '', $int_query));
                    if ($clear_query != '') {
                        $int_query = $clear_query;
                    }
        //(适合115-130斤）
                    $clear_query = trim(preg_replace('/[\(（].*?[）\)]/u', '', $int_query));
                    if ($clear_query != '') {
                        $int_query = $clear_query;
                    }
                    $clear_query = trim(preg_replace('/".*?"/u', '', $int_query));
                    if ($clear_query != '') {
                        $int_query = $clear_query;
                    }
                    if (!preg_match("/[".DSGParserClass::pcreCharsetChinese."]{1}/u", $int_query)) {
                        $res = $int_query;
                    }
                }
         */

        $_message = $this->normalizeText($message);
        $_source = $this->normalizeLanguage($source);
        $_language = $this->normalizeLanguage($language);
        $_category = $category;
        $_message_id = 0;
        $_translation_category = $category;
        $_translation = '';
        $_use_long = 'S';
        if (is_null($this->useTFunction)) {
            $this->useTFunction = Yii::app()->db->cache(3600)->createCommand(
              "SELECT count(0) FROM INFORMATION_SCHEMA.ROUTINES
               WHERE
                ROUTINE_TYPE='FUNCTION'
								AND ROUTINE_CATALOG = current_catalog
                AND ROUTINE_SCHEMA = current_schema
           AND ROUTINE_NAME = 't' LIMIT 1"
            )->queryScalar();
        }
        if ($this->useTFunction && $category != 'pinned') {
            $tempStr = Yii::app()->db->createCommand("SELECT t(:category,:message,:source,:language,1)")
              ->queryScalar(
                [
                  ':category' => $_category,
                  ':message'  => $_message,
                  ':source'   => $_source,
                  ':language' => $_language,
                ]
              );
            if (preg_match('/^\[(.+?)\]\[(\d+)\]\[(L|S)*\](.*)/s', $tempStr, $res)) {
                $_translation_category = $res[1];
                $_message_id = $res[2];
                $_use_long = $res[3];
                $_translation = $res[4];
            }
        } else {
            if ($_category == 'category') {
                $t_source = 't_source_category';
                $t_message = 't_category';
            } elseif ($_category == 'pinned') {
                $t_source = 't_source_pinned';
                $t_message = 't_pinned';
                $_category = '*';
            } elseif (in_array($_category, ['item_title', 'item_comment'])) {
                $t_source = 't_source_dictionary_long';
                $t_message = 't_dictionary_long';
            } elseif ($_category == 'top10000') {
                $t_source = 't_source_sentences';
                $t_message = 't_sentences';
            } else {
                if (mb_strlen($_message, 'UTF-8') <= 32) {
                    $t_source = 't_source_dictionary';
                    $t_message = 't_dictionary';
                } else {
                    $t_source = 't_source_dictionary_long';
                    $t_message = 't_dictionary_long';
                }
            }
            $res = Yii::app()->db->createCommand(
              "select sd.id,sd.category from {$t_source} sd where
            (sd.category=:category or :category='*') and
            sd.language =:source and
            message_md5=md5(:message) LIMIT 1"
            )->queryRow(
              true,
              [
                ':category' => $_category,
                ':message'  => $_message,
                ':source'   => $_source,
              ]
            );
            if ($res) {
                $_message_id = $res['id'];
                $_translation_category = $res['category'];
                $_use_long = ($t_source == 't_source_dictionary_long' ? 'L' : 'S');
            }
            if ($_message_id) {
                $_translation = Yii::app()->db->createCommand(
                  "select dd.translation from {$t_message} dd where
            dd.id = :source_dictionary_id and dd.language = :language limit 1"
                )->queryScalar(
                  [
                    ':source_dictionary_id' => $_message_id,
                    ':language'             => $_language,
                  ]
                );
                if ($_translation && ($_category != 'top10000')) {
                    Yii::app()->db->createCommand(
                      "UPDATE {$t_message} dd
                          SET freq=freq+1
                       WHERE dd.id=:source_dictionary_id AND dd.language=:language LIMIT 1"
                    )
                      ->execute(
                        [
                          ':source_dictionary_id' => $_message_id,
                          ':language'             => $_language,
                        ]
                      );
                }
            }
        }
        if ($withId) {
            $result = new stdClass();
            $result->translation_category = $_translation_category;
            $result->message_id = $_message_id;
            $result->use_long = $_use_long;
            $result->translation = $_translation;
        } else {
            $result = $_translation;
        }
        return $result;
    }

    public function chineseSplit($message, $language, $delimiter = ' ', $translate = 0)
    {
        $res = $this->chineseSplitAsArray($message, $language, $delimiter, $translate);
        $result = '';
        foreach ($res as $val) {
            $result = trim(trim($result . $delimiter . $val->value), $delimiter);
        }
        return trim($result);
//==================================================
    }

    public function chineseSplitAsArray($message, $language, $translate = 0, $editable = false, $clear = false)
    {
//==================================================
        $result = [];
        $_message = preg_replace('/[' . self::$chineseStopChars . ']+/u', ' ', $message);
        $_message = preg_replace('/([' . self::$chineseDigits . ']+)/u', ' $1 ', $_message);
        $_message = preg_replace('/([' . self::$chineseStopWords . ']+)/u', ' $1', $_message);
        $_message = preg_replace('/(' . self::$chineseStopPhrase . ')/u', ' $1 ', $_message);
        $_message = preg_replace(
          '/([^\x3000-\x303F\x31C0-\x31EF\x3200-\x32FF\x3300-\x33FF\x3300-\x33FF\x4E00-\x9FFF\xFE30-\xFE4F]+)/u',
          ' $1 ',
          $_message
        );
        $_message = preg_replace('/(\d)\s+([\.\-]+)\s+(\d)/u', '$1$2$3', $_message);
        $res = preg_match_all('/(?:^|\s+)([^\s]+)/u', $_message, $parts);
        if (!$res) {
            $translationRes = new stdClass();
            $translationRes->value = $message;
            $translationRes->translated = false;
            $result[] = $translationRes;
            return $result;
        }
        foreach ($parts[1] as $part) {
            $translation = '';
            $translated = false;
            $clearPart = trim($part);
            if ($translate > 0) {
                if (preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $clearPart)) {
// is Chinese
                    $category = 'top10000';
                    $translation = $this->translateText(
                      $clearPart,
                      'zh',
                      $language,
                      $category,
                      false,
                      true,
                      true,
                      $editable,
                      $clear,
                      true
                    );
                    if ($translation) {
                        $clearPart = $translation;
                        $translated = true;
                    } else {
                        $category = 'default';
                        $translation = $this->translateText(
                          $clearPart,
                          'zh',
                          $language,
                          $category,
                          false,
                          true,
                          true,
                          $editable,
                          $clear,
                          true
                        );
                        if ($translation) {
                            $clearPart = $translation;
                            $translated = true;
                        }
                    }
                }
            }
            if ($clearPart) {
                $translationRes = new stdClass();
                $translationRes->value = $clearPart;
                $translationRes->translated = $translated;
                $result[] = $translationRes;
            }
        }
        return $result;
//==================================================
    }

    public function chineseSplitCount($message)
    {
        $_message = preg_replace('/[' . self::$chineseStopChars . ']+/u', ' ', $message);
        $_message = preg_replace('/([' . self::$chineseDigits . ']+)/u', ' $1 ', $_message);
        $_message = preg_replace('/([' . self::$chineseStopWords . ']+)/u', ' $1', $_message);
        $_message = preg_replace('/(' . self::$chineseStopPhrase . ')/u', ' $1 ', $_message);
        $_message = preg_replace(
          '/([^\x3000-\x303F\x31C0-\x31EF\x3200-\x32FF\x3300-\x33FF\x3300-\x33FF\x4E00-\x9FFF\xFE30-\xFE4F]+)/u',
          ' $1 ',
          $_message
        );
        $_message = preg_replace('/(\d)\s+([\.\-]+)\s+(\d)/u', '$1$2$3', $_message);
        $res = preg_match_all('/(?:^|\s+)([^\s]+)/u', $_message, $parts);
        if (!$res) {
            return 0;
        } else {
            return $res;
        }
    }

    public function chineseSplitNeeded($message)
    {
        $res = preg_match(
          '/(?:[' .
          self::$chineseStopChars .
          self::$chineseStopWords .
          self::$chineseDigits .
          ']+)|(?:' .
          self::$chineseStopPhrase .
          ')/u',
          $message
        );
        if (!$res) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteFromMemCache($source, $from, $to, $category)
    {
        if (!isset(Yii::app()->memCache)) {
            return;
        }
        $_categories = [
          $category,
          'default',
          '*',
          'prop',
          'propval',
          'item_title',
          'item_comment',
          'category',
          'top10000',
        ];
        $_from = $this->normalizeLanguage($from);
        $_to = $this->normalizeLanguage($to);
        $cacheTag = 'translateMessage-' . $_from . '->' . $_to . '-' . $source;
        Yii::app()->memCache->delete($cacheTag);
        for ($editable = 0; $editable <= 1; $editable++) {
            $cacheTag = 'translateQuery-' . $_from . '->' . $_to . '-' . ($editable ? 'true' : 'false') . '-' . $source;
            Yii::app()->memCache->delete($cacheTag);
            for ($strong = 0; $strong <= 1; $strong++) {
                for ($intOnly = 0; $intOnly <= 1; $intOnly++) {
                    $cacheTag =
                      'translateLocal-' .
                      $_from .
                      '->' .
                      $_to .
                      '-' .
                      ($strong ? 'true' : 'false') .
                      '-' .
                      ($intOnly ? 'true' : 'false') .
                      '-' .
                      $source;
                    Yii::app()->memCache->delete($cacheTag);
                    $cacheTag =
                      'translatePinned-' .
                      $_from .
                      '->' .
                      $_to .
                      '-' .
                      ($strong ? 'true' : 'false') .
                      '-' .
                      ($intOnly ? 'true' : 'false') .
                      '-' .
                      $source;
                    Yii::app()->memCache->delete($cacheTag);
                    for ($extOutput = 0; $extOutput <= 1; $extOutput++) {
                        for ($clear = 0; $clear <= 1; $clear++) {
                            for ($returnFalse = 0; $returnFalse <= 1; $returnFalse++) {
                                foreach ($_categories as $_category) {
                                    $cacheTag =
                                      'translateText-' .
                                      $_from .
                                      '->' .
                                      $_to .
                                      '-' .
                                      $_category .
                                      '-' .
                                      ($strong ? 'true' : 'false') .
                                      '-' .
                                      ($intOnly ? 'true' : 'false') .
                                      '-' .
                                      ($extOutput ? 'true' : 'false') .
                                      '-' .
                                      ($editable ? 'true' : 'false') .
                                      '-' .
                                      ($clear ? 'true' : 'false') .
                                      '-' .
                                      ($returnFalse ? 'true' : 'false') .
                                      '-' .
                                      $source;
                                    Yii::app()->memCache->delete($cacheTag);
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function forceClearResult($translation)
    {
        if (DSConfig::getVal('translator_block_mode_enabled') == 1) {
            $res = preg_replace('/(editable\s*=\s*(?:"|&quot;)[01](?:"|&quot;))/is', '$1 clear="1"', $translation);
        } else {
            $res = $translation;
        }
        return $res;
    }

    public function getTranslation($category, $id, $mode, $language)
    {
        $result = new stdClass();
        $result->message = '';
        $result->translation = '';
        $result->category = $category;
        $result->id = $id;
        $result->mode = $mode;
        $result->from = 'zh';
        $result->to = $this->normalizeLanguage($language);
        if ($result->category == 'category') {
            $t_source = 't_source_category';
            $t_message = 't_category';
        } elseif (in_array($result->category, ['item_title', 'item_comment'])) {
            $t_source = 't_source_dictionary_long';
            $t_message = 't_dictionary_long';
        } elseif ($result->category == 'top10000') {
            $t_source = 't_source_sentences';
            $t_message = 't_sentences';
        } else {
            if ($result->mode == 'S') {
                $t_source = 't_source_dictionary';
                $t_message = 't_dictionary';
            } else {
                $t_source = 't_source_dictionary_long';
                $t_message = 't_dictionary_long';
            }
        }
        $sourceDataRec = Yii::app()->db->createCommand(
          "select sd.message,sd.language from {$t_source} sd where
            (sd.category=:category or :category='*') and
            sd.id =:id LIMIT 1"
        )->queryRow(
          true,
          [
            ':category' => $result->category,
            ':id'       => $result->id,
          ]
        );
        if ($sourceDataRec) {
            $result->message = $sourceDataRec['message'];
            $result->from = $sourceDataRec['language'];
        }

        $translationDataRec = Yii::app()->db->createCommand(
          "select sd.translation from {$t_message} sd where
            sd.id =:id and sd.language=:language LIMIT 1"
        )->queryRow(
          true,
          [
            ':language' => $result->to,
            ':id'       => $result->id,
          ]
        );
        if ($translationDataRec) {
            $result->translation = $translationDataRec['translation'];
        }

        return $result;
    }

    public function init()
    {
        if (class_exists('DSConfig', false)) {
            $this->translator_block_mode_enabled = DSConfig::getVal('translator_block_mode_enabled') == 1;
        }
        if (class_exists('DSConfig', false)) {
            $this->editableByRole = Yii::app()->user->checkAccess('site/translate');
        }

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

    public function markupTranslation(
      $query,
      $from,
      $to,
      $translatedText,
      $translationType,
      $id,
      $useLong,
      $editable = false,
      $clear = false,
      $extAttributes = []
    ) {
        /*        if ((DSConfig::getVal('translator_block_mode_enabled') == 1) && TRUE) {
                    return $query;
                }*/
        //==============================================================
        if (substr($from, 0, 2) == substr($to, 0, 2)) {
            return $query;
        }
        if (class_exists('DSConfig', false)) {
            $this->translator_edit_url = DSConfig::getVal('translator_edit_url');
        }
        if (preg_match('/[<>]+|span/is', $translatedText) > 0) {
            $res = $this->removeOnlineTranslation($translatedText);
        } else {
            $res = $translatedText;
        }
        $translated = ($this->_success) ? '1' : '0';
        if ($this->editableByRole || $editable) {
            $title = htmlentities(
              $translationType . '[' . $id . ']' . '[' . $useLong . ']' . ': ' . $query,
              ENT_QUOTES,
              'UTF-8'
            );
            $translateAttributes = [
              'onclick' => 'editTranslation(event,this.parentNode,\'' .
                $translationType .
                '\',\'' .
                $id .
                '\',\'' .
                $useLong .
                '\'); stopPropagation(event); return false;',
            ];
            $attribures = [
              'editable'   => 1,
              'translated' => $translated,
              'url'        => $this->translator_edit_url,
              'type'       => $translationType,
              'from'       => self::normalizeLanguage($from),
              'to'         => self::normalizeLanguage($to),
              'id'         => $translationType . $id . $useLong,
              'title'      => $title,
            ];
        } else {
            $title = htmlentities($query, ENT_QUOTES, 'UTF-8');
            $attribures = [
              'editable'   => 0,
              'translated' => $translated,
              'type'       => $translationType,
              'from'       => self::normalizeLanguage($from),
              'to'         => self::normalizeLanguage($to),
              'id'         => $translationType . $id . $useLong,
              'title'      => $title,
            ];
        }
        if ($extAttributes && is_array($extAttributes)) {
            $attribures = array_merge($attribures, $extAttributes);
        }
        if (isset($translateAttributes)) {
            $translate = '<translate ' . $this->attributesToString(
                $translateAttributes
              ) . '><i class="fa fa-pencil"></i></translate>';
        } else {
            $translate = '';
        }
        if ($clear && $translated) {
            return $res;
        } else {
            $res = '<translation' . $this->attributesToString($attribures) . '>' . $res . $translate . '</translation>';
            $res = preg_replace("/[\r\n]+/", ' ', $res);
            return $res;
        }
        //==============================================================
    }

    public function removeOnlineTranslation($s)
    {
        $res = preg_replace(
          '/<translation.*?>(.*?)(?:<translate.*?>.*?<\/translate>)*<\/translation>/is',
          '$1',
          $s
        );
        $res = preg_replace('/\<span.*\>(.*)\<\/span\>/is', '$1', $res);
        $res = trim($res);
        return $res;
    }

    public function setTranslation($source, $translation, $from, $to, $category, $id, $mode, $global, $uid, $host)
    {
        $categories = explode(',', $category);
        foreach ($categories as $category) {
            if (!$category) {
                continue;
            }
            $delete = $category[0] === '-';
            $category = ltrim($category, '+-');
            if ($category == 'category') {
                $table_name = 't_source_category';
                $t_translation = 't_category';
            } elseif (in_array($category, ['item_title', 'item_comment'])) {
                $table_name = 't_source_dictionary_long';
                $t_translation = 't_dictionary_long';
            } elseif ($category == 'top10000') {
                $table_name = 't_source_sentences';
                $t_translation = 't_sentences';
            } elseif ($category == 'pinned') {
                $table_name = 't_source_pinned';
                $t_translation = 't_pinned';
            } else {
                if ($mode == 'S') {
                    $table_name = 't_source_dictionary';
                    $t_translation = 't_dictionary';
                } else {
                    $table_name = 't_source_dictionary_long';
                    $t_translation = 't_source_dictionary_long';
                }
            }
//=======================================================================
            Yii::app()->db->createCommand(
              "
        INSERT INTO log_translations(table_name,message_id,host,uid,\"date\",message,translation,\"from\",\"to\")
        VALUES (:table_name,:message_id,:host,:uid,Now(),:message,:translation,:from,:to)
        "
            )->execute(
              [
                ':table_name'  => $table_name,
                ':message_id'  => $id,
                ':host'        => $host,
                ':uid'         => $uid,
                ':message'     => $source,
                ':translation' => $translation,
                ':from'        => $from,
                ':to'          => $to,
              ]
            );
//=======================================================================
            if ($category == 'pinned') {
                $pinnedAllowed = Yii::app()->db->cache(3600)
                  ->createCommand(
                    "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 't_source_pinned'"
                  )
                  ->queryRow();
                if ($pinnedAllowed) {
                    $source_dictionary_id_command = Yii::app()->db->createCommand(
                      "SELECT sd.id FROM t_source_pinned sd WHERE
       (sd.category=:in_category) AND sd.language =:in_source AND message_md5=md5(:in_message) LIMIT 1"
                    );
                    $source_dictionary_id = $source_dictionary_id_command->queryScalar(
                      [
                        ':in_category' => $category,
                        ':in_source'   => $from,
                        ':in_message'  => $source,
                      ]
                    );

                    if ($delete) {
                        if ($source_dictionary_id) {
                            $result = Yii::app()->db->createCommand(
                              "DELETE FROM t_pinned WHERE id=:id"
                            )->execute(
                              [
                                ':id' => $source_dictionary_id,
                              ]
                            );
                            $result = Yii::app()->db->createCommand(
                              "DELETE FROM t_source_pinned 
                                WHERE (category=:in_category) AND language =:in_source AND message_md5=md5(:in_message)"
                            )->execute(
                              [
                                ':in_category' => $category,
                                ':in_source'   => $from,
                                ':in_message'  => $source,

                              ]
                            );
                        }
                    } else {
                        if (!$source_dictionary_id) {
                            $result = Yii::app()->db->createCommand(
                              "INSERT INTO t_source_pinned (language, category, message, message_md5)
              VALUES(:in_source,:in_category,:in_message,md5(:in_message))
              ON CONFLICT ON CONSTRAINT t_source_pinned_constr 
                            DO NOTHING"
                            )->execute(
                              [
                                ':in_category' => $category,
                                ':in_source'   => $from,
                                ':in_message'  => $source,
                              ]
                            );
                            $source_dictionary_id = $source_dictionary_id_command->queryScalar(
                              [
                                ':in_category' => $category,
                                ':in_source'   => $from,
                                ':in_message'  => $source,
                              ]
                            );
                            if (!$source_dictionary_id) {
                                continue;
                            }
                        }
                        if ($source_dictionary_id) {
                            $result = Yii::app()->db->createCommand(
                              "INSERT INTO t_pinned (id,language,translation,freq,status)
                                          VALUES(:id,:language,:translation,1,0)
                                          ON CONFLICT ON CONSTRAINT t_pinned_constr
                                              DO UPDATE SET
                                          translation=:translation, freq=freq+1"
                            )->execute(
                              [
                                ':id'          => $source_dictionary_id,
                                ':language'    => $to,
                                ':translation' => $translation,
                              ]
                            );
                        }
                    }
                }
                continue;
            }
//=======================================================================
            Yii::app()->db->createCommand(
              "
        update {$t_translation}
                set status=1,
                translation=:translation
                where id=:id and language = :to LIMIT 1
        "
            )->execute(
              [
                ':translation' => $translation,
                ':id'          => $id,
                ':to'          => $to,
              ]
            );
            if ($global || ($category == 'top10000')) {
                $records = Yii::app()->db->createCommand(
                  "SELECT sd.id FROM t_source_dictionary sd
                WHERE sd.message_md5=md5(:source) AND sd.language=:from"
                )->queryAll(
                  true,
                  [
                    ':from'   => $from,
                    ':source' => $source,
                  ]
                );
                if ($records) {
                    foreach ($records as $record) {
                        Yii::app()->db->createCommand(
                          "
         UPDATE t_dictionary dd
         SET status=1, translation=:translation
                WHERE dd.language = :to AND dd.id = :id
         "
                        )->execute(
                          [
                            ':translation' => $translation,
                            ':to'          => $to,
                            ':id'          => $record['id'],
                          ]
                        );
                    }
                }
//->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true)
                $records = Yii::app()->db->createCommand(
                  "SELECT sd.id FROM t_source_dictionary_long sd
                WHERE sd.message_md5=md5(:source) AND sd.language=:from"
                )->queryAll(
                  true,
                  [
                    ':from'   => $from,
                    ':source' => $source,
                  ]
                );
                if ($records) {
                    foreach ($records as $record) {
                        Yii::app()->db->createCommand(
                          "
         UPDATE t_dictionary_long dd
         SET status=1, translation=:translation
                WHERE dd.language = :to AND dd.id = :id
         "
                        )->execute(
                          [
                            ':translation' => $translation,
                            ':to'          => $to,
                            ':id'          => $record['id'],
                          ]
                        );
                    }
                }
            }
            if (isset(Yii::app()->memCache)) {
                $this->deleteFromMemCache($source, $from, $to, $category);
            }
        }
        return;
    }

    public function translateArray(
      $queryArray,
      $fieldName,
      $subArray,
      $subArrayFieldName,
      $category,
      $from = 'zh-CN',
      $to = 'ru',
      $strong = false
    ) {
        //TODO: Здесь оборачиваются в переводы размеры типа XXL или 36sm, чего делать не надо! Пофиксить!
        // $category in parseCids, parseSuggestions, parseFilter, parseMultiFilter, parseQuery item_attributes prepareProps
        if (!$queryArray || (!is_array($queryArray) && !($queryArray instanceof ArrayAccess)) || !count(
            $queryArray
          )) //|| !$fieldName || !$subArray
        {
            return;
        }
//TODO: Здесь упрощено за кажущейся ненадобностью. Проверить потом.
        /*
                if ((!$queryArray || (!is_array($queryArray) && !($queryArray instanceof ArrayAccess)) || (count($queryArray) <= 0))
                  || (!$fieldName || (!isset(end($queryArray)->{$fieldName}))) || ($subArray && ((!isset(
                          end($queryArray)->{$subArray}
                      )) || (!is_array(end($queryArray)->{$subArray}
                      ) && !(end($queryArray)->{$subArray} instanceof ArrayAccess))))
                ) {
                    return;
                }
        */
        $wordArray = [];
//== Начали предварительный перевод и набивку массива для внешнего перевода =====
        foreach ($queryArray as $i => $queryRec) {
            if (!$subArray) {
                if (!$this->translator_block_mode_enabled || $this->callFromBlockMode) {
                    if ($category == 'remote') {
                        $res = $this->translateQuery((string) $queryRec->{$fieldName}, $from, $to);
                    } else {
                        $res = $this->translateText(
                          (string) $queryRec->{$fieldName},
                          $from,
                          $to,
                          $category,
                          $strong,
                          true
                        );
                    }
                } else {
                    $this->_success = false;
                }
                if ($this->_success) {
                    if (is_object($queryRec->{$fieldName})) {
                        $queryRec->{$fieldName}->translation = $res;
                        $queryRec->{$fieldName}->translationLang = $this->normalizeLanguage($to);
                        $queryRec->{$fieldName}->sourceLang = $this->normalizeLanguage($from);
                    } else {
                        $queryRec->{$fieldName} = $res;
                    }
                } else {
                    $wordArray[$i] = new stdClass();
                    $wordArray[$i]->{$from} = (string) $queryRec->{$fieldName};
                    $wordArray[$i]->{$to} = (string) $queryRec->{$fieldName};
                    $wordArray[$i]->tag = 'p';
                    $wordArray[$i]->from = $from;
                    $wordArray[$i]->to = $to;
                }
            } else {
                if (!$this->translator_block_mode_enabled || $this->callFromBlockMode) {
                    $res = $this->translateText((string) $queryRec->{$fieldName}, $from, $to, 'prop', $strong, true);
                } else {
                    $this->_success = false;
                }
                if ($this->_success) {
                    if (is_object($queryRec->{$fieldName})) {
                        $queryRec->{$fieldName}->translation = $res;
                        $queryRec->{$fieldName}->translationLang = $this->normalizeLanguage($to);
                        $queryRec->{$fieldName}->sourceLang = $this->normalizeLanguage($from);
                    } else {
                        $queryRec->{$fieldName} = $res;
                    }
                } else {
                    $wordArray[$i] = new stdClass();
                    $wordArray[$i]->{$from} = (string) $queryRec->{$fieldName};
                    $wordArray[$i]->{$to} = (string) $queryRec->{$fieldName};
                    $wordArray[$i]->tag = 'p';
                    $wordArray[$i]->from = $from;
                    $wordArray[$i]->to = $to;
                }
                //== Translate value ================================
                if (!isset($wordArray[$i])) {
                    $wordArray[$i] = new stdClass();
                }
                $wordArray[$i]->values = [];
                foreach ($queryRec->{$subArray} as $j => $value) {
                    $prop = 0;
                    if (isset($value->values_props)) {
                        $props = explode(':', (string) $value->values_props);
                        if (isset($props[0])) {
                            $prop = $props[0];
                        }
                    }
                    if (($prop != 20000) || true) {
                        if (!$this->translator_block_mode_enabled || $this->callFromBlockMode) {
                            $res = $this->translateText(
                              (string) $value->{$subArrayFieldName},
                              $from,
                              $to,
                              'propval',
                              $strong,
                              true
                            );
                        } else {
                            $this->_success = false;
                        }
                        if ($this->_success) {
                            if (is_object($value->{$subArrayFieldName})) {
                                $value->{$subArrayFieldName}->translation = $res;
                                $value->{$subArrayFieldName}->translationLang = $this->normalizeLanguage($to);
                                $value->{$subArrayFieldName}->sourceLang = $this->normalizeLanguage($from);
                            } else {
                                $value->{$subArrayFieldName} = $res;
                            }
                        } else {
                            $wordArray[$i]->values[$j] = new stdClass();
                            $wordArray[$i]->values[$j]->{$from} = (string) $value->{$subArrayFieldName};
                            $wordArray[$i]->values[$j]->{$to} = (string) $value->{$subArrayFieldName};
                            $wordArray[$i]->values[$j]->tag = 'p';
                            $wordArray[$i]->values[$j]->from = $from;
                            $wordArray[$i]->values[$j]->to = $to;
                        }
                    }
                }
            }
        }
//== Закончили предварительный перевод и набивку массива для внешнего перевода =====
        if (!$subArray) {
            if ((count($wordArray) > 0) && (!$this->translator_block_mode_enabled || $this->callFromBlockMode)) {
                $xmlQuery = '';
                foreach ($wordArray as $i => $word) {
                    if (isset($word->tag)) {
                        $xmlQuery =
                          $xmlQuery . '<' . $word->tag . '>' . (string) $word->{$from} . '</' . $word->tag . '>';
                    }
                }
                $translatedQuery = Yii::app()->ExternalTranslator->translateText(
                  $xmlQuery,
                  $from,
                  $to,
                  $category,
                  false,
                  true
                );
                $res = preg_match_all('/<\s*[p]\s*>(.*?)<\s*\/\s*[p]\s*>/i', $translatedQuery, $translatedQueries);
                $j = 0;
                if ($res > 0) {
                    foreach ($wordArray as $i => $word) {
                        if (isset($translatedQueries[1][$j])) {
                            $wordArray[$i]->{$to} = $translatedQueries[1][$j];
                        }
                        $j = $j + 1;
                    }
                }
            }
//===================
            foreach ($wordArray as $i => $word) {
                if ((isset($wordArray[$i])) && (isset($wordArray[$i]->{$to}))) {
                    $query = (string) $wordArray[$i]->{$from};
                    $sourceData = $this->sourceDataFromDB($query, $from, $category);
                    $r = $this->markupTranslation(
                      $query,
                      $from,
                      $to,
                      (string) $wordArray[$i]->{$to},
                      $sourceData->category,
                      $sourceData->message_id,
                      $sourceData->use_long,
                      $this->editableByRole
                    );
                    if (is_object($queryArray[$i]->{$fieldName})) {
                        $queryArray[$i]->{$fieldName}->translation = $r;
                        $queryArray[$i]->{$fieldName}->translationLang = $this->normalizeLanguage($to);
                        $queryArray[$i]->{$fieldName}->sourceLang = $this->normalizeLanguage($from);
                    } else {
                        $queryArray[$i]->{$fieldName} = $r;
                    }
//++++++++++++++++++++++++++++++++++++
                }
            }
        } else {
            if ((count($wordArray) > 0) && (!$this->translator_block_mode_enabled || $this->callFromBlockMode)) {
                $xmlQuery = '';
                $xmlQueryForValues = '';
                foreach ($wordArray as $i => $word) {
                    if (isset($word->tag)) {
                        $xmlQuery =
                          $xmlQuery . '<' . $word->tag . '>' . (string) $word->{$from} . '</' . $word->tag . '>';
                    }
                    if (isset($word->values)) {
                        foreach ($word->values as $wordValue) {
                            if (isset($wordValue->tag)) {
                                $xmlQueryForValues =
                                  $xmlQueryForValues .
                                  '<' .
                                  $wordValue->tag .
                                  '>' .
                                  (string) $wordValue->{$from} .
                                  '</' .
                                  $wordValue->tag .
                                  '>';
                            }
                        }
                    }
                }
                if ($xmlQuery || $xmlQueryForValues) {
                    if ($xmlQuery) {
                        $translatedQuery = Yii::app()->ExternalTranslator->translateText(
                          $xmlQuery,
                          $from,
                          $to,
                          'prop',
                          false,
                          true
                        );
                        $res = preg_match_all(
                          '/<\s*[p]\s*>(.*?)<\s*\/\s*[p]\s*>/i',
                          $translatedQuery,
                          $translatedQueries
                        );
                    } else {
                        $res = 0;
                    }
                    if ($xmlQueryForValues) {
                        $translatedQueryForValues = Yii::app()->ExternalTranslator->translateText(
                          $xmlQueryForValues,
                          $from,
                          $to,
                          'propval',
                          false,
                          true
                        );
                        $resForValues = preg_match_all(
                          '/<\s*[p]\s*>(.*?)<\s*\/\s*[p]\s*>/i',
                          $translatedQueryForValues,
                          $translatedQueriesForValues
                        );
                    } else {
                        $resForValues = 0;
                    }
//echo $xmlQuery;
                    if ($res > 0) {
                        $m = 0;
                        foreach ($wordArray as $i => $word) {
                            if (isset($word->{$to})) {
                                if (isset($translatedQueries[1][$m])) {
                                    $wordArray[$i]->{$to} = $translatedQueries[1][$m];
                                }
                                $m = $m + 1;
                            }
                        }
                    }

                    if ($resForValues > 0) {
                        $j = 0;
                        foreach ($wordArray as $i => $word) {
                            if (isset($word->values)) {
                                foreach ($word->values as $k => $value) {
                                    if (isset($value->{$to})) {
                                        if (isset($translatedQueriesForValues[1][$j])) {
                                            $wordArray[$i]->values[$k]->{$to} = $translatedQueriesForValues[1][$j];
                                        }
                                        $j = $j + 1;
                                    }
                                }
                            }
                        }
                    }
                }
            }
//===================
            foreach ($wordArray as $i => $word) {
                if ((isset($wordArray[$i])) && (isset($wordArray[$i]->{$to}))) {
//+++++ New word +++++++++++++++++++++
                    $query = (string) $wordArray[$i]->{$from};
                    $sourceData = $this->sourceDataFromDB($query, $from, 'prop');
                    $r = $this->markupTranslation(
                      $query,
                      $from,
                      $to,
                      (string) $wordArray[$i]->{$to},
                      $sourceData->category,
                      $sourceData->message_id,
                      $sourceData->use_long,
                      $this->editableByRole
                    );
                    if (is_object($queryArray[$i]->{$fieldName})) {
                        $queryArray[$i]->{$fieldName}->translation = $r;
                        $queryArray[$i]->{$fieldName}->translationLang = $this->normalizeLanguage($to);
                        $queryArray[$i]->{$fieldName}->sourceLang = $this->normalizeLanguage($from);
                    } else {
                        $queryArray[$i]->{$fieldName} = $r;
                    }
//++++++++++++++++++++++++++++++++++++
                }
                if (isset($word->values)) {
                    foreach ($word->values as $k => $value) {
                        if ((isset($value)) && (isset($value->{$to}))) {
//+++++ New word +++++++++++++++++++++
                            $query = (string) $value->{$from};
                            $sourceData = $this->sourceDataFromDB($query, $from, 'propval');
                            $r = $this->markupTranslation(
                              $query,
                              $from,
                              $to,
                              (string) $value->{$to},
                              $sourceData->category,
                              $sourceData->message_id,
                              $sourceData->use_long,
                              $this->editableByRole
                            );
                            if (is_object($queryArray[$i]->{$subArray}[$k]->{$subArrayFieldName})) {
                                $queryArray[$i]->{$subArray}[$k]->{$subArrayFieldName}->translation = $r;
                                $queryArray[$i]->{$subArray}[$k]->{$subArrayFieldName}->translationLang =
                                  $this->normalizeLanguage(
                                    $to
                                  );
                                $queryArray[$i]->{$subArray}[$k]->{$subArrayFieldName}->sourceLang =
                                  $this->normalizeLanguage(
                                    $from
                                  );
                            } else {
                                $queryArray[$i]->{$subArray}[$k]->{$subArrayFieldName} = $r;
                            }
//++++++++++++++++++++++++++++++++++++
                        }
                    }
                }
            }
        }
    }

    public function translateBlock($translations)
    {
        $this->DSGLog = [];
        $this->DSGLog[':from_ip'] = Utils::getRemoteIp();
        $this->DSGLog[':from_host'] = Utils::getRemoteHostEx($this->DSGLog[':from_ip']);
        $this->DSGLog[':date'] = date('Y-m-d H:i:s');
        $this->DSGLog[':duration'] = microtime(true);
        $this->DSGLog[':remote'] = 0;
        $this->DSGLog[':local'] = 0;

        $this->callFromBlockMode = true;
        $result = $translations;
        $translationArray = [];
        if (is_array($translations)) {
            foreach ($translations as $i => $translation) {
                $attributes = $this->getAttributes(html_entity_decode($translation[0], ENT_COMPAT, 'UTF-8'));
                if (!$attributes) {
                    continue;
                }
                $res = preg_match(
                  '/<translation.*?>(.*?)(?:<translate.*?\>.*?<\/translate\>)*<\/translation>/isu',
                  html_entity_decode($translation[0], ENT_COMPAT, 'UTF-8'),
                  $texts
                );
                if (!$res) {
                    continue;
                }
                $editable = isset($attributes['editable']) && ($attributes['editable'] == 1);
                $clear = isset($attributes['clear']) && ($attributes['clear'] == 1);
                $text = $texts[1];
//--------------------------
                if (((isset($attributes['type']) && (!in_array(
                      $attributes['type'],
                      ['top10000']
                    ))) && (in_array(
                    $attributes['from'],
                    ['zh', 'zh-CHS', 'zh-CN']
                  )) && ($this->chineseSplitNeeded($text) || (isset($attributes['type']) && (in_array(
                        $attributes['type'],
                        ['item_title', 'item_comment']
                      )))))
                ) {
                    $splitArray = $this->chineseSplitAsArray($text, $attributes['to'], 1, $editable, $clear);
                    $resArray = [];
                    foreach ($splitArray as $val) {
                        if ($val->translated) {
                            $resArray[] = $val->value;
                        } else {
                            $resArray[] = $this->translateText(
                              $val->value,
                              $attributes['from'],
                              $attributes['to'],
                              '*',
                              false, //strong
                              false, //intOnly
                              true, //extOutput
                              $editable, //editable
                              $clear //clear
                            );
                        }
                    }
                    $textTranslated = implode(' ', $resArray);
                    $this->_collectLexic(
                      $text,
                      $resArray,
                      $attributes['from'],
                      $attributes['to'],
                      $attributes['type'],
                      $attributes
                    );
                } else {
//--------------------------
                    if (isset($attributes['type'])) {
                        $textTranslated = $this->translateText(
                          $text,
                          $attributes['from'],
                          $attributes['to'],
                          $attributes['type'],
                          false,
                          false,
                          true,
                          $editable,
                          $clear
                        );
                    } else {
                        $textTranslated = $this->translateText(
                          $text,
                          $attributes['from'],
                          $attributes['to'],
                          '*',
                          false,
                          false,
                          true,
                          $editable,
                          $clear
                        );
                    }
                }
//--------------------------
                $result[$i][1] = $textTranslated;
            }
            $this->DSGLog[':duration'] = round(microtime(true) - $this->DSGLog[':duration'], 3);
            try {
                if (Yii::app()->db->cache(3600)
                  ->createCommand(
                    "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 'log_dsg_translator_buffer'"
                  )
                  ->queryRow()
                ) {
                    Yii::app()->db->createCommand(
                      "INSERT INTO log_dsg_translator_buffer (\"date\",\"duration\",
                  \"remote\",\"local\",\"from_host\",\"from_ip\")
                  VALUES (:date,:duration,:remote,:local,:from_host,:from_ip)"
                    )->execute($this->DSGLog);
                    $cnt = Yii::app()->db->createCommand("SELECT count(0) FROM log_dsg_translator_buffer")
                      ->queryScalar();
                    if ($cnt > 1000) {
                        Yii::app()->db->createCommand(
                          "INSERT INTO log_dsg_translator (\"date\",\"duration\",
                  \"remote\",\"local\",\"from_host\",\"from_ip\")
                  SELECT \"date\",\"duration\",
                  \"remote\",\"local\",\"from_host\",\"from_ip\" FROM
                  log_dsg_translator_buffer;
                  TRUNCATE TABLE log_dsg_translator_buffer;"
                        )->execute();
                    }
                } else {
                    Yii::app()->db->createCommand(
                      "INSERT INTO log_dsg_translator (\"date\",\"duration\",
                  \"remote\",\"local\",\"from_host\",\"from_ip\")
                  VALUES (:date,:duration,:remote,:local,:from_host,:from_ip)"
                    )->execute($this->DSGLog);
                }
            } catch (Exception $e) {
                $this->callFromBlockMode = false;
                return $result;
            }
        }
        $this->callFromBlockMode = false;
        return $result;
    }

    public function translateCategory($query, $from, $to, $quick = false, $remote = false)
    {
        $_from = $this->normalizeLanguage($from);
        $_to = $this->normalizeLanguage($to);

        if (substr($_from, 0, 2) == substr($_to, 0, 2)) {
            return $query;
        }
        if (!$query) {
            return $query;
        }
        $_query = $this->normalizeText($query);
        if ($_query == '' || $_to == '' || $_from == '') {
            return false;
        }
        if ($quick) {
            $res = $this->translateLocal($_query, $_from, $_to, 'category', false, false);
            $this->_success = true;
            $this->_translatedText = $res;
            return $this->_translatedText;
        } else {
            $translationWay = $_from . '-' . $_to;

            if (!isset($this->_categoryTranslations[$translationWay])) {
                $cacheTag = 'translateCategory-' . $this->normalizeLanguage($_from) . '->' . $this->normalizeLanguage(
                    $_to
                  );
                $cache = false;
                if (isset(Yii::app()->memCache)) {
                    $cache = @Yii::app()->memCache->get($cacheTag);
                } else {
                    $cache = @Yii::app()->cache->get($cacheTag);
                }
                if ($cache !== false) {
                    $this->_categoryTranslations[$translationWay] = $cache;
                } else {

                    $translationWayArray = [];
                    $recs = Yii::app()->db->createCommand(
                      "SELECT message_md5, cc.translation FROM t_source_category sc, t_category cc
                     WHERE sc.id = cc.id AND sc.language=:from AND cc.language = :to"
                    )
                      ->query(
                        [
                          ':from' => $_from,
                          ':to'   => $_to,
                        ]
                      );
                    if ($recs) {
                        foreach ($recs as $rec) {
                            $translationWayArray[$rec['message_md5']] = $rec['translation'];
                        }
                    }
                    $this->_categoryTranslations[$translationWay] = $translationWayArray;
                    if (count($translationWayArray)) {
                        if (isset(Yii::app()->memCache)) {
                            @Yii::app()->memCache->set($cacheTag, $translationWayArray, $this->memCacheTtl);
                        } else {
                            @Yii::app()->cache->set($cacheTag, $translationWayArray, $this->memCacheTtl);
                        }
                    }

                }
            }
            if (!isset($this->_categoryTranslations[$translationWay][md5($_query)])) {
                $res = $this->translateLocal($_query, $_from, $_to, 'category', false, false);
                if ($res != $query) {
                    $this->_categoryTranslations[$translationWay][md5($_query)] = $res;
                    if (isset($cacheTag)) {
                        if (isset(Yii::app()->memCache)) {
                            Yii::app()->memCache->delete($cacheTag);
                        } else {
                            Yii::app()->cache->delete($cacheTag);
                        }
                    }
                } elseif ($remote) {
                    $res = Utils::getRemoteTranslationPlain(
                      $_query,
                      $_from,
                      $_to
                    );//
                    if ($res != $query) {
                        Yii::app()->db->createCommand(
                          "INSERT INTO t_source_category (message_md5,language,category,message)
                            VALUES(md5(:message),:language,'category',:message)
                            ON CONFLICT ON CONSTRAINT t_source_category_constr 
                     DO NOTHING"
                        )->execute(
                          [
                            ':message'  => $_query,
                            ':language' => substr($_from, 0, 2),
                          ]
                        );
                        $recId = Yii::app()->db->createCommand(
                          "SELECT id FROM t_source_category
                            WHERE message_md5=md5(:message) AND language=:language AND category='category'"
                        )->queryScalar(
                          [
                            ':message'  => $_query,
                            ':language' => substr($_from, 0, 2),
                          ]
                        );
                        Yii::app()->db->createCommand(
                          "INSERT INTO t_category (id,language,freq,status,translation)
                            VALUES(:id,:language,1,0,:translation)
                            ON CONFLICT ON CONSTRAINT t_category_constr 
                            DO NOTHING"
                        )->execute(
                          [
                            ':id'          => $recId,
                            ':language'    => substr($_to, 0, 2),
                            ':translation' => $res,

                          ]
                        );
                        $this->_categoryTranslations[$translationWay][md5($_query)] = $res;
                        if (isset($cacheTag)) {
                            if (isset(Yii::app()->memCache)) {
                                Yii::app()->memCache->delete($cacheTag);
                            } else {
                                Yii::app()->cache->delete($cacheTag);
                            }
                        }
                    }
                }
            }
            $res = $_query;

            try {
                $this->_success = false;
                if (isset($this->_categoryTranslations[$translationWay][md5($_query)])) {
                    $res = $this->_categoryTranslations[$translationWay][md5($_query)];
                    $this->_success = true;
                }
                $this->_translatedText = $res;
                return $this->_translatedText;
            } catch (Exception $e) {
                $this->_translatedText = $query;
                $this->_success = false;
                return $this->_translatedText;
            }
        }
    }

    public function translateHtml($html, $from, $to)
    {
        //(?is)(?<=(?:>|^))([^<>]+?)(?=(?:<|$))
        if ($from == $to || !$html) {
            return $html;
        }
        $callback = function ($matches) use ($from, $to) {
            /*            $editableByRole=Yii::app()->DVTranslator->editableByRole;
                        Yii::app()->DVTranslator->editableByRole=false;
                        $translation = Yii::app()->DVTranslator->markupTranslation($matches[2],$from,$to,$matches[2],'*',0,true,false,true,array());
            */
            $preSpaces = '';
            $postSpaces = '';
            if (preg_match('/^([\s\.,]*).*/s', $matches[2], $preMatches)) {
                $preSpaces = $preMatches[1];
            }
            if (preg_match('/.*?(\s*)$/s', $matches[2], $postMatches)) {
                $postSpaces = $postMatches[1];
            }
            $source = html_entity_decode($matches[2], ENT_COMPAT | ENT_IGNORE, 'UTF-8');
            $translation = Yii::t('cms', $source, [], null, $to);
            //$translation = html_entity_decode($translation,ENT_COMPAT | ENT_IGNORE, 'UTF-8');
            /*            Yii::app()->DVTranslator->editableByRole=$editableByRole;
            */
            return $matches[1] . $preSpaces . $translation . $postSpaces . $matches[3];
        };

        $html = preg_replace_callback('/(>|^)([^<>]+?)(<|$)/is', $callback, $html);
        return $html;
    }

    public function translateHtmlProperty($text, $from, $to)
    {
        //return $text;
        //(?is)(?<=(?:>|^))([^<>]+?)(?=(?:<|$))
        if ($from == $to || !$text) {
            return $text;
        }
        $source = html_entity_decode($text, ENT_COMPAT | ENT_IGNORE, 'UTF-8');
        $translation = $this->translateText(
          $text,
          $from,
          $to,
          'item_title',
          false, //strong
          false, //intOnly
          true, //extOutput
          false //editable
        /*          true//clear
                   false,//returnFalse
                  false  //extParams
        */
        );
        $res = $this->forceClearResult($translation);
        return $res;
    }

    public function translateLocal(
      $query = '',
      $from = 'zh-CN',
      $to = 'ru',
      $category = '*',
      $strong = false,
      $intOnly = true
    ) {
        $error = false;
        if (substr($from, 0, 2) == substr($to, 0, 2)) {
            return $query;
        }
        if (!$query) {
            return $query;
        }
        $_query = $this->normalizeText($query);
        if ($_query == '' || $to == '' || $from == '') {
            return false;
        }

        $cacheTag = 'translateLocal-' . $this->normalizeLanguage($from) . '->' . $this->normalizeLanguage(
            $to
          ) . '-' . ($strong ? 'true' : 'false') . '-' . ($intOnly ? 'true' : 'false') . '-' . $_query;
        $cache = false;
        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get($cacheTag);
        }
        if ($cache !== false) {
            $this->_success = true;
            return $cache;
        }
        $rowID = 0;
        $res = '';
        try {
            $this->_success = false;
            if (in_array($from, ['zh-CHS', 'zh-CN', 'zh'])) {
                if (!preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $_query)) {
                    $res = $_query;
                }
            } elseif ($from == 'ru') {
                if (!preg_match("/[а-яА-Я]{1}/iu", $_query)) {
                    $res = $_query;
                }
            } elseif ($from == 'en') {
                if (!preg_match("/[a-zA-Z]{1}/iu", $_query)) {
                    $res = $_query;
                }
            }
            if ($res) {
                $this->_translatedText = $res;
                $this->_success = true;
                return $this->_translatedText;
            }
            if (!$res) {
                try {
                    $translation = $this->translateFromDB($_query, $from, $to, $category);
                    if ($translation->message_id && $translation->translation) {
                        $res = $translation->translation;
                    }
                    if (isset($translation) && $translation->message_id) {
                        $rowID = $translation->message_id;
                    } else {
                        $rowID = 0;
                    }
                } catch (Exception $e) {
                    $rowID = 0;
                    $res = ''; //.$query;
                    $error = true;
                }
            }
            if (((strlen($res) == 0 || !$res || ($res == null))) && !$error && !$intOnly) { // && (!$intOnly)
                $res = Yii::app()->ExternalTranslator->translateText($_query, $from, $to, $category);
                $translation = $this->translateFromDB($_query, $from, $to);
                $lastRecID = $translation->message_id;
                if ($lastRecID > 0) {
                    $rowID = $lastRecID;
                }
            }
            if (!$res) {
                $this->_translatedText = $_query;
                $this->_success = false;
                return $this->_translatedText;
            } else {
                $this->_translatedText = $res;
                $this->_success = true;
                $result = $this->_translatedText;
                if (isset(Yii::app()->memCache) && $result != $_query) {
                    @Yii::app()->memCache->set($cacheTag, $result, $this->memCacheTtl);
                }
                return $result;
            }
        } catch (Exception $e) {
            $this->_translatedText = $query;
            $this->_success = false;
            return $this->_translatedText;
        }
    }

    public function translateMessage($message, $from, $to)
    {
        $cacheTag = 'translateMessage-' . $this->normalizeLanguage($from) . '->' . $this->normalizeLanguage(
            $to
          ) . '-' . $message;
        $cache = false;
        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get($cacheTag);
        }
        if ($cache !== false) {
            $this->_success = true;
            return $cache;
        }
        $res = '';
        try {
            $this->_success = false;
            $res = Yii::app()->ExternalTranslator->translateText(
              $message,
              $from,
              ($to == 'zh') ? 'zh-CHS' : $to
            ); //$ps[$j]
//===== finalBlock ======
            if (strlen($res) == 0 || !$res) {
                $this->_translatedText = '';
                $this->_success = false;
                return $this->_translatedText;
            } else {
                $this->_translatedText = $res;
                $this->_success = true;
                $result = $this->_translatedText;
                if (isset(Yii::app()->memCache) && $result != $message) {
                    @Yii::app()->memCache->set($cacheTag, $result, $this->memCacheTtl);
                }
                return $result;
            }
        } catch (Exception $e) {
            $this->_translatedText = '';
            $this->_success = false;
            return $this->_translatedText;
        }
    }

    public function translatePinnedArray(&$translations)
    {
        if ($translations and is_array($translations)) {
            foreach ($translations as $i => $translation) {
                if (!isset($translation[1])) {
                    return;
                }
                $rawTranslations = preg_split('/(?<=<\/translation>)\s*(?!$)/is', $translation[1]);
                if (!$rawTranslations) {
                    return;
                }
                foreach ($rawTranslations as $j => $rawTranslation) {
                    $attr = $this->getAttributes($rawTranslation);
                    if (!$attr || !count($attr)) {
                        continue;
                    }
                    if (!isset($attr['from']) || !isset($attr['to'])) {
                        continue;
                    }
                    if (preg_match(
                      '/<translation.*?title\s*=\s*".*?\[\d+\]\[.+\]\s*:\s*(.*?)"/isu',
                      $rawTranslation,
                      $matches
                    )) {
                        $query = $matches[1];
                    } else {
                        continue;
                    }
                    if (!$query) {
                        continue;
                    }

                    //query <translation.*?title\s*=\s*".*?\[\d+\]\[.+\]\s*:\s*(.*?)"
                    //query <translation.*?title\s*=\s*".*?\[\d+\]\[.+\]\s*:.*?"\s*>(.+?)<
                    /*
                  $query = '',
                  $from = 'zh-CN',
                  $to = 'ru',
                  $category = '*',
                  $strong = false,
                  $intOnly = true
<translation editable="1" translated="1" url="dsproxy.cart2b.com:8090/site/translate" type="default" from="zh" to="ru" id="default43663S" title="default[43663][S]: 通勤" >Регулярного пассажира пригородных поездов<translate  onclick="editTranslation(event,this.parentNode,'default','43663','S'); stopPropagation(event); return false;" ><span class="fa fa-pencil"></span></translate></translation>
                     */
                    $cacheTag = 'translatePinned-' . $this->normalizeLanguage(
                        $attr['from']
                      ) . '->' . $this->normalizeLanguage(
                        $attr['to']
                      ) . '-' . ((isset($attr['strong']) && $attr['strong']) ? 'true' : 'false') . '-'
                      . ((isset($attr['intOnly']) && $attr['intOnly']) ? 'true' : 'false') . '-' . $query;
                    $cache = false;
                    if (isset(Yii::app()->memCache)) {
                        $cache = @Yii::app()->memCache->get($cacheTag);
                    }
                    if ($cache !== false) {
                        $pinnedTranslation = $cache;
                    } else {
                        $pinnedTranslation = '';
                        try {
                            $this->_success = false;
                            if (in_array($attr['from'], ['zh-CHS', 'zh-CN', 'zh'])) {
                                if (!preg_match(
                                  "/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u",
                                  $query
                                )
                                ) {
                                    continue;
                                }
                            } elseif ($from == 'ru') {
                                if (!preg_match("/[а-яА-Я]{1}/iu", $_query)) {
                                    continue;
                                }
                            } elseif ($from == 'en') {
                                if (!preg_match("/[a-zA-Z]{1}/iu", $_query)) {
                                    continue;
                                }
                            }
                            try {
                                $translationFromDB = $this->translateFromDB(
                                  $query,
                                  $attr['from'],
                                  $attr['to'],
                                  'pinned'
                                );
                                if (isset($translationFromDB) &&
                                  $translationFromDB->message_id &&
                                  $translationFromDB->translation) {
                                    $pinnedTranslation = $translationFromDB->translation;
                                }
                            } catch (Exception $e) {
                                continue;
                            }
                            if (isset(Yii::app()->memCache)) {
                                @Yii::app()->memCache->set($cacheTag, $pinnedTranslation, $this->memCacheTtl);
                            }
                        } catch (Exception $e) {
                            continue;
                        }
                    }
                    if ($pinnedTranslation) {
                        $replacement = preg_replace(
                          '/(<translation.*?title\s*=\s*".*?\[\d+\]\[.+\]\s*:.*?"\s*>).+?(<.+)/isu',
                          '${1}' . preg_quote($pinnedTranslation) . '$2',
                          $rawTranslations[$j]
                        );
                        $replacement = preg_replace(
                          '/(<translation\s)(.+)/isu',
                          '${1}' . 'pinned="1" ' . '$2',
                          $replacement
                        );
                        $rawTranslations[$j] = $replacement;
                    }
                }
                $translations[$i][1] = implode(' ', $rawTranslations);
            }
        }
        return;
    }

    public function translateQuery($query = '', $from = 'zh-CN', $to = 'ru', $editable = false)
    {
        $error = false;
        $cacheTag = 'translateQuery-' . $this->normalizeLanguage($from) . '->' . $this->normalizeLanguage(
            $to
          ) . '-' . ($editable ? 'true' : 'false') . '-' . $query;
        $cache = false;
        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get($cacheTag);
        }
        if ($cache !== false) {
            $this->_success = true;
            return $cache;
        }
        $rowID = 0;
        $res = '';
        $preservedQuery = '';
        $useLong = '';
        try {
            $this->_success = false;
            if (in_array($from, ['zh-CHS', 'zh-CN', 'zh'])) {
                if (!preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $query)) {
                    $res = $query;
                }
            } elseif ($from == 'ru') {
                if (!preg_match("/[а-яА-Я]{1}/iu", $query)) {
                    $res = $query;
                }
            } elseif ($from == 'en') {
                if (!preg_match("/[a-zA-Z]{1}/iu", $query)) {
                    $res = $query;
                }
            }
            if ($query == '' || $to == '' || $from == '') {
                return false;
            }
            if (!$this->translator_block_mode_enabled || $this->callFromBlockMode) {
                // Сохраняем английские слова, такие, как названия брендов
                if (in_array($to, ['zh', 'zh-CHS', 'zh-CN']) && (!in_array($from, ['en']))) {
                    $words = preg_split('/\s/s', $query, -1, PREG_SPLIT_NO_EMPTY);
                    $query = '';
                    foreach ($words as $word) {
                        if (preg_match('/^[a-z0-9\-\(\)\%\$\#\@\!\.\*\+]+$/is', $word)) {
                            $preservedQuery = $preservedQuery . ' ' . $word;
                        } else {
                            $query = $query . ' ' . $word;
                        }
                    }
                }
                $_query = $this->normalizeText($query);
                $preservedQuery = trim($preservedQuery);
                if (!$res) {
                    try {
                        $translation = $this->translateFromDB($_query, $from, $to);
                        if (isset($translation->message_id) && $translation->message_id && $translation->translation) {
                            $res = $translation->translation;
                        }
                        if (isset($translation->use_long)) {
                            $useLong = $translation->use_long;
                        }

                        if (isset($translation) && $translation->message_id) {
                            $rowID = $translation->message_id;
                        } else {
                            $rowID = 0;
                        }
                    } catch (Exception $e) {
                        $rowID = 0;
                        $res = ''; //.$query;
                        $error = true;
                    }
                }
                if (((strlen($res) == 0 || !$res || ($res == null)))) {
                    $rowID = -60001;
                    $res = Yii::app()->ExternalTranslator->translateText($_query, $from, $to);
                    $translation = $this->translateFromDB($_query, $from, $to);
                    $lastRecID = $translation->message_id;
                    if ($lastRecID > 0) {
                        $rowID = $lastRecID;
                    }
                }
                if (!$res) {
                    $this->_translatedText = trim($_query . ' ' . $preservedQuery);
                    $this->_success = false;
                    return $this->_translatedText;
                } else {
                    $this->_translatedText = trim($res . ' ' . $preservedQuery);
                    $this->_success = true;
                    $result = $this->markupTranslation(
                      $_query,
                      $from,
                      $to,
                      $this->_translatedText,
                      'remote',
                      $rowID,
                      $useLong,
                      $editable || $this->editableByRole
                    );
                }
            } else {
                //============================== block mode - immediate remote translation ===================================
                $rowID = 0;
                $this->_success = false;
                $remoteQuery = [
                  [
                    0 => $this->markupTranslation(
                      $query,
                      $from,
                      $to,
                      $query,
                      'remote',
                      $rowID,
                      $useLong,
                      $editable || $this->editableByRole
                    ),
                  ],
                ];
                $res = Utils::getRemoteTranslation($remoteQuery);
// ==== end of post and get data to translator ====================
                if (($res->data) && ($res->info['http_code'] < 400)) {
                    $translations = unserialize($res->data);
                    if (isset($translations[0][1])) {
                        $result = $translations[0][1];
                    } else {
                        $result = $remoteQuery[0][0];
                    }
                } else {
                    $result = $remoteQuery[0][0];
                }
            }
            if (isset(Yii::app()->memCache) && $rowID && $result != $_query) {
                @Yii::app()->memCache->set($cacheTag, $result, $this->memCacheTtl);
            }
            return $result;
        } catch (Exception $e) {
            $this->_translatedText = $query;
            $this->_success = false;
            return $this->_translatedText;
        }
    }

    public function translateText(
      $query = '',
      $from = 'zh-CN',
      $to = 'ru',
      $category = '*',
      $strong = false,
      $intOnly = false,
      $extOutput = true,
      $editable = false,
      $clear = false,
      $returnFalse = false,
      $extParams = false
    ) {
        $_category = $category;
        if (substr($from, 0, 2) === substr($to, 0, 2)) {
            //$this->DSGLog[':local'] = $this->DSGLog[':local']; //strlen($query);
            return $query;
        }
        if (!$query) {
            //$this->DSGLog[':local'] = $this->DSGLog[':local'];//strlen($query);
            return $query;
        }
        $_query = $this->normalizeText($query);
        if ($_query == '' || $to == '' || $from == '') {
            //$this->DSGLog[':local'] = $this->DSGLog[':local'];//strlen($query);
            return false;
        }
        $cacheTag = 'translateText-' .
          $this->normalizeLanguage($from) .
          '->' .
          $this->normalizeLanguage(
            $to
          ) .
          '-' .
          $_category .
          '-' .
          ($strong ? 'true' : 'false') .
          '-' .
          ($intOnly ? 'true' : 'false') .
          '-' .
          ($extOutput ? 'true' : 'false') .
          '-' .
          ($editable ? 'true' : 'false') .
          '-' .
          ($clear ? 'true' : 'false') .
          '-' .
          ($returnFalse ? 'true' : 'false') .
          '-' .
          $_query;
        //Yii::log($cacheTag);
        $cache = false;
        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get($cacheTag);
        }
        if ($cache !== false) {
            $this->_success = true;
            if (isset($this->DSGLog[':local'])) {
                $this->DSGLog[':local'] = $this->DSGLog[':local'] + strlen($query);// strlen($query)+strlen($cache);
            } else {
                $this->DSGLog[':local'] = strlen($query);// strlen($query)+strlen($cache);
            }
            return $cache;
        }
        $rowID = 0;
        $res = '';
        $use_long = '';
        try {
            $this->_success = false;
            if (in_array($from, ['zh-CHS', 'zh-CN', 'zh'])) {
                if (!preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $_query)) {
                    $res = $_query;
                }
            } elseif ($from == 'ru') {
                if (!preg_match("/[а-яА-Я]{1}/iu", $_query)) {
                    $res = $_query;
                }
            } elseif ($from == 'en') {
                if (!preg_match("/[a-zA-Z]{1}/iu", $_query)) {
                    $res = $_query;
                }
            }
            if ($res) {
                $this->_translatedText = $res;
                $this->_success = true;
                if (isset($this->DSGLog[':local'])) {
                    $this->DSGLog[':local'] = $this->DSGLog[':local'] + strlen(
                        $query
                      );//strlen($query)+strlen($this->_translatedText);
                } else {
                    $this->DSGLog[':local'] = strlen(
                      $query
                    );//strlen($query)+strlen($this->_translatedText);
                }
                return $this->_translatedText;
            }
            if (!$this->translator_block_mode_enabled || $this->callFromBlockMode) {
                if (!$res) {
                    try {
                        $translation = $this->translateFromDB($_query, $from, $to, $_category);
                        if (isset($translation->message_id) && $translation->message_id) {
                            $rowID = $translation->message_id;
                        } else {
                            $rowID = 0;
                        }
                        if (isset($translation->translation) && $translation->translation) {
                            $res = $translation->translation;
                        }
                        if (isset($translation->use_long)) {
                            $use_long = $translation->use_long;
                        }
                        if (isset($translation->translation_category) &&
                          $translation->translation_category &&
                          ($translation->translation_category != '*')) {
                            $_category = $translation->translation_category;
                        }
                    } catch (Exception $e) {
                        $rowID = 0;
                        $res = ''; //.$query;
                    }
                }
                if (isset($this->DSGLog[':local'])) {
                    $this->DSGLog[':local'] = $this->DSGLog[':local'] + strlen($query);//strlen($query)+strlen($res);
                } else {
                    $this->DSGLog[':local'] = strlen($query);//strlen($query)+strlen($res);
                }
                if (!$res && !$intOnly) {
                    $res = Yii::app()->ExternalTranslator->translateText($_query, $from, $to, $_category);
                    if (isset($this->DSGLog[':remote'])) {
                        $this->DSGLog[':remote'] = $this->DSGLog[':remote'] + strlen(
                            $query
                          );//strlen($query)+strlen($res);
                    } else {
                        $this->DSGLog[':remote'] = strlen($query);//strlen($query)+strlen($res);
                    }
                    $translation = $this->translateFromDB($_query, $from, $to, $_category);
                    if (isset($translation->message_id) && $translation->message_id) {
                        $rowID = $translation->message_id;
                    }
                    if (isset($translation->translation) && $translation->translation) {
                        $res = $translation->translation;
                    }
                    if (isset($translation->use_long)) {
                        $use_long = $translation->use_long;
                    }
                    if (isset($translation->translation_category) && $translation->translation_category) {
                        $_category = $translation->translation_category;
                    }
                }
                if (!$res) {
                    $this->_translatedText = $_query;
                    $this->_success = false;
                    if ($returnFalse) {
                        return false;
                    }
                    return $this->_translatedText;
                } else {
                    $this->_translatedText = $res;
                    $this->_success = true;
                    if ($extOutput) {
                        $result = $this->markupTranslation(
                          $_query,
                          $from,
                          $to,
                          $this->_translatedText,
                          $_category,
                          $rowID,
                          $use_long,
                          $editable || $this->editableByRole,
                          $clear
                        );
                    } else {
                        $result = $this->_translatedText;
                    }
                }
            } else {
                $this->_success = false;
                if ($extOutput) {
                    $result = $this->markupTranslation(
                      $_query,
                      $from,
                      $to,
                      $_query,
                      $_category,
                      $rowID,
                      $use_long,
                      $editable || $this->editableByRole,
                      $clear,
                      $extParams
                    );
                } else {
                    $result = $_query;
                }
            }
            if (isset(Yii::app()->memCache) && $rowID && $result != $_query) {
                @Yii::app()->memCache->set($cacheTag, $result, $this->memCacheTtl);
            }
            return $result;
        } catch (Exception $e) {
            $this->_translatedText = $query;
            $this->_success = false;
            return $this->_translatedText;
        }
    }

}