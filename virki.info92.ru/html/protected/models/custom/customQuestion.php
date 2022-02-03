<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Question.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "questions".
 * The followings are the available columns in table 'questions':
 * @property integer $id
 * @property string  $theme
 * @property integer $date
 * @property integer $uid
 * @property integer $category
 * @property integer $date_change
 * @property integer $order_id
 * @property string  $file
 * @property integer $status
 * The followings are the available model relations:
 * @property Users   $u
 */
class customQuestion extends DSEventableActiveRecord
{
    public $status_name;
    public $text_category;
    public $username;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'            => 'ID',
          'theme'         => Yii::t('main', 'Тема'),
          'date'          => Yii::t('main', 'Дата'),
          'uid'           => Yii::t('main', 'ID пользователя'),
          'email'         => Yii::t('main', 'Контактный EMail'),
          'category'      => Yii::t('main', 'Категория'),
          'text_category' => Yii::t('main', 'Категория'),
          'date_change'   => Yii::t('main', 'Изменено'),
          'order_id'      => Yii::t('main', 'ID заказа'),
          'file'          => Yii::t('main', 'Файл'),
          'status'        => Yii::t('main', 'Статус'),
          'status_name'   => Yii::t('main', 'Статус'),
          'username'      => Yii::t('admin', 'Имя'),
          'phone'         => Yii::t('admin', 'Телефон'),
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
          ['date, uid, category, date_change, order_id, status', 'numerical', 'integerOnly' => true],
          ['theme', 'length', 'max' => 128],
          ['file', 'length', 'max' => 500],
            // The following rule is used by search().

          [
            'id, theme, date, uid, email, category, date_change, order_id, status, status_name',
            'safe',
            'on' => 'search',
          ],
        ];
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

        $criteria->compare('t.id', $this->id);
        $criteria->compare('theme', $this->theme, true);
        $criteria->compare("t.date", $this->date, true);
        if ($this->uid != null) {
            $criteria->compare('t.uid', $this->uid);
        }
        $criteria->compare('category', $this->category);
        $criteria->compare("date_change", $this->date_change, true);
        $criteria->compare('order_id', $this->order_id);
        $criteria->compare('t.status', $this->status);

        $criteria->select = "t.*, u.*,
      case when t.status=1 then '" . Yii::t('main', 'На рассмотрении') . "'
      when t.status=2 then '" . Yii::t('main', 'Получен ответ') . "'
      else '" . Yii::t('main', 'Закрыто') . "' end as status_name,
      case when category=1 then '" . Yii::t('main', 'Общие вопросы') . "'
      when category=2 then '" . Yii::t('main', 'Вопросы по моему заказу') . "'
      when category=3 then '" . Yii::t('main', 'Рекламация') . "'
      when category=4 then '" . Yii::t('main', 'Возврат денег') . "'
      else '" . Yii::t('main', 'Оптовые заказы') . "' end as text_category";
//      $criteria->with='u';
        $criteria->with = ['u' => ['select' => "email, fullname, phone"]];
        return new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.status ASC, t.date DESC',
            ],
            'pagination' => [
              'pageSize' => 25,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'questions';
    }

    public static function getUpdateLink($id, $external = false)
    {
        $question = self::model()->findByPk($id);
        if ($question) {
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/questions/view/id/' . $id . '&tabName=' . Yii::t(
                    'admin',
                    'Вопрос '
                  ) . $question->id;
            } else {
                return '<a href="' . Yii::app()->createUrl(
                    '/' . Yii::app()->controller->module->id . '/questions/view',
                    ['id' => $id]
                  ) . '" title="' . Yii::t(
                    'admin',
                    'Просмотр вопроса'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    Yii::t(
                      'admin',
                      'Вопрос '
                    ) . $question->id
                  ) . '\',false);return false;"><i class="fa fa-info"></i>&nbsp;' . Yii::t(
                    'admin',
                    'Вопрос '
                  ) . $question->id . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function getUserLink($id)
    {
        $question = self::model()->findByPk($id);
        if ($question) {
            return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                'site_domain'
              ) . '/cabinet/support/view/id/' . $id;
        } else {
            return '<a href="#">' . Yii::t('main', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Question|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}