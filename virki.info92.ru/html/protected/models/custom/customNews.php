<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * =================================================================================================================
 * <description file="customNews.php">
 * </description>
 *******************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "obj_news".
 * The followings are the available columns in table 'obj_news':
 * @property integer                $news_id
 * @property string                 $news_header
 * @property string                 $news_body
 * @property integer                $news_author
 * @property string                 $news_author_name
 * @property string                 $created
 * @property string                 $comments
 * @property integer                $enabled
 * @property integer                $news_type
 * @property integer                $news_type_name
 * @property string                 $date_actual_start
 * @property string                 $date_actual_end
 * @property string                 $recipients
 * @property integer                $confirmation_needed
 * @property integer                $confirmed_count
 * @property integer                $confirmators_count
 * @property integer                $is_confirmed_by_current_user
 * @property integer                $absolute_order
 * The followings are the available model relations:
 * @property ObjNewsConfirmations[] $objNewsConfirmations
 */
class customNews extends DSEventableActiveRecord
{
    public $absolute_order;
    public $confirmators_count;
    public $confirmed_count;
    public $is_confirmed_by_current_user;
    public $news_author_name;
    public $news_type_name;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'news_id'                      => Yii::t('main', 'PK'),
          'news_header'                  => Yii::t('main', 'Заголовок сообщения'),
          'news_body'                    => Yii::t('main', 'Тело сообщения'),
          'news_author'                  => Yii::t('main', 'Автор'),
          'news_author_name'             => Yii::t('main', 'Автор'),
          'created'                      => Yii::t('main', 'Дата создания'),
          'comments'                     => Yii::t('main', 'Комментарии'),
          'enabled'                      => Yii::t('main', 'Включено'),
          'news_type'                    => Yii::t('main', 'Тип сообщения'),
          'news_type_name'               => Yii::t('main', 'Тип сообщения'),
          'date_actual_start'            => Yii::t('main', 'Начало публикации'),
          'date_actual_end'              => Yii::t('main', 'Окончание публикации'),
          'recipients'                   => Yii::t('main', 'Получатели'),
          'confirmation_needed'          => Yii::t('main', 'Нужно подтверждение прочтения'),
          'confirmed_count'              => Yii::t('main', 'Сделано подтверждений'),
          'confirmators_count'           => Yii::t('main', 'Требуется подтверждений'),
          'is_confirmed_by_current_user' => Yii::t('main', 'Подтвенрждено текущим пользователем'),
          'absolute_order'               => Yii::t('main', 'Приоритет'),
        ];
    }

    public function getAttributes($names = true)
    {
        $attr = parent::getAttributes($names);
        return $attr;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'objNewsConfirmations' => [self::HAS_MANY, 'ObjNewsConfirmations', 'news_id'],
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
          ['news_type, news_author', 'required'],
          [
            'news_id, news_author, enabled, news_type, confirmation_needed, absolute_order',
            'numerical',
            'integerOnly' => true,
          ],
          ['news_header, news_body, created, comments, date_actual_start, date_actual_end, recipients', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'news_id, news_header, news_body, news_author, created, comments, enabled, news_type, date_actual_start, date_actual_end, recipients, confirmation_needed, news_author_name, news_type_name, confirmed_count, confirmators_count, is_confirmed_by_current_user, absolute_order',
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
     * @param CDbCriteria|null $criteria
     * @param integer          $pageSize
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        if (!$criteria) {
            $criteria = new CDbCriteria;
        }
        if (!$dataProviderId) {
            $dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()) . '_dataProvider';
        }
        $criteria->select =
          /** @lang PostgreSQL */
          "t.*,
uu.fullname as news_author_name,
dc.val_name as news_type_name,
CASE 
WHEN (t.confirmation_needed is null OR t.confirmation_needed=0) THEN 0
ELSE (SELECT COUNT(0) from obj_news_confirmations nc where nc.news_id = t.news_id) END as confirmed_count,
CASE 
WHEN (t.confirmation_needed is null OR t.confirmation_needed=0) THEN 0
ELSE (SELECT COUNT(0) from users uu1 where uu1.status=1 
    and uu1.role in ('landlord','associate','superAdmin','topManager','leaseholder'))
END as confirmators_count,
(SELECT result from obj_news_confirmations nc where nc.news_id = t.news_id 
                                               AND nc.uid = :current_uid LIMIT 1) as is_confirmed_by_current_user
";
        $criteria->join = "LEFT JOIN dic_custom dc on dc.val_id = t.news_type
          LEFT JOIN users uu on uu.uid = t.news_author";
        $criteria->params[':current_uid'] = Yii::app()->user->id;
        $criteria->compare('news_id', $this->news_id);
        if ($this->news_header) {
            $criteria->addSearchCondition('news_header', $this->news_header, true, 'AND', 'ILIKE');
        }
        if ($this->news_body) {
            $criteria->addSearchCondition('news_body', $this->news_body, true, 'AND', 'ILIKE');
        }
        $criteria->compare('news_author', $this->news_author);
        if ($this->created) {
            $criteria->addSearchCondition('created', $this->created, true, 'AND', 'ILIKE');
        }
        if ($this->comments) {
            $criteria->addSearchCondition('comments', $this->comments, true, 'AND', 'ILIKE');
        }
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('news_type', $this->news_type);
        if ($this->date_actual_start) {
            $criteria->addSearchCondition('date_actual_start', $this->date_actual_start, true, 'AND', 'ILIKE');
        }
        if ($this->date_actual_end) {
            $criteria->addSearchCondition('date_actual_end', $this->date_actual_end, true, 'AND', 'ILIKE');
        }
        if ($this->recipients) {
            $criteria->addSearchCondition('recipients', $this->recipients, true, 'AND', 'ILIKE');
        }
        $criteria->compare('confirmation_needed', $this->confirmation_needed);

        return new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'news_id'             => [
                  'asc'  => 'news_id ASC',
                  'desc' => 'news_id DESC',
                ],
                'news_author_name'    => [
                  'asc'  => 'news_author_name ASC',
                  'desc' => 'news_author_name DESC',
                ],
                'created'             => [
                  'asc'  => 'created ASC',
                  'desc' => 'created DESC',
                ],
                'enabled'             => [
                  'asc'  => 'enabled ASC',
                  'desc' => 'enabled DESC',
                ],
                'news_type_name'      => [
                  'asc'  => 'news_type_name ASC',
                  'desc' => 'news_type_name DESC',
                ],
                'date_actual_start'   => [
                  'asc'  => 'date_actual_start ASC',
                  'desc' => 'date_actual_start DESC',
                ],
                'date_actual_end'     => [
                  'asc'  => 'date_actual_end ASC',
                  'desc' => 'date_actual_end DESC',
                ],
                'recipients'          => [
                  'asc'  => 'recipients ASC',
                  'desc' => 'recipients DESC',
                ],
                'confirmation_needed' => [
                  'asc'  => 'confirmation_needed ASC',
                  'desc' => 'confirmation_needed DESC',
                ],
                'absolute_order'      => [
                  'asc'  => 'absolute_order ASC',
                  'desc' => 'absolute_order DESC NULLS LAST',
                ],
              ],
              'defaultOrder' => [
                'absolute_order' => CSort::SORT_DESC,
                'created'        => CSort::SORT_DESC,
              ],
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
        return 'obj_news';
    }

    /**
     * @param integer $news_id
     * @param integer $uid
     * @return integer
     */
    public static function confirm($news_id, $uid, $result = 1)
    {
        $sql = "INSERT INTO obj_news_confirmations (news_id,uid,created,result)
                VALUES (:news_id,:uid,Now(),:result)
                ON CONFLICT ON CONSTRAINT obj_news_confirmations_news_id_uid_key
                DO UPDATE
                SET created = Now(), result = 100";
        $result = Yii::app()->db->createCommand($sql)->execute(
          [
            ':news_id' => $news_id,
            ':uid'     => $uid,
            ':result'  => $result,
          ]
        );
        return $result;
    }

    public static function getModelSearchSnippet($id, $query)
    {
        if (!function_exists('markup')) {
            function markup($val, $query)
            {
                $result = @preg_replace('/' . $query . '/i', '<strong>' . $query . '</strong>', $val);
                if (isset($result) && $result) {
                    return $result;
                } else {
                    return $val;
                }
            }
        }
        $model = self::model()->findByPk($id);
        $res = '';
        $fields = [
          'news_header',
          'news_body',
        ];
        if ($model) {
            foreach ($fields as $field) {
                if (strlen($model->{$field}) > 0) {
                    $res = $res . '<small>' . $model->getAttributeLabel($field) . ':</small> ' . markup(
                        $model->{$field},
                        $query
                      ) . '&nbsp;';
                }
            }
        }
        return $res;
    }

    public static function getNewsConfirmations($id, $pageSize = 100)
    {
        $sql = "
    select 
news_confirmations_id, 
tt.news_id,
row_number() over (PARTITION BY tt.news_id ORDER BY tt.created asc, tt.news_confirmations_id asc) as row_num,
round((100*(row_number() over (PARTITION BY tt.news_id ORDER BY tt.created asc, tt.news_confirmations_id asc))::float4
/(select count(0)::float4 from users uu2 where uu2.role in ('landlord','associate')))::numeric,1) as percent,
  tt.uid,
	tt.created, 
	Now() - tt.created as created_left,
	tt.created - nn.created as total_left,
	\"result\",
	uu.fullname
from obj_news_confirmations tt
 left join users uu on tt.uid=uu.uid
 left join obj_news nn on nn.news_id = tt.news_id
where tt.news_id = :news_id
order by tt.created desc
	 ";
        $totalItemCount = Yii::app()->db->createCommand("select count(0) from ({$sql}) t")->queryScalar(
          [':news_id' => $id]
        );

        $dataProvider = new CSqlDataProvider(
          $sql, [
            'params'         => [':news_id' => $id],
            'id'             => 'news-confirm-' . $id,
            'keyField'       => 'news_confirmations_id',
            'totalItemCount' => $totalItemCount,
            'pagination'     => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $dataProvider;
    }

    public static function getUpdateLink($id, $external = false, $news = null, $value = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($news)) {
            $news = self::model()->findByPk($id);
        }
        if ($news) {
            if (is_null($value)) {
                $value = addslashes('Сообщение ' . $news->news_id);
            }
            $tabName = addslashes('Сообщение ' . $news->news_id);
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/news/view/id/' . $id . '&tabName=' . $tabName;
            } else {
                $url = Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/news/view', ['id' => $id]);
                return '<a href="' .
                  $url .
                  '" title="' .
                  Yii::t(
                    'admin',
                    'Просмотр объявления'
                  ) .
                  '" onclick="getContent(this,\'' .
                  $tabName .
                  '\',false);return false;"><i class="fa fa-newspaper-o"></i>&nbsp;' .
                  $value .
                  '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function isConfirmed($news_id, $uid)
    {
        $result = Yii::app()->db->createCommand(
          "
SELECT result from obj_news_confirmations nc where nc.news_id = :news_id 
                                               AND nc.uid = :uid LIMIT 1 
"
        )->queryScalar(
          [
            'news_id' => $news_id,
            'uid'     => $uid,
          ]
        );
        if (!$result) {
            return 0;
        } else {
            return $result;
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return News|DSActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
