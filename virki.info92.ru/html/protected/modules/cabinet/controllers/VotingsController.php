<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="VotingsController.php">
 * </description>
 **********************************************************************************************************************/
?><?php

class VotingsController extends CustomCabinetController
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
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->pageTitle = Yii::t('main', 'Голосования');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;

        /** @var Votings $model */
        $model = new Votings('search');
        $model->unsetAttributes();  // clear any default values
        $criteria = new CDbCriteria();
        $criteria->compare('dc.val_group', 'VOTING_TYPE', false);
        $criteria->compare('dc.val_name', 'Голосование', false);
        $criteria->compare('t.enabled', 1, false);
        $criteria->order = "is_voted_by_current_user ASC nulls first, created DESC";
        $dataProvider = $model->search($criteria, 25);

        /* if (isset($_GET['Votings'])) {
             $model->attributes = $_GET['Votings'];
         } */
        $this->renderPartial(
          'index',
          [
            'model'        => $model,
            'dataProvider' => $dataProvider,
          ],
          false,
          true
        );
    }

    public function actionVote($id)
    {
        $uid = Yii::app()->user->id;
        if (($uid === false) || ($uid === null)) {
            $msg = Yii::t('main', 'Для подтверждения прочтения сообщения Вам необходимо зарегистрироваться!');
        } else {
            $res = Votings::vote($id, $uid, 'Воздержался');
            $msg = Yii::t('main', 'Прочтение сообщения подтверждено!');
        }
        echo $msg;
        Yii::app()->end();
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
    public function loadModel($id)
    {
        $model = Votings::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
