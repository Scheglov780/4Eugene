<?php

class FormulasController extends CustomAdminController
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
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return [
          [
            'allow',  // allow all users to perform 'index' and 'view' actions
            'actions' => ['index', 'view'],
            'users'   => ['*'],
          ],
          [
            'allow', // allow authenticated user to perform 'create' and 'update' actions
            'actions' => ['create', 'update', 'GeneratePdf', 'GenerateExcel'],
            'users'   => ['*'],
          ],
          [
            'allow', // allow admin user to perform 'admin' and 'delete' actions
            'actions' => ['admin', 'delete'],
            'users'   => ['*'],
          ],
          [
            'deny',  // deny all users
            'users' => ['*'],
          ],
        ];
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Formulas('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Formulas'])) {
            $model->attributes = $_GET['Formulas'];
        }

        $this->render(
          'admin',
          [
            'model' => $model,
          ]
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new Formulas;

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "formulas-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Formulas'])) {
                $model->attributes = $_POST['Formulas'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['Formulas'])) {
                $model->attributes = $_POST['Formulas'];
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
        if (Yii::app()->session->contains('Formulas_records')) {
            $model = Yii::app()->session->get('Formulas_records');
        } else {
            $model = Formulas::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'formulas-' . date('YmdHis') . '.xls',
          $this->renderPartial(
            'excelReport',
            [
              'model' => $model,
            ],
            true,
            false
          )
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $model = new Formulas('search');
        $model->unsetAttributes();  // clear any default values

        if (isset($_GET['Formulas'])) {
            $model->attributes = $_GET['Formulas'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->formula_id)) {
//                $criteria->addCondition('formula_id = "' . $model->formula_id . '"');
//            }
//
//            if (!empty($model->formula)) {
//                $criteria->addCondition('formula = "' . $model->formula . '"');
//            }
//
//            if (!empty($model->description)) {
//                $criteria->addCondition('description = "' . $model->description . '"');
//            }

        }
//        Yii::app()->session->add('Formulas_records',Formulas::model()->findAll($criteria));

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

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Formulas"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "formulas-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['Formulas'])) {
                unset($_POST['Formulas']['created']);
                $model->attributes = $_POST['Formulas'];
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

        if (isset($_POST['Formulas'])) {
            $model->attributes = $_POST['Formulas'];
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
     * @return array action filters
     */
    public function filters()
    {
        return [
          'accessControl', // perform access control for CRUD operations
        ];
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Formulas::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
