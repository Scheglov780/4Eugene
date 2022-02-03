<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="MainController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class MainController extends CustomCabinetController
{
//@todo: а надо ли это?
    public function actionBackup($secret = null)
    {
        if ($secret) {
            $res = Yii::app()->db->createCommand(
              "SELECT count(0) FROM users WHERE role='superAdmin' AND password=:secret LIMIT 1"
            )
              ->queryScalar([':secret' => $secret]);
            if ($res) {
                $passBySecret = true;
            } else {
                $passBySecret = false;
            }

        } else {
            $passBySecret = false;
        }
        if ($passBySecret || (Yii::app()->user && Yii::app()->user->role == 'superAdmin')) {
            DSBackup::getBackup();
            Yii::app()->end();
        } else {
            echo Yii::t('main', 'У Вас нет прав на выполнение этой операции!');
            Yii::app()->end();
        }
    }

    public function actionCheckOrder($uid = null)
    {
        if ($uid) {
            $order = Order::model()->find(
              "manager=:uid AND 
            (status IN ('IN_PROCESS')
             OR status in (SELECT \"value\" from orders_statuses where parent_status_value in ('IN_PROCESS'))
             )              
              and round((t.delivery+t.sum),2)>=(select round(coalesce(sum(summ),0),2) as \"sum\" from orders_payments op
where op.oid = t.id)
            and t.delivery>0",
              [':uid' => $uid]
            );
            if ($order) {
                echo $order->id;
            }
        }
        Yii::app()->end();
    }

    public function actionDashboard()
    {
        header(
          'Access-Control-Allow-Origin: ' .
          (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] :
            (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '*'))
        );//http://777.danvit.ru
        header('Access-Control-Allow-Credentials: true');
        $userAsManager = Users::getUserAsManager(Yii::app()->user->id);
        $this->renderPartial('view', ['userAsManager' => $userAsManager], false, true);
    }

    public function actionError()
    {
        $this->pageTitle = Yii::t('main', 'Ошибка');
        $error = Yii::app()->errorHandler->error;
        if ($error) {
            if ($error['code'] == 403) {
                if (isset($error['message'])) {
                    echo $error['message'];
                } else {
                    echo CVarDumper::dumpAsString($error, 1);
                }
                //$this->redirect('/user/login');
                Yii::app()->end();
            }
            LogSiteErrors::logError(
              $error['type'] . ' ' . $error['file'] . ': ' . $error['line'],
              $error['message'],
              $error['trace']
            );
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
                //print_r($error);
                echo 'Error: ' . $error['type'] . ': ' . $error['message'];
                echo "\n";
                echo $error['file'] . ': ' . $error['line'];
                echo "\n";
                echo $error['trace'];
            } else {
                $this->render('error', ['error' => $error]);
            }
        }
    }

    public function actionIndex()
    {
        if (Yii::app()->request->isAjaxRequest &&
          (Yii::app()->request->getParam('ajax') == 'admin-tabs-history-grid')) {
            $this->renderPartial('menu_history_block');
        } else {
            $userAsManager = Users::getUserAsManager(Yii::app()->user->id);
            $this->render('view', ['userAsManager' => $userAsManager]);
        }
    }

    public function actionOpen($url, $tabName)
    {
//http://777.danvit.ru/admin/main/open?url=admin/users/view/id/2136&tabName=test@mail.ru
        $userAsManager = Users::getUserAsManager(Yii::app()->user->id);
        $_url = urldecode($url);
        $_tabName = urldecode($tabName);
        Yii::app()->clientScript->registerScript(
          'actionOpen',
          "
          var deferredDashboard = $.Deferred();          
          $.when(deferredDashboard).then(function(){
            try {
                  getContent('" . Yii::app()->createUrl($_url) . "','" . $_tabName . "',false);
                console.log('Content editor loaded conventionaly');
            } catch (err) {
                console.log('Problems with content editor');
            }
         });
",
          CClientScript::POS_END
        );
        $this->render('view', ['userAsManager' => $userAsManager]);
    }

    public function actionView()
    {
        $this->renderPartial('index');
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