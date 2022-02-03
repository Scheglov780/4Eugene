<?php

/**
 * This is the model class for table "blog_categories".
 * The followings are the available columns in table 'blog_categories':
 * @property string      $id
 * @property string      $name
 * @property string      $description
 * @property integer     $enabled
 * The followings are the available model relations:
 * @property BlogPosts[] $blogPosts
 */
class BlogCategories extends customBlogCategories
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogCategories the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
