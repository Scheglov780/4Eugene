<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SiteLog.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customSiteLog
{
    public static function doAPIKeyLog($type, $key)
    {
        $command = Yii::app()->db->createCommand(
          "INSERT INTO log_api_requests (\"type\",\"key\",\"date\")
        VALUES (:type,:key,now())"
        );
        $command->execute(
          [
            ':type' => $type,
            ':key'  => $key,
          ]
        );
    }

    public static function doHttpLog()
    {
        $url = urldecode(Yii::app()->request->url);
        $contentType = Yii::app()->request->acceptTypes;
        if (isset($_SERVER['REQUEST_TIME'])) {
            $duration = time() - $_SERVER['REQUEST_TIME'];
        } else {
            $duration = 0;
        }

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            return;
        }

        if (isset($_SERVER['HTTP_X_PRELOADING_TIME']) && ($_SERVER['HTTP_X_PRELOADING_TIME'] == 0)) {
            header('X-Preloading-Time: ' . $duration);
            return;
        }
        if (isset($_SERVER['HTTP_X_PRELOADING_TIME']) && ($_SERVER['HTTP_X_PRELOADING_TIME'] > 0)) {
            $duration = $duration + $_SERVER['HTTP_X_PRELOADING_TIME'];
            return;//???
        }

        if ((Yii::app()->request->isAjaxRequest || Yii::app()->request->isPostRequest) && !preg_match(
            '/^(?:\/.{2})*\/item\/\d+$/is',
            $url
          )) {
            return;
        }

        if (isset(Yii::app()->request->cookies['ItemAjaxPreloadedTime'])) {
            $duration = $duration + round((int) Yii::app()->request->cookies['ItemAjaxPreloadedTime']->value / 1000);
            Yii::app()->request->cookies->remove('ItemAjaxPreloadedTime');
        }
        if (isset(Yii::app()->request->cookies['ItemAjaxPreloadedReferer'])) {
            $referer = urldecode((string) Yii::app()->request->cookies['ItemAjaxPreloadedReferer']->value);
            Yii::app()->request->cookies->remove('ItemAjaxPreloadedReferer');
        }

        if (preg_match('/^(?:\/.{2})*\/item\/[^\d]+/is', $url)) {
            return;
        }

        if (!preg_match(
          '/^(?:\/.{2})*\/(?:site|user|tools|search|seller|item|favorite|checkout|category|cart|cabinet|brand|article|blog)(?:\/|$)/is',
          $url
        )) {
            return;
        }
        if (!isset($referer)) {
            $referer = urldecode(Yii::app()->request->urlReferrer);
        }
        if ($url == preg_replace('/http[s]*:\/\/.+?\//is', '/', $referer)) {
            $referer = '';
        }
        $uid = Yii::app()->user->id;
        if ($uid == null) {
            $uid = -1;
        }
        if (isset(Yii::app()->request->cookies['PHPSESSID'])) {
            $session = Yii::app()->request->cookies['PHPSESSID'];
        } else {
            $session = '';
        }
        $ip = Yii::app()->request->userHostAddress;
        $useragent = Yii::app()->request->userAgent;
        if ($duration > 127) {
            $duration = 127;
        }
        $command = Yii::app()->db->createCommand(
          "INSERT INTO log_http_requests (session,url,ip,useragent,uid,\"date\",referer,duration)
        VALUES (:session,:url,:ip,:useragent,:uid,now(),:referer,:duration)"
        );
        $command->execute(
          [
            ':session'   => $session,
            ':url'       => $url,
            ':ip'        => $ip,
            ':useragent' => $useragent,
            ':referer'   => $referer,
            ':duration'  => $duration,
            ':uid'       => $uid,
          ]
        );
    }

    /**
     * @param $item customItem
     */
    public static function doItemLog($item)
    {
        $lastDelete = Yii::app()->cache->get('itemLogLastDelete');
        $nowDate = microtime(true);
        if (!$lastDelete || (abs($nowDate - $lastDelete) > 600)) {
            /*            try {
                            Yii::app()->db->createCommand(
                              "delete from favorites
                                 where favorites.`date` < (CURDATE() - INTERVAL 120 DAY)"
                            )->execute();
                        } catch (CDbException $e) {
                            return;
                        }
            */
            try {
                Yii::app()->db->createCommand(
                /** @lang SQL */ "-- set sql_log_bin = 0;
          delete from log_item_requests
                 WHERE log_item_requests.\"date\" < (CURRENT_DATE - INTERVAL '30 day'); -- LIMIT 1000;
          -- set sql_log_bin = 1;"
                )->execute();
            } catch (CDbException $e) {
                // Yii::app()->db->createCommand('REPAIR TABLE log_http_requests')->execute();
                return;
            }
            try {
                Yii::app()->db->createCommand(
                /** @lang SQL */ "-- set sql_log_bin = 0;
      delete from log_http_requests
                 WHERE log_http_requests.\"date\" < (CURRENT_DATE - INTERVAL '30 day'); -- LIMIT 10000;
      -- set sql_log_bin = 1;"
                )->execute();
            } catch (CDbException $e) {
                // Yii::app()->db->createCommand('REPAIR TABLE log_http_requests')->execute();
                return;
            }
            try {
                Yii::app()->db->createCommand(
                /** @lang SQL */ "-- set sql_log_bin = 0;
           delete from log_queries_requests
                       WHERE log_queries_requests.\"date\" < (CURRENT_DATE - INTERVAL '30 day'); -- LIMIT 1000;
          -- set sql_log_bin = 1;"
                )->execute();
            } catch (CDbException $e) {
                // Yii::app()->db->createCommand('REPAIR TABLE log_queries_requests')->execute();
                return;
            }
            try {
// Not needed for legacy site
//                Yii::app()->db->createCommand(
//                /** @lang SQL */ "-- set sql_log_bin = 0;
//          delete from log_api_requests
//                 WHERE log_api_requests.\"date\" < (CURRENT_DATE - INTERVAL '7 day'); -- LIMIT 1000;
//          -- set sql_log_bin = 1;"
//                )->execute();

            } catch (CDbException $e) {
                // Yii::app()->db->createCommand('REPAIR TABLE log_api_requests')->execute();
                return;
            }
            Yii::app()->cache->set('itemLogLastDelete', $nowDate, 3600);
        }

        $uid = Yii::app()->user->id;
        if ($uid == null) {
            $uid = -1;
        }
        if (isset($GLOBALS['_COOKIE']['PHPSESSID'])) {
            $session = $GLOBALS['_COOKIE']['PHPSESSID'];
        } else {
            $session = '';
        }
        /*  `id` bigint(20) NOT NULL AUTO_INCREMENT,
          `date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
          `session` varchar(64) DEFAULT NULL,
          `uid` mediumint(9) DEFAULT NULL,
          `num_iid` bigint(20) NOT NULL,
          `cid` bigint(20) NOT NULL DEFAULT '0',
          `express_fee` float DEFAULT NULL,
          `price` float DEFAULT NULL,
          `promotion_price` float DEFAULT NULL,
          `nick` varchar(64) DEFAULT NULL,
          `pic_url` varchar(256) DEFAULT NULL,
          `title` varchar(1024) DEFAULT NULL,
          `prop_names` varchar(4000) DEFAULT NULL,
        */
        $title = (string) $item->topItem->title;
        $prop_names = '';
        if (isset($item->topItem->props)) {
            foreach ($item->topItem->props as $pid => $prop) {
                $prop_name = preg_replace('/.*title.*?>(.+?)<.*/is', '$1', $prop->name) . ', ' . $pid;
                $prop_values = '';
                if (isset($prop->childs)) {
                    foreach ($prop->childs as $value) {
                        $prop_values = ', ' . preg_replace(
                            '/.*title.*?>(.+?)<.*/is',
                            '$1',
                            $value->name
                          ) . ', ' . $value->vid;
                    }
                }
                $prop_names = $prop_names . ' ' . $prop_name . ' ' . $prop_values;
            }
        }
        //TODO: Тут проверить что за ds_source
        $ds_source = $item->topItem->ds_source;
        $ds_type = ($item->topItem->isTmall ? 'tmall' : 'taobao');
        $command = Yii::app()->db->createCommand(
          "INSERT INTO log_item_requests (\"date\",\"session\",\"uid\",\"num_iid\",
  \"cid\",\"express_fee\",\"price\",\"promotion_price\",\"nick\",\"seller_rate\",
  \"pic_url\",\"title\",\"prop_names\",\"ds_source\",\"ds_type\")
  VALUES (now(),:session,:uid,:num_iid,
  :cid,:express_fee,:price,:promotion_price,:nick,:seller_rate,
  :pic_url,:title,:prop_names,:ds_source,:ds_type)"
        );
        $params = [
          ':session'         => $session,
          ':uid'             => $uid,
          ':num_iid'         => $item->topItem->num_iid,
          ':cid'             => $item->topItem->cid,
          ':express_fee'     =>
            strval(isset($item->topItem->express_price) ? $item->topItem->express_price : 0),
          ':price'           => strval($item->topItem->price),
          ':promotion_price' =>
            strval(
              isset($item->topItem->promotion_price) ? $item->topItem->promotion_price : $item->topItem->price
            ),
          ':nick'            => $item->topItem->nick,
          ':seller_rate'     => $item->topItem->seller->seller_credit,
          ':pic_url'         => $item->topItem->pic_url,
          ':title'           => $title,
          ':prop_names'      => $prop_names,
          ':ds_source'       => $ds_source,
          ':ds_type'         => $ds_type,
        ];
        //CVarDumper::dump($params,10,true); die;
        $command->execute(
          $params
        );
        unset($params);
//========== Update saved items ==========================
        $command = Yii::app()->db->createCommand(
          "UPDATE log_item_requests
      SET \"express_fee\" = :express_fee,
          \"price\" = :price,
          \"promotion_price\" = :promotion_price
          WHERE num_iid = :num_iid AND (express_fee!=:express_fee OR price!=:price OR promotion_price!=:promotion_price)"
        );
        $command->execute(
          [
            ':num_iid'         => $item->topItem->num_iid,
            ':express_fee'     =>
              strval(isset($item->topItem->express_price) ? $item->topItem->express_price : 0),
            ':price'           => strval($item->topItem->price),
            ':promotion_price' =>
              strval(
                isset($item->topItem->promotion_price) ? $item->topItem->promotion_price : $item->topItem->price
              ),
          ]
        );
        $command = Yii::app()->db->createCommand(
          "UPDATE favorites
      SET \"express_fee\" = :express_fee,
          \"price\" = :price,
          \"promotion_price\" = :promotion_price
          WHERE num_iid = :num_iid AND (express_fee!=:express_fee OR price!=:price OR promotion_price!=:promotion_price)"
        );
        $command->execute(
          [
            ':num_iid'         => $item->topItem->num_iid,
            ':express_fee'     =>
              strval(isset($item->topItem->express_price) ? $item->topItem->express_price : 0),
            ':price'           => strval($item->topItem->price),
            ':promotion_price' =>
              strval(
                isset($item->topItem->promotion_price) ? $item->topItem->promotion_price : $item->topItem->price
              ),
          ]
        );

        $command = Yii::app()->db->createCommand(
          "UPDATE featured
      SET \"express_fee\" = :express_fee,
          \"price\" = :price,
          \"promotion_price\" = :promotion_price
          WHERE num_iid = :num_iid AND (express_fee!=:express_fee OR price!=:price OR promotion_price!=:promotion_price)"
        );
        $command->execute(
          [
            ':num_iid'         => $item->topItem->num_iid,
            ':express_fee'     =>
              strval(isset($item->topItem->express_price) ? $item->topItem->express_price : 0),
            ':price'           => strval($item->topItem->price),
            ':promotion_price' =>
              strval(
                isset($item->topItem->promotion_price) ? $item->topItem->promotion_price : $item->topItem->price
              ),
          ]
        );
//========================================================
    }

    public static function doItemsLog($searchRes)
    {
        if (!$searchRes) {
            return;
        }
        if (!isset($searchRes->items)) {
            return;
        }
        if (count($searchRes->items) <= 0) {
            return;
        }
        Profiler::start('doItemsLog');
        $uid = Yii::app()->user->id;
        if ($uid == null) {
            $uid = -1;
        }
        if (isset($GLOBALS['_COOKIE']['PHPSESSID'])) {
            $session = $GLOBALS['_COOKIE']['PHPSESSID'];
        } else {
            $session = '';
        }

        $valuesToCheckExists = [];
        $searchResCacheKeyString = '';
        foreach ($searchRes->items as $item) {
            if (!isset($valuesToCheckExists[$item->ds_source])) {
                $valuesToCheckExists[$item->ds_source] = [];
            }
            $valuesToCheckExists[$item->ds_source][] = "'" . $item->num_iid . "'";
            $searchResCacheKeyString = $searchResCacheKeyString . $item->ds_source . $item->num_iid;
        }
        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get('itemsLog-' . $searchResCacheKeyString);
            if ($cache) {
                return;
            }
            @Yii::app()->memCache->set('itemsLog-' . $searchResCacheKeyString, 1, 24 * 3600);
        }
        $notNeedToUpdateRes = [];
        foreach ($valuesToCheckExists as $ds_source => $valuesToCheckExistsForSource) {
            $notNeedToUpdateResForSource = Yii::app()->db->createCommand(
              "SELECT num_iid FROM log_items_requests WHERE date_day IN (extract(day from now()),extract(day from Now() - INTERVAL '24 HOUR'))
           AND num_iid IN (" . (implode(
                ',',
                $valuesToCheckExistsForSource
              ) !== '' ? implode(',', $valuesToCheckExistsForSource) : 'null') . ")
    AND ds_source = :ds_source AND \"date\">(CURRENT_DATE - INTERVAL '24 hour')"
            )
              ->queryAll(true, [':ds_source' => $ds_source]);
            //$notNeedToUpdateRes = array();
            $valuesToCheckExistsForSourceFinal = [];
            if ($notNeedToUpdateResForSource) {
                foreach ($notNeedToUpdateResForSource as $notNeedToUpdateItem) {
                    $valuesToCheckExistsForSourceFinal[] = $notNeedToUpdateItem['num_iid'];
                }
            }
            $values = [];
            foreach ($searchRes->items as $item) {
//            if ($item->cid <> 0) {
//                $int_cid = $item->cid;
//            } else {
                if ($item->cid) {
                    $int_cid = $item->cid;
                } else {
                    $int_cid = '0';
                }
//            }
                if (!in_array($item->num_iid, $valuesToCheckExistsForSourceFinal) && ($item->ds_source == $ds_source)) {
                    $values[] =
                      "(now(), extract(day from now()), '" .
                      $item->ds_source .
                      "','" .
                      $item->num_iid .
                      "'," .
                      ((isset($item->uniqpid) && $item->uniqpid) ? $item->uniqpid : 0) .
                      ",'" .
                      $int_cid .
                      "'," .
                      $item->express_fee .
                      "," .
                      $item->price .
                      ","
                      .
                      $item->promotion_price .
                      ",'" .
                      $item->pic_url .
                      "','" .
                      $item->nick .
                      "'," .
                      $item->seller_rate .
                      ",'" .
                      preg_replace(
                        '/\'/',
                        '\'',
                        $searchRes->query
                      ) .
                      "','" .
                      trim(
                        Utils::clearSqlInjections(
                          $item->name->source
                        )
                      ) .
                      "'," .
                      ((isset($item->tmall) && $item->tmall) ? "'tmall'" : "'taobao'") .
                      ")";
                }
            }
            if (count($values) > 0) {
                try {
                    //delayed ignore
                    $sql = "INSERT INTO log_items_requests (\"date\",\"date_day\",\"ds_source\",\"num_iid\",\"uniqpid\",\"cid\",\"express_fee\",\"price\",
  \"promotion_price\",\"pic_url\", \"nick\", \"seller_rate\",\"query\", \"title\",\"ds_type\")
  VALUES " . implode(',', $values) . "
                 ON CONFLICT ON CONSTRAINT log_items_requests_constr
               DO UPDATE SET \"date\"=Now(), \"express_fee\"=EXCLUDED.express_fee, \"price\"=EXCLUDED.price,
                \"uniqpid\"=EXCLUDED.uniqpid, \"promotion_price\"=EXCLUDED.promotion_price,
  \"nick\"=EXCLUDED.nick, \"seller_rate\"=EXCLUDED.seller_rate, \"title\"=EXCLUDED.title, \"ds_type\"=EXCLUDED.ds_type";
                    $command = Yii::app()->db->createCommand($sql);
                    $command->execute();
                } catch (Exception $e) {
                    Profiler::stop('doItemsLog');
                }
            }
        }
        Profiler::stop('doItemsLog');
    }

    public static function doQueryLog($searchRes)
    {
        if (in_array(Yii::app()->controller->id, ['search']) && isset($_GET['query']) && $_GET['query']) {
            $uid = Yii::app()->user->id;
            if ($uid == null) {
                $uid = -1;
            }
            if (isset($GLOBALS['_COOKIE']['PHPSESSID'])) {
                $session = $GLOBALS['_COOKIE']['PHPSESSID'];
            } else {
                $session = '';
            }
            $command = Yii::app()->db->createCommand(
              "INSERT INTO log_queries_requests(\"date\",\"session\",\"uid\",\"res_count\",\"cid\",\"query\")
VALUES (now(),:session,:uid,:res_count,:cid,:query)
       -- ON CONFLICT ON CONSTRAINT log_queries_requests_constr 
       -- DO NOTHING 
"
            );
            $command->execute(
              [
                ':session'   => $session,
                ':uid'       => $uid,
                ':res_count' => $searchRes->total_results,
                ':cid'       => $searchRes->cid,
                ':query'     => $searchRes->query,
              ]
            );
        }
    }

    public static function getPagesHistory($type, $count)
    {
        $_uid = Yii::app()->user->id;
        if (isset(Yii::app()->request->cookies['PHPSESSID'])) {
            $_session = Yii::app()->request->cookies['PHPSESSID'];
        } else {
            $_session = null;
        }
        if (!is_null($_uid)) {
            $_session = null;
        }
        $_type = (($type) ? $type : null);
        $_count = $count;
        if ($_uid || $_session) {
            $command = Yii::app()->db->createCommand(
              "SELECT ss.url FROM
(SELECT lh.url, max(lh.date) AS \"date\"
  FROM log_http_requests lh
 WHERE     (lh.uid = :uid OR :uid IS NULL)
       AND (lh.session = :session OR :session IS NULL)
       AND (   lh.url ~* :type
            OR (    (:type IS NULL)
                AND (lh.url ~* '\/(category|search|brand|item|seller)\/')))
                GROUP BY lh.url
                ) ss
ORDER BY ss.date DESC
 LIMIT {$_count}"
            );
            $urls = $command->queryAll(
              true,
              [
                ':uid'     => $_uid,
                ':session' => $_session,
                ':type'    => $_type,
              ]
            );
        } else {
            $urls = false;
        }
        $result = [];
        if ($urls) {
            foreach ($urls as $url) {
                $descr = self::getUrlDescription($url['url']);
                if ($descr['label']) {
                    $rec = new stdClass();
                    $rec->url = $url['url'];
                    $rec->label = $descr['label'];
                    $rec->type = $descr['type'];
                    $result[] = $rec;
                }
            }
            return $result;
        } else {
            return false;
        }
    }

    public static function getTopSearchQueries($count = 5)
    {
        $command = Yii::app()->db->cache(1200)->createCommand(
          "SELECT ll.query, count(0) AS cnt FROM log_queries_requests ll
WHERE (ll.query IS NOT NULL) AND (ll.query !='') AND (ll.query NOT LIKE '%&%') AND ll.cid='0'
GROUP BY ll.query
ORDER BY cnt DESC, max(ll.date) DESC LIMIT " . $count
        );
        $result = $command->queryAll();
        if ($result) {
            foreach ($result as $i => $rec) {
                $result[$i]['query'] = urldecode($rec['query']);
            }
        }
        return $result;
    }

    public static function getUrlDescription($url)
    {
        $result = [];
        if (preg_match('/\/(category)\//i', $url)) {
            $result['type'] = 'category';
            if (preg_match('/[\/\?](?:cid)[\/=](\d+)(?:[\/&]|$)/i', $url, $matches)) {
                $recs = MainMenu::model()->find('cid=:cid', [':cid' => $matches[1]]);
                if ($recs) {
                    $result['label'] = $recs[Utils::appLang()];
                } else {
                    $result['label'] = '';
                }
                /*            } elseif (preg_match('/[\/\?](mainmenu\-.+?)(?:[\/&]|$)/i', $url, $matches)) {
                                $recs = MainMenu::model()->find('url=:url', array(':url' => $matches[1]));
                                if ($recs) {
                                    $result['label'] = $recs[Utils::appLang()];
                                } else {
                                    $result['label'] = '';
                                } */
            } else {
                $result['label'] = '';
            }
        } elseif (preg_match('/\/(search)\//i', $url)) {
            $result['type'] = 'search';
            $result['label'] = Yii::t('main', 'Поиск');
            if (preg_match('/[\/\?](?:q|query)[\/=](.+?)(?:[\/&]|$)/i', $url, $matches)) {
                $result['label'] = $result['label'] . ': ' . urldecode($matches[1]);
            } elseif (preg_match('/[\/\?](?:cid)[\/=](\d+)(?:[\/&]|$)/i', $url, $matches)) {
                $recs = MainMenu::model()->find('cid=:cid', [':cid' => $matches[1]]);
                if ($recs) {
                    $result['label'] = $recs[Utils::appLang()];
                } else {
                    $result['label'] = '';
                }
            } else {
                $result['label'] = '';
            }
        } elseif (preg_match('/\/(brand)\//i', $url)) {
            $result['type'] = 'brand';
            $result['label'] = Yii::t('main', 'Бренд');
            if (preg_match('/[\/\?](?:brand)[\/=](.+?)(?:[\/&]|$)/i', $url, $matches)) {
                $recs = Brands::model()->find('url=:url', [':url' => $matches[1]]);
                if ($recs) {
                    $result['label'] = $result['label'] . ' ' . $recs['name'];
                } else {
                    $result['label'] = '';
                }
            } else {
                $result['label'] = '';
            }
        } elseif (preg_match('/\/(item)\//i', $url)) {
            $result['type'] = 'item';
            $result['label'] = Yii::t('main', 'Товар');
            if (preg_match('/\/item[\/=](\d+)(?:[\/&]|$)/i', $url, $matches)) {
                $result['label'] = $result['label'] . ' Art.' . $matches[1];
            } else {
                $result['label'] = '';
            }
        } elseif (preg_match('/\/(seller)\//i', $url)) {
            $result['type'] = 'seller';
            if (preg_match('/[\/\?](?:nick)[\/=](.+?)(?:[\/&]|$)/i', $url, $matches)) {
                $result['label'] = Yii::t('main', 'Продавец') . ' ' . urldecode($matches[1]);
            } elseif (preg_match('/[\/\?](?:seller_id)[\/=](\d+)(?:[\/&]|$)/i', $url, $matches)) {
                $result['label'] = Yii::t('main', 'Продавец') . ' ' . $matches[1];
            } else {
                $result['label'] = Yii::t('main', 'Продавец') . '...';
            }
        } else {
            $result['type'] = '';
            $result['label'] = '';
        }
        if (preg_match('/[\/\?]page[\/=](\d+)(?:[\/&]|$)/i', $url, $matches)) {
            if ($result['label']) {
                $result['label'] = $result['label'] . ' ' . Yii::t('main', 'стр.') . ' ' . $matches[1];
            }
        }
        return $result;
//        return Yii::t('main', 'Описание');
    }

}