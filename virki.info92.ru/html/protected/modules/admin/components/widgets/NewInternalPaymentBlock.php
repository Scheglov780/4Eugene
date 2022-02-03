<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsListBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class NewInternalPaymentBlock extends CustomWidget
{

    public $buttonHtmlOptions = [];
    public $buttonIcon = 'fa fa-cc-visa';
    public $buttonLabel = 'Новый платёж';
    public $buttonType = 'default';
    public $id = false;
    public $model = null;
    public $uid = null;
    public $yiiGridViewIdToUpdate = 'empty';
    public $yiiListViewIdToUpdate = 'empty';

    public function run()
    {
        if (!$this->model) {
            $this->model = Users::model()->findByPkEx($this->uid);
        }
        if (!$this->model) {
            echo 'Пользователь не определён!';
            Yii::app()->end();
        }
        if (!$this->id) {
            $this->id = uniqid();
        }
//=================================================================================
        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.NewInternalPaymentBlock.NewInternalPaymentBlock',
          []
        );
    }
}
