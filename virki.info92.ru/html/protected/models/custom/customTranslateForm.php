<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="TranslateForm.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customTranslateForm extends CFormModel
{
    public $from;
    public $global;
    public $host;
    public $id;
    public $message;
    public $mode;
    public $pinned;
    public $source;
    public $to;
    public $type;
    public $url;
    public $userid;

    public function attributeLabels()
    {
        return [
          'type'    => Yii::t('main', 'Тип') . ':',
          'mode'    => Yii::t('main', 'Длинный текст') . ':',
          'id'      => 'ID:',
          'from'    => Yii::t('main', 'Язык оригинала') . ':',
          'to'      => Yii::t('main', 'Язык перевода') . ':',
          'userid'  => Yii::t('main', 'ID оператора') . ':',
          'url'     => Yii::t('main', 'URL') . ':',
          'global'  => Yii::t('main', 'Изменить все вхождения'),
          'pinned'  => Yii::t('main', 'Зафиксировать'),
          'source'  => Yii::t('main', 'Оригинал') . ':',
          'message' => Yii::t('main', 'Перевод') . ':',
        ];
    }

    public function rules()
    {
        return [
          ['type, mode, id, from, to, userid, host, url, source, message, global, pinned', 'required'],
            //array('phone', 'safe'),
        ];
    }
}