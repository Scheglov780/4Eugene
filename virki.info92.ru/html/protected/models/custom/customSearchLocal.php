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

class customSearchLocal extends SearchBase
{
    private $DSGSearchRes; /*! Поисковый запрос на китайском языке. */
    private $_pageSize = null; /* Исключить данный текст из результатов поиска. Значение - на китайском. */
    private $cat = ''; //!Хэш для поиска по картинке
    private $endCredit = ''; //! Расширенные дополнительные парамтры
    private $endPrice = '';//!
    private $ex_q = '';//!
    private $extParams = false; //! unused
    private $image = ''; //! unused
    private $pageNo = 1; /*! Искать только товары со скидкой. Если да, передаем значение 1 */
    private $promotions = false; /*! Поиск только по рекомендованным товарам (с высоким рейтингом
                                и сервисом продавца). Если да - значение 1 */
    private $props = '';//!
    private $q = '';//!
    private $recommend = false;//!!! ??? Возможно и не нужно - проверить и удалить ВЕЗДЕ
    private $sort = ''; //!
    private $startCredit = '';//!
    private $startPrice = '';//!
    /*    public $search_use_related_queries = 0;
        public $search_use_related_cats = 1;
        public $search_use_parsed_filters = 1;
    */
    private $translator_long_list_count_limit = 20;
    private static $pageSize = null;

