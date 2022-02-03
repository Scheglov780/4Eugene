<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ToolsForm.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customToolsForm extends CFormModel
{

    public $captcha;
    public $category;
    public $country;
    public $email;
    public $file;
    public $order_id;
    public $question;
    public $theme;
    public $weight;

    function attributeLabels()
    {

        return [
          'file'     => Yii::t('main', 'Прикрепить файл'),
          'order_id' => Yii::t('main', 'Номер заказа (если есть)'),
          'category' => Yii::t('main', 'Категория'),
          'weight'   => Yii::t('main', 'Вес, грамм'),
          'country'  => Yii::t('main', 'Страна'),
          'theme'    => Yii::t('main', 'Тема'),
          'question' => Yii::t('main', 'Текст сообщения'),
          'email'    => 'Email, по которому с вами можно связаться',
          'captcha'  => Yii::t('main', 'Значение, или результат выражения на картинке'),
        ];
    }

    function rules()
    {
        return [
          ['weight,country', 'required', 'on' => 'calc'],
          ['weight', 'numerical', 'on' => 'calc', 'min' => 0.1],
          ['theme, question, email,captcha', 'required', 'on' => 'question'],
          [
            'file',
            'file',
            'maxSize'    => ((integer) preg_replace('/(\d+).+/is', '\1', ini_get('upload_max_filesize'))) * 1024 * 1024,
            'tooLarge'   => Yii::t('main', 'Файл должен быть меньше, чем') . ' ' . ini_get('upload_max_filesize'),
            'allowEmpty' => true,
          ],
          ['email', 'email', 'allowName' => false, 'pattern' => '/[a-z0-9\-\.\+%_]+@[a-z0-9\.\-]+\.[a-z]{2,6}/i'],
          [
            'captcha',
            'captcha',
            'allowEmpty'    => !CCaptcha::checkRequirements(),
            'captchaAction' => 'tools/captcha',
            'on'            => 'question',
          ],
        ];
    }
}