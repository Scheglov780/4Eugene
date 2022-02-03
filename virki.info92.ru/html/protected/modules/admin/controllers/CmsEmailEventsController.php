<?php

class CmsEmailEventsController extends CustomAdminController
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
        $model = new CmsEmailEvents;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmsemailevents-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['CmsEmailEvents'])) {
                $model->attributes = $_POST['CmsEmailEvents'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['CmsEmailEvents'])) {
                $model->attributes = $_POST['CmsEmailEvents'];
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
        if (Yii::app()->session->contains('CmsEmailEvents_records')) {
            $model = Yii::app()->session->get('CmsEmailEvents_records');
        } else {
            $model = CmsEmailEvents::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'emailEvents-' . date('YmdHis') . '.xls',
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


        $model = new CmsEmailEvents('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['CmsEmailEvents'])) {
            $model->attributes = $_GET['CmsEmailEvents'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->template)) {
//                $criteria->addCondition('template = "' . $model->template . '"');
//            }
//
//            if (!empty($model->class)) {
//                $criteria->addCondition('class = "' . $model->class . '"');
//            }
//
//            if (!empty($model->action)) {
//                $criteria->addCondition('action = "' . $model->action . '"');
//            }
//
//            if (!empty($model->condition)) {
//                $criteria->addCondition('condition = "' . $model->condition . '"');
//            }
//
//            if (!empty($model->recipients)) {
//                $criteria->addCondition('recipients = "' . $model->recipients . '"');
//            }
//
//            if (!empty($model->tests)) {
//                $criteria->addCondition('tests = "' . $model->tests . '"');
//            }
//
//            if (!empty($model->enabled)) {
//                $criteria->addCondition('enabled = "' . $model->enabled . '"');
//            }
//
//            if (!empty($model->regular)) {
//                $criteria->addCondition('regular = "' . $model->regular . '"');
//            }

        }
//        Yii::app()->session->add('CmsEmailEvents_records',CmsEmailEvents::model()->findAll($criteria));

        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );

    }

    public function actionTestEvent($id)
    {
        return CmsEmailEvents::emailEventTest($id);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["CmsEmailEvents"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmsemailevents-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['CmsEmailEvents'])) {
                unset($_POST['CmsEmailEvents']['created']);
                $model->attributes = $_POST['CmsEmailEvents'];
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

        if (isset($_POST['CmsEmailEvents'])) {
            $model->attributes = $_POST['CmsEmailEvents'];
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
    public function loadModel($id)
    {
        $model = CmsEmailEvents::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
