<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SiteController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class customSiteController extends CustomFrontController
{
    public function actionConvertCurrency($sum, $src, $dst)
    {
        if (Yii::app()->request->isAjaxRequest) {
            try {
                $res = Formulas::priceWrapper(Formulas::convertCurrency($sum, $src, $dst), $dst);
                echo $res;
                die;
            } catch (Exception $e) {
                echo 0;
                die;
            }
        } else {
            echo 0;
            die;
        }
    }

    public function actionError()
    {
        $this->pageTitle = Yii::t('main', 'Ошибка');
        $error = Yii::app()->errorHandler->error;
        if ($error) {
            LogSiteErrors::logError(
              $error['code'] . ' ' . $error['type'] . ' ' . $error['file'] . ': ' . $error['line'],
              $error['message'],
              $error['trace']
            );
            //logError($error_label,$error_message=false,$error_description=false,$custom_data=false)
        } else {
            $error = new CHttpException(
              (isset($_REQUEST['code']) ? $_REQUEST['code'] : 403),
              Yii::t('main', 'Что-то пошло не так.')
            );
        }
        //REPAIR TABLE <table name>;
        if (Yii::app()->request->isAjaxRequest) {
            /*
                code - the HTTP status code (e.g. 403, 500)
                type - the error type (e.g. 'CHttpException', 'PHP Error')
                message - the error message
                file - the name of the PHP script file where the error occurs
                line - the line number of the code where the error occurs
                trace - the call stack of the error
                source - the context source code where the error occurs

             */
            echo 'Error: ' . $error['type'] . ': ' . $error['message'];
        } else {
            $this->render('error', ['error' => $error]);
        }
    }

    public function actionIndex()
    {
        $this->httpCache();
        $this->body_class = 'home';
        $this->pageTitle = '';

        $referer = Yii::app()->request->urlReferrer;
        $extReferer = !preg_match('/^http[s]*:\/\/' . DSConfig::getVal('site_domain') . '/i', $referer);
        if ($extReferer) {
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial(
                  'main',
                  [],
                  false,
                  false
                );
            } else {
                $this->render(
                  'main',
                  []
                );
            }
        } else {
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial(
                  'main',
                  [],
                  false,
                  false
                );
            } else {
                $this->render(
                  'main',
                  []
                );
            }
        }
    }

    public function actionScheduler($action = null, $param = null)
    {
        if (is_null($action)) {
            header(
              'Access-Control-Allow-Origin: ' .
              (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] :
                (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '*'))
            );//http://777.danvit.ru
            header('Access-Control-Allow-Credentials: true');
            if (Yii::app()->request->isAjaxRequest) {
                ScheduledJobs::schedulerEvent();
            }
        } // wget --no-check-certificate --timeout=300 --output-document=/dev/null --quiet https://virki.info92.ru/site/scheduler?action=cron&param=Nekta
        elseif ($action == 'cron') {
            if ($param == 'Nekta') {
                IoT::nektaGetData();
            }
        }
        die;
    }

    public function actionSendMail()
    {
        /*
        if (isset( $_POST['SendMessageForm'])) {
            if (isset($_POST['ajax']) && $_POST['ajax'] == 'sendMessageForm') {
                $model = new SendMessageForm();//$modelClass;
                $model->attributes = $_POST['SendMessageForm'];
                if ($model->validate()) {
                    //
                }
             }
        }
        */
        if (isset($_POST['SendMessageForm'])) {
            $model = new SendMessageForm();
            $model->attributes = $_POST['SendMessageForm'];
            //$model->captcha = null;
            if ($model->validate()) {
                if ($model->subj) {
                    $subj = $model->subj . ' - ';
                } else {
                    $subj = Yii::t('main', 'Сообщение с сайта от');
                }
                $result = Mail::sendMail(
                  $_POST['SendMessageForm']['email'],
                  $_POST['SendMessageForm']['name'],
                  DSConfig::getVal('SendMail_fromEmail'),
                  $subj . ' ' . $_POST['SendMessageForm']['email'] . ' (' . $_POST['SendMessageForm']['name'] . ')',
                  $_POST['SendMessageForm']['message']
                );
                if ($result) {
                    Yii::app()->user->setFlash(
                      'sendMailIsOK',
                      Yii::t('main', 'Сообщение отправлено')
                    );
                } else {
                    Yii::app()->user->setFlash(
                      'sendMailIsError',
                      Yii::t('main', 'Внутренняя ошибка отправки сообщения')
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
                      'sendMailIsError',
                      Yii::t('main', $message)
                    );
                }
            }
        }
        $this->redirect('/');
        /*            if (isset($_POST['message']) && isset($_POST['message']['uid']) && isset($_POST['message']['message'])) {
                        if ($_POST['message']['uid'] == 'all' && isset($_POST['message']['template_id']) && $_POST['message']['template_id']) {
                            Mail::sendMailToAll($_POST['message']['message'],true,$_POST['message']['template_id']);
                        } else {
                            Mail::sendMailToUser($_POST['message']['uid'], null, $_POST['message']['message']);
                        }
                    }
        */
    }

    public function actionSitemap()
    {
        echo SEOUtils::GetSitemap();
    }

    public function actionSitemap2ya()
    {
        echo SEOUtils::GetSitemap('yandex');
    }

    public function actionTest()
    {
        $Nekta = new NektaCommunicator('virki2@bk.ru', 'Virki-2!');
        if ($Nekta->login()) {
            $devices = $Nekta->getDevicesList();
            //$dataTypes = $Nekta->getDeviceDataMsgTypes();
            //$dataGroups = $Nekta->getDeviceDataMsgGroups();
            /*
                  1 - Показания
                  5 - Профиль мощности
                  6 - Мгновенные показания
            */
            $data = $Nekta->getDeviceData(13133, time() - (3600 * 24 * 93), time(), 6);
            if ($data) {
                header('Content-Type: application/json;charset=utf-8');
                print_r($data);
            }
        } else {
            $error = $Nekta->getLastError();
            print_r($error);
        }
        die;
    }

    public function actionTheme($set)
    {
        $cookie = new CHttpCookie('frontTheme', $set, ['domain' => '.' . DSConfig::getVal('site_domain')]);
        $cookie->expire = time() + 60 * 60 * 24 * 180;
        $cookie->httpOnly = false;
        Yii::app()->request->cookies['frontTheme'] = $cookie;
        Yii::app()->db->createCommand('DELETE FROM cache')->execute();
        $returnPath = Yii::app()->request->getUrlReferrer();
        Yii::app()->request->redirect(($returnPath ? $returnPath : '/'));
    }

    public function actionTranslate($type = '', $id = 0, $mode = 'S', $language = 'ru')
    { //, $zh = FALSE, $en = FALSE, $ru = FALSE
        // plain cid cid_ext pid vid suggestion
        header('Access-Control-Allow-Origin: *');
        /*    if (!in_array(Yii::app()->user->getRole(),array('guest','user'))) {
              Yii::app()->end();
            }
        */
        $res = new stdClass();
        if (($type != '') && ($id != 0) && (count($_POST) <= 0)) {
            $res->type = $type;
            $res->id = $id;
            $res->mode = $mode;

            $translation = Yii::app()->DVTranslator->getTranslation($type, $id, $mode, $language);
            $res->source = $translation->message;
            $res->message = $translation->translation;
            echo CJSON::encode($res);
            Yii::app()->end();
        } //==================================================================
        elseif (isset($_POST['TranslateForm'])) {
            $res->type = $_POST['TranslateForm']['type'];
            $res->id = $_POST['TranslateForm']['id'];
            $res->mode = $_POST['TranslateForm']['mode'];
            $res->source = $_POST['TranslateForm']['source'];
            $res->message = $_POST['TranslateForm']['message'];
            $res->global = $_POST['TranslateForm']['global'];
            $res->uid = $_POST['TranslateForm']['userid'];
            $res->host = $_POST['TranslateForm']['host'];
            $res->from = $_POST['TranslateForm']['from'];
            $res->to = $_POST['TranslateForm']['to'];
            if (isset($_POST['TranslateForm']['pinned']) && $_POST['TranslateForm']['pinned']) {
                $res->type = 'pinned,' . $res->type;
            } else {
                $res->type = '-pinned,' . $res->type;
            }
            Yii::app()->DVTranslator->setTranslation(
              $res->source,
              $res->message,
              $res->from,
              $res->to,
              $res->type,
              $res->id,
              $res->mode,
              $res->global,
              $res->uid,
              $res->host
            );
            Yii::app()->end();
        }
    }

    public function actionTranslateblock()
    {
        try {
            if (isset($_POST['translationArray'])) {
                $translations = unserialize(gzuncompress(convert_uudecode(urldecode($_POST['translationArray']))));
                //$translations=unserialize(urldecode($_POST['translationArray']));
                $translations = Yii::app()->DVTranslator->translateBlock($translations);
                echo serialize($translations);
            }
        } catch (Exception $e) {
            Yii::log(CVarDumper::dumpAsString($e, 1, false));
            Yii::app()->end();
        }
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