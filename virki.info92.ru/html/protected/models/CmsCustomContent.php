<?php

/**
 * This is the model class for table "cms_custom_content".
 * The followings are the available columns in table 'cms_custom_content':
 * @property integer $id
 * @property string  $content_id
 * @property string  $lang
 * @property string  $content_data
 */
class CmsCustomContent extends customCmsCustomContent
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
