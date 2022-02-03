<?php

/**
 * This is the model class for table "blog_comments".
 * The followings are the available columns in table 'blog_comments':
 * @property string    $id
 * @property integer   $uid
 * @property string    $post_id
 * @property string    $created
 * @property string    $title
 * @property string    $body
 * @property integer   $enabled
 * The followings are the available model relations:
 * @property BlogPosts $post
 * @property Users     $u
 */
class BlogComments extends customBlogComments
{
    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogComments the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