    private function searchInDb($ds_source = false)
    {
        //TODO: Сюда не приходит ds_source - разобраться.
        if (self::$pageSize) {
            $this->_pageSize = self::$pageSize;
        }
        $query = [];
        if ($this->extParams) {
            $query = $this->extParams;
        }
        /*
        if (isset($this->_params['nick'])) {
//TODO: поиск по пользователю - нужно ли?
            $query[':seller_nick'] = $this->_params['nick'];
        } else {
            $query[':seller_nick'] = null;
        }
        */
        if (isset($this->_params['user_id'])) {
//TODO: поиск по пользователю - нужно ли?
            $query[':seller_id'] = $this->_params['user_id'];
        } else {
            $query[':seller_id'] = null;
        }
        if (isset($this->q) && ($this->q != '') && !preg_match('/^&/is', $this->q)) {
            $query[':q'] = $this->q;
        } else {
            $query[':q'] = null;
        }
        if (isset($this->image) && ($this->image != '')) {
//TODO: поиск по картинкам - нужно ли?
            //$query['tfsid'] = $this->image;
        }
        //Если категория указана
        if (isset($this->cat) && ($this->cat != '0')) {
            //И если категорий несколько
            //TODO: здесь раньше было '/(.+?)(?:,)/' - проверить
            if (preg_match('/(.+?)(?:,)/', $this->cat, $matches)) { //For multiple categories old fix
                //И если не указан поисковый запрос
                if (!isset($this->q) || (isset($this->q) && !$this->q)) {
                    $query[':cat'] = $matches[1];
                } else {
                    //Иначе если поисковый запрос указан
                    $query[':cat'] = null;
                }
                //Иначе, если категорий не несколько
            } else {
                $query[':cat'] = $this->cat;
            }
        } else {
            $query[':cat'] = null;
        }
        if (isset($this->props) && ($this->props != '') && ($this->props)) {
//TODO: поиск по свойствам - нужно ли?
            //$query['props'] = $this->props;
        }
        if (isset($this->sort) && ($this->sort != '')) {
            $query[':sort_order'] = $this->sort;
        } else {
            $query[':sort_order'] = 'popularity_desc';
        }
        if (isset($this->startPrice) && $this->startPrice) {
            $query[':startPrice'] = $this->startPrice;
        } else {
            $query[':startPrice'] = null;
        }
        if (isset($this->endPrice) && $this->endPrice) {
            $query[':endPrice'] = $this->endPrice;
        } else {
            $query[':endPrice'] = null;
        }
        if (isset($this->pageNo) && ($this->pageNo > 1)) {
            $query[':start_item_num'] = ($this->pageNo - 1) * $this->_pageSize;
        } else {
            $query[':start_item_num'] = 0;
        }
        $query[':page_size'] = $this->_pageSize;

        if ($ds_source) {
            $query[':ds_source'] = $ds_source;
        } else {
            $query[':ds_source'] = null;
        }

        if (class_exists('Profiler', false)) {
            Profiler::start('SearchLocal->selectData');
        }

        //TODO: Тут исполнить запрос
//        $searchTransaction = Yii::app()->db->beginTransaction();
        /** @noinspection SqlDialectInspection  start */
        if (SQL_NO_WITH) {
            $sql = /** @lang PostgreSQL */
              "SELECT /* SQL_CALC_FOUND_ROWS */
-- ROW_NUMBER() OVER() as res_num, ss.keywords,
ii.\"item_id\",
ii.\"language\",
ii.\"currency\",
ii.\"ds_source\",
ii.\"cid\",
ii.\"picture_url\",
ii.\"description_url\",
ii.\"pid\",
ii.\"title\",
ii.\"location\",
ii.\"sold_items\",
ii.\"pce\",
ii.\"currency\",
ii.\"price\",
ii.\"price_promo\",
ii.\"price_delivery\",
ii.\"in_stock\",
ii.\"seller_id\",
ii.\"seller_id_encripted\",
ii.\"seller_nick\",
ii.\"seller_rate\",
ii.\"updated\",
ii.\"queried\"
 FROM \"local_items_search\" ss
JOIN local_items ii ON ss.ds_source = ii.ds_source AND ss.item_id = ii.item_id
WHERE
(ss.ds_source = :ds_source OR :ds_source = '' OR :ds_source IS NULL)
AND (
to_tsvector('russian',ss.keywords) @@ websearch_to_tsquery('russian',:q)
         OR :q = '' OR :q IS NULL)
AND (
to_tsvector('russian',ss.keywords) @@ websearch_to_tsquery('russian',:cat)        
OR :cat = '' OR :cat IS NULL
OR ii.cid = :cat  
)
-- TODO: Спорно и может быть потом раскомментить
-- AND EXISTS (SELECT 'x' FROM categories_ext cc3 WHERE cc3.cid = ii.cid AND cc3.ds_source = ii.ds_source)
AND (:startPrice::varchar = '' OR :startPrice::numeric IS NULL OR ii.price_promo>= :startPrice::numeric)
AND (:endPrice::varchar = '' OR :endPrice::numeric IS NULL OR ii.price_promo::numeric<= :endPrice::numeric)
-- TODO: Возможно, потом уточнить
AND (ss.uid = :seller_id OR ii.uid = :seller_id or ii.seller_id = :seller_id OR :seller_id is null)
ORDER BY
ii.in_stock = 0, 
CASE WHEN :sort_order = 'sales_desc' THEN sold_items ELSE NULL END DESC,
CASE WHEN :sort_order = 'popularity_desc' THEN queried ELSE NULL END DESC, 
CASE WHEN :sort_order = 'rate_desc' THEN seller_rate ELSE NULL END DESC,
CASE WHEN :sort_order = 'price_asc' THEN price_promo ELSE NULL END ASC,
CASE WHEN :sort_order = 'price_desc' THEN price_promo ELSE NULL END DESC,
CASE WHEN (:q::varchar is not null AND :q::varchar != '') THEN
ts_rank(to_tsvector('russian',ss.keywords), websearch_to_tsquery('russian',:q)) ELSE NULL END DESC,
CASE WHEN (:cat::varchar is not null AND :cat::varchar != '') THEN
ts_rank(to_tsvector('russian',ss.keywords), websearch_to_tsquery('russian',:cat)) ELSE NULL END DESC
";
        } else {
            $sql = /** @lang PostgreSQL */
              "SELECT /* SQL_CALC_FOUND_ROWS */
-- ROW_NUMBER() OVER() as res_num, ss.keywords,
ii.\"item_id\",
ii.\"language\",
ii.\"currency\",
ii.\"ds_source\",
ii.\"cid\",
ii.\"picture_url\",
ii.\"description_url\",
ii.\"pid\",
ii.\"title\",
ii.\"location\",
ii.\"sold_items\",
ii.\"pce\",
ii.\"currency\",
ii.\"price\",
ii.\"price_promo\",
ii.\"price_delivery\",
ii.\"in_stock\",
ii.\"seller_id\",
ii.\"seller_id_encripted\",
ii.\"seller_nick\",
ii.\"seller_rate\",
ii.\"updated\",
ii.\"queried\"
 FROM \"local_items_search\" ss
JOIN local_items ii ON ss.ds_source = ii.ds_source AND ss.item_id = ii.item_id
WHERE
(ss.ds_source = :ds_source OR :ds_source = '' OR :ds_source IS NULL)
AND (
to_tsvector('russian',ss.keywords) @@ websearch_to_tsquery('russian',:q)        
        OR :q = '' OR :q IS NULL)
AND (
to_tsvector('russian',ss.keywords) @@ websearch_to_tsquery('russian',:cat)    
    OR :cat = '' OR :cat IS NULL
OR ii.cid = :cat  
OR ii.cid IN (
WITH RECURSIVE categories AS (
  SELECT cc1.id, cc1.parent, cc1.cid FROM categories_ext cc1
  WHERE cc1.cid = :cat
  UNION
  SELECT cc2.id, cc2.parent, cc2.cid
  FROM categories_ext AS cc2, categories AS rr
  WHERE
    cc2.parent = rr.id
)
SELECT ccr.cid FROM categories ccr WHERE ccr.id != ccr.parent)
)
-- TODO: Спорно и может быть потом раскомментить
-- AND EXISTS (SELECT 'x' FROM categories_ext cc3 WHERE cc3.cid = ii.cid AND cc3.ds_source = ii.ds_source)
AND (:startPrice::varchar = '' OR :startPrice::numeric IS NULL OR ii.price_promo::numeric>= :startPrice::numeric)
AND (:endPrice::varchar = '' OR :endPrice::numeric IS NULL OR ii.price_promo::numeric<= :endPrice::numeric)
-- TODO: Возможно, потом уточнить
AND (ss.uid = :seller_id OR ii.uid = :seller_id or ii.seller_id = :seller_id OR :seller_id is null)
ORDER BY
ii.in_stock = 0, 
CASE WHEN :sort_order = 'sales_desc' THEN sold_items ELSE NULL END DESC,
CASE WHEN :sort_order = 'popularity_desc' THEN queried ELSE NULL END DESC, 
CASE WHEN :sort_order = 'rate_desc' THEN seller_rate ELSE NULL END DESC,
CASE WHEN :sort_order = 'price_asc' THEN price_promo ELSE NULL END ASC,
CASE WHEN :sort_order = 'price_desc' THEN price_promo ELSE NULL END DESC,
CASE WHEN (:q::varchar is not null AND :q::varchar != '') THEN
ts_rank(to_tsvector('russian',ss.keywords), websearch_to_tsquery('russian',:q)) ELSE NULL END DESC,
CASE WHEN (:cat::varchar is not null AND :cat::varchar != '') THEN
ts_rank(to_tsvector('russian',ss.keywords), websearch_to_tsquery('russian',:cat)) ELSE NULL END DESC
";
        }
        /** @noinspection SqlDialectInspection  end */
        $countSql = "SELECT Count(0) FROM ({$sql}) countSql";
        $sql = $sql . "
 LIMIT {$query[':page_size']} OFFSET {$query[':start_item_num']}";
        unset($query[':start_item_num'], $query[':page_size']);
        $items = Yii::app()->db->createCommand($sql)->queryAll(true, $query);
        //TODO: Тут не забыть спросить сколько всего найдено результатов
        $items_count = Yii::app()->db->createCommand($countSql)->queryScalar($query);
//        $searchTransaction->commit();
        //TODO: не забыть потом для китайского языка прикрутить триграммный парсер полнотекста (разобраться)
        if (class_exists('Profiler', false)) {
            Profiler::stop('SearchLocal->selectData');
        }
        $this->DSGSearchRes = new stdClass();
        $this->DSGSearchRes->items = [];
        if (!$items_count || !$items || ($items && !count($items))) {
            return $this->DSGSearchRes;
        }
        $this->DSGSearchRes->total_results = $items_count;

        foreach ($items as $item) {
            $this->DSGSearchRes->items[] = new customSearchItemResult($item, true);
        }

        unset($item, $items);
        $this->DSGSearchRes->intCategories = [];
        $this->DSGSearchRes->intGroups = [];
        $this->DSGSearchRes->intFilters = [];
        $this->DSGSearchRes->intMultiFilters = [];
        $this->DSGSearchRes->intSuggestions = [];
        $this->DSGSearchRes->intPriceRanges = [];
        /*
                    if ($this->search_use_related_cats) {
                        //  $this->parseCategoriesFromJson($jsonData);
                    }
                    if ($this->search_use_parsed_filters) {
                        $this->parseGroupsFromJson($jsonData);
                        $this->parseFiltersFromJson($jsonData);
                        //  $this->parseMultiFiltersFromJson($jsonData);
                    }
                    if ($this->search_use_related_queries) {
                        $this->parseSuggestionsFromJson($jsonData);
                    }
                    $this->parsePriceRangesFromJson($jsonData);
        */

        /*
                    if ($searchTemplateName == 's.taobao.com') {
                        $resstr = array();
                        $res = $this->regexMatch('parse_items_count', $data->body, $resstr);
                        if ($res > 0) {
                            $resnum = DSGUtils::parseChineseNumber($resstr[1]);
                        } else {
                            $resnum = 0;
                        }
                        $this->DSGSearchRes->total_results = $resnum;
                        $this->regexReplaceCallback(
                          'parse_items_block',
                          array(
                            $this,
                            'parseItem'
                          ),
                          $this->DSGSearchRes->html->body,
                          (int) self::$pageSize
                        );

                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        if ($this->search_use_related_cats) {
                            $this->parseCategories($data->body);
                        }
                        if ($this->search_use_parsed_filters) {
                            $this->parseGroups($data->body);
                            $this->parseFilters($data->body);
                            $this->parseMultiFilters($data->body);
                        }
                        if ($this->search_use_related_queries) {
                            $this->parseSuggestions($data->body);
                        }
                        $this->parsePriceRanges($data->body);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                    } elseif ($searchTemplateName == 's.taobao.com/image') {
                        $resstr = array();
                        $res = $this->regexMatch('loaded_data_section', $data->body, $resstr);
                        if ($res > 0) {
                            if (md5($data->body) != md5($resstr[1])) {
                                $data->body = $resstr[1];
                            }
                            $jsonData = $this->JavaScriptToJSON($resstr[1], true, true);
                        } else {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        unset($resstr);
                        $res = $this->jsonObjGetByRulePath('parse_items_block', $jsonData);
                        if (!$res) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        } else {
                            $this->DSGSearchRes->total_results = count($res[0]->auctions);
                        }
                        $itemsList = $res[0]->auctions;
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJson($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        if ($this->search_use_related_cats) {
                            //  $this->parseCategoriesFromJson($jsonData);
                        }
                        if ($this->search_use_parsed_filters) {
                            $this->parseGroupsFromJson($jsonData);
                            $this->parseFiltersFromJson($jsonData);
                            //  $this->parseMultiFiltersFromJson($jsonData);
                        }
                        if ($this->search_use_related_queries) {
                            $this->parseSuggestionsFromJson($jsonData);
                        }
                        $this->parsePriceRangesFromJson($jsonData);
                        unset($data);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    } elseif ($searchTemplateName == 's.taobao.com/json') {
                        $resstr = array();
                        $res = $this->regexMatch('loaded_data_section', $data->body, $resstr);
                        if ($res > 0) {
                            if (md5($data->body) != md5($resstr[1])) {
                                $data->body = $resstr[1];
                            }
                            $jsonData = $this->JavaScriptToJSON($resstr[1], true, true);
                        } else {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        unset($resstr);
                        if (isset($jsonData->pageName)) {
                            $i2i = $jsonData->pageName == 'i2i';
                        } else {
                            $i2i = false;
                        }
                        $res = $this->jsonObjGetByRulePath((!$i2i ? 'parse_items_count' : 'parse_items_count_i2i'), $jsonData);
                        if (!$res) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        } else {
                            $this->DSGSearchRes->total_results = $res;
                        }
                        $itemsList = $res = $this->jsonObjGetByRulePath(
                          (!$i2i ? 'parse_items_block' : 'parse_items_block_i2i'),
                          $jsonData
                        );
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJson($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        if ($this->search_use_related_cats) {
                            //  $this->parseCategoriesFromJson($jsonData);
                        }
                        if ($this->search_use_parsed_filters) {
                            $this->parseGroupsFromJson($jsonData);
                            $this->parseFiltersFromJson($jsonData);
                            //  $this->parseMultiFiltersFromJson($jsonData);
                        }
                        if ($this->search_use_related_queries) {
                            $this->parseSuggestionsFromJson($jsonData);
                        }
                        $this->parsePriceRangesFromJson($jsonData);
                        unset($data);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    } elseif ($searchTemplateName == 'world.taobao.com/search') {
                        $resstr = array();
                        $res = $this->regexMatch('ValidationCheck', $data->body);
                        if ($res > 0) {
                            $jsonData = $this->JavaScriptToJSON($data->body, true, true);
                        } else {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        $res = $this->jsonObjGetByRulePath('parse_items_count', $jsonData);
                        if (!$res) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        } else {
                            $this->DSGSearchRes->total_results = $res;
                        }
                        $itemsList = $res = $this->jsonObjGetByRulePath('parse_items_block', $jsonData);
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJson($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        if ($this->search_use_related_cats) {
                            //  $this->parseCategoriesFromJson($jsonData);
                        }
                        if ($this->search_use_parsed_filters) {
                            //$this->parseGroupsFromJson($jsonData);
                            $this->parseFiltersFromJson($jsonData);
                            //  $this->parseMultiFiltersFromJson($jsonData);
                        }
                        if ($this->search_use_related_queries) {
                            $this->parseSuggestionsFromJson($jsonData);
                        }
                        $this->parsePriceRangesFromJson($jsonData);
                        unset($data);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    } elseif ($searchTemplateName == 's.taobao.com/json/seller') {
                        if (!$query['user_id']) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        $infoDataUrl = $this->getDSGRule('info_url') . $query['user_id'];
                        $info_data = DSGDownloader::getHttpDocument($infoDataUrl, false, $this->forceNoProxy);
                        $resstr = array();
                        $jsonData = $this->JavaScriptToJSON($data->body, true, true);
                        $res = $this->regexMatch('parse_items_count', $info_data->body, $resstr);
                        if (!$res) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        } else {
                            $this->DSGSearchRes->total_results = $resstr[1];
                        }

                        $res = $this->regexMatch('user_rate_url', $info_data->body, $resstr);
                        if ($res > 0) {
                            $this->DSGSearchRes->userRateUrl = $resstr[0];
                        }

                        $itemsList = $res = $this->jsonObjGetByRulePath('parse_items_block', $jsonData);
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJson($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        unset($data);
                        unset($info_data);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    } elseif ($searchTemplateName == 's.taobao.com/json/seller2') {
                        if (!$query['user_id']) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        $resstr = array();
                        $jsonData = $this->JavaScriptToJSON($data->body, true, true);
                        $res = $this->regexMatchAll('parse_items_count', $data->body, $resstr);
                        if (!$res) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        } else {
                            $this->DSGSearchRes->total_results = $res;
                        }
                        if ($this->DSGSearchRes->total_results >= $this->_pageSize) {
                            $this->DSGSearchRes->total_results = round(
                              ($this->pageNo) * $this->_pageSize + $this->DSGSearchRes->total_results
                            );
                        } else {
                            $this->DSGSearchRes->total_results = round(
                              ($this->pageNo - 1) * $this->_pageSize + $this->DSGSearchRes->total_results
                            );
                        }
                        if (isset($this->extParams) && isset($this->extParams['encryptedUserId']) && $this->extParams['encryptedUserId']) {
                            $this->DSGSearchRes->userRateUrl = "//rate.taobao.com/user-rate-{$this->extParams['encryptedUserId']}.htm";
                        } else {
                            $encryptedUserId = DSGSeller::getEncryptedUserId($query['user_id']);
                            if ($encryptedUserId) {
                                $this->DSGSearchRes->userRateUrl = "//rate.taobao.com/user-rate-{$encryptedUserId}.htm";
                            }
                        }

                        $itemsList = $this->jsonObjGetByRulePath('parse_items_block', $jsonData);
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJson($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        unset($data);
                        unset($info_data);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    } elseif ($searchTemplateName == 's.taobao.com/json/seller3') {
                        if (!$query['user_id']) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        $resstr = array();
                        $jsonData = $this->JavaScriptToJSON($data->body, true, true);
                        $res = $this->regexMatchAll('parse_items_count', $data->body, $resstr);
                        if (!$res) {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        } else {
                            $this->DSGSearchRes->total_results = $res;
                        }
                        if ($this->DSGSearchRes->total_results >= $this->_pageSize) {
                            $this->DSGSearchRes->total_results = round(
                              ($this->pageNo) * $this->_pageSize + $this->DSGSearchRes->total_results
                            );
                        } else {
                            $this->DSGSearchRes->total_results = round(
                              ($this->pageNo - 1) * $this->_pageSize + $this->DSGSearchRes->total_results
                            );
                        }
                        if (isset($this->extParams) && isset($this->extParams['encryptedUserId']) && $this->extParams['encryptedUserId']) {
                            $this->DSGSearchRes->userRateUrl = "//rate.taobao.com/user-rate-{$this->extParams['encryptedUserId']}.htm";
                        } else {
                            $encryptedUserId = DSGSeller::getEncryptedUserId($query['user_id']);
                            if ($encryptedUserId) {
                                $this->DSGSearchRes->userRateUrl = "//rate.taobao.com/user-rate-{$encryptedUserId}.htm";
                            }
                        }

                        $itemsList = $this->jsonObjGetByRulePath('parse_items_block', $jsonData);
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJson($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();

                        unset($data);
                        unset($info_data);
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    } elseif ($searchTemplateName == 'list.taobao.com') {
                        $resstr = array();
                        $res = $this->regexMatch('loaded_data_section', $data->body, $resstr);
                        if ($res > 0) {
                            $jsonData = $this->JavaScriptToJSON($resstr[1], true, true);
                        } else {
                            $this->DSGSearchRes->total_results = 0;
                            if (class_exists('Profiler', false)) {
                                Profiler::stop('DSGSearch->parse');
                            }
                            $this->DSGSearchRes->debugMessages = $this->debugMessages;
                            return $this->DSGSearchRes;
                        }
                        $itemsList = $res = $this->jsonObjGetByRulePath('parse_items_block', $jsonData);

                        $res = $this->jsonObjGetByRulePath('parse_items_count', $jsonData);
                        if ($res) {
                            $this->DSGSearchRes->total_results = DSGUtils::parseChineseNumber($res);
                        } else {
                            if (is_array($itemsList) && count($itemsList) > 0) {
                                $this->DSGSearchRes->total_results = count($itemsList);
                            } else {
                                $this->DSGSearchRes->total_results = 0;
                                if (class_exists('Profiler', false)) {
                                    Profiler::stop('DSGSearch->parse');
                                }
                                $this->DSGSearchRes->debugMessages = $this->debugMessages;
                                return $this->DSGSearchRes;
                            }
                        }
                        if (is_array($itemsList)) {
                            foreach ($itemsList as $item) {
                                $this->parseItemFromJsonList($item);
                            }
                        }
                        unset($itemsList);
                        $this->DSGSearchRes->intCategories = array();
                        $this->DSGSearchRes->intGroups = array();
                        $this->DSGSearchRes->intFilters = array();
                        $this->DSGSearchRes->intMultiFilters = array();
                        $this->DSGSearchRes->intSuggestions = array();
                        $this->DSGSearchRes->intPriceRanges = array();
                        if ($this->search_use_related_cats) {
                            $this->parseCategoriesFromJson2($jsonData);
                        }
                        if ($this->search_use_parsed_filters) {
                            $this->parseFiltersFromJson2($jsonData);
                        }
                        unset($resstr);
                        unset($this->searchParams);
                        unset($this->DSGSearchRes->html);
                        unset($jsonData);
                    }
        */
        if (is_array($this->DSGSearchRes->items) && (count($this->DSGSearchRes->items) <= 0)) {
            $this->DSGSearchRes->total_results = 0;
        }
        return $this->DSGSearchRes;
    }

