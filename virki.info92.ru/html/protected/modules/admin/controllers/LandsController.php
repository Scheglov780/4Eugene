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

class LandsController extends CustomAdminController
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
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Lands;
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "lands-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Lands'])) {
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
                if ($model->save()) {
                    echo Yii::t('main', 'Параметры участка сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров участка');
                }
                return;
            }
        } else {
            if (isset($_POST['Lands'])) {
                $model->attributes = $_POST['Lands'];
                $model->save();
            }

            $this->render(
              'create',
              [
                'model' => $model,
              ]
            );
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $id = $_POST["id"];

        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset(Yii::app()->request->isAjaxRequest)) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            } else {
                echo "true";
            }
        } else {
            if (!isset($_GET['ajax'])) {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            } else {
                echo "false";
            }
        }
    }

    public function actionGenerateExcel()
    {
        if (Yii::app()->session->contains('Users_records')) {
            $model = Yii::app()->session->get('Users_records');
        } else {
            $model = Users::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'lands-' . date('YmdHis') . '.xls',
          $this->renderPartial(
            'excelReport',
            [
              'model' => $model,
            ],
            true,
            false,
            true
          )
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
//        $session = new CHttpSession;
//        $session->open();
//        $criteria = new CDbCriteria();

        $model = new Lands('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Lands'])) {
            $model->attributes = $_GET['Lands'];

//            if (!empty($model->uid)) {
//                $criteria->addCondition('uid = "' . $model->uid . '"');
//            }
//
//            if (!empty($model->fullname)) {
//                $criteria->addCondition('fullname like "%' . $model->fullname . '%"');
//            }
//
//            if (!empty($model->email)) {
//                $criteria->addCondition('email like "%' . $model->email . '%"');
//            }
//
//            if (!empty($model->status)) {
//                $criteria->addCondition('status = "' . $model->status . '"');
//            }
//
//            if (!empty($model->created)) {
//                $criteria->addCondition('created = "' . $model->created . '"');
//            }
//
//            if (!empty($model->phone)) {
//                $criteria->addCondition('phone like "' . $model->phone . '%"');
//            }
//
        }
//        $session['Users_records'] = Users::model()->findAll($criteria);

        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );

    }

    public function actionStatistic($id)
    {
        $model = $this->loadModel($id);
        if (Yii::app()->request->isAjaxRequest && $model) {
            $this->renderPartial(
              'statistic',
              [
                'model' => $model,
              ]
            );
        } else {
            echo Yii::t('main', 'Нет данных');
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
