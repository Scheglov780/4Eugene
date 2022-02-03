<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Question.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "questions".
 * The followings are the available columns in table 'questions':
 * @property integer $id
 * @property string  $theme
 * @property integer $date
 * @property integer $uid
 * @property integer $category
 * @property integer $date_change
 * @property integer $order_id
 * @property string  $file
 * @property integer $status
 * The followings are the available model relations:
 * @property Users   $u
 */
class Question extends customQuestion
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