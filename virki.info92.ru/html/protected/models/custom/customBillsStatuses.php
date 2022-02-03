<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsStatuses.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "bills_statuses".
 * The followings are the available columns in table 'bills_statuses':
 * @property integer $id
 * @property string  $value
 * @property string  $name
 * @property string  $descr
 * @property integer $manual
 * @property string  $aplyment_criteria
 * @property string  $auto_criteria
 * @property integer $order_in_process
 * @property integer $enabled
 * The followings are the available model relations:
 * @property Bills[] $bills
 */
class customBillsStatuses extends CActiveRecord
{
    private static $_billStatusesManual0 = false;
    private static $_billStatusesManual1 = false;
    private static $_statusesEnabledDBQuery = false;
    private static $_statusesForFilter = false;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'                  => Yii::t('main', 'id записи статуса. Внимание, в расчетах не используется!'),
          'value'               => Yii::t('main', 'ID статуса для расчетов'),
          'name'                => Yii::t('main', 'Название'),
          'descr'               => Yii::t('main', 'Описание статуса'),
          'manual'              => Yii::t('main', 'Устанавливается ли статус вручную'),
          'aplyment_criteria'   => Yii::t('main', 'Условие применения статуса'),
          'auto_criteria'       => Yii::t('main', 'Условие вычисления статуса'),
          'order_in_process'    => Yii::t('main', 'Порядок статуса в бизнес-процессе'),
          'enabled'             => Yii::t('main', 'Включен ли статус'),
          'parent_status_value' => Yii::t('main', 'Статус, определяющий поведение'),
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
          'bills' => [self::HAS_MANY, 'Bills', 'status'],
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
          ['value, name', 'required'],
          ['manual, order_in_process, enabled', 'numerical', 'integerOnly' => true],
          ['value', 'length', 'max' => 128],
          ['parent_status_value', 'length', 'max' => 128],
          ['name', 'length', 'max' => 256],
          ['descr, aplyment_criteria, auto_criteria', 'safe'],
            // The following rule is used by search().

