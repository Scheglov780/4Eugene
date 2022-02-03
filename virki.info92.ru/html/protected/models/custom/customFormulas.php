<?php

/**
 * This is the model class for table "formulas".
 * The followings are the available columns in table 'formulas':
 * @property integer $id
 * @property string  $formula_id
 * @property string  $formula
 * @property string  $description
 */
class customFormulas extends CActiveRecord
{

    private static $_rates_updated_from_bank_in_this_session = false;
    protected static $_UserCountry = false;
    protected static $_UserK = false;
    protected static $_destCurr = false;
    protected static $_destCurrRate = false;
    protected static $_priceK_array = false;
    protected static $_skidkaK_array = false;
    protected static $_srcCurr = false;
    protected static $_srcCurrRate = false;
    protected static $formula_cache = [];

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'          => 'PK',
          'formula_id'  => Yii::t('main', 'id формулы'),
          'formula'     => Yii::t('main', 'Формула расчета, php'),
          'description' => Yii::t('main', 'Описание формулы'),
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
          ['formula_id', 'length', 'max' => 256],
          ['formula, description', 'safe'],
            // The following rule is used by search().

          ['id, formula_id, formula, description', 'safe', 'on' => 'search'],
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
        $criteria->compare('formula_id', $this->formula_id, true);
        $criteria->compare('formula', $this->formula, true);
        $criteria->compare('description', $this->description, true);

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
        return 'formulas';
    }

    protected static function getCountK($count)
    {
        $_count = (float) $count;
        $koef_discount = 1;
        if ($_count <= 1) {
            return $koef_discount;
        }
        if (self::$_skidkaK_array == false) {
            self::$_skidkaK_array = Yii::app()->db->createCommand(
              "SELECT
              cast(SUBSTRING(counts.id,'skidka_([0-9]+)_[0-9]+') AS INTEGER) AS count_from,
              cast(SUBSTRING(counts.id,'skidka_[0-9]+_([0-9]+)') AS INTEGER) AS count_to,
              \"value\"
              FROM
              (SELECT cc.id, cc.value FROM config cc
              WHERE cc.id ~ 'skidka_[0-9]+_[0-9]+') counts
              ORDER BY count_from, count_to"
            )
              ->queryAll();
        }
        if (is_array(self::$_skidkaK_array)) {
            foreach (self::$_skidkaK_array as $skidkaK) {
                if (($skidkaK['count_from'] < $_count) && ($_count <= $skidkaK['count_to'])) {
                    $koef_discount = $skidkaK['value'];
                    break;
                }
            }
        }
        return $koef_discount;
    }

    /* =====================================================================================================================

              Собственно, формулы.

       ===================================================================================================================*/

    protected static function getFormula($formulaId)
    {
        if (is_array(self::$formula_cache)) {
            if (isset(self::$formula_cache[$formulaId])) {
                return self::$formula_cache[$formulaId];
            }
        }
        $rec = self::model()
          ->findBySql("SELECT * FROM formulas WHERE formula_id=:formulaId", [':formulaId' => $formulaId]);
        if ($rec) {
            $res = $rec['formula'];
            if (!is_array(self::$formula_cache)) {
                self::$formula_cache = [];
            }
            self::$formula_cache[$formulaId] = $res;
            return $res;
        } else {
            throw new CException(Yii::t('main', 'Формула') . ' ' . $formulaId . ' ' . Yii::t('main', 'не найдена!'));
        }
    }

    protected static function getPriceK($price)
    {
        $_price = (float) $price;
        $koef_price = 1;
        if (self::$_priceK_array == false) {
            self::$_priceK_array = Yii::app()->db->createCommand(
              "SELECT
                    cast(SUBSTRING(prices.id,'price_([0-9]+)_[0-9]+') AS INTEGER) AS price_from,
                    cast(SUBSTRING(prices.id,'price_[0-9]+_([0-9]+)') AS INTEGER) AS price_to,
                    \"value\"
              FROM
              (SELECT cc.id, cc.value FROM config cc
              WHERE cc.id ~ 'price_[0-9]+_[0-9]+') prices
               ORDER BY price_from, price_to"
            )
              ->queryAll();
        }
        if (is_array(self::$_priceK_array)) {
            foreach (self::$_priceK_array as $priceK) {
                if (($priceK['price_from'] < $_price) && ($_price <= $priceK['price_to'])) {
                    $koef_price = $priceK['value'];
                    break;
                }
            }
        }
        return $koef_price;
    }

    protected static function getUserCountry($uid)
    {
        if (!self::$_UserCountry) {
            $u = Addresses::model()->find('uid=:uid and enabled=1', [':uid' => $uid]);
            if ($u) {
                self::$_UserCountry =
                  ($u['country'] ? $u['country'] : DSConfig::getValDef('delivery_default_country', 'RUS'));
            } else {
                self::$_UserCountry = DSConfig::getValDef('delivery_default_country', 'RUS');
            }
        }
        return self::$_UserCountry;
    }

    protected static function getUserK($uid)
    {
        if (!self::$_UserK) {
            $u = Users::model()->findByPk($uid);
            if ($u) {
                self::$_UserK = (float) ($u['skidka'] ? $u['skidka'] : 1);
            } else {
                self::$_UserK = 1;
            }
        }
        return self::$_UserK;
    }

    public static function GetPriceTable($dsSource, $price, $delivery, $postageId, $weight, $isTmall)
    {
        $prices = new stdClass();
        $prices->pricesX = [];
        $prices->pricesYprice = [];
        $prices->pricesYeconomy = [];
        for ($i = 1; $i < 21; $i++) {
            $prices->pricesX[] = $i;
            //TODO: разобраться с dsSource
            $resUserPrice = self::getUserPrice(
              [
                'dsSource'    => $dsSource,
                'price'       => $price,
                'count'       => $i,
                'deliveryFee' => $delivery,
                'postageId'   => $postageId,
                'sellerNick'  => false,
                'weight'      => $weight,
                'isTmall'     => $isTmall,
              ]
            );
            $p = $resUserPrice->price;
            $prices->pricesYeconomy[] = $resUserPrice->discount;
            $prices->pricesYprice[] = self::cRound($p / $i);
        }
        $arr = [21, 51, 101];
        foreach ($arr as $i) {
            $prices->pricesX[] = $i;
            //TODO: разобраться с dsSource
            $resUserPrice = self::getUserPrice(
              [
                'dsSource'    => $dsSource,
                'price'       => $price,
                'count'       => $i,
                'deliveryFee' => $delivery,
                'postageId'   => $postageId,
                'sellerNick'  => false,
                'weight'      => $weight,
                'isTmall'     => $isTmall,
              ]
            );
            $p = $resUserPrice->price;
            $prices->pricesYeconomy[] = $resUserPrice->discount;
            $prices->pricesYprice[] = self::cRound($p / $i);
        }
        return $prices;
    }

    public static function cRound($val, $currency = false, $digitsNum = false)
    {
        if (!$currency) {
            $currency = DSConfig::getCurrency();//DSConfig::getSiteCurrency();
        } else {
            $currency = $currency;
        }
        $res = (float) $val;
        if (eval(self::getFormula('CRound')) === false) {
            throw new CException('Ошибки в формуле CRound');
        }
        return (float) $res;
    }

    public static function calculateOrder($order)
    {
// === Variables =============
        try {
            $vars = [];
            $vars['orderId'] = new FormulasVar($order->id, [], Yii::t('main', 'Идентификатор заказа (PK)'));
            $vars['items_count'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT coalesce(sum(oi.num),0)
                  FROM orders_items oi WHERE oi.oid=:oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
              )->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Общее количество заказанных штук товаров во всех лотах заказа (кроме отмененных лотов)'
            )
            );
            $vars['actual_items_count'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT coalesce(sum(coalesce(oi.actual_num,oi.num)),0)
                       FROM orders_items oi WHERE oi.oid=:oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
              )->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Общее количество фактически штук товаров во всех лотах заказа (кроме отмененных лотов)'
            )
            );

            $vars['source_total'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT coalesce(
          sum(LEAST(oi.source_price, oi.source_promotion_price)*oi.num + oi.express_fee),0)
            FROM orders_items oi WHERE oi.oid=:oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
              )->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Общая стоимость закупки всех лотов на таобао при заказе, в валюте продавца (кроме отмененных лотов)'
            )
            );
            if ($vars['source_total']) {
                $vars['source_total']->val = self::cRound($vars['source_total']->val, false, 2);
            }
            $vars['source_total_curr'] = new FormulasVar(
              Formulas::convertCurrency(
                $vars['source_total']->val,
                'cny',
                DSConfig::getVal('site_currency'),
                false,
                $order->date
              ), [], Yii::t(
              'main',
              'Общая стоимость закупки всех лотов на таобао при заказе, в валюте сайта (кроме отмененных лотов)'
            )
            );
            $vars['actual_source_total'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT
           round(
                     sum(
          CASE
           WHEN oi.actual_lot_price IS NULL THEN (LEAST(oi.source_price, oi.source_promotion_price)* coalesce(oi.actual_num, oi.num)
                                                   + coalesce(oi.actual_lot_express_fee, oi.express_fee))

           ELSE oi.actual_lot_price + coalesce(oi.actual_lot_express_fee, oi.express_fee)
           END
                       )
                   ,2)
            FROM orders_items oi
           WHERE oi.oid = :oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
              )->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Фактическая стоимость закупки всех лотов, в валюте продавца (кроме отмененных лотов)'
            )
            );

            $vars['actual_source_express_fee'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT
           round(
                     sum(coalesce(oi.actual_lot_express_fee, oi.express_fee))
                   ,2)
            FROM orders_items oi
           WHERE oi.oid = :oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
              )->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Фактическая стоимость доставки всех лотов, в валюте продавца (кроме отмененных лотов)'
            )
            );

            $vars['actual_source_price'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT
           round(
                     sum(
          CASE
           WHEN oi.actual_lot_price IS NULL THEN (LEAST(oi.source_price, oi.source_promotion_price)* coalesce(oi.actual_num, oi.num))

           ELSE oi.actual_lot_price
           END
                       )
                   ,2)
            FROM orders_items oi
           WHERE oi.oid = :oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
              )->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Фактическая стоимость товаров всех лотов на таобао, в валюте продавца (кроме отмененных лотов)'
            )
            );

            if ($vars['actual_source_total']) {
                $vars['actual_source_total']->val = self::cRound($vars['actual_source_total']->val, false, 2);
            }
            $vars['actual_source_total_curr'] = new FormulasVar(
              Formulas::convertCurrency(
                $vars['actual_source_total']->val,
                'cny',
                DSConfig::getVal('site_currency'),
                false,
                $order->date
              ), [], Yii::t(
              'main',
              'Фактическая стоимость закупки всех лотов на таобао при заказе, в валюте сайта (кроме отмененных лотов)'
            )
            );

            $vars['actual_lots_weight'] = new FormulasVar(
              Yii::app()->db
                ->createCommand(
                  "SELECT
             round(
                       sum(
            CASE
             WHEN oi.actual_lot_weight IS NULL THEN oi.weight * coalesce(oi.actual_num, oi.num)
             ELSE oi.actual_lot_weight
             END
                         )
                     ,0)
              FROM orders_items oi
             WHERE oi.oid = :oid AND oi.status NOT IN (SELECT ois.id FROM orders_items_statuses ois WHERE ois.excluded=1)"
                )->queryScalar(
                  [
                    ':oid' => $vars['orderId']->val,
                  ]
                ), $vars, Yii::t(
              'main',
              'Фактический вес всех лотов заказа, в граммах (кроме отмененных лотов)'
            )
            );

            $vars['sum'] = new FormulasVar(
              $order->sum,
              $vars,
              Yii::t('main', 'Цена товаров заказа c доставкой от продавца, при оформлении')
            );
            $vars['delivery'] = new FormulasVar(
              $order->delivery, $vars, Yii::t(
              'main',
              'Цена доставки заказа при оформлении'
            )
            );
            $vars['order_total'] = new FormulasVar(
              $vars['sum']->val + $vars['delivery']->val, $vars, Yii::t(
              'main',
              'Общая цена заказа при оформлении'
            )
            );

            $vars['manual_weight'] = new FormulasVar(
              $order->manual_weight, $vars, Yii::t(
              'main',
              'Общий итоговый вес заказа, введенный вручную'
            )
            );

            $vars['usedWeight'] = new FormulasVar(
              ($vars['manual_weight']->val > 0) ? $vars['manual_weight']->val : $vars['actual_lots_weight']->val,
              $vars,
              Yii::t(
                'main',
                'Вес заказа, который будет использоваться при окончательных расчетах'
              )
            );
            $vars['delivery_country'] = new FormulasVar(
              $order->addresses['country'], [], Yii::t(
              'main',
              'Страна доставки'
            )
            );

