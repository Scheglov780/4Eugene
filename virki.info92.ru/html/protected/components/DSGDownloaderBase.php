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

/* Класс, реализующий работу с библиотекой curl с некоторыми
   специфическими особенностями.                                               */

abstract class DSGDownloaderBase
{
    protected static $_lastIp = false;
    protected static $checkProxyResult = null;
    protected static $checkRemoteTranslatorResult = null;
    /** Адрес и порт http-proxy для обращений к сайту-источнику или к DSG-прокси.
     * Например, 'proxy.test.com:8080'
     * Работает в паре с параметром proxy_http_enabled
     * @var string
     */
    protected static $proxy_http_address = '10.0.0.1:3128';
    protected static $proxy_http_auth = '';
    /**
     * Использовать ли http-proxy для обращений к сайту-источнику или к DSG-прокси.
     * Работает в паре с параметром proxy_http_address
     * @var bool
     */
    protected static $proxy_http_enabled = false;
    /**
     * Работает ли класс на стороне DSProxy
     * @var bool
     */
    public static $isDSProxy = false;

    public static abstract function closeDownloader();

    public static abstract function getHttpDocument(
      $path,
      $urlPreserved = false,
      $direct = false,
      $referer = null,
      DSGParserClass $DSGParser = null,
      $refresh = false
    );

    public static abstract function getHttpDocumentArray(
      $urls,
      $direct = false,
      $referer = null,
      $cacheKey = null
    );

    public static abstract function getRedirectUrl($url, $mr = 20);

    public static abstract function normalizeUrl($url);

    protected static function getIpFromPool()
    {
        $curl_ip_pool = DSConfig::getVal('curl_ip_pool', false);
        if (!$curl_ip_pool) {
            return false;
        }
        $poolArray = preg_split('/[\s,;\r\n]+/', $curl_ip_pool);
        $ip = false;
        if ($poolArray && is_array($poolArray) && count($poolArray)) {
            $ip = $poolArray[array_rand($poolArray)];
        }
        static::$_lastIp = $ip;
        return $ip;
    }

