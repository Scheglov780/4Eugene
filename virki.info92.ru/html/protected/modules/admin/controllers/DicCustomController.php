<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DicCustomController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DicCustomController extends CustomAdminController
{

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
        $model = new DicCustom;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "diccustom-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['DicCustom'])) {
                $model->attributes = $_POST['DicCustom'];
                if ($model->save()) {
                    echo Yii::t('main', 'Сохранено');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения');
                }
                return;
            }
        } else {
            if (isset($_POST['DicCustom'])) {
                $model->attributes = $_POST['DicCustom'];
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
    public function actionDelete($id = false)
    {
        if (!$id) {
            $id = $_POST["val_id"];
        }
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
        if (Yii::app()->session->contains('DicCustom_records')) {
            $model = Yii::app()->session->get('DicCustom_records');
        } else {
            $model = DicCustom::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'dicCustom-' . date('YmdHis') . '.xls',
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

        $model = new DicCustom('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['DicCustom'])) {
            $model->attributes = $_GET['DicCustom'];
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = false)
    {
        if ($id == false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["DicCustom"]["val_id"];
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "diccustom-update-form");

        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['DicCustom'])) {
                $model->attributes = $_POST['DicCustom'];
                if ($model->save()) {
                    echo Yii::t('main', 'Параметр сохранен');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения');
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
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = DicCustom::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('main', 'Запрашиваемая страница не найдена.'));
        }
        return $model;
    }
}
