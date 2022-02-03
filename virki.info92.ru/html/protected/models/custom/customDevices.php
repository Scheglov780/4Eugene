<?
/*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Devices.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "obj_devices_manual".
 * The followings are the available columns in table 'obj_devices_manual':
 * @property integer $devices_id
 * @property string  $source                  -- Nekta
 * @property string  $name                    --    varchar
 * -- device_id    -- varchar
 * @property integer $active                  -- int2
 * -- protocol_id    -- int4
 * --gateway_id    -- int4
 * @property string  $properties              -- jsonb
 * -- device_timezone    -- int2
 * -- interface_id    -- int4
 * -- creator_id    -- int4
 * -- company_creator_id    -- int4
 * -- model_class_id    -- int4
 * @property integer $model_id                -- int4
 * @property string  $model_id_name
 * @property integer $device_type_id          -- int4
 * @property string  $device_type_id_name
 * @property integer $device_group_id         -- int4
 * @property string  $device_group_id_name
 * @property integer $report_period_update    -- int4
 * -- impulse_weight    -- float8
 * -- starting_value    -- float8
 * -- transformation_ratio    -- float8
 * @property string  $desc                    -- text
 * @property string  $last_active             -- timestamptz
 * @property string  $last_active_left        -- timestamptz
 * @property string  $last_message            -- jsonb
 * @property double  $value1
 * @property double  $value2
 * @property double  $value3
 * @property double  $d90value1
 * @property double  $d90value2
 * @property double  $d90value3
 * @property double  $starting_value1
 * @property double  $starting_value2
 * @property double  $starting_value3
 * @property double  $starting_balance
 * @property string  $starting_date
 * -- last_message_type    -- int4
 * @property string  $status                  -- jsonb
 * @property string  $created_at              -- timestamptz
 * @property string  $created_at_left         -- timestamptz
 * @property string  $updated_at
 * @property string  $updated_at_left         -- timestamptz
 * @property string  $deleted_at
 * @property string  $deleted_at_left         -- timestamptz
 * -- archived_at    -- timestamptz
 * -- on_dashboard    -- bool
 * @property string  $address                 -- jsonb
 * -- active_polling    -- int4
 * @property string  $data_updated            -- timestamptz
 * @property string  $data_updated_left
 * @property string  $device_serial_number
 * @property integer $device_usage_id
 * @property integer $device_usage_name
 * @property integer $device_status_id
 * @property integer $device_status_name
 * The followings are the available model relations:
 * @property string  $lands
 * @property string  $users
 * @property string  $tariffs
 */