    /** Локальная поисковая функция
     * @param string $mode - режим поиска, варианты: search, relatedBySeller, relatedByItem
     * @return customSearchResult Набор данных результатов поиска
     */
    public function execute()
    {
        Profiler::start('searchLocal->execute', true);
        //Точка входа в поиск
        $searchRes = $this->searchByParams(false);
        Profiler::start('searchLocal->prepareItemTitle');
        $seo_catalog_enabled = DSConfig::getVal('seo_catalog_enabled') == 1;
        $searchRes->breadcrumbs = $this->searchBreadcrumbs((isset($searchRes->viewUrl) ? $searchRes->viewUrl : ''));
        if ($searchRes->items && is_array($searchRes->items)) {
            static::prepareItemsTitle($this, $searchRes->items, $seo_catalog_enabled, $searchRes->breadcrumbs);
        }
        Profiler::stop('searchLocal->prepareItemTitle');
        Profiler::start('searchLocal->weightForArray');
        //Weights::getItemWeightForArray($searchRes);
        Profiler::stop('searchLocal->weightForArray');
        //TODO: fromAPI как-то расфиксить
        // if (!$fromAPI) {
        //TODO: Вроде бы всё делается потом в customSearch ?
        //Formulas::getUserPriceForArray($searchRes);
        //ItemFilters::checkForNotOnSale($searchRes);
        // }
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
        Profiler::stop('searchLocal->execute', true);
        if (isset($this->dsSrcLangQuery)) {
            $searchRes->dsSrcLangQuery = $this->dsSrcLangQuery;
        }
        return $searchRes;
    }

