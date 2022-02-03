<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ProfileController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class UsersController extends CustomAdminController
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

    /** @param Users $model */
    protected function performValidation($model)
    {
        if (!$model->email) {
            $model->addError('new_email', 'Email не указан');
        }
        if (!$model->phone) {
            $model->addError('phone', 'Телефон не указан');
        }
        $lands = json_decode($model->lands);
        if (!(is_array($lands) && count($lands))) {
            $model->addError('lands', 'Участки не указаны');
        }
        if (!$model->checked) {
            $model->addError('checked', 'Актуальность данных не подтверждена');
        }
    }

    public function actionBalance()
    {
        if (isset($_POST['operation'])) {
            $payment = new Payment;
            if ($_POST['operation'] == 1) {
                $payment->sum = (float) $_POST['sum'];
            } else {
                $payment->sum = 0 - (float) $_POST['sum'];
            }
            $payment->description = $_POST['desc'];
            $payment->uid = $_POST['Users']['uid'];
            $payment->manager_id = Yii::app()->user->id ?? 1;
            $payment->date = date("Y-m-d H:i:s", time());
            $payment->status = $_POST['operation'];
            if ($payment->save()) {
                if ($_POST['operation'] == 1) {
                    $mess = Yii::t('main', "На счет добавлено ") . Formulas::priceWrapper(
                        $_POST['sum'],
                        DSConfig::getVal('site_currency')
                      );
                } else {
                    $mess = Yii::t('main', "Со счета списано ") . Formulas::priceWrapper(
                        $_POST['sum'],
                        DSConfig::getVal('site_currency')
                      );
                }
            } else {
                $mess = Yii::t('main', 'Произошла ошибка пополнения счёта');
            }
            Yii::app()->user->setFlash('user', $mess);
            echo $mess;
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        /** @var Users $model */
        $model = new Users;
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "users-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
                $model->password = md5($model->password);
                if (isset($_POST['Users']['lands']) && is_array($_POST['Users']['lands'])) {
                    $model->lands = $_POST['Users']['lands'];
                } else {
                    $model->lands = [];
                }
                //@todo: отрефакторить по всему проекту
                //@todo: взять пример с ВП и пушить сообщения об ошибках в какой-то стэк, который потом выведется мессагой
                //@todo: экшены перетащить в какой-то протоконтроллер - предок.
                if ($model->save()) {
                    echo Yii::t('main', 'Параметры пользователя сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров пользователя<br/>');
                    foreach ($model->errors as $error) {
                        foreach ($error as $err) {
                            echo $err . '<br/>';
                        }
                    }
                }
                return;
            }
        } else {
            if (isset($_POST['Users'])) {
                $model->attributes = $_POST['Users'];
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
        if (Yii::app()->session->contains('Users_records')) {
            $model = Yii::app()->session->get('Users_records');
        } else {
            $model = Users::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'users-' . date('YmdHis') . '.xls',
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

    public function actionGenerateMailList($criteria = '1=1')
    {
        header('Content-Encoding: UTF-8');
        header('Content-type: text/plain; charset=UTF-8');
        $filename = 'users.txt';
        header('Content-Disposition: attachment; filename="' . $filename . '"'); //charset=UTF-8;
        //$csv="\xEF\xBB\xBF";
        $sql = "SELECT uu.email, uu.phone, coalesce(uu.fullname,'') AS fullname FROM users uu WHERE " . $criteria;
        try {
            $users = Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $e) {
            echo $e;
        }
        $result = '';
        if ($users) {
            foreach ($users as $user) {
                //echo $user->fullname . ' <' . $user->email . '>' . "\r\n";
                $result = $result . $user['fullname'] . "\t" . $user['phone'] . "\t" . $user['email'] . "\r\n";
            }
        }
        header('Content-Length: ' . strlen($result));
        header('Cache-Control: private');
        header('Pragma: no-cache');
        echo $result;
        Yii::app()->end();
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {


        $model = new Users('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Users'])) {
            $model->attributes = $_GET['Users'];
        }
        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );

    }

    public function actionStatistic($id)
    {
        $model = $this->loadModel($id);
        if (Yii::app()->request->isAjaxRequest && $model) {
            $this->renderPartial(
              'statistic',
              [
                'model' => $model,
              ]
            );
        } else {
            echo Yii::t('main', 'Нет данных');
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = false)
    {
        if ($id === false) {
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["Users"]["uid"];
        }
        $model = $this->loadModel($id);
        // Uncomment the following line if AJAX validation is needed
//$this->performAjaxValidation($model, "users-update-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['Users'])) {
                unset($_POST['Users']['created']);
                $model->attributes = $_POST['Users'];
                $model->phone = preg_replace('/[^\d]+/isu', '', $model->phone);
                if (isset($_POST['Users']['lands']) && is_array($_POST['Users']['lands'])) {
                    $model->lands = $_POST['Users']['lands'];
                } else {
                    $model->lands = [];
                }
                if ($model->save(true, $model->getUpdatedAttributesNames())) {
                    echo Yii::t('main', 'Параметры пользователя сохранены');
                } else {
                    echo Yii::t('main', 'Ошибка сохранения параметров пользователя');
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

        if (isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->save();
        }

        $this->render(
          'update',
          [
            'model' => $model,
          ]
        );
    }

    public function actionUpdateEmail()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $uid = $_REQUEST['Users']['id'];
            $newEmail = $_REQUEST['Users']['email'];
            $res = Yii::app()->db->createCommand(
              "
            UPDATE users uu
            SET email = :newEmail
            WHERE uu.uid = :uid
            "
            )->execute([':newEmail' => $newEmail, ':uid' => $uid]);
        }
        return;
    }

    public function actionUpdatePhone()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $uid = $_REQUEST['Users']['id'];
            $newPhone = $_REQUEST['Users']['phone'];
            $newPhone = preg_replace('/[^\d]*/isu', '', $newPhone);
            $res = Yii::app()->db->createCommand(
              "
            UPDATE users uu
            SET phone = :newPhone
            WHERE uu.uid = :uid
            "
            )->execute([':newPhone' => $newPhone, ':uid' => $uid]);
        }
        return;
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id = false)
    {
        if (!isset($id) || $id === false) {
            $id = $_REQUEST["id"];
        }
        $model = Users::model()->findByPkEx($id);
        $this->performValidation($model);
        $userCart = false;//Cart::getUserCart($id, false, false, true);
        $this->renderPartial(
          'update',
          [
            'model' => $model,
            'userCart' => $userCart,
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
        $model = Users::model()->findByPkEx($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
