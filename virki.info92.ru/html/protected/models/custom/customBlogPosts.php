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
class customBlogPosts extends DSEventableActiveRecord
{
    public $accessRightsComment = '';
    public $accessRightsPost = '';
    public $authorName = '';
    public $categoryName = '';
    public $commentsCount = 0;
    public $rating = 0;

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
          'id'                  => 'PK',
          'uid'                 => Yii::t('main', 'ID пользователя'),
          'category_id'         => Yii::t('main', 'ID категории'),
          'title'               => Yii::t('main', 'Заголовок'),
          'tags'                => Yii::t('main', 'Тэги'),
          'body'                => Yii::t('main', 'Сообщение'),
          'created'             => Yii::t('main', 'Создано'),
          'start_date'          => Yii::t('main', 'Начало показа'),
          'end_date'            => Yii::t('main', 'Конец показа'),
          'enabled'             => Yii::t('main', 'Вкл'),
          'comments_enabled'    => Yii::t('main', 'Вкл комментарии'),
          'categoryName'        => Yii::t('main', 'Категория'),
          'authorName'          => Yii::t('main', 'Автор'),
          'commentsCount'       => Yii::t('main', 'Комментариев'),
          'rating'              => Yii::t('main', 'Рейтинг'),
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
          'blogComments' => [self::HAS_MANY, 'BlogComments', 'post_id'],
          'category'     => [self::BELONGS_TO, 'BlogCategories', 'category_id'],
          'u'            => [self::BELONGS_TO, 'Users', 'uid'],
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
          ['body, created', 'required'],
          ['uid, enabled, comments_enabled', 'numerical', 'integerOnly' => true],
          ['category_id', 'length', 'max' => 10],
          ['title, tags', 'length', 'max' => 255],
          ['start_date, end_date', 'safe'],
            // The following rule is used by search().

          [
            'id, uid, category_id, title, tags, body, created, start_date, end_date, enabled, comments_enabled',
            'safe',
            'on' => 'search',
          ],
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
    //@todo: см. абстрактную функцию предка. Другие паркаметры, ($criteria = null, $pageSize = 100, $id = null)
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

    public function search($pageSize = 25, $condition = '', $params = [], $dataProviderId = 'BlogPostsDP')
    {
        $criteria = new CDbCriteria;
        /*
                $criteria->join = "LEFT JOIN orders oo ON oo.id=t.oid
                                   LEFT JOIN users uu ON uu.uid=oo.uid";
                $criteria->params = array(':uid' => $_uid, ':manager' => $_manager);
        */
        $criteria->select = "t.*, cc.name as categoryName, cc.access_rights_post as accessRightsPost, 
        cc.access_rights_comment as accessRightsComment,
             coalesce(uu.fullname,'') as authorName,
        (select count(0) from blog_comments bc where bc.post_id = t.id and bc.enabled = 1) as commentsCount,
        (select round(avg(bc.rating)) from blog_comments bc where bc.post_id = t.id and bc.enabled = 1) as rating
        ";
        $criteria->join = "LEFT JOIN blog_categories cc ON cc.id=t.category_id
                                   LEFT JOIN users uu ON uu.uid=t.uid";
        /*
                    'categoryName' => Yii::t('main','Категория'),
                    'authorName' => Yii::t('main','Автор'),
                    'commentsCount' => Yii::t('main','Комментариев'),
                 */
        if ($condition) {
            $criteria->condition = $condition;
        }
        if ($params && is_array($params) && count($params)) {
            $criteria->params = $params;
        }
        $criteria->compare('t.id', $this->id, false);
        $criteria->compare('t.uid', $this->uid, false);
        $criteria->compare('t.category_id', $this->category_id, false);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('tags', $this->tags, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('start_date', $this->start_date, true);
        $criteria->compare('end_date', $this->end_date, true);
        $criteria->compare('t.enabled', $this->enabled, false);
        $criteria->compare('comments_enabled', $this->comments_enabled, false);

        /*        $dependecy = new CDbCacheDependency(
                  'SELECT sum(cnt) FROM (
        SELECT count(0) as cnt FROM blog_posts
        union all
        SELECT count(0) as cnt FROM blog_comments
        ) dd'
                );
        */

        return new CActiveDataProvider(
//          $this->cache(3600, $dependecy, 2), array(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.id desc',
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
        return 'blog_posts';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogPosts|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
