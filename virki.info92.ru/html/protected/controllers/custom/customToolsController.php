<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ToolsController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class customToolsController extends CustomFrontController
{

    public function actionCalculator()
    {
        $this->pageTitle = Yii::t('main', 'Расчет стоимости доставки');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $selected_country = null;
        if ((isset($_POST['ToolsForm']) && isset($_POST['ToolsForm']['country']))) {
            $selected_country = $_POST['ToolsForm']['country'];
        } else {
            $addresses = Yii::app()->db->createCommand()
              ->select('*')
              ->from('addresses')
              ->where('uid=:uid', [':uid' => Yii::app()->user->id])
              ->limit(1)
              ->order('id ASC')
              ->queryAll();
            if (is_array($addresses) && isset($addresses[0]['country'])) {
                $selected_country = $addresses[0]['country'];
            }
        }

        $model = new ToolsForm('calc');
        $res = false;
        if (isset($_POST['ToolsForm'])) {
            $_POST['ToolsForm']['weight'] = strtr($_POST['ToolsForm']['weight'], [',' => '.']);
            $model->attributes = $_POST['ToolsForm'];
            $weight = $model->weight;
            if ($weight == 0) {
                $weight = 100;
            }
            if ($model->validate()) {
                $res = true;
                $delivery = Deliveries::getDelivery($weight, $model->country);
            } else {
                $delivery = Deliveries::getDelivery($weight, $model->country);
            }
        } else {
            $delivery = Deliveries::getDelivery(100, $model->country);
        }
// Weights list =================================================
        $weights = new Weights('search');
        $weights->unsetAttributes(); // clear any default values
        $weights->search = null;
        if (isset($_POST['Weights'])) {
            $weights->attributes = $_POST['Weights'];
            if (isset($_POST['Weights']['ru'])) {
                $weights->search = $_POST['Weights']['ru'];
            } else {
                $weights->search = null;
            }
        }
        Yii::app()->session->add('Weights_records', $weights->search());
//===============================================================
        $render = [
          'model'            => $model,
          'res'              => $res,
          'delivery'         => $delivery,
          'selected_country' => $selected_country,
          'weights'          => $weights,
        ];
        $this->render('calculator', $render);
    }

    public function actionPostcalc($selectedCountry = false)
    {
        $this->renderPartial('postcalc.postcalc_light', ['selectedCountry' => $selectedCountry], false, true);
    }

    function actionQuestion()
    {
        $model = new ToolsForm('question');
        $file_name = '';
        $this->pageTitle = Yii::t('main', 'Задать вопрос');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $category_values = [
          1 => Yii::t('main', 'Общие вопросы'),
          2 => Yii::t('main', 'Вопросы и дополнения по заказу'),
          3 => Yii::t('main', 'Рекламация'),
          4 => Yii::t('main', 'Возврат денег'),
          5 => Yii::t('main', 'Оптовые заказы'),
        ];
        if (!Yii::app()->user->isGuest) {
            $orders_list = [];
            $uid = Yii::app()->user->id;
            $criteria = new CDbCriteria;
            $criteria->select = 'id,uid,date';
            $criteria->condition = "uid=:uid and 
            (status in ('CANCELED_BY_SERVICE','PAUSED','SEND_TO_CUSTOMER','IN_PROCESS')
            OR status in (SELECT \"value\" from orders_statuses where parent_status_value in ('CANCELED_BY_SERVICE','PAUSED','SEND_TO_CUSTOMER','IN_PROCESS')
            )
            )
            ";
            $criteria->params = [':uid' => $uid];
            $criteria->order = 'id DESC';
            $orders = Order::model()->findAll($criteria);
            if ($orders) {
                foreach ($orders as $order) {
                    $orders_list[$order['id']] = $order['uid'] . '-' . $order['id'];
                }
            }
        } else {
            $orders_list = [];
        }
        $model->email =
          (!Yii::app()->user->isGuest) ? (Yii::app()->user->email ? Yii::app()->user->email : Yii::app()->user->phone) :
            '';
        if (isset($_POST['ToolsForm'])) {
            $model->attributes = $_POST['ToolsForm'];
            if ($model->validate()) {
                $question = new Question;
                $question->theme = $model->theme;
                $question->email = $model->email;
                $question->date = date("Y-m-d H:i:s", time());
                $question->category = $_POST['ToolsForm']['category'];
                if ($model->order_id) {
                    $question->order_id = $model->order_id;
                } else {
                    $question->order_id = null;
                }
                if (Yii::app()->user->isGuest) {
                    $question->uid = 0;
                } else {
                    $question->uid = Yii::app()->user->id;
                }
                $save_file = false;
                $error = false;
                $maxFileSize = (integer) preg_replace('/(\d+).+/is', '\1', ini_get('upload_max_filesize'));
                if (empty($_FILES['ToolsForm']['tmp_name']['file']) || (!empty($_FILES['ToolsForm']['tmp_name']['file'])
                    && ($_FILES['ToolsForm']['size']['file'] < $maxFileSize * 1024 * 1024))
                ) {
                    if (empty($_FILES['ToolsForm']['tmp_name']['file'])) {
                        $question->file = null;
                    } else {
                        $file = CUploadedFile::getInstance($model, 'file');
                        $extension = CFileHelper::getExtension($file);
                        $question->file = $file;
                        $file_name = uniqid('') . '.' . $extension;
                        $save_file = true;
                    }
                } else {
                    Yii::app()->user->setFlash(
                      'success',
                      Yii::t('main', 'Размер файла должен быть меньше') . ' ' . ini_get('upload_max_filesize')
                    );
                    $error = true;
                }
                if (!$error) {
                    $question->save(false);

                    if ($save_file) {
                        $question->file->saveAs($_SERVER['DOCUMENT_ROOT'] . '/upload/' . $file_name);
                        $question->file = $file_name;
                        $question->save(false);
                    }
                    $message = new Message;
                    if (Yii::app()->user->isGuest) {
                        $message->uid = 0;
                    } else {
                        $message->uid = Yii::app()->user->id;
                    }
                    $message->email = $model->email;
                    $message->qid = $question->id;
                    $message->question = $model->question;
                    $message->parent = 0;
                    $message->date = date("Y-m-d H:i:s", time());
                    $message->save();
                    Yii::app()->user->setFlash('success', Yii::t('main', 'Ваше сообщение отправлено.'));
                    if (Yii::app()->user->isGuest) {
                        $this->redirect('/');
                    } else {
                        $this->redirect(Yii::app()->createUrl('/cabinet/support/history', []));
                    }
                }
            }
        }

        $render = [
          'model'           => $model,
          'category_values' => $category_values,
          'orders'          => $orders_list,
        ];

        $this->render('question', $render);
    }

    public function actions()
    {
        if (is_dir(Yii::getPathOfAlias('ext.captchaExtended'))) {
            $result = [
              'captcha' => [
                'class' => 'CaptchaExtendedAction',
                  // if needed, modify settings
                'mode'  => CaptchaExtendedAction::MODE_MATH,
              ],
            ];
        } else {
            $result = [
                // captcha action renders the CAPTCHA image displayed on the contact page
              'captcha' => [
                'class'     => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1,
              ],
            ];
        }
        return $result;
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
}