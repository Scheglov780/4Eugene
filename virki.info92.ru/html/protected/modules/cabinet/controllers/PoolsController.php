<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="PoolsController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class PoolsController extends CustomCabinetController
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
        /** @var Votings $model */
        $model = new Votings;
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "votings-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Votings'])) {
                $model->attributes = $_POST['Votings'];
                $model->votings_author = Yii::app()->user->id;
                if (!$model->date_actual_start) {
                    $model->date_actual_start = null;
                }
                if (!$model->date_actual_end) {
                    $model->date_actual_end = null;
                }
                if ($model->save()) {
                    echo Yii::t('main', 'Данные сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения данных');
                }
                return;
            }
        } else {
            if (isset($_POST['Votings'])) {
                $model->attributes = $_POST['Votings'];
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

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Опросы');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;

        /** @var Votings $model */
        $model = new Votings('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria();
        $criteria->compare('dc.val_group', 'VOTING_TYPE', false);
        $criteria->compare('dc.val_name', 'Опрос', false);
        $criteria->compare('t.enabled', 1, false);
        $criteria->order = "is_voted_by_current_user ASC nulls first, created DESC";
        $dataProvider = $model->search($criteria, 25);

        /* if (isset($_GET['Votings'])) {
             $model->attributes = $_GET['Votings'];
         } */
        $this->renderPartial(
          'index',
          [
            'model' => $model,
            'dataProvider' => $dataProvider,
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
        /** @var Votings $model */
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Votings"]["votings_id"];
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "votings-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Votings'])) {
                unset($_POST['Votings']['created']);
                $model->attributes = $_POST['Votings'];
                if (!$model->date_actual_start) {
                    $model->date_actual_start = null;
                }
                if (!$model->date_actual_end) {
                    $model->date_actual_end = null;
                }
                if ($model->save()) {
                    echo Yii::t('main', 'Параметры сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров');
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

        if (isset($_POST['Votings'])) {
            $model->attributes = $_POST['Votings'];
            $model->save();
        }

        $this->render(
          'update',
          [
            'model' => $model,
          ]
        );
    }

    public function actionVote($id)
    {
        $uid = Yii::app()->user->id;
        if (($uid === false) || ($uid === null)) {
            $msg = Yii::t('main', 'Для подтверждения прочтения сообщения Вам необходимо зарегистрироваться!');
        } else {
            $res = Votings::vote($id, $uid, 'Воздержался');
            $msg = Yii::t('main', 'Прочтение сообщения подтверждено!');
        }
        echo $msg;
        Yii::app()->end();
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

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Votings::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
