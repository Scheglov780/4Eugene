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

class customServicesController extends CustomFrontController
{
    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Инфраструктура');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;

        $this->render(
          'index',
          [],
          false,
          false
        );
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