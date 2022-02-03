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

class customProfileController extends CustomFrontController
{
    function actionAddress()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Список адресов');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $addresses = Yii::app()->db->createCommand()
          ->select('*')
          ->from('addresses')
          ->where('(uid=:uid or is_delivery_point=1) and enabled=1', [':uid' => Yii::app()->user->id])
          ->order('is_delivery_point ASC, id DESC')
          ->queryAll();

        $model = new CabinetForm('address');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.addressForm') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.addressForm', $model);
        } else {
            $form = null;
        }

        $user = Users::model()->findByPk(Yii::app()->user->id);
        $data = [];
        if ($user) {
            foreach ($user as $k => $v) {
                $data[$k] = $v;
            }
        }
        $model->attributes = $data;
        if (isset($_POST['CabinetForm'])) {
            $model->attributes = $_POST['CabinetForm'];
        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.address',
          [
            'countries' => Deliveries::getCountries(),
            'model'     => $model,
            'form'      => $form,
            'addresses' => $addresses,
          ]
        );
    }

    public function actionCreateaddress()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Адрес');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new CabinetForm('address');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.addressForm') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.addressForm', $model);
        } else {
            $form = null;
        }

        $address = new Addresses();

        if (isset($_POST['CabinetForm'])) {
            $model->attributes = $_POST['CabinetForm'];

            if ($model->validate()) {
                $address->uid = Yii::app()->user->id;
                $address->phone = $model->phone;
                $address->fullname = $model->fullname;
                if (Yii::app()->user->inRole(['superAdmin', 'topManager'])) {
                    $address->is_delivery_point = $model->is_delivery_point;
                }
                if ($address->save()) {
                    Yii::app()->user->setFlash(
                      'address',
                      Yii::t('main', 'Новый адрес успешно создан')
                    );
                } else {
                    Yii::app()->user->setFlash(
                      'address',
                      Yii::t('main', 'Ошибка добавления нового адреса')
                    );
                }
                $this->redirect('/cabinet/profile/address');
            }

        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.create_address',
          ['model' => $model, 'form' => $form]
        );

    }

    public function actionDeleteaddress($id)
    {
        $model = Addresses::model()->findByPk($id);
        if ($model->is_delivery_point && (!Yii::app()->user->inRole(['superAdmin', 'topManager']))) {
            Yii::app()->user->setFlash(
              'address',
              Yii::t('main', 'Вы не можете удалить адрес пункта выдачи!')
            );
        } else {
            $model->enabled = 0;
            if ($model->update()) {
                Yii::app()->user->setFlash(
                  'address',
                  Yii::t('main', 'Адрес успешно удален')
                );
            } else {
                Yii::app()->user->setFlash(
                  'address',
                  Yii::t('main', 'Ошибка удаления адреса')
                );
            }
        }
        $this->redirect('/cabinet/profile/address');
    }

    function actionEmail()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Изменить EMail');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new CabinetForm('email');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile._email') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile._email', $model);
        } else {
            $form = null;
        }

        $user = Users::model()->findByPk(Yii::app()->user->id);

        //$model->email = $user->email;

        if (isset($_POST['CabinetForm'])) {
            $model->attributes = $_POST['CabinetForm'];

            if ($model->validate()) {
                if (md5($model->password) == $user->password) {

                    $email = Yii::app()->db->createCommand()
                      ->select()
                      ->from('users')
                      ->where(
                        'uid!=:uid AND email=:email',
                        [':uid' => Yii::app()->user->id, ':email' => $model->email]
                      )
                      ->queryScalar();
                    if (!$email) {

                        $user->email = $model->email;
                        $user->save();

                        $identity = new UserIdentity($user->email, $user->password, true);
                        $identity->setState('email', $model->email);

                        Yii::app()->user->setFlash(
                          'email',
                          Yii::t('main', 'EMail успешно изменен')
                        );
                    } else {
                        Yii::app()->user->setFlash(
                          'email',
                          Yii::t('main', 'Данный EMail уже зарегистрирован в базе')
                        );
                    }
                } else {
                    Yii::app()->user->setFlash(
                      'email',
                      Yii::t('main', 'Вы ввели не верный пароль')
                    );
                }
                $this->redirect('/cabinet/profile/email');
            }
        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.email',
          ['model' => $model, 'form' => $form, 'user' => $user]
        );
    }

    public function actionIndex()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Личные данные');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new CabinetForm('profile');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile._profile') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile._profile', $model);
        } else {
            $form = null;
        }

        $user = Users::model()->findByPk(Yii::app()->user->id);

        $data = [];
        if ($user) {
            foreach ($user as $k => $v) {
                if ($k == 'password') {
                    $data[$k] = '';
                } else {
                    $data[$k] = $v;
                }
            }
        }
        $model->attributes = $data;
        if (isset($_POST['CabinetForm'])) {
            foreach ($_POST['CabinetForm'] as $attr => $val) {
                $model->$attr = $val;
            }
            //$model->attributes = $_POST['CabinetForm'];
            if ($model->validate()) {
                if (md5($model->password) == $user->password) {
                    $user->fullname = $model->fullname;
                    $user->phone = $model->phone;
                    if ($model->promo_code != '') {
                        $user->default_manager = Users::getUidByPromo($model->promo_code);
                    }
                    if (!$user->default_manager) {
                        $user->default_manager = Users::getFirstSuperAdminId();
                    }
                    $user->save();
                    Yii::app()->user->setFlash(
                      'index',
                      Yii::t('main', 'Данные успешно обновлены')
                    );
                    $this->redirect('/cabinet/profile/index');
                } else {
                    Yii::app()->user->setFlash(
                      'index',
                      Yii::t('main', 'Пароль не верен')
                    );
                }
            }
        }
        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.index',
          ['model' => $model, 'form' => $form]
        );
    }

    function actionMailevents()
    {
        if (Yii::app()->request->isPostRequest) {
            if (isset($_POST['events']) && is_array($_POST['events'])) {
                $events = $_POST['events'];
            } else {
                $events = [];
            }
            CmsEmailEvents::setArraySubscribed(Yii::app()->user->id, $events);
        }
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'E-mail оповещения');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];
        $eventsAndSubscroptionsForUserDataProvider =
          CmsEmailEvents::getEventsAndSubscroptionsForUser(Yii::app()->user->id);
        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.emailevents',
          [
            'eventsAndSubscroptionsForUserDataProvider' => $eventsAndSubscroptionsForUserDataProvider,
          ]
        );
    }

    function actionPassword()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Изменить пароль');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new CabinetForm('password');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile._password') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile._password', $model);
        } else {
            $form = null;
        }

        if (isset($_POST['CabinetForm'])) {
            $model->attributes = $_POST['CabinetForm'];

            if ($model->validate()) {
                $user = Users::model()->findByPk(Yii::app()->user->id);
                if (md5($model->password) == $user->password) {
                    $user = Users::model()->findByPk(Yii::app()->user->id);
                    $user->password = md5($model->new_password);
                    $user->save();
                    Yii::app()->user->setFlash(
                      'password',
                      Yii::t('main', 'Пароль успешно изменен')
                    );
                } else {
                    Yii::app()->user->setFlash(
                      'password',
                      Yii::t('main', 'Вы ввели не верный пароль')
                    );
                }
                $this->redirect('/cabinet/profile/password');
            }
        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.password',
          ['model' => $model, 'form' => $form]
        );
    }

    public function actionUpdateaddress($id)
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Адрес');
        $this->breadcrumbs = [
          Yii::t('main', 'Личный кабинет') => '/cabinet',
          $this->pageTitle,
        ];

        $model = new CabinetForm('address');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.addressForm') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.addressForm', $model);
        } else {
            $form = null;
        }
        $address = Addresses::model()->findByPk($id);

        $data = [];
        if ($address) {
            foreach ($address as $k => $v) {
                $data[$k] = $v;
            }
        }

        $model->attributes = $data;

        if (isset($_POST['CabinetForm'])) {
            foreach ($_POST['CabinetForm'] as $attr => $val) {
                $model->$attr = $val;
            }
            //CVarDumper::dump($model->attributes,10,true); die;

            if ($model->validate()) {
                $address->phone = $model->phone;
                $address->fullname = $model->fullname;
                $address->region = $model->region;
                if (Yii::app()->user->inRole(['superAdmin', 'topManager'])) {
                    $address->is_delivery_point = ($model->is_delivery_point ? 1 : 0);
                } else {
                    $address->is_delivery_point = ($address->is_delivery_point ? 1 : 0);
                }
                if ($address->save()) {
                    Yii::app()->user->setFlash(
                      'address',
                      Yii::t('main', 'Адрес успешно обновлен')
                    );
                } else {
                    Yii::app()->user->setFlash(
                      'address',
                      Yii::t('main', 'Ошибка обновления адреса')
                    );
                }
                $this->redirect('/cabinet/profile/address');
            }

        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.profile.create_address',
          ['model' => $model, 'form' => $form]
        );

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