<?php

class BlogsController extends CustomAdminController
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
    protected function performCategoriesAjaxValidation($model, $form_id)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form_id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

//============ categories ==========================================

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performCommentsAjaxValidation($model, $form_id)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form_id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performPostsAjaxValidation($model, $form_id)
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
    public function actionCategoriesCreate()
    {
        $model = new BlogCategories;

        // Uncomment the following line if AJAX validation is needed
        $this->performCategoriesAjaxValidation($model, "blogcategories-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['BlogCategories'])) {
                $model->attributes = $_POST['BlogCategories'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            echo "false";
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionCategoriesDelete()
    {
        $id = $_POST["id"];

        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadCategoriesModel($id)->delete();

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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCategoriesUpdate()
    {
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["BlogCategories"]["id"];
        $model = $this->loadCategoriesModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performCategoriesAjaxValidation($model, "blogcategories-update-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['BlogCategories'])) {

                $model->attributes = $_POST['BlogCategories'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
            $this->renderPartial(
              'application.modules.' .
              Yii::app()->controller->module->id .
              '.views.widgets.blogs._categories_ajax_update_form',
              [
                'model' => $model,
              ],
              false,
              true,
              false
            );
            return;
        }
    }
//============ end of categories ===================================
//============ posts ===============================================

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCommentsCreate()
    {
        $model = new BlogComments;

        // Uncomment the following line if AJAX validation is needed
        $this->performCommentsAjaxValidation($model, "blogcomments-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['BlogComments'])) {
                $model->attributes = $_POST['BlogComments'];
                $model->created = date('Y-m-d H:i:s', time());
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            echo "false";
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionCommentsDelete()
    {
        $id = $_POST["id"];
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadCommentsModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset(Yii::app()->request->isAjaxRequest)) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['comments_index']);
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCommentsUpdate()
    {
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["BlogComments"]["id"];
        $model = $this->loadCommentsModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performCommentsAjaxValidation($model, "blogcomments-update-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['BlogComments'])) {
                $model->attributes = $_POST['BlogComments'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
            $this->renderPartial(
              'application.modules.' .
              Yii::app()->controller->module->id .
              '.views.widgets.blogs._comments_ajax_update_form',
              [
                'model' => $model,
              ],
              false,
              true,
              false
            );
            return;
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->renderPartial(
          'index',
          null,
          false,
          true
        );

    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionPostsCreate()
    {
        $model = new BlogPosts;
        // Uncomment the following line if AJAX validation is needed
        $this->performPostsAjaxValidation($model, "blogposts-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['BlogPosts'])) {
                $model->attributes = $_POST['BlogPosts'];
                $model->created = date('Y-m-d H:i:s', time());
                if (!$model->start_date) {
                    $model->start_date = null;
                }
                if (!$model->end_date) {
                    $model->end_date = null;
                }
                //return;
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            echo "false";
        }
    }
//============ end of posts ========================================
//============ Comments ============================================

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionPostsDelete()
    {
        $id = $_POST["id"];
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadPostsModel($id)->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset(Yii::app()->request->isAjaxRequest)) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['posts_index']);
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

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionPostsUpdate()
    {
        $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["BlogPosts"]["id"];
        $model = $this->loadPostsModel($id);
        // Uncomment the following line if AJAX validation is needed
        $this->performPostsAjaxValidation($model, "blogposts-update-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['BlogPosts'])) {

                $model->attributes = $_POST['BlogPosts'];
                if (!$model->start_date) {
                    $model->start_date = null;
                }
                if (!$model->end_date) {
                    $model->end_date = null;
                }
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
            $this->renderPartial(
              'application.modules.' .
              Yii::app()->controller->module->id .
              '.views.widgets.blogs._posts_ajax_update_form',
              [
                'model' => $model,
              ],
              false,
              true,
              false
            );
            return;
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadCategoriesModel($id)
    {
        $model = BlogCategories::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadCommentsModel($id)
    {
        $model = BlogComments::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadPostsModel($id)
    {
        $model = BlogPosts::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
//============ end of Comments =====================================
}
