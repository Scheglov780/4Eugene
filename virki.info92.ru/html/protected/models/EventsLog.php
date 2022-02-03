<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="EventsLog.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "events_log".
 * The followings are the available columns in table 'events_log':
 * @property integer $id
 * @property string  $date
 * @property integer $uid
 * @property string  $event_name
 * @property integer $subject_id
 * The followings are the available model relations:
 * @property Events  $eventName
 * @property Users   $u
 */
class EventsLog extends customEventsLog
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
