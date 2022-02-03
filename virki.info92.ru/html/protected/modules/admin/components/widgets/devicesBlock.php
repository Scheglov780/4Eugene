<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CmsHistoryBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class devicesBlock extends CustomWidget
{
    /** @property Devices $devices */
    public $devices;

    public function run()
    {
        $this->render(
          'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.devicesBlock.devicesBlock',
          [
            'devices' => $this->devices,
          ]
        );
    }
}
