<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 * Используйте $debug=true для включения отладки
 **********************************************************************************************************************/
?>
<?php
//phpinfo();die;
//$debug = (preg_match('/virki\-2\.spb\.ru/iu', $_SERVER['SERVER_NAME']) || false);
$debug = (isset($_COOKIE['XDEBUG_SESSION']) && ($_COOKIE['XDEBUG_SESSION'] == 'Alexy_virki'));
define('JQUERY_MIGRATE', false);
//define('DEBUG_MENU', true); //Don't forgot to comment this string then menu debugging complete!!!
if ($debug) {
    error_reporting(E_ALL);
    define('YII_PROFILING', false); //TRUE - to enable profiler
    defined('FORCE_XDEBUG') or define('FORCE_XDEBUG', true);
    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_DEBUG_SHOW_PROFILER') or define('YII_DEBUG_SHOW_PROFILER', true);
    //enable profiling
    defined('YII_DEBUG_PROFILING') or define('YII_DEBUG_PROFILING', true);
    //trace level
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
    //execution time
    defined('YII_DEBUG_DISPLAY_TIME') or define('YII_DEBUG_DISPLAY_TIME', true);
    require_once(dirname(__FILE__) . '/../framework/yii.php');
} else {
    define('YII_PROFILING', false);
    defined('YII_DEBUG') or define('YII_DEBUG', false);
    require_once(dirname(__FILE__) . '/../framework/yiilite.php');
}

$configFile = dirname(__FILE__) . '/protected/config/main.php';
$app = Yii::createWebApplication($configFile);
$isAjaxForce = preg_match('/^(?:data|item\d|img\d)\.+/is', $_SERVER['HTTP_HOST']);
if (!($isAjaxForce || Yii::app()->request->isPostRequest || Yii::app()->request->isAjaxRequest)) {
    $requestURL = Yii::app()->request->getRequestUri();
    if (!preg_match('/\/(under|api)(?:\/|$)/is', $requestURL)) {
        $site_under_construction = DSConfig::getVal('site_under_construction');
        $skipUnderConstruction = Yii::app()->user->inRole('superAdmin');
        if ((!isset($site_under_construction) || $site_under_construction) && !$skipUnderConstruction) {
            defined('DS_UNDER_CONSTRUCTION') or define('DS_UNDER_CONSTRUCTION', true);
        } else {
            defined('DS_UNDER_CONSTRUCTION') or define('DS_UNDER_CONSTRUCTION', false);
        }
        if (DS_UNDER_CONSTRUCTION) {
            $isAdmin = ((strpos($requestURL, '/admin') !== false) || (strpos(
                  $requestURL,
                  '/message'
                ) !== false) || (strpos($requestURL, '/img/index') !== false) || (strpos(
                  $requestURL,
                  '/cabinet/balance'
                ) !== false));
            if ($isAdmin === false) {
                if (($requestURL != '/user/login') && ($requestURL != '/cabinet')) {
                    $app->catchAllRequest = ['/under/index'];
                }
            }
        }
    }
}
$app->run();