<?php

class CmsPagesController extends CustomAdminController
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
        $model = new CmsPages;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmspages-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['CmsPages'])) {
                $model->attributes = $_POST['CmsPages'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['CmsPages'])) {
                $model->attributes = $_POST['CmsPages'];
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

    public function actionDataLoading()
    {
        function dirToArray($dir)
        {

            $result = [];

            $cdir = scandir($dir);
            foreach ($cdir as $key => $value) {
                if (!in_array($value, [".", ".."])) {
                    if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) {
                        $result = array_merge($result, dirToArray($dir . DIRECTORY_SEPARATOR . $value));
                    } else {
                        $result[] = $dir . '/' . $value;
                    }
                }
            }

            return $result;
        }

        //  header('Access-Control-Allow-Origin: *');
//        if (!Yii::app()->theme->name) {
        $frontTheme = DSConfig::getVal('site_front_theme');
//        }
        if (isset(Yii::app()->request->cookies['frontTheme'])) {
            $cookieTheme = (string) Yii::app()->request->cookies['frontTheme'];
        } else {
            $cookieTheme = false;
        }
        if ($cookieTheme) {
            $frontTheme = $cookieTheme;
        }

        $themePath = Yii::getPathOfAlias('webroot') . '/themes/' . $frontTheme;
        $importPath = $themePath . '/article';
        if (is_dir($importPath)) {
            $filesList = dirToArray($importPath);

            $errors = [];
            Yii::app()->db->createCommand(
              "
truncate table cms_loaded
"
            )
              ->execute();
            foreach ($filesList as $file) {
                if (file_exists($file)) {
                    $content = file_get_contents($file);
                    Yii::app()->db->createCommand(
                      "
INSERT INTO cms_loaded (page_id,content_data,title,description,keywords)
VALUES(:page_id,:content_data,'','','')
"
                    )
                      ->execute(
                        [
                          ':page_id' => $file,
                          ':content_data' => $content,
                        ]
                      );
                } else {
                    $errors[] = $file;
                }
            }
            echo 'Complete!<br>';
            echo count($filesList) - count($errors) . ' files loaded.<br>';
            echo 'Erroros: <br>' . CVarDumper::dumpAsString($errors, 10, true);
        } else {
            echo 'Path not fount: <br>' . $importPath;
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
        if (Yii::app()->session->contains('CmsPages_records')) {
            $model = Yii::app()->session->get('CmsPages_records');
        } else {
            $model = CmsPages::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'Pages-' . date('YmdHis') . '.xls',
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
        $model = new CmsPages('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['CmsPages'])) {
            $model->attributes = $_GET['CmsPages'];
            /*
                      if (!empty($model->id)) {
                          $criteria->addCondition('id = "' . $model->id . '"');
                      }

                      if (!empty($model->page_id)) {
                          $criteria->addCondition('page_id = "' . $model->page_id . '"');
                      }

                      if (!empty($model->url)) {
                          $criteria->addCondition('url = "' . $model->url . '"');
                      }

                      if (!empty($model->enabled)) {
                          $criteria->addCondition('enabled = "' . $model->enabled . '"');
                      }

                      if (!empty($model->SEO)) {
                          $criteria->addCondition('SEO = "' . $model->SEO . '"');
                      }
          */
        }
        //Yii::app()->session->add('CmsPages_records',CmsPages::model()->findAll($criteria));

        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );

    }

    public function actionSetParent($id)
    {
        if (isset($_POST['parent']) && $_POST['parent']) {
            $model = CmsPages::model()->findByPk($id);
            $parent = CmsPages::model()->findByPk($_POST['parent']);
            if ($model && $parent) {
                $model->parent = $parent->id;
                $result = $model->save();
            }
        }
    }

    public function actionTreeCommand()
    {
        $result = 0;
        if (isset($_POST['command']) && isset($_POST['id'])) {
            $model = CmsPages::model()->findByPk($_POST['id']);
            if ($model) {
                switch ($_POST['command']) {
                    case 'top':
                        $parent = CmsPages::model()->findByPk($model->parent);
                        $parentRoot = CmsPages::model()->findByPk($parent->parent);
                        if ($parent) {
                            if ($parent->parent && $parent->parent != $model->parent) {
                                $model->parent = $parent->parent;
                                if ($model->save()) {
                                    if ($parentRoot && $parentRoot->parent != $parentRoot->id) {
                                        $result = $parent->parent;
                                    } else {
                                        $result = null;
                                    }
                                }
                            }
                        }
                        break;
                    case 'up':
                        $rowsInLevel = CmsPages::model()->findAll(
                          'parent=:parent order by abs(order_in_level), id',
                          [':parent' => $model->parent]
                        );
                        foreach ($rowsInLevel as $i => $row) {
                            if ($rowsInLevel[$i]->id == $model->id) {
                                if (isset($rowsInLevel[$i - 1])) {
                                    $rowsInLevel[$i]->order_in_level = $rowsInLevel[$i - 1]->order_in_level;
                                    $rowsInLevel[$i]->save();
                                    $rowsInLevel[$i - 1]->order_in_level = ($i + 1) * 10;
                                    $rowsInLevel[$i - 1]->save();
                                } else {
                                    $rowsInLevel[$i]->order_in_level = ($i + 1) * 10;
                                    $rowsInLevel[$i]->save();
                                }
                            } else {
                                $rowsInLevel[$i]->order_in_level = ($i + 1) * 10;
                                $rowsInLevel[$i]->save();
                            }
                        }
                        break;
                    case 'down':
                        $rowsInLevel = CmsPages::model()->findAll(
                          'parent=:parent order by enabled desc, abs(order_in_level) asc, id asc',
                          [':parent' => $model->parent]
                        );
                        foreach ($rowsInLevel as $i => $row) {
                            if ($rowsInLevel[$i]->id == $model->id) {
                                if (isset($rowsInLevel[$i + 1])) {
                                    $rowsInLevel[$i]->order_in_level = ($i + 2) * 10;;
                                    $rowsInLevel[$i]->save();
                                    $rowsInLevel[$i + 1]->order_in_level = ($i + 1) * 10;
                                    $rowsInLevel[$i + 1]->save();
                                } else {
                                    $rowsInLevel[$i]->order_in_level = ($i + 1) * 10;
                                    $rowsInLevel[$i]->save();
                                }
                            } else {
                                if (isset($rowsInLevel[$i - 1]->id) && $rowsInLevel[$i - 1]->id == $model->id) {
                                    continue;
                                } else {
                                    $rowsInLevel[$i]->order_in_level = ($i + 1) * 10;
                                    $rowsInLevel[$i]->save();
                                }
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        echo CJSON::encode($result);
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate()
    {

        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["CmsPages"]["id"];
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmspages-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['CmsPages'])) {
                unset($_POST['CmsPages']['created']);
                $model->attributes = $_POST['CmsPages'];
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

        if (isset($_POST['CmsPages'])) {
            $model->attributes = $_POST['CmsPages'];
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
        $model = CmsPages::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
