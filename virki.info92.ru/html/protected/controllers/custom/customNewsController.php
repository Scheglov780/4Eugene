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

class customNewsController extends CustomFrontController
{
    public function actionConfirm($id)
    {
        $uid = Yii::app()->user->id;
        if (($uid === false) || ($uid === null)) {
            $msg = Yii::t('main', 'Для подтверждения прочтения сообщения Вам необходимо зарегистрироваться!');
        } else {
            $res = News::confirm($id, $uid);
            $msg = Yii::t('main', 'Прочтение сообщения подтверждено!');
        }
        echo $msg;
        Yii::app()->end();
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Новости');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;

        $model = new News('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria();
        $criteria->compare('dc.val_group', 'NEWS_TYPE', false);
        $criteria->compare('dc.val_name', 'Новость', false);
        $criteria->compare('t.enabled', 1, false);
        $criteria->order =
          "absolute_order DESC NULLS LAST, confirmation_needed DESC NULLS LAST, is_confirmed_by_current_user ASC nulls first, created DESC";
        $dataProvider = $model->search($criteria, 25);

        $this->render(
          'index',
          ['dataProvider' => $dataProvider],
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