class customDevices extends DSRelatableActiveRecord
{
    public $address;
    public $created_at_left;
    public $d90value1;
    public $d90value2;
    public $d90value3;
    public $data_updated;
    public $data_updated_left;
    public $deleted_at_left;
    public $device_group_id_name;
    public $device_status_name;
    public $device_type_id_name;
    public $device_usage_name;
    public $lands;
    public $last_active;
    public $last_active_left;
    public $last_message;
    public $model_id_name;
    public $starting_balance;
    public $starting_date;
    public $starting_value1;
    public $starting_value2;
    public $starting_value3;
    public $status;
    public $tariffs;
    public $updated_at_left;
    public $users;
    public $value1;
    public $value2;
    public $value3;
    protected static $_devicesGroups = null;
    protected static $_devicesModels = null;
    protected static $_devicesTypes = null;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'devices_id'           => Yii::t('main', 'ID'),
          'source'               => Yii::t('main', 'Сервис'),
          'name'                 => Yii::t('main', 'Псевдоним'),
          'active'               => Yii::t('main', 'Все данные о приборе учёта введены правильно и проверены'),
          'properties'           => Yii::t('main', 'Свойства'),
          'model_id'             => Yii::t('main', 'Модель'),
          'device_type_id'       => Yii::t('main', 'Тип'),
          'device_group_id'      => Yii::t('main', 'Группа'),
          'report_period_update' => Yii::t('main', 'T обновления'),
          'desc'                 => Yii::t('main', 'Описание'),
          'last_active'          => Yii::t('main', 'Обновлён'),
          'last_active_left'     => Yii::t('main', 'Обновлён'),
          'last_message'         => Yii::t('main', 'Данные'),
          'value1'               => 'V1<sub>тек.</sub>',
          'value2'               => 'V2<sub>тек.</sub>',
          'value3'               => 'V3<sub>тек.</sub>',
          'd90value1'            => '&Delta;V1<sub>90</sub>',
          'vd90alue2'            => '&Delta;V2<sub>90</sub>',
          'vd90alue3'            => '&Delta;V3<sub>90</sub>',
          'starting_value1'      => 'V1<sub>нач.</sub>',
          'starting_value2'      => 'V2<sub>нач.</sub>',
          'starting_value3'      => 'V3<sub>нач.</sub>',
          'starting_balance'     => 'С<sub>нач.</sub>',
          'starting_date'        => 'T<sub>нач.</sub>',
          'status'               => Yii::t('main', 'Проверен'),
          'created_at'           => Yii::t('main', 'Подключен'),
          'created_at_left'      => Yii::t('main', 'Подключен'),
          'updated_at'           => Yii::t('main', 'Настроен'),
          'updated_at_left'      => Yii::t('main', 'Настроен'),
          'deleted_at'           => Yii::t('main', 'Удалён'),
          'deleted_at_left'      => Yii::t('main', 'Удалён'),
          'address'              => Yii::t('main', 'Адрес'),
          'data_updated'         => Yii::t('main', 'Опрошен'),
          'data_updated_left'    => Yii::t('main', 'Опрошен'),
          'device_usage_id'      => Yii::t('main', 'Назначение'),
          'device_usage_name'    => Yii::t('main', 'Назначение'),
          'device_status_id'     => Yii::t('main', 'Статус прибора'),
          'device_status_name'   => Yii::t('main', 'Статус прибора'),
          'device_serial_number' => Yii::t('main', 'Серийный №'),
          'lands'                => Yii::t('main', 'Участки'),
          'users'                => Yii::t('main', 'Пользователи'),
          'tariffs'              => Yii::t('main', 'Тарифы'),
        ];
    }

    public function getAttributes($names = true)
    {
        $attr = parent::getAttributes($names);
        return $attr;
    }

    public function getStartPoints()
    {
        $result = Yii::app()->db->createCommand(
          "
        select devices_startpoint_id, devices_id, created, deleted, 
               startpoint_value1, startpoint_value2, startpoint_value3, uid, balance 
               from obj_devices_startpoints sp
                where sp.devices_id = :devices_id and sp.deleted is null limit 1
        "
        )->queryRow(
          true,
          [
            ':devices_id' => $this->devices_id,
          ]
        );
        if ($result) {
            $this->starting_value1 = $result['startpoint_value1'];
            $this->starting_value2 = $result['startpoint_value2'];
            $this->starting_value3 = $result['startpoint_value3'];
            $this->starting_balance = $result['balance'];
            $this->starting_date = $result['created'];
        }
        return $result;
    }

    public function insert($attributes = null)
    {
        $res = parent::insert($attributes);
        if ($res && isset($this->tariffs) && is_array($this->tariffs)) {
            $res = $this->setRelatable('tariffs', $this->tariffs);
        }
        if ($res && isset($this->lands) && is_array($this->lands)) {
            $res = $this->setRelatable('parent_lands', $this->lands);
        }
        if ($res) {
            $res = $this->updateStartPoints();
        }
        return $res;
    }

    /**
     * @return array relatable rules.
     */
    public function relatable()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'tariffs'      => [
            'detailTable'            => 'obj_tariffs',
            'detailTablePK'          => 'tariffs_id',
            'relatableTable'         => 'obj_devices_tariffs',
            'relatableTablePK'       => 'devices_tariffs_id',
            'relatableTableMasterId' => 'devices_id',
            'relatableTableDetailId' => 'tariffs_id',
          ],
          'parent_lands' => [
            'detailTable'            => 'obj_devices_manual',
            'detailTablePK'          => 'devices_id',
            'relatableTable'         => 'obj_lands_devices',
            'relatableTablePK'       => 'lands_devices_id',
            'relatableTableMasterId' => 'lands_id',
            'relatableTableDetailId' => 'devices_id',
          ],
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
          'objLandsDevices'   => [self::HAS_MANY, 'ObjLandsDevices', 'lands_id'],
          'objDevicesTariffs' => [self::HAS_MANY, 'ObjDevicesTariffs', 'devices_id'],
          'objUsersLands'     => [self::HAS_MANY, 'ObjUsersLands', 'lands_id'],
        ];
    }

    public function requiredRule($attribute, $params)
    {
        if (empty($this->phone)
          && empty($this->email)
        ) {
            $this->addError($attribute, 'Должен быть указан как минимум номер телефона или email');
            return false;
        }
        return true;
    }

    //@todo: использовать или удалить

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            //array('email, phone', 'requiredRule'),
          ['devices_id,source', 'required', 'on' => 'update'],
          [
            'devices_id, active, model_id, device_type_id, device_group_id, report_period_update, device_usage_id, device_status_id',
            'numerical',
            'integerOnly' => true,
          ],
            // array('starting_value1, starting_value2, starting_value3, starting_balance', 'numerical'),
          ['source, name', 'length', 'max' => 255],
          ['value1, value2, value3', 'length', 'max' => 17],
            /* array(
              'lands_id, created',
              'unsafe',
              'on'                     => 'update',
              'safe'                   => true,
              'skipOnError'            => true,
              'enableClientValidation' => false
            ),
            array(
              'users, devices',
              'safe',
              'on'                     => 'update,create',
              'skipOnError'            => true,
              'enableClientValidation' => false
            ),*/
          [
            'd90value1, d90value2, d90value3, tariffs, device_serial_number, source, properties, desc, last_active, last_active_left, last_message, status, created_at, created_at_left, updated_at, updated_at_left, deleted_at, deleted_at_left, address, data_updated, data_updated_left',
            'safe',
          ],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'd90value1, d90value2, d90value3, tariffs, device_serial_number, devices_id, source, name, active, properties, model_id, device_type_id, device_group_id, report_period_update, desc, last_active, last_active_left, last_message, value1, value2, value3, starting_value1, starting_value2, starting_value3, starting_balance, starting_date, status, created_at, created_at_left, updated_at, updated_at_left, deleted_at, deleted_at_left, address, data_updated, data_updated_left, device_usage_id, device_usage_name, device_status_id, device_status_name',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        if (!$criteria) {
            $criteria = new CDbCriteria;
        }
        if (!$dataProviderId) {
            $dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()) . '_dataProvider';
        }

