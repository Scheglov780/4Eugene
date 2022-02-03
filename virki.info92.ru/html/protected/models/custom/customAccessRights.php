<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="AccessRights.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "access_rights".
 * The followings are the available columns in table 'access_rights':
 * @property string  $role
 * @property string  $description
 * @property string  $allow
 * @property string  $deny
 * The followings are the available model relations:
 * @property Users[] $users
 */
class customAccessRights extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'role'        => Yii::t('admin', 'Роль'),
          'description' => Yii::t('admin', 'Описание'),
          'allow'       => Yii::t('admin', 'Разрешено'),
          'deny'        => Yii::t('admin', 'Запрещено'),
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
          'users' => [self::HAS_MANY, 'Users', 'role'],
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
          ['role', 'required'],
          ['role', 'length', 'max' => 64],
          ['description, allow, deny', 'safe'],
            // The following rule is used by search().

          ['role, description, allow, deny', 'safe', 'on' => 'search'],
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
    public function search($criteria = null, $pageSize = 100)
    {


        $criteria = new CDbCriteria;

        $criteria->compare('role', $this->role, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('allow', $this->allow, true);
        $criteria->compare('deny', $this->deny, true);
        //   $criteria->select="t.role as id,t.*";

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
        return 'access_rights';
    }

    public static function GuestIsDisabled()
    {
        $res = self::model()->findByPk('guest');
        if ($res) {
            if ($res->deny == '*') {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }

    }

    public static function getRoleDescriptionByRole($role)
    {
        $res = self::model()->findByPk($role);
        if ($res) {
            return $res->description;
        } else {
            return null;
        }
    }

    public static function getRoles()
    {
        $res = self::model()->findAllBySql("SELECT role, description FROM access_rights", []);
        $resArr = [];
        if (($res != false) && ($res != null)) {
            foreach ($res as $r) {
                $resArr[$r['role']] = $r['description'];
            }
        }
        return $resArr;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return AccessRights the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
