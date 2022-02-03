<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ReportsSystem.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "reports_system".
 * The followings are the available columns in table 'reports_system':
 * @property integer $id
 * @property string  $internal_name
 * @property string  $name
 * @property string  $description
 * @property string  $script
 * @property string  $group
 * @property integer $enabled
 */
class customReportsSystem extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'            => Yii::t('main', 'id отчета'),
          'internal_name' => Yii::t('main', 'Внутренее имя отчета'),
          'name'          => Yii::t('main', 'Отображаемое имя отчета'),
          'description'   => Yii::t('main', 'Описание отчета'),
          'script'        => Yii::t('main', 'Скрипт'),
          'group'         => Yii::t('main', 'Группа отчетов'),
          'order'         => Yii::t('main', 'Порядок в группе'),
          'enabled'       => Yii::t('main', 'Включен ли отчет'),
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
          ['script', 'required'],
          ['enabled,order', 'numerical', 'integerOnly' => true],
          ['internal_name, group', 'length', 'max' => 512],
          ['name', 'length', 'max' => 32767],
          ['description, script', 'safe'],
            // The following rule is used by search().

          [
            'id, internal_name, name, description, script, group, order, enabled',
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
    public function search()
    {


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('internal_name', $this->internal_name, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('script', $this->script, true);
        $criteria->compare('group', $this->group, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('order', $this->enabled);
        $criteria->order = "\"group\", enabled desc, \"order\"";

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 50,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'reports_system';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ReportsSystem the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
