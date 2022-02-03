<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Mail.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "mail_events".
 * The followings are the available columns in table 'mail_events':
 * @property integer $id
 * @property string  $mailevent_name
 * @property integer $enabled
 * @property string  $mail_template
 */
class customMail
{
    public $message;
    public $subject;
    public $user;
    private static $_cachedImages = [];
    /**
     * @return string the associated database table name
     */
    private static $mailFromQueryPerRun = 10;

    private static function internalSendMail($from, $fromName, $to, $subj, $body, $attaches = [])
    {
        try {
            include_once Yii::app()->basePath . '/extensions/phpmailer/PHPMailer/class.phpmailer.php';
            $mailer = new PHPMailer();
            $mailer->CharSet = 'UTF-8';
            $mailer->isHTML(true);
            $mailer->Encoding = 'base64';
            /*
            SendMail_isSMTP
            SendMail_SMTPAuth
            SendMail_SMTPSecure
            SendMail_SMTPHost
            SendMail_SMTPPort
            SendMail_SMTPUsername
            SendMail_SMTPPassword
            SendMail_fromEmail
            SendMail_fromName
            */

            if (DSConfig::getVal('SendMail_isSMTP') == 1) {
                include_once Yii::app()->basePath . '/extensions/phpmailer/PHPMailer/class.smtp.php';
                $mailer->isSMTP();
                // for debug
                /*
                $mailer->SMTPDebug = SMTP::DEBUG_SERVER;
                $mailer->SMTPDebug = 2;
                $mailer->Debugoutput = function($str, $level) {
                    echo "debug level $level; message: $str";
                };
                */
                //===============
                $mailer->Timeout = 25;
                $mailer->SMTPKeepAlive = false;
                $mailer->SMTPAuth = (DSConfig::getVal(
                  'SendMail_SMTPAuth'
                ) ? true : false);  // enable SMTP authentication
                $mailer->SMTPSecure = DSConfig::getVal(
                  'SendMail_SMTPSecure'
                );           //'ssl', sets the prefix to the servier
                $mailer->Host = DSConfig::getVal(
                  'SendMail_SMTPHost'
                );      //'smtp.gmail.com' sets GMAIL as the SMTP server
                $mailer->Port = (int) DSConfig::getVal('SendMail_SMTPPort');      //465 set the SMTP port
                $mailer->Username = DSConfig::getVal('SendMail_SMTPUsername');  //'yourname@gmail.com' username
                $mailer->Password = DSConfig::getVal('SendMail_SMTPPassword');  //'password' password
            }
            //
            if (DSConfig::getVal('SendMail_fromEmail')) {
                $mailer->From = DSConfig::getVal('SendMail_fromEmail');
            } else {
                $mailer->From = $from;
            }
            if (DSConfig::getVal('SendMail_fromName')) {
                $mailer->FromName = DSConfig::getVal('SendMail_fromName');
            } else {
                $mailer->FromName = $fromName;
            }
            $mailer->Subject = $subj;
            $mailer->Body = $body;
            $mailer->addAddress($to);//'00.00@mail.ru' $to
            if (isset($attaches) && $attaches && is_array($attaches)) {
                foreach ($attaches as $filename => $attach) {
                    $attachBase64 = base64_decode($attach);
//                    if (preg_match('/\.(?:jpg|jpeg|png|gif)$/i',$filename)) {
//                        $mailer->addStringEmbeddedImage(($attachBase64 ? $attachBase64 : $attach),md5($filename).'@test.com');
//                    } else {
                    $mailer->addStringAttachment(($attachBase64 ? $attachBase64 : $attach), $filename);
//                    }
                }
            }
            $result = false;
            $result = @$mailer->send();
            if (!$result) {
                LogSiteErrors::logError(CVarDumper::dumpAsString($mailer->ErrorInfo));
            }
            if (DSConfig::getVal('SendMail_isSMTP') == 1) {
                $mailer->smtpClose();
            }
            $mailer->clearAddresses();
            $mailer->clearAttachments();
            unset($mailer);

        } catch (Exception $e) {
            LogSiteErrors::logError(CVarDumper::dumpAsString($e));
            return false;
        }
        return true;
    }

