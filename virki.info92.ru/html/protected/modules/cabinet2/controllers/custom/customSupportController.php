<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SupportController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customSupportController extends CustomFrontController
{
    public function actionHistory()
    {
        $this->pageTitle = Yii::t('main', 'История обращений');
        $this->body_class = 'cabinet';
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];
        $q_statuses = [
          1 => Yii::t('main', 'На рассмотрении'),
          2 => Yii::t('main', 'Получен ответ'),
          3 => Yii::t('main', 'Закрыто'),
        ];

        $model = new Question('search');
        $model->unsetAttributes(); // clear any default values

        $criteria = new CDbCriteria;
        $criteria->condition = 't.uid=:uid';
        $criteria->params = [':uid' => Yii::app()->user->id];
        $criteria->order = 't.date DESC';

        if (isset($_GET['Question'])) {
            /*            $model->attributes = $_GET['Question'];
                        if (!empty($model->id)) {
                            $criteria->addCondition('t.id = "' . $model->id . '"');
                        }
                        if (!empty($model->theme)) {
                            $criteria->addCondition('theme like "%' . $model->theme . '%"');
                        }
                        if (!empty($model->date)) {
                            $criteria->addCondition("FROM_UNIXTIME(date,'%d.%m.%Y %H:%i') like '%" . $model->date . "%'");
                        }
            //            if (!empty($model->uid)) {
                        $criteria->addCondition('t.uid = ' . Yii::app()->user->id);
            //            }
                        if (!empty($model->category)) {
                            $criteria->addCondition('category like "%' . $model->category . '%"');
                        }
                        if (!empty($model->date_change)) {
                            $criteria->addCondition(
                              "FROM_UNIXTIME(date_change,'%d.%m.%Y %H:%i') like '%" . $model->date_change . "%'"
                            );
                        }
                        if (!empty($model->order_id)) {
                            $criteria->addCondition('order_id = "' . $model->order_id . '"');
                        }
                        if (!empty($model->status)) {
                            $criteria->addCondition('t.status = "' . $model->status . '"');
                        }
            */
        }
//        $questions = Question::model()->findAll($criteria);
//        Yii::app()->session->add('Question_records',$questions);

        //$questions = Question::model()->findAll($criteria);
        $model->uid = Yii::app()->user->id;

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.support.history',
          ['model' => $model, 'q_statuses' => $q_statuses]
        ); //'questions'=>$questions,
    }

    public function actionIndex()
    {
        /*
               $this->pageTitle = Yii::t('main', 'Служба поддержки');
                $this->body_class = 'cabinet';
                $this->breadcrumbs = array(
                  Yii::t('main', 'Личный кабинет') => '/cabinet',
                  $this->pageTitle
                );

                $model = new CabinetForm('support');
                if (file_exists(Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.support._support').'.php')) {
                    $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.support._support', $model);
                    $form->attributes = array(
                      'enctype' => 'multipart/form-data',
                      'class'   => 'long'
                    );
                } else {
                    $form = null;
                }

                if (isset($_POST['CabinetForm'])) {
                    $model->attributes = $_POST['CabinetForm'];

                    if ($model->validate()) {
                        $question = new Question;
                        $save_file = false;
                        if (!empty($_FILES['CabinetForm']['tmp_name']['file'])) {
                            if ($_FILES['CabinetForm']['size']['file'] > 5 * 1024 * 1024) {
                                Yii::app()->user->setFlash('success', Yii::t('main', 'Файл должен быть меньше, чем 5MB'));
                                $this->redirect('/cabinet/support');
                            }

                            $file = CUploadedFile::getInstance($model, 'file');
                            $extension = CFileHelper::getExtension($file);
                            $question->file = $file;
                            $file_name = uniqid("") . '.' . $extension;
                            $save_file = true;
                        } else {
                            $question->file = null;
                        }

                        $question->theme = $model->theme;
                        $question->date = time();
                        $question->uid = Yii::app()->user->id;
                        $question->category = $model->category;
                        $question->status = 1;

                        if ($model->order_id) {
                            $question->order_id = $model->order_id;
                        }
                        $question->save(false);

                        if ($save_file) {
                            $question->file->saveAs($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $file_name);
                            $question->file = $file_name;
                            $question->save(false);
                        }

                        $message = new Message;
                        $message->uid = Yii::app()->user->id;
                        $message->email = Yii::app()->user->email;
                        $message->qid = $question->id;
                        $message->question = $model->text;
                        $message->date = time();
                        $message->save();

                        Yii::app()->user->setFlash('success', Yii::t('main', 'Ваше сообщение отправлено'));
                        $this->redirect('/cabinet/support');
                    }
                }

                $this->render('webroot.themes.' . $this->frontTheme . '.views.cabinet.support.index', array('model'=>$model,'form' => $form));
         */

        $this->redirect(Yii::app()->createUrl('/tools/question', []));
    }

    function actionSave()
    {

        if (isset($_POST['Message'])) {
            if (isset($_POST['Message']['colose_question'])) {
                $question = Question::model()->findByPk($_POST['Message']['qid']);
                if (isset($question->id)) {
                    $question->date_change = time();
                    $question->status = 3;
                    if ($question->save(false)) {
                        Yii::app()->user->setFlash('mess', Yii::t('main', 'Вопрос был успешно закрыт'));
                        $this->redirect('/cabinet/support/history');
                    }
                }
            } else {
                $message = new Message;
                $message->attributes = $_POST['Message'];
                $message->status = 1;
                if (empty($_POST['Message']['question'])) {
                    Yii::app()->user->setFlash('mess', Yii::t('main', 'Вопрос не введён'));
                    $this->redirect('/cabinet/support');
                }

                $question = Question::model()->findByPk($message->qid);
                if (isset($question->id)) {
                    $question->status = 1;
                    $question->date_change = time();
                    $question->save(false);
                }

                if ($message->save()) {
                    Yii::app()->user->setFlash('mess', Yii::t('main', 'Ответ сохранён'));
                }
            }
        }
        $this->redirect('/cabinet/support');
    }

    public function actionView($id)
    {
        $this->pageTitle = Yii::t('main', 'История обращений');
        $this->body_class = 'cabinet';
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];
        $q_satuses = [
          1 => Yii::t('main', 'На рассмотрении'),
          2 => Yii::t('main', 'Получен ответ'),
          3 => Yii::t('main', 'Закрыто'),
        ];

        $category_values = [
          1 => Yii::t('main', 'Общие вопросы'),
          2 => Yii::t('main', 'Вопросы по моему заказу'),
          3 => Yii::t('main', 'Рекламация'),
          4 => Yii::t('main', 'Возврат денег'),
          5 => Yii::t('main', 'Оптовые заказы'),
        ];

        $question = Question::model()->findByPk($id);
        if (!$question) {
            throw new CHttpException (404);
        }
        if (($question->uid !== Yii::app()->user->id) && (Yii::app()->user->inRole(['user', 'guest']))) {
            throw new CHttpException (404);
        }

        $mess = Message::model()->findAll('qid=:qid AND status <> 3', [':qid' => $question->id]);
        $ans = Message::model()->findAll('qid=:qid AND status = 3', [':qid' => $question->id]);
        $messages = [];
        $answers = [];
        foreach ($mess as $k => $mes) {
            $messages[$k] = new stdClass();
            $messages[$k]->id = $mes->id;
            $messages[$k]->uid = $mes->uid;
            $messages[$k]->date = $mes->date;
            $messages[$k]->email = $mes->email;
            $messages[$k]->parent = $mes->parent;
            $messages[$k]->status = $mes->status;
            $messages[$k]->question = $mes->question;
            if ($mes->uid !== false) {
                $messages[$k]->user = Users::model()->findByPk($mes->uid);
            } else {
                $messages[$k]->user = false;
            }
            //отметка статуса о прочтении 2->4
            if (2 == $mes->status) {
                $UpMes = Message::model()->find('id=:id', [':id' => $mes->id]);
                $UpMes->status = 4;
                $UpMes->save();
            }

        }
        foreach ($ans as $mes) {
            $k = $mes->parent;
            $answers[$k] = new stdClass();
            $answers[$k]->id = $mes->id;
            $answers[$k]->uid = $mes->uid;
            $answers[$k]->date = $mes->date;
            $answers[$k]->email = $mes->email;
            $answers[$k]->parent = $mes->parent;
            $answers[$k]->status = $mes->status;
            $answers[$k]->question = $mes->question;
            if ($mes->uid !== false) {
                $answers[$k]->user = Users::model()->findByPk($mes->uid);
            } else {
                $answers[$k]->user = '';
            }
        }

        $render = [
          'question' => $question,
          'messages' => $messages,
          'category_values' => $category_values,
          'q_satuses' => $q_satuses,
          'answers' => $answers,
        ];

        $this->render('webroot.themes.' . $this->frontTheme . '.views.cabinet.support.view', $render);
    }

    public function filters()
    {
        return array_merge(
          [
            'Rights', // perform access control for CRUD operations
          ],
          parent::filters()
        );
    }

}