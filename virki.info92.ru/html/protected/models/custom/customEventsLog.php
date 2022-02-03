<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="EventsLog.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "events_log".
 * The followings are the available columns in table 'events_log':
 * @property integer $id
 * @property string  $date
 * @property integer $uid
 * @property string  $event_name
 * @property integer $subject_id
 * The followings are the available model relations:
 * @property Events  $eventName
 * @property Users   $u
 */
class customEventsLog extends CActiveRecord
{
    public $eventName;
    public $fromName;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'            => Yii::t('admin', 'id события'),
          'date'          => Yii::t('admin', 'Дата'),
          'uid'           => Yii::t('admin', 'id пользователя, инициировавшего событие'),
          'event_name'    => Yii::t('admin', 'Имя типа события'),
          'subject_id'    => Yii::t('admin', 'id объекта, относительно которого сработало событие'),
          'eventName'     => Yii::t('admin', 'Событие'),
          'fromName'      => Yii::t('admin', 'Пользователь'),
          'subject_value' => Yii::t('admin', 'Значения'),
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'eventName' => [self::BELONGS_TO, 'Events', 'event_name'],
          'u'         => [self::BELONGS_TO, 'Users', 'uid'],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
          ['date, uid, subject_id', 'required'],
          ['uid, subject_id', 'numerical', 'integerOnly' => true],
          ['event_name', 'length', 'max' => 128],
            // The following rule is used by search().

          ['id, date, uid, event_name, subject_id', 'safe', 'on' => 'search'],
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('event_name', $this->event_name, true);
        $criteria->compare('subject_id', $this->subject_id);
        return new CActiveDataProvider(
          $this, [
            'criteria' => $criteria,
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'events_log';
    }

    public static function getEvents(
      $subjectId,
      $eventsType = '.*',
      $pageSize = 5,
      $asArray = false,
      $showInternal = true,
      $filter = ''
    ) {
        // Must to return dataProviders for comments and attaches
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, (select uu.email from users uu where uu.uid=t.uid limit 1) as fromName,
    (select ee.event_descr from events ee where ee.event_name= t.event_name limit 1) as eventName';
        $criteria->condition = '(t.subject_id=:subject_id or :subject_id is null)
and ((t.event_name ~ :event_name) or :event_name is null)
and ((select ee.internal from events ee where ee.event_name=t.event_name)=0 or :internal=1)
' . ($filter ? ' and ' . $filter : '');
        $criteria->params = [
          ':subject_id' => $subjectId,
          ':event_name' => $eventsType,
          ':internal'   => ($showInternal) ? 1 : 0,
        ];
        $criteria->order = 't.date DESC';
        $cacheDependency = new CDbCacheDependency("select last_value from events_log_id_seq");
        $rows = self::model()->cache(3600, $cacheDependency)->findAll($criteria);
        Yii::app()->session->add('EventsLog_records', $rows);
        if ($asArray) {
            return $rows;
        } else {
            $orderComments = new CActiveDataProvider(
              self::model()->cache(3600, $cacheDependency, 2), [
                'criteria'   => $criteria,
                'sort'       => false,
                'pagination' => [
                  'pageSize' => $pageSize,
                ],
              ]
            );
            return $orderComments;
        }
    }

    public static function getLastEventForSubj($subjectId, $eventsType = '.*')
    {
        // Must to return dataProviders for comments and attaches
        $criteria = new CDbCriteria;
        $criteria->select = 't.*, (select uu.email from users uu where uu.uid=t.uid limit 1) as fromName,
    (select ee.event_descr from events ee where ee.event_name= t.event_name limit 1) as eventName';
        $criteria->condition = '(t.subject_id=:subject_id or :subject_id is null)
and ((t.event_name ~ :event_name) or :event_name is null)';
        $criteria->limit = 1;
        $criteria->params = [
          ':subject_id' => $subjectId,
          ':event_name' => $eventsType,
        ];
        $criteria->order = 't.date DESC';
        $rows = self::model()->findAll($criteria);
        return $rows;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return EventsLog|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
