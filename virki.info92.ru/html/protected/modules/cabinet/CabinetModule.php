<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CabinetModule.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CabinetModule extends CWebModule
{

    public $defaultController = 'Main';
    public $displayedName = 'Кабинет';

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
            'cabinet.models.*',
            'cabinet.components.*',
            'cabinet.controllers.*',
          ]
        );

        //register translation messages from module dbadmin
        //so no need do add to config/main.php
        /*      Yii::app()->setComponents(
                array('messages' => array(
                  'class'=>'CPhpMessageSource',
                  'basePath'=>'protected/modules/cabinet/messages',
                )));
        */
        Yii::app()->setComponents(
          [
            'errorHandler' => [
              'errorAction' => '/cabinet/main/error',
            ],

          ]
        );

        Yii::app()->theme = 'cabinet';
    }
}
