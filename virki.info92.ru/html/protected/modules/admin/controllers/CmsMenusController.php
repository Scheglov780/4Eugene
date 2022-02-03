<?php

class CmsMenusController extends CustomAdminController
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
        $model = new CmsMenus;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmsmenus-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['CmsMenus'])) {
                $model->attributes = $_POST['CmsMenus'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['CmsMenus'])) {
                $model->attributes = $_POST['CmsMenus'];
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
        if (Yii::app()->session->contains('CmsMenus_records')) {
            $model = Yii::app()->session->get('CmsMenus_records');
        } else {
            $model = CmsMenus::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'menus-' . date('YmdHis') . '.xls',
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


        $model = new CmsMenus('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['CmsMenus'])) {
            $model->attributes = $_GET['CmsMenus'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->menu_id)) {
//                $criteria->addCondition('menu_id = "' . $model->menu_id . '"');
//            }
//
//            if (!empty($model->menu_data)) {
//                $criteria->addCondition('menu_data = "' . $model->menu_data . '"');
//            }
//
//            if (!empty($model->enabled)) {
//                $criteria->addCondition('enabled = "' . $model->enabled . '"');
//            }
//
//            if (!empty($model->SEO)) {
//                $criteria->addCondition('SEO = "' . $model->SEO . '"');
//            }

        }
//        Yii::app()->session->add('CmsMenus_records',CmsMenus::model()->findAll($criteria));

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
            $standalone = false;
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["CmsMenus"]["id"];
        } else {
            $standalone = true;
        }
        $model = $this->loadModel($id, true);
        if (!$model) {
            $model = new CmsMenus();
            $model->menu_id = $id;
        }
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmsmenus-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['CmsMenus'])) {
                unset($_POST['CmsMenus']['created']);
                $model->attributes = $_POST['CmsMenus'];
                if ($model->save()) {
                    if (!$standalone) {
                        echo $model->id;
                    } else {
                        echo Yii::t('admin', 'Параметры сохранены');
                    }
                } else {
                    echo "false";
                }
                return;
            }
            if (!$standalone) {
                $this->renderPartial(
                  '_ajax_update_form',
                  [
                    'model' => $model,
                  ]
                );
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

            return;

        }

        if (isset($_POST['CmsMenus'])) {
            $model->attributes = $_POST['CmsMenus'];
            if ($model->save()) {
                // $this->redirect(array('view', 'id' => $model->id));
            }
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
    public function loadModel($id, $force = false)
    {
        if ($force) {
            $model = CmsMenus::model()->findBySql(
              "SELECT * FROM cms_menus WHERE id=cast(:id as integer) OR menu_id=cast(:id as varchar)",
              [':id' => $id]
            );
        } else {
            $model = CmsMenus::model()->findByPk($id);
        }
        if ($model === null && (!$force)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
