<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ReportsSystem.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "reports_system".
 * The followings are the available columns in table 'reports_system':
 * @property integer $id
 * @property string  $internal_name
 * @property string  $name
 * @property string  $description
 * @property string  $query
 * @property string  $data_props
 * @property string  $view_props
 * @property string  $type
 * @property string  $group
 * @property integer $enabled
 */
class ReportsSystem extends customReportsSystem
{
    /*=================================================================================================
     * Please use OOP (add, hide, override or overload any method or property) to implement
     * any of your own functionality needed. This file never will be overwritten or changed
     * with updates to protect your custom functionality.
     * Warning: don't change anything in "custom" folder - all your changes will be lost after update!
     =================================================================================================*/
    /*
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsCustomContent the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
