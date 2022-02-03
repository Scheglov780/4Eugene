<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSGCurl.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * Класс, реализующий работу с библиотекой curl с некоторыми специфическими особенностями.
 */
class DSGDownloaderCurl extends DSGDownloaderBase
{
    /** Формат работы curl с SSL
     *    CURL_SSLVERSION_DEFAULT 0
     *    CURL_SSLVERSION_TLSv1 1
     *    CURL_SSLVERSION_SSLv2 2
     *    CURL_SSLVERSION_SSLv3 3
     *    CURL_SSLVERSION_TLSv1_0 4
     *    CURL_SSLVERSION_TLSv1_1 5
     *    CURL_SSLVERSION_TLSv1_2 6
     *    CURL_SSLVERSION_TLSv1_3 7
     * @var int
     */
    private static $CURL_SSLVERSION = 5;
    /**
     * @var DSGLog|null
     */
    private static $DSGLog = null;
    private static $_cookieNames = [];
    /** Переменная, в которой хранится экземпляр ресурса curl для его
     * повторного использования в режиме keep-alive
     * @var resource|bool
     */
    private static $_curlObject = false;
    private static $_downloadCache = [];
    private static $_newCookieHeader = '';
    private static $debugLog = false;
    private static $userAgents = [
        //'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
      "Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36",
        //'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:55.0) Gecko/20100101 Firefox/55.0'
    ];
    public static $cookiesEnabled = false;
    /**
     * Использовать ли режим отладки
     * @var bool
     */
    public static $debug = false;
    public static $loggingDownloads = true;
    /** Адрес специализированного внешнего DSG-прокси.
     * Строковое значение. Например 'proxy2.dropshop.pro'
     * Работает в паре с параметром proxy_enabled
     * @var string
     */
    public static $proxy_address = null;
    /** Использовать ли специализированный внешний DSG-прокси.
     * Работает в паре с параметром proxy_address
     * @var bool
     */
    public static $proxy_enabled = false;

    /* Summary
       Функция для скачивания контента заданного URL
       Description
       $path - URL, содержимое которого необходимо скачать

       $urlPreserved = FALSE - параметры (как часть URL), которые
       необходимо сохранять при редиректах.

       Например, необходимо сохранять номер страницы и порядок
       сортировки, тогда $urlPreserved может быть
       '&amp;page=10&amp;sord=desc'

       $direct = FALSE - принудительно скачивать без использования
       любых прокси.
       Returns
       Возвращает stdClass() $res, где

       $res-\>info = curl_getinfo($ch) - информация о закачке

       $res-\>data = - собственно, закачанные данные
                                     */

