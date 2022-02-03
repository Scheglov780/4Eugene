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

class customSearchRemote extends SearchBase
{

    private function searchByParams($extParams = false)
    {
        $search_DropShop_grabbers_debug = DSConfig::getVal('search_DropShop_grabbers_debug') == 1;
//== Prepare search_filter params =========================================
        $search_filter = DSConfig::getVal('search_filter');
        if ($search_filter !== '') {
            parse_str($search_filter, $args);
            if (isset($args['q'])) {
                if (is_array($this->params)) {
                    $this->params['search_filter'] = $args['q'];
                }
            }
            unset ($args);
        }
        unset($search_filter);
//local_shop_mode
//=========================================
        $cacheParams = $this->prepareCacheParams();
        //=========================================
        /** @noinspection PhpUndefinedFieldInspection */
        /** @noinspection PhpUsageOfSilenceOperatorInspection */
        $cache = @Yii::app()->fileCache->get('DSG_search-' . Utils::array2string($cacheParams));
        // Начало собственно поиска
        if (($cache == false) || (DSConfig::getVal(
              'search_cache_enabled'
            ) != 1) || ($search_DropShop_grabbers_debug == 1)
        ) {
            $req = new DSGSearch($search_DropShop_grabbers_debug);
            $req->dsSourceObj = $this->dsSource;
            //TODO: ds_source параметра может и не быть - докуртить
            $req->dsSource = $this->params['ds_source'];
            if ($cacheParams['query']) {
                $req->q = $cacheParams['query'];
            }
            if (isset($this->params['image']) && $this->params['image']) {
                $req->image = $this->params['image'];
            }
            if (isset($this->params['original'])) {
                if ($this->params['original'] == 'on') {
                    $req->tmall = true;
                }
            }
            if (isset($this->params['not_unique'])) {
                if ($this->params['not_unique'] == 'on') {
                    $req->not_unique = true;
                }
            }
            if ((!empty($this->params['recommend'])) && ($this->params['recommend'] == 1)) {
                $req->recommend = true;
            }

            //set category id
            if (isset($this->params['cid'])) {
                if ($this->params['cid'] != '0') {
                    $req->cat = $this->params['cid'];
                }
            }

//====== Price safe mode ======
            if (isset($cacheParams['price_min'])) {
                $req->startPrice = $cacheParams['price_min'];
            }
            if (isset($cacheParams['price_max'])) {
                $req->endPrice = $cacheParams['price_max'];
            }
//=============================
            if (isset($this->params['props'])) {
                if (!empty($this->params['props'])) {
                    $req->props = $this->params['props'];
                }
            }
            if (!empty($this->params['sort_by'])) {
                $req->sort = $this->params['sort_by'];
            }

            $req->extParams = $extParams;
            $req->pageSize = 25; //$this->dsSource->dsSourcePageSize;
            $in_page_no = $this->params['page'];
            $req->pageNo = $in_page_no;

            $req->cacheKey =
              ($req->image ? $req->image : '') .
              $this->params['ds_source'] .
              '-' .
              ($req->q ? $req->q : '*') .
              '-' .
              ($req->tmall ? 'true' : 'false') .
              '-' .
              ($req->not_unique ? 'true' : 'false') .
              '-' .
              ($req->recommend ? 'true' : 'false') .
              '-' .
              ($req->cat ? $req->cat : '0') .
              '-' .
              ($req->startPrice ? $req->startPrice : '0') .
              '-' .
              ($req->endPrice ? $req->endPrice : '0') .
              '-' .
              ($req->props ? $req->props : '*') .
              '-' .
              ($req->sort ? $req->sort : '*') .
              '-' .
              (($extParams && is_array($extParams) && count($extParams)) ? implode(
                '-',
                $extParams
              ) : '*') .
              '-' .
              $req->pageSize .
              '-' .
              $req->pageNo;
            $DSGSearchRes = $req->execute();
            if (isset($DSGSearchRes->capcha) && $DSGSearchRes->capcha) {
                $DSGSearchRes->capcha->rise('/site/capcha');
                return false;
            }
            unset($req);
            $searchRes = $this->postprocessSearchRes($DSGSearchRes);
            if (count($DSGSearchRes->items) > 0) {
                /** @noinspection PhpUndefinedFieldInspection */
                /** @noinspection PhpUsageOfSilenceOperatorInspection */
                @Yii::app()->fileCache->set(
                  'DSG_search-' . Utils::array2string($cacheParams),
                  [$searchRes],
                  60 * 60 * (int) DSConfig::getVal('search_cache_ttl_search')
                );
            }
        } else {
            [$searchRes] = $cache;
        }

//===== START Post-translations ========================================
        $this->postprocessTranslations($searchRes);
        $searchRes->searchSortParameters = [];//$this->dsSource->searchSortParameters;
//===== END Post-translations ==========================================
        if (isset($DSGSearchRes) && $search_DropShop_grabbers_debug) {
            $searchRes->debugMessages = new CArrayDataProvider(
              $DSGSearchRes->debugMessages, [
                'id'         => 'id',
                'pagination' => [
                  'pageSize' => 150,
                ],
              ]
            );
        }
//
        return $searchRes;
    }

    //Поисковая функция

    private function searchByUser()
    {
        Profiler::start('search->searchByUser');
        $searchRes = new customSearchResult();
        $searchRes->search_type = 'SearchByUser';
        $searchRes->total_results = 0;
        $searchRes = $this->searchByParams(
          [
            'nick'            => $this->params['nick'],
            'user_id'         => $this->params['user_id'],
            'encryptedUserId' => (isset($_GET['encryptedUserId']) ? $_GET['encryptedUserId'] : ''),
          ]
        );
        Profiler::stop('search->searchByUser');
        return $searchRes;
    }

//Поисковая функция, как выяснилось - для всего.

    /** Внешняя поисковая функция
     * @param string $mode - режим поиска, варианты: search, relatedBySeller, relatedByItem
     * @return customSearchResult Набор данных результатов поиска
     */
    public function execute()
    {
        Profiler::start('searchRemote->execute', true);
        //TODO: Стрёмный момент, там только zh,en,ru
        $lang = Utils::transLang();
        if (!empty($this->params['nick']) || !empty($this->params['user_id'])) {
            //Точка входа в поиск
            $searchRes = $this->searchByUser();
        } else {
            //Точка входа в поиск
            $searchRes = $this->searchByParams(false);
        }
        Profiler::start('searchRemote->prepareItemTitle');
        $seo_catalog_enabled = DSConfig::getVal('seo_catalog_enabled') == 1;
        $searchRes->breadcrumbs = $this->searchBreadcrumbs((isset($searchRes->viewUrl) ? $searchRes->viewUrl : ''));
        if ($searchRes->items && is_array($searchRes->items)) {
            static::getItemsCidsFromDb($searchRes->items);
            static::prepareItemsTitle($this, $searchRes->items, $seo_catalog_enabled, $searchRes->breadcrumbs);
        }
        Profiler::stop('searchRemote->prepareItemTitle');
//====================================================================================================
        Profiler::stop('searchRemote->execute', true);
        if (isset($this->dsSrcLangQuery)) {
            $searchRes->dsSrcLangQuery = $this->dsSrcLangQuery;
        }
        return $searchRes;
    }
}