//    print_r($order->addresses['country']);
//     $vars['delivery_country']->val

            $vars['delivery_id'] = new FormulasVar($order->delivery_id, $vars, Yii::t('main', 'Служба доставки'));
            $delivery = Deliveries::getDelivery(
              $vars['usedWeight']->val,
              $vars['delivery_country']->val,
              $vars['delivery_id']->val,
              1
            ); //
            if (isset($delivery->summ)) {
                $vars['actual_lots_delivery'] = new FormulasVar($delivery->summ, $vars);
            } else {
                $vars['actual_lots_delivery'] = new FormulasVar('', $vars);
            }
            $vars['actual_lots_delivery']->description = Yii::t('main', 'Стоимость доставки по весу лотов');

            $orderItems = OrdersItems::model()->findAll(
              'oid=:oid and status not in (select ois.id from orders_items_statuses ois where ois.excluded=1)',
              [':oid' => $vars['orderId']->val]
            );

            $vars['actual_lots_summ'] = new FormulasVar(0, $vars, Yii::t('main', 'Сумма цен лотов'));
            $vars['billing_use_operator_account'] = new FormulasVar(
              DSConfig::getValDef(
                'billing_use_operator_account',
                0
              ) == 1, [], Yii::t('main', 'Начислять ли бонусы оператору')
            );
            $vars['operatorProfit'] = new FormulasVar(0, $vars, Yii::t('main', 'Профит оператора по лотам'));
