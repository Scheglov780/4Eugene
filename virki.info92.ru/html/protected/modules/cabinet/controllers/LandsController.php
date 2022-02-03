<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="LandsController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class LandsController extends CustomCabinetController
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

    /** @param Lands $model */
    protected function performValidation($model)
    {
        if (!$model->land_group) {
            $model->addError('land_group', 'Укажите группу участков, название пос1дка или СНТ');
        }
        if (!$model->land_number) {
            $model->addError('land_number', 'Укажите номер участка');
        }
        if (!$model->land_number_cadastral) {
            $model->addError('land_number_cadastral', 'Укажите кадастровый номер участка');
        }
        if (!$model->address) {
            $model->addError('address', 'Укажите адрес участка');
        }
        if (!$model->land_type) {
            $model->addError('land_type', 'Укажите статус участка');
        }
        if (!$model->land_area) {
            $model->addError('land_area', 'Укажите площадь участка');
        }
        if (!$model->land_geo_latitude) {
            $model->addError('land_geo_latitude', 'Укажите широту участка');
        }
        if (!$model->land_geo_longitude) {
            $model->addError('land_geo_longitude', 'Укажите долготу участка');
        }
        $devices = json_decode($model->devices);
        if (!(is_array($devices) && count($devices))) {
            $model->addError('devices', 'Свяжитесь с Администрацией для уточнения данных по приборам учёта');
        }
        $users = json_decode($model->users);
        if (!(is_array($users) && count($users))) {
            $model->addError('users', 'Свяжитесь с Администрацией для уточнения данных по владельцу участка');
        }
        $tariffs = json_decode($model->tariffs);
        if (!(is_array($tariffs) && count($tariffs))) {
            $model->addError('tariffs', 'Свяжитесь с Администрацией для уточнения данных по тарифам участка');
        }
        if (!$model->status) {
            $model->addError('status', 'Проверьте все указаныне даныне и подтвердите их актуальность');
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = false)
    {
        /** @var Lands $model */
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : (isset($_REQUEST["Lands"]["lands_id"]) ?
              $_REQUEST["Lands"]["lands_id"] : false);
        }
        if (!$id) {
            echo Yii::t('main', 'Ошибка сохранения параметров участка');
            return;
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "lands-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Lands'])) {
                unset($_POST['Lands']['created']);
                $model->attributes = $_POST['Lands'];
                if (isset($_POST['Lands']['devices']) && is_array($_POST['Lands']['devices'])) {
                    $model->devices = $_POST['Lands']['devices'];
                } else {
                    $model->devices = [];
                }
                if (isset($_POST['Lands']['tariffs']) && is_array($_POST['Lands']['tariffs'])) {
                    $model->tariffs = $_POST['Lands']['tariffs'];
                } else {
                    $model->tariffs = [];
                }
                if (isset($_POST['Lands']['users']) && is_array($_POST['Lands']['users'])) {
                    $model->users = $_POST['Lands']['users'];
                } else {
                    $model->users = [];
                }
                if ($model->save(true, $model->getUpdatedAttributesNames())) {
                    echo Yii::t('main', 'Параметры участка сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров участка');
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

        if (isset($_POST['Lands'])) {
            $model->attributes = $_POST['Lands'];
            $model->save();
        }

        $this->render(
          'update',
          [
            'model' => $model,
          ]
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id = false)
    {
        if (!isset($id) || $id === false) {
            $id = $_REQUEST["id"];
        }
        $model = $this->loadModel($id); //Lands::get getLand($id);
        $this->performValidation($model);
        $this->renderPartial(
          'update',
          [
            'model' => $model,
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
        $model = Lands::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
