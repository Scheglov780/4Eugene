<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BannersController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class BannersController extends CustomAdminController
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
        $model = new Banners;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "banners-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Banners'])) {
                $model->attributes = $_POST['Banners'];
                if (trim($model->html_content)) {
                    $model->img_src = '';
                    $model->html_content = trim($model->html_content);
                }
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['Banners'])) {
                $model->attributes = $_POST['Banners'];
                if (trim($model->html_content)) {
                    $model->img_src = '';
                    $model->html_content = trim($model->html_content);
                }
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

    public function actionDuplicate()
    {
        $id = $_POST["id"];
        $sourceBanner = Banners::model()->findByPk($id);
        if ($sourceBanner) {
            $newBanner = new Banners;
            $newBanner->attributes = $sourceBanner->attributes;
            unset($newBanner['id']);
            if ($newBanner->save()) {
                echo 'true';
            } else {
                echo 'false';
            }
            return;
        }
    }

    public function actionGenerateExcel()
    {
        if (Yii::app()->session->contains('Banners_records')) {
            $model = Yii::app()->session->get('Banners_records');
        } else {
            $model = Banners::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'Banners-' . date('YmdHis') . '.xls',
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


        $model = new Banners('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Banners'])) {
            $model->attributes = $_GET['Banners'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->img_src)) {
//                $criteria->addCondition('img_src = "' . $model->img_src . '"');
//            }
//
//            if (!empty($model->href)) {
//                $criteria->addCondition('href = "' . $model->href . '"');
//            }
//
//            if (!empty($model->title)) {
//                $criteria->addCondition('title = "' . $model->title . '"');
//            }
//
//            if (!empty($model->enabled)) {
//                $criteria->addCondition('enabled = "' . $model->enabled . '"');
//            }

        }
//        Yii::app()->session->add('Banners_records',Banners::model()->findAll($criteria));

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

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Banners"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "banners-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Banners'])) {
                unset($_POST['Banners']['created']);
                $model->attributes = $_POST['Banners'];
                if (trim($model->html_content)) {
                    $model->img_src = '';
                    $model->html_content = trim($model->html_content);
                }
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

        if (isset($_POST['Banners'])) {
            $model->attributes = $_POST['Banners'];
            if (trim($model->html_content)) {
                $model->img_src = '';
                $model->html_content = trim($model->html_content);
            }
            if ($model->save()) {
                $this->redirect(['view', 'id' => $model->id]);
            }
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
        $model = Banners::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