// begin of items calculation
            if ($orderItems) {
                foreach ($orderItems as $orderItem) {
                    if ($vars['billing_use_operator_account']->val) {
                        $vars['operatorProfit']->val =
                          $vars['operatorProfit']->val + $orderItem->calculated_operatorProfit;
                    }
                    /*        if ($orderItem->calculated_actualPrice) {
                              $price = $orderItem->calculated_actualPrice;
                            } else {
                              $price = 2;//min($orderItem->source_price, $orderItem->source_promotion_price);
                            }
                    */
                    $price = (($orderItem->calculated_actualPrice > 0) ? $orderItem->calculated_actualPrice : min(
                      $orderItem->source_price,
                      $orderItem->source_promotion_price
                    ));

                    $num = (($orderItem->actual_num) ? $orderItem->actual_num : $orderItem->num);
                    $actualDeliveryCalculation = (isset($orderItem->actual_lot_express_fee) &&
                      is_numeric($orderItem->actual_lot_express_fee)
                      && (float) $orderItem->actual_lot_express_fee >= 0);
                    $delivery =
                      ($actualDeliveryCalculation ? $orderItem->actual_lot_express_fee : $orderItem->express_fee);
                    //$delivery = ($actualDeliveryCalculation ? $orderItem->actual_lot_express_fee/$num : $orderItem->express_fee);
                    $weight =
                      (($orderItem->actual_lot_weight) ? $orderItem->actual_lot_weight / $num : $orderItem->weight);
                    $resUserPrice = self::getUserPrice(
                      [
                        'dsSource'     => $orderItem->ds_source,
                        'price'        => $price,
                        'count'        => $num,
                        'deliveryFee'  => $delivery,
                        'postageId'    => 0,
                        'sellerNick'   => $orderItem->seller_nick,
                        'currency'     => DSConfig::getSiteCurrency(),
                        'currencyDate' => $order->date,
                        'user'         => $order->uid,
                        'weight'       => $weight,
                        'isTmall'      => (isset($orderItem->ds_type) && ($orderItem->ds_type == 'tmall')),
                        'internal'     => $actualDeliveryCalculation,
                      ]
                    );
                    $vars['actual_lots_summ']->val = $vars['actual_lots_summ']->val + $resUserPrice->price;
                    $vars['actual_lots_summ']->description =
                      $vars['actual_lots_summ']->description .
                      '<br/>(' .
                      $price .
                      ' cny + ' .
                      $delivery .
                      ' cny) * ' .
                      $num .
                      ' pcs * ' .
                      DSConfig::getVal(
                        'price_main_k'
                      ) .
                      ' k = ' .
                      $resUserPrice->price .
                      ' ' .
                      DSConfig::getSiteCurrency();
                    //.'<br/>'.print_r($orderItem,true);
//        $vars['calculated_actualPrice']+$vars['calculated_actualExpressFee']
                }
            }
