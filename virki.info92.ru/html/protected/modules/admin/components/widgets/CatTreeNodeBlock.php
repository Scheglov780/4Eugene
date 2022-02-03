<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CatTreeNodeBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CatTreeNodeBlock extends CustomWidget
{

    public $lang = 'ru';
    public $nodeData = false;

    public function run()
    {
        if ($this->nodeData) {
            $this->render(
              'application.modules.' .
              Yii::app()->controller->module->id .
              '.views.widgets.CatTreeNodeBlock.CatTreeNodeBlock',
              [
                'nodeData' => $this->nodeData,
                'lang'     => $this->lang,
              ]
            );
        };
    }
}
