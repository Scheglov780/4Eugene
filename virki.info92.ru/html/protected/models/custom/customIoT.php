<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Img.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customIoT
{
    /*
          1 - Показания посуточно
          5 - Профиль мощности
          6 - Мгновенные показания (old)
    */
    private static $enabledDataTypes = [1, 5];

    public static function log($message, $debug = false)
    {
        $debugInfo = '';
        if ($debug) {
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            $debugInfo = '(' . $caller['file'] . ':' . $caller['line'] . ')';
        }
        Yii::app()->db->createCommand('insert into log_iot (datetime, message) values (Now(), :message)')
          ->execute(
            [
              ':message' => $message . "\r\n" . $debugInfo,
            ]
          );
    }

    public static function nektaGetData()
    {
        $startTime = time();
        $devicesProcessedCount = 0;
        $Nekta = new NektaCommunicator(DSConfig::getVal('src_nekta_login'), DSConfig::getVal('src_nekta_password'));
        if ($Nekta->login()) {
            self::log('Nekta: login OK for ' . DSConfig::getVal('src_nekta_login'));
            //Getting dictionaries
            if (is_null(DSConfig::getVal('iot_nekta_dic_last_update', false)) || (time() - DSConfig::getVal(
                  'iot_nekta_dic_last_update',
                  false
                )) > 60 * 60 * 24) {
                $groupsRaw = $Nekta->getDicDevicesGroups();
                $groups = json_decode($groupsRaw);
                if (is_array($groups->data->device_groups)) {
                    Yii::app()->db->createCommand('TRUNCATE TABLE src_nekta_device_groups')->execute();
                    foreach ($groups->data->device_groups as $i => $group) {
                        $sql = '
                        insert into src_nekta_device_groups (id, name, slug)
                          values(
                          :id, :name, :slug       
                          ) 
ON CONFLICT ON CONSTRAINT src_nekta_device_groups_pkey 
                                          DO NOTHING';
                        $sqlParams = [
                          ':id'   => $group->id,
                          ':name' => $group->name,
                          ':slug' => $group->slug,
                        ];
                        Yii::app()->db->createCommand($sql)->execute($sqlParams);
                    }
                }
                $typesRaw = $Nekta->getDicDevicesTypes();
                $types = json_decode($typesRaw);
                if (is_array($types->data->metering_device_types)) {
                    Yii::app()->db->createCommand('TRUNCATE TABLE src_nekta_device_types')->execute();
                    foreach ($types->data->metering_device_types as $i => $type) {
                        $sql = '
                        insert into src_nekta_device_types (id, name, slug, device_group_id)
                          values(
                          :id, :name, :slug, :device_group_id       
                          ) 
ON CONFLICT ON CONSTRAINT src_nekta_device_types_pkey 
                                          DO NOTHING';
                        $sqlParams = [
                          ':id'              => $type->id,
                          ':name'            => $type->name,
                          ':slug'            => $type->slug,
                          ':device_group_id' => $type->device_group_id,
                        ];
                        Yii::app()->db->createCommand($sql)->execute($sqlParams);
                    }
                }
                $modelsRaw = $Nekta->getDicDevicesModels();
                $models = json_decode($modelsRaw);
                if (is_array($models->data->metering_device_models)) {
                    Yii::app()->db->createCommand('TRUNCATE TABLE src_nekta_device_models')->execute();
                    foreach ($models->data->metering_device_models as $i => $model) {
                        $sql = '
                        insert into src_nekta_device_models (id, name, slug, device_brand_id, device_group_id, device_type_id, protocol_id, active, control_relay, options, tabs, rules, poll_rules, server_interface, gateway_interface, impulse_weight)
                          values(
                                 :id, 
                                 :name, 
                                 :slug, 
                                 :device_brand_id, 
                                 :device_group_id, 
                                 :device_type_id, 
                                 :protocol_id, 
                                 :active, 
                                 :control_relay, 
                                 :options, 
                                 :tabs, 
                                 :rules, 
                                 :poll_rules, 
                                 :server_interface, 
                                 :gateway_interface, 
                                 :impulse_weight       
                          ) 
ON CONFLICT ON CONSTRAINT src_nekta_device_models_pkey 
                                          DO NOTHING';
                        $sqlParams = [
                          ':id'                => $model->id,
                          ':name'              => $model->name,
                          ':slug'              => $model->slug,
                          ':device_brand_id'   => $model->device_brand_id,
                          ':device_group_id'   => $model->device_group_id,
                          ':device_type_id'    => $model->device_type_id,
                          ':protocol_id'       => $model->protocol_id,
                          ':active'            => (int) $model->active,
                          ':control_relay'     => (int) $model->control_relay,
                          ':options'           => json_encode($model->options),
                          ':tabs'              => json_encode($model->tabs),
                          ':rules'             => json_encode($model->rules),
                          ':poll_rules'        => json_encode($model->poll_rules),
                          ':server_interface'  => json_encode($model->server_interface),
                          ':gateway_interface' => json_encode($model->gateway_interface),
                          ':impulse_weight'    => json_encode($model->impulse_weight),
                        ];
                        Yii::app()->db->createCommand($sql)->execute($sqlParams);
                    }
                }
                DSConfig::setVal('iot_nekta_dic_last_update', time());
            }
            // Updating devices
            $devices = $Nekta->getDevicesList();
            if ($devices) {
                $devices = json_decode($devices);
                if (json_last_error() != JSON_ERROR_NONE) {
                    self::log(
                      'Nekta: error in json_decode for devices.' . "\r\n" . CVarDumper::dumpAsString($devices),
                      true
                    );
                }
                if (is_array($devices->data->metering_devices)) {
                    foreach ($devices->data->metering_devices as $i => $device) {
                        $sqlExternal = '
                        insert into src_nekta_metering_devices (
                          id, name, device_id, active, protocol_id, gateway_id, properties, 
                          device_timezone, interface_id, creator_id, company_creator_id, 
                          model_class_id, model_id, device_type_id, device_group_id, report_period_update, 
                          impulse_weight, starting_value, transformation_ratio, "desc", last_active, 
                          last_message, last_message_type, status, created_at, updated_at, deleted_at, 
                          archived_at, on_dashboard, address, active_polling
                          )
                          values(
                          :id, :name, :device_id, :active, :protocol_id, :gateway_id, :properties, 
                          :device_timezone, :interface_id, :creator_id, :company_creator_id, 
                          :model_class_id, :model_id, :device_type_id, :device_group_id, 
                                 :report_period_update, 
                          :impulse_weight, :starting_value, :transformation_ratio, :desc, 
                                 to_timestamp(:last_active), 
                          :last_message, :last_message_type, :status, 
                                 to_timestamp(:created_at), 
                                 to_timestamp(:updated_at), 
                                 to_timestamp(:deleted_at), 
                          to_timestamp(:archived_at), 
                                 :on_dashboard, :address, :active_polling       
                          ) 
ON CONFLICT ON CONSTRAINT src_nekta_metering_devices_pkey 
                                          DO UPDATE SET 
                                          name=:name, 
                                          device_id=:device_id, 
                                          active=:active, 
                                          protocol_id=:protocol_id, 
                                          gateway_id=:gateway_id, 
                                          properties=:properties, 
                                          device_timezone=:device_timezone, 
                                          interface_id=:interface_id, 
                                          creator_id=:creator_id, 
                                          company_creator_id=:company_creator_id, 
                                          model_class_id=:model_class_id, 
                                          model_id=:model_id, 
                                          device_type_id=:device_type_id, 
                                          device_group_id=:device_group_id, 
                                          report_period_update=:report_period_update, 
                                          impulse_weight=:impulse_weight, 
                                          starting_value=:starting_value, 
                                          transformation_ratio=:transformation_ratio, 
                                          "desc"=:desc, 
                                          last_active= to_timestamp(:last_active), 
                                          last_message=:last_message, 
                                          last_message_type=:last_message_type, 
                                          status=:status, 
                                          created_at=to_timestamp(:created_at), 
                                          updated_at=to_timestamp(:updated_at), 
                                          deleted_at=to_timestamp(:deleted_at), 
                                          archived_at=to_timestamp(:archived_at), 
                                          on_dashboard=:on_dashboard, 
                                          address=:address, 
                                          active_polling=:active_polling                           
                        ';
                        $sqlParamsExternal = [
                          ':id'                   => $device->id,
                          ':name'                 => $device->name,
                          ':device_id'            => $device->deviceID,
                          ':active'               => $device->active,
                          ':protocol_id'          => $device->protocol_id,
                          ':gateway_id'           => $device->gateway_id,
                          ':properties'           => json_encode($device->properties),
                          ':device_timezone'      => $device->deviceTimezone,
                          ':interface_id'         => $device->interface_id,
                          ':creator_id'           => $device->creator_id,
                          ':company_creator_id'   => $device->company_creator_id,
                          ':model_class_id'       => $device->model_class_id,
                          ':model_id'             => $device->model_id,
                          ':device_type_id'       => $device->device_type_id,
                          ':device_group_id'      => $device->device_group_id,
                          ':report_period_update' => $device->report_period_update,
                          ':impulse_weight'       => $device->impulse_weight,
                          ':starting_value'       => $device->starting_value,
                          ':transformation_ratio' => $device->transformation_ratio,
                          ':desc'                 => $device->desc,
                          ':last_active'          => $device->last_active,
                          ':last_message'         => json_encode($device->last_message),
                          ':last_message_type'    => json_encode($device->last_message_type),
                          ':status'               => json_encode($device->status),
                          ':created_at'           => $device->created_at,
                          ':updated_at'           => $device->updated_at,
                          ':deleted_at'           => $device->deleted_at,
                          ':archived_at'          => $device->archived_at,
                          ':on_dashboard'         => (int) $device->on_dashboard,
                          ':address'              => json_encode($device->address),
                          ':active_polling'       => (int) $device->active_polling,
                        ];
                        $sqlInternal = '
                        insert into obj_devices_manual (
devices_id,source,name,active,properties,model_id,device_type_id,device_group_id,
  report_period_update,"desc",created_at,updated_at,deleted_at,
  /* starting_value1,starting_value2, starting_value3, */ device_usage_id,device_status_id                                                        
                          )
                          values(
                         :id,\'nekta\',:name,:active,:properties,:model_id,:device_type_id,:device_group_id,
                         :report_period_update,:desc,to_timestamp(:created_at),Now(),
                                 to_timestamp(:deleted_at), /* :starting_value,0,0, */ 72,75                                 
                          ) 
ON CONFLICT ON CONSTRAINT obj_devices_manual_pkey 
                                          DO UPDATE SET 
                                          name=:name, 
                                          active=:active, 
                                          properties=:properties, 
                                          model_id=:model_id, 
                                          device_type_id=:device_type_id, 
                                          device_group_id=:device_group_id, 
                                          report_period_update=:report_period_update, 
                                          /* starting_value1=:starting_value, */ 
                                          "desc"=:desc, 
                                          created_at=to_timestamp(:created_at), 
                                          updated_at=Now(), 
                                          deleted_at=to_timestamp(:deleted_at),
                                          device_status_id = case when obj_devices_manual.device_status_id<>77 then 
                                                                 case when :status::text = \'null\' then 76
                                                                      else 75 end
                                                                  else obj_devices_manual.device_status_id end
                        ';
                        $sqlParamsInternal = [
                          ':id'                   => $device->id,
                          ':name'                 => $device->name,
                          ':active'               => $device->active,
                          ':properties'           => json_encode($device->properties),
                          ':model_id'             => $device->model_id,
                          ':device_type_id'       => $device->device_type_id,
                          ':device_group_id'      => $device->device_group_id,
                          ':report_period_update' => $device->report_period_update,
                            // ':starting_value'       => $device->starting_value,
                          ':desc'                 => $device->desc,
                          ':created_at'           => $device->created_at,
                            //':updated_at'           => $device->updated_at,
                          ':deleted_at'           => $device->deleted_at,
                          ':status'               => json_encode($device->status),
                        ];
                        try {
                            Yii::app()->db->createCommand($sqlExternal)
                              ->execute(
                                $sqlParamsExternal
                              );
                        } catch (Exception $e) {
                            self::log('Nekta: ' . $e->getMessage() . "\r\n" . CVarDumper::dumpAsString($device), true);
                        }
                        try {
                            Yii::app()->db->createCommand($sqlInternal)
                              ->execute(
                                $sqlParamsInternal
                              );
                        } catch (Exception $e) {
                            self::log('Nekta: ' . $e->getMessage() . "\r\n" . CVarDumper::dumpAsString($device), true);
                            continue;
                        }
                    }
                }
            }
            //$dataTypes = $Nekta->getDeviceDataMsgTypes();
            //$dataGroups = $Nekta->getDeviceDataMsgGroups();
            /*
                  1 - Показания посуточно
                  5 - Профиль мощности
                  6 - Мгновенные показания (old)
            */
            $devicesToUpdateSql =
              'select d2.id,
floor(extract (epoch from coalesce(starttime_t1,now()-interval \'92 days\'))) as starttime_t1,
floor(extract (epoch from coalesce(starttime_t5,now()-interval \'92 days\'))) as starttime_t5,
floor(extract (epoch from coalesce(starttime_t6,now()-interval \'92 days\'))) as starttime_t6
from
(
select d.id, 
(select max(t1.realdatetime) from src_nekta_data_type1 t1 where d.id=t1.device_id) as starttime_t1,
(select max(t5.realdatetime) from src_nekta_data_type5 t5 where d.id=t5.device_id) as starttime_t5,
(select max(t6.realdatetime) from src_nekta_data_type6 t6 where d.id=t6.device_id) as starttime_t6,
data_updated
from src_nekta_metering_devices d
where (data_updated is null OR data_updated < (Now() - interval \'30 minutes\'))
order by data_updated ASC NULLS first
) d2';
            $devicesToUpdate = Yii::app()->db->createCommand($devicesToUpdateSql)
              ->queryAll();
            if ($devicesToUpdate) {
                foreach ($devicesToUpdate as $i => $device) {
                    if (in_array(1, self::$enabledDataTypes)) {
// Begin ==============================
//                    $diff = time()-$device['starttime_t1'];
//                    self::log('Nekta: diff='.$diff);
                        $deviceData = $Nekta->getDeviceData($device['id'], $device['starttime_t1'], time(), 1);
                        if ($deviceData) {
                            $deviceData = json_decode($deviceData);
                            if (json_last_error() != JSON_ERROR_NONE) {
                                self::log(
                                  'Nekta: error in json_decode for deviceData' .
                                  "\r\n" .
                                  CVarDumper::dumpAsString($deviceData),
                                  true
                                );
                            }
                            if (!empty($deviceData->data->messages->data) &&
                              is_array($deviceData->data->messages->data)) {
                                foreach ($deviceData->data->messages->data as $i => $data) {
                                    if (empty($data)) {
                                        self::log(
                                          'Nekta: ' .
                                          CVarDumper::dumpAsString($deviceData) .
                                          "\r\n" .
                                          CVarDumper::dumpAsString(
                                            '$data is empty! - continue normaly'
                                          ),
                                          true
                                        );
                                        continue;
                                    }
                                    $sql = '
                        insert into src_nekta_data_type1 (device_id, realdatetime, rssi, 
                                                          tariff1, tariff2, tariff3, 
                                                          datetime, station_id, 
                                                          transformation_ratio, transformation_ratio_current, 
                                                          transformation_ratio_voltage, 
                                                          start_tariff1, end_tariff1, 
                                                          delta_tariff1, start_tariff1_kkt, end_tariff1_kkt, 
                                                          delta_tariff1_kkt, 
                                                          start_tariff2, end_tariff2, delta_tariff2, 
                                                          start_tariff2_kkt, end_tariff2_kkt, 
                                                          delta_tariff2_kkt, start_tariff3, end_tariff3, 
                                                          delta_tariff3, start_tariff3_kkt, end_tariff3_kkt, 
                                                          delta_tariff3_kkt)
                          values(
                                                          :device_id, to_timestamp(:realdatetime), :rssi, 
                                                          :tariff1, :tariff2, :tariff3, 
                                                          to_timestamp(:datetime), :station_id, 
                                                          :transformation_ratio, :transformation_ratio_current, 
                                                          :transformation_ratio_voltage, 
                                                          :start_tariff1, :end_tariff1, 
                                                          :delta_tariff1, :start_tariff1_kkt, :end_tariff1_kkt, 
                                                          :delta_tariff1_kkt, 
                                                          :start_tariff2, :end_tariff2, :delta_tariff2, 
                                                          :start_tariff2_kkt, :end_tariff2_kkt, 
                                                          :delta_tariff2_kkt, :start_tariff3, :end_tariff3, 
                                                          :delta_tariff3, :start_tariff3_kkt, :end_tariff3_kkt, 
                                                          :delta_tariff3_kkt
                          )
ON CONFLICT ON CONSTRAINT src_nekta_data_type1_pkey
                                          DO NOTHING
                        ';
                                    try {
                                        Yii::app()->db->createCommand($sql)
                                          ->execute(
                                            [
                                              ':device_id'                    => $device['id'],
                                              ':realdatetime'                 => $data->realdatetime,
                                              ':rssi'                         => (isset($data->rssi) ? $data->rssi :
                                                null),
                                              ':tariff1'                      => (isset($data->tariff1) ?
                                                $data->tariff1 :
                                                null),
                                              ':tariff2'                      => (isset($data->tariff2) ?
                                                $data->tariff2 :
                                                null),
                                              ':tariff3'                      => (isset($data->tariff3) ?
                                                $data->tariff3 :
                                                null),
                                              ':datetime'                     => $data->datetime,
                                              ':station_id'                   => (isset($data->station_id) ?
                                                $data->station_id :
                                                null),
                                              ':transformation_ratio'         => (isset($data->transformation_ratio) ?
                                                $data->transformation_ratio : 1),
                                              ':transformation_ratio_current' => (isset($data->transformation_ratio_current) ?
                                                $data->transformation_ratio_current : 1),
                                              ':transformation_ratio_voltage' => (isset($data->transformation_ratio_voltage) ?
                                                $data->transformation_ratio_voltage : 1),
                                              ':start_tariff1'                => (isset($data->start_tariff1) ?
                                                $data->start_tariff1 : null),
                                              ':end_tariff1'                  => (isset($data->end_tariff1) ?
                                                $data->end_tariff1 : null),
                                              ':delta_tariff1'                => (isset($data->delta_tariff1) ?
                                                $data->delta_tariff1 : null),
                                              ':start_tariff1_kkt'            => (isset($data->start_tariff1_kkt) ?
                                                $data->start_tariff1_kkt : null),
                                              ':end_tariff1_kkt'              => (isset($data->end_tariff1_kkt) ?
                                                $data->end_tariff1_kkt : null),
                                              ':delta_tariff1_kkt'            => (isset($data->delta_tariff1_kkt) ?
                                                $data->delta_tariff1_kkt : null),
                                              ':start_tariff2'                => (isset($data->start_tariff2) ?
                                                $data->start_tariff2 : null),
                                              ':end_tariff2'                  => (isset($data->end_tariff2) ?
                                                $data->end_tariff2 : null),
                                              ':delta_tariff2'                => (isset($data->delta_tariff2) ?
                                                $data->delta_tariff2 : null),
                                              ':start_tariff2_kkt'            => (isset($data->start_tariff2_kkt) ?
                                                $data->start_tariff2_kkt : null),
                                              ':end_tariff2_kkt'              => (isset($data->end_tariff2_kkt) ?
                                                $data->end_tariff2_kkt : null),
                                              ':delta_tariff2_kkt'            => (isset($data->delta_tariff2_kkt) ?
                                                $data->delta_tariff2_kkt : null),
                                              ':start_tariff3'                => (isset($data->start_tariff3) ?
                                                $data->start_tariff3 : null),
                                              ':end_tariff3'                  => (isset($data->end_tariff3) ?
                                                $data->end_tariff3 : null),
                                              ':delta_tariff3'                => (isset($data->delta_tariff3) ?
                                                $data->delta_tariff3 : null),
                                              ':start_tariff3_kkt'            => (isset($data->start_tariff3_kkt) ?
                                                $data->start_tariff3_kkt : null),
                                              ':end_tariff3_kkt'              => (isset($data->end_tariff3_kkt) ?
                                                $data->end_tariff3_kkt : null),
                                              ':delta_tariff3_kkt'            => (isset($data->delta_tariff3_kkt) ?
                                                $data->delta_tariff3_kkt : null),
                                            ]
                                          );
                                    } catch (Exception $e) {
                                        self::log(
                                          'Nekta: ' . $e->getMessage() . "\r\n" . CVarDumper::dumpAsString(
                                            (!empty($data) ? $data : '$data is empty! - catching')
                                          ),
                                          true
                                        );
                                        continue;
                                    }
                                }
                            }
                        }
// End ==============================
                    }
                    if (in_array(5, self::$enabledDataTypes)) {
// Begin ==============================
//                    $diff = time()-$device['starttime_t5'];
//                    self::log('Nekta: diff='.$diff);
                        $deviceData = $Nekta->getDeviceData($device['id'], $device['starttime_t5'], time(), 5);
                        if ($deviceData) {
                            $deviceData = json_decode($deviceData);
                            if (json_last_error() != JSON_ERROR_NONE) {
                                self::log(
                                  'Nekta: error in json_decode for deviceData' .
                                  "\r\n" .
                                  CVarDumper::dumpAsString($deviceData),
                                  true
                                );
                            }
                            try {
                                if (isset($deviceData->data->messages->data)) {
                                    if (!empty(($deviceData->data->messages->data)) &&
                                      is_array($deviceData->data->messages->data)) {
                                        foreach ($deviceData->data->messages->data as $i => $data) {
                                            if (empty($data)) {
                                                self::log(
                                                  'Nekta: ' .
                                                  CVarDumper::dumpAsString($deviceData) .
                                                  "\r\n" .
                                                  CVarDumper::dumpAsString(
                                                    '$data is empty! - continue normaly'
                                                  ),
                                                  true
                                                );
                                                continue;
                                            }
                                            $sql = '
                        insert into src_nekta_data_type5 (device_id, realdatetime, rssi, datetime, station_id, power_a_plus, 
                                                          incorrect_profile, incomplete_cut_flag, transformation_ratio_current, 
                                                          transformation_ratio_voltage)
                          values(
                                                          :device_id, to_timestamp(:realdatetime), :rssi, 
                                 to_timestamp(:datetime), :station_id, :power_a_plus, 
                                                          :incorrect_profile, :incomplete_cut_flag, 
                                 :transformation_ratio_current, 
                                                          :transformation_ratio_voltage
                          )
ON CONFLICT ON CONSTRAINT src_nekta_data_type5_pkey
                                          DO NOTHING
                        ';
                                            try {
                                                Yii::app()->db->createCommand($sql)
                                                  ->execute(
                                                    [
                                                      ':device_id'                    => $device['id'],
                                                      ':realdatetime'                 => $data->realdatetime,
                                                      ':rssi'                         => (isset($data->rssi) ?
                                                        $data->rssi :
                                                        null),
                                                      ':datetime'                     => (isset($data->datetime) ?
                                                        $data->datetime :
                                                        null),
                                                      ':station_id'                   => (isset($data->station_id) ?
                                                        $data->station_id :
                                                        null),
                                                      ':power_a_plus'                 => (isset($data->power_a_plus) ?
                                                        $data->power_a_plus : null),
                                                      ':incorrect_profile'            => (isset($data->incorrect_profile) ?
                                                        (int) $data->incorrect_profile : null),
                                                      ':incomplete_cut_flag'          => (isset($data->incomplete_cut_flag) ?
                                                        (int) $data->incomplete_cut_flag : null),
                                                      ':transformation_ratio_current' => (isset($data->transformation_ratio_current) ?
                                                        $data->transformation_ratio_current : null),
                                                      ':transformation_ratio_voltage' => (isset($data->transformation_ratio_voltage) ?
                                                        $data->transformation_ratio_voltage : null),
                                                    ]
                                                  );
                                            } catch (Exception $e) {
                                                self::log(
                                                  'Nekta: ' .
                                                  $e->getMessage() .
                                                  "\r\n" .
                                                  CVarDumper::dumpAsString($data),
                                                  true
                                                );
                                                continue;
                                            }
                                        }
                                    }
                                } else {
                                    self::log(
                                      'Nekta: ' . "\r\n" . CVarDumper::dumpAsString([$deviceData, $device]),
                                      true
                                    );
                                }
                            } catch (Exception $e) {
                                self::log(
                                  'Nekta: ' .
                                  $e->getMessage() .
                                  "\r\n" .
                                  CVarDumper::dumpAsString([$deviceData, $device]),
                                  true
                                );
                                continue;
                            }
                        }
// End ==============================
                    }
                    if (in_array(6, self::$enabledDataTypes)) {
// Begin ==============================
//                    $diff = time()-$device['starttime_t5'];
//                    self::log('Nekta: diff='.$diff);
                        $deviceData = $Nekta->getDeviceData($device['id'], $device['starttime_t6'], time(), 6);
                        if ($deviceData) {
                            $deviceData = json_decode($deviceData);
                            if (json_last_error() != JSON_ERROR_NONE) {
                                self::log(
                                  'Nekta: error in json_decode for deviceData' .
                                  "\r\n" .
                                  CVarDumper::dumpAsString($deviceData),
                                  true
                                );
                            }
                            if (is_array($deviceData->data->messages->data)) {
                                foreach ($deviceData->data->messages->data as $i => $data) {
                                    $sql = '
                        insert into src_nekta_data_type6 (device_id, realdatetime, freq, coruu3, status, current1, datetime, voltage1)
                          values(
                                                          :device_id, to_timestamp(:realdatetime), :freq, :coruu3, :status, 
                                 :current1, to_timestamp(:datetime), :voltage1
                          )
ON CONFLICT ON CONSTRAINT src_nekta_data_type6_pkey
                                          DO NOTHING
                        ';
                                    try {
                                        Yii::app()->db->createCommand($sql)
                                          ->execute(
                                            [
                                              ':device_id'    => $device['id'],
                                              ':realdatetime' => $data->realdatetime,
                                              ':freq'         => (isset($data->freq) ? $data->freq : null),
                                              ':coruu3'       => (isset($data->coruu3) ? $data->coruu3 : null),
                                              ':status'       => (isset($data->status) ? $data->status : null),
                                              ':current1'     => (isset($data->current1) ? $data->current1 : null),
                                              ':datetime'     => (isset($data->datetime) ? $data->datetime : null),
                                              ':voltage1'     => (isset($data->voltage1) ? $data->voltage1 : null),
                                            ]
                                          );
                                    } catch (Exception $e) {
                                        self::log(
                                          'Nekta: ' . $e->getMessage() . "\r\n" . CVarDumper::dumpAsString($data),
                                          true
                                        );
                                        continue;
                                    }
                                }
                            }
                        }
// End ==============================
                    }
                    Yii::app()->db->createCommand(
                      'UPDATE src_nekta_metering_devices
                    set data_updated = Now() where id = :id '
                    )
                      ->execute(
                        [
                          ':id' => $device['id'],
                        ]
                      );
                    $devicesProcessedCount = $devicesProcessedCount + 1;
                    $endTime = time() - $startTime;
                    if ($endTime > 60) {
                        break;
                    }
                }
            }
        }
        $endTime = time() - $startTime;
        $mess = 'Nekta: Complete in ' . $endTime . 's with ' . $devicesProcessedCount . ' devices';
        self::log($mess);
        echo $mess;
    }

}
