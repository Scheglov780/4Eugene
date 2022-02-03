<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleNewsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class ModuleNewsBlock extends CustomWidget
{

    public $id = false;
    public $pageSize = 25;

    public function run()
    {
        $model = new ModuleNews('Search');
        $model->unsetAttributes();
        $dataProvider = $model->search($this->pageSize);

        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.ModuleNewsBlock.ModuleNewsBlock',
          [
            'dataProvider' => $dataProvider,
            'id'           => $this->id,
          ]
        );
    }
}
