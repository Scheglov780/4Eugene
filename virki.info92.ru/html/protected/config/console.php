<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="main.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
Yii::app()->setId('0668553454'); //894a6c9c
$config = [
  'basePath'       => dirname(__FILE__) . '/..',
  'name'           => 'Platform console',
  'sourceLanguage' => 'ru',
  'language'       => 'ru',
  'charset'        => 'UTF-8',
    // autoloading model and component classes
  'import'         => [
    'application.models.custom.*',
    'application.models.*',
    'application.components.*',
  ],
  'preload'        => [
    'log',
  ],
  'components'     => [
    'messages'       => [
      'class'                  => 'DsDbMessageSource',
      'sourceMessageTable'     => 't_source_message', // по умолчанию 'SourceMessage'
      'translatedMessageTable' => 't_message', // по умолчанию 'Message'
      'cachingDuration'        => YII_DEBUG ? 0 : 3600, // кэширование
      'onMissingTranslation'   => ['TranslationEventHandler', 'handleMissingTranslation'],
    ],
    'log'            => [
      'class'  => 'CLogRouter',
      'routes' => [
        [
          'class'   => 'CFileLogRoute',
          'enabled' => YII_DEBUG,
          'levels'  => 'error, warning',
            //'levels'=>'error, warning, trace, profile, info',
        ],
        [
          'class'         => 'CProfileLogRoute',//'CWebLogRoute',
            //'enabled' => FALSE,
          'enabled'       => false,
          'levels'        => 'error, warning, profile',
          'showInFireBug' => true,
            //'levels'=>'error, warning, trace, profile, info',
        ],
      ],
    ],
    'db'             => [
      'pdoClass'           => 'NestedPDO',
      'class'              => 'DSGDbConnection',
//      'connectionString' => 'mysql:host=localhost;dbname=777',
      'connectionString'   => 'mysql:unix_socket=/var/lib/mysql/mysql.sock;dbname=777',
      'emulatePrepare'     => true,
      'persistent'         => true,
      'enableProfiling'    => false,
      'enableParamLogging' => false,
      'username'           => '777',
      'password'           => 'Q1w2e3r4t5',
      'charset'            => 'utf8',
    ],
      /*    'user' => array(
            'allowAutoLogin' => TRUE,
            'loginUrl' => '/user/login',
            'class' => 'WebUser',
            'autoRenewCookie' => true,
            'identityCookie' => array('domain' => $cookieDomain),
          ),
          'securityManager'=>array(
            'cryptAlgorithm' => 'blowfish',
            'encryptionKey' => Yii::app()->getId(),
          ),
          'request'=>array(
           // 'enableCsrfValidation'=>true,
           // 'enableCookieValidation'=>true,
          ),
      */
//=======================
    'DVTranslator'   => [
      'class' => 'application.extensions.DVTranslator.DVTranslator',
    ],
    'BingTranslator' => [
      'class' => 'application.extensions.BingTranslator.BingTranslator',
    ],
    'authManager'    => [
      'class'        => 'DVAuthManager',
      'defaultRoles' => ['guest'],
      'showErrors'   => YII_DEBUG,
    ],
    'cache'          => [
        /*      'class'=>'CMemCache',
                    'servers'=>array(
                            array(
                              'host'=>'127.0.0.1',
                            'port'=>11211,
                          'persistent'=>true,
                          ),
                        ),
                ),
        */
      'class'                => 'DSGDbCache',
      'cacheTableName'       => 'cache',
      'autoCreateCacheTable' => false,
      'connectionID'         => 'db',
      'gCProbability'        => 50000,
    ],

      /*    'cache' => array(
            'class' => 'system.caching.CApcCache',
          ),
      */
    'fileCache'      => [
        /*      'class'=>'CMemCache',
                          'servers'=>array(
                                              array(
                                  'host'=>'127.0.0.1',
                                  'port'=>11211,
                                  'persistent'=>true,
                                    ),
                            ),
        */
      'class'          => 'DSGFileCache',
      'cachePath'      => 'application.cache',
      'directoryLevel' => 1,
      'gCProbability'  => 100000,
    ],

    'imageCache' => [
      'class'          => 'system.caching.CFileCache',
      'cachePath'      => 'application.cache',
      'directoryLevel' => 1,
      'gCProbability'  => 100000,
    ],
      /*    'memCache'=>array(
            'class'=>'CMemCache',
            'servers'=>array(
              array(
                'host'=>'127.0.0.1',
                'port'=>11211,
                'persistent'=>true,
              ),
            ),
          ),
      */

//=============================================
  ],
    /*  'modules' => array(
      ),
    */
];

return $config;