    private static function checkHeaderForPersistentCookiesAndApply($ch, $header)
    {
        if ($header && is_string($header)) {
            if ($ch) {
                $interface = static::$_lastIp;//curl_getinfo($ch, 0x100000 + 41);//CURLINFO_LOCAL_IP
                if (!$interface) {
                    $interface = '0.0.0.0';
                }
            } else {
                $interface = '0.0.0.0';
            }
            $res = preg_match_all('/^set-cookie:\s+(.+?)=(.+?);.*?domain\s*=(.+?)(?:;|$)/im', $header, $matches);
            if ($res) {
                foreach ($matches[0] as $i => $cookie) {
                    Yii::app()->db->createCommand(
                      "
                    INSERT INTO log_source_cookies (\"name\",\"value\",domain,\"date\",interface)
                    VALUES (:name,:value,:domain,NOW(), :interface)
                    ON CONFLICT ON CONSTRAINT log_source_cookies_constr 
                        DO UPDATE SET value=:value,\"date\"=NOW()
                    "
                    )->execute(
                      [
                        ':name'      => $matches[1][$i],
                        ':value'     => $matches[2][$i],
                        ':domain'    => $matches[3][$i],
                        ':interface' => $interface,
                      ]
                    );
                }
                /*
                 * name
value
domain
date

                 */
            }
        }
        return;
    }

    private static function cookiesFromRequest(&$ch, $resetCookies = false)
    {
        if (!$resetCookies) {
            $cookiesFromBrowser = Yii::app()->request->cookies;
            if (!count($cookiesFromBrowser)) {
                $cookiesFromBrowser = static::getNewCookies();
            }
        } else {
            $cookiesFromBrowser = static::getNewCookies();
        }

        // $cookiesFromBrowser = Yii::app()->request->cookies;
        $cookieBuffer = [];
        if (DSConfig::getVal('curl_cookies_mode') == 'random') {
            foreach (static::$_cookieNames as $cookieName) {
                // break;
                if (isset($cookiesFromBrowser[$cookieName])) {
                    $cookieBuffer[$cookieName] = $cookieName . '=' . $cookiesFromBrowser[$cookieName]->value;
                }
            }
        } elseif (DSConfig::getVal('curl_cookies_mode') == 'original') {
            $url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $interface = curl_getinfo($ch, CURLOPT_INTERFACE);
            if (!$interface) {
                $interface = '0.0.0.0';
            }
            $domain = strtolower(preg_replace('/^http[s]*:\/\/.*?([a-z0-9\-]+?\.[a-z0-9\-]+?)\/.+$/i', '\1', $url));
            $cookiesFromDb = Yii::app()->db->createCommand(
              "SELECT cc.name, cc.value FROM log_source_cookies cc WHERE cc.domain LIKE :domain AND cc.interface = :interface"
            )->queryAll(
              true,
              [
                ':domain'    => '%' . $domain,
                ':interface' => $interface,
              ]
            );
            if ($cookiesFromDb) {
                foreach ($cookiesFromDb as $cookieFromDb) {
                    $cookieBuffer[$cookieFromDb['name']] = $cookieFromDb['name'] . '=' . $cookieFromDb['value'];
                }
            }
        }
//=============================
        if (defined('FORCE_XDEBUG')) {
            $cookieBuffer['XDEBUG_SESSION'] = 'XDEBUG_SESSION=Alexy_proxy2';
        } else {
            unset($cookieBuffer['XDEBUG_SESSION']);
        }
//=============================
        $cookies = implode("; ", $cookieBuffer);
        curl_setopt($ch, CURLOPT_COOKIE, $cookies);
        return $cookies;
    }

    /* Summary
       Возвращает ресурс curl для использования в функции download
       Description
       $path - строковый параметр, ссылка (URL) на ресурс, который
       необходимо скачать.
       Returns
       Возвращает ресурс curl с необходимыми установками.          */

    private static function cookiesToResponse($header)
    {
        preg_match_all("/^(Set-cookie:\s*(.+?)\s*=.*?)$/ims", $header, $cookies);
        $domain = preg_replace('/^http[s]*:\/\//is', '', Yii::app()->getBaseUrl(true));
        $proxyDomain = preg_replace('/:\d+$/is', '', static::$proxy_address);
        $preg = '/(' . preg_replace('/([\.\-])/is', '\\\\$1', $proxyDomain) . ')/i';
        return;
    }

    /* Summary
       Внутренняя реализация загрузки документа при помощи curl с
       учетом авторизации, редиректов и других необходимых
       особенностей.
       Description
       $ch - ресурс curl

       $maxredirect = NULL - максимальное количество редиректов.
       Если NULL то 20 по умолчанию

       $urlPreserved = FALSE - параметры (как часть URL), которые
       необходимо сохранять при редиректах.

       Например, необходимо сохранять номер страницы и порядок
       сортировки, тогда $urlPreserved может быть
       '&amp;page=10&amp;sord=desc'

       $direct = FALSE - принудительно скачивать без использования
       любых прокси.
       Returns
       При успешном завершении будет возвращен результат, а при неудаче - FALSE. */

    private static function getNewCookies($url = '')
    {
        if (!$url) {
            return [];
        }
        $header = '';
        try {
            $ch = curl_init(
              $url
            );
            curl_setopt(
              $ch,
              CURLOPT_URL,
              $url
            );
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            // curl_setopt( $ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3' );
            //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'rsa_rc4_128_sha');
            curl_setopt($ch, CURLOPT_SSLVERSION, static::$CURL_SSLVERSION);//CURL_SSLVERSION_DEFAULT
            curl_setopt($ch, CURLOPT_TIMEOUT, (int) DSConfig::getVal('curl_timeout_default'));//120
            curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
            curl_setopt($ch, CURLOPT_NOPROGRESS, true);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 3600);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            if (defined('CURLOPT_CERTINFO')) {
                curl_setopt($ch, CURLOPT_CERTINFO, false);
            }
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, false);
            //curl_setopt($ch, CURLOPT_TCP_NODELAY, false);
            curl_setopt($ch, CURLOPT_COOKIEJAR, '/dev/null');
            $mr = 20;
            $open_basedir = ini_get('open_basedir');
            $safe_mode = false;//ini_get('safe_mode');
            if (($open_basedir == '') && (in_array($safe_mode, ['0', 'Off', '']) || !$safe_mode)) {
                curl_setopt($ch, CURLOPT_MAXREDIRS, $mr); //
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);//
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $header = curl_exec($ch);
                curl_close($ch);
            } else {
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                if ($mr > 0) {
                    $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    $originalUrl = $newurl;
                    $rch = curl_copy_handle($ch);
                    curl_setopt($rch, CURLOPT_HEADER, true);
                    curl_setopt($rch, CURLOPT_NOBODY, true);
                    curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                    curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
                    do {
                        curl_setopt($rch, CURLOPT_URL, $newurl);
                        static::setHeaders($ch, []);
                        $header = curl_exec($rch);
                        if (curl_errno($rch)) {
                            $code = 0;
                        } else {
                            $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                            if ($code == 301 || $code == 302) {
                                preg_match('/Location:(.*?)[\n\r]/i', $header, $matches);
//                $oldurl=$newurl;
                                $url = trim(array_pop($matches));
                                if (preg_match('/http[s]*:\/\/.+?(?=\/)/i', $url)) {
                                    $newurl = $url;
                                } else {
                                    preg_match('/http[s]*:\/\/.+?(?=\/)/i', $newurl, $m);
                                    $newurl = trim(array_pop($m)) . $url;
                                }
                            } else {
                                $code = 0;
                            }
                        }
                    } while ($code && --$mr);
                    curl_close($rch);
                    if (!$mr) {
                        return '';
                    }
                }
            }
            $result = [];
            if (preg_match_all('/Set\-Cookie:\s*(.+?)=(.+?);/is', $header, $matches)) {
                static::$_newCookieHeader = $header;
                static::cookiesToResponse($header);
                foreach ($matches[1] as $i => $match) {
                    $val = new stdClass();
                    $val->value = $matches[2][$i];
                    $result[$matches[1][$i]] = $val;
                }
            }
            return $result;
        } catch (Exception $e) {
            return [];
        }
    }

    /* Summary
       Функция безопасно закрывает общий ресурс curl в переменной
       _curlObject                                                                                               */

    private static function setHeaders($ch, $headers)
    {
        if (!isset($headers) || !is_array($headers)) {
            $headers = [];
        }
        $headers[] = 'User-Agent: ' . static::$userAgents[1];
        $headers[] = "Connection: keep-alive";
        $headers[] = "Keep-Alive: 30";
//        $headers[] = 'Cache-Control: no-cache';
//        $headers[] = 'Pragma: no-cache';
//        $headers[] = 'Origin: http://777.danvit.ru';
        //$headers[] = 'Content-Type: image/jpeg';

        if ((!static::$proxy_enabled || static::$isDSProxy)) {
            $fakeProxyAddress =
              ((isset($_SERVER['SERVER_NAME']) && $_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] :
                $_SERVER['SERVER_ADDR']);
//            $fakeProxyAddress = mt_rand(193, 254) .".". mt_rand(1, 254) . "." . mt_rand(1, 254) . "." . mt_rand(1, 254);
            $headers[] = 'Via: 1.0 ' . $fakeProxyAddress;
            if (isset($_SERVER['REMOTE_ADDR'])) {
                $randIP = $_SERVER['REMOTE_ADDR'];
            } else {
                $randIP = mt_rand(193, 254) . "." . mt_rand(0, 254) . "." . mt_rand(0, 254) . "." . mt_rand(1, 254);
            }

            $headers[] = 'X-Forwarded-For: ' . $randIP;
        }

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }

    /* Summary
       Возвращает ресурс curl для использования в функции download
       Description
       $path - строковый параметр, ссылка (URL) на ресурс, который
       необходимо скачать.
       Returns
       Возвращает ресурс curl с необходимыми установками.          */

    public static function closeDownloader()
    {
        if (gettype(static::$_curlObject) == 'resource') {
            curl_close(static::$_curlObject);
            if (class_exists('Profiler', false)) {
                Profiler::message('curl', 'closed');
            }
        }
    }

    /* Summary
   Внутренняя реализация загрузки документа при помощи curl с
   учетом авторизации, редиректов и других необходимых
   особенностей.
   Description
   $ch - ресурс curl

   $maxredirect = NULL - максимальное количество редиректов.
   Если NULL то 20 по умолчанию

   $urlPreserved = FALSE - параметры (как часть URL), которые
   необходимо сохранять при редиректах.

   Например, необходимо сохранять номер страницы и порядок
   сортировки, тогда $urlPreserved может быть
   '&amp;page=10&amp;sord=desc'

   $direct = FALSE - принудительно скачивать без использования
   любых прокси.
   Returns
   При успешном завершении будет возвращен результат, а при неудаче - FALSE. */

    public static function download(
      $ch,
      $maxredirect = null,
      $urlPreserved = false,
      $direct = false,
      $timeout = false,
      $resetCookies = false,
      $postData = false,
      $refresh = false
    ) {
        if (is_array($postData)) {
            $postDataStr = '';
            foreach ($postData as $k => $v) {
                if (is_string($v)) {
                    $vv = (string) $v;
                } elseif (is_a($v, 'CURLFile')) {
                    $vv = $v->name;
                } else {
                    $vv = 'null';
                }
                $postDataStr = $postDataStr . $k . ': ' . $vv . ';';
            }
        } elseif (is_string($postData)) {
            $postDataStr = $postData;
        } else {
            $postDataStr = '';
        }

        $_downloadCacheKey = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL)
          . ($urlPreserved ? $urlPreserved : '-false-')
          . ($postDataStr ? $postDataStr : '-false-');
        if (isset(static::$_downloadCache[$_downloadCacheKey]) && !$resetCookies && $refresh) {
            $_downloadCacheResult = static::$_downloadCache[$_downloadCacheKey];
            if (isset($_downloadCacheResult->body) && $_downloadCacheResult->body
              && isset($_downloadCacheResult->header) && $_downloadCacheResult->header) {
                return $_downloadCacheResult;
            }
        }
        if (!$timeout) {
            $timeout = (int) DSConfig::getVal('curl_timeout_default');
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $mr = $maxredirect === null ? 20 : intval($maxredirect);
        $open_basedir = ini_get('open_basedir');
        $safe_mode = false;//ini_get('safe_mode');
        //$safe_mode = 'on';
        if (class_exists('DSConfig', false) && !static::$isDSProxy) {
            static::$proxy_address = DSConfig::getVal('proxy_address');
            static::$proxy_enabled = (DSConfig::getVal('proxy_enabled') == 1) && static::checkHost(
                static::$proxy_address
              );
            static::$debug = DSConfig::getVal('site_debug') == 1;
        }
        $proxy_enabled = (static::$proxy_enabled && !$direct);
        if (!$proxy_enabled) {
            if (($open_basedir == '') && (in_array($safe_mode, ['0', 'Off', '']) || !$safe_mode)) {
                curl_setopt($ch, CURLOPT_MAXREDIRS, $mr); //
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);//
                curl_setopt($ch, CURLOPT_HEADER, true);
            } else {
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
                if ($mr > 0) {
                    $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                    $originalUrl = $newurl;
                    $rch = curl_copy_handle($ch);
                    curl_setopt($rch, CURLOPT_HEADER, true);
                    curl_setopt($rch, CURLOPT_NOBODY, true);
                    curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                    curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
                    do {
                        curl_setopt($rch, CURLOPT_URL, $newurl);
                        $header = curl_exec($rch);
                        static::checkHeaderForPersistentCookiesAndApply($ch, $header);
                        if (curl_errno($rch)) {
                            $code = 0;
                        } else {
                            $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                            if ($code == 301 || $code == 302) {
                                preg_match('/Location:(.*?)[\n\r]/i', $header, $matches);
                                $url = trim(array_pop($matches));
                                if (preg_match('/http[s]*:\/\/.+?(?=\/)/i', $url)) {
                                    $newurl = $url;
                                } else {
                                    preg_match('/http[s]*:\/\/.+?(?=\/)/i', $newurl, $m);
                                    $newurl = trim(array_pop($m)) . $url;
                                }
                            } else {
                                $code = 0;
                            }
                        }
                    } while ($code && --$mr);
                    curl_close($rch);
                    if (!$mr) {
                        static::$DSGLog->result =
                          'Err: download error 1 max redirects or redirect error';//Ошибка обработки редиректа
                        static::$DSGLog->extData['url'] = $newurl;
                        return static::fillCurlResult(
                          null,
                          null,
                          new CHttpException(
                            570,
                            'Too many redirects. When following redirects, libcurl hit the maximum amount.'
                          )
                        );
                    }
                    $debug = static::$debug;
                    if ($debug) {
                        echo '<div>';
                        echo '<pre>' . $originalUrl . '</pre>';
                    }
                    if (($urlPreserved) && ($newurl != $originalUrl)) {
                        $newurl = $newurl . '&' . $urlPreserved;
                        if ($debug) {
                            echo '<pre>' . $newurl . '</pre>';
                        }
                    }
                    if ($debug) {
                        echo '</div>';
                    }
                    curl_setopt($ch, CURLOPT_URL, $newurl);
                }
            }
        } else {
            $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            $originalUrl = $newurl;
            $debug = static::$debug;
            if ($debug) {
                echo '<pre>' . $originalUrl . '</pre>';
            }
            $newurl = 'http://' . static::$proxy_address . '/site/proxy?url=' . urlencode(
                $newurl
              ) . '&pver=' . DSGParserClass::getParserVersion(false) . ($refresh ? '&refresh=true' : '');
            if ($debug) {
                echo '<pre>' . $newurl . '</pre>';
            }
            curl_setopt($ch, CURLOPT_URL, $newurl);
        }
        static::cookiesFromRequest($ch, $resetCookies);
        if ($postData) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        };
        try {
            curl_setopt($ch, CURLOPT_HEADER, true);
//------------ incorrect https processing -----
            $_url = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            if (preg_match('/^((?:https:)*\/\/(?:.+?))\//i', $_url, $_matches)) {
                $_domain = $_matches[1];
            } else {
                $_domain = '';
            }
            if ($_domain && isset(Yii::app()->memCache)) {
                $_needProtocolRepare = @Yii::app()->memCache->get('needProtocolRepare -' . $_domain);
                if ($_needProtocolRepare) {
                    $newurl = preg_replace('/^(?:https:)*\/\//is', 'http://', $_url);
                    curl_setopt($ch, CURLOPT_URL, $newurl);
                }
            }
//---------------------------------------------
            $content = curl_exec($ch);
            $result = static::fillCurlResult($ch, $content);
            if (isset($result->curlError) && $result->curlError && preg_match(
                '/error.*ssl/is',
                $result->curlError->getMessage()
              )
              && preg_match('/^(?:https:)*\/\//is', curl_getinfo($ch, CURLINFO_EFFECTIVE_URL))) {
                $newurl = preg_replace('/^(?:https:)*\/\//is', 'http://', curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
                curl_setopt($ch, CURLOPT_URL, $newurl);
                $content = curl_exec($ch);
                $result = static::fillCurlResult($ch, $content);
                if (is_null($result->curlError) && $_domain && isset(Yii::app()->memCache)) {
                    @Yii::app()->memCache->set('needProtocolRepare -' . $_domain, '1', 600);
                }
            }

            if (isset($result->header)) {
                static::checkHeaderForPersistentCookiesAndApply($ch, $result->header);
            }
            /*            if (preg_match('/1.1 302 Found/',$content)) {
                            die;
                        }
            */
            if ($proxy_enabled) {
                static::$DSGLog->DSProxy = static::$proxy_address;
                if (preg_match('/O:8:"stdClass"/', $result->body)) {
                    try {
                        $result = @unserialize($result->body);
                        if ($result) {
                            static::$_downloadCache[$_downloadCacheKey] = $result;
                        }
                        return $result;
                    } catch (Exception $e) {
                        return $result;
                    }
                } else {
                    static::$_downloadCache[$_downloadCacheKey] = $result;
                    return $result;
                }
            } else {
                static::$_downloadCache[$_downloadCacheKey] = $result;
                return $result;
            }
        } catch (Exception $e) {
            return static::fillCurlResult(
              $ch,
              null,
              new CHttpException(535, $e->getMessage())
            );
        }
    }

    public static function fillCurlResult($ch, $content, $curlError = null)
    {
        $execRes = new stdClass();
//        $execRes->cookies = '';
        $execRes->header = '';
        $execRes->body = '';
        $execRes->info = null;
        $execRes->curlError = $curlError;
        $execRes->capcha = null;
        $execRes->antiSpider = null;
        $execRes->postData = null;
        $execRes->compressed = false;
        if ($ch) {
            $execRes->info = curl_getinfo($ch);
            if (curl_errno($ch) > 0) {
                if (!$execRes->curlError) {
                    $execRes->curlError = new CHttpException(530, curl_error($ch));
                }
                static::$DSGLog->result = 'Err: curl error'; //Ошибка загрузки
                static::$DSGLog->extData['curlInfo'] = $execRes->info;
                static::$DSGLog->extData['content'] = $content;
                static::$DSGLog->extData['exception'] = $execRes->curlError;
            } elseif ($content) {
                //(?:^HTTP\/1.+?)(?=O:8:"stdClass")
                if ($content[0] == '{') {
                    $execRes->header = '';
                    $execRes->body = $content;
                } else {
                    if (preg_match_all(
                      '/(?:^HTTP\/1.+?)(?:(?:(?:[\r\n]+(?!O:8:"stdClass")[a-zA-Z0-9\-_]+:.+?)(?=[\r\n])))+[\r\n]{2,}/sm',
                      $content,
                      $res,
                      PREG_OFFSET_CAPTURE
                    )) {
                        $header_size = 0;
                        foreach ($res[0] as $headerItem) {
                            if ($headerItem[1] == $header_size) {
                                $header_size = $header_size + strlen($headerItem[0]);
                            } else {
                                break;
                            }
                        }
                        /* $strLenFirst=strlen($res[0][0][0]);
                         $strLenLast=strlen($res[0][count($res[0]) - 1][0]);
                         $strOffsetLast=$res[0][count($res[0]) - 1][1];
                         if ($strLenFirst<$strOffsetLast) {
                             $header_size = $strLenFirst;
                         } else {
                             $header_size = $strOffsetLast + $strLenLast;
                         }
                        */
                    } else {
                        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
                    }

                    $execRes->header = substr($content, 0, $header_size);
                    if (preg_match('/Content\-Type/i', $execRes->header)) {
                        $execRes->body = substr($content, $header_size);
                    }
                    if (preg_match('/Content-Encoding:.*?[\s,](?:gzip|compress)[\s,$]/is', $execRes->header)) {
                        $execRes->compressed = true;
                    }
                    //static::cookiesToResponse($execRes->header);
                    //text/html;charset=gb18030
                    if (isset($execRes->info['content_type']) && preg_match(
                        '/charset\s*=\s*GBK/i',
                        $execRes->info['content_type']
                      )
                    ) {
                        $execRes->body = @iconv('GBK', 'UTF-8//IGNORE', $execRes->body);
                    } elseif (isset($execRes->info['content_type']) && preg_match(
                        '/charset\s*=\s*gb18030/i',
                        $execRes->info['content_type']
                      )
                    ) {
                        $execRes->body = @iconv('GB18030', 'UTF-8//IGNORE', $execRes->body);
                    }
                }
            } else {
                static::$DSGLog->result = 'Err: no content returned'; //Ошибка - нет контента
                static::$DSGLog->extData['curlInfo'] = $execRes->info;
                static::$DSGLog->extData['exception'] = $execRes->curlError;
            }
        }
        return $execRes;
    }

    public static function getCurl(
      $path,
      $referer = null,
      $cacheKey = null,
      $log = true,
      $forDSProxy = false
    ) {
        if (isset(static::$DSGLog)) {
            static::$DSGLog = null;
        }
        $_path = static::normalizeUrl($path);
        if ($log) {
            static::$DSGLog = new DSGLog($_path, $cacheKey);
            if (static::$debugLog) {
                static::$DSGLog->debug = $_path;
            }
        }
        try {
            if (class_exists('Profiler', false)) {
                Profiler::message('curl path', $_path);
            }
            if (gettype(static::$_curlObject) != 'resource') {
                $ch = curl_init($_path);
                if (class_exists('Profiler', false)) {
                    Profiler::message('curl', 'new');
                }
                static::$_curlObject = $ch;
            } else {
                $ch = static::$_curlObject;
                if (class_exists('Profiler', false)) {
                    Profiler::message('curl', 'reuse');
                }
                curl_setopt($ch, CURLOPT_URL, $_path);
            }
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
            curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, (int) DSConfig::getVal('curl_timeout_default'));//120
            curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
            //curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
            //curl_setopt($ch, 244, 1);
            curl_setopt($ch, CURLOPT_NOPROGRESS, true);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            if (defined('CURLOPT_CERTINFO')) {
                curl_setopt($ch, CURLOPT_CERTINFO, false);
            }
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, false);
            //curl_setopt($ch, CURLOPT_TCP_NODELAY, false);