    public function searchByParams($extParams = false)
    {
        //TODO: Тут где-то различать поиск по категориям и полнотекст, и выставлять ds_source
        //if (!empty($this->params['nick']) || !empty($this->params['user_id'])) {
        $cacheParams = $this->prepareCacheParams($extParams);
        //set category id
        if (isset($this->params['cid'])) {
            if ($this->params['cid'] != '0') {
                $this->cat = $this->params['cid'];
            }
        }

        if ($cacheParams['query']) {
            $this->q = $cacheParams['query'];
        }

        if (isset($this->params['image']) && $this->params['image']) {
            $this->image = $this->params['image'];
        }

        if (isset($this->params['original'])) {
            if ($this->params['original'] == 'on') {
                $this->promotions = true;
            }
        }

        if ((!empty($this->params['recommend'])) && ($this->params['recommend'] == 1)) {
            $this->recommend = true;
        }
//====== Price safe mode ======
        if (isset($cacheParams['price_min'])) {
            $this->startPrice = $cacheParams['price_min'];
        }
        if (isset($cacheParams['price_max'])) {
            $this->endPrice = $cacheParams['price_max'];
        }
//=============================
        if (isset($this->params['props'])) {
            if (!empty($this->params['props'])) {
                $this->props = $this->params['props'];
            }
        }
        if (!empty($this->params['sort_by'])) {
            $this->sort = $this->params['sort_by'];
        }

        $this->extParams = $extParams;

        $this->_pageSize = self::getPageSize(
          $this->params['ds_source']
        ); //12
        $in_page_no = $this->params['page'];
        $this->pageNo = $in_page_no;
        $DSGSearchRes = $this->searchInDb($this->params['ds_source']);
        $searchRes = $this->postprocessSearchRes($DSGSearchRes);
//===== START Post-translations ========================================
        $this->postprocessTranslations($searchRes);
//===== END Post-translations ==========================================
        return $searchRes;
    }

