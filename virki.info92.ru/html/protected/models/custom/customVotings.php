<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * =================================================================================================================
 * <description file="customVotings.php">
 * </description>
 *******************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "obj_votings".
 * The followings are the available columns in table 'obj_votings':
 * @property integer $votings_id
 * @property integer $votings_type
 * @property integer $votings_type_name
 * @property string  $votings_header
 * @property string  $votings_query
 * @property string  $votings_variants
 * @property string  $votings_summary
 * @property integer $votings_author
 * @property integer $votings_author_name
 * @property string  $date_actual_start
 * @property string  $date_actual_end
 * @property string  $recipients
 * @property string  $created
 * @property integer $enabled
 * @property string  $comments
 * @property integer $voted_count
 * @property integer $voters_count
 * @property integer $is_voted_by_current_user
 */
class customVotings extends DSEventableActiveRecord
{
    public $is_voted_by_current_user;
    public $voted_count;
    public $voters_count;
    public $votings_author_name;
    public $votings_type_name;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'votings_id'               => Yii::t('main', 'PK'),
          'votings_type'             => Yii::t('main', 'Тип голосования'),
          'votings_type_name'        => Yii::t('main', 'Тип голосования'),
          'votings_header'           => Yii::t('main', 'Заголовок голосования'),
          'votings_query'            => Yii::t('main', 'Вопрос голосования'),
          'votings_variants'         => Yii::t('main', 'Параметры голосования'),
          'votings_summary'          => Yii::t('main', 'Итоги голосования'),
          'votings_author'           => Yii::t('main', 'Автор'),
          'votings_author_name'      => Yii::t('main', 'Автор'),
          'date_actual_start'        => Yii::t('main', 'Начало публикации'),
          'date_actual_end'          => Yii::t('main', 'Окончание публикации'),
          'recipients'               => Yii::t('main', 'Участники'),
          'created'                  => Yii::t('main', 'Дата создания'),
          'enabled'                  => Yii::t('main', 'Включено'),
          'comments'                 => Yii::t('main', 'Комментарии'),
          'voted_count'              => Yii::t('main', 'Проголосовало'),
          'voters_count'             => Yii::t('main', 'Всего голосующих'),
          'is_voted_by_current_user' => Yii::t('main', 'Текущий пользователь проголосовал'),
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
        return [];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
          ['votings_type, votings_author, votings_variants', 'required'],
          ['votings_id, votings_type, votings_author, enabled', 'numerical', 'integerOnly' => true],
          [
            'votings_header, votings_query, votings_summary, date_actual_start, date_actual_end, recipients, created, comments',
            'safe',
          ],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'votings_id, votings_type, votings_header, votings_query, votings_variants, votings_summary, votings_author, date_actual_start, date_actual_end, recipients, created, enabled, comments',
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
uu.fullname as votings_author_name,
dc.val_name as votings_type_name,
(SELECT COUNT(0) from obj_votings_results nc where nc.votings_id = t.votings_id) as voted_count,
(SELECT COUNT(0) from users uu1 where uu1.status=1 
    and uu1.role in ('landlord','associate','superAdmin','topManager','leaseholder'))
as voters_count,
(SELECT result from obj_votings_results nc where nc.votings_id = t.votings_id 
                                               AND nc.uid = :current_uid LIMIT 1) as is_voted_by_current_user
";
        $criteria->join = "LEFT JOIN dic_custom dc on dc.val_id = t.votings_type
          LEFT JOIN users uu on uu.uid = t.votings_author";
        $criteria->params[':current_uid'] = Yii::app()->user->id;
        $criteria->compare('votings_id', $this->votings_id);
        if ($this->votings_header) {
            $criteria->addSearchCondition('votings_header', $this->votings_header, true, 'AND', 'ILIKE');
        }
        if ($this->votings_query) {
            $criteria->addSearchCondition('votings_query', $this->votings_query, true, 'AND', 'ILIKE');
        }
        if ($this->votings_variants) {
            $criteria->addSearchCondition('votings_variants', $this->votings_variants, true, 'AND', 'ILIKE');
        }
        if ($this->votings_summary) {
            $criteria->addSearchCondition('votings_summary', $this->votings_summary, true, 'AND', 'ILIKE');
        }
        $criteria->compare('votings_author', $this->votings_author);
        if ($this->date_actual_start) {
            $criteria->addSearchCondition('date_actual_start', $this->date_actual_start, true, 'AND', 'ILIKE');
        }
        if ($this->date_actual_end) {
            $criteria->addSearchCondition('date_actual_end', $this->date_actual_end, true, 'AND', 'ILIKE');
        }
        if ($this->recipients) {
            $criteria->addSearchCondition('recipients', $this->recipients, true, 'AND', 'ILIKE');
        }
        if ($this->created) {
            $criteria->addSearchCondition('created', $this->created, true, 'AND', 'ILIKE');
        }
        $criteria->compare('enabled', $this->enabled);
        if ($this->comments) {
            $criteria->addSearchCondition('comments', $this->comments, true, 'AND', 'ILIKE');
        }
        return new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'votings_id'          => [
                  'asc'  => 'news_id ASC',
                  'desc' => 'news_id DESC',
                ],
                'votings_author_name' => [
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
                'votings_type_name'   => [
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
              ],
              'defaultOrder' => [
                'created' => CSort::SORT_DESC,
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
        return 'obj_votings';
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
          'votings_header',
          'votings_query',
          'votings_summary',
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

    public static function getUpdateLink($id, $external = false, $voting = null, $value = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($voting)) {
            $voting = self::model()->findByPk($id);
        }
        if ($voting) {
            if (is_null($value)) {
                $value = 'Голосование ' . $voting->votings_id;
            }
            $tabName = 'Голосование #' . $voting->votings_id;
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/votings/view/id/' . $id . '&tabName=' . addslashes($tabName);
            } else {
                $url = Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/votings/view', ['id' => $id]);
                return '<a href="' . $url . '" title="' . Yii::t(
                    'admin',
                    'Просмотр голосования'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    $tabName
                  ) . '\',false);return false;"><i class="fa fa-hand-paper-o"></i>&nbsp;' . $value . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function getVotingsVotes($id, $pageSize = 100)
    {
        $sql = "
    select 
votings_results_id, 
tt.votings_id,
row_number() over (PARTITION BY tt.votings_id ORDER BY tt.created, tt.votings_results_id asc) as row_num,
round((100*(row_number() over (PARTITION BY tt.votings_id ORDER BY tt.created, tt.votings_results_id asc))::float4
/(select count(0)::float4 from users uu2 where uu2.role in ('landlord','associate')))::numeric,1) as percent,
  tt.uid,
	tt.created, 
	Now() - tt.created as created_left,
	tt.created - nn.created as total_left,
	\"result\",
(select obj.val->'name'::text from json_array_elements(nn.votings_variants->'voting_results') obj(val)
  where obj.val->>'value' = tt.\"result\" 
	-- limit 1
 ) 
	as	result_name,
sum(\"result\"::integer) over (PARTITION BY tt.votings_id ORDER BY tt.created, tt.votings_results_id asc) as voting_result,           
	uu.fullname
from obj_votings_results tt
 left join users uu on tt.uid=uu.uid
 left join obj_votings nn on nn.votings_id = tt.votings_id
 where tt.votings_id = :votings_id
order by row_num desc
	 ";
        $totalItemCount = Yii::app()->db->createCommand("select count(0) from ({$sql}) t")->queryScalar(
          [':votings_id' => $id]
        );

        $dataProvider = new CSqlDataProvider(
          $sql, [
            'params'         => [':votings_id' => $id],
            'id'             => 'votings-votes-' . $id,
            'keyField'       => 'votings_results_id',
            'totalItemCount' => $totalItemCount,
            'pagination'     => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $dataProvider;
    }

    public static function isVoted($votings_id, $uid)
    {
        $result = Yii::app()->db->createCommand(
          "
SELECT result from obj_votings_results nc where nc.votings_id = :votings_id 
                                               AND nc.uid = :uid LIMIT 1 
"
        )->queryScalar(
          [
            'votings_id' => $votings_id,
            'uid'        => $uid,
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
     * @return Votings|DSActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    /**
     * @param integer $votings_id
     * @param integer $uid
     * @return integer
     */
    public static function vote($votings_id, $uid, $result = 1)
    {
        $sql = "INSERT INTO obj_votings_results (votings_id,uid,created,result)
                VALUES (:votings_id,:uid,Now(),:result)
                ON CONFLICT ON CONSTRAINT obj_votings_id_uid_key
                DO UPDATE
                SET created = Now(), result = :result";
        $result = Yii::app()->db->createCommand($sql)->execute(
          [
            ':votings_id' => $votings_id,
            ':uid'        => $uid,
            ':result'     => $result,
          ]
        );
        return $result;
    }
}