//    $criteria->select ="select SUM(payments.sum) as payments_sum";
        //where uid=". Topic.topicId, Topic.extension from Topic order by Topic.startDate desc limit 1,2) as Topic ON Topic.topicId = Rant.topicId LEFT JOIN User on User.userId = Rant.userId';
//    $criteria->join='LEFT JOIN payments pp ON pp.uid=t.uid';
        $criteria->select =
          /** @lang PostgreSQL */
          "t.devices_id,
  t.source,
  t.name,
  t.active,
  t.device_serial_number,
	jsonb_pretty(t.properties) AS properties,
  t.model_id,
  name_model.name as model_id_name,
  t.device_type_id,
  name_type.name as device_type_id_name,
  t.device_group_id,
  name_group.name as device_group_id_name,
  t.report_period_update,
  t.\"desc\",
	case when t.source = 'manual' then dd1.data_updated
	else ss.last_active end as last_active,
  now() - case when t.source = 'manual' then dd1.data_updated
	else ss.last_active end as last_active_left,
    jsonb_pretty(ss.last_message) AS last_message,
		case when t.source = 'manual' then dd1.tariff1_val::numeric(10,3)
    else (ss.last_message -> 'tariff1'::text)::numeric(10,3) end AS value1,
		case when t.source = 'manual' then dd1.tariff2_val::numeric(10,3)
    else (ss.last_message -> 'tariff2'::text)::numeric(10,3) end AS value2,
		case when t.source = 'manual' then dd1.tariff3_val::numeric(10,3)
    else (ss.last_message -> 'tariff3'::text)::numeric(10,3) end AS value3,
    oddv2.d90tariff1::numeric(10,3) AS d90value1,
    oddv2.d90tariff2::numeric(10,3) AS d90value2,
    oddv2.d90tariff3::numeric(10,3) AS d90value3,        
       sp.startpoint_value1::numeric(10, 3) as starting_value1,
       sp.startpoint_value2::numeric(10, 3) as starting_value2,
       sp.startpoint_value3::numeric(10, 3) as starting_value3,
			 sp.balance as starting_balance,
			 sp.created as starting_date,
    jsonb_pretty(ss.status) AS status,	-- case
  t.created_at,
    now() - t.created_at AS created_at_left,	
  t.updated_at,
    now() - t.updated_at AS updated_at_left,	
  t.deleted_at,
	now() - t.deleted_at AS deleted_at_left,
  ss.address,	-- case
	case when t.source = 'manual' then dd1.data_updated
  else ss.data_updated end as data_updated,
  now() - case when t.source = 'manual' then dd1.data_updated
  else ss.data_updated end AS data_updated_left,
    t.device_usage_id,
		dc_usage.val_name as device_usage_name,
    t.device_status_id,
    dc_status.val_name as device_status_name, 