    public static function getFeatured($type = 'popular', $count = false, $asArray = false)
    {
        $uid = -1;
        $types = ['popular', 'recommended', 'recentUser', 'recentAll'];
        if (Yii::app()->db->cache(YII_DEBUG ? 0 : 3600)->createCommand(
          "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 'orders_items'"
        )->queryRow()) {
            $notOnSaleSql =
              "(SELECT count(0) FROM orders_items oi0 WHERE oi0.iid=ii1.num_iid AND oi0.status IN (0) LIMIT 1)";
        } else {
            $notOnSaleSql = "0";
        }

        if (DSConfig::getVal('local_shop_mode') == 'only') {
            $dsFilter = " LIKE 'local_%' ";
        } elseif (DSConfig::getVal('local_shop_mode') == 'off') {
            $dsFilter = " NOT LIKE 'local_%' ";
        } else {
            $dsFilter = ' IS NOT NULL ';
        }

        if (in_array($type, ['popular', 'recentAll'])) {
            $cacheDuration = 1800;
        } else {
            $cacheDuration = 60;
        }
        /** @noinspection PhpUndefinedFieldInspection */
        $demo = (preg_match('/dspromo/is', Yii::app()->theme->name) ? 1 : 0);
        $dataProvider = false;
        if (!$count) {
            $featured_on_main_items_count = (int) DSConfig::getVal('featured_on_main_items_count');
        } else {
            $featured_on_main_items_count = $count;
        }
        $page = 0;
        foreach ($types as $searchType) {
            if (isset($_GET[$searchType . '_dataProvider_page'])) {
                $page = $_GET[$searchType . '_dataProvider_page'];
                break;
            }
        }
        if ($page > round($featured_on_main_items_count * 100)
        ) {
            return $dataProvider;
        }
        try {
            $fromDateString = date("d.m.Y", time() - 3600 * 24 * ($demo ? 30 : 7));
//TODO: Ниже в SQL-запросах перепродумать подзапрос in classifier
            if ($type == 'popular') {

                $countTotalCmd = Yii::app()->db->cache($cacheDuration)->createCommand(
                  "SELECT count(0) AS cnt FROM
(SELECT 1 /* count(0) AS cnt, max(ii1.date) as last_date */
FROM log_item_requests ii1
WHERE ii1.date > to_timestamp('" . $fromDateString . "','DD.MM.YYYY') AND
(ii1.ds_source, ii1.cid) IN (SELECT cc.ds_source, cc.cid FROM classifier cc WHERE cc.cid!='0' 
 AND (cc.ds_source $dsFilter)
) 
AND (ii1.uid<>-1 OR :demo=1)
GROUP BY ii1.ds_source, ii1.cid, ii1.num_iid
 HAVING -- 1 max(ii1.date) = last_date and
 (count(0)>2 OR :demo=1)
  ) rr /*popular count*/"
                );
                $sql = "SELECT rr1.not_on_sale, rr1.cnt, rr1.last_date, rr2.* FROM
(SELECT 
{$notOnSaleSql} AS not_on_sale, 
count(0) AS cnt, max(ii1.date) AS last_date, max(ii1.id) as id FROM log_item_requests ii1
WHERE ii1.date > to_timestamp('" . $fromDateString . "','DD.MM.YYYY') AND
(ii1.ds_source, ii1.cid) IN (SELECT cc.ds_source, cc.cid FROM classifier cc WHERE cc.cid!='0' 
 AND (cc.ds_source $dsFilter)
)
AND (ii1.uid<>-1 OR :demo=1)
GROUP BY ii1.ds_source, ii1.cid, ii1.num_iid
 HAVING -- 2 max(ii1.date) = last_date and
 (count(0)>2 OR :demo=1)
ORDER BY cnt DESC, last_date DESC  /*popular*/ ) rr1, log_item_requests rr2
WHERE rr1.id = rr2.id";
            } elseif ($type == 'recentAll') {
                /** @noinspection PhpUndefinedFieldInspection */
                if (Yii::app()->user->role == 'guest') {
                    $uid = -1;
                } else {
                    /** @noinspection PhpUndefinedFieldInspection */
                    $uid = Yii::app()->user->id;
                }
                $countTotalCmd = Yii::app()->db->cache($cacheDuration)->createCommand(
                  "SELECT count(0) AS cnt FROM
(SELECT 1 /* count(0) AS cnt, max(ii1.date) as last_date */
FROM log_item_requests ii1
WHERE ii1.date > to_timestamp('" . $fromDateString . "','DD.MM.YYYY') AND
(ii1.ds_source, ii1.cid) IN (SELECT cc.ds_source, cc.cid FROM classifier cc WHERE cc.cid!='0' AND (cc.ds_source $dsFilter)) 
AND (ii1.uid!=:uid OR :demo=1) AND (ii1.uid<>-1 OR :demo=1)
GROUP BY ii1.ds_source, ii1.cid, ii1.num_iid
-- having 3 max(ii1.date) = last_date
 ) gg  /*recent all count*/"
                )
                  ->bindParam(':uid', $uid, PDO::PARAM_INT)
                  ->bindParam(':demo', $demo, PDO::PARAM_INT);

                $sql = "SELECT rr1.not_on_sale, rr1.cnt, rr1.last_date, rr2.* FROM
(SELECT 
{$notOnSaleSql} AS not_on_sale, 
count(0) AS cnt, max(ii1.date) AS last_date, max(ii1.id) as id FROM log_item_requests ii1
WHERE ii1.date > to_timestamp('" . $fromDateString . "','DD.MM.YYYY') AND
(ii1.ds_source, ii1.cid) IN (SELECT cc.ds_source, cc.cid FROM classifier cc WHERE cc.cid!='0' AND (cc.ds_source $dsFilter)) 
AND (ii1.uid!=:uid OR :demo=1) AND (ii1.uid<>-1 OR :demo=1)
GROUP BY ii1.ds_source, ii1.cid, ii1.num_iid
-- having 4 max(ii1.date) = last_date
ORDER BY last_date DESC  /*recent all*/) rr1, log_item_requests rr2
WHERE rr1.id = rr2.id";
            } elseif ($type == 'recentUser') {
                /** @noinspection PhpUndefinedFieldInspection */
                $uid = Yii::app()->user->id;
                $countTotalCmd = Yii::app()->db->cache($cacheDuration)->createCommand(
                  "SELECT count(0) AS cnt FROM
(SELECT 1 /* count(0) AS cnt, max(ii1.date) as last_date */
FROM log_item_requests ii1
WHERE ii1.date > to_timestamp('" . $fromDateString . "','DD.MM.YYYY') AND
(ii1.ds_source, ii1.cid) IN (SELECT cc.ds_source, cc.cid FROM classifier cc WHERE cc.cid!='0' AND (cc.ds_source $dsFilter)) 
AND (:uid<>-1 OR :demo=1) AND (ii1.uid=:uid OR :demo=1)
GROUP BY -- ii1.cid,
ii1.ds_source, ii1.num_iid
-- having 5 max(ii1.date) = last_date
 ) gg  /*recent user count*/"
                )
                  ->bindParam(':uid', $uid, PDO::PARAM_INT)
                  ->bindParam(':demo', $demo, PDO::PARAM_INT);

                $sql = "SELECT rr1.not_on_sale, rr1.cnt, rr1.last_date, rr2.* FROM
(SELECT 
{$notOnSaleSql} AS not_on_sale, 
count(0) AS cnt, max(ii1.date) AS last_date, max(ii1.id) as id FROM log_item_requests ii1
WHERE ii1.date > to_timestamp('" . $fromDateString . "','DD.MM.YYYY') AND
(ii1.ds_source, ii1.cid) IN (SELECT cc.ds_source, cc.cid FROM classifier cc WHERE cc.cid!='0' AND (cc.ds_source $dsFilter)) 
AND (:uid<>-1 OR :demo=1) AND (ii1.uid=:uid OR :demo=1)
GROUP BY -- ii1.cid,
ii1.ds_source, ii1.num_iid
-- having 6 max(ii1.date) = last_date
ORDER BY last_date DESC  /*recent user*/) rr1, log_item_requests rr2
WHERE rr1.id = rr2.id";

            } elseif ($type == 'recommended') {

                $countTotalCmd = Yii::app()->db->cache($cacheDuration)->createCommand(
                  "SELECT count(0) AS cnt FROM featured ii1
                          WHERE (ii1.ds_source $dsFilter)
                        "
                )//          ->bindParam(':uid', $uid, PDO::PARAM_INT)
                ;

                $sql = "SELECT  
{$notOnSaleSql} AS not_on_sale, 
ii1.num_iid AS id, ii1.* FROM featured ii1 
WHERE (ii1.ds_source $dsFilter)
ORDER BY date DESC";
            } else {
                return false;
            }
            if ($asArray) {
                $dataProvider = Yii::app()->db->cache($cacheDuration)
                  ->createCommand($sql . ' LIMIT ' . $count)
                  ->queryAll();
            } else {
                $params = [];
                if (preg_match('/:uid/is', $countTotalCmd->text)) {
                    $params[':uid'] = $uid;
                }
                if (preg_match('/:demo/is', $countTotalCmd->text)) {
                    $params[':demo'] = $demo;
                }
                $countTotal = (int) $countTotalCmd->queryScalar($params);
                $params = [];
                if (preg_match('/:uid/is', $sql)) {
                    $params[':uid'] = $uid;
                }
                if (preg_match('/:demo/is', $sql)) {
                    $params[':demo'] = $demo;
                }
                $dpParams = [
                  'params'         => $params,
                  'id'             => $type . '_dataProvider',
                  'keyField'       => 'id',
                  'totalItemCount' => min($countTotal, round($featured_on_main_items_count * 100)),
                  'pagination'     => [
                    'pageSize' => $featured_on_main_items_count,
                  ],
                ];

                /** @noinspection PhpUndefinedFieldInspection */
                if (preg_match('/bot|\+http/i', Yii::app()->request->userAgent) && Yii::app()->user->isGuest) {
                    $dpParams['pagination'] = null;
                    $dpParams['totalItemCount'] = $featured_on_main_items_count;
                }
                $dataProvider = new CSqlDataProvider(
                  Yii::app()->db->cache($cacheDuration)->createCommand($sql),
                  $dpParams
                );
            }
        } catch (Exception $e) {
            return false;
        }
        $data = $dataProvider->getData();
        if (is_array($data)) {
            $dataCount = count($data);
            for ($i = 0; $i < $dataCount; $i = $i + 1) {
                $data[$i] = new customSearchItemResult($data[$i], false);
            }
            Profiler::start('searchLocal->prepareItemTitle');
            $seo_catalog_enabled = DSConfig::getVal('seo_catalog_enabled') == 1;
            if (is_array($data)) {
                static::prepareItemsTitle(null, $data, $seo_catalog_enabled, []);
            }
            Profiler::stop('searchLocal->prepareItemTitle');
            //Formulas::getUserPriceForArray($data);
            //Weights::getItemWeightForArray($data);
            $dataProvider->setData($data);
        }
        return $dataProvider;
    }
}