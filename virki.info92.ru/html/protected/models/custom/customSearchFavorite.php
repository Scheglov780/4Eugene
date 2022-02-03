<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Search.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/*
 * Модель для общего поиска товаров. Уникальна и используется для поиска, категорий, продавцов
 */

class customSearchFavorite extends SearchBase
{
//    public $lang; //!
//    public $q = ''; /*! Поисковый запрос на китайском языке. */
//    public $ex_q = ''; /* Исключить данный текст из результатов поиска. Значение - на китайском. */
//    public $image = ''; //!Хэш для поиска по картинке
//    public $extParams = false; //! Расширенные дополнительные парамтры
//    public $startPrice = '';//!
//    public $endPrice = '';//!
//    public $startCredit = ''; //! unused
//    public $endCredit = ''; //! unused
//    public $promotions = false; /*! Искать только товары со скидкой. Если да, передаем значение 1 */
//    public $recommend = false; /*! Поиск только по рекомендованным товарам (с высоким рейтингом
//                                и сервисом продавца). Если да - значение 1 */
//    public $sort = '';//!
//    public $cat = '';//!
//    public $props = '';//!!! ??? Возможно и не нужно - проверить и удалить ВЕЗДЕ
//    public static $pageSize = null; //!
//    public $_pageSize = null;//!
//    public $pageNo = 1;//!

    /*    public $search_use_related_queries = 0;
        public $search_use_related_cats = 1;
        public $search_use_parsed_filters = 1;
    */
//    public $translator_long_list_count_limit = 20;
//    private $DSGSearchRes;

    private function searchByFavorite()
    {
        $query = '';
        if (isset($this->params['query'])) {
            $query = $this->prepareSearchQuery($this->params['query'], true);
        }
        $req = new stdClass();
        if ($query == false) {
            $req->q = $query;
        }
        if (!empty($this->params['price_min'])) {
            $req->startPrice = $this->params['price_min'];
        } else {
            if (DSConfig::getVal('search_use_safe_price_ranges') == 1) {
                $req->startPrice = 0.1;
            } else {
                $req->startPrice = 0;
            }
        }
        if (!empty($this->params['price_max']) && ($this->params['price_max'] != false)) {
            $req->endPrice = $this->params['price_max'];
        } else {
            if (DSConfig::getVal('search_use_safe_price_ranges') == 1) {
                $req->endPrice = 999999;
            } else {
                $req->endPrice = 9999999;
            }
        }
        //set category id
        if (isset($this->params['cid'])) {
            if ($this->params['cid'] != '0') {
                $req->cat = $this->params['cid'];
            } else {
                $req->cat = '0';
            }
        }
        //set page size
        $req->pageSize = (int) DSConfig::getVal('search_ItemsPerPageDefault'); //12
        //set page number
        $in_page_no = $this->params['page'];
        $req->pageNo = $in_page_no;
        $req->pageOffset = $req->pageSize * ($req->pageNo - 1);
        /** @noinspection PhpUndefinedFieldInspection */
        $req->uid = Yii::app()->user->id;
        if (!empty($this->params['sort_by'])) {
            $req->sort = $this->params['sort_by'];
        }
//======================================================================================
        $countTotal = Yii::app()->db->createCommand(
          "SELECT count(0) AS cnt FROM favorites ff
WHERE
uid=:uid
AND (ff.cid=:cid OR :cid IS NULL OR :cid='0' OR ff.cid IN (
(SELECT ce2.cid FROM categories_ext ce2 WHERE ce2.parent IN (SELECT ce1.id FROM categories_ext ce1 WHERE ce1.cid=:cid)
)))
AND (least(price,promotion_price) BETWEEN :price_min AND :price_max)"
        )
          ->queryScalar(
            [
              ':uid' => $req->uid,
              ':cid' => $req->cat,
              ':price_min' => $req->startPrice,
              ':price_max' => $req->endPrice,
            ]
          );
        $req->pageSize = (int) $req->pageSize;
        $searchRecords = Yii::app()->db->createCommand(
          "SELECT ff.id, ff.num_iid,ff.cid,ff.express_fee,ff.price,ff.promotion_price,ff.pic_url,ff.seller_rate,
                        '' AS seller_nick, ff.title, ff.dsg_item,
          ff.ds_source, ff.ds_type
  FROM favorites ff
WHERE
uid=:uid
AND (ff.cid=:cid OR :cid IS NULL OR :cid='0' OR ff.cid IN (
(SELECT ce2.cid FROM categories_ext ce2 WHERE ce2.parent IN (SELECT ce1.id FROM categories_ext ce1 WHERE ce1.cid=:cid)
)))
AND (least(ff.price,ff.promotion_price) BETWEEN {$req->startPrice} AND {$req->endPrice})
ORDER BY ff.date DESC
LIMIT {$req->pageOffset},{$req->pageSize}"
        )->queryAll(
          true,
          [
            ':uid' => $req->uid,
            ':cid' => $req->cat,
          ]
        );
//======================================================================================
        $searchRes = new customSearchResult();
        if (isset($this->params['query'])) {
            $searchRes->query = $this->params['query'];
        }
        if (isset($this->params['cid'])) {
            $searchRes->cid = $this->params['cid'];
        }
        $searchRes->search_type = 'searchDSG';
        if (($searchRecords) && ($countTotal > 0)) {
            $searchRes->total_results = $countTotal;
            if ($searchRes->total_results > 0) {
                foreach ($searchRecords as $item) {
                    $searchRes->items[] = new customSearchItemResult($item, false);
                }
            }
        } else {
            $searchRes->total_results = 0;
        }
        return $searchRes;
    }

    public function execute()
    {
        Profiler::start('searchFavorite->execute', true);
        $searchRes = $this->searchByFavorite();
        Profiler::start('searchFavorite->prepareItemTitle');
        $seo_catalog_enabled = DSConfig::getVal('seo_catalog_enabled') == 1;
        $breadcrumbs = $this->searchBreadcrumbs('');
        if (is_array($searchRes->items)) {
            static::prepareItemsTitle($this, $searchRes->items, $seo_catalog_enabled, $breadcrumbs);
        }
        Profiler::stop('searchFavorite->prepareItemTitle');
        Profiler::start('searchFavorite->weightForArray');
        //Weights::getItemWeightForArray($searchRes);
        Profiler::stop('searchFavorite->weightForArray');
        Formulas::getUserPriceForArray($searchRes);
        ItemFilters::checkForNotOnSale($searchRes);
//====================================================================================================
        if (isset($this->params['sort_by']) && ($this->params['sort_by'] == 'price_asc')) {
            uasort(
              $searchRes->items,
              function ($a, $b) {
                  $a_val = $a->promotion_price;// + $a->express_fee;
                  $b_val = $b->promotion_price;// + $b->express_fee;

                  if ($a_val < $b_val) {
                      return -1;
                  } elseif ($a_val == $b_val) {
                      return 0;
                  } else {
                      return 1;
                  }
              }
            );
        } elseif (isset($this->params['recommend']) && ($this->params['recommend'] == 1)) {
            uasort(
              $searchRes->items,
              function ($a, $b) {
                  return mt_rand(-1, 1);
              }
            );
        }

        Profiler::stop('searchFavorite->execute', true);
        if (isset($this->dsSrcLangQuery)) {
            $searchRes->dsSrcLangQuery = $this->dsSrcLangQuery;
        }
        return $searchRes;
    }

}