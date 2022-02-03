<?php

/**
 * This is the model class for table "cms_email_events".
 * The followings are the available columns in table 'cms_email_events':
 * @property integer $id
 * @property string  $mailevent_name
 * @property string  $template
 * @property string  $template_sms
 * @property string  $class
 * @property string  $action
 * @property string  $condition
 * @property string  $recipients
 * @property integer $enabled
 * @property string  $regular
 */
class customCmsEmailEvents extends CActiveRecord
{
    private static $testMode = false;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'              => 'ID',
          'template'        => Yii::t('admin', 'Шаблон Email (синтаксис View)'),
          'template_sms'    => Yii::t('admin', 'Шаблон SMS (синтаксис View)'),
          'layout'          => Yii::t('admin', 'Оформление'),
          'class'           => Yii::t('admin', 'Класс события'),
          'action'          => Yii::t('admin', 'Тип события'),
          'condition'       => Yii::t('admin', 'Условие'),
          'recipients'      => Yii::t('admin', 'Получатели'),
          'tests'           => Yii::t('admin', 'Тест'),
          'enabled'         => Yii::t('admin', 'Вкл'),
          'regular'         => Yii::t('admin', 'Повтор'),
          'relevant_fields' => Yii::t('admin', 'Значимые поля'),
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
          ['class, action', 'required'],
          ['enabled', 'numerical', 'integerOnly' => true],
          ['layout, class, action', 'length', 'max' => 255],
          ['regular', 'length', 'max' => 20],
          ['template, template_sms, layout, condition, recipients, tests, relevant_fields', 'safe'],
            // The following rule is used by search().

