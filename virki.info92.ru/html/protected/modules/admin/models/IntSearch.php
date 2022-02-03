<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="IntSearch.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class IntSearch
{
    public $query;
    private static $searchRules = [
      'users' => [
        'query' => "SELECT concat('Users',uu.uid) AS id, uu.uid AS pk, 'Users' AS type, :query AS query
FROM users uu
WHERE uu.uid::varchar LIKE :query
OR lower(uu.email) = lower(:query)
OR lower(uu.fullname) = lower(:query)
OR lower(uu.role) = lower(:query)
OR lower(uu.phone) = lower(:query)
UNION
SELECT concat('Users',uu.uid) AS id, uu.uid AS pk, 'Users' AS type, :query AS query
FROM users uu
WHERE 
(uu.uid::varchar LIKE concat('%',:query,'%')
OR uu.email ILIKE concat('%',:query,'%')
OR uu.fullname ILIKE concat('%',:query,'%')
OR uu.role ILIKE concat('%',:query,'%')
OR uu.phone LIKE concat('%',:query,'%')
) AND :strong=0",
      ],
        /*
              'orders'      => array(
                'query' => "SELECT concat('Order',oo.id) AS id, oo.id AS pk, 'Order' AS type, :query AS query
        FROM orders oo
        WHERE (oo.id = :query
        OR concat(oo.uid,'-',oo.id) = :query
        OR oo.status = :query
        OR oo.code = :query
        OR oo.delivery_id = :query) AND :strong = 0
        UNION
        SELECT concat('Order',oo.id) AS id, oo.id AS pk, 'Order' AS type, :query AS query
        FROM orders oo
        WHERE
        (oo.id LIKE concat('%',:query,'%')
        OR concat(oo.uid,'-',oo.id) LIKE concat('%',:query,'%')
        OR oo.status LIKE concat('%',:query,'%')
        OR oo.code LIKE concat('%',:query,'%')
        OR oo.delivery_id LIKE concat('%',:query,'%')
        ) AND :strong=0"
              ),
              'ordersItems' => array(
                'query' => "SELECT concat('OrdersItems',oi.id) AS id, oi.id AS pk, 'OrdersItems' AS type, :query AS query
        FROM orders_items oi, orders_items_statuses ois
        WHERE oi.status=ois.id
        AND(
        ((oi.id = :query
        OR concat(oi.oid,'-',oi.id) = :query
        OR ois.name = :query) AND :strong=0)
        OR oi.tid = :query
        OR oi.track_code = :query
        OR oi.tid ~* concat('^[[:space:]]*',:query,'[[:space:]]*$')
        OR oi.track_code ~* concat('^[[:space:]]*',:query,'[[:space:]]*$')
        )
        UNION
        SELECT concat('OrdersItems',oi.id) AS id, oi.id AS pk, 'OrdersItems' AS type, :query AS query
        FROM orders_items oi, orders_items_statuses ois
        WHERE
        (oi.status=ois.id
        AND(
        oi.id LIKE concat('%',:query,'%')
        OR concat(oi.oid,'-',oi.id) LIKE concat('%',:query,'%')
        OR ois.name LIKE concat('%',:query,'%')
        ) AND :strong=0
        -- or oi.tid like concat('%',:query,'%')
        -- or oi.track_code like concat('%',:query,'%')
        )"
              ),
        */

    ];

    public function Search()
    {
        if (($this->query == '') || is_null($this->query)) {
            return false;
        } else {
            $strong = 0;
            if (!preg_match('/^[\d\s]+$/is', $this->query)) {
                $intQuery = str_replace(' ', '%', $this->query);
            } else {
                $intQuery = $this->query;
                if (strlen($intQuery) >= 10) {
                    $strong = 1;
                }
            }
            $res = [];
            foreach (self::$searchRules as $searchRule) {
                $sql = $searchRule['query'];
                $sqlRes = Yii::app()->db->createCommand($sql)
                  ->queryAll(
                    true,
                    [
                      ':query'  => $intQuery,
                      ':strong' => $strong,
                    ]
                  );
                if ($sqlRes) {
                    $res = array_merge($res, $sqlRes);
                }
            }
            //CVarDumper::dump($res,10,true);
            //die;
            $result = new CArrayDataProvider(
              $res, [
                'id'         => 'adminSearchResults',
                'keyField'   => 'id',
                  /*      'sort'=>array(
                          'attributes'=>array(
                            'id', 'username', 'email',
                          ),
                        ),
                  */
                'pagination' => [
                  'pageSize' => 25,
                ],
              ]
            );
            return $result;
        }
    }
}

