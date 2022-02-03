<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="NewsController.php">
 * </description>
 **********************************************************************************************************************/
?><?php

class NewsController extends CustomAdminController
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
        /** @var News $model */
        $model = new News;
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "news-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['News'])) {
                $model->attributes = $_POST['News'];
                $model->news_author = Yii::app()->user->id;
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
            if (isset($_POST['News'])) {
                $model->attributes = $_POST['News'];
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

    public function actionCreateConfirm()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['newsConfirmationForm'])) {
                $sql = "insert into obj_news_confirmations 
    (news_id, created, uid, result) 
    values (:news_id, now(), :uid, 1)
    ON CONFLICT ON CONSTRAINT obj_news_confirmations_news_id_uid_key 
                                          DO UPDATE SET 
                                          created = now(),
                                          uid = :uid";
                $result = Yii::app()->db->createCommand($sql)->execute(
                  [
                    ':news_id' => $_POST['newsConfirmationForm']['news_id'],
                    ':uid'     => $_POST['newsConfirmationForm']['uid'],
                  ]
                );
                if ($result) {
                    echo Yii::t('main', 'Подтверждение сохранено');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения подтверждения');
                }
                return;
            }
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

    public function actionDeleteConfirm()
    {
        if (!isset($_POST["id"])) {
            return;
        }
        $id = $_POST["id"];

        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $sql = "DELETE from obj_news_confirmations where news_confirmations_id = :news_confirmations_id";
            Yii::app()->db->createCommand($sql)->execute([':news_confirmations_id' => $id]);

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
        if (Yii::app()->session->contains('News_records')) {
            $model = Yii::app()->session->get('News_records');
        } else {
            $model = News::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'news-' . date('YmdHis') . '.xls',
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
        /** @var News $model */
        $model = new News('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['News'])) {
            $model->attributes = $_GET['News'];
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
        /** @var News $model */
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["News"]["news_id"];
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "news-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['News'])) {
                unset($_POST['News']['created']);
                $model->attributes = $_POST['News'];
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

        if (isset($_POST['News'])) {
            $model->attributes = $_POST['News'];
            $model->save();
        }

        $this->render(
          'update',
          [
            'model' => $model,
          ]
        );
    }

    public function actionUpdateConfirm($id = false)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_POST['newsConfirmationForm'])) {
                if ($id === false) {
                    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
                }
                $record = Yii::app()->db->createCommand(
                  'SELECT tt.news_confirmations_id, tt.news_id, 
       tt.created, tt.uid, tt.result from obj_news_confirmations tt
       where tt.news_confirmations_id = :news_confirmations_id'
                )->queryRow(true, [':news_confirmations_id' => $id]);

                $modelData = new newsConfirmationForm();
                $modelData->news_confirmations_id = $record['news_confirmations_id'];
                $modelData->news_id = $record['news_id'];
                $modelData->result = $record['result'];
                $modelData->uid = $record['uid'];
                $modelData->created = $record['created'];
            } else {
                $sql = "update obj_news_confirmations
                set 
                    -- result = :result,
                uid = :uid,
                created = Now()
                where news_confirmations_id = :news_confirmations_id";
                $result = Yii::app()->db->createCommand($sql)->execute(
                  [
                      //':result'  => $_POST['newsConfirmationForm']['result'],
                    ':uid' => Yii::app()->user->id,
                    ':news_confirmations_id' => $_POST['newsConfirmationForm']['news_confirmations_id'],
                  ]
                );
                if ($result) {
                    echo Yii::t('main', 'Подтверждение сохранено');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения подтверждения');
                }
                return;
            }
            $this->renderPartial(
              '_ajax_update_form_confirm',
              [
                'model' => $modelData,
              ]
            );
            return;
        }
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
        $model = $this->loadModel($id);
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
        $model = News::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
