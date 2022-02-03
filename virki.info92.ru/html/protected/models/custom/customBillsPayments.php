<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsPayments.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "bills_payments".
 * The followings are the available columns in table 'bills_payments':
 * @property integer $id
 * @property integer $bid
 * @property integer $uid
 * @property double  $summ
 * @property string  $date
 * @property string  $descr
 * The followings are the available model relations:
 * @property Users   $u
 * @property Bills   $b
 */
class customBillsPayments extends BillablePayments
{
    public $code;
    public $manager_name;

    public function attributeLabels()
    {
        return [
          'id'           => Yii::t('main', 'ID платежа'),
          'bid'          => Yii::t('main', 'ID счёта'),
          'uid'          => Yii::t('main', 'ID пользователя или менеджера, проведшего платеж'),
          'summ'         => Yii::t('main', 'Сумма платежа'),
            //Yii::t('main', 'Сумма платежа') . ', ' . DSConfig::getSiteCurrency(),
          'date'         => Yii::t('main', 'Дата проведения платежа'),
          'descr'        => Yii::t('main', 'Описание платежа'),
          'manager_name' => Yii::t('main', 'Инициатор'),
          'code'         => Yii::t('main', 'Счёт'),
        ];
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        /* return array(
          'u' => array(self::BELONGS_TO, 'Users', 'uid'),
          'o' => array(self::BELONGS_TO, 'Bills', 'bid'),
        ); */
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
          ['bid, uid, summ, date', 'required'],
          ['bid, uid', 'numerical', 'integerOnly' => true],
          ['summ', 'numerical'],
          ['descr', 'safe'],
            // The following rule is used by search().

          ['id, bid, uid, summ, date, descr, manager_name', 'safe', 'on' => 'search'],
        ];
    }

    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('bid', $this->bid);
        $criteria->compare('uid', $this->uid);
        $criteria->compare('summ', $this->summ);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('descr', $this->descr, true);
        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
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
        return 'bills_payments';
    }

    public static function getBillPayments($billId, $pageSize = 5, $asArray = false, $userId = false)
    {
        // Must to return dataProviders for comments and attaches
        $criteria = new CDbCriteria;
        $criteria->select = '
        t.id, t.bid, t.uid,t.summ,t.date,t.descr, uu.fullname as manager_name, bb.code
        ';
        $criteria->join = '
        left join users uu on uu.uid = t.uid
        left join bills_for_statuses_view bb on bb.id = t.bid 
        ';
        $criteria->condition =
          '(t.uid=:uid or bb.uid = :uid or :uid::integer is null) and (t.bid=:bid or :bid::integer is null)';
        $criteria->params = [':uid' => ($userId ? $userId : null), ':bid' => ($billId ? $billId : null)];
        $criteria->order = 't.date DESC';
        $cacheDependency = new CDbCacheDependency("SELECT last_value FROM  bills_payments_id_seq");
        if ($asArray) {
            $rows = static::model()->cache(YII_DEBUG ? 0 : 3600, $cacheDependency)->findAll($criteria);
            return $rows;
        } else {
            $billPayments = new CActiveDataProvider(
              static::model()->cache(YII_DEBUG ? 0 : 3600, $cacheDependency, 2), [
                'criteria'   => $criteria,
                'sort'       => false,
                'pagination' => [
                  'pageSize' => $pageSize,
//        'currentPage'=>'pageCount'-1,
                ],
              ]
            );
            return $billPayments;
        }
    }

    public static function getPaymentsSumForBill($billId)
    {
        $cacheDependency = new CDbCacheDependency("SELECT last_value FROM  bills_payments_id_seq");
        $sum = static::model()->cache(3600, $cacheDependency)->findBySql(
          "SELECT round(coalesce(sum(t.summ),0),2) AS summ FROM bills_payments t WHERE t.bid=:bid",
          [
            ':bid' => $billId,
          ]
        );
        if ($sum) {
            return Formulas::cRound($sum['summ'], false, 2);
        } else {
            return 0;
        }
    }

    public static function getUpdateLink($id, $external = false)
    {
        $bill = static::model()->findByPk($id);
        if ($bill) {
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/billsPayments/view/id/' . $id . '&tabName=' . Yii::t(
                    'admin',
                    'Платёж '
                  ) . $bill->uid . '-' . $bill->id;
            } else {
                return '<a href="' . Yii::app()->createUrl(
                    '/' . Yii::app()->controller->module->id . '/billsPayments/view',
                    ['id' => $id]
                  ) . '" title="' . Yii::t(
                    'admin',
                    'Просмотр платежа'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    Yii::t(
                      'admin',
                      'Платёж '
                    ) . $bill->uid . '-' . $bill->id
                  ) . '\',false);return false;"><i class="fa fa-cc-visa"></i>&nbsp;' . Yii::t(
                    'admin',
                    'Платёж '
                  ) . $bill->uid . '-' . $bill->id . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function getUserLink($id)
    {
        $bill = static::model()->findByPk($id);
        if ($bill) {
            return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                'site_domain'
              ) . '/cabinet/bills/view/id/' . $id;
        } else {
            return '<a href="#">' . Yii::t('main', 'Ошибка') . '</a>';
        }
    }

    public static function payForBill($billId, $summ, $description = '', $userId = false, $paymentSystem = false)
    {
        $result = false;
        if (!$summ || $summ == 0) {
            return false;
        }
        if (!$paymentSystem || $paymentSystem == 'balance') {
            $bill = Bills::model()->findByPk($billId);
            $payment = new BillsPayments();
            $payment->bid = $billId;
            if ($userId === false) {
                if (Yii::app()->user->id) {
                    $payment->uid = Yii::app()->user->id;
                } else {
                    if ($bill && $bill->uid) {
                        $payment->uid = $bill->uid;
                    } else {
                        $payment->uid = DSConfig::getVal('checkout_default_manager_id');
                    }
                }
            } else {
                $payment->uid = $userId;
            }
            $payment->summ = $summ;
            $payment->descr = $description;
            $payment->date = date('Y-m-d H:i:s', time());
            $result = $payment->save();
            if ($result && $bill) {
                if (!in_array($bill->status, BillsStatuses::getStatusesArrayWithChildren(['IN_PROCESS']))) {
                    $bill->status = 'IN_PROCESS';
                }
                $bill->update();
            }
        } else {
            $paymentParams = [];
            if ($summ && $summ >= 0.01) {
                $paymentParams['sum'] = $summ;
            } else {
                return false;
            }
            if ($userId && ($userId == Yii::app()->user->id)) {
                $paymentParams['user'] = $userId;
            } else {
                return false;
            }
            $bill = Bills::model()->findByPk($billId);
            if ($bill && ($bill->uid == $userId)) {
                $paymentParams['bill'] = $billId;
            } else {
                return false;
            }
            $paySystem = PaySystems::getModelByType($paymentSystem);
            if ($paySystem) {
                $paymentParams['paysystem'] = $paymentSystem;
            } else {
                return false;
            }
            $signature = md5(
              $paymentParams['sum'] .
              $paymentParams['user'] .
              $paymentParams['bill'] .
              $paymentParams['paysystem'] .
              Yii::app()->id
            );
            $paymentParams['sig'] = $signature;
            $result = true;
            Yii::app()->request->redirect(
              Yii::app()->createUrl('/cabinet/balance/payment', $paymentParams),
              true,
              302
            );
        }
        return $result;
    }
}
