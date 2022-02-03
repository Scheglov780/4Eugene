<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Payment.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "payments".
 * The followings are the available columns in table 'payments':
 * @property integer $id
 * @property double  $sum
 * @property string  $description
 * @property integer $status
 * @property string  $date
 */
class customPayment extends DSEventableActiveRecord
{
    public $email;
    public $fullname;
    public $manager_name;
    public $phone;
    public $status_name;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'           => 'ID',
          'sum'          => Yii::t('admin', 'Сумма'),
          'description'  => Yii::t('admin', 'Описание'),
          'status'       => Yii::t('admin', 'Статус'),
          'status_name'  => Yii::t('admin', 'Статус'),
          'date'         => Yii::t('admin', 'Дата'),
          'uid'          => Yii::t('admin', 'ID пользователя'),
          'manager_id'   => Yii::t('admin', 'ID менеджера'),
          'manager_name' => Yii::t('admin', 'Менеджер'),
          'email'        => Yii::t('admin', 'EMail'),
          'fullname'     => Yii::t('admin', 'ФИО'),
          'phone'        => Yii::t('admin', 'Телефон'),
          'oid'          => Yii::t('admin', 'Счёт'),
        ];
    }

    public function primaryKey()
    {
        return 'id';
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
          ['id, status, uid, oid, manager_id', 'numerical', 'integerOnly' => true],
          ['sum', 'numerical'],
          ['description', 'length', 'max' => 256],
            // array('ruble', 'double'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            // array('id, sum, description, status, ruble', 'safe', 'on'=>'search'),
          [
            'id, sum, description, status, date, uid, manager_name, oid, email, fullname, phone, status_name',
            'safe',
            'on' => 'search,update,save',
          ],
        ];
    }

    public function save($refund_odrer = false, $runValidation = true, $attributes = null)
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
        /*
         *  1 - Зачисление или возврат средств
         *  2 - Снятие средств
         *  3 - Ожидание зачисления средств
         *  4 - Отмена ожидания зачисления средств
         *  5 - Отправка внутреннего перевода средств
         *  6 - Получение внутреннего перевода средств
         */
        $criteria->select =
          /** @lang PostgreSQL */
          "t.*, statuses.status_name, 
        uu.fullname, uu.email, uu.phone, mm.fullname as manager_name";

        $criteria->join = $criteria->join .
          /** @lang PostgreSQL */
          "
left join (
      values(1, 'Зачисление или возврат средств'),
			(2, 'Снятие средств'),
			(3, 'Ожидание зачисления средств'),
			(4, 'Отмена ожидания зачисления средств'),
			(5, 'Отправка внутреннего перевода средств'),
            (6, 'Получение внутреннего перевода средств'),
			(7, 'Зачисление бонуса или прибыли'),
			(8, 'Вывод средств из системы')
) statuses(status,status_name) on statuses.status = t.status
left join users uu on t.uid = uu.uid
left join users mm on t.manager_id = mm.uid
left join bills_view bv on t.oid = bv.id
";
        $criteria->addCondition("t.uid is not null and (t.uid::varchar != '')");
        $criteria->compare('t.id', $this->id);
        $criteria->compare('sum', $this->sum);
        if ($this->description) {
            $criteria->addSearchCondition('t.description', $this->description, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.status', $this->status);

        if ($this->date) {
            $criteria->addSearchCondition('t.date', $this->date, true, 'AND', 'ILIKE');
        }

        if ($this->email) {
            $criteria->addSearchCondition('t.email', $this->email, true, 'AND', 'ILIKE');
        }
        if ($this->fullname) {
            $criteria->addSearchCondition('t.fullname', $this->fullname, true, 'AND', 'ILIKE');
        }
        if ($this->phone) {
            $criteria->addSearchCondition('t.phone', $this->phone, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.uid', $this->uid);
        /*
        if (!isset($criteria->params[':uid'])) {
            $criteria->params[':uid'] = null;
        }
        if (!isset($criteria->params[':manager'])) {
            $criteria->params[':manager'] = null;
        }
        */
        if ($cacheDependency) {
            $modelClass = Payment::model()->cache(3600, $cacheDependency, 2);
        } else {
            $modelClass = $this;
        }
        return new CActiveDataProvider(
          $modelClass,
          [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'id'   => [
                  'asc'  => 't.id ASC',
                  'desc' => 't.id DESC',
                ],
                'date' => [
                  'asc'  => 't.date ASC',
                  'desc' => 't.date DESC',
                ],
              ],
              'defaultOrder' => [
                'date' => CSort::SORT_DESC,
              ],
            ],
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        //     var_dump($dataProvider->getData());
//      die;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'payments';
    }

    public static function getUpdateLink($id, $external = false)
    {
        $payment = self::model()->findByPk($id);
        if ($payment) {
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/payment/view/id/' . $id . '&tabName=' . Yii::t(
                    'admin',
                    'Платёж '
                  ) . $payment->uid . '-' . $payment->id;
            } else {
                return '<a href="' . Yii::app()->createUrl(
                    '/' . Yii::app()->controller->module->id . '/payment/view',
                    ['id' => $id]
                  ) . '" title="' . Yii::t(
                    'admin',
                    'Просмотр платежа'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    Yii::t(
                      'admin',
                      'Платёж '
                    ) . $payment->uid . '-' . $payment->id
                  ) . '\',false);return false;"><i class="fa fa-cc-visa"></i>&nbsp;' . Yii::t(
                    'admin',
                    'Платёж '
                  ) . $payment->uid . '-' . $payment->id . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function getUserLink($id)
    {
        $payment = self::model()->findByPk($id);
        if ($payment) {
            return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                'site_domain'
              ) . '/cabinet/payment/view/id/' . $id;
        } else {
            return '<a href="#">' . Yii::t('main', 'Ошибка') . '</a>';
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
