<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="QuestionsController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class QuestionsController extends CustomAdminController
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

    public function actionGenerateExcel()
    {
        if (Yii::app()->session->contains('Question_records')) {
            $model = Yii::app()->session->get('Question_records');
        } else {
            $model = Question::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'questions-' . date('YmdHis') . '.xls',
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

    public function actionIndex()
    {

//        $criteria->order = 't.status ASC, t.date DESC';
        $model = new Question('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Question'])) {
            $model->attributes = $_GET['Question'];
//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//            if (!empty($model->theme)) {
//                $criteria->addCondition("theme like '%" . $model->theme . "%'");
//            }
//            if (!empty($model->date)) {
//                $criteria->addCondition(
//                  "FROM_UNIXTIME(t.date,'%d.%m.%Y %H:%i') like '%" . (string) $model->date . "%'"
//                );
//            }
//            if (!empty($model->uid)) {
//      $criteria->addCondition('uid = ' . Yii::app()->user->id);
//            }
//            if (!empty($model->category)) {
//                $criteria->addCondition('category like "%' . $model->category . '%"');
//            }
//            if (!empty($model->date_change)) {
//                $criteria->addCondition(
//                  "FROM_UNIXTIME(date_change,'%d.%m.%Y %H:%i') like '%" . (string) $model->date_change . "%'"
//                );
//            }
//            if (!empty($model->order_id)) {
//                $criteria->addCondition('order_id = "' . $model->order_id . '"');
//            }
//            if (!empty($model->status)) {
//                $criteria->addCondition('status = "' . $model->status . '"');
//            }
        }
//        Yii::app()->session->add('Question_records',Question::model()->findAll($criteria));

        /*    $dataProvider=new CActiveDataProvider('Question',array(
              'sort'=> array(
                'defaultOrder'=>'date_change IS NULL DESC, date_change desc, date desc',
              ),
              'pagination'=>array(
                'pageSize'=>100,
              ),
            ));
        */
        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );
    }

    public function actionSave()
    {
        if (isset($_POST['Message'])) {
            $message = new Message;
            $mes['parent'] = $_POST['Message']['id'];
            // статус сообщения "ответ администратора"
            $mes['status'] = 3;
            $mes['question'] = $_POST['Message']['question'];
            $mes['uid'] = Yii::app()->user->id;
            $mes['email'] = Yii::app()->user->email;
            $mes['qid'] = $_POST['Message']['qid'];;
            $mes['date'] = time();
            $message->attributes = $mes;
            //находим вопрос
            $question = Question::model()->findByPk($message->qid);
            if (isset($question->id)) {
                $question->date_change = time();
                if ($question->status == 1) {
                    $question->status = 2;
                }
                $question->save(false);
            }

            if ($message->save()) {

                // статус сообщения "есть ответ"
                $message = Message::model()->findByPk($_POST['Message']['id']);
                $message->status = 2;
                $message->save();
                echo Yii::t('main', "Ответ сохранен");
            }
        } else {
            echo Yii::t('main', "Неверный запрос");
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        $question = Question::model()->findByPk($id);
        $messages = Message::model()->getQuestionThred($id);
        $this->renderPartial(
          'view',
          [
            'question' => $question,
            'messages' => $messages,
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
        $model = Question::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}