//      curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
//---------
            $ipFromPool = static::getIpFromPool();
            if ($ipFromPool) {
                curl_setopt($ch, CURLOPT_INTERFACE, $ipFromPool);
            }
            curl_setopt($ch, CURLOPT_COOKIEJAR, '/dev/null');
            if (!static::$isDSProxy) {
                if (class_exists('DSConfig', false)) {
                    static::$proxy_http_enabled = DSConfig::getVal('proxy_http_enabled') == 1;
                    static::$proxy_http_address = DSConfig::getVal('proxy_http_address');
                }
            } else {
                // curl_setopt( $ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3' );
                //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'rsa_rc4_128_sha');
                curl_setopt($ch, CURLOPT_SSLVERSION, static::$CURL_SSLVERSION);//CURL_SSLVERSION_DEFAULT
            }
            if (static::$proxy_http_enabled) {
                curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
                curl_setopt($ch, CURLOPT_PROXY, static::$proxy_http_address);
                if (static::$proxy_http_auth) {
                    curl_setopt($ch, CURLOPT_PROXYUSERPWD, static::$proxy_http_auth);
                }
                static::$DSGLog->httpProxy = static::$proxy_http_address;
            }
            if ($referer) {
                $headers = ["Referer: " . $referer];
            } else {
                $headers = [];
            }
            if (preg_match('/(?:\&(?:ajax|json)=)/i', $_path)) {
                $headers[] = "X-Requested-With: XMLHttpRequest";
            }

            static::setHeaders($ch, $headers);

            return $ch;
        } catch (Exception $e) {
            throw new Exception (520, 'System error: curl not installed or inited.');
        }
    }

    public static function getFromProxyV2($class)
    {
        $startTime = microtime(true);
        if (class_exists('DSConfig', false) && !static::$isDSProxy) {
            static::$proxy_enabled = true;
            static::$proxy_address = DSConfig::getVal('proxy_address');
        }
        if (static::checkProxy() != 'OK') {
            $res = static::fillCurlResult(null, false);
            /** @noinspection PhpUnusedLocalVariableInspection */
            $endTime = microtime(true) - $startTime;
            return $res;
        }

        $url = 'http://' . static::$proxy_address . '/site/proxy?url=' . get_class(
            $class
          ) . '&pver=' . DSGParserClass::getParserVersion(false);
        $class->forceProtocolV2 = false;
        //$post = urlencode(serialize($class));
        $post = urlencode(base64_encode(gzcompress(serialize($class), 9)));
        $ch = static::getCurl($url, null, null, true, true);
        static::$DSGLog->type = get_class($class);
        static::$DSGLog->DSProxy = static::$proxy_address;
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'data=' . $post);
//===============================================
        $fHeader = fopen('php://temp', 'w+');
        $fBody = fopen('php://temp', 'w+');
        curl_setopt($ch, CURLOPT_WRITEHEADER, $fHeader);
        curl_setopt($ch, CURLOPT_FILE, $fBody);
