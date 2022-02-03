<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="AdminModule.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class AdminModule extends CWebModule
{
    public $defaultController = 'Main';
    public $displayedName = 'Управление';

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        } else {
            return false;
        }
    }

    public function init()
    {
        $this->setImport(
          [
            'admin.models.*',
            'admin.components.*',
            'admin.controllers.*',
          ]
        );

        //register translation messages from module dbadmin
        //so no need do add to config/main.php
        /*      Yii::app()->setComponents(
                array('messages' => array(
                  'class'=>'CPhpMessageSource',
                  'basePath'=>'protected/modules/admin/messages',
                )));
        */
        Yii::app()->setComponents(
          [
            'errorHandler' => [
              'errorAction' => '/admin/main/error',
            ],

          ]
        );

        Yii::app()->theme = 'admin';
    }
}
