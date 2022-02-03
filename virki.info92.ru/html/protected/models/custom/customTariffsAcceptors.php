<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * =================================================================================================================
 * <description file="customTariffsAcceptors.php">
 * </description>
 *******************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "obj_tariffs_acceptors".
 * The followings are the available columns in table 'obj_tariffs_acceptors':
 * @property integer $tariff_acceptors_id
 * @property string  $name
 * @property string  $address
 * @property string  $OGRN
 * @property string  $INN
 * @property string  $KPPacceptor
 * @property string  $schet
 * @property string  $valuta
 * @property string  $bank
 * @property string  $KPPbank
 * @property string  $BIK
 * @property string  $korrSchet
 * @property string  $created
 * @property string  $comments
 * @property integer $enabled
 */
class customTariffsAcceptors extends DSEventableActiveRecord
{

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'tariff_acceptors_id' => Yii::t('main', 'PK'),
          'name'                => Yii::t('main', 'Название'),
          'address'             => Yii::t('main', 'Адрес'),
          'OGRN'                => Yii::t('main', 'ОГРН'),
          'INN'                 => Yii::t('main', 'ИНН'),
          'KPPacceptor'         => Yii::t('main', 'КПП получателя'),
          'schet'               => Yii::t('main', 'Счёт'),
          'valuta'              => Yii::t('main', 'Валюта'),
          'bank'                => Yii::t('main', 'Банк'),
          'KPPbank'             => Yii::t('main', 'КПП банка'),
          'BIK'                 => Yii::t('main', 'БИК'),
          'korrSchet'           => Yii::t('main', 'Корр.счёт'),
          'created'             => Yii::t('main', 'Дата создания'),
          'comments'            => Yii::t('main', 'Комментарии'),
          'enabled'             => Yii::t('main', 'Получатель включен'),
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
          ['tariff_acceptors_id', 'required', 'on' => 'update'],
          ['tariff_acceptors_id, enabled', 'numerical', 'integerOnly' => true],
          ['name', 'length', 'max' => 256],
          [
            'address, OGRN, INN, KPPacceptor, schet, valuta, bank, KPPbank, BIK, korrSchet, created, comments',
            'safe',
          ],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'tariff_acceptors_id, name, address, OGRN, INN, KPPacceptor, schet, valuta, bank, KPPbank, BIK, korrSchet, created, comments, enabled',
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
          "t.*";
        $criteria->compare('tariff_acceptors_id', $this->tariff_acceptors_id);
        if ($this->name) {
            $criteria->addSearchCondition('name', $this->name, true, 'AND', 'ILIKE');
        }
        if ($this->address) {
            $criteria->addSearchCondition('address', $this->address, true, 'AND', 'ILIKE');
        }
        if ($this->OGRN) {
            $criteria->addSearchCondition('OGRN', $this->OGRN, true, 'AND', 'ILIKE');
        }
        if ($this->INN) {
            $criteria->addSearchCondition('INN', $this->INN, true, 'AND', 'ILIKE');
        }
        if ($this->KPPacceptor) {
            $criteria->addSearchCondition('KPPacceptor', $this->KPPacceptor, true, 'AND', 'ILIKE');
        }
        if ($this->schet) {
            $criteria->addSearchCondition('schet', $this->schet, true, 'AND', 'ILIKE');
        }
        if ($this->valuta) {
            $criteria->addSearchCondition('valuta', $this->valuta, true, 'AND', 'ILIKE');
        }
        if ($this->bank) {
            $criteria->addSearchCondition('bank', $this->bank, true, 'AND', 'ILIKE');
        }
        if ($this->KPPbank) {
            $criteria->addSearchCondition('KPPbank', $this->KPPbank, true, 'AND', 'ILIKE');
        }
        if ($this->BIK) {
            $criteria->addSearchCondition('BIK', $this->BIK, true, 'AND', 'ILIKE');
        }
        if ($this->korrSchet) {
            $criteria->addSearchCondition('korrSchet', $this->korrSchet, true, 'AND', 'ILIKE');
        }
        if ($this->created) {
            $criteria->addSearchCondition('created', $this->created, true, 'AND', 'ILIKE');
        }
        if ($this->comments) {
            $criteria->addSearchCondition('comments', $this->comments, true, 'AND', 'ILIKE');
        }
        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'name'        => [
                  'asc'  => 'name ASC',
                  'desc' => 'name DESC',
                ],
                'description' => [
                  'asc'  => 'description ASC',
                  'desc' => 'description DESC',
                ],
              ],
              'defaultOrder' => [
                'name' => CSort::SORT_ASC,
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
        return 'obj_tariffs_acceptors';
    }

    public static function getList()
    {
        $res = self::model()->findAllBySql(
          "select acc.tariff_acceptors_id, acc.name
                      from obj_tariffs_acceptors acc order by acc.name",
          []
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['tariff_acceptors_id']] = $r['name'];
            }
        }
        return $resArr;
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
          'name',
          'description',
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
                $value = addslashes($model->name);
            }
            $tabName = addslashes($model->name);
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/tariffsAcceptors/view/id/' . $id . '&tabName=' . $tabName;
            } else {
                $url =
                  Yii::app()->createUrl(
                    '/' . Yii::app()->controller->module->id . '/tariffsAcceptors/view',
                    ['id' => $id]
                  );
                return '<a href="' .
                  $url .
                  '" title="' .
                  Yii::t(
                    'admin',
                    'Просмотр получателя платежей'
                  ) .
                  '" onclick="getContent(this,\'' .
                  $tabName .
                  '\',false);return false;"><i class="fa fa-bank"></i>&nbsp;' .
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
