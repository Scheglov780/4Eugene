<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ScheduledJobsController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class ScheduledJobsController extends CustomAdminController
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
        $model = new ScheduledJobs;

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "scheduledjobs-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['ScheduledJobs'])) {
                $model->attributes = $_POST['ScheduledJobs'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['ScheduledJobs'])) {
                $model->attributes = $_POST['ScheduledJobs'];
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
        if (Yii::app()->session->contains('ScheduledJobs_records')) {
            $model = Yii::app()->session->get('ScheduledJobs_records');
        } else {
            $model = ScheduledJobs::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'scheduledJobs-' . date('YmdHis') . '.xls',
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


        $model = new ScheduledJobs('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['ScheduledJobs'])) {
            $model->attributes = $_GET['ScheduledJobs'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->job_script)) {
//                $criteria->addCondition('job_script = "' . $model->job_script . '"');
//            }
//
//            if (!empty($model->job_start_time)) {
//                $criteria->addCondition('job_start_time = "' . $model->job_start_time . '"');
//            }
//
//            if (!empty($model->job_stop_time)) {
//                $criteria->addCondition('job_stop_time = "' . $model->job_stop_time . '"');
//            }
//
//            if (!empty($model->job_interval)) {
//                $criteria->addCondition('job_interval = "' . $model->job_interval . '"');
//            }
//
//            if (!empty($model->job_description)) {
//                $criteria->addCondition('job_description = "' . $model->job_description . '"');
//            }

        }
//        Yii::app()->session->add('ScheduledJobs_records',ScheduledJobs::model()->findAll($criteria));

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

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["ScheduledJobs"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "scheduledjobs-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['ScheduledJobs'])) {
                unset($_POST['ScheduledJobs']['created']);
                $model->attributes = $_POST['ScheduledJobs'];
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

        if (isset($_POST['ScheduledJobs'])) {
            $model->attributes = $_POST['ScheduledJobs'];
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
        $model = ScheduledJobs::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
