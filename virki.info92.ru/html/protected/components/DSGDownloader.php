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

class DSGDownloader extends DSGDownloaderBase
{
    private static $_instance = null;

    /**
     * @return DSGDownloaderCurl|DSGDownloaderJs
     */
    private static function instance()
    {
        if (!self::$_instance) {
            $DSGDownloader = Yii::app()->params->DSGDownloader;
            self::$_instance = $DSGDownloader;
        }
        return self::$_instance;
    }

    public static function closeDownloader()
    {
        $DSGDownloader = self::instance();
        return $DSGDownloader::closeDownloader();
    }

    public static function getHttpDocument(
      $path,
      $urlPreserved = false,
      $direct = false,
      $referer = null,
      DSGParserClass $DSGParser = null,
      $refresh = false
    ) {
        $DSGDownloader = self::instance();
        return $DSGDownloader::getHttpDocument(
          $path,
          $urlPreserved,
          $direct,
          $referer,
          $DSGParser,
          $refresh
        );
    }

    public static function getHttpDocumentArray(
      $urls,
      $direct = false,
      $referer = null,
      $cacheKey = null
    ) {
        $DSGDownloader = self::instance();
        return $DSGDownloader::getHttpDocumentArray(
          $urls,
          $direct,
          $referer,
          $cacheKey
        );
    }

    public static function getRedirectUrl($url, $mr = 20)
    {
        $DSGDownloader = self::instance();
        return $DSGDownloader::getRedirectUrl($url, $mr);
    }

    public static function name()
    {
        $DSGDownloader = Yii::app()->params->DSGDownloader;
        return $DSGDownloader;
    }

    public static function normalizeUrl($url)
    {
        $DSGDownloader = self::instance();
        return $DSGDownloader::normalizeUrl($url);
    }

}