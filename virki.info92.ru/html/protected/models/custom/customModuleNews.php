<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleNews.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "admin_news".
 * The followings are the available columns in table 'admin_news':
 * @property integer $id
 * @property integer $uid
 * @property string  $date
 * @property string  $message
 * The followings are the available model relations:
 * @property Users   $u
 */
class customModuleNews extends CActiveRecord
{
    public $username;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'       => Yii::t('admin', 'ID сообщения'),
          'uid'      => Yii::t('admin', 'UID отправителя'),
          'date'     => Yii::t('admin', 'Дата'),
          'message'  => Yii::t('admin', 'Текст сообщения'),
          'username' => Yii::t('admin', 'Автор'),
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
          'u' => [self::BELONGS_TO, 'Users', 'uid'],
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
          ['message', 'required'],
//			array('uid', 'numerical', 'integerOnly'=>true),
          ['message', 'length', 'max' => 4000],
            // The following rule is used by search().

          ['id, uid, date, message', 'safe', 'on' => 'search'],
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
        $this->uid = Yii::app()->user->id;
        $this->date = date("Y-m-d H:i:s", time());
        return parent::save();
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
    public function search($pageSize = 20)
    {


        $criteria = new CDbCriteria;
        $criteria->select = "t.*, (select uu.email from users uu where uu.uid=t.uid limit 1) as username";
//    $criteria->select = new CDbExpression("DATE_FORMAT(created, '%Y-%m-%d') AS created");

        $criteria->compare('id', $this->id);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('message', $this->message, true);
        $criteria->order = 't.date DESC';
        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
              /*            'sort' => array(
                            'defaultOrder' => 't.date DESC',
                          ), */
            'sort'       => false,
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
        return 'module_news';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ModuleNews|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
