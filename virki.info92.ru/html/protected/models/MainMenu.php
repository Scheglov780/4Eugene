<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="MainMenu.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "categories_ext".
 * The followings are the available columns in table 'categories_ext':
 * @property integer $id
 * @property integer $cid
 * @property string  $ru
 * @property string  $en
 * @property integer $parent
 * @property integer $status
 * @property string  $url
 * @property string  $zh
 * @property string  $query
 * @property integer $level
 * @property integer $order_in_level
 */
class MainMenu extends customMainMenu
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
     * @return MainMenu|DSMetatagableActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}