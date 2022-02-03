<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ProfileController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class ProfileController extends CustomCabinetController
{
    public $breadcrumbs;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form_id)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form_id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /** @param Users $model */
    protected function performValidation($model)
    {
        if (!$model->email) {
            $model->addError('new_email', 'Укажите email для связи с Вами');
        }
        if (!$model->phone) {
            $model->addError('phone', 'Укажите телефон для связи с Вами');
        }
        $lands = json_decode($model->lands);
        if (!(is_array($lands) && count($lands))) {
            $model->addError('lands', 'Свяжитесь с Администрацией для уточнения данных по своим участкам');
        }
        if (!$model->checked) {
            $model->addError('checked', 'Проверьте все указаныне даныне и подтвердите их актуальность');
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = false)
    {
        /** @var Users $model */
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Users"]["uid"];
        }
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "users-update-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Users'])) {
                unset($_POST['Users']['created']);
                $model->attributes = $_POST['Users'];
                $model->phone = preg_replace('/[^\d]+/isu', '', $model->phone);
                if (isset($_POST['Users']['lands']) && is_array($_POST['Users']['lands'])) {
                    $model->lands = $_POST['Users']['lands'];
                } else {
                    $model->lands = [];
                }
                if ($model->save(true, $model->getUpdatedAttributesNames())) {
                    echo Yii::t('main', 'Параметры пользователя сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров пользователя');
                }
                return;
            }

            $this->renderPartial(
              '_ajax_update_form',
              [
                'model' => $model,
              ]
            );
            return;

        }

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->save();
        }

        $this->render(
          'update',
          [
            'model' => $model,
          ]
        );
    }

    public function actionUpdateEmail()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $uid = $_REQUEST['Users']['id'];
            $newEmail = $_REQUEST['Users']['email'];
            $res = Yii::app()->db->createCommand(
              "
            UPDATE users uu
            SET email = :newEmail
            WHERE uu.uid = :uid
            "
            )->execute([':newEmail' => $newEmail, ':uid' => $uid]);
        }
        return;
    }

    public function actionUpdatePhone()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $uid = $_REQUEST['Users']['id'];
            $newPhone = $_REQUEST['Users']['phone'];
            $newPhone = preg_replace('/[^\d]*/isu', '', $newPhone);
            $res = Yii::app()->db->createCommand(
              "
            UPDATE users uu
            SET phone = :newPhone
            WHERE uu.uid = :uid
            "
            )->execute([':newPhone' => $newPhone, ':uid' => $uid]);
        }
        return;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id = false)
    {
        if (!isset($id) || $id === false) {
            $id = (isset($_REQUEST["id"]) ? $_REQUEST["id"] : Yii::app()->user->id);
        }
        $model = $this->loadModel($id);
        $this->performValidation($model);
        $userCart = false;//Cart::getUserCart($id, false, false, true);
        $this->renderPartial(
          'update',
          [
            'model' => $model,
            'userCart' => $userCart,
          ],
          false,
          true
        );
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Users::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