    public static function parseImageAttaches($attaches, $body)
    {
        $result = new stdClass();
        $result->attaches = $attaches;
        $result->body = $body;
        if (preg_match_all(
          '/[\'"](http[s]*:\/\/[a-z0-9%\-_&#\.\?\/]+?([a-z0-9\-_%]+?\.(?:jpg|jpeg|png|gif)))[\'"]/i',
          $result->body,
          $matches
        )) {
            foreach ($matches[0] as $i => $fullMatch) {
                $fullPath = $matches[1][$i];
                $fileName = $matches[2][$i];
                if (!isset(self::$_cachedImages[$fullPath])) {
                    try {
                        $imageData = file_get_contents($fullPath);
                        if (!$imageData) {
                            continue;
                        }
                        self::$_cachedImages[$fullPath] = $imageData;
                    } catch (Exception $e) {
                        continue;
                    }
                } else {
                    $imageData = self::$_cachedImages[$fullPath];
                }
                $result->attaches[$fileName] = base64_encode($imageData);
                $result->body = str_replace($fullPath, md5($fileName) . '@test.com', $result->body);
            }
        }
        return $result;
    }

    public static function sendMail(
      $from,
      $fromName,
      $to,
      $subj,
      $body,
      $queue = false,
      $eventId = -1,
      $postingId = null,
      $attaches = []
    ) {
        $mailQueue = new MailQueue();
        if (DSConfig::getVal('SendMail_fromEmail')) {
            $mailQueue->from = DSConfig::getVal('SendMail_fromEmail');
        } else {
            $mailQueue->from = $from;
        }
        $mailQueue->from_name = $fromName;
        $mailQueue->to = $to;
        $mailQueue->subj = $subj;
        $mailQueue->priority = 0;
        $mailQueue->created = date('Y-m-d H:i:s', time());
        $mailQueue->processed = ($queue ? null : date('Y-m-d H:i:s', time()));
        $mailQueue->result = ($queue ? null : 'OK');
        $mailQueue->event_id = $eventId;
        $mailQueue->posting_id = $postingId;
//       $attachesAndBody=self::parseImageAttaches($attaches,$body);
//       $mailQueue->body = $attachesAndBody->body;
//       $mailQueue->attaches = serialize($attachesAndBody->attaches);
        $mailQueue->body = $body;
        try {
            $mailQueue->attaches = serialize($attaches);
            if ($queue) {
                $res = $mailQueue->save();
                return $res;
            }
            if (self::internalSendMail(
              $from,
              $fromName,
              $to,
              $subj,
              (isset($attachesAndBody) ? $attachesAndBody->body : $body),
              (isset($attachesAndBody) ? $attachesAndBody->$attaches : $attaches)
            )
            ) {
                return $mailQueue->save();
            } else {
                return false;
            }
        } catch (Exception $e) {
            $mailQueue->result = 'ERR';
            $mailQueue->processed = date('Y-m-d H:i:s', time());
            $mailQueue->save();
            return false;
        }
    }

    public static function sendMailFromQueue($countPerRun = false)
    {
        try {
            $cnt = ($countPerRun ? $countPerRun : self::$mailFromQueryPerRun);
            $mailQueueToSend = MailQueue::model()
              ->findAllBySql(
                "SELECT * FROM mail_queue mq
            WHERE mq.processed IS NULL AND mq.\"from\" != 'SMS' ORDER BY priority DESC, created LIMIT {$cnt}"
              );
            if ($mailQueueToSend) {
                foreach ($mailQueueToSend as $mailQueue) {
                    try {
                        $mailQueue->processed = date('Y-m-d H:i:s', time());
                        $mailQueue->result = 'TRY';
                        $mailQueue->update();
                        if (self::internalSendMail(
                          $mailQueue->from,
                          $mailQueue->from_name,
                          $mailQueue->to,
                          $mailQueue->subj,
                          $mailQueue->body,
                          @unserialize($mailQueue->attaches)
                        )
                        ) {
                            $mailQueue->result = 'OK';
                        } else {
                            $mailQueue->result = 'ERR';
                        }
                        $mailQueue->update();
                    } catch (Exception $e) {
                        $mailQueue->result = 'ERR';
                        $mailQueue->processed = date('Y-m-d H:i:s', time());
                        $mailQueue->update();
                        continue;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendMailToAll($message, $queue = true, $templateId = false)
    {
        if (Yii::app()->user->checkAccess('@sendMailToAll')) {
            $mail = new Mail();
            $mail->user = 'all';
            $mail->message = $message;
            return CmsEmailEvents::emailProcessEvents($mail, 'sendMailToAll', $queue, [], $templateId);
        } else {
            return false;
        }
    }

    /**
     * @param integer $uid
     * @param string  $subject
     * @param string  $message
     * @param array   $attaches
     * @param string  $template
     * @return bool
     */
    public static function sendMailToUser($uid, $subject, $message, $attaches = [], $template = 'sendMailToUser')
    {
        $mail = new Mail();
        $mail->user = Users::model()->findByPk($uid);
        $mail->message = $message;
        $mail->subject = $subject;
        if ($mail->user) {
            return CmsEmailEvents::emailProcessEvents($mail, $template, false, $attaches);
        } else {
            return false;
        }
    }
}