    public static function checkHost($address, $timeout = 7, $refresh = false)
    {
        $cacheKey = 'checkHost-' . $address;

        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get($cacheKey);
        } else {
            $cache = @Yii::app()->cache->get($cacheKey);
        }
        if ($cache === false || $refresh) {
            $host = preg_replace('/:.+$/s', '', $address);
            if (preg_match('/:/', $address)) {
                $port = preg_replace('/^.+:/s', '', $address);
            } else {
                $port = 80;
            }
            $connection = @fsockopen($host, $port, $errno, $errstr, $timeout);
            if (!$connection) // attempt to connect
            {
                $result = 0;
            } else {
                if ($connection) {
                    @fclose($connection); //close connection
                }
                $result = 1;
            }
            if (isset(Yii::app()->memCache)) {
                @Yii::app()->memCache->set($cacheKey, $result, 180);
            } else {
                @Yii::app()->cache->set($cacheKey, $result, 180);
            }
        } else {
            $result = $cache;
        }
        return $result;
    }

    public static function checkProxy($refresh = false)
    {
        $result = 'OK';
        if (static::$isDSProxy) {
            return $result;
        }

        if (static::$checkProxyResult) {
            return static::$checkProxyResult;
        }

        $proxyAddress = DSConfig::getVal('proxy_address');
        $proxyEnabled = DSConfig::getVal('proxy_enabled');
        if ($proxyEnabled != 1) {
            $result = Yii::t(
              'admin',
              'DropShop proxy не используется. Вы можете включить proxy параметром настройки proxy_enabled'
            );
            static::$checkProxyResult = $result;
            return $result;
        }
        $cacheKey = 'cache-checkProxy-' . $proxyAddress;
        $useMemcache = isset(Yii::app()->memCache);
        if ($useMemcache) {
            $cache = @Yii::app()->memCache->get($cacheKey);
        } else {
            $cache = @Yii::app()->cache->get($cacheKey);
        }
        if (!$cache || $refresh) {

            $isProxyHostConnected = static::checkHost($proxyAddress, 7, $refresh);
            if (!$isProxyHostConnected) {
                $result = Yii::t(
                  'admin',
                  'Невозможно подключиться к DropShop proxy. Вы можете настройить proxy параметром настройки proxy_address'
                );
                static::$checkProxyResult = $result;
            } else {
                $url = 'http://' . $proxyAddress . '/site/proxy?cmd=checkAccess';
//======================================================================================
                $ch = curl_init($url);
                curl_setopt($ch, CURLINFO_HEADER_OUT, false);
                curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 7);//120
                curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
                curl_setopt($ch, CURLOPT_NOPROGRESS, true);
                curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
//======================================================================================
                $result = curl_exec($ch);
                curl_close($ch);
                if ($result != 'OK') {
                    $result = Yii::t(
                      'admin',
                      'Сайт не зарегистрирован на выбранном в конфигурации proxy, доступ запрещён, или нет действующих тарифов.'
                    );
                    static::$checkProxyResult = $result;
                }
            }
            //if ($result == 'OK') {
            if ($useMemcache) {
                @Yii::app()->memCache->set($cacheKey, $result, 180);
            } else {
                @Yii::app()->cache->set($cacheKey, $result, 600);
            }
            //}
        } else {
            $result = $cache;
        }
        static::$checkProxyResult = $result;
        return $result;
    }

    public static function checkRemoteTranslator($refresh = false)
    {
        $result = 'OK';
        if (static::$isDSProxy) {
            return $result;
        }
        if (static::$checkRemoteTranslatorResult) {
            return static::$checkRemoteTranslatorResult;
        }

        $proxyUrl = DSConfig::getVal('translator_block_mode_url');
        if (preg_match('/^(http[s]*:\/\/)*(.*?)\//s', $proxyUrl, $matches)) {
            $proxyProtocol = $matches[1];
            $proxyAddress = $matches[2];
        } else {
            $proxyProtocol = '';
            $proxyAddress = '';
        }
        $proxyEnabled = DSConfig::getVal('translator_block_mode_enabled');
        if ($proxyEnabled != 1) {
            $result = Yii::t(
              'admin',
              'DropShop Translator не используется. Вы можете включить переводчик параметром настройки translator_block_mode_enabled'
            );
            static::$checkRemoteTranslatorResult = $result;
            return $result;
        }
        $cacheKey = 'cache-checkRemoteTranslator-' . $proxyAddress;
        $useMemcache = isset(Yii::app()->memCache);
        if ($useMemcache) {
            $cache = @Yii::app()->memCache->get($cacheKey);
        } else {
            $cache = @Yii::app()->cache->get($cacheKey);
        }
        if (!$cache || $refresh) {
            $isProxyHostConnected = static::checkHost($proxyAddress, 7, $refresh);
            if (!$isProxyHostConnected) {
                $result = Yii::t(
                  'admin',
                  'Невозможно подключиться к DropShop Translator. Вы можете настройить переводчик параметром настройки proxy_address'
                );
                static::$checkRemoteTranslatorResult = $result;
            } else {
                $url = ($proxyProtocol ? $proxyProtocol : 'http://') . $proxyAddress . '/site/proxy?cmd=checkAccess';
//======================================================================================
                $ch = curl_init($url);
                curl_setopt($ch, CURLINFO_HEADER_OUT, false);
                curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                curl_setopt($ch, CURLOPT_TIMEOUT, 7);//120
                curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
                curl_setopt($ch, CURLOPT_NOPROGRESS, true);
                curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
                curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
//======================================================================================
                $result = curl_exec($ch);
                curl_close($ch);
                if ($result != 'OK') {
                    $result = Yii::t(
                      'admin',
                      'Сайт не зарегистрирован на выбранном в конфигурации переводчике, доступ запрещён, или нет действующих тарифов.'
                    );
                    static::$checkRemoteTranslatorResult = $result;
                }
            }
            //if ($result == 'OK') {
            if ($useMemcache) {
                @Yii::app()->memCache->set($cacheKey, $result, 180);
            } else {
                @Yii::app()->cache->set($cacheKey, $result, 600);
            }
            //}
        } else {
            $result = $cache;
        }
        static::$checkRemoteTranslatorResult = $result;
        return $result;
    }

}