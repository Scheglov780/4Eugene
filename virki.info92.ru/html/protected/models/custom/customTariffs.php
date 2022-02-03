<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * =================================================================================================================
 * <description file="customTariffs.php">
 * </description>
 *******************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "obj_tariffs".
 * The followings are the available columns in table 'obj_tariffs':
 * @property integer $tariffs_id
 * @property string  $tariff_name
 * @property string  $tariff_short_name
 * @property string  $tariff_description
 * @property string  $tariff_rules --jsonb
 * @property string  $created
 * @property string  $comments
 * @property integer $enabled
 * @property integer $acceptor
 */
class customTariffs extends DSEventableActiveRecord
{
    public $acceptor_name;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'tariffs_id'         => Yii::t('main', 'PK'),
          'tariff_name'        => Yii::t('main', 'Название тарифа'),
          'tariff_short_name'  => Yii::t('main', 'Короткое название тарифа'),
          'tariff_description' => Yii::t('main', 'Описание тарифа'),
          'tariff_rules'       => Yii::t('main', 'Правила тарифа'),
          'created'            => Yii::t('main', 'Дата создания'),
          'comments'           => Yii::t('main', 'Комментарии'),
          'enabled'            => Yii::t('main', 'Тариф включен'),
          'acceptor_id'        => Yii::t('main', 'Реквизиты получателя'),
          'acceptor_name'      => Yii::t('main', 'Реквизиты получателя'),
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
          ['tariffs_id', 'required', 'on' => 'update'],
          ['tariffs_id, enabled, acceptor_id', 'numerical', 'integerOnly' => true],
          ['tariff_name', 'length', 'max' => 256],
          ['tariff_short_name', 'length', 'max' => 48],
          ['tariff_description, tariff_rules, created, comments, acceptor_name', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'tariffs_id, tariff_name, tariff_short_name, tariff_description, tariff_rules, created, comments, enabled, acceptor_id, acceptor_name',
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
          "t.tariffs_id, t.tariff_name, t.tariff_short_name, t.tariff_description,
           jsonb_pretty(t.tariff_rules) as tariff_rules, t.created,t.comments, t.enabled,
           t.acceptor_id, acc.name||'<br>'||acc.bank as acceptor_name";
        $criteria->join = $criteria->join .
          /** @lang PostgreSQL */
          "
        left join obj_tariffs_acceptors acc on acc.tariff_acceptors_id = t.acceptor_id";
        $criteria->compare('tariffs_id', $this->tariffs_id);
        if ($this->tariff_name) {
            $criteria->addSearchCondition('tariff_name', $this->tariff_name, true, 'AND', 'ILIKE');
        }
        if ($this->tariff_short_name) {
            $criteria->addSearchCondition('tariff_short_name', $this->tariff_short_name, true, 'AND', 'ILIKE');
        }
        if ($this->tariff_description) {
            $criteria->addSearchCondition('tariff_description', $this->tariff_description, true, 'AND', 'ILIKE');
        }
        if ($this->tariff_rules) {
            $criteria->addSearchCondition('tariff_rules', $this->tariff_rules, true, 'AND', 'ILIKE');
        }
        if ($this->created) {
            $criteria->addSearchCondition('created', $this->created, true, 'AND', 'ILIKE');
        }
        if ($this->comments) {
            $criteria->addSearchCondition('comments', $this->comments, true, 'AND', 'ILIKE');
        }
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('acceptor_id', $this->acceptor_id);

        return new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'tariff_name'        => [
                  'asc'  => 'tariff_name ASC',
                  'desc' => 'tariff_name DESC',
                ],
                'tariff_short_name'  => [
                  'asc'  => 'tariff_short_name ASC',
                  'desc' => 'tariff_short_name DESC',
                ],
                'tariff_description' => [
                  'asc'  => 'tariff_description ASC',
                  'desc' => 'tariff_description DESC',
                ],
                'acceptor_name'      => [
                  'asc'  => 'acceptor_name ASC',
                  'desc' => 'acceptor_name DESC',
                ],
              ],
              'defaultOrder' => [
                'tariff_name' => CSort::SORT_ASC,
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
        return 'obj_tariffs';
    }

    public static function getList()
    {
        $res = self::model()->findAllBySql(
          "select tt.tariffs_id, tt.tariff_name
                      from obj_tariffs tt order by tt.tariff_name",
          []
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['tariffs_id']] = $r['tariff_name'];
            }
        }
        return $resArr;
    }

    public static function getListForDevice($id = null)
    {
        if (is_null($id)) {
            $sql = "select tt.tariffs_id, tt.tariff_short_name
                      from obj_tariffs tt 
where tt.tariff_rules->>'target' = 'device'
  AND tt.tariff_rules->>'regular' = 'true'
order by tt.tariff_short_name";
            $res = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            $sql = "select ul.tariffs_id
from obj_devices_tariffs ul where ul.deleted is null and ul.devices_id = :id";
            $res = Yii::app()->db->createCommand($sql)->queryColumn(
              [
                ':id' => $id,
              ]
            );
        }
        if (!is_array($res)) {
            $res = [];
        }
        return $res;
    }

    public static function getListForLand($id = null)
    {
        if (is_null($id)) {
            $sql = "select tt.tariffs_id, tt.tariff_short_name
                      from obj_tariffs tt 
where tt.tariff_rules->>'target' = 'land' 
  AND tt.tariff_rules->>'regular' = 'true'
order by tt.tariff_short_name";
            $res = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            $sql = "select ul.tariffs_id
from obj_lands_tariffs ul where ul.deleted is null and ul.lands_id = :id";
            $res = Yii::app()->db->createCommand($sql)->queryColumn(
              [
                ':id' => $id,
              ]
            );
        }
        if (!is_array($res)) {
            $res = [];
        }
        return $res;
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
          'tariff_name',
          'tariff_short_name',
          'tariff_description',
          'comments',
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

    public static function getUpdateLink($id, $external = false, $model = null, $value = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($model)) {
            $model = self::model()->findByPk($id);
        }
        if ($model) {
            if (is_null($value)) {
                $value = addslashes($model->tariff_name);
            }
            $tabName = addslashes($model->tariff_name);
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/tariffs/view/id/' . $id . '&tabName=' . $tabName;
            } else {
                $url = Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/tariffs/view', ['id' => $id]);
                return '<a href="' .
                  $url .
                  '" title="' .
                  Yii::t(
                    'admin',
                    'Просмотр тарифа'
                  ) .
                  '" onclick="getContent(this,\'' .
                  $tabName .
                  '\',false);return false;"><i class="fa fa-calculator"></i>&nbsp;' .
                  $value .
                  '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return DSActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
