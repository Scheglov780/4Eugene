<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ItemController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/*
 * Контроллер для работы с товаром.
 */

class customBlanksController extends CustomFrontController
{
    public function actionBill($code = null)
    {
        if (!Yii::app()->user->id) {
            throw new CHttpException(404, 'Документ  не найден!');
            Yii::app()->end();
        }
        $this->pageTitle = 'Форма ПД-4';
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;
        $bill = (new Bills('search'))->searchRecord("t.code ='{$code}'");
        if ($bill) {
            $result = $this->renderPartial(
              'bill',
              ['bill' => $bill],
              true,
              false
            );
            echo $result;
        } else {
            throw new CHttpException(404, 'Документ  не найден!');
        }
    }

    public function filters()
    {
        if (AccessRights::GuestIsDisabled()) {
            return array_merge(
              [
                'Rights', // perform access control for CRUD operations
              ],
              parent::filters()
            );
        } else {
            return parent::filters();
        }
    }
}