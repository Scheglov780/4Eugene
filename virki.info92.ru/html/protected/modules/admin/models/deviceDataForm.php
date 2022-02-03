<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="InstallForm.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class deviceDataForm extends CFormModel
{
    public $data_id;
    public $data_updated;
    public $devices_id;
    public $source;
    public $uid;
    public $value1;
    public $value2;
    public $value3;

    public function attributeLabels()
    {
        return [
          'data_id'      => 'pk',
          'source'       => 'Источник',
          'devices_id'   => 'ID прибора',
          'data_updated' => 'Дата показаний',
          'value1'       => 'V1',
          'value2'       => 'V2',
          'value3'       => 'V3',
          'uid'          => 'ID пользователя',
        ];
    }

    function rules()
    {
        return [
          ['value1,value2,value3', 'numerical'],
        ];
    }

}