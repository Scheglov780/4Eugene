<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleTabsHistory.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "module_tabs_history".
 * The followings are the available columns in table 'module_tabs_history':
 * @property integer $id
 * @property string  $module
 * @property string  $href
 * @property string  $name
 * @property string  $title
 * @property integer $uid
 * @property string  $date
 * The followings are the available model relations:
 * @property Users   $u
 */
class ModuleTabsHistory extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'     => Yii::t('main', 'id записи истории'),
          'href'   => Yii::t('main', 'Ссылка'),
          'module' => Yii::t('main', 'Модуль'),
          'name'   => Yii::t('main', 'История вкладок'),
          'title'  => Yii::t('main', 'title ссылки'),
          'uid'    => Yii::t('main', 'Uid'),
          'date'   => Yii::t('main', 'Дата'),
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
          ['module, href, name, uid, date', 'required'],
          ['uid', 'numerical', 'integerOnly' => true],
          ['href, title', 'length', 'max' => 1024],
          ['name', 'length', 'max' => 512],
          ['module', 'length', 'max' => 64],
            // The following rule is used by search().

          ['id, module, href, name, title, uid, date', 'safe', 'on' => 'search'],
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
        $criteria->compare('module', $this->module, true);
        $criteria->compare('href', $this->href, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('date', $this->date, true);

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
        return 'module_tabs_history';
    }

    public static function getHistory($uid = false, $module = false)
    {
        if ($uid === false) {
            $_uid = Yii::app()->user->id;
        } else {
            $_uid = $uid;
        }
        if (is_null($_uid) || $_uid === false) {
            return false;
        }
        if ($module === false) {
            $_module = Yii::app()->controller->module->id;
        } else {
            $_module = $module;
        }
        if (is_null($_module) || $_module === false) {
            return false;
        }

        $criteria = new CDbCriteria;
        $criteria->select = 'max(t.id) as id, t.href, max(t.name) as name, max(t.title) as title, t.uid';
        $criteria->condition = '[[module]]=:module and uid=:uid';
        $criteria->group = '[[module]], uid, href';
        $criteria->limit = 20;
        $criteria->params = [':module' => $_module, ':uid' => $_uid];
        $criteria->order = 'max("date") DESC';
        $cacheDependency =
          new CDbCacheDependency(
            "SELECT count(0) as cnt FROM module_tabs_history  where [[module]]='{$_module}' and uid={$_uid}"
          );
        $history = new CActiveDataProvider(
          self::model()->cache(3600, $cacheDependency, 2), [
            'criteria'   => $criteria,
            'sort'       => false,
            'pagination' => false,
//      'pagination' => array(
//        'pageSize' => 20,
//      ),
          ]
        );
        return $history;
    }

    public static function getHistoryArray($uid = false, $module = false)
    {
        if ($uid === false) {
            $_uid = Yii::app()->user->id;
        } else {
            $_uid = $uid;
        }
        if (is_null($_uid) || $_uid === false) {
            return false;
        }
        if ($module === false) {
            $_module = Yii::app()->controller->module->id;
        } else {
            $_module = $module;
        }
        if (is_null($_module) || $_module === false) {
            return false;
        }
        $cacheDependency =
          new CDbCacheDependency(
            "SELECT count(0) as cnt FROM module_tabs_history where [[module]]='{$_module}' and uid={$_uid}"
          );
        $history = Yii::app()->db->cache(3600, $cacheDependency, 2)->createCommand(
          "SELECT max(t.id) as id, t.href, t.name from module_tabs_history t 
                 WHERE [[module]]=:module AND uid=:uid GROUP BY [[module]], uid, href ORDER BY max(\"date\") DESC LIMIT 20"
        )->queryAll(true, [
          ':module' => $_module,
          ':uid'    => $_uid,
        ]);
        return $history;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ModuleTabsHistory|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

}
