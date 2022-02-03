<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="MessageController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class MessageController extends CustomAdminController
{
    public $breadcrumbs;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    public function actionSendMail()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['message']) && isset($_POST['message']['uid']) && isset($_POST['message']['message'])) {
                if ($_POST['message']['uid'] == 'all' &&
                  isset($_POST['message']['template_id']) &&
                  $_POST['message']['template_id']) {
                    Mail::sendMailToAll($_POST['message']['message'], true, $_POST['message']['template_id']);
                } else {
                    Mail::sendMailToUser($_POST['message']['uid'], null, $_POST['message']['message']);
                }
            }
        }
    }

    public function actionSendNote()
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['message']) && isset($_POST['message']['uid']) && isset($_POST['message']['message'])) {
                $notice = new UserNotice;
                $notice->msg = $_POST['message']['message'];
                $notice->uid = $_POST['message']['uid'];
                $notice->status = 6;
                $notice->data = CJSON::encode($_POST['message']);
                $result = $notice->save();
            }
        }
    }
}
