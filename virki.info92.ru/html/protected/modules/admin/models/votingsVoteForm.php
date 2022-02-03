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

class votingsVoteForm extends CFormModel
{
//votings_results_id votings_id uid created result

    public $created;
    public $result;
    public $uid;
    public $votings_id;
    public $votings_results_id;

    public function attributeLabels()
    {
        return [
          'votings_results_id' => 'ID',
          'votings_id'         => 'ID голосования',
          'uid'                => 'Пользователь',
          'created'            => 'Дата подачи голоса',
          'result'             => 'Результат',
        ];
    }

    function rules()
    {
        return [
        ];
    }

}