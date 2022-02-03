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

class Cabinet2Module extends CWebModule
{
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
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(
          [
            'cabinet2.models.*',
            'cabinet2.models.custom.*',
            'cabinet2.components.*',
            'cabinet2.controllers.*',
            'cabinet2.controllers.custom.*',
          ]
        );
    }
}
