<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Billable.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

abstract class customBillable extends DSEventableActiveRecord
{
    /*
     private static $billableTableName;
     private static $billableItemsTableName;
     private static $billableItemsFKField;
     private static $billableItemsStatusesTableName;
    */
    public function __toString()
    {
        return $this->id;
    }

    public static function getBillableFullAddress($billable)
    {
        $fio = '';
        if ($billable->addresses['fullname']) {
            $fio = trim($fio . ' ' . $billable->addresses['fullname']);
        }
        $phone = '';
        if ($billable->addresses['phone']) {
            $phone = Yii::t('admin', 'Телефон') . ': ' . $billable->addresses['phone'];
        }
        $result = trim(($fio ? $fio . ', ' : '') . ($address ? $address . ', ' : '') . $phone, ",\t\n\r\x00\x0B");
        return $result;
    }

    public static function getBillableItemsLegend($id)
    {
        $staticParams = static::$staticParams;
        if (isset($staticParams['billableItemsStatusesTableName'])) {
            $itemsLegend = Yii::app()->db->createCommand(
              "SELECT min(ois.name) as name, count(0) AS cnt, min(ois.excluded) as excluded FROM {$staticParams['billableItemsTableName']} oi, 
                {$staticParams['billableItemsStatusesTableName']} ois WHERE ois.id=oi.status AND oi.{$staticParams['billableItemsFKField']}=:id
                                 GROUP BY ois.id"
            )->queryAll(true, [':id' => $id]);
        } else {
            //@todo: какая-то чепуха. Разобраться.
            $statusName = Yii::t('main', 'В посылке');
            $itemsLegend = Yii::app()->db->createCommand(
              "SELECT '{$statusName}' as name, count(0) AS cnt, 0 as excluded FROM {$staticParams['billableItemsTableName']} oi
              WHERE oi.{$staticParams['billableItemsFKField']}=:id"
            )->queryAll(true, [':id' => $id]);
        }
        if ($itemsLegend) {
            return $itemsLegend;
        } else {
            return [];
        }
    }

    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
