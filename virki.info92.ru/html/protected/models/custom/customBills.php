<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * =================================================================================================================
 * <description file="customBills.php">
 * </description>
 *******************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "bills".
 * The followings are the available columns in table 'bills':
 * @property integer $id
 * @property integer $tariff_object_id
 * @property string  $status
 * @property string  $date
 * @property integer $manager_id
 * @property integer $tariff_id
 * @property string  $summ
 * @property string  $code
 * @property string  $manual_summ
 * @property integer $frozen
 */
class customBills extends DSEventableActiveRecord
{
    public $acceptor_name;
    public $ext_status_name;
    public $j_acceptor;
    public $j_land;
    public $j_payments;
    public $j_tariff;
    public $j_user;
    public $land_name;
    public $lands_id;
    public $manager_name;
    public $paid_summ;
    public $status_name;
    public $tariff_name;
    public $tariff_object_id_device;
    public $tariff_object_id_land;
    public $tariff_short_name;
    public $uid;
    public $user_name;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'                      => Yii::t('main', 'ID'),
          'tariff_object_id'        => Yii::t('main', 'Объект'),
          'status'                  => Yii::t('main', 'Статус'),
          'date'                    => Yii::t('main', 'Дата выставления счёта'),
          'manager_id'              => Yii::t('main', 'Менеджер'),
          'tariff_id'               => Yii::t('main', 'Тариф'),
          'summ'                    => Yii::t('main', 'Сумма счёта'),
          'code'                    => Yii::t('main', 'Трек-код'),
          'manual_summ'             => Yii::t('main', 'Сумма счёта вручную'),
          'frozen'                  => Yii::t('main', 'Заблокирован'),
          'tariff_name'             => Yii::t('main', 'Тариф'),
          'tariff_short_name'       => Yii::t('main', 'Тариф'),
          'user_name'               => Yii::t('main', 'Плательщик'),
          'uid'                     => Yii::t('main', 'Плательщик'),
          'land_name'               => Yii::t('main', 'Участок'),
          'lands_id'                => Yii::t('main', 'Участок'),
          'acceptor_name'           => Yii::t('main', 'Получатель'),
          'manager_name'            => Yii::t('main', 'Менеджер'),
          'status_name'             => Yii::t('main', 'Статус'),
          'ext_status_name'         => Yii::t('main', 'Доп. статус'),
          'paid_summ'               => 'Оплачено, сумма',
          'tariff_object_id_device' => 'Прибор учёта',
          'tariff_object_id_land'   => 'Участок',
        ];
    }

    public function getAttributes($names = true)
    {
        $attr = parent::getAttributes($names);
        return $attr;
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
          ['id, tariff_object_id, date, tariff_id', 'required', 'on' => 'update'],
          ['tariff_object_id_land,tariff_object_id_device, tariff_id, summ', 'required', 'on' => 'create'],
          [
            'id, tariff_object_id, tariff_object_id_land,tariff_object_id_device, manager_id, tariff_id, frozen',
            'numerical',
            'integerOnly' => true,
          ],
          ['status, code', 'length', 'max' => 128],
          ['summ, manual_summ', 'length', 'max' => 12],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'id, tariff_object_id, status, date, manager_id, tariff_id, summ, code, manual_summ, frozen,tariff_name,tariff_short_name,user_name,uid,land_name,lands_id,acceptor_name,manager_name,status_name',
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
    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        if (empty($criteria)) {
            $criteria = new CDbCriteria;
        }
        if (empty($dataProviderId)) {
            $dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()) . '_dataProvider';
        }
        $caseQueryForBillExtStatus = BillsStatuses::getCaseQueryForBillExtStatus();
        $alowedStatuses = BillsStatuses::getAllowedStatusesForAccess();

        if (is_array($alowedStatuses) and count($alowedStatuses)) {
            $alowedStatusesIn = implode(',', $alowedStatuses);
        } else {
            $alowedStatusesIn = 'null';
        }

        $criteria->select =
          /** @lang PostgreSQL */
          "t.*,
           case
when (ot.tariff_rules->>'target'::text) = 'land'::text then t.tariff_object_id else null end as tariff_object_id_land, 
           case