          [
            'id, template, template_sms, layout, class, action, condition, recipients, relevant_fields, tests, enabled, regular',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {


        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('template', $this->template, true);
        $criteria->compare('template_sms', $this->template_sms, true);
        $criteria->compare('class', $this->class, true);
        $criteria->compare('layout', $this->class, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('condition', $this->condition, true);
        $criteria->compare('recipients', $this->recipients, true);
        $criteria->compare('tests', $this->recipients, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('regular', $this->regular, true);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 50,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cms_email_events';
    }

    private static function compareObjects($new, $old, $relevantFields)
    {
        $result = [];
        $relevantFieldsArray = preg_split('/\s*,\s*/', $relevantFields);
        if (is_array($relevantFieldsArray)) {
            foreach ($relevantFieldsArray as $field) {
                if ($old && $new) {
                    if (((get_class($old) == get_class($new)) && (get_class(
                            $new
                          ) != 'stdClass')) || (isset($old->$field) && isset($new->$field))
                    ) {
                        if ((property_exists($old, $field)
                            || (is_a($old, 'CActiveRecord') && $old->hasAttribute($field)))
                          &&
                          (property_exists($new, $field)
                            || (is_a($new, 'CActiveRecord') && $old->hasAttribute($field)))
                        ) {
                            if (
                              ((string) $old->$field !== (string) $new->$field)
                              || (is_null($old->$field) && (!is_null($new->$field) && (string) $new->$field !== ''))
                              || ((!is_null($old->$field) && (string) $new->$field !== '') && is_null($new->$field))
                              || self::$testMode
                            ) {
                                $result[$field] = new stdClass();
                                $result[$field]->label = (method_exists(
                                  $new,
                                  'getAttributeLabel'
                                ) ? $new->getAttributeLabel($field) : $field);
                                $result[$field]->old = $old->$field;
                                $result[$field]->new = $new->$field;
                            }
                        }
                    }
                } elseif ($new) {
                    if (isset($new->$field)) {
                        $result[$field] = new stdClass();
                        $result[$field]->label = (method_exists($new, 'getAttributeLabel') ? $new->getAttributeLabel(
                          $field
                        ) : $field);
                        $result[$field]->old = $new->$field;
                        $result[$field]->new = $new->$field;
                    }
                }
            }

        }
        if (count($result)) {
            return $result;
        } else {
            return false;
        }
    }

    private static function getEmailEventRecipients($new, $old, $condition)
    {
        $result = false;
        $inExcludeConditionArray = [];
        $inIncludeConditionArray = [];
        $inConditionArray = explode(',', $condition);
        if (!$inConditionArray || !count($inConditionArray)) {
            return false;
        }
        foreach ($inConditionArray as $i => $inCondition) {
            $inConditionArray[$i] = trim($inConditionArray[$i]);
            $tmp = @eval('return ' . $inConditionArray[$i] . ';');
            if (isset($tmp) && strlen($tmp)) {
                if (strpos($tmp, '-') === 0) {
                    $inExcludeConditionArray[] = "'" . preg_replace('/^\-/', '', $tmp) . "'";
                } else {
                    $inIncludeConditionArray[] = "'" . $tmp . "'";
                }
            }
        }
        $inExcludeConditionArray = array_unique($inExcludeConditionArray);
        $inIncludeConditionArray = array_unique($inIncludeConditionArray);
        $inInclude = implode(',', $inIncludeConditionArray);
        $inExclude = implode(',', $inExcludeConditionArray);
        /*
               $userRule='('.($inInclude?'uid in(' . $inInclude . ')':'').($inExclude?' and uid not in (' . $inExclude . ')':'').')';
                $userRule=($userRule!='()'?$userRule:'');
                $roleRule='('.($inInclude?'role in(' . $inInclude . ')':'').($inExclude?' and role not in (' . $inExclude . ')':'').')';
                $roleRule=($roleRule!='()'?$roleRule:'');
                $allRule=$userRule.($userRule && $roleRule?' or '.$roleRule:$roleRule);
                $allRule=($allRule?' and '.$allRule:'');
                if ($allRule) {
                    $sql = 'select distinct * from users where status =1 '.$allRule;
                    $result = Users::model()->findAllBySql($sql);
                }
        */
        if ($inInclude || $inExclude) {
            if (preg_match('/^\'\d+\'$/', $inInclude) &&
              DSConfig::getVal('user_registration_confirmation_needed') == 1) {
                $statusCondition = '(uu.status=1 or uu.status=0)';
            } else {
                $statusCondition = '(uu.status=1)';
            }
            $sql = /** @lang SQL */
              "SELECT uu.* FROM users uu WHERE {$statusCondition} "
              .
              (($inInclude) ?
                ' and (uu.uid::varchar in(' .
                ($inInclude !== '' ? $inInclude : 'null') .
                ') or uu.role in (' .
                ($inInclude !== '' ? $inInclude : 'null') .
                '))' : '')
              .
              (($inExclude) ?
                ' and uu.uid not in (select ue.uid from users ue where ue.uid::varchar in(' .
                ($inExclude !== '' ? $inExclude : 'null') .
                ') or ue.role in (' .
                ($inExclude !== '' ? $inExclude : 'null') .
                '))' : '')
              .
              ' group by uu.uid';
            /*
            select distinct uu.* from users uu where uu.status =1  and (uu.uid in('0') or uu.role in ('0')) and
            uu.uid not in (select ue.uid from users ue where ue.uid in('0') or ue.role in ('0'))
            */
            $result = Users::model()->findAllBySql($sql);
        }
        return $result;
    }

    private static function isEmailEventCondition($new, $old, $condition)
    {
        $result = false;
        $result = @eval($condition);
        return $result;
    }

    private static function render($layout, $text, $_data_, $lang = false)
    {
        //===== Process layout if set =====================================
        if ($layout) {
            $layoutText = cms::customContent($layout, true, true, false, false);
            if ($layoutText && preg_match('/(^.+?<\/mail>)(.+)/is', $text, $matches)) {
                $mailHeader = $matches[1];
                $mailContent = $matches[2];
                $layoutText = $mailHeader . "\r\n" . $layoutText;
                if (preg_match('/<\?(?:php)*\s*(?:=|echo)\s*\$content\s*[;]*\s*\?>/is', $layoutText)) {
                    $textToRender = preg_replace(
                      '/<\?(?:php)*\s*(?:=|echo)\s*\$content\s*[;]*\s*\?>/is',
                      $mailContent,
                      $layoutText
                    );
                } else {
                    $textToRender = $text;
                }

            } else {
                $textToRender = $text;
            }

        } else {
            $textToRender = $text;
        }
        //===== End process layout ========================================
        if ($lang && (Yii::app()->sourceLanguage !== $lang)) {
            $originalLang = Yii::app()->sourceLanguage;
            Yii::app()->sourceLanguage = $lang;
        } else {
            $originalLang = false;
        }
        if (is_array($_data_)) {
            extract($_data_, EXTR_PREFIX_SAME, 'data');
        } else {
            $data = $_data_;
        }
        $open_basedir = ini_get('open_basedir');
        $safe_mode = false;//ini_get('safe_mode');
        try {
            if ($open_basedir || $safe_mode) {
                $tFileName = tempnam(
                  YiiBase::getPathOfAlias('webroot') . '/upload/',
                  'php'
                ) or die('could not create file');
                $tempFile = fopen($tFileName, 'w+');
            } else {
                $tempFile = tmpfile();
            }
            $metaDatas = stream_get_meta_data($tempFile);
            $tmpFilename = $metaDatas['uri'];
            fwrite($tempFile, $textToRender);
            if (!cms::checkPhpSyntax($tmpFilename)) {
                if (isset($originalLang) && $originalLang) {
                    Yii::app()->sourceLanguage = $originalLang;
                }
                echo '<pre>Error in cms message template!</pre>';
                return false;
            }
//      fseek($tempFile, 0);
            ob_start();
            ob_implicit_flush(false);
            include $tmpFilename;
            $content = ob_get_clean();
            fclose($tempFile); // this removes the file
            if (isset($tFileName)) {
                unlink($tFileName);
            }
            if (isset($originalLang) && $originalLang) {
                Yii::app()->sourceLanguage = $originalLang;
            }
            return $content;
        } catch (Exception $e) {
            if (isset($originalLang) && $originalLang) {
                Yii::app()->sourceLanguage = $originalLang;
            }
            return CVarDumper::dumpAsString($e, 6, false);
        }
    }

    private static function sendEmailEventMessage(
      $event,
      $new,
      $old,
      $recipients,
      $comparedFields,
      $queue,
      $attaches = []
    ) {
        $postingId = ($queue ? uniqid() : null);
        foreach ($recipients as $recipient) {
            try {
                if (!self::isSubscribed($recipient->uid, $event->id)) {
                    continue;
                }
                if ($recipient->email) {
                    $from = 'support@' . DSConfig::getVal('site_domain');
                    $fromName = Yii::t('main', 'Cлужба поддержки') . ' ' . DSConfig::getVal('site_name');
                    $subj = Yii::t('main', 'Сообщение от службы поддержки') . ' ' . DSConfig::getVal('site_name');
                    $body = @self::render(
                      $event->layout,
                      $event->template,
                      [
                        'event'          => $event,
                        'new'            => $new,
                        'old'            => $old,
                        'recipient'      => $recipient,
                        'comparedFields' => $comparedFields,
                      ]
                    );
                    if ($body) {
                        if (preg_match('/<from>(.*?)<\/from>/is', $body, $matches)) {
                            $from = $matches[1];
                        }
                        if (preg_match('/<fromName>(.*?)<\/fromName>/is', $body, $matches)) {
                            $fromName = $matches[1];
                        }
                        if (preg_match('/<subj>(.*?)<\/subj>/is', $body, $matches)) {
                            $subj = $matches[1];
                        }
                        $body = preg_replace('/\s*<mail>.*?<\/mail>\s*/is', '', $body);
                        Mail::sendMail(
                          $from,
                          $fromName,
                          $recipient->email,
                          $subj,
                          $body,
                          $queue,
                          $event->id,
                          $postingId,
                          $attaches
                        );
                    }
                }
                // Send SMS =================================
                if (DSConfig::getVal('SendSms_enabled') && $recipient->phone) {
                    $from = 'SMS';
                    $fromName = Yii::t('main', 'Cлужба поддержки') . ' ' . DSConfig::getVal('site_name');
                    $subj = Yii::t('main', 'Сообщение от службы поддержки') . ' ' . DSConfig::getVal('site_name');
                    $body = @self::render(
                      false,
                      $event->template_sms,
                      [
                        'event'          => $event,
                        'new'            => $new,
                        'old'            => $old,
                        'recipient'      => $recipient,
                        'comparedFields' => $comparedFields,
                      ]
                    );
                    if ($body) {
                        if (preg_match('/<fromName>(.*?)<\/fromName>/is', $body, $matches)) {
                            $fromName = $matches[1];
                        }
                        $body = preg_replace('/\s*<sms>.*?<\/sms>\s*/is', '', $body);
                        Sms::sendSms($from, $fromName, $recipient->phone, $subj, $body, $queue, $event->id, $postingId);
                    }
                }
                //===========================================
            } catch (Exception $e) {
                continue;
            }
        }
        return true;
    }

    public static function emailEventTest($id)
    {
        $event = self::model()->findByPk($id);
        $result = false;
        if (!$event) {
            return false;
        }
        self::$testMode = true;
        $result = @eval($event->tests);
        return $result;
    }

    public static function emailProcessEvents(
      $sender,
      $action,
      $queue = false,
      $attaches = [],
      $templateId = false
    ) {
        try {
            $result = false;
            $class = get_class($sender);
            if ($action == 'beforeUpdate') {
                $old = $sender->findByPk($sender->primaryKey);
            } else {
                $old = false;
            }
            $events = self::model()->findAll(
              'class=:class and action=:action and enabled=1 and (id=:id or :id is null)',
              [
                ':class'  => $class,
                ':action' => $action,
                ':id'     => (($templateId) ? $templateId : null),
              ]
            );
            if ($events) {
                foreach ($events as $i => $event) {
                    if (self::isEmailEventCondition($sender, $old, $event->condition)) {
                        $recipients = self::getEmailEventRecipients($sender, $old, $event->recipients);
                        if ($recipients) {
                            $comparedFields = self::compareObjects($sender, $old, $event->relevant_fields);
                            if ($comparedFields || !$event->relevant_fields) {
                                $result = true;
                                self::sendEmailEventMessage(
                                  $event,
                                  $sender,
                                  $old,
                                  $recipients,
                                  $comparedFields,
                                  ((DSConfig::getVal(
                                      'SendMail_isSMTP'
                                    ) == 1 && $action != 'sendMailToUser') ? true : $queue),
                                  $attaches
                                );
                            }
                        }
                    }
                }
            }
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getEventStatistic($eventId)
    {
        $res = Yii::app()->db->createCommand(
          "
        SELECT count(0) AS cnt, max(qq.processed) AS last_processed FROM mail_queue qq WHERE qq.event_id = :event_id AND qq.processed>=(NOW() - INTERVAL '48 HOUR') 
        "
        )->queryRow(true, [':event_id' => $eventId]);
        return $res;
    }

    public static function getEventsAndSubscroptionsForUser($uid)
    {
        Yii::app()->db->createCommand(
          "DELETE FROM cms_email_unsubscribe WHERE uid=:uid 
AND date_from<=(Now() - INTERVAL '45 DAY')"
        )->execute(
          [':uid' => $uid]
        );
        $events = Yii::app()->db->createCommand(
          "
SELECT ee.id, ee.template, uu.date_from FROM cms_email_events ee
LEFT JOIN cms_email_unsubscribe uu ON uu.event_id=ee.id AND uu.date_from > (Now() - INTERVAL '365 DAY') 
AND uu.uid = :uid
WHERE ee.enabled=1  
"
        )->queryAll(true, [':uid' => $uid]);
        $user = Users::model()->findByPk($uid);
        $isManager = (!in_array($user->role, ['guest', 'user']));
        $result = [];
        if ($events) {
            foreach ($events as $event) {
                $nameFound = preg_match('/^\s*<\?\s*\/\/\s*(.*?)\s*\?>/', $event['template'], $matches);
                if ($nameFound) {
                    $name = Yii::t('main', $matches[1]);
                } else {
                    $name = Yii::t('main', 'Не определено');
                }
                if (!$isManager && preg_match('/(?:manager|менеджер|закупщик)/ius', $name)) {
                    continue;
                }
                $result[] = [
                  'id'     => $event['id'],
                  'name'   => $name,
                  'enable' => (is_null($event['date_from']) ? 1 : 0),
                ];
            }
        }
        $resultDataProvider = new CArrayDataProvider(
          $result, [
            'id'         => 'EventsAndSubscroptionsForUserDataProvider',
            'keyField'   => 'id',
            'pagination' => [
              'pageSize' => 10000,
            ],
          ]
        );
        return $resultDataProvider;
//==================
    }

    public static function isSubscribed($uid, $event_id)
    {
        if (isset(Yii::app()->memCache)) {
            $gc = @Yii::app()->memCache->get('unsubscribed-gc');
        } else {
            $gc = @Yii::app()->cache->get('unsubscribed-gc');
        }
        if (!$gc) {
            Yii::app()->db->createCommand(
              "DELETE FROM cms_email_unsubscribe WHERE uid=:uid 
AND date_from<=(Now() - INTERVAL '45 DAY')"
            )->execute(
              [':uid' => $uid]
            );
            if (isset(Yii::app()->memCache)) {
                @Yii::app()->memCache->set('unsubscribed-gc', 1, 3600);
            } else {
                @Yii::app()->cache->set('unsubscribed-gc', 1, 3600);
            }
        }
        $res = Yii::app()->db->createCommand(
          "SELECT 'x' FROM cms_email_unsubscribe
        WHERE uid=:uid AND event_id=:event_id AND date_from>(Now() - INTERVAL '45 DAY')"
        )->execute([':uid' => $uid, ':event_id' => $event_id]);
        if (!$res) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsEmailEvents|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function setArraySubscribed($uid, $events)
    {
        $availableEvents = Yii::app()->db->createCommand(
          "
SELECT ee.id FROM cms_email_events ee
WHERE ee.enabled=1  
"
        )->queryColumn();
        if ($availableEvents) {
            foreach ($availableEvents as $availableEvent) {
                if (is_array($events) && isset($events[$availableEvent])) {
                    self::setSubscribed($uid, $availableEvent);
                } else {
                    self::setUnsubscribed($uid, $availableEvent);
                }
            }
        }
    }

    public static function setSubscribed($uid, $event_id)
    {
        Yii::app()->db->createCommand(
          "
         DELETE FROM cms_email_unsubscribe WHERE uid=:uid AND event_id=:event_id"
        )
          ->execute([':uid' => $uid, ':event_id' => $event_id]);
    }

    public static function setUnsubscribed($uid, $event_id)
    {
        Yii::app()->db->createCommand(
          "
        INSERT INTO cms_email_unsubscribe (uid,event_id,date_from)
        VALUES (:uid,:event_id, Now())
        ON CONFLICT ON CONSTRAINT cms_email_unsubscribe_constr 
        DO NOTHING"
        )->execute([':uid' => $uid, ':event_id' => $event_id]);
    }
}
