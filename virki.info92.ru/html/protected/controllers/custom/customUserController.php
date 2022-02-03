<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/*
 * Контроллер для управления пользовательскими действиями, такими как регистрация,
 * авторизация, восстановление пароля, логаут.
 * @package User
 */

class customUserController extends CustomFrontController
{

    public $columns = 'three-col';

    public function actionCheck($email, $key)
    {
        if (DSConfig::getVal('user_can_restore_password')) {
            $record = Users::model()->findByAttributes(['email' => $email]);
            if (!$record) {
                Yii::app()->user->setFlash(
                  'notFoundUser',
                  Yii::t(
                    'main',
                    'Пользователь с указаным EMail не найден!'
                  )
                );
                $this->redirect($this->createUrl('/'));
            } else {
                $hash = Yii::app()->getSecurityManager();
                if ($key == $hash->hashData(strtotime($record->created))) {
                    $record->status = 1;
                    $res = $record->save();
                    if (!$res) {
                        throw new Exception (Yii::t('main', 'Ошибка подтверждения EMail!'), 503);
                    }
                    Yii::app()->user->setFlash(
                      'successCheck',
                      Yii::t('main', 'Ваш Email успешно подтвержден!')
                    );
                    if (!Yii::app()->user->id || (Yii::app()->user->id && Yii::app()->user->id != $record->uid)) {
                        if (Yii::app()->user->id) {
                            Yii::app()->user->logout();
                        }
                        /*                    Yii::app()->user->setFlash(
                                              'successCheck',
                                              Yii::t('main', 'Ваш Email успешно подтвержден!') .
                                              '<br>' . Yii::t('main', 'Теперь вы можете авторизоваться')
                                            );
                        */
                        $this->redirect('/user/login');
                    } else {
                        $this->redirect('/cabinet');
                    }
                } else {
                    throw new Exception (Yii::t('main', 'Код доступа не верный!'), 503);
                }
            }
        } else {
            Yii::app()->request->redirect(Yii::app()->createUrl('/article/contacts', ['registration' => 'call']));
        }
    }

    /*
     * Действие для отображения страницы авторизации
     */

    public function actionLogin($returnUrl = false)
    {
        header('HTTP/1.1 401 Unauthorized', true, 401);
        if ($returnUrl) {
            $referer = $returnUrl;
        } else {
            $referer = Yii::app()->request->urlReferrer;
        }
        if (isset($referer) && $referer && !preg_match('/\/user\/login/', $referer)) {
            Yii::app()->user->setReturnUrl($referer);
        }
        $returnUrl = Yii::app()->user->returnUrl;
        $this->pageTitle = Yii::t('main', 'Авторизация');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $model = new UserForm('login');
        if (file_exists(
          Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.user.loginForm') . '.php'
        )) {
            $form = new CForm('webroot.themes.' . Yii::app()->theme->name . '.views.user.loginForm', $model);
        } else {
            $form = null;
        }
        if (isset($_POST['UserForm'])) {
            $loginByPhone = (boolean) DSConfig::getVal('login_use_phone_as_login');
            $model->attributes = $_POST['UserForm'];
            if ($loginByPhone) {
                $model->phone = $model->email;
            }
            if ($model->validate()) {
                Users::model()->login(
                  ($loginByPhone ? $model->phone : $model->email),
                  $model->password,
                  $model->rememberMe
                );
            }
        }
        $this->render('login', ['model' => $model, 'form' => $form]);
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect('/');
    }

    public function actionNotice()
    {
        $notices = UserNotice::model()->findAll('uid=:uid', [':uid' => Yii::app()->user->id]);
        foreach ($notices as $notice) {
            $notice->delete();
        }
        if (Yii::app()->request->getRequestUri() != Yii::app()->request->urlReferrer) {
            $this->redirect(Yii::app()->request->urlReferrer);
        }
    }

