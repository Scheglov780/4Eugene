<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BlogController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customBlogController extends CustomFrontController
{

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

    public function actionAuthors($id)
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }

        $author = Blogs::getAuthorById($id);

        if (!$author) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        $this->pageTitle = $author->authorName;
        $this->breadcrumbs = [
          Yii::t('main', 'Блог') => ['/blog'],
          $this->pageTitle,
        ];
        $this->render(
          'author',
          ['author' => $author],
          false,
          false
        );
    }

    public function actionCategories($id)
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        $category = BlogCategories::model()->findByPk($id);
        if (!$category || !$category->enabled) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }

        $this->pageTitle = $category->name;
        $this->breadcrumbs = [
          Yii::t('main', 'Блог') => ['/blog'],
          $this->pageTitle,
        ];
        $this->render(
          'category',
          ['category' => $category],
          false,
          false
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCommentsCreate()
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
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
            } else {
                echo 'false';
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
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        if (!isset($_POST["id"])) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
            echo 'false';
        }
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


//============ posts ===============================================

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionCommentsUpdate()
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        if (!isset($_REQUEST["id"]) && !isset($_REQUEST["BlogComments"]["id"])) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
            echo 'false';
        }
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
              'webroot.themes.' . Yii::app()->theme->name . '.views.widgets.blogs._comments_ajax_update_form',
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
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        $this->pageTitle = Yii::t('main', 'Блог');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;
        $this->render(
          'index',
          [],
          false,
          false
        );
    }

    public function actionPosts($id)
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }

        $postData = BlogPosts::model()->findByPk($id);
        if (!$postData || !$postData->enabled) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        $category = BlogCategories::model()->findByPk($postData->category_id);
        if (!$category || !$category->enabled) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        $this->pageTitle = $postData->title;
        $this->breadcrumbs = [
          Yii::t('main', 'Блог') => [$this->createUrl('/blog')],
          $category->name        => $this->createUrl('/blog/categories', ['id' => $category->id]),
          $this->pageTitle,
        ];
        $this->render(
          'post',
          ['postId' => $id, 'postData' => $postData],
          false,
          false
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionPostsCreate()
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
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

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionPostsDelete()
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        if (!isset($_POST["id"])) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
            echo 'false';
        }
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
//============ end of posts ========================================
//============ Comments ============================================

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionPostsUpdate()
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        if (!isset($_REQUEST["id"]) && !isset($_REQUEST["BlogPosts"]["id"])) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
            //echo 'false';
        }
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
              'webroot.themes.' . Yii::app()->theme->name . '.views.widgets.blogs._posts_ajax_update_form',
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

    public function actionTags($id)
    {
        if (!DSConfig::getVal('blogs_enabled')) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }

        if (!$id) {
            throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }

        $this->pageTitle = $id;
        $this->breadcrumbs = [
          Yii::t('main', 'Блог') => ['/blog'],
          $this->pageTitle,
        ];
        $this->render(
          'tag',
          ['tag' => $id],
          false,
          false
        );
    }

    public function filters()
    {
        if (AccessRights::GuestIsDisabled()) {
            return array_merge(
              [
                'Rights', // perform access control for CRUD operations
              ],
              parent::filters()
            );
        } else {
            return parent::filters();
        }
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