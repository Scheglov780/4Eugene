<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="PaysystemsController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class PaysystemsController extends CustomAdminController
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
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionConfig($id = false)
    {
        if (!$id) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["PaySystems"]["id"];
            $model = $this->loadModel($id);

            if (Yii::app()->request->isAjaxRequest) {

                if (isset($_POST['PaySystems'])) {

                    $model->attributes = $_POST['PaySystems'];
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

            if (isset($_POST['PaySystems'])) {
                $model->attributes = $_POST['PaySystems'];
                $model->save();
                return;
                /*      if ($model->save()) {
                        $this->redirect(array('view', 'id' => $model->id));
                      }
                */
            }
        } else {
            $model = $this->loadModel($id);
            if (isset($_POST['PaySystems'])) {

                $model->attributes = $_POST['PaySystems'];
//        print_r($_POST['PaySystems']);
//        die;
                //$model->value = (float)strtr($model->value,array(','=>'.'));
                if ($model->save()) {
                    echo Yii::t('main', "Запись сохранена");
                } else {
                    echo Yii::t('main', "Неверный формат данных!");
                }
                return;
            }
        }

        $this->renderPartial(
          'config',
          [
            'model' => $model,
          ],
          false,
          true
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new PaySystems;

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "paysystems-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['PaySystems'])) {
                $model->attributes = $_POST['PaySystems'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['PaySystems'])) {
                $model->attributes = $_POST['PaySystems'];
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
        if (Yii::app()->session->contains('PaySystems_records')) {
            $model = Yii::app()->session->get('PaySystems_records');
        } else {
            $model = PaySystems::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'paySystems-' . date('YmdHis') . '.xls',
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

        $model = new PaySystems('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['PaySystems'])) {
            $model->attributes = $_GET['PaySystems'];
//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//            if (!empty($model->enabled)) {
//                $criteria->addCondition('enabled = "' . $model->enabled . '"');
//            }
//            if (!empty($model->logo_img)) {
//                $criteria->addCondition('logo_img = "' . $model->logo_img . '"');
//            }
//            if (!empty($model->int_name)) {
//                $criteria->addCondition('int_name = "' . $model->int_name . '"');
//            }
//            if (!empty($model->name_ru)) {
//                $criteria->addCondition('name_ru = "' . $model->name_ru . '"');
//            }
//            if (!empty($model->name_en)) {
//                $criteria->addCondition('name_en = "' . $model->name_en . '"');
//            }
//            if (!empty($model->descr_ru)) {
//                $criteria->addCondition('descr_ru = "' . $model->descr_ru . '"');
//            }
//            if (!empty($model->descr_en)) {
//                $criteria->addCondition('descr_en = "' . $model->descr_en . '"');
//            }
//            if (!empty($model->parameters)) {
//                $criteria->addCondition('parameters = "' . $model->parameters . '"');
//            }
//            if (!empty($model->form_ru)) {
//                $criteria->addCondition('form_ru = "' . $model->form_ru . '"');
//            }
//            if (!empty($model->form_en)) {
//                $criteria->addCondition('form_en = "' . $model->form_en . '"');
//            }
        }
//        Yii::app()->session->add('PaySystems_records',PaySystems::model()->findAll($criteria));
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

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["PaySystems"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "paysystems-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['PaySystems'])) {
                unset($_POST['PaySystems']['created']);
                $model->attributes = $_POST['PaySystems'];
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

        if (isset($_POST['PaySystems'])) {
            $model->attributes = $_POST['PaySystems'];
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
        $model = PaySystems::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