          [
            'id, value, name, descr, manual, aplyment_criteria, auto_criteria, order_in_process, enabled, parent_status_value',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    public function search()
    {


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('descr', $this->descr, true);
        $criteria->compare('manual', $this->manual);
        $criteria->compare('aplyment_criteria', $this->aplyment_criteria, true);
        $criteria->compare('auto_criteria', $this->auto_criteria, true);
        $criteria->compare('order_in_process', $this->order_in_process);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('parent_status_value', $this->enabled);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.enabled DESC, t.order_in_process ASC',
            ],
            'pagination' => [
              'pageSize' => 100,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bills_statuses';
    }

//=================================================================
// Возвращает список статусов и кол-во заказов в них

    public static function getAllStatusesListAndBillCount($uid = false, $manager = false, $withAllStatuses = false)
    {
        if ($uid === false) {
            $_uid = null;
        } else {
            $_uid = $uid;
        }
        if ($manager === false) {
            $_manager = null;
        } else {
            $_manager = $manager;
        }
        if (!self::$_statusesEnabledDBQuery) {
            $command = Yii::app()->db->createCommand(
              "SELECT id, value, name, descr, manual, aplyment_criteria, auto_criteria, 
       order_in_process, enabled, parent_status_value 
       FROM bills_statuses bs WHERE bs.enabled=1
 UNION ALL
SELECT 0 as id, 'ALL' as value, 'Все счета' as name, null as descr, 
       0 as manual, null as aplyment_criteria, null as auto_criteria, 
       -10 as order_in_process, 1 as enabled, null as parent_status_value 
ORDER BY order_in_process"
            );
            self::$_statusesEnabledDBQuery = $command->queryAll();
        }
        $statuses = self::$_statusesEnabledDBQuery;
        $cacheDependency = new CDbCacheDependency(
          "select sum(lval) from
( SELECT last_value as lval FROM events_log_id_seq
union all
SELECT last_value as lval FROM bills_payments_id_seq) tt"
        );
        if ($statuses) {
            foreach ($statuses as $i => $status) {
                if ($status['manual'] == 1) {
                    $cntAndDate = Yii::app()->db->cache(3600, $cacheDependency)->createCommand(
                      "SELECT count(0) AS cnt, max(date) AS lastdate, round(sum(actual_summ),2) AS totalsum,
          round(sum(coalesce(paid_summ,0)),2) AS totalpayed,
round(sum(coalesce(paid_summ,0))-sum(actual_summ),2) AS totalnopayed
FROM bills_for_statuses_view bb 
WHERE status=:value AND (bb.uid=:uid OR :uid::integer IS NULL) AND (bb.manager_id=:manager OR :manager::integer IS NULL)"
                    )->queryRow(
                      true,
                      [
                        ':value'   => $status['value'],
                        ':uid'     => $_uid,
                        ':manager' => $_manager,
                      ]
                    );
                } else {
                    $auto_criteria = trim($status['auto_criteria'], " \t\n\r\0\\x0B;");
                    if (!$auto_criteria) {
                        if ($status['id'] == 0) {
                            $auto_criteria = "SELECT id FROM bills_for_statuses_view bb 
                           WHERE (bb.uid=:uid OR :uid::integer IS NULL) 
                                  AND (bb.manager_id=:manager OR :manager::integer IS NULL)";
                        } else {
                            $auto_criteria = "SELECT id FROM bills_for_statuses_view bb 
                              WHERE (bb.uid=:uid OR :uid::integer IS NULL) 
                                  AND (bb.manager_id=:manager OR :manager::integer IS NULL)
                                  AND 1=0";
                        }
                    }
                    $cntAndDate = Yii::app()->db->cache(3600, $cacheDependency)->createCommand(
                      "SELECT count(0) AS cnt, max(date) AS lastdate, round(sum(actual_summ),2) AS totalsum,
          round(sum(coalesce(paid_summ,0)),2) AS totalpayed,
round(sum(coalesce(paid_summ,0))-sum(actual_summ),2) AS totalnopayed
FROM bills_for_statuses_view bb where
bb.id in ({$auto_criteria})"
                    )->queryRow(
                      true,
                      [
                        ':uid'     => $_uid,
                        ':manager' => $_manager,
                      ]
                    );
                }
                $statuses[$i]['count'] = $cntAndDate['cnt'];
                $statuses[$i]['lastdate'] = $cntAndDate['lastdate'];
                $statuses[$i]['totalsum'] = $cntAndDate['totalsum'];
                $statuses[$i]['totalpayed'] = $cntAndDate['totalpayed'];
                $statuses[$i]['totalnopayed'] = $cntAndDate['totalnopayed'];
            }
            if (!$withAllStatuses) {
                unset($statuses[0]);
            }
            return $statuses;
        } else {
            return [];
        }
    }

//-------------------------

    public static function getAllowedStatusesForAccess()
    {
        $result = [];
        $statuses = Yii::app()->db->createCommand("select os.value from bills_statuses os where os.enabled = 1")
          ->queryColumn();
        if ($statuses) {
            foreach ($statuses as $status) {
                if (Yii::app()->user->checkAccess('&billStatus=' . $status)) {
                    $result[$status] = "'" . $status . "'";
                }
            }
        }
        return $result;
    }

//-----------------------------------------------------------------

    public static function getAllowedStatusesForBill($id, $uid, $manager)
    {
        if (!self::$_billStatusesManual1) {
            self::$_billStatusesManual1 = BillsStatuses::model()->findAll(
              'enabled=1 and manual=1 order by order_in_process'
            );
        }
        $billStatuses = self::$_billStatusesManual1;
        $result = [];
        foreach ($billStatuses as $billStatus) {
            if (!$billStatus['aplyment_criteria']) {
                continue;
            }
            $aplyment_criteria = trim($billStatus['aplyment_criteria'], " \t\n\r\0\\x0B;");
            if (!$aplyment_criteria) {
                $aplyment_criteria = 'SELECT id FROM bills_for_statuses_view WHERE 1=0';
            }
            $bill = Bills::model()->findBySql(
              'SELECT bb.id FROM bills_for_statuses_view bb WHERE bb.id IN (' . $aplyment_criteria . ') AND bb.id=:id',
              [':id' => $id, ':uid' => $uid, ':manager' => $manager]
            );
            if ($bill || Yii::app()->user->checkAccess('@allowChangeAnyBillState')
            ) {
                $result[$billStatus['value']] = Yii::t('main', $billStatus['name']);
            }
        }
        return $result;
    }

    public static function getCaseQueryForBillExtStatus($returnAsName = true)
    {
        if (!self::$_billStatusesManual0) {
            self::$_billStatusesManual0 = BillsStatuses::model()->findAll(
              'enabled=1 and manual=0 order by order_in_process'
            );
        }
        $billStatuses = self::$_billStatusesManual0;
        $caseQuery = '';
        foreach ($billStatuses as $billStatus) {
            $auto_criteria = trim($billStatus['auto_criteria'], " \t\n\r\0\\x0B;");
            if (!$auto_criteria) {
                $auto_criteria = 'SELECT id FROM bills_for_statuses_view WHERE 1=0';
            }
            $caseQuery =
              $caseQuery .
              " WHEN t.id IN (" .
              $auto_criteria .
              ") THEN '" .
              ($returnAsName ? $billStatus['name'] : $billStatus['value']) .
              "'
      ";
        }
        $caseQuery = " CASE " . $caseQuery . " ELSE '' END ";
        return $caseQuery;
    }

    public static function getInQueryForBillStatus($status)
    {
        $allStatuses = Yii::app()->db->createCommand("select * from bills_statuses os");
        if ($status != null) {
            $billStatus = BillsStatuses::model()->find('value=:value', [':value' => $status]);
            //@todo: разобраться с запросами
            if ($billStatus['manual'] == 1) {
                $query = "select bb.id from bills_for_statuses_view bb where bb.status='{$billStatus['value']}'";
            } else {
                $query = trim($billStatus['auto_criteria'], " \t\n\r\0\\x0B;");
            }
        } else {
            $query = 'SELECT bb.id FROM bills_for_statuses_view bb';
        }
        if (!$query) {
            $query = 'SELECT bb.id FROM bills_for_statuses_view bb';
        }
        return $query;
    }

    public static function getStatusListForFilter()
    {
        if (!self::$_statusesForFilter) {
            self::$_statusesForFilter = static::model()->findAll('enabled=1 and manual=1 order by order_in_process');
        }
        $billStatuses = self::$_statusesForFilter;
        $result = [];
        foreach ($billStatuses as $billStatus) {
            $result[$billStatus['value']] = Yii::t('main', $billStatus['name']);
        }
        return $result;
    }

    public static function getStatusName($status)
    {
        $res = static::model()->find('value=:value', [':value' => $status]);
        if ($res) {
            return Yii::t('main', $res->name);
        } else {
            return '-';
        }
    }

    public static function getStatusesArrayWithChildren($statuses)
    {
        foreach ($statuses as $i => $status) {
            $statuses[$i] = "'" . $status . "'";
        }
        $inQueryStr = implode(',', $statuses);
        $result = Yii::app()->db->createCommand(
          "
        select distinct \"value\" from bills_statuses where \"value\" in (" . $inQueryStr . ")
        or parent_status_value in (" . $inQueryStr . ")
        "
        )->queryColumn();
        return $result;
    }

    public static function isAllowedStatusForBill($status, $id, $uid, $manager)
    {
        $billStatuses = self::getAllowedStatusesForBill($id, $uid, $manager);
        return isset($billStatuses[$status]);
    }

}