when (ot.tariff_rules->>'target'::text) = 'device'::text then t.tariff_object_id else null end as tariff_object_id_device,    
          ot.tariff_name, 
          ot.tariff_short_name,
          uu.fullname as user_name,
          uu.uid,
          ol.land_group||'/№'||ol.land_number as land_name,
          ol.lands_id,
          ta.name||', '||ta.bank as acceptor_name,
          mm.fullname as manager_name,
          bs.name as status_name,
          {$caseQueryForBillExtStatus} as ext_status_name,
          (select sum(bp2.summ) from bills_payments bp2 where bp2.bid = t.id) as paid_summ,
         ROW_TO_JSON(ot) as j_tariff,
         ROW_TO_JSON(ta) as j_acceptor,
         (select jsonb_agg(rpayments) from (
          select bp.* from bills_payments bp
          where bp.bid = t.id order by bp.date
          ) rpayments) as j_payments,
					ROW_TO_JSON(uu) as j_user,
					ROW_TO_JSON(ol) as j_land
          ";
        $criteria->join = $criteria->join .
          /** @lang PostgreSQL */
          "
left join obj_tariffs ot on ot.tariffs_id = t.tariff_id
left join users mm on mm.uid = t.manager_id
left join obj_tariffs_acceptors ta on ta.tariff_acceptors_id = ot.acceptor_id
inner join bills_statuses bs on bs.value::text = t.status::text and (bs.value in ({$alowedStatusesIn}) OR (:uid::integer is null and :manager::integer is null))
left join obj_lands_tariffs olt on olt.lands_id = t.tariff_object_id 
and olt.tariffs_id = ot.tariffs_id and olt.deleted is null 
and (ot.tariff_rules->>'target'::text) = 'land'::text
left join obj_devices_tariffs odt on odt.devices_id = t.tariff_object_id 
and odt.tariffs_id = ot.tariffs_id and odt.deleted is null 
and (ot.tariff_rules->>'target'::text) = 'device'::text
left join obj_lands_devices oldd on
case
when odt.devices_id is not null then oldd.devices_id = odt.devices_id and oldd.deleted is null
when (ot.tariff_rules ->> 'target'::text) = 'device'::text then oldd.devices_id = t.tariff_object_id
else null::boolean
end
left join obj_lands ol on ol.lands_id = 
case
when olt.lands_id is not null then olt.lands_id
when oldd.lands_id is not null then oldd.lands_id
when (ot.tariff_rules ->> 'target'::text) = 'land'::text then t.tariff_object_id
else null::integer
end
left join obj_users_lands ul on ul.lands_id = ol.lands_id and ul.deleted is null
left join users uu on uu.uid = ul.uid
        ";
        $criteria->compare('t.id', $this->id);
        //$criteria->compare('t.tariff_object_id', $this->tariff_object_id);
        if ($this->status) {
            $criteria->addSearchCondition('t.status', $this->status, true, 'AND', 'ILIKE');
        }
        if ($this->date) {
            $criteria->addSearchCondition('t.date', $this->date, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.manager_id', $this->manager_id);
        $criteria->compare('t.tariff_id', $this->tariff_id);
        $criteria->compare('uu.uid', $this->uid);
        $criteria->compare('ol.lands_id', $this->lands_id);
        if ($this->summ) {
            $criteria->addSearchCondition('summ', $this->summ, true, 'AND', 'ILIKE');
        }
        if ($this->code) {
            $criteria->addSearchCondition('t.code', $this->code, true, 'AND', 'ILIKE');
        }
        if ($this->manual_summ) {
            $criteria->addSearchCondition('t.manual_summ', $this->manual_summ, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.frozen', $this->frozen);
        if (!isset($criteria->params[':uid'])) {
            $criteria->params[':uid'] = null;
        }
        if (!isset($criteria->params[':manager'])) {
            $criteria->params[':manager'] = null;
        }
        if ($cacheDependency) {
            $modelClass = Bills::model()->cache(3600, $cacheDependency, 2);
        } else {
            $modelClass = $this;
        }
        return new CActiveDataProvider(
          $modelClass,
          [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'id'   => [
                  'asc'  => 't.id ASC',
                  'desc' => 't.id DESC',
                ],
                'date' => [
                  'asc'  => 't.date ASC',
                  'desc' => 't.date DESC',
                ],
                'code' => [
                  'asc'  => 't.code ASC',
                  'desc' => 't.code DESC',
                ],
              ],
              'defaultOrder' => [
                'date' => CSort::SORT_DESC,
              ],
            ],
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'bills';
    }

    public static function cancelOldUnpaid($daysAgo = 7)
    {
        $sql = "select bb.id from bills bb
            where
             (bb.status IN ('IN_PROCESS')
             OR bb.status in (SELECT \"value\" from bills_statuses where parent_status_value in ('IN_PROCESS'))
             )               
               and bb.frozen<>1
               and not exists(select 'x' from bills_payments bp where bp.bid = bb.id)
               and bb.date < (Now() - interval '{$daysAgo} day')";
        $billIds = Yii::app()->db->createCommand($sql)->queryColumn();
        if ($billIds) {
            foreach ($billIds as $billId) {
                $bill = Bills::model()->findByPk($billId);
                if ($bill) {
                    $bill->status = 'CANCELED_BY_SERVICE';
                    $bill->update();
                }
            }
        }
    }

    public static function executeSql($sql)
    {
        if ($sql) {
            try {
                Yii::app()->db->createCommand($sql)->execute();
            } catch (Exception $e) {
                Utils::debugLog(CVarDumper::dumpAsString($e));
            }
        }
    }

    public static function getAdminBillsList(
      $status,
      $uid = false,
      $manager = false,
      $pageSize = 25,
      $orderBy = '',
      $model = null
    ) {
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
        if ($status != null) {
            $billStatus = BillsStatuses::model()->find(
              '"value"=:value or parent_status_value=:value',
              [':value' => $status]
            );
        } else {
            $billStatus = new stdClass();
            $billStatus->name = Yii::t('admin', 'Все');
            $billStatus->value = null;
        }
        $alowedStatuses = BillsStatuses::getAllowedStatusesForAccess();
        if (is_array($alowedStatuses) and count($alowedStatuses)) {
            $alowedStatusesIn = implode(',', $alowedStatuses);
        } else {
            $alowedStatusesIn = 'null';
        }

        $criteria = new CDbCriteria;
        $inQueryForBillStatus = BillsStatuses::getInQueryForBillStatus($billStatus->value);
        $criteria->condition = "(uu.uid=:uid or :uid is null) 
        and (t.manager_id=:manager or :manager is null) and t.id IN ({$inQueryForBillStatus})";
        $criteria->params = [':uid' => $_uid, ':manager' => $_manager];
        $cacheDependency = new CDbCacheDependency(
          "select sum(lval) from
( SELECT last_value as lval FROM events_log_id_seq
union all
SELECT last_value as lval FROM bills_payments_id_seq) tt"
        );
        if ($model) {
            $bills = $model;
        } else {
            $bills = new Bills('search');
            $bills->unsetAttributes();
        }

        $billsDataProvider = $bills->search(
          $criteria,
          $pageSize,
          $cacheDependency,
          'adminBillsListDataProvider' . ($status ? '_' . $status : '')
        );
        return $billsDataProvider;
    }

    public static function getBillExtStatus($id, $returnAsName = true)
    {
        $extStatus = static::model()
          ->findBySql(
            "select " . BillsStatuses::getCaseQueryForBillExtStatus(
              $returnAsName
            ) . ' as extstatuses from bills_for_statuses_view t where t.id=:id',
            [
              ':id'         => $id,
              ':uid'        => null,
              ':manager_id' => null,
            ]
          );
        if ($extStatus) {
            $res = $extStatus['extstatuses'];
            if ($returnAsName) {
                return Yii::t('main', $res);
            } else {
                return $res;
            }
        } else {
            return '';
        }
    }

    public static function getBillsList($status, $uid = false, $manager = false)
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
        $billStatus = BillsStatuses::model()->find('"value"=:value', [':value' => $status]);
        $criteria = new CDbCriteria;
        $criteria->condition =
          '(uid=:uid or manager_id=:manager) and t.id IN (' . BillsStatuses::getInQueryForBillStatus(
            $billStatus->value
          ) . ')';
        $criteria->params = [':uid' => $_uid, ':manager' => $_manager];
        $cacheDependency = new CDbCacheDependency(
          "select sum(lval) from
( SELECT last_value as lval FROM events_log_id_seq
union all
SELECT last_value as lval FROM bills_payments_id_seq) tt"
        );
        $bills = new Bills('search');
        $bills->unsetAttributes();
        $billsDataProvider = $bills->search(
          $criteria,
          25,
          $cacheDependency
        );
        return $billsDataProvider;
    }

    public static function getModelSearchSnippet($id, $query)
    {
        if (!function_exists('markup')) {
            function markup($val, $query)
            {
                $result = @preg_replace('/' . $query . '/i', '<strong>' . $query . '</strong>', $val);
                if (isset($result) && $result) {
                    return $result;
                } else {
                    return $val;
                }
            }
        }
        $model = self::model()->findByPk($id);
        $res = '';
        $fields = [
          'code',
            /* 'description',
             'comments', */
        ];
        if ($model) {
            foreach ($fields as $field) {
                if (strlen($model->{$field}) > 0) {
                    $res = $res . '<small>' . $model->getAttributeLabel($field) . ':</small> ' . markup(
                        $model->{$field},
                        $query
                      ) . '&nbsp;';
                }
            }
        }
        return $res;
    }

    public static function getUpdateLink($id, $external = false, $model = null, $value = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($model)) {
            $model = self::model()->findByPk($id);
        }
        if ($model) {
            if (is_null($value)) {
                $value = addslashes($model->name);
            }
            $tabName = addslashes($model->name);
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . "/admin/main/open?url=admin/bills/view/id/" . $id . '&tabName=' . $tabName;
            } else {
                $url = Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/bills/view', ['id' => $id]);
                return '<a href="' .
                  $url .
                  '" title="' .
                  Yii::t(
                    'admin',
                    'Просмотр счёта'
                  ) .
                  '" onclick="getContent(this,\'' .
                  $tabName .
                  '\',false);return false;"><i class="fa fa-trash"></i>&nbsp;' .
                  $value .
                  '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return DSActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function remindToPay($statuses = false, $daysOld = false)
    {
        if (!is_array($statuses)) {
            $statuses = ['IN_PROCESS'];
        }
        $bills = [];
        foreach ($statuses as $status) {
            $statusBills = self::getAdminBillsList($status, null, null, 100000);
            $bills = array_merge($bills, ($statusBills ? $statusBills : []));
        }
        $bills = array_unique($bills);
        if ($bills) {
            /** @var Bills $bill */
            foreach ($bills as $bill) {
                //@todo: неправильная арифметика с датами
                $billDaysOld = (time() - $bill->date) / (24 * 3600);
                $statusesArrayWithChildren = BillsStatuses::getStatusesArrayWithChildren($statuses);
                $billExtStatus = static::getBillExtStatus($bill->id, false);
                if ((in_array($bill->status, $statusesArrayWithChildren) || (in_array(
                      $billExtStatus,
                      $statusesArrayWithChildren
                    )))
                  && (!$bill->paid_summ) && ($billDaysOld >= (float) $daysOld || $daysOld == false)) { //>
                    CmsEmailEvents::emailProcessEvents($bill, 'remindToPay', true);
                }
            }
        }
    }

    public static function remindToProcess()
    {
        /*        Yii::app()->db->createCommand(
                  "UPDATE bills set status = 'PAUSED' where status = 'IN_PROCESS'"
                )->execute();
        */
        //@todo: есть неясности...
        $bills = self::getAdminBillsList('PAID', null, null, 100000);
        if ($bills) {
            foreach ($bills as $bill) {
                if (in_array(
                  $bill->status,
                  BillsStatuses::getStatusesArrayWithChildren(['IN_PROCESS'])
                )) {
                    CmsEmailEvents::emailProcessEvents($bill, 'remindToProcess', true);
                }
            }
        }
    }
}