//===============================================
        static::cookiesFromRequest($ch, false);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $startIterationTime = microtime(true);
        curl_exec($ch);
        /** @noinspection PhpUnusedLocalVariableInspection */
        $endIterationTime = microtime(true);
        $curlInfo = curl_getinfo($ch);
        if (curl_errno($ch) > 0) {
//TODO Тут что-то может быть не так!!!
            /*
            if (isset($tmpRulesList)) {
                $class->search_DSGRulesList = $tmpRulesList;
            }
            */
            static::$DSGLog->result = 'Err: V2 download error 1 in class ' . get_class(
                $class
              );//Ошибка загрузки (1) с прокси
            static::$DSGLog->extData['curlInfo'] = $curlInfo;
            throw new CHttpException(575, curl_error($ch) . ' ' . CVarDumper::dumpAsString($curlInfo, 10, false));
        }
        fseek($fBody, 0);
        $fStat = fstat($fBody);
        $body = null;
        if ($fStat['size'] > 0) {
            $body = fread($fBody, $fStat['size']);
        }
//===============================================
        $headers = '';
        fseek($fHeader, 0);
        $fStat = fstat($fHeader);
        if ($fStat['size'] > 0) {
            $headers = fread($fHeader, $fStat['size']);
            static::cookiesToResponse($headers);
            if (preg_match('/Content\-Time:\s*([\d\.\-]+(?:\scached)*)/i', $headers, $headerVal)) {
                if (class_exists('Profiler', false)) {
                    Profiler::message('Proxy Content-Time', $headerVal[1]);
                }
            }
//===============================================
        }
        fclose($fHeader);
        fclose($fBody);
        unset ($fHeader);
        unset ($fBody);
        unset ($fStat);
