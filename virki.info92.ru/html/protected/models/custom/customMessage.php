<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Message.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "messages".
 * The followings are the available columns in table 'messages':
 * @property integer $id
 * @property string  $question
 * @property string  $email
 * @property integer $uid
 * @property integer $qid
 */
class customMessage extends DSEventableActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'       => 'ID',
          'question' => Yii::t('main', 'Сообщение'),
          'email'    => Yii::t('main', 'Email'),
          'uid'      => 'Uid',
          'qid'      => 'Qid',
          'parent'   => 'Parent',
          'status'   => Yii::t('main', 'Статус'),
          'date'     => Yii::t('main', 'Дата'),
        ];
    }

    public function getQuestionThred($qid)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        // Yii::app()->db->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
        $criteria = new CDbCriteria;

        $criteria->compare('t.qid', $qid);
        $criteria->select = "t.*, u.*";
        $criteria->with = ['u' => ['select' => "email, fullname, phone"]];
        $criteria->order = 't.date ASC';
        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'sort'       => false,
            'pagination' => [
              'pageSize' => 50,
            ],
          ]
        );
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
          ['uid, qid, parent, status', 'numerical', 'integerOnly' => true],
          ['email', 'length', 'max' => 128],
          ['question, date', 'safe'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
          ['id, question, email, uid, qid, parent, status, date', 'safe', 'on' => 'search'],
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
        return parent::save();
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        if (!$criteria) {
            $criteria = new CDbCriteria;
        }
        if (!$dataProviderId) {
            $dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()) . '_dataProvider';
        }

        $criteria->compare('id', $this->id);
        $criteria->compare('question', $this->question, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('qid', $this->qid);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(
          $this, [
            'id'       => $dataProviderId,
            'criteria' => $criteria,
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'messages';
    }

    public static function getUpdateLink($id, $external = false)
    {
        $message = self::model()->findByPk($id);
        if ($message) {
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/message/view/id/' . $id . '&tabName=' . Yii::t(
                    'admin',
                    'Сообщение '
                  ) . $message->uid . '-' . $message->id;
            } else {
                return '<a href="' . Yii::app()->createUrl(
                    '/' . Yii::app()->controller->module->id . '/message/view',
                    ['id' => $id]
                  ) . '" title="' . Yii::t(
                    'admin',
                    'Просмотр сообщения'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    Yii::t(
                      'admin',
                      'Сообщение '
                    ) . $message->uid . '-' . $message->id
                  ) . '\',false);return false;"><i class="fa fa-envelope"></i>&nbsp;' . Yii::t(
                    'admin',
                    'Сообщение '
                  ) . $message->uid . '-' . $message->id . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function getUserLink($id)
    {
        $order = self::model()->findByPk($id);
        if ($order) {
            return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                'site_domain'
              ) . '/cabinet/message/view/id/' . $id;
        } else {
            return '<a href="#">' . Yii::t('main', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Message the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}