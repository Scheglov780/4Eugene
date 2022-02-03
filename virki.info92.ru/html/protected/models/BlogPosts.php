<?php

/**
 * This is the model class for table "blog_posts".
 * The followings are the available columns in table 'blog_posts':
 * @property string         $id
 * @property integer        $uid
 * @property string         $category_id
 * @property string         $title
 * @property string         $tags
 * @property string         $body
 * @property string         $created
 * @property string         $start_date
 * @property string         $end_date
 * @property integer        $enabled
 * @property integer        $comments_enabled
 * The followings are the available model relations:
 * @property BlogComments[] $blogComments
 * @property BlogCategories $category
 * @property Users          $u
 */
class BlogPosts extends customBlogPosts
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogPosts the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
