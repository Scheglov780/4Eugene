<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UtilitesController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class UtilitesController extends CustomAdminController
{

    public function actionClearDatabase($table = 'all')
    {
        if ($table == 'all') {
            $uid = Yii::app()->user->id;
            $uids =
              Yii::app()->db->createCommand("select uid from users where uid={$uid} or email='scheglov@danvit.ru'")
                ->queryColumn();
            Yii::app()->db->createCommand(
              "
      -- SET FOREIGN_KEY_CHECKS=0;
      DELETE FROM users where users.uid not in (" . implode(',', $uids) . ");
      -- DELETE FROM users where users.role not in ('superAdmin');
      delete from addresses where uid not in (select uid from users); 
      truncate table module_news; 
      truncate table module_tabs_history; 
      truncate table blog_categories; 
      truncate table blog_comments; 
      truncate table blog_posts; 
      truncate table \"cache\"; 
      delete from cart where cart.uid not in (select users.uid from users); 
      truncate table cms_content_history;
      truncate table debug_log;
      truncate table events_log; 
      delete from favorites where favorites.uid not in (select users.uid from users); 
      truncate table featured; 
      truncate table img_hashes;
      truncate table log_api_requests;
      truncate table log_dsg;
      truncate table log_dsg_details;
      truncate table log_dsg_translator;
      truncate table log_http_requests;
      truncate table log_item_requests; 
      truncate table log_items_requests;
      truncate table log_queries_requests;
      truncate table log_site_errors; 
      truncate table log_translations;
      truncate table log_translator_keys;
      truncate table mail_queue;
      truncate table messages;
      delete from orders where orders.uid not in (select uid from users); 
      delete from orders_comments where oid not in (select id from orders); 
      delete from orders_comments_attaches where orders_comments_attaches.comment_id not in (select id from orders_comments); 
      delete from orders_items where oid not in (select id from orders);
      delete from orders_items_comments where orders_items_comments.item_id not in (select orders_items.id from orders_items);
      delete from orders_items_comments_attaches where orders_items_comments_attaches.comment_id not in (select id from orders_items_comments); 
      delete from orders_payments where oid not in (select id from orders); 
      truncate table pay_systems_log;
      delete from payments where uid not in (select uid from users);
      truncate table questions; 
      truncate table user_notice;
      truncate table warehouse;
      truncate table warehouse_place;
      truncate table warehouse_place_item;      
       -- SET FOREIGN_KEY_CHECKS=1;
      "
            )->execute();
            Yii::app()->fileCache->flush();
            Yii::app()->cache->flush();
        } else {
            Yii::app()->db->createCommand('truncate table ' . $table)->execute();
        }
    }

    public function actionCommand($cmd)
    {
        switch ($cmd) {
            /*            case 'convertOrders':
                            $this->cmd_convertOrders();
                            break;
                        case 'convertOrdersItems':
                            $this->cmd_convertOrdersItems();
                            break;
                        case 'convertCart':
                            $this->cmd_convertCart();
                            break;
                        case 'convertDeliveries':
                            $this->cmd_convertDeliveries();
                            break;
                        case 'convertArticles':
                            $this->cmd_convertArticles();
                            break;
                        case 'loadDic':
                            $this->cmd_loadDic();
                            break;
            */
            default:
                echo 'No command specified';
                break;
        }

    }

    public function actionIndex()
    {
        $this->renderPartial('index', [], false, true);
    }

    public function actionSetParams()
    {
        if (isset($_POST['InstallForm'])) {
            $params = $_POST['InstallForm'];
            foreach ($params as $param => $val) {
                $config = DSConfig::model()->findByPk($param);
                if ($config) {
                    $config->value = $val;
                    $config->save();
                }
            }
        }
    }
    /*
        private function cmd_convertOrders()
        {

            if (!Order::model()->hasAttribute('data')) {
                echo 'Orders are allready updated!';
                return;
            }
            $command = Yii::app()->db->createCommand(
              "INSERT INTO orders_comments (oid,uid,date,message,internal)
         SELECT oo.id, oo.uid, FROM_UNIXTIME(oo.`date`), oo.comment, 0  FROM orders oo
         WHERE oo.comment IS NOT NULL AND oo.comment<>''"
            );
            $command->execute();
            $command = Yii::app()->db->createCommand(
              "UPDATE orders oo
        SET oo.payed=oo.delivery+oo.sum
        WHERE oo.debt>=0"
            );
            //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "UPDATE orders oo
    SET oo.payed=oo.delivery+oo.sum+oo.debt
    WHERE oo.debt<0"
            );
            //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "INSERT INTO orders_payments(`oid`,`uid`,`summ`,`date`)
    SELECT oo.id, oo.uid, oo.payed, FROM_UNIXTIME(oo.`date`) AS `date` FROM orders oo
    WHERE oo.payed!=0"
            );
            //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "DELETE FROM payments
            WHERE payments.sum<=0"
            );
            //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "UPDATE orders
    SET status='IN_PROCESS'
    WHERE status IN (1,2,3,4,5,6,10,12,101,102)"
            );
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "UPDATE orders
    SET status='CANCELED_BY_CUSTOMER'
    WHERE status IN (13)"
            );
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "UPDATE orders
    SET status='SEND_TO_CUSTOMER'
    WHERE status IN (7)"
            );
            $command->execute();

            $command = Yii::app()->db->createCommand(
              "UPDATE orders
    SET status='PAUSED'
    WHERE status IN (1,2,3,4,5,6,7,8,9,10,11,12,13,101,102)"
            );
            $command->execute();

            $orders = Order::model()->findAll();
            try {
                foreach ($orders as $order) {
                    $data = json_decode($order->data);
                    $order->delivery_id = $data->delivery;
                    $address = Addresses::model()->findBySql(
                      'SELECT * FROM addresses WHERE `phone`=:phone AND city=:city AND `address`=:address AND
      `firstname`=:firstname AND
      `lastname` =:lastname',
                      array(
                        ':phone'     => $data->phone,
                        ':city'      => $data->city,
                        ':address'   => $data->address,
                        ':firstname' => $data->firstname,
                        ':lastname'  => $data->lastname
                      )
                    );
                    if ($address != null && $address != false) {
                        $order->addresses_id = $address->id;
                    } else {
                        $address = Addresses::model()
                          ->findBySql('SELECT * FROM addresses WHERE uid=:uid', array(':uid' => $order->uid));
                        if ($address != null && $address != false) {
                            $order->addresses_id = $address->id;
                        } else {
                            $order->addresses_id = 1;
                        }
                    }
                    $order->save(false);
                }
            } catch (Exception $e) {
                echo 'Errors in order ' . $order->id . '<br/>';
                CVarDumper::dump($e, 1, true);
                return;
            }
            $command = Yii::app()->db->createCommand("DELETE FROM addresses WHERE uid NOT IN (SELECT uid FROM users)");
            //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $command->execute();
            $command = Yii::app()->db->createCommand(
              "DELETE FROM orders WHERE addresses_id NOT IN (SELECT id FROM addresses)"
            );
            //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $command->execute();
            echo 'Complete!';
        }
    */
    /*
        private function cmd_convertOrdersItems()
        {
            if (!OrdersItems::model()->hasAttribute('data')) {
                echo 'Orders items are allready updated!';
                return;
            }

            $ordersItems = OrdersItems::model()->findAll('iid=0');
            try {
                foreach ($ordersItems as $orderItem) {
                    $data = json_decode($orderItem->data);
                    if (isset($data->input_props) && (is_array($data->input_props))) {
                        //       echo $orderItem->id.'<br/>';
                        $inp_props = array();
                        foreach ($data->input_props as $input_prop) {
                            try {
                                if (isset($input_prop->name_zh) && isset($input_prop->value_zh)) {
                                    $inp_props[] = new stdClass();
                                    end($inp_props)->name = $input_prop->name_zh;
                                    end($inp_props)->value = $input_prop->value_zh;
                                }
    //              if (count($inp_props) > 0) {
                                $inp_props_js = json_encode($inp_props);
                                $orderItem->input_props = $inp_props_js;
    //              }

                            } catch (Exception $e) {
                                echo $e->getMessage() . '<br/>';
                                continue;
                            }
                        }
                    } else {
                        $inp_props_js = json_encode(array());
                        $orderItem->input_props = $inp_props_js;
                    }
                    /*        if (isset($data->SumDiscount)) {
                              $orderItem->sum_discount = $data->SumDiscount;
                            }
                            elseif (isset($data->float_sum)) {
                              $orderItem->sum_discount = $data->float_sum;
                            }
                    */
    /*
                    if (isset($data->TaobaoPromotion_price)) {
                        $orderItem->source_promotion_price = $data->TaobaoPromotion_price;
                    }

                    if (isset($data->TaobaoPrice)) {
                        $orderItem->source_price = $data->TaobaoPrice;
                    }

                    //  if (isset($data->TaobaoPrice) && isset($data->price)) {
    //          $orderItem->_price = $data->price;
    //        }

                    /*        if (isset($data->priceNoDiscount)) {
                              $orderItem->price_no_discount = $data->priceNoDiscount;
                            }
                    */

    /*        if (isset($data->priceUserFinal)) {
              $orderItem->price_user_final = $data->priceUserFinal;
            }
    */
    /*                if (isset($data->num)) {
                        $orderItem->num = $data->num;
                    }

                    if (isset($data->iid)) {
                        $orderItem->iid = $data->iid;
                    }

                    if (isset($data->props)) {
                        $orderItem->props = $data->props;
                    }

                    /*        if (isset($data->desc)) {
                              $orderItem->desc = $data->desc;
                            }
                    */
    /*                if (isset($data->title)) {
                        $orderItem->title = Utils::getOriginalFromTranslation($orderItem->title);
                    }

                    if (isset($data->seller_nick)) {
                        $orderItem->seller_nick = $data->seller_nick;
                    } else {
                        $orderItem->seller_nick = '';
                    }

                    if (isset($data->pic_url)) {
                        $orderItem->pic_url = $data->pic_url;
                    }

                    if (isset($data->weight)) {
                        $orderItem->weight = $data->weight;
                    }
                    try {
    //        $orderItem->validate();
                        $orderItem->save(false);
                        if (count($orderItem->errors) > 0) {
                            echo $orderItem->id . ' ';
                        }
                    } catch (Exception $e) {
                        echo 'Errors in orderItem <br/>';// . $orderItem->id;
                        CVarDumper::dump($e, 1, true);
                        return;
                    }
                }
                echo 'Loop complete on ID:' . $orderItem->id . ' ';
            } catch (Exception $e) {
                echo 'Errors in orderItem ' . $orderItem->id . ' <br/>';
                CVarDumper::dump($e, 1, true);
                return;
            }
            try {
                $command = Yii::app()->db->createCommand(
                  "DELETE FROM orders_items WHERE oid NOT IN (SELECT id FROM orders) AND iid!=0"
                );
                //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
                $command->execute();
                $command = Yii::app()->db->createCommand(
                  "INSERT INTO `orders_items_comments` (
      `item_id`,
      `uid`,
      `date`,
      `message`,
      `internal`
      )
    SELECT oi.id,
    (SELECT oo.uid FROM orders oo WHERE oo.id=oi.oid) AS uid,
    (SELECT FROM_UNIXTIME(oo.`date`) FROM orders oo WHERE oo.id=oi.oid) AS `date`,
    oi.`comment`,0
    FROM orders_items oi
    WHERE oi.`comment` IS NOT NULL AND oi.`comment`<>''"
                );
                //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
                $command->execute();

                /*    $command = Yii::app()->db->createCommand("update orders_items oi
                                                              set oi.status=oi.status+1;
                                                              update orders_items oi
                                                              set oi.status=1 where
                                                              oi.status=2 and (oi.code is null or oi.code!=1)");
                    //  ->bindParam(':text', $textEn, PDO::PARAM_STR);
                    $command->execute();
                */
    /*    $command = Yii::app()->db->createCommand("update orders_items oi
                  set oi.source_price = oi.sum_no_discount
                  where oi.source_price =0");
        $command->execute();
        $command = Yii::app()->db->createCommand("update orders_items oi
                  set oi.source_promotion_price = oi.sum
                  where oi.source_promotion_price =0");
        $command->execute();
    */
    /*            echo 'Complete!';
            } catch (Exception $e) {
                echo 'Errors in orders_items post-processing<br/>';
                CVarDumper::dump($e, 1, true);
                return;
            }
        }
    */
    /*
        private function cmd_convertCart()
        {
            if (!Cart::model()->hasAttribute('value')) {
                echo 'Carts are allready updated!';
                return;
            }
            $carts = Cart::model()->findAll('value is not null');
            try {
                foreach ($carts as $cart) {
                    $data = unserialize($cart->value);
                    if (is_array($data)) {
                        foreach ($data as $cartItem) {
                            if (isset($cartItem['input_props']) && (is_array($cartItem['input_props']))) {
                                natsort($cartItem['input_props']);
                                $input_props = implode(';', $cartItem['input_props']);
                            } else {
                                $input_props = '';
                            }
    //-----------
                            $uid = $cart->uid;
                            $command = Yii::app()->db->createCommand(
                              "INSERT IGNORE INTO cart (uid, iid, num, input_props, `desc`, `date`)
                 VALUES (:uid, :iid, :num, :input_props, :desc, Now())"
                            )
                              ->bindParam(':uid', $uid, PDO::PARAM_INT)
                              ->bindParam(':iid', $cartItem['iid'], PDO::PARAM_INT)
                              ->bindParam(':num', $cartItem['num'], PDO::PARAM_INT)
                              ->bindParam(':desc', $cartItem['desc'], PDO::PARAM_STR)
                              ->bindParam(':input_props', $input_props, PDO::PARAM_STR);
                            $command->execute();

    //-----------
                        }
                    }
                }

                $command = Yii::app()->db->createCommand("DELETE FROM cart WHERE uid NOT IN (SELECT u.uid FROM users u)");
                $command->execute();

                $command = Yii::app()->db->createCommand("DELETE FROM cart WHERE value IS NOT NULL");
                $command->execute();

            } catch (Exception $e) {
                echo 'Errors in cart ' . $cart->id . '<br/>';
                CVarDumper::dump($e, 1, true);
                return;
            }
            echo 'Complete!';
        }
    */
    /*
        private function cmd_convertDeliveries()
        {
            $oldDeliveries = DSConfig::model()->findAll("id like 'delivery_%' and value like '%<delivery>%'");
            if (!$oldDeliveries) {
                echo 'Deliveries are allready updated!';
                return;
            }
            try {
                Deliveries::model()->deleteAll();
                foreach ($oldDeliveries as $oldDelivery) {
                    $xml = simplexml_load_string($oldDelivery['value']);
                    if (Deliveries::model()->find('delivery_id = :delivery_id', array(':delivery_id' => $xml->id))) {
                        $oldDelivery->delete();
                        continue;
                    }
                    $newDelivery = new Deliveries();
                    $newDelivery->delivery_id = (string) $xml->id;
                    $newDelivery->enabled = (string) $xml->enabled;
                    $newDelivery->name = (string) $xml->name;
                    $newDelivery->description = (string) $xml->description;
                    $newDelivery->currency = (string) $xml->currency;
                    $newDelivery->min_weight = (string) $xml->min_weight;
                    $newDelivery->max_weight = (string) $xml->max_weight;
                    $newDelivery->fees = preg_replace('/(?<=<delivery>).*(?=<fees>)/is', "\r\n", $oldDelivery['value']);
                    if ($newDelivery->save()) {
                        $oldDelivery->delete();
                    }
                }
            } catch (Exception $e) {
                echo 'Error in delivery: <br/>' . CVarDumper::dumpAsString($e, 6, true);
                return;
            }
            echo 'Complete!';
        }
    */
}