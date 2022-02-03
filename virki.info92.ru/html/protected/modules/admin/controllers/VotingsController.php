<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="VotingsController.php">
 * </description>
 **********************************************************************************************************************/
?><?php

class VotingsController extends CustomAdminController
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

    public function actionCreateVote()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['votingsVoteForm'])) {
                $sql = "insert into obj_votings_results 
    (votings_id, created, uid, result) 
    values (:votings_id, now(), :uid, 1)
    ON CONFLICT ON CONSTRAINT obj_votings_id_uid_key 
                                          DO UPDATE SET 
                                          created = now(),
                                          uid = :uid";
                $result = Yii::app()->db->createCommand($sql)->execute(
                  [
                    ':votings_id' => $_POST['votingsVoteForm']['votings_id'],
                    ':uid'        => $_POST['votingsVoteForm']['uid'],
                  ]
                );
                if ($result) {
                    echo Yii::t('main', 'Голос сохранен');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения голоса');
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

    public function actionDeleteVote()
    {
        if (!isset($_POST["id"])) {
            return;
        }
        $id = $_POST["id"];

        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $sql = "DELETE from obj_votings_results where votings_results_id = :votings_results_id";
            Yii::app()->db->createCommand($sql)->execute([':votings_results_id' => $id]);

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
        if (Yii::app()->session->contains('Votings_records')) {
            $model = Yii::app()->session->get('Votings_records');
        } else {
            $model = Votings::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'votings-' . date('YmdHis') . '.xls',
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
        /** @var Votings $model */
        $model = new Votings('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Votings'])) {
            $model->attributes = $_GET['Votings'];
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

    public function actionUpdateVote($id = false)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_POST['votingsVoteForm'])) {
                if ($id === false) {
                    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
                }
                $record = Yii::app()->db->createCommand(
                  'SELECT tt.votings_results_id, tt.votings_id, 
       tt.created, tt.uid, tt.result from obj_votings_results tt
       where tt.votings_results_id = :votings_results_id'
                )->queryRow(true, [':votings_results_id' => $id]);

                $modelData = new votingsVoteForm();
                $modelData->votings_results_id = $record['votings_results_id'];
                $modelData->votings_id = $record['votings_id'];
                $modelData->result = $record['result'];
                $modelData->uid = $record['uid'];
                $modelData->created = $record['created'];
            } else {
                $sql = "update obj_votings_results
                set 
                    -- result = :result,
                uid = :uid,
                created = Now()
                where votings_results_id = :votings_results_id";
                $result = Yii::app()->db->createCommand($sql)->execute(
                  [
                      //':result'  => $_POST['votingsVoteForm']['result'],
                    ':uid' => Yii::app()->user->id,
                    ':votings_results_id' => $_POST['votingsVoteForm']['votings_results_id'],
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
              '_ajax_update_form_vote',
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
        $model = Votings::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
