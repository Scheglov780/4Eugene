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
defined('SQL_NO_WITH') or define('SQL_NO_WITH', false);

Yii::app()->setId('0668553454-778'); //894a6c9c
//Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
Yii::setPathOfAlias('booster', dirname(__FILE__) . '/../extensions/Yiibooster');
Yii::setPathOfAlias('chartjs', dirname(__FILE__) . '/../extensions/yii-chartjs');
Yii::setPathOfAlias('nlac', dirname(__FILE__) . '/../extensions/NLSClientScript');
//  httpful bootstrap execution
// require(dirname(__FILE__)."/protected/components/httpful/bootstrap.php");
$cookieDomain = '.virki-2.spb.ru';
$config = [
  'basePath'       => dirname(__FILE__) . '/..',
  'name'           => 'ВИРКИ2:SMART',
  'theme'          => '', // Для указания темы(шаблона) используйте параметр config.site_front_theme в БД
  'sourceLanguage' => 'ru',
  'language'       => 'ru',
  'charset'        => 'UTF-8',
    // autoloading model and component classes
  'import'         => [
    'application.controllers.custom.*',
    'application.models.custom.*',
    'application.models.*',
    'application.components.*',
    'application.components.widgets.custom.*',
  ],
  'preload'        => [
    'log',
  ],
  'components'     => [
    'session'         => [
//      'class' => 'CHttpSession',
      'timeout' => 300,
//      'cookieParams' => array('domain' => $cookieDomain),
    ],
    'messages'        => [
      'class'                  => 'DsDbMessageSource',
      'sourceMessageTable'     => 't_source_message', // по умолчанию 'SourceMessage'
      'translatedMessageTable' => 't_message', // по умолчанию 'Message'
      'cachingDuration'        => YII_DEBUG ? 0 : 3600, // кэширование
      'onMissingTranslation'   => ['TranslationEventHandler', 'handleMissingTranslation'],
    ],
    'widgetFactory'   => [
      'widgets' => [
        'CGridView'   => [
          'cssFile' => false,
          'pager'   => ['cssFile' => false],
        ],
        'CListView'   => [
          'cssFile' => false,
          'pager'   => ['cssFile' => false],
        ],
        'CTreeView'   => [
          'cssFile' => false,
        ],
        'CDetailView' => [
          'cssFile' => false,
            //'pager'=>array('cssFile' => false),
        ],
        'CLinkPager'  => [
            //               'cssFile'=>false,

          'nextPageLabel' => '>',
          'prevPageLabel' => '<',
          'header'        => '',
        ],

      ],
    ],
    'log'             => [
      'class'  => 'CLogRouter',
      'routes' => [
        [
          'class'   => 'CFileLogRoute',
          'enabled' => YII_DEBUG,
          'levels'  => 'error, warning',
            //  'levels'=>'error, warning, trace, profile, info',
        ],
        [
          'class'         => 'CProfileLogRoute',//'CWebLogRoute',
            //'enabled' => true,
          'enabled'       => YII_PROFILING,
          'levels'        => 'error, warning, profile',
          'showInFireBug' => false,
            //'levels'=>'error, warning, trace, profile, info',
        ],
        [
          'class'   => 'CWebLogRoute',
          'enabled' => YII_DEBUG,
          'levels'  => 'error',
        ],
      ],
    ],
    'db'              => [
      'pdoClass'              => 'NestedPDO',
      'class'                 => 'DSGDbConnection',
//      'connectionString' => 'mysql:host=localhost;dbname=info92',
      'connectionString'      => 'pgsql:host=127.0.0.1;port=5432;dbname=virki',
        //'emulatePrepare'        => false,
      'persistent'            => true,
      'enableProfiling'       => YII_PROFILING,
      'enableParamLogging'    => YII_PROFILING,
      'username'              => 'virki',
      'password'              => '**********',
      'charset'               => 'utf8',
//      'nullConversion' => PDO::NULL_EMPTY_STRING,
      'schemaCachingDuration' => (YII_DEBUG ? 0 : 3600),
    ],
    'user'            => [
      'allowAutoLogin'  => true,
      'loginUrl'        => '/user/login',
      'class'           => 'WebUser',
      'autoRenewCookie' => true,
      'identityCookie'  => ['domain' => $cookieDomain],
    ],
    'securityManager' => [
      'cryptAlgorithm' => 'blowfish',
      'encryptionKey'  => Yii::app()->getId(),
    ],
    'request'         => [
        // 'enableCsrfValidation'=>true,
        // 'enableCookieValidation'=>true,
    ],
    'urlManager'      => [
      'class'          => 'CUrlManager',
      'urlFormat'      => 'path',
      'showScriptName' => false,
      'rules'          => [
        [
          (file_exists('webroot' . '/sitemap.xml')) ? '/sitemap.xml' : 'site/sitemap',
          'pattern'   => 'sitemap.xml',
          'urlSuffix' => '',
        ],
        [
          (file_exists('webroot' . '/sitemap2ya.xml')) ? '/sitemap2ya.xml' : 'site/sitemap2ya',
          'pattern'   => 'sitemap2ya.xml',
          'urlSuffix' => '',
        ],
        [
          'class' => 'application.components.langUrlRule',
        ],
      ],
    ],

    'clientScript'       => [
      'class' => 'nlac\NLSClientScript',
        //'excludePattern' => '/\.tpl/i', //js regexp, files with matching paths won't be filtered is set to other than 'null'
        //'includePattern' => '/\.php/', //js regexp, only files with matching paths will be filtered if set to other than 'null'

      'mergeJs'          => false,
        //true, //def:true
      'compressMergedJs' => false,
        //def:false

      'mergeCss'          => false,
        //def:true
      'compressMergedCss' => false,
        //def:false

      'mergeJsExcludePattern' => '/edit_area/',
        //won't merge js files with matching names

      'mergeIfXhr'            => false,
        //true, //def:false, if true->attempts to merge the js files even if the request was xhr (if all other merging conditions are satisfied)

        //'serverBaseUrl' => 'http://localhost', //can be optionally set here
      'mergeAbove'            => 1,
        //def:1, only "more than this value" files will be merged,
      'curlTimeOut'           => 30,
        //def:10, see curl_setopt() doc
      'curlConnectionTimeOut' => 30,
        //def:10, see curl_setopt() doc

      'appVersion' => 0.998
        //if set, it will be appended to the urls of the merged scripts/css
    ],

// LESS compiler support
    'assetManager'       => [
      'class'            => 'application.extensions.EAssetManager',
      'lessCompile'      => true,
      'lessCompiledPath' => null,//'webroot.assets'
      'lessFormatter'    => (YII_DEBUG ? 'classic' : 'compressed'),
      'lessForceCompile' => false,//YII_DEBUG
    ],

//=======================
      /**
       * Class CApplication
       * @property DVTranslator DVTranslator
       */
    'DVTranslator'       => [
      'class' => 'application.extensions.DVTranslator.DVTranslator',
    ],
    'ExternalTranslator' => [
      'class' => 'application.extensions.ExternalTranslator.ExternalTranslator',
    ],
    'authManager'        => [
      'class'        => 'DVAuthManager',
      'defaultRoles' => ['guest'],
      'showErrors'   => YII_DEBUG,
    ],
    'cache'              => [
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
    'fileCache'          => [
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
    'memCache'   => [
      'class'        => 'CMemCache',
      'useMemcached' => true,
      'servers'      => [
        [
          'host'       => '127.0.0.1',
          'port'       => 11211,
          'persistent' => true,
        ],
      ],
    ],
//=============================================
  ],
  'modules'        => [
    'gii' => [
      'class'          => 'system.gii.GiiModule',
      'password'       => '**********',
      'ipFilters'      => ['**********'],
      'newFileMode'    => 0666,
      'newDirMode'     => 0777,
      'generatorPaths' => [
          //'bootstrap.gii',
        'ext.ajaxgii',
      ],
    ],
      // 'apcinfo',
    'admin',
    'cabinet',
    'cabinet2',
  ],
  'params'         => [
    'DSGDownloader' => 'DSGDownloaderCurl',//'DSGDownloaderJs',
  ],
];
if (isset($_SERVER['SCRIPT_URI']) && $_SERVER['SCRIPT_URI']) {
    $url = $_SERVER['SCRIPT_URI'];
} elseif (isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']) {
    $url = $_SERVER['REQUEST_URI'];
} else {
    $url = '';
}
// img subdomain session disable
if (preg_match('/^http[s]*:\/\/img\d\./i', $url)) {
    ini_set("session.use_cookies", 0);
    ini_set("session.use_only_cookies", 1);
    ini_set("session.use_trans_sid", 0);
    $config['components']['user']['allowAutoLogin'] = false;
    $config['components']['session'] = [
      'autoStart'  => false,
      'cookieMode' => 'none',
    ];
}
//=== Workarounds for bootstrap ========================================================================================
$useNewBootstrap = true;
//======================================================================================================================
/*
ВНИМАНИЕ! ACHTUNG! ATTANTION!
Ежели дефолтная тема сайта использует bootstrup3: $useNewBootstrap = true;
*/
$config['components']['booster'] = [
  'class'          => 'booster.components.Booster',

    /*	'enableCdn' => false,
        'coreCss' => true,
        'bootstrapCss' => true,
        'responsiveCss' => true,
        'disableZooming' => false,
        'fontAwesomeCss' => false,
        'yiiCss' => true,
        'jqueryCss' => true,
        'enableJS' => true,
        'enableBootboxJS' => true,
        'enableNotifierJS' => true,
        'ajaxCssLoad' => false,
        'ajaxJsLoad' => false,
        'forceCopyAssets' => false,
        'enablePopover' => true,
        'enableTooltip' => true,
        'minify' => !(bool) YII_DEBUG,
    */
  'fontAwesomeCss' => true,
  'jqueryCss'      => true,
  'enablePopover'  => false,
  'enableTooltip'  => true,
  'minify'         => !(bool) YII_DEBUG,
];
$config['import'][] = 'application.extensions.Yiibooster.widgets.TbPager';
$config['preload'][] = 'booster';
//======================================================================================================================

//if (!preg_match('/\/panel\//i',$url)||TRUE) {
$config['components']['errorHandler'] = ['errorAction' => '/site/error',];
//}
//CVarDumper::dump($config,10,true); die;
return $config;