(select jsonb_agg(rtariffs) from (
select ul.devices_tariffs_id, ul.devices_id, ll.* from obj_devices_tariffs ul
left join obj_tariffs ll on ll.tariffs_id = ul.tariffs_id
where ul.devices_id = t.devices_id and ul.deleted is null
order by ul.created
) rtariffs) as tariffs,      
(select jsonb_agg(rlands) from (
select ul.lands_devices_id, ul.devices_id, ll.* from obj_lands_devices ul
left join obj_lands ll on ll.lands_id = ul.lands_id
where ul.devices_id = t.devices_id and ul.deleted is null
order by ul.created
) rlands) as lands,
(select jsonb_agg(rusers) from (
select ld.users_lands_id, ld.uid, dd.* from obj_users_lands ld 
left join users dd on dd.uid = ld.uid
where ld.lands_id in
(select ul.lands_id from obj_lands_devices ul
where ul.devices_id = t.devices_id and ul.deleted is null) and ld.deleted is null
order by ld.created
) rusers) as users
  ";
        $criteria->join = $criteria->join .
          /** @lang PostgreSQL */
          "
left join lateral (select ll.land_group, ll.land_number from obj_lands_devices ul
left join obj_lands ll on ll.lands_id = ul.lands_id
where ul.devices_id = t.devices_id and ul.deleted is null
order by ul.created limit 1
) lll on true
LEFT JOIN LATERAL ( SELECT sum(oddv.delta_tariff1) AS d90tariff1,
            sum(oddv.delta_tariff2) AS d90tariff2,
            sum(oddv.delta_tariff3) AS d90tariff3
           FROM obj_devices_data_view oddv
          WHERE oddv.device_id = t.devices_id and (oddv.data_updated >= (now() - interval '90 day'))) oddv2 ON true
