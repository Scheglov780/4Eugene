<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ConfigController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

class ConfigController extends CustomAdminController
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

    public function actionCatParser()
    {
        $settingsdata = DSConfig::model()->findByPk('search_CategoriesUpdate_custom');
        if (isset($_POST['DSConfig'])) {
            $settingsdata->attributes = $_POST['DSConfig'];
            //$model->value = (float)strtr($model->value,array(','=>'.'));
            $settingsdata->save();
            if (Yii::app()->request->isAjaxRequest) {
                echo Yii::t('main', "Запись сохранена");
                return;
            }
        }
        $this->renderPartial(
          'extupdate',
          [
            'settings' => $settingsdata,
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
        $model = new DSConfig;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "config-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['DSConfig'])) {
                $model->attributes = $_POST['DSConfig'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['DSConfig'])) {
                $model->attributes = $_POST['DSConfig'];
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
            $id = $_POST["id"];
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

    public function actionDelivery()
    {
        $settings = new CDbCriteria;
        $settings->select = 'label,id,value';
        $settings->condition = "id LIKE 'delivery%'";
        $settings->order = 'id ASC';
        $settingsdata = DSConfig::model()->findAll($settings);
//print_r($systemsettings); die;
        $this->renderPartial(
          'delivery',
          [
            'settings' => $settingsdata,
          ],
          false,
          true
        );
    }

    public function actionGenerateExcel()
    {
        if (Yii::app()->session->contains('Config_records')) {
            $model = Yii::app()->session->get('Config_records');
        } else {
            $model = DSConfig::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'Config-' . date('YmdHis') . '.xls',
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


        $model = new DSConfig('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['DSConfig'])) {
            $model->attributes = $_GET['DSConfig'];
//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//            if (!empty($model->label)) {
//                $criteria->addCondition('label = "' . $model->label . '"');
//            }
//            if (!empty($model->value)) {
//                $criteria->addCondition('value = "' . $model->value . '"');
//            }
//            if (!empty($model->default_value)) {
//                $criteria->addCondition('default_value = "' . $model->default_value . '"');
//            }
//            if (!empty($model->in_wizard)) {
//                $criteria->addCondition('in_wizard = "' . $model->in_wizard . '"');
//            }
        }
//        Yii::app()->session->add('Config_records',DSConfig::model()->findAll($criteria));
        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );
    }

    public function actionPrices()
    {
        $model = new DSConfig('search');
        $model->unsetAttributes(); // clear any default values

        $criteria = new CDbCriteria;
//    $criteria->select = 'label,id,value';
        $criteria->condition = "id LIKE 'rate\_%'";
        $criteria->order = 'id ASC';
        $currencyRates = new CActiveDataProvider(
          DSConfig::model(), [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 200,
            ],
          ]
        );

        $criteria = new CDbCriteria;
//    $criteria->select = 'label,id,value';
        $criteria->condition = 'id ~* \'^price_[0-9]+_[0-9]+\'';
        $criteria->order = 'SUBSTRING(id,\'^price_[0-9]+_([0-9]+)\')::integer';
        $priceRates = new CActiveDataProvider(
          DSConfig::model(), [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 200,
            ],
          ]
        );

        $criteria = new CDbCriteria;
//    $criteria->select = 'label,id,value';
        $criteria->condition = 'id ~* \'^skidka_[0-9]+_[0-9]+\'';
        $criteria->order = 'SUBSTRING(id,\'^skidka_[0-9]+_([0-9]+)\')::integer';
        $countRates = new CActiveDataProvider(
          DSConfig::model(), [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 200,
            ],
          ]
        );

        $criteria = new CDbCriteria;
//    $criteria->select = 'label,id,value';
        $criteria->condition = "id in ('price_main_k','price_main_k_min_sum')";
        $mainK = new CActiveDataProvider(
          DSConfig::model(), [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 200,
            ],
          ]
        );

        if (isset($_GET['DSConfig'])) {
            $model->attributes = $_GET['DSConfig'];
            /*            if (!empty($model->id)) {
                            $criteria->addCondition('id = "' . $model->id . '"');
                        }
                        if (!empty($model->label)) {
                            $criteria->addCondition('label = "' . $model->label . '"');
                        }
                        if (!empty($model->value)) {
                            $criteria->addCondition('value = "' . $model->value . '"');
                        }
                        if (!empty($model->default_value)) {
                            $criteria->addCondition('default_value = "' . $model->default_value . '"');
                        }
                        if (!empty($model->in_wizard)) {
                            $criteria->addCondition('in_wizard = "' . $model->in_wizard . '"');
                        }
            */
        }