//===============================================
        if (preg_match('/^HTTP\/1\.1\s+/s', $body)) {
            $body = preg_replace('/.*HTTP\/1\.1.*\r\n\r\n/s', '', $body);
        }
        $content = $headers . $body;
        $res = static::fillCurlResult($ch, $content);
        if (($res->info['http_code'] >= 400)) {
            static::$DSGLog->result = 'Err: V2 download error 2 in class ' . get_class(
                $class
              ); //Ошибка загрузки (2) с прокси
            static::$DSGLog->extData['curlInfo'] = $res->info;
            static::$DSGLog->extData['header'] = $res->header;
            static::$DSGLog->extData['body'] = $res->body;
        } else {
            if (preg_match('/O:8:"stdClass"/', $res->body)) {
                try {
//                    $length=strlen($res->body);
                    $res->body = @unserialize($res->body);
                    if (!is_object($res->body)) {
                        static::$DSGLog->result = 'Err: V2 download error 5 in class ' . get_class(
                            $class
                          ); //Ошибка загрузки (3) с прокси
                        static::$DSGLog->extData['curlInfo'] = $res->info;
                        static::$DSGLog->extData['header'] = $res->header;
                        static::$DSGLog->extData['body'] = $res->body;
                        /** @noinspection PhpUnusedLocalVariableInspection */
                        $endTime = microtime(true) - $startTime;
                        return $res;
                    }
                    static::$DSGLog->result = 'OK: V2 from ' . get_class($class);//Загружено с прокси (DSG)
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    $endTime = microtime(true) - $startTime;
                    return $res;
                } catch (Exception $e) {
                    static::$DSGLog->result = 'Err: V2 download error 3 in class ' . get_class(
                        $class
                      ); //Ошибка загрузки (3) с прокси
                    static::$DSGLog->extData['curlInfo'] = $res->info;
                    static::$DSGLog->extData['header'] = $res->header;
                    static::$DSGLog->extData['body'] = $res->body;
                    static::$DSGLog->extData['exception'] = $e;
                    /** @noinspection PhpUnusedLocalVariableInspection */
                    $endTime = microtime(true) - $startTime;
                    return $res;
                }
            } else {
                static::$DSGLog->result = 'OK: V2 URL from ' . get_class($class); //Загружено с прокси (url)
                /** @noinspection PhpUnusedLocalVariableInspection */
                $endTime = microtime(true) - $startTime;
                return $res;
            }
        }
        static::closeDownloader();
        /** @noinspection PhpUnusedLocalVariableInspection */
        $endTime = microtime(true) - $startTime;
        return $res;
    }

    public static function getHttpDocument(
      $path,
      $urlPreserved = false,
      $direct = false,
      $referer = null,
      DSGParserClass $DSGParser = null,
      $refresh = false
    ) {
        if (Yii::app()->db->cache(3600)->createCommand(
          "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 'proxy_cache_prefetch'"
        )->queryRow()) {
            /** @noinspection SqlResolve */
            $proxyCactePrefetch = Yii::app()->db->createCommand(
              '
        SELECT "value" FROM proxy_cache_prefetch WHERE "hash"=:hash LIMIT 1
        '
            )->queryScalar([':hash' => md5($path)]);
            if ($proxyCactePrefetch) {
                /** @noinspection SqlResolve */
                Yii::app()->db->createCommand(
                  "
                        DELETE FROM proxy_cache_prefetch WHERE \"hash\"=:hash
                        "
                )->execute([':hash' => md5($path)]);
                return (unserialize($proxyCactePrefetch));
            }
        }
        /** @noinspection PhpUnusedLocalVariableInspection */
        $startTime = microtime(true);
        if (class_exists('DSConfig', false) && !static::$isDSProxy) {
            if (DSConfig::getVal('proxy_enabled') == 1 && !$direct) {
                // Стучимся в прокси, он работает быстро и таймауты должны быть маленькие
                $all_time_limit = (int) DSConfig::getVal('curl_timeout_dsproxy') + 1;
                $request_time_limit = round((int) DSConfig::getVal('curl_timeout_dsproxy') / 2);
                set_time_limit(120); //($all_time_limit + 15);
            } else {
                //Таймауты для локальной закачки
                $all_time_limit = (int) DSConfig::getVal('curl_timeout_default') + 1;
                $request_time_limit = round((int) DSConfig::getVal('curl_timeout_default') / 2);
                set_time_limit(120);//($all_time_limit + 15);
            }
        } else {
            //Таймауты для чистого прокси
            $all_time_limit = (int) DSConfig::getVal('curl_timeout_default') + 1;
            $request_time_limit = round((int) DSConfig::getVal('curl_timeout_default') / 2);
            set_time_limit(120);
        }
        $startTime = microtime(true);
        $time = 0;

        if (isset(Yii::app()->memCache)) {
            $noRepeat = @Yii::app()->memCache->get('curl-noRepeat-' . $path);
        } else {
            $noRepeat = @Yii::app()->cache->get('curl-noRepeat-' . $path);
        }

        if ($noRepeat && !$refresh && DSConfig::getVal('search_cache_enabled') == 1) { // && false
//            header('HTTP/1.1 503 Service Unavailable');
            static::$DSGLog->result = 'Err: curl temporary no repeat';//Фатальная ошибка загрузки url
//            echo 'Service temporary unavailable.';
            return false;
        }
        while (($all_time_limit > $time)) {
            $ch = static::getCurl(
              $path,
              $referer,
              (($DSGParser && isset($DSGParser->cacheKey)) ? md5($DSGParser->cacheKey) : null)
            );
            $startIterationTime = microtime(true);
            $res = static::download($ch, 20, $urlPreserved, $direct, $request_time_limit, $time > 0, false, $refresh);
            if (!is_object($res)) {
                header('HTTP/1.1 403 Forbidden');
                static::$DSGLog->result = 'Err: fatal error in download';//Фатальная ошибка загрузки url
                echo 'Bad request.';
                return false;
            }
            if (isset($res->info['http_code']) && $res->info['http_code'] == 204) {
                break;
            }
            if (isset($res->curlError) && $res->curlError && preg_match('/error.*ssl/is', $res->curlError->getMessage())
              && preg_match('/^(?:https:)*\/\//is', curl_getinfo($ch, CURLINFO_EFFECTIVE_URL))) {
                $newurl = preg_replace('/^(?:https:)*\/\//is', 'http://', curl_getinfo($ch, CURLINFO_EFFECTIVE_URL));
                curl_setopt($ch, CURLOPT_URL, $newurl);
                $res = static::download(
                  $ch,
                  20,
                  $urlPreserved,
                  $direct,
                  $request_time_limit,
                  $time > 0,
                  false,
                  $refresh
                );
            }
            $endIterationTime = microtime(true);
            $iterationTime = $endIterationTime - $startIterationTime;
            $endTime = microtime(true);
            $time = $endTime - $startTime;
            if (isset($res->body) && $res->body && preg_match('/(?:dbexception)|(?:innodb)/i', $res->body)) {
                static::$DSGLog->result = 'Err: CDbException'; //Документ не найден в источнике
                static::$DSGLog->extData['body'] = $res->body;
                return $res;
            }
            if ((!$res->curlError) &&
              $res->info &&
              (isset($res->info['http_code']) && $res->info['http_code'] < 400) &&
              $res->body) {
                if (preg_match('/"error\-notice"/i', $res->body)) {
                    static::$DSGLog->result = 'Err: error notice from source'; //Документ не найден в источнике
                    static::$DSGLog->extData['curlInfo'] = $res->info;
                    static::$DSGLog->extData['body'] = $res->body;
                    return $res;
                }
                if (is_null($DSGParser)) {
                    static::$DSGLog->result = 'OK: V1 from url'; //Закачано по ссылке
                    break;
                } else {
                    if ($DSGParser->ValidationCheck($res->body)) {
                        static::$DSGLog->result = 'OK: V1 from ' . get_class($DSGParser); //Закачано из DSG
                        break;
                    } else {
                        $capcha = new DSGCapcha();
                        $res->capcha = $capcha->execute($res->body);
                        if ($res->capcha) {
                            static::$DSGLog->result = 'Captcha: captcha rised'; //Капча
                            static::$DSGLog->extData['curlInfo'] = $res->info;
                            static::$DSGLog->extData['header'] = $res->header;
                            static::$DSGLog->extData['body'] = $res->body;
                            break;
                        } elseif (preg_match(
                          '/anti_Spider\-(?:html\-)*checklogin/i',
                          $res->body
                        )) { //searchapp-list_html-anti_Spider-html-checklogin
                            $res->antiSpider = true;
                            static::$DSGLog->result = 'antiSpider: check login'; //Капча
                            static::$DSGLog->extData['curlInfo'] = $res->info;
                            static::$DSGLog->extData['header'] = $res->header;
                            static::$DSGLog->extData['body'] = $res->body;
                            if ((static::$proxy_enabled || static::$proxy_http_enabled)) {
                                static::$proxy_address = '';
                                static::$proxy_enabled = false;
                                static::$proxy_http_enabled = false;
                                static::$proxy_http_address = '';
                                static::closeDownloader();
                            }
                            if (static::$isDSProxy) {
                                break;
                            }
                            if ((int) ($request_time_limit - $iterationTime) > 5) {
                                sleep(5);
                                //sleep((int) ($request_time_limit - $iterationTime));
                            }
                        } else {
                            static::$DSGLog->result = 'Repeat: no data downloaded'; //Класс GSG не прошел валидацию
                            static::$DSGLog->extData['curlInfo'] = $res->info;//$res->info->http_code
                            static::$DSGLog->extData['header'] = $res->header;
                            static::$DSGLog->extData['body'] = $res->body;
                            if ((!preg_match(
                                '/[1-3][0-9][0-9]/',
                                $res->info['http_code']
                              )) && (static::$proxy_enabled || static::$proxy_http_enabled)
                            ) {
                                static::$proxy_address = '';
                                static::$proxy_enabled = false;
                                static::$proxy_http_enabled = false;
                                static::$proxy_http_address = '';
                                static::closeDownloader();
                            } else {
                                if (isset(Yii::app()->memCache)) {
                                    @Yii::app()->memCache->set('curl-noRepeat-' . $path, 1, 120);
                                } else {
                                    @Yii::app()->cache->set('curl-noRepeat-' . $path, 1, 120);
                                }
                                break;
                            }
                            //TODO: может быть это снова когда-нибудь пригодится
                            /*
                            if ((int) ($request_time_limit - $iterationTime) > 0) {
                                //sleep((int) ($request_time_limit - $iterationTime));
                            }
                            */
                        }
                    }
                }
            } else {
                $message = '';
                if (isset($res->curlError)) {
                    $err = $res->curlError;
                    $message = ': ' . $err->getMessage();
                }
                static::$DSGLog->result = trim('Timeout' . $message); //Таймаут загрузки
                if (isset($res) && isset($res->info)) {
                    static::$DSGLog->extData['curlInfo'] = $res->info;
                    if (static::$proxy_enabled || static::$proxy_http_enabled) {
                        static::$proxy_address = '';
                        static::$proxy_enabled = false;
                        static::$proxy_http_enabled = false;
                        static::$proxy_http_address = '';
                        static::closeDownloader();
                    } else {
                        if (static::$isDSProxy) {
                            break;
                        }
                    }
                }
                if (isset($res) && isset($res->header)) {
                    static::$DSGLog->extData['header'] = $res->header;
                }
                if (isset($res) && isset($res->body)) {
                    static::$DSGLog->extData['body'] = $res->body;
                }
//TODO: может быть это снова когда-нибудь пригодится
                /*
                if ((int) ($request_time_limit - $iterationTime) > 0) {
                    // sleep((int) ($request_time_limit - $iterationTime));
                }
                */
            }
        }
        if (isset($res)) {
            /** @noinspection PhpUnusedLocalVariableInspection */
            $endTime = microtime(true) - $startTime;
            //Utils::debugLog(round($endTime,2).': '.$res->info['size_download'].' S '.$res->info['url']);
            return $res;
        } else {
            return null;
        }

    }

    /* Summary
   Функция безопасно закрывает общий ресурс curl в переменной
   _curlObject */

    public static function getHttpDocumentArray(
      $urls,
      $direct = false,
      $referer = null,
      $cacheKey = null
    ) {
        $startTime = microtime(true);
        set_time_limit(60);
        try {
            if (class_exists('Profiler', false)) {
                Profiler::message('curl multi', CVarDumper::dumpAsString($urls, 3));
            }
//----------------------------------------
            if (!static::$isDSProxy) {
                if (class_exists('DSConfig', false)) {
                    static::$proxy_address = DSConfig::getVal('proxy_address');
                    static::$proxy_enabled = (DSConfig::getVal('proxy_enabled') == 1) && static::checkHost(
                        static::$proxy_address
                      );
                    static::$debug = DSConfig::getVal('site_debug') == 1;
                }
            }
            $proxy_enabled = (static::$proxy_enabled && !$direct);
//----------------------------------------
            $multi = curl_multi_init();
            $channels = [];
// Loop through the URLs, create curl-handles
// and attach the handles to our multi-request
            foreach ($urls as $url) {
                $ch = curl_init();
                $_url = static::normalizeUrl($url);
                if ($proxy_enabled) {
                    $newurl = $_url;
                    $newurl = 'http://' . static::$proxy_address . '/site/proxy?url=' . urlencode(
                        $newurl
                      ) . '&pver=' . DSGParserClass::getParserVersion(false);
                    curl_setopt($ch, CURLOPT_URL, $newurl);
                } else {
                    curl_setopt($ch, CURLOPT_URL, $_url);
                }

//!!        curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLINFO_HEADER_OUT, true);
                curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, (int) DSConfig::getVal('curl_timeout_default'));
                curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
                curl_setopt($ch, CURLOPT_NOPROGRESS, true);
                //curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
                //curl_setopt($ch, 244, 1);
                curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
                if (defined('CURLOPT_CERTINFO')) {
                    curl_setopt($ch, CURLOPT_CERTINFO, false);
                }
                curl_setopt($ch, CURLOPT_FRESH_CONNECT, false);
                //curl_setopt($ch, CURLOPT_TCP_NODELAY, false);
//---------
                if (!static::$isDSProxy) {
                    if (class_exists('DSConfig', false)) {
                        static::$proxy_http_enabled = DSConfig::getVal('proxy_http_enabled') == 1;
                        static::$proxy_http_address = DSConfig::getVal('proxy_http_address');
                    }
                } else {
                    // curl_setopt( $ch, CURLOPT_SSL_CIPHER_LIST, 'SSLv3' );
                    //curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, 'rsa_rc4_128_sha');
                    curl_setopt($ch, CURLOPT_SSLVERSION, static::$CURL_SSLVERSION);//CURL_SSLVERSION_DEFAULT
                }
                if (static::$proxy_http_enabled) {
                    curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
                    curl_setopt($ch, CURLOPT_PROXY, static::$proxy_http_address);
                    if (static::$proxy_http_auth) {
                        curl_setopt($ch, CURLOPT_PROXYUSERPWD, static::$proxy_http_auth);
                    }
                }
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//? может быть и нет
                curl_setopt($ch, CURLOPT_MAXREDIRS, 20);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                if ($referer) {
                    static::setHeaders($ch, ["Referer: " . $referer]);
                }
                curl_multi_add_handle($multi, $ch);
                $channels[$url] = new stdClass();
                $channels[$url]->ch = $ch;
                $channels[$url]->log = new DSGLog($_url, md5($cacheKey));
                if (static::$debugLog) {
                    $channels[$url]->log = $_url;
                }
            }
        } catch (Exception $e) {
            throw new Exception ('System error: curl not installed or inited', 510);
        }

