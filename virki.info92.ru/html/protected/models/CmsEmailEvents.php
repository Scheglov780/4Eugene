<?php

/**
 * This is the model class for table "cms_email_events".
 * The followings are the available columns in table 'cms_email_events':
 * @property integer $id
 * @property string  $mailevent_name
 * @property string  $template
 * @property string  $class
 * @property string  $action
 * @property string  $condition
 * @property string  $recipients
 * @property integer $enabled
 */
class CmsEmailEvents extends customCmsEmailEvents
{

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsEmailEvents the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