left join src_nekta_metering_devices ss on ss.\"id\" = t.devices_id
 left join (select dd.device_id, 
max(dd.tariff1_val) as tariff1_val,
max(dd.tariff2_val) as tariff2_val,
max(dd.tariff3_val) as tariff3_val,
max(dd.data_updated) as data_updated
 from obj_devices_manual_data dd
 group by dd.device_id) dd1 on dd1.device_id = t.devices_id  
		LEFT JOIN dic_custom dc_usage on dc_usage.val_id = t.device_usage_id
		LEFT JOIN dic_custom dc_status on dc_status.val_id = t.device_status_id	
		 LEFT JOIN src_device_models name_model on name_model.id = t.model_id
		 LEFT JOIN src_nekta_device_types name_type on name_type.id = t.device_type_id
		 LEFT JOIN src_nekta_device_groups name_group on name_group.id = t.device_group_id
		 LEFT JOIN obj_devices_startpoints sp on sp.devices_id = t.devices_id and sp.deleted is null		 
        ";
        $criteria->compare('t.devices_id', $this->devices_id);
        $criteria->compare('t.device_serial_number', $this->device_serial_number);
        if ($this->source) {
            $criteria->addSearchCondition('t.source', $this->source, true, 'AND', 'ILIKE');
        }
        if ($this->name) {
            $criteria->addSearchCondition('t.name', $this->name, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.active', $this->active);
        if ($this->properties) {
            $criteria->addSearchCondition('t.properties', $this->properties, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.model_id', $this->model_id);
        $criteria->compare('t.device_type_id', $this->device_type_id);
        $criteria->compare('t.device_group_id', $this->device_group_id);
        $criteria->compare('t.report_period_update', $this->report_period_update);
        if ($this->desc) {
            $criteria->addSearchCondition('t.desc', $this->desc, true, 'AND', 'ILIKE');
        }
        if ($this->last_active) {
            $criteria->addSearchCondition('last_active', $this->last_active, true, 'AND', 'ILIKE');
        }
        if ($this->last_active_left) {
            $criteria->addSearchCondition('last_active_left', $this->last_active_left, true, 'AND', 'ILIKE');
        }
        if ($this->last_message) {
            $criteria->addSearchCondition('last_message', $this->last_message, true, 'AND', 'ILIKE');
        }
        /* $criteria->compare('value1', $this->value1);
        $criteria->compare('value2', $this->value2);
        $criteria->compare('value3', $this->value3); */
        $criteria->compare('sp.starting_value1', $this->starting_value1);
        $criteria->compare('sp.starting_value2', $this->starting_value2);
        $criteria->compare('sp.starting_value3', $this->starting_value3);
        $criteria->compare('sp.starting_balance', $this->starting_balance);
        $criteria->compare('sp.starting_date', $this->starting_date);
        if ($this->status) {
            $criteria->addSearchCondition('status', $this->status, true, 'AND', 'ILIKE');
        }
        if ($this->created_at) {
            $criteria->addSearchCondition('t.created_at', $this->created_at, true, 'AND', 'ILIKE');
        }
        if ($this->created_at_left) {
            $criteria->addSearchCondition('created_at_left', $this->created_at_left, true, 'AND', 'ILIKE');
        }
        if ($this->updated_at) {
            $criteria->addSearchCondition('t.updated_at', $this->updated_at, true, 'AND', 'ILIKE');
        }
        if ($this->updated_at_left) {
            $criteria->addSearchCondition('updated_at_left', $this->updated_at_left, true, 'AND', 'ILIKE');
        }
        if ($this->deleted_at) {
            $criteria->addSearchCondition('t.deleted_at', $this->deleted_at, true, 'AND', 'ILIKE');
        }
        if ($this->deleted_at_left) {
            $criteria->addSearchCondition('deleted_at_left', $this->deleted_at_left, true, 'AND', 'ILIKE');
        }
        if ($this->address) {
            $criteria->addSearchCondition('address', $this->address, true, 'AND', 'ILIKE');
        }
        if ($this->data_updated) {
            $criteria->addSearchCondition('data_updated', $this->data_updated, true, 'AND', 'ILIKE');
        }
        if ($this->data_updated_left) {
            $criteria->addSearchCondition('data_updated_left', $this->data_updated_left, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.device_usage_id', $this->device_usage_id);
        $criteria->compare('t.device_status_id', $this->device_status_id);

        $dataProvider = new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'devices_id'        => [
                  'asc'  => 't.devices_id ASC',
                  'desc' => 't.devices_id DESC',
                ],
                'source'            => [
                  'asc'  => 't.source ASC',
                  'desc' => 't.source DESC',
                ],
                'name'              => [
                  'asc'  => 't.name ASC',
                  'desc' => 't.name DESC',
                ],
                'active'            => [
                  'asc'  => 't.active ASC',
                  'desc' => 't.active DESC',
                ],
                'model_id'          => [
                  'asc'  => 't.model_id ASC',
                  'desc' => 't.model_id DESC',
                ],
                'device_type_id'    => [
                  'asc'  => 't.device_type_id ASC',
                  'desc' => 't.device_type_id DESC',
                ],
                'device_group_id'   => [
                  'asc'  => 't.device_group_id ASC',
                  'desc' => 't.device_group_id DESC',
                ],
                'last_active'       => [
                  'asc'  => 'last_active ASC',
                  'desc' => 'last_active DESC',
                ],
                'created_at'        => [
                  'asc'  => 't.created_at ASC',
                  'desc' => 't.created_at DESC',
                ],
                'deleted_at'        => [
                  'asc'  => 't.deleted_at ASC',
                  'desc' => 't.deleted_at DESC',
                ],
                'data_updated'      => [
                  'asc'  => 'data_updated ASC',
                  'desc' => 'data_updated DESC',
                ],
                'lands'             => [
                  'asc'  => 'lll.land_group ASC, substring(lll.land_number,\'(\d+)\')::integer ASC, lll.land_number ASC',
                  'desc' => 'lll.land_group DESC, substring(lll.land_number,\'(\d+)\')::integer DESC, lll.land_number DESC',
                ],
                'device_usage_name' => [
                  'asc'  => 'device_usage_name ASC',
                  'desc' => 'device_usage_name DESC',
                ],
                'starting_date'     => [
                  'asc'  => 'sp.created is null desc, lll.land_group ASC, substring(lll.land_number,\'(\d+)\')::integer ASC, lll.land_number ASC',
                  'desc' => 'sp.created is null asc, lll.land_group ASC, substring(lll.land_number,\'(\d+)\')::integer ASC, lll.land_number ASC',
                ],
              ],
              'defaultOrder' => [
                'lands' => CSort::SORT_ASC,
              ],
            ],
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $dataProvider;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'obj_devices_manual';
    }

    public function update($attributes = null)
    {
        $res = parent::update($attributes);
        if ($res && isset($this->tariffs) && is_array($this->tariffs)) {
            $res = $this->setRelatable('tariffs', $this->tariffs);
        }
        if ($res && isset($this->lands) && is_array($this->lands)) {
            $res = $this->setRelatable('parent_lands', $this->lands);
        }
        if ($res) {
            $res = $this->updateStartPoints();
        }
        return $res;
    }

    public function updateStartPoints($data = null)
    {
        $newStartPointData = [];
        $fieldNames = [
          'devices_id',
          'starting_value1',
          'starting_value2',
          'starting_value3',
          'starting_balance',
        ];
        if (!$data && isset($_POST['Devices'])) {
            $data = $_POST['Devices'];
        }
        foreach ($fieldNames as $fieldName) {
            if (isset($data[$fieldName])) {
                $newStartPointData[$fieldName] = ($data[$fieldName] !== '' ? $data[$fieldName] : null);
            } else {
                $newStartPointData[$fieldName] = null;
            }
        }
        $newStartPointData['uid'] = Yii::app()->user->id;
        if ($newStartPointData['devices_id'] &&
          ($newStartPointData['starting_value1'] ||
            ($newStartPointData['starting_value2'] &&
              $newStartPointData['starting_value3']))) {
            $oldStartPointData = Yii::app()->db->createCommand(
              " select 
       devices_startpoint_id, devices_id, created, deleted, 
       startpoint_value1, startpoint_value2, startpoint_value3, uid, balance from obj_devices_startpoints sp
       where sp.devices_id = :devices_id and sp.deleted is null limit 1"
            )
              ->queryRow(
                true,
                [
                  ':devices_id' => $newStartPointData['devices_id'],
                ]
              );
            $changed = false;
            if ($oldStartPointData) {
                if (
                  (($oldStartPointData['startpoint_value1'] ?? '') !== ($newStartPointData['starting_value1'] ?? '')) ||
                  (($oldStartPointData['startpoint_value2'] ?? '') !== ($newStartPointData['starting_value2'] ?? '')) ||
                  (($oldStartPointData['startpoint_value3'] ?? '') !== ($newStartPointData['starting_value3'] ?? '')) ||
                  (($oldStartPointData['balance'] ?? '0') !== ($newStartPointData['starting_balance'] ?? '0'))
                ) {
                    $changed = true;
                }
                //startpoint_value1, startpoint_value2, startpoint_value3, uid, balance
            }
            if ($changed) {
                Yii::app()->db->createCommand(
                  "
            update obj_devices_startpoints
            set deleted = now()
            where devices_startpoint_id = :devices_startpoint_id
            "
                )->execute(
                  [
                    ':devices_startpoint_id' => $oldStartPointData['devices_startpoint_id'],
                  ]
                );
            }
            if ($changed || !$oldStartPointData) {
                Yii::app()->db->createCommand(
                  "
            insert into obj_devices_startpoints (
            devices_id, created, startpoint_value1, startpoint_value2, startpoint_value3, uid, balance
            ) values (
            :devices_id, now(), 
            :startpoint_value1, :startpoint_value2, :startpoint_value3, :uid, :balance
            )
            
            "
                )->execute(
                  [
                    ':devices_id'        => $newStartPointData['devices_id'],
                    ':startpoint_value1' => $newStartPointData['starting_value1'],
                    ':startpoint_value2' => $newStartPointData['starting_value2'],
                    ':startpoint_value3' => $newStartPointData['starting_value3'],
                    ':balance'           => $newStartPointData['starting_balance'] ?? $oldStartPointData['balance'],
                    ':uid'               => $newStartPointData['uid'],
                  ]
                );
            }
        }
        return true;
    }

    public static function addReadings($data)
    {
        if (!empty($data['value1']) || (!empty($data['value2']) && !empty($data['value3']))) {
            $sql = "insert into obj_devices_manual_data 
    (device_id, data_updated, uid, tariff1_val, tariff2_val, tariff3_val, data_source) 
    values (:device_id, now(), :uid, :tariff1, :tariff2, :tariff3, :data_source)";
            try {
                $result = Yii::app()->db->createCommand($sql)->execute(
                  [
                    ':device_id'   => $data['devices_id'],
                    ':uid'         => Yii::app()->user->id,
                    ':tariff1'     => $data['value1'],
                    ':tariff2'     => $data['value2'],
                    ':tariff3'     => $data['value3'],
                    ':data_source' => 69 //69	DATASOURCE_TYPE	Сайт
                  ]
                );
            } catch (CDbException $e) {
                $result = false;
            }
        } else {
            $result = true;
        }
        return $result;
    }

    public static function deleteReadings($id)
    {
        $sql = "DELETE from obj_devices_manual_data where data_id = :data_id";
        Yii::app()->db->createCommand($sql)->execute([':data_id' => $id]);
    }

    public static function getDevice($id)
    {
        $device = self::model()->findByPk($id);
        $device->getStartPoints();
        /*
                if ($device) {
                    $device->userBalance = self::getBalance($user->uid);
                    $device->payments = new Payment('search');
                    $device->payments->unsetAttributes(); // clear any default values
                    $device->payments->uid = $uid;

                    //$user->addresses = new Addresses('search');
                    //$user->addresses->unsetAttributes(); // clear any default values
                    //$user->addresses->uid = $uid;

                    $user->manager = self::model()
                      ->find("uid=:manager and role not in ('user','guest')", array('manager' => $user->default_manager));
                }
        */
        return $device;
    }

    public static function getDeviceData($source, $id, $pageSize = 100)
    {
        if ($source == 'nekta') {
            $sql = "
    select md5(tt.device_id::varchar||tt.datetime::varchar) as pk,
           'nekta'::text AS source,
    tt.device_id,
		tt.datetime - COALESCE(lag(tt.datetime) OVER (PARTITION BY tt.device_id ORDER BY tt.datetime), tt.datetime) AS delta_data_updated,
    tt.datetime AS data_updated,
		extract (epoch from tt.datetime - COALESCE(lag(tt.datetime) OVER (PARTITION BY tt.device_id ORDER BY tt.datetime), tt.datetime)) as delta_data_updated_sec,		           
    tt.tariff1 as tariff1,       
    tt.delta_tariff1 AS delta_tariff1,
    tt.tariff2 as tariff2,       
    tt.delta_tariff2 AS delta_tariff2,
    tt.tariff3 as tariff3,       
    tt.delta_tariff3 AS delta_tariff3,           
    0 AS uid,
    uu.fullname,
    78 as data_source,
    dc.val_name as data_source_name      
   FROM src_nekta_data_type1 tt
    left join users uu on uu.uid = 0
    left join dic_custom dc on dc.val_id = 78 and dc.val_group = 'DATASOURCE_TYPE'
     where tt.device_id = :device_id
	 order by tt.datetime desc
	 ";
        } elseif ($source == 'manual') {
            $sql = "
    SELECT tt.data_id as pk,
           'manual'::text AS source,
    tt.device_id,
	tt.data_updated - COALESCE(lag(tt.data_updated) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated, tt.data_id), tt.data_updated) AS delta_data_updated,
    tt.data_updated,
		extract (epoch from tt.data_updated - COALESCE(lag(tt.data_updated) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated, tt.data_id), tt.data_updated)) as delta_data_updated_sec,		           
    tt.tariff1_val as tariff1,
    tt.tariff1_val - COALESCE(lag(tt.tariff1_val) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated, tt.data_id), 0::float) AS delta_tariff1,
    tt.tariff2_val as tariff2,
    tt.tariff2_val - COALESCE(lag(tt.tariff2_val) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated, tt.data_id), 0::float) AS delta_tariff2,
    tt.tariff3_val as tariff3,
    tt.tariff3_val - COALESCE(lag(tt.tariff3_val) OVER (PARTITION BY tt.device_id ORDER BY tt.data_updated, tt.data_id), 0::float) AS delta_tariff3,           
    tt.uid,  
    uu.fullname,
    tt.data_source,
    dc.val_name as data_source_name
   FROM obj_devices_manual_data tt
        left join users uu on uu.uid = tt.uid
    left join dic_custom dc on dc.val_id = tt.data_source and dc.val_group = 'DATASOURCE_TYPE'
    where tt.device_id = :device_id
	 order by tt.data_updated desc
	 ";
        }
        $totalItemCount = Yii::app()->db->createCommand("select count(0) from ({$sql}) t")->queryScalar(
          [':device_id' => $id]
        );

        $dataProvider = new CSqlDataProvider(
          $sql, [
            'params'         => [':device_id' => $id],
            'id'             => 'device-data-' . $source . '-' . $id,
            'keyField'       => 'pk',
            'totalItemCount' => $totalItemCount,
            'pagination'     => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $dataProvider;
    }

    public static function getGroups($id = null)
    {
        if (isset(self::$_devicesGroups)) {
            $resArr = self::$_devicesGroups;
        } else {
            $res = Yii::app()->db->createCommand("SELECT id, name from src_nekta_device_groups order by name")
              ->queryAll();
            $resArr = [];
            if (($res !== false) && ($res !== null)) {
                foreach ($res as $r) {
                    $resArr[$r['id']] = $r['name'];
                }
            }
            self::$_devicesGroups = $resArr;
        }
        if (isset($id)) {
            return $resArr[$id];
        } else {
            return $resArr;
        }
    }

    public static function getList($id = null, $getParents = false)
    {
        if (is_null($id)) {
            $sql = "select ll.devices_id, ll.source, ll.name
from obj_devices_manual ll
order by ll.source, ll.devices_id::integer";
            $res = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            if (!$getParents) {
                $sql = "select ul.devices_id
from obj_lands_devices ul where ul.deleted is null and ul.lands_id = :id";
                $res = Yii::app()->db->createCommand($sql)->queryColumn(
                  [
                    ':id' => $id,
                  ]
                );
            } else {
                $sql = "select ul.lands_id
from obj_lands_devices ul where ul.deleted is null and ul.devices_id = :id";
                $res = Yii::app()->db->createCommand($sql)->queryColumn(
                  [
                    ':id' => $id,
                  ]
                );
            }
        }
        if (!is_array($res)) {
            $res = [];
        }
        return $res;
    }

    public static function getListForDropDown()
    {
        $res = self::model()->findAllBySql(
          "select dd.devices_id, dd.source, dd.name, dd.model_id_name
                from obj_devices_view dd
               order by dd.source, dd.model_id_name, dd.name",
          []
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['devices_id']] =
                  $r['source'] . '/' . $r['model_id_name'] . '/' . ($r['name'] ? $r['name'] : $r['devices_id']);
            }
        }
        return $resArr;
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
        $device = self::model()->findByPk($id);
        $res = '';
        $fields = [
          'devices_id',
          'source',
          'name',
        ];
        if ($device) {
            foreach ($fields as $field) {
                if (strlen($device->{$field}) > 0) {
                    $res = $res . '<small>' . $device->getAttributeLabel($field) . ':</small> ' . markup(
                        $device->{$field},
                        $query
                      ) . '&nbsp;';
                }
            }
        }
        return $res;
    }

    public static function getModels($id = null)
    {
        if (isset(self::$_devicesModels)) {
            $resArr = self::$_devicesModels;
        } else {
            $res = Yii::app()->db->createCommand(
              "SELECT id, name from src_device_models order by \"name\" like '*%' desc, \"name\""
            )->queryAll();
            $resArr = [];
            if ($res) {
                foreach ($res as $r) {
                    $resArr[$r['id']] = $r['name'];
                }
            }
            self::$_devicesModels = $resArr;
        }
        if (isset($id)) {
            return $resArr[$id];
        } else {
            return $resArr;
        }
    }

    public static function getSources()
    {
        $res = self::model()->findAllBySql("SELECT source FROM obj_devices_manual GROUP BY source", []);
        $resArr = [];
        if (($res != false) && ($res != null)) {
            foreach ($res as $r) {
                $resArr[$r['source']] = $r['source'];
            }
        }
        return $resArr;
    }

    public static function getTypes($id = null)
    {
        if (isset(self::$_devicesTypes)) {
            $resArr = self::$_devicesTypes;
        } else {
            $res =
              Yii::app()->db->createCommand("SELECT id, name from src_nekta_device_types order by name")->queryAll();
            $resArr = [];
            if ($res) {
                foreach ($res as $r) {
                    $resArr[$r['id']] = $r['name'];
                }
            }
            self::$_devicesTypes = $resArr;
        }
        if (isset($id)) {
            return $resArr[$id];
        } else {
            return $resArr;
        }
    }

    /** @param Devices $device */
    public static function getUpdateLink($id, $external = false, $device = null, $value = null, $icon = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($device)) {
            $device = self::model()->findByPk($id);
        }
        if (!isset($device->model_id_name)) {
            $device->model_id_name = self::getModels($device->model_id);
            $device->device_type_id_name = self::getTypes($device->device_type_id);
            $device->device_group_id_name = self::getGroups($device->device_group_id);
        }
        if ($device) {
            if (is_null($value)) {
                $value = addslashes(
                  $device->source .
                  '/' .
                  ($device->name ? $device->name :
                    ($device->model_id_name ? $device->model_id_name : $device->devices_id))
                );
            }
            $tabName = addslashes(
              $device->source .
              '/' .
              ($device->name ? $device->name : ($device->model_id_name ? $device->model_id_name : $device->devices_id))
            );
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/devices/view/id/' . $id . '&tabName=' . $tabName;
            } else {
                $url = Yii::app()->createUrl(
                  '/' . Yii::app()->controller->module->id . '/devices/view',
                  ['id' => $id]
                );
                return '<a href="' .
                  $url .
                  '" title="' .
                  Yii::t(
                    'admin',
                    'Просмотр профиля прибора'
                  ) .
                  '" onclick="getContent(this,\'' .
                  $tabName .
                  '\',false);return false;">' .
                  ($icon ? "<i class='{$icon}'></i> " : '') .
                  $value .
                  '</a>'; //<i class="fa fa-podcast"></i>&nbsp;
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Devices|DSRelatableActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function updateReadings($data)
    {

    }

}