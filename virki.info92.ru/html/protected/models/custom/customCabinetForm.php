<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CabinetForm.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customCabinetForm extends CFormModel
{

    public $category;
    public $email;
    /*
     * Имя
     * @var string
     */
    public $file;
    public $fullname;
    public $is_delivery_point;

    //password reset
    public $new_password;
    public $new_password2;
    public $order_id;
    public $password;
    public $phone;

    //support
    public $promo_code;
    public $publicAccount;
    public $region;
    public $sum;
    public $text;
    public $theme;

    function attributeLabels()
    {
        return [
          'category'          => Yii::t('main', 'Категория'),
          'region'            => Yii::t('main', 'Регион'),
          'sum'               => Yii::t('main', 'Сумма платежа в учетной валюте сайта') . ' (' . strtoupper(
              DSConfig::getVal('site_currency')
            ) . ')',
          'fullname'          => Yii::t('main', 'Имя'),
          'email'             => Yii::t('main', 'Новый E-mail'),
          'password'          => Yii::t('main', 'Текущий пароль'),
          'new_password'      => Yii::t('main', 'Новый пароль'),
          'new_password2'     => Yii::t('main', 'Повторите новый пароль'),
          'phone'             => Yii::t('main', 'Моб. тел. +XXXXXXXXXXX'),
          'theme'             => Yii::t('main', 'Тема'),
          'text'              => Yii::t('main', 'Текст сообщения'),
          'order_id'          => Yii::t('main', 'Номер заказа (если есть)'),
          'file'              => Yii::t('main', 'Прикрепить файл'),
          'promo_code'        => Yii::t('main', 'Промо-код'),
          'is_delivery_point' => Yii::t('main', 'Офис'),
        ];
    }

    public function onUnsafeAttribute($name, $value)
    {
        //silently ignore unsafe attributes
    }

    function rules()
    {
        return [
          ['sum', 'required', 'on' => 'payment'],
          ['sum', 'numerical', 'on' => 'payment'],
          ['publicAccount', 'required', 'on' => 'payment'],

          ['fullname,password', 'required', 'on' => 'profile'],
            //array('password','exist', 'on'=>'profile','className'=>'Users'), //d_birth,m_birth,y_birth,
          ['phone,promo_code,is_delivery_point', 'safe'],

          ['email,password', 'required', 'on' => 'email'],
          ['email', 'email', 'allowName' => false, 'pattern' => '/[a-z0-9\-\.\+%_]+@[a-z0-9\.\-]+\.[a-z]{2,6}/i'],

          ['password,new_password,new_password2', 'required', 'on' => 'password'],
          ['new_password2', 'compare', 'compareAttribute' => 'new_password', 'on' => 'password'],

          ['phone,fullname', 'required', 'on' => 'address'],
          ['theme,text,category', 'required', 'on' => 'support'],
          [
            'file',
            'file',
            'maxSize'    => 1 * 1024 * 1024,
            'tooLarge'   => Yii::t('main', 'Файл должен быть меньше, чем 1MB'),
            'allowEmpty' => true,
          ],
            //array('order_id,file','exist','on'=>'support','className'=>'Users'),
          ['phone', 'required', 'on' => 'createaddress'],
        ];
    }
}