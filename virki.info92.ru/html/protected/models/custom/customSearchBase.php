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

/**
 * @property mixed    dsSrcLang
 * @property Category $cid_model
 */
abstract class customSearchBase extends customSearchBaseProps
{
    public $dsSrcLangQuery = '';

    public abstract function execute();

    /**
     * @param $DSGSearchRes
     * @return customSearchResult
     */
    protected function postprocessSearchRes($DSGSearchRes)
    {
        $searchRes = new customSearchResult();
        if (isset($DSGSearchRes->viewUrl)) {
            $searchRes->viewUrl = $DSGSearchRes->viewUrl;
        }
        if ($DSGSearchRes == 'ERROR') {
            $searchRes->error = 'ERROR';
        } elseif ($DSGSearchRes == 'antiSpider') {
            $searchRes->error = 'antiSpider';
        }
        if (isset($this->params['cid_query'])) {
            $searchRes->query = $this->params['cid_query'];
        }
        if (isset($this->params['query'])) {
            $searchRes->query = $searchRes->query . ' ' . $this->params['query'];
        }
        $searchRes->query = trim($searchRes->query);
        if (isset($this->params['cid'])) {
            $searchRes->cid = $this->params['cid'];
        }
        $searchRes->search_type = 'searchDSG';
        $searchRes->pageSize = 25; //$this->dsSource->dsSourcePageSize;
        $searchRes->searchSortParameters = [];//$this->dsSource->searchSortParameters;
        $searchRes->ds_sources = $this->dsSources;
        if ((isset($DSGSearchRes->items)) && (isset($DSGSearchRes->total_results))) {
            $searchRes->total_results = (integer) $DSGSearchRes->total_results;
            if (isset($DSGSearchRes->userRateUrl)) {
                $searchRes->userRateUrl = $DSGSearchRes->userRateUrl;
            }
            if ($searchRes->total_results > 0) {
                foreach ($DSGSearchRes->items as $item) {
                    if (is_a($item, 'customSearchItemResult')) {
                        $searchRes->items[] = clone $item;
                    } else {
                        $searchRes->items[] = new customSearchItemResult($item, false);
                    }
                }
                unset($item);
                if (in_array($this->searchType, ['search'])) {
                    $searchRes->cids = $DSGSearchRes->intCategories;
                    //$searchRes->bids = array();
                    $searchRes->groups = $DSGSearchRes->intGroups;
                    $searchRes->filters = $DSGSearchRes->intFilters;
                    $searchRes->multiFilters = $DSGSearchRes->intMultiFilters;
                    /** @noinspection PhpUndefinedFieldInspection */
                    if (!Yii::app()->user->isGuest) {
                        $searchRes->suggestions = $DSGSearchRes->intSuggestions;
                    } else {
                        $searchRes->suggestions = [];
                    }
                    $searchRes->priceRange = $DSGSearchRes->intPriceRanges;
                }
//-----------------
                $queryToPriceRanges =
                  (isset($this->params['query']) && isset($this->params['query']) ? $this->params['query'] : '') .
                  (isset($this->params['cid_query']) && isset($this->params['cid_query']) ? $this->params['cid_query'] :
                    '');
                if (($this->params['page'] == 1) && isset($this->params['cid']) && in_array(
                    $this->searchType,
                    ['search']
                  )
                ) {
                    CategoriesPrices::savePriceRanges(
                      $this->dsSource->dsSourceGroup,
                      $this->params['cid'],
                      $queryToPriceRanges,
                      $searchRes->priceRange
                    );
                }
//-----------------
            }
        } else {
            $searchRes->total_results = 0;
        }
        return $searchRes;
    }

