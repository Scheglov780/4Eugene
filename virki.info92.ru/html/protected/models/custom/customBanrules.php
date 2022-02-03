<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Banrules.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "banrules".
 * The followings are the available columns in table 'banrules':
 * @property string  $id
 * @property string  $description
 * @property string  $rule_source
 * @property string  $request_rule
 * @property string  $redirect_rule
 * @property integer $rule_order
 * @property integer $enabled
 */
class customBanrules extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'           => 'ID',
          'description'  => Yii::t('admin', 'Описание'),
          'request_rule' => Yii::t('admin', 'Условие запроса'),
          'rule_order'   => Yii::t('admin', 'Порядок отработки правила'),
          'enabled'      => Yii::t('admin', 'Вкл.'),
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
          ['rule_order, enabled', 'numerical', 'integerOnly' => true],
          ['request_rule', 'length', 'max' => 4000],
          ['description', 'safe'],
            // The following rule is used by search().

          ['id, description, request_rule, rule_order, enabled', 'safe', 'on' => 'search'],
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('request_rule', $this->request_rule, true);
        $criteria->compare('rule_order', $this->rule_order);
        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 20,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'banrules';
    }

    public static function applyRules()
    {
////REMOTE_ADDR, HTTP_USER_AGENT, //REQUEST_URI
        /*
        if  (preg_match('/firefox/i',$_SERVER['HTTP_USER_AGENT']) && preg_match('/\/item\/\d+/i',$_SERVER['REQUEST_URI'])) {
            return '/site/error';
        } else {
            return false;
        }
        */

        try {
            $rules = Banrules::model()->findAll('enabled=1 order by rule_order');
            if ($rules) {
                foreach ($rules as $rule) {
                    $result = @eval($rule['request_rule']);
                    if ($result != false) {
                        return $result;
                    }
                }
            }
        } catch (Exception $e) {
            return false;
        }
        return false;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Banrules the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
