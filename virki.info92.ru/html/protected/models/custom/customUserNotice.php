<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserNotice.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "user_notice".
 * The followings are the available columns in table 'user_notice':
 * @property integer $id
 * @property string  $msg
 * @property double  $sum
 * @property integer $uid
 */
class customUserNotice extends CActiveRecord
{

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id' => 'ID',
          'msg' => 'Msg',
          'sum' => 'Sum',
          'uid' => 'Uid',
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
          ['id, uid', 'numerical', 'integerOnly' => true],
          ['sum', 'numerical'],
          ['msg', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
          ['id, msg, sum, uid', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('msg', $this->msg, true);
        $criteria->compare('sum', $this->sum);
        $criteria->compare('uid', $this->uid);

        return new CActiveDataProvider(
          $this, [
            'criteria' => $criteria,
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user_notice';
    }

    /**
     * Returns the static model of the specified AR class.
     * @return UserNotice the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function setFlash($uid, $message, $type = 6)
    {
        $notice = new UserNotice;
        $notice->msg = $message;
        $notice->uid = $uid;
        $notice->status = $type;
        $notice->data = CJSON::encode(['uid' => $uid, $message => 'message']);
        $notice->save();
    }
}