    /**
     * @param $searchRes
     */
    protected function postprocessTranslations(&$searchRes)
    {
        //TODO: Переписать - научить потом Yii::app()->DVTranslator->translateArray понимать $item->dsSrcLang
        // Уже научили. Может на самом деле тут нужно будет научить понимать и язык.
        Profiler::start('Cids->translate');
        /** @noinspection PhpUndefinedFieldInspection */
        Yii::app()->DVTranslator->translateArray(
          $searchRes->cids,
          'title',
          false,
          false,
          'category',
          $this->dsSrcLang,
          Utils::appLang()
        );
        Profiler::stop('Cids->translate');

        Profiler::start('Groups->translate');
        /** @noinspection PhpUndefinedFieldInspection */
        Yii::app()->DVTranslator->translateArray(
          $searchRes->groups,
          'title',
          'values',
          'values_title',
          'prop,propval',
          $this->dsSrcLang,
          Utils::appLang()
        );
        Profiler::stop('Groups->translate');
        Profiler::start('Filters->translate');
        /** @noinspection PhpUndefinedFieldInspection */
        Yii::app()->DVTranslator->translateArray(
          $searchRes->filters,
          'title',
          'values',
          'values_title',
          'prop,propval',
          $this->dsSrcLang,
          Utils::appLang()
        );
        Profiler::stop('Filters->translate');
        Profiler::start('multiFilters->translate');
        /** @noinspection PhpUndefinedFieldInspection */
        Yii::app()->DVTranslator->translateArray(
          $searchRes->multiFilters,
          'title',
          'values',
          'values_title',
          'prop,propval',
          $this->dsSrcLang,
          Utils::appLang()
        );
        Profiler::stop('multiFilters->translate');
//===================================================
// Sort and truncate arrays
//---------------------------------------------------
        /*    if (!function_exists('compareByValueTitle')) {
              function compareByValueTitle($a, $b) {
                $a_val = $a->values_title;
                $b_val = $b->values_title;
                return strcmp($a_val, $b_val);
              }
            }
            if (isset(end($this->DSGSearchRes->intMultiFilters)->values)) {
              uasort(end($this->DSGSearchRes->intMultiFilters)->values, "compareByValueTitle");
            }
        */
//===================================================
        Profiler::start('Suggestions->translate');
        /** @noinspection PhpUndefinedFieldInspection */
        Yii::app()->DVTranslator->translateArray(
          $searchRes->suggestions,
          'title',
          false,
          false,
          '*',
          $this->dsSrcLang,
          Utils::appLang()
        );
        Profiler::stop('Suggestions->translate');
    }

    /**
     * @param bool $extParams
     * @return array
     */
    protected function prepareCacheParams($extParams = false)
    {
        //$search_DropShop_grabbers_debug = DSConfig::getVal('search_DropShop_grabbers_debug') == 1;
// Filling parameters
        $cacheParams = $this->params;
        $query = '';
        if (isset($this->params['query'])) {
            $query = $this->prepareSearchQuery($this->params['query'], true);
        }
        if (isset($this->params['search_filter'])) {
            $query = trim($this->params['search_filter'] . ' ' . $query);
            unset($this->params['search_filter']);
        }
        if ($extParams) {
            $cacheParams = array_merge($cacheParams, $extParams);
        }

        if (isset($cacheParams['similarPath']) && ($cacheParams['similarPath'] != false)) {
            $query = trim($query . '&' . urldecode($cacheParams['similarPath']));
        }

        $cacheParams['query'] = $query;
//====== Price safe mode ======
        $search_price_min = DSConfig::getValDef('search_price_min', 0);
        if (!empty($this->params['price_min'])) {
            $startPrice = $this->params['price_min'];
        } else {
            if (DSConfig::getValDef('search_use_safe_price_ranges', 0) == 1) {
                $startPrice = max(0.1, $search_price_min);
            } else {
                $startPrice = 0;
            }
        }

        if (!empty($this->params['price_max'])) {
            $endPrice = $this->params['price_max'];
        } else {
            if (DSConfig::getValDef('search_use_safe_price_ranges', 0) == 1) {
                $endPrice = 999999;
            } else {
                $endPrice = 0;
            }
        }
        if (DSConfig::getValDef('search_use_safe_price_ranges', 0) == 1
          && isset($this->params['sort_by']) && in_array($this->params['sort_by'], ['price_asc', 'price_desc'])
        ) {
            $cat = '';
            if (isset($this->params['cid'])) {
                if ($this->params['cid'] != '0') {
                    $cat = $this->params['cid'];
                }
            }
            $q = '';
            if ($cacheParams['query']) {
                $q = $cacheParams['query'];
            }
            if (DSConfig::getValDef('search_use_safe_price_ranges', 0) == 1) {
                [$minPrice, $maxPrice] = CategoriesPrices::getPricesRangeForSearch(
                  $this->dsSource->dsSourceGroup,
                  $cat,
                  $q
                );
                $startPrice = max($startPrice, $minPrice);
                $endPrice = min($endPrice, $maxPrice);
                $startPrice = max(0.1, $startPrice, $search_price_min);
                if ($endPrice <= $startPrice) {
                    $endPrice = 999999;
                }
            }
        }
//TODO: потом убрать, так как есть вариант отключения (DSConfig::getVal('search_use_safe_price_ranges')==1)
        if ($startPrice != 0.1) {
            $cacheParams['price_min'] = $startPrice;
        }
        if ($endPrice != 999999) {
            $cacheParams['price_max'] = $endPrice;
        }
        return $cacheParams;
    }