//        Yii::app()->session->add('Config_records',DSConfig::model()->findAll($criteria));

        $this->renderPartial(
          'prices',
          [
            'model'         => $model,
            'currencyRates' => $currencyRates,
            'priceRates'    => $priceRates,
            'countRates'    => $countRates,
            'mainK'         => $mainK,
          ],
          false,
          true
        );
    }

    public function actionSearchParser()
    {
        $settingsdata = DSConfig::model()->findByPk('search_DropShop_grabbers_custom');
        if (isset($_POST['DSConfig'])) {
            $settingsdata->attributes = $_POST['DSConfig'];
            //$model->value = (float)strtr($model->value,array(','=>'.'));
            $settingsdata->save();
            if (Yii::app()->request->isAjaxRequest) {
                echo Yii::t('main', "Запись сохранена");
                return;
            }
        }
        $this->renderPartial(
          'parserupdate',
          [
            'settings' => $settingsdata,
          ],
          false,
          true
        );
    }

    public function actionSysSettings()
    {
        $syssettings = new CDbCriteria;
        $syssettings->select = 'label,id,value';
        $syssettings->condition = "id NOT LIKE 'rate_%' AND id NOT LIKE 'price_%'
    AND id NOT LIKE 'skidka_%' AND id NOT LIKE 'ext_%' AND id NOT LIKE 'delivery%' AND id NOT LIKE 'keys%'";
        // AND id NOT LIKE 'keys%'
        $syssettings->order = 'id ASC';
        $systemsettings = DSConfig::model()->findAll($syssettings);
//print_r($systemsettings); die;
        $this->renderPartial(
          'syssettings',
          [
            'systemsettings' => $systemsettings,
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
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["DSConfig"]["id"];
            $newTab = false;
        } else {
            $newTab = true;
        }
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "config-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['DSConfig'])) {

                $model->attributes = $_POST['DSConfig'];
                if ($model->save()) {
                    if (!$newTab) {
                        echo $model->id;
                    } else {
                        echo Yii::t('main', 'Параметр сохранен.');
                    }
                } else {
                    echo "false";
                }
                return;
            }
            if (!$newTab) {
                $this->renderPartial(
                  '_ajax_update_form',
                  [
                    'model' => $model,
                  ]
                );
            } else {
                $this->renderPartial(
                  'extupdate',
                  [
                    'settings' => $model,
                  ],
                  false,
                  true
                );
            }

            return;

        }

        if (isset($_POST['DSConfig'])) {
            $model->attributes = $_POST['DSConfig'];
//		    if(
            $model->save();
//            )
//			    $this->redirect(array('view','id'=>$model->id));
        } else {

            $this->renderPartial(
              'update',
              [
                'model' => $model,
              ],
              false,
              true
            );
        }
    }

    public function actionUpdateParamFromProxy($param)
    {
        try {

            $model = $this->loadModel($param);
            if (!$model) {
                echo Yii::t('main', 'Ошибка обновления!');
            }
            $url = 'http://' . DSConfig::getVal('proxy_address') . '/Updates/get/name/' . $param;
            $res = Utils::getHttpDocument($url);
            if (isset($res->body)) {
                $new_xml = simplexml_load_string($res->body, null, LIBXML_NOCDATA);
                $xml = simplexml_load_string(DSConfig::getVal($param), null, LIBXML_NOCDATA);
                if (isset($xml->attributes()->ver) && (isset($new_xml->attributes()->ver))) {
                    if ((string) $xml->attributes()->ver == (string) $new_xml->attributes()->ver) {
                        //-----------------
                        echo Yii::t(
                            'main',
                            'Версии совпадают, обновление не требуется'
                          ) . ' ( ver.' . (string) $new_xml->attributes()->ver . ')';
                        //-----------------
                    } else {
                        $model->value = $res->body;
                        $model->save();
                        echo Yii::t('main', 'Обновлено до версии ') . (string) $new_xml->attributes()->ver;
                    }
                }
            }
        } catch (Exception $e) {
            echo Yii::t('main', 'Ошибка обновления!');
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id = false)
    {
        if (!$id) {
            $id = $_REQUEST["id"];
        }
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
        $model = DSConfig::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('main', 'Запрашиваемая страница не найдена.'));
        }
        return $model;
    }

}
