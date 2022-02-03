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

class CmsHistoryBlock extends CustomWidget
{

    public $contentId = '';
    public $contentLang = '';
    public $pageSize = 20;
    public $tableName = '';

    public function run()
    {
        $dataProvider =
          CmsContentHistory::getContentHistory($this->tableName, $this->contentId, $this->contentLang, $this->pageSize);
        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.CmsHistoryBlock.CmsHistoryBlock',
          [
            'dataProvider' => $dataProvider,
            'id'           => $this->tableName . '-' . $this->contentId,
          ]
        );
    }
}
