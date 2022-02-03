<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="TranslatorkeysController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class TranslatorkeysController extends CustomAdminController
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

    public function actionCheckkey($key, $type)
    {
        $q = 'Каждый охотник желает знать где сидит фазан';
        $result = Yii::app()->ExternalTranslator->translateTextEx($key, $type, $q, 'ru', 'en', 'default', false);
        echo 'Source: ' . $q . "\r\n" . 'Result: ' . $result;
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new TranslatorKeys;

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "translatorkeys-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['TranslatorKeys'])) {
                $model->attributes = $_POST['TranslatorKeys'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['TranslatorKeys'])) {
                $model->attributes = $_POST['TranslatorKeys'];
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
        if (Yii::app()->session->contains('TranslatorKeys_records')) {
            $model = Yii::app()->session->get('TranslatorKeys_records');
        } else {
            $model = TranslatorKeys::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'translatorKeys-' . date('YmdHis') . '.xls',
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

        $model = new TranslatorKeys('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TranslatorKeys'])) {
            $model->attributes = $_GET['TranslatorKeys'];
//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//            if (!empty($model->key)) {
//                $criteria->addCondition('key = "' . $model->key . '"');
//            }
//            if (!empty($model->type)) {
//                $criteria->addCondition('type = "' . $model->type . '"');
//            }
//            if (!empty($model->enabled)) {
//                $criteria->addCondition('enabled = "' . $model->enabled . '"');
//            }
//            if (!empty($model->banned)) {
//                $criteria->addCondition('banned = "' . $model->banned . '"');
//            }
//            if (!empty($model->banned_date)) {
//                $criteria->addCondition('banned_date = "' . $model->banned_date . '"');
//            }
//            if (!empty($model->descr)) {
//                $criteria->addCondition('descr = "' . $model->descr . '"');
//            }
        }
//        Yii::app()->session->add('TranslatorKeys_records',TranslatorKeys::model()->findAll($criteria));
        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["TranslatorKeys"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "translatorkeys-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['TranslatorKeys'])) {

                $model->attributes = $_POST['TranslatorKeys'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
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

        if (isset($_POST['TranslatorKeys'])) {
            $model->attributes = $_POST['TranslatorKeys'];
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
    public function actionView()
    {
        $id = $_REQUEST["id"];

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial(
              'ajax_view',
              [
                'model' => $this->loadModel($id),
              ]
            );

        } else {
            $this->render(
              'view',
              [
                'model' => $this->loadModel($id),
              ]
            );
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = TranslatorKeys::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
