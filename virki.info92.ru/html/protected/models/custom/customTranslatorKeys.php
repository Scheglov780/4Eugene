<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="TranslatorKeys.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "translator_keys".
 * The followings are the available columns in table 'translator_keys':
 * @property integer $id
 * @property string  $key
 * @property string  $type
 * @property integer $enabled
 * @property integer $banned
 * @property string  $banned_date
 * @property string  $descr
 */
class customTranslatorKeys extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public $keyusage = '-';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'          => 'ID',
          'key'         => 'AppKey',
          'type'        => Yii::t('admin', 'Тип'),
          'enabled'     => Yii::t('admin', 'Вкл'),
          'banned'      => Yii::t('admin', 'Бан'),
          'banned_date' => Yii::t('admin', 'Дата бана'),
          'descr'       => Yii::t('admin', 'Описание'),
          'keyusage'    => Yii::t('admin', 'Расход'),
        ];
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
          ['enabled, banned', 'numerical', 'integerOnly' => true],
          ['key, type', 'length', 'max' => 512],
          ['banned_date, descr', 'safe'],
            // The following rule is used by search().

          ['id, key, type, enabled, banned, banned_date, descr', 'safe', 'on' => 'search'],
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
    public function search()
    {


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('type', $this->type, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('banned', $this->banned);
        $criteria->compare('banned_date', $this->banned_date, true);
        $criteria->compare('descr', $this->descr, true);

        $criteria->select = "t.*,
      concat(
       (select concat(sum(ll.chars),' (',round(100*sum(ll.chars)/10000000,1),'%)') from log_translator_keys ll where ll.keyid=t.id
      and ll.result !=0
      and ll.\"date\">(Now() - INTERVAL '1 MONTH')),', ',
       (select concat(count(0),' calls per hour') from log_translator_keys ll where ll.keyid=t.id
      and ll.result !=0
      and ll.\"date\">(Now() - INTERVAL '1 hour'))      
       ) as keyusage";

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 100,
            ],
          ]
        );
    }

    public function tableName()
    {
        return 'translator_keys';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TranslatorKeys the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
