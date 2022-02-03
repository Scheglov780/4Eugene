<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CustomCabinetController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CustomCabinetController extends CustomController
{

    function __construct($id, $module = null)
    {
        $preg = '/(?<!img\d\.)' . str_replace('.', '\.', DSConfig::getVal('site_domain')) . '/i';
        $baseUrl = Yii::app()->getBaseUrl(true);
        if (preg_match($preg, $baseUrl)) {
            $langRegexp = '/\/(' . trim(str_replace(',', '|', DSConfig::getVal('site_language_block'))) . ')\//i';
            if (isset(Yii::app()->request->cookies['front_lang'])) {
                Yii::app()->language = Yii::app()->request->cookies['front_lang']->value;
            } elseif (preg_match($langRegexp, Yii::app()->request->requestUri, $langMatches)) {
                Yii::app()->language = $langMatches[1];
            } else {
                $prefLang = Yii::app()->request->getPreferredLanguage();
                $prefLang = substr($prefLang, 0, 2);
                $langs = explode(',', DSConfig::getVal('site_language_supported'));
                if (in_array($prefLang, $langs)) {
                    Yii::app()->language = $prefLang;
                } else {
                    Yii::app()->language = $langs[0];
                }
            }
            $languages = explode(',', DSConfig::getVal('site_language_block'));
            if (!in_array(Yii::app()->language, $languages)) {
                if (count($languages)) {
                    Yii::app()->language = $languages[0];
                } else {
                    Yii::app()->language = Yii::app()->sourceLanguage;
                }
            }
            if ((Yii::app()->getBaseUrl(true) == 'http://' . DSConfig::getVal('site_domain'))
              || (Yii::app()->getBaseUrl(true) == 'https://' . DSConfig::getVal('site_domain'))
            ) {
                if ((!isset(Yii::app()->request->cookies['front_lang'])) ||
                  (Yii::app()->language !== Yii::app()->request->cookies['front_lang']->value)) {
                    $cookie = new CHttpCookie(
                      'front_lang',
                      Yii::app()->language,
                      ['domain' => '.' . DSConfig::getVal('site_domain')]
                    );
                    $cookie->expire = time() + 60 * 60 * 24 * 180;
                    Yii::app()->request->cookies['front_lang'] = $cookie;
                }
            }
//=================================
//        SiteLog::doHttpLog();
//=================================
        }

        //so no need do add to config/main.php
        $this->manager = (Yii::app()->user->checkAccess($module->id . '/main/*')) ? 0 : Yii::app()->user->id;
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
    }

    private $_ifModifiedSince;
    private $_isSendLastModified = false;
    public $breadcrumbs = [];
    public $manager = '';
    public $menu = [];
    public $meta_desc = '';
    public $meta_keyword = '';
    public $params = [];

    /**
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param CAction $action the action just executed.
     */
    protected function afterAction($action)
    {
        if ($this->id == 'img' && $this->action = 'index') {
            return;
        }
//=================================
        //SiteLog::doHttpLog();
//=================================
        parent::afterAction($action);
    }

    public function filters()
    {
        return [
          ['application.components.RightsFilter'],
          ['application.components.AjaxRenderFilter'],
          ['application.components.PostprocessFilter'],
        ];
    }

//=========================================================================

    public function init()
    {
//      header('Access-Control-Allow-Origin: *');
        $userId = Yii::app()->user->id;
        if ($userId != null) {
            $user = Users::model()->findByPk($userId);
            if (($user === false) || ($user == null)) {
                Yii::app()->user->logout();
                Yii::app()->user->clearStates();
            }
        }
        // @todo: может быть, это нужно
        // $this->pageTitle = '';
        parent::init();
    }

}

