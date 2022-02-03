<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsController.php">
 * </description>
 **********************************************************************************************************************/
?><?php

class BillsController extends CustomCabinetController
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
        /** @var Bills $model */
        $model = new Bills;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "bills-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Bills'])) {
                foreach ($_POST['Bills'] as $i => $bill) {
                    if ($bill === '') {
                        $_POST['Bills'][$i] = null;
                    }
                }
                $model->attributes = $_POST['Bills'];
                $tariff = Tariffs::model()->findByPk($model->tariff_id);
                $tariffRules = json_decode($tariff->tariff_rules);
                if ($tariffRules->target == 'land' && $model->tariff_object_id_land) {
                    $model->tariff_object_id = $model->tariff_object_id_land;
                } elseif ($tariffRules->target == 'device' && $model->tariff_object_id_device) {
                    $model->tariff_object_id = $model->tariff_object_id_device;
                } else {
                    echo Yii::t('main', 'Не правильно выбран объект - данные не сохранены');
                }

                if ($model->save()) {
                    echo Yii::t('main', 'Данные сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения данных');
                }
                return;
            }
        } else {
            if (isset($_POST['Bills'])) {
                $model->attributes = $_POST['Bills'];
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

    public function actionDashboard()
    {
//=================================================================================
        $uid = Yii::app()->user->id;
        $manager = null;
//=================================================================================
        $billsByStatusesArray = BillsStatuses::getAllStatusesListAndBillCount($uid, $manager, false);
        $billsByStatusesArrayForDataProvider = BillsStatuses::getAllStatusesListAndBillCount($uid, $manager, true);
        $billsByStatusesDataProvider = new CArrayDataProvider(
          $billsByStatusesArrayForDataProvider, [
            'id' => 'billsByStatuses',
              /*      'sort'=>array(
                      'attributes'=>array(
                        'id', 'username', 'email',
                      ),
                    ),
              */
            'pagination' => [
              'pageSize' => 100,
            ],
          ]
        );
        $this->renderPartial(
          'dashboard',
          [
            'billsByStatusesDataProvider' => $billsByStatusesDataProvider,
            'billsByStatusesArray'        => $billsByStatusesArray,
          ],
          false,
          true
        );
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

    public function actionGenerateExcel($type = null, $uid = null)
    {
        if (Yii::app()->user->id) {
            if (!$type || $type == 'all') {
                $type = null;
            }
            if (!(Yii::app()->user->inRole(['manager', 'billManager', 'topManager', 'superAdmin']) ||
              (Yii::app()->user->id == $uid))) {
                throw new CHttpException(404, 'Документ  не найден!');
            }
            $model = new Bills('search');
            $model->status = $type;
            $model->uid = $uid;

            $dataProvider = $model->search(null, 100000);
            $data = $dataProvider->data;
            unset($dataProvider);
            Yii::app()->request->sendFile(
              'bills-' . date('YmdHis') . '.xls',
              $this->renderPartial(
                'excelReport',
                [
                  'model' => $data,
                ],
                true,
                false,
                true
              )
            );
        } else {
            throw new CHttpException(404, 'Документ  не найден!');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex($type = null)
    {
        if ($type == 'ALL') {
            $type = null;
        }
        if ($type) {
            $name = BillsStatuses::getStatusName($type);
        } else {
            $name = '';
        }
        /** @var Bills $model */
        $model = new Bills('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Bills'])) {
            $model->attributes = $_GET['Bills'];
        }
        $this->renderPartial(
          'index',
          [
            'model' => $model,
            'type'  => $type,
            'name'  => $name,
          ],
          false,
          true,
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
        /** @var Bills $model */
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Bills"]["id"];
        }
        if (isset($_REQUEST["type"])) {
            $type = $_REQUEST["type"];
        } else {
            $type = null;
        }
        $model = $this->loadModel($id);
        $tariff = Tariffs::model()->findByPk($model->tariff_id);
        $tariffRules = json_decode($tariff->tariff_rules);
        if ($tariffRules->target == 'land') {
            $model->tariff_object_id_land = $model->tariff_object_id;
        } elseif ($tariffRules->target == 'device') {
            $model->tariff_object_id_device = $model->tariff_object_id;
        }
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "bills-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Bills'])) {
                unset($_POST['Bills']['created']);
                unset($_POST['Bills']['code']);
                unset($_POST['Bills']['date']);
                foreach ($_POST['Bills'] as $i => $bill) {
                    if ($bill === '') {
                        $_POST['Bills'][$i] = null;
                    }
                }
                $model->attributes = $_POST['Bills'];
                unset($model->code);
                $model->unsetAttributes(['code']);
                $tariff = Tariffs::model()->findByPk($model->tariff_id);
                $tariffRules = json_decode($tariff->tariff_rules);
                if ($tariffRules->target == 'land' && $model->tariff_object_id_land) {
                    $model->tariff_object_id = $model->tariff_object_id_land;
                } elseif ($tariffRules->target == 'device' && $model->tariff_object_id_device) {
                    $model->tariff_object_id = $model->tariff_object_id_device;
                } else {
                    echo Yii::t('main', 'Не правильно выбран объект - данные не сохранены');
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
                'type'  => $type,
              ]
            );
            return;

        }

        if (isset($_POST['Bills'])) {
            $model->attributes = $_POST['Bills'];
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
        $model = Bills::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