// While we're still active, execute curl
        $active = null;
        $results = [];
        try {
            do {
                $mrc = curl_multi_exec($multi, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);

            while ($active && $mrc == CURLM_OK) {
                // Wait for activity on any curl-connection
                if (curl_multi_select($multi, 0.3) == -1) {
                    continue;
                }

                // Continue to exec until curl is ready to
                // give us more data
                do {
                    $mrc = curl_multi_exec($multi, $active);
                } while ($mrc == CURLM_CALL_MULTI_PERFORM);
            }

// Loop through the channels and retrieve the received
// content, then remove the handle from the multi-handle
            foreach ($channels as $i => $channel) {
                $content = curl_multi_getcontent($channel->ch);
                $results[$i] = static::fillCurlResult($channel->ch, $content);
                if (isset($proxy_enabled) && $proxy_enabled) {
                    $channel->log->DSProxy = static::$proxy_address;
                }

                if (static::$proxy_http_enabled) {
                    $channel->log->httpProxy = static::$proxy_http_address;
                }
                if (!$channel->log->result) {
                    $channel->log->result = 'OK: V1 multi from url'; //Закачано многопоточно по url
                }
                $channel->log = null;
                curl_multi_remove_handle($multi, $channel->ch);
            }
// Close the multi-handle and return our results
            curl_multi_close($multi);
            /** @noinspection PhpUnusedLocalVariableInspection */
            $endTime = microtime(true) - $startTime;
            /* foreach ($results as $res) {
                 //Utils::debugLog(round($endTime,2).': '.$res->info['size_download'].' M '.$res->info['url']);
             } */

            return $results;
        } catch (Exception $e) {
            return $results;
        }
    }

    public static function getRedirectUrl($url, $mr = 20)
    {
        /** @noinspection PhpUnusedLocalVariableInspection */
        $header = '';
        //TODO: Maybe it's not needed to initialize this
        $_url = '';
        //TODO: Maybe it's not needed to initialize this
        $newurl = '';
        $startTime = microtime(true);
        $redirected = false;
        try {
            $ch = static::getCurl($url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            if ($mr > 0) {
                $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                $originalUrl = $newurl;
                $rch = curl_copy_handle($ch);
                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
                do {
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    static::setHeaders($ch, []);
                    $header = curl_exec($rch);
                    if (curl_errno($rch)) {
                        $code = 0;
                    } else {
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                        if ($code == 301 || $code == 302) {
                            $redirected = true;
                            preg_match('/Location:(.*?)[\n\r]/i', $header, $matches);
//                $oldurl=$newurl;
                            $_url = trim(array_pop($matches));
                            if (preg_match('/http[s]*:\/\/.+?(?=\/)/i', $_url)) {
                                $newurl = $_url;
                            } else {
                                preg_match('/http[s]*:\/\/.+?(?=\/)/i', $newurl, $m);
                                $newurl = trim(array_pop($m)) . $_url;
                            }
                        } else {
                            $code = 0;
                        }
                    }
                } while ($code && --$mr);
                $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                curl_close($rch);
                /** @noinspection PhpUnusedLocalVariableInspection */
                $endTime = microtime(true) - $startTime;
                if (!$mr && $redirected) {
                    return true;
                }
            }
            return $newurl;
        } catch (Exception $e) {
            return $url;
        }
    }

    public static function normalizeUrl($url)
    {
        if (preg_match('/:\d{2,}/', $url)) {
            $protocol = 'http://';
        } else {
            $protocol = 'https://';
        }
        if (!preg_match('/^http[s]*:\/\/.+/', $url)) {
            return $protocol . preg_replace('/^\/\//', '', $url);
        } else {
            return $url;
        }
    }
}