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

class StructureController extends CustomAdminController
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
          'structure-' . date('YmdHis') . '.xls',
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
        $model = new Lands('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Lands'])) {
            $model->attributes = $_GET['Lands'];
        }
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
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Lands"]["lands_id"];
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
        $model = Lands::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
