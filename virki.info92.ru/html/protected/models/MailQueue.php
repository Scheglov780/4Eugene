<?php

/**
 * This is the model class for table "mail_queue".
 * The followings are the available columns in table 'mail_queue':
 * @property integer $id
 * @property string  $from
 * @property string  $from_name
 * @property string  $to
 * @property string  $subj
 * @property string  $body
 * @property integer $priority
 * @property string  $created
 * @property string  $processed
 * @property string  $result
 * @property string  $event_id
 * @property string  $posting_id
 */
class MailQueue extends customMailQueue
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