    /**
     * @param string $query
     * @param bool   $extOutput
     * @return string
     */
    protected function prepareSearchQuery($query, $extOutput = false)
    {
        return null;
        Profiler::start('search->prepareSearchQuery');
//== query check for eval end other pre-validations ============================
        if (preg_match(
          '/(?:eval\s*\()|(?:(?:select|delete|insert|update|truncate|drop|alter).+(?:(?:from|into|table|database|trigger|index)))/is',
          $query
        )) {
            $query = '';
        }
        if (mb_strlen($query, 'UTF-8') > 64) {
            $query = mb_substr($query, 0, 64, 'UTF-8');
            $query = preg_replace('/^(.{1,64})?\s+.*/is', '\1', $query);
        }
//== end of query check for eval end other pre-validations =====================
        $lang = Utils::appLang();//Utils::TransLang();

        $query = trim(preg_replace(DSConfig::getVal('stoplist_search'), '', $query));
        $query = Utils::translateFuzzyBrand($query);
        //TODO: Тут что-то поделать потом с dsSrcLang
        if (preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $query) && ($lang == 'zh')) {
            $res = trim($query);
        } elseif ((!preg_match("/[а-я]{1}/ui", $query)) && ($lang == 'ru')) {
            $res = trim(strtoupper($query));
        } elseif ((!preg_match("/[a-z]{1}/ui", $query)) && ($lang == 'en')) {
            $res = trim(strtoupper($query));
        } elseif (preg_match(
            '/\b' . str_replace('/', '\/', $query) . '\b/i',
            DSConfig::getVal('stoplist_translator')
          ) > 0
        ) {
            $res = trim(strtoupper($query));
        } else {
            /** @noinspection PhpUndefinedFieldInspection */
            $dsSrcLangQueryRes = trim(
              Yii::app()->DVTranslator->translateQuery(
                $query,
                $lang,
                ($this->dsSrcLang ? $this->dsSrcLang : 'zh-CN'),
                !$extOutput
              )
            ); //TRUE, FALSE,
            $res = Utils::removeOnlineTranslation($dsSrcLangQueryRes);
            if (!$extOutput) {
                $dsSrcLangQueryRes = $res;
            } else {
                $dsSrcLangQueryRes = PostprocessFilter::renderTranslation($dsSrcLangQueryRes, 'Q', false);
            }
        }
//============= Работаем с виртуальными категориями
        $haveCidQuery = (isset($this->params['cid_query']) && ($this->params['cid_query'] != ''));
        if ($haveCidQuery) {
            $res = trim((trim($this->params['cid_query']) . ' ' . trim($res)));
        }
//============= Работаем со свойствами
        if ($this->dsSrcLang == 'zh') {
            $useContextualPropsSearch = DSConfig::getValDef('search_useContextualPropsSearch', 0) == 1;
            if ($useContextualPropsSearch) {
                if (!empty($this->params['props'])) {
                    $pidsvids = explode(';', preg_replace('/%3b|%2c/i', ';', $this->params['props']));
                    $pids = '';
                    $vids = '';
                    foreach ($pidsvids as $pidvid) {
                        if ($pidvid != '') {
                            $pidvidarray = explode(':', str_replace('%3A', ':', $pidvid));
                            $pids .= $pidvidarray[0] . ',';
                            $vids .= $pidvidarray[1] . ',';
                        }
                    }
                    $pids = substr($pids, 0, -1);
                    $vids = substr($vids, 0, -1);
                    if (!$pids) {
                        $pids = 'null';
                    }
                    if (!$vids) {
                        $vids = 'null';
                    }
//======
                    $command = Yii::app()->db->createCommand(
                      "
 SELECT DISTINCT vv.ZH FROM classifier_props_vals vv
WHERE vv.PID IN (" . $pids . ") AND vv.VID IN (" . $vids . ") AND vv.ZH IS NOT NULL AND vv.ZH<>''"
                    );
                    $rows = $command->queryAll();
                    $props_zh = '';
                    foreach ($rows as $row) {
                        $props_zh .= trim($row['ZH']) . ' ';
                    }
                    $props_zh = substr($props_zh, 0, -1);
                    if ($props_zh != '') {
                        $res = trim($res) . ' ' . trim($props_zh);
                    }
//======
                }
            }
        }
//====================================
        Profiler::stop('search->prepareSearchQuery');
//====================================
        if ($res == '') {
            return false;
        } else {
            if (isset($dsSrcLangQueryRes)) {
                $this->dsSrcLangQuery = $dsSrcLangQueryRes;
            }
            return trim($res);
        }
    }

    /**
     * @return string
     */
    public function getDsSrcLang()
    {
        if ($this->dsSource) {
            return $this->dsSource->dsSourceLang;
        } else {
            return 'zh';
        }
    }

    /**
     * @param string $viewUrl
     * @return array
     */
    public function searchBreadcrumbs($viewUrl = '')
    {
        $breadcrumbs = [];
        if (false &&
          isset($this->params['ds_source']) &&
          isset($this->params['cid']) &&
          isset($this->params['query'])) {
            $model = MainMenu::model()->find(
              'ds_source=:ds_source AND cid=:cid AND query = :query AND status!=0',
              [
                ':ds_source' => $this->params['ds_source'],
                ':cid'       => $this->params['cid'],
                ':query'     => (isset($this->params['cid_query']) && $this->params['cid_query'] ?
                  $this->params['cid_query'] : ''),
              ]
            );
        } else {
            $model = false;
        }
        /* if (!$model) {
            $model = Category::model()->find(
              'ds_source=:ds_source AND cid=:cid AND status!=0 AND is_parent=0',
              array(
                ':ds_source' => $this->params['ds_source'],
                ':cid' => $this->params['cid'],
              )
            );
        } */
        /*        if (!$model) {
                    //TODO: Посмотреть, разобраться
                  return $breadcrumbs;
                }
        */
        if ($model) {
            if (isset($model->parent) && isset($model->cid)) {
                //Генерируем хлебные крошки
                $cat = new stdClass();
                $cat->cid = $model->cid;
                $cat->url = '';//MainMenu::getUrl($model);
                $cat->parent = $model->parent;
                if (Utils::appLang() == Utils::transLang(Utils::appLang())) {
                    $cat->name = $model->{Utils::transLang()};
                } else {
                    $cat->name = Yii::t(
                      '~category',
                      ($this->dsSrcLang ? $this->dsSrcLang : ($model->zh ? $model->zh : $model->ru))
                    ); //$model->{Utils::TransLang()};
                }
                $parents = [];//array_reverse(MainMenu::getParents($cat, array($cat), 1));
                foreach ($parents as $category) {
                    $breadcrumbs[$category->name] = Yii::app()
                      ->createUrl('/category/index', ['name' => $category->url]);
                }
            }
        }
        /** @noinspection PhpUndefinedFieldInspection */
        if ($viewUrl && Yii::app()->user->inRole('superAdmin')) {
            $breadcrumbs[Yii::t('main', 'Источник')] = $viewUrl;
        }
        return $breadcrumbs;
    }

    /**
     * @param array $searchResItems
     */
    protected static function getItemsCidsFromDb(array $searchResItems)
    {
        if (!count($searchResItems)) {
            return;
        }
        $cidsArray = [];
        foreach ($searchResItems as $searchResItem) {
            if ($searchResItem->cid != '0') {
                continue;
            }
            $cidsArray[] = "('$searchResItem->ds_source','$searchResItem->num_iid')";
        }
        if (!count($cidsArray)) {
            return;
        }
        $cidsQuery = implode(',', $cidsArray);
        $sql = "SELECT rr.ds_source,rr.num_iid, MAX(rr.cid) as cid FROM 
                (
                 SELECT ii1.ds_source, ii1.num_iid, MAX(ii1.cid) as cid FROM log_items_requests ii1 
                 WHERE ii1.cid != '0' AND (ii1.ds_source,ii1.num_iid) IN ($cidsQuery) 
                 GROUP BY ii1.ds_source,ii1.num_iid
                 UNION ALL 
                 SELECT ii2.ds_source, ii2.num_iid, MAX(ii2.cid) as cid FROM log_item_requests ii2 
                 WHERE ii2.cid != '0' AND (ii2.ds_source,ii2.num_iid) IN ($cidsQuery) 
                 GROUP BY ii2.ds_source,ii2.num_iid
                 ) rr
                 GROUP BY rr.ds_source,rr.num_iid";
        $records = Yii::app()->db->createCommand($sql)->queryAll();
        if (!$records) {
            return;
        }
        foreach ($records as $record) {
            foreach ($searchResItems as &$searchResItem) {
                if ($searchResItem->cid != '0') {
                    continue;
                }
                if ($searchResItem->ds_source == $record['ds_source'] &&
                  $searchResItem->num_iid == $record['num_iid']) {
                    $searchResItem->cid = $record['cid'];
                    break;
                }
            }
        }
    }

    /**
     * @param array   $searchResItems
     * @param boolean $seo_catalog_enabled
     * @param array   $breadcrumbs
     */
    protected static function prepareItemsTitle(
      $searchBaseObject,
      array $searchResItems,
      $seo_catalog_enabled,
      $breadcrumbs
    ) {
        if (!count($searchResItems)) {
            return;
        }
        $cidsArray = [];
        $langsArray = [];
        $langsNamesArray = [];
        foreach ($searchResItems as $searchResItem) {
            if ($searchResItem->cid == '0') {
                continue;
            }
            $cidsArray[] = "('$searchResItem->ds_source','$searchResItem->cid')";
            //TODO Тут как-то язык по сорсу определять, да ваще и не тут даже может,а в предке
            $lang =
              'ru';//Utils::transLang(DSConfig::getDsSourceParam($searchResItem->ds_source,'srcLang')); //Utils::transLang($searchResItem->dsSrcLang);
            $langsNamesArray[] = $lang;
            $langsArray[] = "MAX($lang) as $lang";
        }

//                        $category = Yii::app()->db->createCommand(
//                          "SELECT {$_lang} FROM classifier WHERE ds_source = :ds_source and cid=:cid LIMIT 1"
//                        )
//                          ->queryScalar(array(':ds_source' => $dsSourceGroup, ':cid' => $searchResItem->cid));
        $langsArray = array_unique($langsArray);
        $langsNamesArray = array_unique($langsNamesArray);

        if (count($cidsArray) && count($langsArray)) {
            $cidsQuery = implode(',', $cidsArray);
            $langsQuery = implode(',', $langsArray);
            $sql = "SELECT cc.ds_source, cc.cid, $langsQuery FROM classifier cc 
                 WHERE (cc.ds_source,cc.cid) IN ($cidsQuery) 
                 GROUP BY cc.ds_source, cc.cid";
            $categoriesRecs = Yii::app()->db->createCommand($sql)->queryAll();
            $categories = [];
            foreach ($categoriesRecs as $categoriesRec) {
                if (!isset($categories[$categoriesRec['ds_source']])) {
                    $categories[$categoriesRec['ds_source']] = [];
                }
                if (!isset($categories[$categoriesRec['ds_source']][$categoriesRec['cid']])) {
                    $categories[$categoriesRec['ds_source']][$categoriesRec['cid']] = [];
                }
                foreach ($langsNamesArray as $langName) {
                    $categories[$categoriesRec['ds_source']][$categoriesRec['cid']][$langName] =
                      $categoriesRec[$langName];
                }
            }
        }

        foreach ($searchResItems as $searchResItem) {
// =========== init ============
            $searchResItem->title = new dvString(
              'Подробно о товаре, выбор дополнительных свойств товара, оформление заказа...', 'ru'
            );
            $searchResItem->title->translation = Yii::t(
              'main',
              'Подробно о товаре, выбор дополнительных свойств товара, оформление заказа...',
              'ru'
            );
            $searchResItem->alt = new dvString(
              'Подробно о товаре, выбор дополнительных свойств товара, оформление заказа...', 'ru'
            );
            $searchResItem->alt->translation = Yii::t(
              'main',
              'Подробно о товаре, выбор дополнительных свойств товара, оформление заказа...',
              'ru'
            );
            if (isset($searchResItem->ds_source)) {
                $dsSourceGroup = $searchResItem->ds_source;
            } elseif ($searchBaseObject && isset($searchBaseObject->dsSource->dsSourceGroup)) {
                $dsSourceGroup = $searchBaseObject->dsSource->dsSourceGroup;
            } else {
                $dsSourceGroup = false;
            }

// =========== title ===========
            if ($seo_catalog_enabled && $dsSourceGroup) {
                $titleFromItem = '';
                $titleFromItemShort = '';
                $titleFromCategory = '';
                $titleFromBrand = '';
                $titleToProceed = '';
                if (isset($searchResItem->name) && $searchResItem->name) {
                    $titleFromItem = preg_replace('/<.*?>/', '', $searchResItem->name->source);
                    if (preg_match('/^local_.+/i', $searchResItem->ds_source)) {
                        $titleFromItemShort = $titleFromItem;
                    } else {
                        if (preg_match_all('/<span\s.*?>(.+?)<\/span>/is', $searchResItem->name->source, $matches)) {
                            $words = array_unique($matches[1]);
                            $titleFromItemShort = implode('', $words);
                        }
                    }
                    // Если раскомменчено - приводит к дополнительным нагрузкам на переводчик
                    /* else {
                        $shortTitle = $searchResItem->srcLangTitle;
                    } */
                }
                if (!$titleFromItemShort) {
                    if (isset($searchResItem->cid) && $searchResItem->cid != '0') {
                        $lang = 'ru';//DSConfig::getDsSourceParam($searchResItem->ds_source,'srcLang');
                        //TODO Тут как-то язык по сорсу определять, да ваще и не тут даже может,а в предке
                        if (isset($categories) && isset($categories[$dsSourceGroup][$searchResItem->cid][$lang])) {
                            $titleFromCategory = $categories[$dsSourceGroup][$searchResItem->cid][$lang];
                        }
                        if (!$titleFromCategory && $breadcrumbs and count($breadcrumbs) > 1) {
                            foreach ($breadcrumbs as $catName => $breadcrumb) {
                                if ($breadcrumb != end($breadcrumbs)) {
                                    $titleFromCategory = $titleFromCategory . ', ' . $catName;
                                }
                            }
                        }
                    }
                    if (!$titleFromCategory && preg_match(
                        '/\/brand\/(.+)/i',
                        Yii::app()->request->getRequestUri(),
                        $matches
                      )
                    ) {
                        $brandUrl = $matches[1];
                        $brand = Yii::app()->db->createCommand("SELECT name FROM brands WHERE url=:url LIMIT 1")
                          ->queryScalar([':url' => $brandUrl]);
                        if ($brand) {
                            $searchResItem->title->translation = $brand;
                            $searchResItem->alt->translation = $brand;
                            return;
                        }
                    }
                }
                if ($titleFromItemShort) {
                    $titleToProceed = $titleFromItemShort;
                } elseif ($titleFromCategory) {
                    $titleToProceed = $titleFromCategory;
                } elseif ($titleFromBrand) {
                    $titleToProceed = $titleFromBrand;
                } elseif ($titleFromItem) {
                    $titleToProceed = $titleFromItem;
                }

                $titleToProceed = trim($titleToProceed, ', ');
                $searchResItem->title->source = $titleToProceed;
                $searchResItem->title->sourceLang =
                  ($searchResItem->srcLanguage ? $searchResItem->srcLanguage :
                    'ru'/* DSConfig::getDsSourceParam($searchResItem->ds_source,'srcLang')*/);
                /** @noinspection PhpUndefinedFieldInspection */
                $searchResItem->title->translation = trim(
                  Yii::app()->DVTranslator->translateHtmlProperty(
                    $titleToProceed,
                    ($searchResItem->srcLanguage ? $searchResItem->srcLanguage :
                      'ru'/* DSConfig::getDsSourceParam($searchResItem->ds_source,'srcLang') */),
                    Utils::appLang()
                  )
                );
                $searchResItem->alt->source = $searchResItem->title->source;
                $searchResItem->alt->translation = (string) $searchResItem->title;
                /** @noinspection PhpUndefinedFieldInspection */
                /* $searchResItem->html_alt = trim(
                  Yii::app()->DVTranslator->translateHtmlProperty(
                    $titleToProceed,
                    $searchResItem->dsSrcLang,
                    Utils::appLang()
                  )
                );
                */
            }
        }
    }

    /**
     * @param string $ds_source
     * @return int
     */
    public static function getPageSize($ds_source = false)
    {
        return 25;
        $found = null;
        $grabbersXml = DSConfig::getDSGParserXMLByName('search_DropShop_grabbers');
        if ($ds_source) {
            $xpath =
              "//parser_section[enabled = 1 and default = 1 and subtype = 'search' and ds_sources[ds_source = '{$ds_source}']]";
            $found = $grabbersXml->xpath($xpath);
        }
        if (!$found || !count($found)) {
            if (DSConfig::getVal('local_shop_mode') == 'off') {
                $xpath = "//parser_section[enabled = 1 and default = 1 and subtype = 'search' and  type != 'local']";
            } elseif (DSConfig::getVal('local_shop_mode') == 'only') {
                $xpath = "//parser_section[enabled = 1 and default = 1 and subtype = 'search' and type = 'local']";
            } else {
                $xpath = "//parser_section[enabled = 1 and default = 1 and subtype = 'search']";
            }
            $found = $grabbersXml->xpath($xpath);
        }
        if ($found && count($found)) {
            if (!function_exists('cmpDsSources')) {
                function cmpDsSources($a, $b)
                {
                    if (DSConfig::getVal('local_shop_mode') != 'off') {
                        if ((string) $a->type == 'local') {
                            return -1;
                        } else {
                            return 1;
                        }
                    } else {
                        if ((int) $a->default == (int) $b->default) {
                            return 0;
                        }
                        return ((int) $a->default < (int) $b->default) ? 1 : -1;
                    }
                }
            }
            usort($found, 'cmpDsSources');
            return (integer) $found[0]->pageSize;
        } else {
            return (integer) DSConfig::getVal('search_ItemsPerPageDefault');
        }
    }
}