// end of items calculation
            /*            $vars['actual_lots_summ']->val = $vars['actual_lots_summ']->val + Formulas::cRound(
                            $vars['operatorProfit']->val * DSConfig::getVal('price_main_k'),
                            DSConfig::getSiteCurrency()
                          );
            */
            $vars['actual_lots_total'] = new FormulasVar(
              $vars['actual_lots_summ']->val +
              (($vars['actual_lots_delivery']->val) ? $vars['actual_lots_delivery']->val : 0),
              $vars, Yii::t('main', 'Стоимость товаров и доставки по лотам')
            );

            $vars['manual_delivery'] = new FormulasVar(
              $order->manual_delivery, $vars, Yii::t(
              'main',
              'Стоимость доставки вручную'
            )
            );
            $vars['manual_sum'] = new FormulasVar(
              $order->manual_sum, $vars, Yii::t('main', 'Стоимость заказа вручную')
            );
            $vars['manual_total'] = new FormulasVar(
              (($vars['manual_delivery']->val || ($vars['manual_delivery']->val === '0')) ?
                $vars['manual_delivery']->val : $vars['delivery']->val)
              +
              (($vars['manual_sum']->val || ($vars['manual_sum']->val === '0')) ? $vars['manual_sum']->val :
                $vars['actual_lots_summ']->val),
              $vars, Yii::t('main', 'Стоимость заказа вручную')
            );
            $vars['payments_sum'] = new FormulasVar(
              Yii::app()->db->createCommand(
                "SELECT round(coalesce(sum(opp.summ),0),2) FROM orders_payments opp
LEFT JOIN orders oo ON opp.oid=oo.id WHERE opp.oid=:oid -- and opp.date>=extract(epoch FROM (oo.date))"
              )//TODO: time-of-order-payment
              ->queryScalar(
                [
                  ':oid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t('main', 'Сумма платежей по заказу')
            );

            $vars['payments_saldo'] = new FormulasVar(
              $vars['payments_sum']->val - $vars['manual_total']->val, $vars, Yii::t(
              'main',
              'Сальдо платежей по заказу'
            )
            );

            $vars['realCost'] = new FormulasVar(
              $vars['actual_source_total_curr']->val
              + (($vars['manual_delivery']->val) ? $vars['manual_delivery']->val : $vars['delivery']->val),
              $vars,
              Yii::t(
                'main',
                'Актуальная себестоимость заказа'
              )
            );

            $vars['showedCost'] = new FormulasVar(
              $vars['source_total_curr']->val
              + (($vars['manual_delivery']->val) ? $vars['manual_delivery']->val : $vars['delivery']->val),
              $vars,
              Yii::t(
                'main',
                'Отображаемая себестоимость заказа'
              )
            );
            $vars['realProfit'] = new FormulasVar(
              $vars['payments_sum']->val - $vars['realCost']->val, $vars, // - $vars['payments_saldo']->val
              Yii::t('main', 'Реальное сальдо полученных платежей по заказу и его реальной себестоимости')
            );
            $vars['showedProfit'] = new FormulasVar(
              $vars['payments_sum']->val - $vars['showedCost']->val, $vars, Yii::t( // - $vars['payments_saldo']->val
              'main',
              'Отображаемое сальдо полученных платежей по заказу и его реальной себестоимости'
            )
            );
            if ($vars['billing_use_operator_account']->val) {
                $vars['billing_operator_profit_model'] = new FormulasVar(
                  DSConfig::getValDef(
                    'billing_operator_profit_model',
                    ''
                  ), [], Yii::t('main', 'Параметры начисления бонусов')
                );
                parse_str($vars['billing_operator_profit_model']->val, $profitModel);
                //FROM_PURCHASE - от разницы на закупке лотов, FROM_TOTAL - от общей прибыли с заказа.
                if (isset($profitModel['FROM_TOTAL'])) {
                    $vars['operatorProfit'] = new FormulasVar(
                      round(
                        $vars['operatorProfit']->val +
                        (($vars['showedProfit']->val < 0) ? 0 :
                          $vars['showedProfit']->val * $profitModel['FROM_TOTAL']),
                        2
                      ),
                      $vars, Yii::t('main', 'Профит оператора')
                    );
                }
            }
            $vars['siteProfit'] = new FormulasVar(
              round(
                $vars['realProfit']->val - $vars['operatorProfit']->val,
                2
              ), $vars, Yii::t('main', 'Профит сайта')
            );
        } catch (Exception $e) {
            CVarDumper::dump($e, 1, true);
            die;
        }
        return $vars;
    }

    public static function calculateOrderItem($item)
    {

        // === Variables =============
        $vars = [];
        if (($item->actual_num <= 0) || ($item->actual_num == null)) {
            $item->actual_num = $item->num;
        }

        $vars['num'] = new FormulasVar(
          $item->num, [], Yii::t(
          'main',
          'Заказанное количество штук товаров в лоте'
        )
        );
        $vars['actual_num'] = new FormulasVar(
          $item->actual_num, $vars, Yii::t(
          'main',
          'Фактическое количество штук товаров в лоте'
        )
        );
//???
        $vars['calculated_lotPrice'] = new FormulasVar(
          min(
            $item->source_promotion_price,
            $item->source_price
          ) * $vars['num']->val, $vars,
          Yii::t('main', 'Стоимость закупки лота в заказе, в валюте продавца')
        );
//=========================================================
        $intParams = [];
        $vars['isTmall'] = $item->ds_type == 'tmall';
        $vars['postage'] = new stdClass();
        $vars['postage']->start_fee = $item->express_fee;
        $vars['postage']->add_fee = $item->express_fee;
        $vars['postage']->add_standard = 1;
        $intParams['count'] = $vars['num']->val;
        $vars['weight'] = $item->weight;
        if (eval(self::getFormula('getUserPrice[postFee]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[postFee]');
        }

//=========================================================
        $vars['calculated_lotExpressFee'] = new FormulasVar(
        //$item->express_fee * $vars['num']->val
          $vars['postFee'], $vars,
          Yii::t('main', 'Стоимость доставки лота в заказе, в валюте продавца')
        );
        $vars['calculated_lotWeight'] = new FormulasVar(
          $item->weight * $vars['num']->val, $vars,
          Yii::t('main', 'Вес лота в заказе')
        );

        $vars['calculated_actualPrice'] = new FormulasVar(
          ($vars['actual_num']->val > 0) ? Formulas::cRound(
            $item->actual_lot_price / $vars['actual_num']->val,
            false,
            2
          ) : 0, $vars,
          Yii::t('main', 'Расчетная стоимость одного товара лота')
        );
        $vars['calculated_actualWeight'] = new FormulasVar(
          ($vars['actual_num']->val > 0) ? round(
            $item->actual_lot_weight / $item->actual_num
          ) : 0, $vars,
          Yii::t('main', 'Расчетный вес одного товара лота')
        );
        $vars['calculated_actualExpressFee'] = new FormulasVar(
          ($vars['actual_num']->val > 0) ? Formulas::cRound(
            $item->actual_lot_express_fee / $vars['actual_num']->val,
            false,
            2
          ) : 0, $vars,
          Yii::t('main', 'Расчетная стоимость доставки одного товара лота')
        );

        $vars['billing_use_operator_account'] = new FormulasVar(
          DSConfig::getValDef(
            'billing_use_operator_account',
            0
          ) == 1, [],
          Yii::t('main', 'Начислять ли бонусы оператору')
        );
        if ($vars['billing_use_operator_account']->val) {
            $vars['billing_operator_profit_model'] = new FormulasVar(
              DSConfig::getValDef(
                'billing_operator_profit_model',
                ''
              ), [], Yii::t('main', 'Параметры начисления бонусов')
            );
            parse_str($vars['billing_operator_profit_model']->val, $profitModel);
            //FROM_PURCHASE - от разницы на закупке лотов, FROM_TOTAL - от общей прибыли с заказа FROM_SOURCE_PRICE - процент от цены на таобао
            if (isset($profitModel['FROM_PURCHASE']) && (!in_array(
                $item->status,
                OrdersItemsStatuses::getOrderItemExcludedStatusesArray()
              )) && ($item->actual_lot_price)
            ) {
                $vars['basePrice'] = new FormulasVar(
                  (min(
                      $item->source_promotion_price,
                      $item->source_price
                    ) * $vars['actual_num']->val) +
                  ($item->express_fee), $vars, Yii::t( // * $vars['actual_num']->val
                  'main',
                  'Расчетная стоимость закупки лота с доставкой от продавца'
                )
                );
                $vars['realPrice'] = new FormulasVar(
                  $item->actual_lot_price + $item->actual_lot_express_fee, $vars, Yii::t(
                  'main',
                  'Фактическая стоимость закупки лота с доставкой от продавца'
                )
                );
                $vars['delta'] = new FormulasVar(
                  $vars['basePrice']->val - $vars['realPrice']->val, $vars, Yii::t(
                  'main',
                  'Экономия на закупке'
                )
                );
                $vars['profit'] = new FormulasVar(
                  $vars['delta']->val *
                  (($vars['basePrice']->val > $vars['realPrice']->val) ? (float) $profitModel['FROM_PURCHASE'] : 1),
                  $vars,
                  Yii::t('main', 'Профит оператора от экономии на закупке в валюте продавца')
                );
                $vars['calculated_operatorProfit'] = new FormulasVar(
                  Formulas::convertCurrency(
                    $vars['profit']->val,
                    'cny',
                    DSConfig::getVal('site_currency')
                  ), $vars, Yii::t('main', 'Профит оператора')
                );
            }
            if (isset($profitModel['FROM_SOURCE_PRICE']) && (!in_array(
                $item->status,
                OrdersItemsStatuses::getOrderItemExcludedStatusesArray()
              )) && ($item->actual_lot_price)
            ) {
                $vars['realPrice'] = new FormulasVar(
                  $item->actual_lot_price + $item->actual_lot_express_fee, $vars, Yii::t(
                  'main',
                  'Фактическая стоимость закупки лота с доставкой от продавца'
                )
                );

                $vars['profit2'] = new FormulasVar(
                  $vars['realPrice']->val * (float) $profitModel['FROM_PURCHASE'], $vars,
                  Yii::t('main', 'Профит оператора от стоимости товара в валюте продавца')
                );
                if (isset($vars['profit2'])) {
                    $profit = $vars['profit']->val + $vars['profit2']->val;
                } else {
                    $profit = $vars['profit2']->val;
                }
                $vars['calculated_operatorProfit'] = new FormulasVar(
                  Formulas::convertCurrency(
                    $profit,
                    'cny',
                    DSConfig::getVal('site_currency')
                  ), $vars, Yii::t('main', 'Профит оператора')
                );
            }
        }
        return $vars;
    }

    public static function calculateParcel($parcel)
    {
// === Variables =============
        try {
            $vars = [];
            $vars['orderId'] = new FormulasVar($parcel->id, [], Yii::t('main', 'Идентификатор заказа (PK)'));
            $vars['actual_items_count'] = new FormulasVar(
              Yii::app()->db->createCommand(
                'SELECT coalesce(sum(pi.num),0)
                  FROM parcels_items pi WHERE pi.pid=:pid'
              )->queryScalar(
                [
                  ':pid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t(
              'main',
              'Общее количество заказанных штук товаров во всех лотах заказа (кроме отмененных лотов)'
            )
            );

            $vars['delivery_country'] = new FormulasVar(
              $parcel->addresses['country'], [], Yii::t(
              'main',
              'Страна доставки'
            )
            );

            $vars['billing_use_operator_account'] = new FormulasVar(
              DSConfig::getValDef(
                'billing_use_operator_account',
                0
              ) == 1, [], Yii::t('main', 'Начислять ли бонусы оператору')
            );
            $vars['operatorProfit'] = new FormulasVar(0, $vars, Yii::t('main', 'Профит оператора по лотам'));

            $vars['payments_sum'] = new FormulasVar(
              Yii::app()->db->createCommand(
                'SELECT round(coalesce(sum(ppp.summ),0),2) FROM parcels_payments ppp
LEFT JOIN parcels pp ON ppp.pid=pp.id WHERE ppp.pid=:pid -- and opp.date>=extract(epoch FROM (oo.date))'
              )//TODO: time-of-order-payment
              ->queryScalar(
                [
                  ':pid' => $vars['orderId']->val,
                ]
              ), $vars, Yii::t('main', 'Сумма платежей по заказу')
            );

            $vars['payments_saldo'] = new FormulasVar(
              $vars['payments_sum']->val - (is_numeric($parcel->manual_sum) ? $parcel->manual_sum : $parcel->sum),
              $vars,
              Yii::t(
                'main',
                'Сальдо платежей по заказу'
              )
            );
        } catch (Exception $e) {
            CVarDumper::dump($e, 1, true);
            die;
        }
        return $vars;
    }

    public static function calculateParcelItem($item)
    {
        // === Variables =============
        $vars = [];
        $vars['num'] = new FormulasVar(
          $item->num, [], Yii::t(
          'main',
          'Количество штук товаров лота в посылке'
        )
        );
        return $vars;
    }

    public static function convertCurrency($srcVal, $srcCurr, $destCurr, $digitsNum = false, $forDate = false)
    {
        //ini_set('precision', 20);
        if (!self::$_rates_updated_from_bank_in_this_session &&
          DSConfig::getVal('rates_auto_update') &&
          ((time() - DSConfig::getVal(
                'rates_auto_update_last_time'
              )) > 60 * 60 * 8)
        ) {
            Utils::getCurrencyRatesFromBank();
            self::$_rates_updated_from_bank_in_this_session = true;
        }

        if ($srcCurr == $destCurr) {
            $res = self::cRound($srcVal, $destCurr, $digitsNum);
            return (float) $res;
        }
        if ((self::$_srcCurr != $srcCurr) && !$forDate) {
            $srcCurrRate = self::getCurrencyRate($srcCurr, $forDate);
            self::$_srcCurr = $srcCurr;
            self::$_srcCurrRate = $srcCurrRate;
        } else {
            $srcCurrRate = (($forDate) ? self::getCurrencyRate($srcCurr, $forDate) : self::$_srcCurrRate);
        }
        if ((self::$_destCurr != $destCurr) && !$forDate) {
            $destCurrRate = self::getCurrencyRate($destCurr, $forDate);
            self::$_destCurr = $destCurr;
            self::$_destCurrRate = $destCurrRate;
        } else {
            $destCurrRate = (($forDate) ? self::getCurrencyRate($destCurr, $forDate) : self::$_destCurrRate);
        }
        if ($destCurrRate != 0) {
            if (extension_loaded('bcmath')) {
                bcscale(30);
                $res = self::cRound(
                  bcmul(bcdiv($srcCurrRate, $destCurrRate), self::cRound($srcVal, $srcCurr)),
                  $destCurr,
                  $digitsNum
                );
            } else {
                $res = self::cRound(
                  ($srcCurrRate / $destCurrRate) * self::cRound($srcVal, $srcCurr),
                  $destCurr,
                  $digitsNum
                );
            }
        } else {
            if (extension_loaded('bcmath')) {
                bcscale(30);
                $res = self::cRound(bcmul($srcCurrRate, self::cRound($srcVal, $srcCurr)), $destCurr, $digitsNum);
            } else {
                $res = self::cRound(($srcCurrRate / 1) * self::cRound($srcVal, $srcCurr), $destCurr, $digitsNum);
            }
        }
        return (float) $res;
    }

    public static function getCurrencyRate($currency, $forDate = false)
    {
        if (!$forDate || (DSConfig::getVal('rates_use_currency_log') != 1)) {
            $result = (float) DSConfig::getVal('rate_' . $currency);
        } else {
            $iCurrency = $currency;
            if (is_numeric($forDate)) {
                $iForDate = (int) $forDate;
            } else {
                $iForDate = strtotime($forDate);
                if (!is_numeric($iForDate)) {
                    $iForDate = time();
                }
            }
            $res = Yii::app()->db->createCommand(
              "SELECT rate FROM currency_log ll
                                                WHERE ll.currency=:currency AND ll.date<=extract(epoch FROM (:forDate))
                                                ORDER BY ll.date DESC LIMIT 1"
            )->queryScalar(
              [
                ':currency' => $iCurrency,
                ':forDate'  => $iForDate,
              ]
            );
            if (!$res) {
                $res = Yii::app()->db->createCommand(
                  "SELECT rate FROM currency_log ll
                                                WHERE ll.currency=:currency ORDER BY ll.date DESC LIMIT 1"
                )->queryScalar(
                  [
                    ':currency' => $iCurrency,
                  ]
                );
            }
            if (!$res) {
                $result = (float) DSConfig::getVal('rate_' . $currency);
            } else {
                $result = (float) $res;
            }

        }
        return $result;
    }

    public static function getOriginalSourcePrice(array $params)
    {
        $intParams = [
          'price' => new CException('getOriginalSourcePrice: no price defined!'),
        ];
// Old parameters
        foreach ($intParams as $key => $default) {
            $intParams[$key] = isset($params[$key]) ? $params[$key] : $default;
            if (is_a($intParams[$key], 'CException')) {
                throw $intParams[$key];
            }
        }
// === Variables =============
        $vars = [];
        $vars['currency'] = DSConfig::getCurrency();
        $vars['mainK'] = (float) DSConfig::getValDef('price_main_k', 1);
        $vars['mainKMinSum'] = (float) DSConfig::getValDef('price_main_k_min_sum', 0);
        $vars['postFee'] = 0;
        $vars['priceWithPostageAndCount'] = Formulas::convertCurrency(
          $intParams['price'] - $vars['postFee'],
          $vars['currency'],
          'cny'
        );
        $vars['discountCountK'] = self::getPriceK($vars['priceWithPostageAndCount']);
        if (($vars['mainK'] * $vars['discountCountK']) != 0) {
            $vars['userPriceInCNY'] = Formulas::cRound(
              ($vars['priceWithPostageAndCount']) / ($vars['mainK'] * $vars['discountCountK']),
              'cny',
              0
            );
        } else {
            $vars['userPriceInCNY'] = Formulas::cRound($vars['priceWithPostageAndCount'], 'cny', 0);
        }
        if ($vars['userPriceInCNY'] < 0) {
            return 0;
        } else {
            return $vars['userPriceInCNY'];
        }
    }

    public static function getUserPrice(array $params)
    {
        /*
          array(
            'price'=>'',
            'count'=>'',
            'deliveryFee'=>'',
            'postageId'=>'',
            'sellerNick'=>'',
            'asHtml' => FALSE,
            'currency' => FALSE,
            'user' => FALSE,
          )
          */
        //$price, $count, $deliveryFee, $postageId, $sellerNick, $asHtml = FALSE, $currency = FALSE, $user = FALSE
        //ini_set('precision', 20);
        $intParams = [
          'dsSource'     => new CException('getUserPrice: no dsSource defined!'),//'taobao',
          'price'        => new CException('getUserPrice: no price defined!'),
          'count'        => new CException('getUserPrice: no count defined!'),
          'deliveryFee'  => new CException('getUserPrice: no deliveryFee defined!'),
          'postageId'    => new CException('getUserPrice: no postageId defined!'),
          'sellerNick'   => new CException('getUserPrice: no sellerNick defined!'),
          'weight'       => 0,
          'isTmall'      => false,
          'internal'     => false,
          'currency'     => DSConfig::getCurrency(),
          'currencyDate' => false,
          'user'         => Yii::app()->user->id,
        ];
        //$price, $count, $deliveryFee, $postageId, $sellerNick, $asHtml = FALSE, $currency = FALSE, $user = FALSE
        foreach ($intParams as $key => $default) {
            if (in_array($key, ['deliveryFee']) && is_null($params[$key])) {
                $intParams[$key] = 0;
            } else {
                if (isset($params[$key])) {
                    if (is_numeric($params[$key])) {
                        $intParams[$key] = floatval($params[$key]);
                    } else {
                        $intParams[$key] = $params[$key];
                    }
                } else {
                    if (is_numeric($default)) {
                        $intParams[$key] = floatval($default);
                    } else {
                        $intParams[$key] = $default;
                    }
                }
            }
            if (is_a($intParams[$key], 'CException')) {
                throw $intParams[$key];
            }
        }
// === Variables =============
        $vars = [];
//-----------------------------------------------------------
        if (!isset($intParams['dsSource']) || !$intParams['dsSource']) {
            new CException('getUserPrice: no dsSource defined!');
        }
        $vars['dsSource'] = $intParams['dsSource'];
        $vars['srcCurrency'] = 'rur';//DSConfig::getDsSourceParam($intParams['dsSource'], 'srcCurrency');
        if (!$vars['srcCurrency']) {
            new CException('getUserPrice: no src currency defined!');
        }
        $vars['weight'] = $intParams['weight'];
        $vars['isTmall'] = $intParams['isTmall'];
        $vars['internal'] = $intParams['internal'];
        $vars['UserK'] = (float) self::getUserK($intParams['user']);
        $vars['mainK'] = (float) DSConfig::getValDef('price_main_k', 1);
        //Минимальная сумма наценки на весь лот, в основной валюте сайта
        $vars['mainKMinSum'] = self::convertCurrency(
          DSConfig::getValDef('price_main_k_min_sum', 0),
          DSConfig::getVal('site_currency'),
          'cny'
        );
//-- Postage calulations --
        $vars['postage'] = new stdClass();
        $vars['postage']->start_fee = $intParams['deliveryFee'];
        // Old calc: $vars['postage']->add_fee = (($intParams['deliveryFee'] > 50) ? $intParams['deliveryFee'] : 0);
        $vars['postage']->add_fee = $intParams['deliveryFee'];
        $vars['postage']->add_standard = 1;
        if (!$vars['postage']->start_fee) {
            $vars['postage']->start_fee = 0;
            $vars['postage']->add_fee = 0;
            $vars['postage']->add_standard = 1;
        }
//==========================================
        if (eval(self::getFormula('getUserPrice[postFee]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[postFee]');
        }
        if (eval(self::getFormula('getUserPrice[priceWithPostageAndCount]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[priceWithPostageAndCount]');
        }
        $vars['discountPriceK'] = (float) self::getPriceK($vars['priceWithPostageAndCount']);
        $vars['discountCountK'] = (float) self::getCountK($intParams['count']);

        if (eval(self::getFormula('getUserPrice[discountCountSumm]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[discountCountSumm]');
        }
        if (eval(self::getFormula('getUserPrice[discountNoCountSumm]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[discountNoCountSumm]');
        }
        if (eval(self::getFormula('getUserPrice[userPriceInCNY]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[userPriceInCNY]');
        }
        if (eval(self::getFormula('getUserPrice[userOldPriceInCNY]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[userOldPriceInCNY]');
        }
        if (eval(self::getFormula('getUserPrice[discount]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[discount]');
        }
        if (eval(self::getFormula('getUserPrice[userDeliveryInCNY]')) === false) {
            throw new CException('Ошибки в формуле getUserPrice[userDeliveryInCNY]');
        }
        $vars['discountInCurr'] = self::convertCurrency(
          $vars['discount'],
          $vars['srcCurrency'],//'cny',
          $intParams['currency'],
          false,
          $intParams['currencyDate']
        );
        $vars['userPriceInCurr'] = self::convertCurrency(
          $vars['userPriceInCNY'],
          $vars['srcCurrency'],//'cny',
          $intParams['currency'],
          false,
          $intParams['currencyDate']
        );
        $vars['userDeliveryInCurr'] = self::convertCurrency(
          $vars['userDeliveryInCNY'],
          $vars['srcCurrency'],//'cny',
          $intParams['currency'],
          false,
          $intParams['currencyDate']
        );
        $result = new FormulasGetUserPriceResult();
        $result->price = self::cRound($vars['userPriceInCurr'], $intParams['currency']);
        $result->discount = (float) $vars['discountInCurr'];
        $result->delivery = (float) $vars['userDeliveryInCurr'];
//------ Full delivery calculation --------------------------
        if (DSConfig::getValDef('checkout_weight_needed', 0) == 1) {
            $vars['totalWeight'] = round($intParams['count'] * $intParams['weight']);
            $vars['UserCountry'] = self::getUserCountry($intParams['user']);
            $deliveries = Deliveries::getDelivery($vars['totalWeight'], $vars['UserCountry'], false, 0, false);
            if ($deliveries && is_array($deliveries) && count($deliveries)) {
                reset($deliveries);
                $delivery = current($deliveries);
                $vars['totalDelivery'] = self::convertCurrency(
                  $delivery->summ,
                  $delivery->currency,//DSConfig::getVal('site_currency'),//$delivery->currency,
                  $intParams['currency'],
                  false
                );
            } else {
                $vars['totalDelivery'] = 0;
            }
        } else {
            $vars['totalWeight'] = 0;
            $vars['totalDelivery'] = 0;
        }
        $result->totalWeight = $vars['totalWeight'];
        $result->totalDelivery = $vars['totalDelivery'];
//-----------------------------------------------------------
        $result->params = $intParams;
        $result->vars = $vars;
        return $result;
    }

    public static function getUserPriceForArray($searchRes)
    {
        $_source_EnabelDiscounts = DSConfig::getValDef('source_EnabelDiscounts', 0);
        $_delivery_source_fee_in_price = DSConfig::getValDef('delivery_source_fee_in_price', 0);
        $_delivery_source_fee_in_search = DSConfig::getValDef('delivery_source_fee_in_search', 0);
        if (isset($searchRes->items)) {
            $_items = &$searchRes->items;
        } elseif (is_array($searchRes)) {
            $_items = &$searchRes;
        } else {
            if (YII_DEBUG) {
                throw new Exception('Formulas::getUserPriceForArray: invalid parameter!');
            } else {
                return;
            }
        }
        foreach ($_items as $k => $item) {
//===============================================
            if ($_source_EnabelDiscounts == 0) {
                foreach ($_items as $m => $ResItem) {
                    $_items[$m]->promotion_price = $_items[$m]->price;
                }
            }
            if ($item->price != 0) {
                $item->promotion_percent = ceil((100 - ($item->promotion_price / $item->price) * 100) / 5) * 5;
            } else {
                $item->promotion_percent = 0;
            }
//===============================================
            $item->price = (float) $item->price;
            $item->promotion_price = (float) $item->promotion_price;
            $item->post_fee = (float) $item->post_fee;
            $item->ems_fee = (float) $item->ems_fee;
            $item->express_fee = (float) $item->express_fee;

            if ($_delivery_source_fee_in_price == 1 && $_delivery_source_fee_in_search == 1) {
                $expressFeeInPrice = $item->express_fee;
            } else {
                $expressFeeInPrice = -1;
            }

            $resUserPrice = self::getUserPrice(
              [
                'dsSource'    => $item->ds_source,
                'price'       => $item->price,
                'count'       => 1,
                'deliveryFee' => $expressFeeInPrice,
                'postageId'   => false,
                'sellerNick'  => false,
                'weight'      => (isset($item->weight) ? $item->weight : 0),
                'isTmall'     => (isset($item->tmall) ? $item->tmall : false),
              ]
            );
            $item->userPrice = $resUserPrice->price;
            $resUserPrice = self::getUserPrice(
              [
                'dsSource'    => $item->ds_source,
                'price'       => $item->promotion_price,
                'count'       => 1,
                'deliveryFee' => $expressFeeInPrice,
                'postageId'   => false,
                'sellerNick'  => false,
                'weight'      => (isset($item->weight) ? $item->weight : 0),
                'isTmall'     => (isset($item->tmall) ? $item->tmall : false),
              ]
            );
            $item->userPromotionPrice = $resUserPrice->price;
            $item->totalWeight = $resUserPrice->totalWeight;
            $item->totalDelivery = $resUserPrice->totalDelivery;
            $_items[$k] = $item;
        }
        return;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Formulas|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function priceWrapper($price, $currency = false, $digitsNum = false)
    {
        if (!$currency) {
            $currency = DSConfig::getCurrency();
        }
        if (!strrpos($price, '-')) {
            $html = '<span>' . self::cRound($price, $currency, $digitsNum) . '</span>';
        } else {
            $html = '<span>' . $price . '</span>';
        }
        $symb = DSConfig::getCurrency(true, true, $currency); //DSConfig::getVal('site_currency')
        $symb = str_replace('%d', $html, $symb);
        return $symb;
    }

    public static function weightWrapper($weight)
    {
        if ($weight <= 1000) {
            $result = $weight . ' ' . Yii::t('main', 'гр');
        } else {
            $kg = intval($weight / 1000);
            $g = $weight % 1000;
            $result = $kg . '' . Yii::t('main', 'кг ') . ' ' . $g . '' . Yii::t('main', 'гр');
        }
        return $result;
    }
}
