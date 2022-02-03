<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DeviesController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DevicesController extends CustomAdminController
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

    /** @param Devices $model */
    protected function performValidation($model)
    {
        if (!$model->source) {
            $model->addError(
              'source',
              'Укажите сервис, через который обновляются данные онлайн приборов, или manual для оффлайн приборов'
            );
        }
        if (!$model->name) {
            $model->addError('name', 'Укажите понятный и удобный псевдоним прибора, например: электросчетчик уч.249');
        }
        if (!$model->device_serial_number) {
            $model->addError('device_serial_number', 'Укажите серийный номер прибора');
        }
        if (!$model->value1 && !$model->value2 && !$model->value3) {
            $model->addError('value1', 'Укажите начальные показания V1 для однотарифного прибора');
            $model->addError('value2', 'Укажите начальные показания V2 и V3 для двухтарифного прибора');
            $model->addError('value3', 'Укажите начальные показания V2 и V3 для двухтарифного прибора');
        }
        $lands = json_decode($model->lands);
        if (!(is_array($lands) && count($lands))) {
            $model->addError('lands', 'Свяжитесь с Администрацией для привязки прибора учёта к участку');
        }
        $tariffs = json_decode($model->tariffs);
        if (!(is_array($tariffs) && count($tariffs))) {
            $model->addError('tariffs', 'Свяжитесь с Администрацией для уточнения данных по тарифам прибора');
        }
        if (!$model->active) {
            $model->addError('active', 'Проверьте все указаныне даныне и подтвердите их актуальность');
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        /** @var Devices $model */
        $model = new Devices;
        // Uncomment the following line if AJAX validation is needed
        if (Yii::app()->request->isAjaxRequest) {
//$this->performAjaxValidation($model, "devices-create-form");
            if (isset($_POST['Devices'])) {
                $model->attributes = $_POST['Devices'];
                if (($model->properties && is_null(json_decode($model->properties))) || ($model->properties === '')) {
                    $model->properties = json_encode($model->properties);
                }
                if (isset($_POST['Devices']['lands']) && is_array($_POST['Devices']['lands'])) {
                    $model->lands = $_POST['Devices']['lands'];
                } else {
                    $model->lands = [];
                }
                if (isset($_POST['Devices']['tariffs']) && is_array($_POST['Devices']['tariffs'])) {
                    $model->tariffs = $_POST['Devices']['tariffs'];
                } else {
                    $model->tariffs = [];
                }
                if ($model->save()) {
                    echo Yii::t('main', 'Параметры устройства сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров устройства');
                }
                return;
            }
        } else {
            if (isset($_POST['Devices'])) {
                $model->attributes = $_POST['Devices'];
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

    public function actionCreateData()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['deviceDataForm'])) {
                $result = Devices::addReadings($_POST['deviceDataForm']);
                if ($result) {
                    echo Yii::t('main', 'Показания прибора сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения показаний прибора');
                }
                return;
            }
        }
    }

    /**
     * Deletes a particular model.
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

    public function actionDeleteData()
    {
        if (!isset($_POST["id"])) {
            return;
        }
        $id = $_POST["id"];

        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            Devices::deleteReadings($id);

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
        if (Yii::app()->session->contains('Devices_records')) {
            $model = Yii::app()->session->get('Devices_records');
        } else {
            $model = Devices::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'Devices-' . date('YmdHis') . '.xls',
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
        /** @var Devices $model */
        $model = new Devices('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Devices'])) {
            $model->attributes = $_GET['Devices'];
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

    public function actionManageReadings()
    {
        /** @var Devices $model */
        if (Yii::app()->request->isAjaxRequest && Yii::app()->request->isPostRequest) {
            $data = $_POST;
            $result = true;
            if (isset($data['readings'])) {
                foreach ($data['readings'] as $id => $reading) {
                    $model = $this->loadModel($id);
                    if (!$model->updateStartPoints($reading)) {
                        $result = false;
                    }
                    if (!Devices::addReadings($reading)) {
                        $result = false;
                    }
                }
            }
            if ($result) {
                echo 'Данные сохранены';
            } else {
                echo 'Данные сохранены с ошибками';
            }
            return;
        }
        $model = new Devices('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Devices'])) {
            $model->attributes = $_GET['Devices'];
        }
        $this->renderPartial(
          'manageReadings',
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
        /** @var Devices $model */
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : (isset($_REQUEST["Devices"]["devices_id"]) ?
              $_REQUEST["Devices"]["devices_id"] : false);
        }
        if (!$id) {
            echo Yii::t('main', 'Ошибка сохранения параметров устройства');
            return;
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "devices-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Devices'])) {
                unset($_POST['Devices']['created_at']);
                $model->attributes = $_POST['Devices'];
                if (($model->properties && is_null(json_decode($model->properties))) || ($model->properties === '')) {
                    $model->properties = json_encode($model->properties);
                }
                if (isset($_POST['Devices']['lands']) && is_array($_POST['Devices']['lands'])) {
                    $model->lands = $_POST['Devices']['lands'];
                } else {
                    $model->lands = [];
                }
                if (isset($_POST['Devices']['tariffs']) && is_array($_POST['Devices']['tariffs'])) {
                    $model->tariffs = $_POST['Devices']['tariffs'];
                } else {
                    $model->tariffs = [];
                }
                if ($model->save(true, $model->getUpdatedAttributesNames())) {
                    echo Yii::t('main', 'Параметры устройства сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров устройства');
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

        if (isset($_POST['Devices'])) {
            $model->attributes = $_POST['Devices'];
            $model->save();
        }

        $this->render(
          'update',
          [
            'model' => $model,
          ]
        );
    }

    public function actionUpdateData($id = false)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (!isset($_POST['deviceDataForm'])) {
                if ($id === false) {
                    $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
                }
                $record = Yii::app()->db->createCommand(
                  'SELECT tt.data_id, tt.device_id, 
       tt.data_updated, tt.uid, tt.tariff1_val,tt.tariff2_val,tt.tariff3_val, tt.data_source from obj_devices_manual_data tt
       where tt.data_id = :data_id'
                )->queryRow(true, [':data_id' => $id]);

                $modelData = new deviceDataForm();
                $modelData->source = 'manual';
                $modelData->data_id = $record['data_id'];
                $modelData->devices_id = $record['device_id'];
                $modelData->value1 = $record['tariff1_val'];
                $modelData->value2 = $record['tariff2_val'];
                $modelData->value3 = $record['tariff3_val'];
                $modelData->uid = $record['uid'];
                $modelData->data_updated = $record['data_updated'];
            } else {
                $sql = "update obj_devices_manual_data
                set tariff1_val = :tariff1,
                tariff2_val = :tariff2,
                tariff3_val = :tariff3,                                
                uid = :uid,
                data_updated = Now(),
                data_source = 69
                where data_id = :data_id";
                $result = Yii::app()->db->createCommand($sql)->execute(
                  [
                    ':tariff1' => $_POST['deviceDataForm']['value1'],
                    ':tariff2' => $_POST['deviceDataForm']['value2'],
                    ':tariff3' => $_POST['deviceDataForm']['value3'],
                    ':uid'     => Yii::app()->user->id,
                    ':data_id' => $_POST['deviceDataForm']['data_id'],
                  ]
                );
                if ($result) {
                    echo Yii::t('main', 'Показания прибора сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения показаний прибора');
                }
                return;
            }
            $this->renderPartial(
              '_ajax_update_form_data',
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
        $model = $this->loadModel($id); //$model = Devices::getDevice($id);
        $this->performValidation($model);
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
        $model = Devices::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        $model->getStartPoints();
        return $model;
    }
}