    function actionPassword()
    {
        if (DSConfig::getVal('user_can_restore_password')) {
            $this->pageTitle = Yii::t('main', 'Восстановление пароля');
            $this->breadcrumbs = [
              $this->pageTitle,
            ];
            $model = new UserForm('password');
            if (file_exists(
              Yii::getPathOfAlias('webroot.themes.' . Yii::app()->theme->name . '.views.user._password') . '.php'
            )) {
                $form = new CForm('webroot.themes.' . Yii::app()->theme->name . '.views.user._password', $model);
            } else {
                $form = null;
            }
            if (isset($_POST['UserForm'])) {
                $model->attributes = $_POST['UserForm'];
                if ($model->validate()) {
                    $user = Users::model()->find('email=:email', [':email' => $model->email]);
                    if ($user == false) {
                        Yii::app()->user->setFlash('non-found', Yii::t('main', 'Данный EMail в базе не найден'));
                    } elseif (Users::sendPassMail($user)) {
                        Yii::app()->user->setFlash(
                          'password_reset',
                          Yii::t('main', 'Вам на почту отправлено сообщение с инструкциями о смене пароля')
                        );
                        $this->redirect('/user/login');
                    }
                }
            }
            $this->render('password', ['model' => $model, 'form' => $form]);
        } else {
            Yii::app()->request->redirect(Yii::app()->createUrl('/article/contacts', ['registration' => 'call']));
        }
    }

    function actionPassword_reset($email, $key)
    {
        if (DSConfig::getVal('user_can_restore_password')) {
            $record = Users::model()->findByAttributes(['email' => $email]);
            if ($record === null) {
                Yii::app()->user->setFlash(
                  'notFoundUser',
                  Yii::t(
                    'main',
                    'Данный Email в базе не найден'
                  )
                );
                $this->redirect($this->createUrl('/'));
            } else {
                $hash = Yii::app()->getSecurityManager();
                if ($key == $hash->hashData($record->email)) {
                    $this->pageTitle = Yii::t('main', 'Восстановление пароля');
                    $this->breadcrumbs = [
                      $this->pageTitle,
                    ];
                    $model = new UserForm('password_reset');
                    if (file_exists(
                      Yii::getPathOfAlias(
                        'webroot.themes.' . Yii::app()->theme->name . '.views.user._password_reset'
                      ) . '.php'
                    )) {
                        $form = new CForm(
                          'webroot.themes.' . Yii::app()->theme->name . '.views.user._password_reset',
                          $model
                        );
                    } else {
                        $form = null;
                    }
                    if (isset($_POST['UserForm'])) {
                        $model->attributes = $_POST['UserForm'];
                        if ($model->validate()) {
                            $record->password = md5($model->password);
                            $record->save();
                            Yii::app()->user->setFlash(
                              'pass',
                              Yii::t('main', 'Ваш пароль успешно изменен.') . '<br>' .
                              Yii::t('main', 'Теперь вы можете авторизоваться')
                            );
                            $this->redirect('/user/login');
                        }
                    }
                    $this->render('password_reset', ['model' => $model, 'form' => $form]);
                } else {
                    throw new Exception (Yii::t('main', 'Код доступа не верный!'), 503);
                }
            }
        } else {
            Yii::app()->request->redirect(Yii::app()->createUrl('/article/contacts', ['registration' => 'call']));
        }
    }

