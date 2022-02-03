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
class customBlogComments extends DSEventableActiveRecord
{
    public $accessRightsComment = '';
    public $accessRightsPost = '';
    public $authorName = '';

    protected function beforeSave()
    {
        $this->body = Blogs::processEmbeddedImages($this->body);
        if ($this->hasEventHandler('onBeforeSave')) {
            $event = new CModelEvent($this);
            $this->onBeforeSave($event);
            return $event->isValid;
        } else {
            return true;
        }
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'                  => Yii::t('main', 'PK'),
          'uid'                 => Yii::t('main', 'ID пользователя'),
          'post_id'             => Yii::t('main', 'ID поста'),
          'created'             => Yii::t('main', 'Создано'),
          'title'               => Yii::t('main', 'Заголовок'),
          'body'                => Yii::t('main', 'Сообщение'),
          'enabled'             => Yii::t('main', 'Вкл'),
          'rating'              => Yii::t('main', 'Рейтинг'),
          'authorName'          => Yii::t('main', 'Автор'),
          'accessRightsPost'    => Yii::t('main', 'Создание сообщений в категории'),
          'accessRightsComment' => Yii::t('main', 'Создание комментариев в категории'),
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'post' => [self::BELONGS_TO, 'BlogPosts', 'post_id'],
          'u'    => [self::BELONGS_TO, 'Users', 'uid'],
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
          ['post_id, created', 'required'],
          ['uid, enabled, rating', 'numerical', 'integerOnly' => true],
          ['id, post_id', 'length', 'max' => 10],
          ['title', 'length', 'max' => 255],
          ['body', 'safe'],
            // The following rule is used by search().

          ['id, uid, post_id, created, title, body, enabled, rating', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    //@TODO: см. абстрактную функцию предка, тут другие параметры, ($criteria = null, $pageSize = 100, $id=null)
    /*
     *     public function search($criteria = null, $pageSize = 100, $dataProviderId = null)
    {
        if (!$criteria) {
            $criteria = new CDbCriteria;
        }
        if (!$id) {
            $id = lcfirst((new ReflectionClass($this))->getShortName()).'_dataProvider';
        }
     */

    public function search($postId, $pageSize = 25, $condition = '', $params = [])
    {
        $criteria = new CDbCriteria;
        $criteria->select = "t.*,
             coalesce(uu.fullname,'') as authorName,
             cc.access_rights_post as accessRightsPost, 
             cc.access_rights_comment as accessRightsComment
        ";
        $criteria->join = "LEFT JOIN blog_posts pp ON pp.id=t.post_id
        LEFT JOIN blog_categories cc ON cc.id=pp.category_id
        LEFT JOIN users uu ON uu.uid=t.uid";

        if ($condition) {
            $criteria->condition = $condition;
        }
        if ($params && is_array($params) && count($params)) {
            $criteria->params = $params;
        }

        $criteria->compare('post_id', $postId, false);
        $criteria->compare('post_id', $this->post_id, false);
        $criteria->compare('t.id', $this->id, false);
        $criteria->compare('t.uid', $this->uid, false);
        $criteria->compare('t.created', $this->created, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('t.enabled', $this->enabled, false);
        $criteria->compare('t.rating', $this->rating, false);

        /*        $dependecy = new CDbCacheDependency(
                  'SELECT sum(cnt) FROM (
        SELECT count(0) as cnt FROM blog_comments
        ) dd'
                );
        */
        return new CActiveDataProvider(
//          $this->cache(3600, $dependecy, 2), array(
          $this, [
            'id'         => 'blogCommentsDP-' . $postId,
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.id asc',
            ],
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );

    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'blog_comments';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogComments|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
