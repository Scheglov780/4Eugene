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
class customBlogCategories extends CActiveRecord
{
    public $authorsCount = 0;
    public $commentsCount = 0;
    public $lastActivityDate = 0;
    /**
     * @return string the associated database table name
     */
    public $postsCount = 0;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'                    => 'PK',
          'name'                  => Yii::t('main', 'Категория'),
          'description'           => Yii::t('main', 'Описание'),
          'enabled'               => Yii::t('main', 'Вкл'),
          'postsCount'            => Yii::t('main', 'Сообщений'),
          'commentsCount'         => Yii::t('main', 'Комментариев'),
          'authorsCount'          => Yii::t('main', 'Авторов'),
          'lastActivityDate'      => Yii::t('main', 'Последняя активность'),
          'access_rights_post'    => Yii::t('main', 'Права на создание сообщения'),
          'access_rights_comment' => Yii::t('main', 'Права на создание комментария'),
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
          'blogPosts' => [self::HAS_MANY, 'BlogPosts', 'category_id'],
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
          ['enabled', 'numerical', 'integerOnly' => true],
          ['name', 'length', 'max' => 255],
          ['description, access_rights_post, access_rights_comment', 'safe'],
            // The following rule is used by search().

          ['id, name, description, enabled, access_rights_post, access_rights_comment', 'safe', 'on' => 'search'],
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
    public function search($pageSize = 25, $condition = '', $params = [], $adminMode = true)
    {
        $criteria = new CDbCriteria;
        /*
                $criteria->join = "LEFT JOIN orders oo ON oo.id=t.oid
                                   LEFT JOIN users uu ON uu.uid=oo.uid";
                $criteria->params = array(':uid' => $_uid, ':manager' => $_manager);
        */
        if ($adminMode) {
            $noAdminCondition = '';
        } else {
            $noAdminCondition =
              "and (bp.enabled=1 and (bp.start_date is null or bp.start_date <= Now()) and (bp.end_date is null or bp.end_date >= Now()))";
        }
        $criteria->select = "t.*, (select count(0) from blog_posts bp 
        where bp.category_id = t.id
        {$noAdminCondition}
        ) as postsCount,
        (select count(0) from blog_comments bc 
        where bc.post_id in (select bp.id from blog_posts bp where bp.category_id = t.id
        {$noAdminCondition}
        )
        ) as commentsCount,
        (select COUNT(DISTINCT bp.uid) as cnt from blog_posts 
        bp where bp.category_id = t.id
        {$noAdminCondition}
        ) as authorsCount,
        (select max(bp.created) from blog_posts bp 
        where bp.category_id = t.id
        {$noAdminCondition}
        ) as lastActivityDate
        ";
        if ($condition) {
            $criteria->condition = $condition;
        }
        if ($params && is_array($params) && count($params)) {
            $criteria->params = $params;
        }
        $criteria->compare('id', $this->id, false);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('enabled', $this->enabled);

        /*        $dependecy = new CDbCacheDependency(
                  'SELECT sum(cnt) FROM (
        SELECT count(0) as cnt FROM blog_categories
        union all
        SELECT count(0) as cnt FROM blog_posts
        union all
        SELECT count(0) as cnt FROM blog_comments
        ) dd'
                );
        */
        return new CActiveDataProvider(
//          $this->cache(3600, $dependecy, 2), array(
          $this, [
            'id'         => 'BlogCategoriesDP',
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.name ASC',
            ],
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
    }

    public function tableName()
    {
        return 'blog_categories';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return BlogCategories|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