    public function actionRegister($returnUrl = false)
    {
        if (DSConfig::getVal('user_registration_enabled')) {
            header('HTTP/1.1 401 Unauthorized', true, 401);
            if ($returnUrl) {
                $referer = $returnUrl;
            } else {
                $referer = Yii::app()->request->urlReferrer;
            }
            if (!preg_match('/\/user\/(?:login|register)/', $referer)) {
                Yii::app()->user->setReturnUrl($referer);
            }

            $this->pageTitle = Yii::t('main', 'Регистрация');
            $this->breadcrumbs = [
              $this->pageTitle,
            ];

            $model = new UserForm('register');

            if (isset($_POST['UserForm'])) {
                $model->attributes = $_POST['UserForm'];
                if ($model->validate()) {
                    if (isset($_POST['UserForm']['privacy']) && $_POST['UserForm']['privacy'] == 1) {
                        $result = Users::newUser($model);
                        if ($result) {
                            $this->redirect($this->createUrl($referer));
                        } elseif (is_null($result)) {
                            $this->redirect($this->createUrl('/user/login'));
                        }
                    } else {
                        Yii::app()->user->setFlash(
                          'emailFinded',
                          Yii::t(
                            'main',
                            cms::customContent(
                              'flashMessage:youMustToConfirmUserRules',
                              false,
                              false,
                              false,
                              false,
                              'Вы должны принять условия пользовательского соглашения'
                            )
                          )
                        );
                    }
                } else {
                    $message = '';
                    foreach ($model->errors as $errors) {
                        foreach ($errors as $error) {
                            $message = $message . $error . '<br/>';
                        }
                    }
                    if ($message) {
                        Yii::app()->user->setFlash(
                          'errorRegister',
                          Yii::t('main', $message)
                        );
                    }
                }
            }
            $this->render('register', ['model' => $model]);
        } else {
            Yii::app()->request->redirect(Yii::app()->createUrl('/article/contacts', ['registration' => 'call']));
        }
    }

    function actionSetCurrency($curr = false)
    {
        $currs = explode(',', DSConfig::getVal('site_currency_block'));
        if (!in_array($curr, $currs)) {
            $curr = DSConfig::getVal('site_currency');
        }
        $cookie = new CHttpCookie('currency', $curr, ['domain' => '.' . DSConfig::getVal('site_domain')]);
        $cookie->expire = time() + 60 * 60 * 24 * 180;
        Yii::app()->request->cookies['currency'] = $cookie;
        $this->redirect(Yii::app()->request->urlReferrer);
        Yii::app()->end();
    }

    public function actionSetLang($lang = 'ru')
    {
        $langs = explode(',', DSConfig::getVal('site_language_supported'));
        if (!in_array($lang, $langs)) {
            $lang = $langs[0];
        }
        //TODO: Что такое админ23?
        if (preg_match('/\/admin[23]*(?:\/|$)/', Yii::app()->request->urlReferrer)) {
            $langCookie = 'admin_lang';
        } else {
            $langCookie = 'front_lang';
        }
        $siteDomain = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
            'site_domain'
          );
        if (Yii::app()->getBaseUrl(true) == $siteDomain) {
            $cookie = new CHttpCookie(
              $langCookie,
              $lang,
              ['domain' => '.' . DSConfig::getVal('site_domain')]
            );
            $cookie->expire = time() + 60 * 60 * 24 * 180;
            Yii::app()->request->cookies[$langCookie] = $cookie;
        }

        $url = preg_replace(
          '/\/(' . implode('|', $langs) . ')(\/|$)/',
          '/' . $lang . '/',
          Yii::app()->request->urlReferrer
        );

        if (strpos($url, $lang) <= 0) {
            $url = strtr($url, ['/admin' => '/' . $lang . '/admin']);
        }
        if (!preg_match('/\/(' . implode('|', $langs) . ')(?:\/|$)/', $url)) {
            $url = str_replace($siteDomain, $siteDomain . '/' . $lang, $url);
        }
        $this->redirect($url);
        Yii::app()->end();
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
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1,
              ],
            ];
        }
        return $result;
        /*      'oauth' => array(
                // the list of additional properties of this action is below
                'class'=>'ext.hoauth.HOAuthAction',
                // Yii alias for your user's model, or simply class name, when it already on yii's import path
                // default value of this property is: User
                'model' => 'Users',
                // map model attributes to attributes of user's social profile
                // model attribute => profile attribute
                // the list of avaible attributes is below
                'attributes' => array(
                  'email' => 'email',
                  'fullname' => 'fullName',
                  // you can also specify additional values,
                  // that will be applied to your model (eg. account activation status)
                  'status' => 1,
                ),
              ),
        */
        // this is an admin action that will help you to configure HybridAuth
        // (you must delete this action, when you'll be ready with configuration, or
        // specify rules for admin role. User shouldn't have access to this action!)
        /*'oauthadmin' => array(
          'class'=>'ext.hoauth.HOAuthAdminAction',
        ),*/
    }

}