<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SRichTextarea.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

Yii::import('ext.elrte.SElrteArea');

/**
 * Draw textarea widget
 */
class SRichTextarea extends SElrteArea
{
    public function setModel($model)
    {
        $this->model = $model;
    }
}
