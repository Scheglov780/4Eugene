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

class customSearch extends customSearchBaseProps
{
    public static $intversion = '3.0.12.06.2017';
    public static $version = 'ver.: <b>3.0</b>';

    /** Проверка результатов поиска
     * @param customSearchResult $searchRes
     */
    private function checkSearch($searchRes)
    {
        if (isset($this->params['page']) && ($this->params['page'] == 1)
          && ((isset($this->params['cid']) && $this->params['cid']) ||
            (isset($this->params['cid_query']) && $this->params['cid_query']))
        ) {
            if (isset($searchRes->items) && (!count($searchRes->items))) {
//======================================================================================
                $url = 'ERR-0:' . Yii::app()->request->url;
                /** @noinspection PhpUndefinedFieldInspection */
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

                $command = Yii::app()->db->createCommand(
                  "INSERT INTO log_http_requests (session,url,ip,useragent,uid,\"date\")
        VALUES (:session,:url,:ip,:useragent,:uid,now())"
                );
                $command->execute(
                  [
                    ':session' => $session,
                    ':url' => $url,
                    ':ip' => $ip,
                    ':useragent' => $useragent,
                    ':uid' => $uid,
                  ]
                );
//======================================================================================
            }
        }
        return;
    }

    /** Сборка результатов поиска по разным источникам
     * @param customSearchResult
     * @return customSearchResult|boolean|null
     */
    private function mergeSearchResults()
    {
        $numArgs = func_num_args();
        if ($numArgs == 0) {
            return false;
        }
        if ($numArgs == 1) {
            $result = func_get_arg(1);
            if (is_object($result)) {
                return $result;
            } else {
                return false;
            }
        }
        $result = null;
        for ($i = 0; $i < func_num_args(); $i++) {
            $arg = func_get_arg($i);
            if (!is_object($result)) {
                $result = $arg;
            } else {
                if (is_object($arg)) {
                    if (isset($arg->viewUrl) && $arg->viewUrl) {
                        $result->viewUrl = $arg->viewUrl;
                    }
                    if (isset($arg->dsSrcLangQuery) && $arg->dsSrcLangQuery) {
                        $result->dsSrcLangQuery = $arg->dsSrcLangQuery;
                    }
                    $result->total_results = (isset($result->total_results) ? $result->total_results : 0)
                      + (isset($arg->total_results) ? $arg->total_results : 0);
                    $arraysToMerge = [
                      'items',
                      'cids',
                      'bids',
                      'groups',
                      'filters',
                      'multiFilters',
                      'suggestions',
                      'priceRange',
                    ];
                    foreach ($arraysToMerge as $paramToMerge) {
                        if (isset($arg->$paramToMerge) && is_array($arg->$paramToMerge)) {
                            if (isset($result->$paramToMerge) && is_array($result->$paramToMerge)) {
                                $result->$paramToMerge = array_merge($result->$paramToMerge, $arg->$paramToMerge);
                            } else {
                                $result->$paramToMerge = $arg->$paramToMerge;
                            }
                        }
                    }
                }
            }
        }
        return $result;
    }

    /** Основная поисковая функция
     * @return customSearchResult Набор данных результатов поиска
     */
    public function execute()
    {
        $timerStart = microtime(true);
        Profiler::start('search->execute', true);
        /* Логика такая:
         - Определяем, какие ds_source будут использоваться для поиска - делаем это в сабклассе

         - создаём соответствующие объекты, приводим this и объект к customSearchBaseProps и копируем в объект параметры из this;

         - Прогоняем каждый из объектов методом execute (как там внутри искать по пропертям - пусть разбираются сами)

         - Вычисляем крошку, если в поиске есть внешние источники, а точнее - один внешний источник.
           Точнее, наверное, мерджим свойство $breadcrumbs каждого поиска. Для чего метод searchBreadcrumbs
           отправляем в поисковые классы.

         - Подготавливаем itemTitle, для чего $this->prepareItemTitle переносим в поисковые классы, возможно даже abstract

         - Weights::getItemWeightForArray($searchRes);

         - Formulas::getUserPriceForArray($searchRes);

         - ItemFilters::checkForNotOnSale($searchRes);

        */
        /*
        $local_shop_mode = DSConfig::getVal('local_shop_mode');
        $isSearchByImage = isset($this->params['image']) && (bool)$this->params['image'];
        if ($local_shop_mode != 'off' && !$isSearchByImage) {
            $searchLocal = new SearchLocal(null, $this);
            $searchResLocal = $searchLocal->execute();
            unset($searchLocal);
        }
        if ($local_shop_mode != 'only') {
            $searchRemote = new SearchRemote(null, $this);
            $searchResRemote = $searchRemote->execute();
            unset($searchRemote);
        }
        */
//====================================================================================================
        Profiler::stop('search->execute', true);
        if (isset($searchResLocal) && isset($searchResRemote)) {
            $searchRes = $this->mergeSearchResults($searchResLocal, $searchResRemote);
        } elseif (isset($searchResLocal)) {
            $searchRes = $searchResLocal;
            unset($searchResLocal);
        } elseif (isset($searchResRemote)) {
            $searchRes = $searchResRemote;
            unset($searchResRemote);
        } else {
            $searchRes = null;
        }
        if ($searchRes) {
            //TODO: Вот эти штуки потом по ds_source что ли внутри каждой функции разрулить
            Profiler::start('searchRemote->weightForArray');
            //Weights::getItemWeightForArray($searchRes);
            Profiler::stop('searchRemote->weightForArray');
            //Formulas::getUserPriceForArray($searchRes);
            //ItemFilters::checkForNotOnSale($searchRes);
            //=============================================
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

            if (isset($this->dsSrcLangQuery)) {
                $searchRes->dsSrcLangQuery = $this->dsSrcLangQuery;
            }
            SiteLog::doItemsLog($searchRes);
            SiteLog::doQueryLog($searchRes);
            $this->checkSearch($searchRes);
        }
        $timerEnd = microtime(true) - $timerStart;
        return $searchRes;
    }

}