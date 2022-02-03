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

class newsConfirmationForm extends CFormModel
{
    public $created;
    public $news_confirmations_id;
    public $news_id;
    public $result;
    public $uid;

    public function attributeLabels()
    {
        return [
          'news_confirmations_id' => 'ID',
          'news_id'               => 'ID сообщения',
          'uid'                   => 'ID пользователя',
          'created'               => 'Дата подтверждения прочтения',
          'result'                => 'Результат',
        ];
    }

    function rules()
    {
        return [
        ];
    }

}