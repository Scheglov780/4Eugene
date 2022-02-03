<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="OrdersPayments.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

abstract class customBillablePayments extends DSEventableActiveRecord
{

    abstract function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null);

    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
