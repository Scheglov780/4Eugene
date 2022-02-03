<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="IntSearch.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class ObjStructure
{
    public static function getLandReport(&$objData)
    {
        $data = json_decode($objData);
        $result = [];
        if (isset($data[0])) {
            /** @var Lands $land */
            $land = $data[0];
            if (!$land->address) {
                $result['L1'] = ['land', $land->lands_id, 'warning', 'Не указан адрес участка'];
            }
            if (!$land->land_area) {
                $result['L2'] = ['land', $land->lands_id, 'warning', 'Не указана площадь участка'];
            }
            if (!$land->land_geo_latitude) {
                $result['L3'] = ['land', $land->lands_id, 'warning', 'Не указаны географические координаты участка'];
            }
            if (!$land->land_number_cadastral) {
                $result['L4'] = ['land', $land->lands_id, 'warning', 'Не указан кадастровый номер участка'];
            }
            if (!$land->users) {
                $result['L5'] = ['land', $land->lands_id, 'danger', 'Не указан владелец участка'];
            } else {
                $users = $land->users;
                if (count($users) > 1) {
                    $result['L6'] = ['land', $land->lands_id, 'info', 'Несколько владельцев участка'];
                }
                /**
                 * @var int    $i
                 * @var  Users $user
                 */
                foreach ($users as $i => $user) {
                    if (!$user->email) {
                        $result['U1'] = ['user', $user->uid, 'warning', 'Не указан email владельца'];
                    }
                    if (!$user->phone) {
                        $result['U2'] = ['user', $user->uid, 'danger', 'Не указан телефон владельца'];
                    }
                }
            }
            if (!$land->devices) {
                $result['L7'] = ['land', $land->lands_id, 'danger', 'Не указаны приборы учёта'];
            } else {
                $devices = $land->devices;
                /**
                 * @var int     $i
                 * @var Devices $device
                 */
                foreach ($devices as $i => $device) {
                    if ($device->source == 'manual') {
                        $result['D1'] = [
                          'device',
                          $device->devices_id,
                          'info',
                          'Устаревший прибор учёта с ручным снятием показаний',
                        ];
                    }
                    if (!$device->tariffs_count) {
                        $result['D2'] = ['device', $device->devices_id, 'danger', 'Не указаны тарифы прибора учёта'];
                    }
                    if (!$device->starting_date) {
                        $result['D3'] = [
                          'device',
                          $device->devices_id,
                          'danger',
                          'Не указаны начальные данные прибора учёта',
                        ];
                    }
                }
            }
            if (!$land->tariffs) {
                $result['L8'] = ['land', $land->lands_id, 'danger', 'Не указаны тарифы участка'];
            }
        }
        // Comparison function
        if (!function_exists('getLandReportCompare')) {
            function getLandReportCompare($a, $b)
            {
                if ($a[2] == $b[2]) {
                    if ($a[3] == $b[3]) {
                        return 0;
                    }
                    return ($a[3] < $b[3]) ? -1 : 1;
                }
                $cmparr = ['danger', 'warning', 'info'];
                return (array_search($a[2], $cmparr)
                  < array_search($b[2], $cmparr)) ? -1 : 1;
            }
        }
// Sort and print the resulting array
        uasort($result, 'getLandReportCompare');
        return $result;
    }

    public static function getStructureDataProvider($rootId)
    {
        $sql = "
        select ss.tree_id, ss.tree_parent_id, ss.tree_children_count, ss.obj_id, ss.obj_type, 
               ss.obj_group, ss.obj_name, ss.obj_assigned, ss.obj_data from obj_structure_view ss
        ";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $workRows = [];
        if ($rows) {
            foreach ($rows as $i => $row) {
                $workRows[$row['tree_id']] = $row;
            }
            if (isset($workRows[$rootId]['tree_parent_id'])) {
                $rootParent = $workRows[$rootId]['tree_parent_id'];
            } else {
                $rootParent = null;
            }
            unset($workRows[$rootId]);
            if ($rootParent != $rootId) {
                foreach ($workRows as $i => $row) {
                    if ($row['tree_parent_id'] == $rootParent) {
                        unset($workRows[$i]);
                    }
                }
                foreach ($workRows as $i => $row) {
                    if ($row['tree_parent_id'] != $rootId && !isset($workRows[$row['tree_parent_id']])) {
                        unset($workRows[$i]);
                    }
                }
            }
        }

        $structureDataProvider = new CArrayDataProvider(
          $workRows, [
            'id'         => 'objStructureDataProvider',
            'keyField'   => 'tree_id',
//            'totalItemCount' => $menuCount,
            'pagination' => [
              'pageSize' => 100000,
            ],
          ]
        );
        return $structureDataProvider;
    }
}

