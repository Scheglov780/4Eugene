<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="FilemanController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class FilemanController extends CustomAdminController
{

    public function actionIndex($path = false, $url = false)
    {
        $elFinderPath = Yii::getPathOfAlias('ext.elrte.lib.elfinder.php');

        include $elFinderPath . '/elFinderConnector.class.php';
        include $elFinderPath . '/elFinder.class.php';
        include $elFinderPath . '/elFinderVolumeDriver.class.php';
        include $elFinderPath . '/elFinderVolumeLocalFileSystem.class.php';
        if (!function_exists('dsAccess')) {
            function dsAccess($attr, $path, $data, $volume)
            {
                return strpos(basename($path), '.') === 0       // if file/folder begins with '.' (dot)
                  ? !($attr == 'read' || $attr == 'write')
                    // set read+write to false, other (locked+hidden) set to true
                  : null;                                    // else elFinder decide it itself
            }
        }
        $rootsArray = [];
        if ($path && $url) {
            $rootsArray[] = [
              'driver'        => 'LocalFileSystem',
                // driver for accessing file system (REQUIRED)
              'path'          => $path,
                //Yii::getPathOfAlias('webroot').'/themes/'.DSConfig::getVal('site_front_theme').'/images/banners',
              'URL'           => $url,
                //'/themes/'.DSConfig::getVal('site_front_theme').'/images/banners',
              'accessControl' => 'dsAccess',
            ];
        } else {
            $rootsArray[] = [
              'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
              'path'          => Yii::getPathOfAlias('webroot') . '/upload',         // path to files (REQUIRED)
              'URL'           => '/upload', // URL to files (REQUIRED)
              'accessControl' => 'dsAccess'             // disable and hide dot starting files (OPTIONAL)
            ];
            $rootsArray[] = [
              'driver'        => 'LocalFileSystem',   // driver for accessing file system (REQUIRED)
              'path'          => Yii::getPathOfAlias('webroot') . '/images',         // path to files (REQUIRED)
              'URL'           => '/images', // URL to files (REQUIRED)
              'accessControl' => 'dsAccess'             // disable and hide dot starting files (OPTIONAL)
            ];
            $rootsArray[] = [
              'driver'        => 'LocalFileSystem',
                // driver for accessing file system (REQUIRED)
              'path'          => Yii::getPathOfAlias('webroot') . '/themes/' . DSConfig::getVal('site_front_theme'),
                // path to files (REQUIRED)
              'URL'           => '/themes/' . DSConfig::getVal('site_front_theme'),
                // URL to files (REQUIRED)
              'accessControl' => 'dsAccess'
                // disable and hide dot starting files (OPTIONAL)
            ];
            $rootsArray[] = [
              'driver'        => 'LocalFileSystem',
                // driver for accessing file system (REQUIRED)
              'path'          => Yii::getPathOfAlias('webroot') . '/themes/' . DSConfig::getVal(
                  'site_front_theme'
                ) . '/images/banners',
                // path to files (REQUIRED)
              'URL'           => '/themes/' . DSConfig::getVal('site_front_theme') . '/images/banners',
                // URL to files (REQUIRED)
              'accessControl' => 'dsAccess'
                // disable and hide dot starting files (OPTIONAL)
            ];
        }
        $opts = [
            // 'debug' => true,
          'locale' => 'ru_RU.UTF-8',
          'roots'  => $rootsArray,
        ];

        // run elFinder
        $connector = new elFinderConnector(new elFinder($opts));
        $connector->run();
        exit;
    }

    public function actionView()
    {
        $this->renderPartial('view', [], false, true);
    }
}