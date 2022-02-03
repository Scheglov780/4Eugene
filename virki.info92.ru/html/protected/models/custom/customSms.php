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
class customSms
{
    public $message;
    public $subject;
    public $user;
    /**
     * @return string the associated database table name
     */
    private static $smsFromQueryPerRun = 10;

    private static function internalSendSms($from, $fromName, $to, $subj, $body)
    {
        try {
            $SendSms_configuration =
              simplexml_load_string(DSConfig::getVal('SendSms_configuration'), null, LIBXML_NOCDATA);
            if (!$SendSms_configuration || !isset($SendSms_configuration->name)) {
                LogSiteErrors::logError('Error: SMS api not configured!');
                return false;
            }
            if ((string) $SendSms_configuration->name == 'telerivet') {
                include_once Yii::app()->basePath . '/components/sms/telerivet.php';
                $api = new Telerivet_API((string) $SendSms_configuration->apiKey);
                $project = $api->initProjectById((string) $SendSms_configuration->projectId);

                $contact = $project->sendMessage([
                  'to_number' => $to,
                  'content'   => $body,
                ]);
                unset($project, $api);
            } else {
                return false;
            }
        } catch (Exception $e) {
            LogSiteErrors::logError(CVarDumper::dumpAsString($e));
            return false;
        }
        return true;
    }

    public static function sendSms(
      $from,
      $fromName,
      $to,
      $subj,
      $body,
      $queue = false,
      $eventId = -1,
      $postingId = null
    ) {
        $mailQueue = new MailQueue();
        $mailQueue->from = $from;
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
            if ($queue) {
                $res = $mailQueue->save();
                return $res;
            }
            if (self::internalSendSms(
              $from,
              $fromName,
              $to,
              $subj,
              $body
            )
            ) {
                return $mailQueue->save();
            } else {
                $mailQueue->result = 'ERR';
                $mailQueue->processed = date('Y-m-d H:i:s', time());
                $mailQueue->save();
                return false;
            }
        } catch (Exception $e) {
            $mailQueue->result = 'ERR';
            $mailQueue->processed = date('Y-m-d H:i:s', time());
            $mailQueue->save();
            return false;
        }
    }

    public static function sendSmsFromQueue($countPerRun = false)
    {
        try {
            $cnt = ($countPerRun ? $countPerRun : self::$smsFromQueryPerRun);
            $mailQueueToSend = MailQueue::model()
              ->findAllBySql(
                "SELECT * FROM mail_queue mq
            WHERE mq.processed IS NULL AND mq.\"from\" = 'SMS' ORDER BY priority DESC, created LIMIT {$cnt}"
              );
            if ($mailQueueToSend) {
                foreach ($mailQueueToSend as $mailQueue) {
                    try {
                        $mailQueue->processed = date('Y-m-d H:i:s', time());
                        $mailQueue->result = 'TRY';
                        $mailQueue->update();
                        if (self::internalSendSms(
                          $mailQueue->from,
                          $mailQueue->from_name,
                          $mailQueue->to,
                          $mailQueue->subj,
                          $mailQueue->body
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
}
