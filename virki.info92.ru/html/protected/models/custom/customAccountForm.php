<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="AccountForm.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customAccountForm extends CFormModel
{

    public $id_account;
    public $password;
    public $summ;

    function attributeLabels()
    {
        return [
          'id_account' => Yii::t('main', 'Номер счета в формате XXXX-XXXX') . ':',
          'summ'       => Yii::t('main', 'Сумма') . '(' . DSConfig::getVal('site_currency') . '):',
          'password'   => Yii::t('main', 'Ваш пароль') . ':',
        ];
    }

    function rules()
    {
        return [
          ['id_account,summ,password', 'required', 'on' => 'transfer'],
          ['summ', 'numerical'],
        ];
    }

}


