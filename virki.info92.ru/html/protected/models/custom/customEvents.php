<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Events.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "events".
 * The followings are the available columns in table 'events':
 * @property integer $id
 * @property string  $event_name
 * @property string  $event_descr
 * @property string  $event_rules
 * @property string  $event_action
 * @property integer $enabled
 */
class customEvents extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'           => Yii::t('admin', 'id описания события'),
          'event_name'   => Yii::t('admin', 'Системное имя события'),
          'event_descr'  => Yii::t('admin', 'Описание события'),
          'event_rules'  => Yii::t('admin', 'Условие срабатывания события'),
          'event_action' => Yii::t('admin', 'Действия события'),
          'enabled'      => Yii::t('admin', 'Вкл'),
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
          ['enabled', 'numerical', 'integerOnly' => true],
          ['event_name', 'length', 'max' => 512],
          ['event_descr, event_rules, event_action', 'safe'],
            // The following rule is used by search().

          ['id, event_name, event_descr, event_rules, event_action, enabled', 'safe', 'on' => 'search'],
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
        $criteria->compare('event_name', $this->event_name, true);
        $criteria->compare('event_descr', $this->event_descr, true);
        $criteria->compare('event_rules', $this->event_rules, true);
        $criteria->compare('event_action', $this->event_action, true);
        $criteria->compare('enabled', $this->enabled);

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
        return 'events';
    }

    protected static function processEvent($event, $eventSubjects, $model)
    {
        $uid = Yii::app()->user->id;
        $event_name = $event->event_name;
        $event_action = $event->event_action;
        if (isset($eventSubjects[0])) {
            reset($eventSubjects[0]);
        }
        if ($event && $eventSubjects && (isset($eventSubjects[0]) && ((bool) current($eventSubjects[0]) !== false))) {
            foreach ($eventSubjects as $eventSubject) {
                try {
                    $rule_params = [];
                    $rule_params_values = [];
                    $res = preg_match_all('/(?<=:)[a-z0-9-_]+/i', $event_action, $rule_params);
                    if ($res > 0) {
                        foreach ($rule_params[0] as $rule_param) {
                            if (strpos($rule_param, 'new_') === 0) {
                                $new_rule_param = substr($rule_param, 4);
                                if (isset($model[$new_rule_param])) {
                                    $rule_params_values[$rule_param] = $model[$new_rule_param];
                                } else {
                                    $rule_params_values[$rule_param] = null;
                                }
                            } else {
                                if (isset($eventSubject[$rule_param])) {
                                    $rule_params_values[$rule_param] = $eventSubject[$rule_param];
                                } else {
                                    $rule_params_values[$rule_param] = null;
                                }
                            }
                        }
                    }
//          $rule_params_values=array_unique($rule_params_values);
                    $command = Yii::app()->db->createCommand($event_action);
//          $command = Yii::app()->db->pdoInstance->prepare($event_action);
                    $commandParams = [];
                    foreach ($rule_params_values as $rule_param => $rule_params_value) {
                        $commandParams[':' . $rule_param] = $rule_params_values[$rule_param];
                    }
                    $commandParams[':uid'] = $uid;
                    $commandParams[':event_name'] = $event_name;
                    $command->execute($commandParams);
                } catch (Exception $e) {
                    continue;
                }
            }
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Events the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function processEvents($model, $eventType = '.*')
    {
        $events = self::model()->findAll(
          'event_name ~ :event_type and enabled=1',
          [':event_type' => $eventType]
        );
        if ($events) {
            foreach ($events as $event) {
                try {
                    $rule_query = $event->event_rules;
                    $rule_params = [];
                    $rule_params_values = [];
                    $res = preg_match_all('/(?<=:)[a-z0-9-_]+/i', $rule_query, $rule_params);
                    if ($res > 0) {
                        foreach ($rule_params[0] as $rule_param) {
                            if (isset($model[$rule_param])) {
                                $rule_params_values[$rule_param] = $model[$rule_param];
                            } else {
                                $rule_params_values[$rule_param] = null;
                            }
                        }
                    }
//- Make query
//          $rule_params_values=array_unique($rule_params_values);
                    $command = Yii::app()->db->createCommand($rule_query);
                    $commandParams = [];
                    foreach ($rule_params_values as $rule_param => $rule_params_value) {
                        $val = strval($rule_params_values[$rule_param]);
                        $commandParams[':' . $rule_param] = $val;
                        /* $command->bindParam(
                          ':' . $rule_param,
                          $val,
                          PDO::PARAM_STR
                        );
                        */
                    }
                    $eventSubjects = $command->queryAll(true, $commandParams);
                    if ($eventSubjects) {
                        self::processEvent($event, $eventSubjects, $model);
                    }
                } catch (Exception $e) {
                    continue;
                }
            }
        }
    }
}
