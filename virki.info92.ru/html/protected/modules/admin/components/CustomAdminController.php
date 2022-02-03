<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CustomAdminController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CustomAdminController extends CustomController
{

    function __construct($id, $module = null, $view_admin = null)
    {
        // Yii::app()->language='en';
        //register translation messages from module dbadmin
        $langRegexp = '/\/(' . trim(str_replace(',', '|', DSConfig::getVal('site_language_block'))) . ')\//i';
        if (isset(Yii::app()->request->cookies['admin_lang'])) {
            Yii::app()->language = Yii::app()->request->cookies['admin_lang']->value;
        } elseif (preg_match($langRegexp, Yii::app()->request->requestUri, $langMatches)) {
            Yii::app()->language = $langMatches[1];
        } else {
            $langs = explode(',', DSConfig::getVal('site_language_supported'));
            Yii::app()->language = $langs[0];
        }
        if ((Yii::app()->getBaseUrl(true) == 'http://' . DSConfig::getVal('site_domain'))
          || (Yii::app()->getBaseUrl(true) == 'https://' . DSConfig::getVal('site_domain'))
        ) {
            if ((!isset(Yii::app()->request->cookies['admin_lang'])) ||
              (Yii::app()->language !== Yii::app()->request->cookies['admin_lang']->value)) {
                $cookie = new CHttpCookie('admin_lang', Yii::app()->language);
                $cookie->expire = time() + 60 * 60 * 24 * 180;
                Yii::app()->request->cookies['admin_lang'] = $cookie;
            }
        }

        //so no need do add to config/main.php
        $this->manager = (Yii::app()->user->checkAccess($module->id . '/main/*')) ? 0 : Yii::app()->user->id;
//======================
//      if ($id<>'main') {
//      Yii::app()->clientscript->scriptMap['jquery.js'] = false;
//      Yii::app()->clientscript->scriptMap['jquery.min.js'] = false;
//      Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
        /*      }else {
                Yii::app()->clientscript->scriptMap['jquery.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery.min.js'] = false;
                Yii::app()->clientscript->scriptMap['jquery-ui.min.js'] = false;
              }
        */
//======================
//--      Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl .'/themes/admin/css/'.'easyui.css');
//--      Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl .'/themes/admin/css/'.'icon.css');
//      Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl .'/themes/admin/css/'.'pager.css');
//--      Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl .'/themes/admin/js/'.'jquery.easyui.min.js',CClientScript::POS_END);
//--      Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl .'/themes/admin/js/'.'easyui-lang-ru.js',CClientScript::POS_END);
//       Yii::app()->clientScript->registerCoreScript('jquery');
        Yii::app()->clientScript->registerScriptFile(
          Yii::app()->request->baseUrl . '/themes/' . $module->id . '/js/' . 'ds.admin.logic.js',
          CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
          Yii::app()->request->baseUrl . '/themes/' . $module->id . '/js/' . 'ds.admin.interface.js',
          CClientScript::POS_END
        );
        Yii::app()->clientScript->registerScriptFile(
          Yii::app()->request->baseUrl . '/themes/' . $module->id . '/js/' . 'ds.admin.item.js',
          CClientScript::POS_END
        );

        parent::__construct($id, $module);

//        echo '<pre>';
//        print_r($_GET);
//        echo '</pre>';
//        die();
    }

    public $breadcrumbs = [];
    public $manager = '';
    public $menu = [];

    public function filters()
    {
        return [
          ['application.components.RightsFilter'],
          ['application.components.AjaxRenderFilter'],
          ['application.components.PostprocessFilter'],
        ];
    }

    public function init()
    {
//      header('Access-Control-Allow-Origin: *');
        parent::init();
    }

}

