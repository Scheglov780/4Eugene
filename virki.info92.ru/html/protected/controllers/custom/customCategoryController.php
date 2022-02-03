<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CategoryController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customCategoryController extends CustomFrontController
{

    public $body_class = 'category';
    public $columns = 'two-col';

    public function actionIndex(
      $name = false,
      $query = false,
      $ds_source = false,
      $cid = '0',
      $page = 1,
      array $props = [],
      $price_min = false,
      $price_max = false,
      $sales_min = false,
      $sales_max = false,
      $rating_min = false,
      $rating_max = false,
      $sort_by = false,
      $original = false,
      $recommend = false,
      $not_unique = false
    ) {
//      header('Access-Control-Allow-Origin: *');

        $name = urldecode($name);
        if (!$name && $cid == '0') {
            throw new CHttpException(404, Yii::t('main', 'Неверный запрос'));
        }
        // Не нужно, пожалуйста, ставить здесь больше 10. Иначе поисковики мгновенно выберут все лимиты по получению данных с таобао - а эти лимиты существуют.
        if (($page >= 10 && Yii::app()->user->isGuest) || ((int) DSConfig::getVal(
              'seo_pages_count_for_crawler'
            ) > 3 && Yii::app()->user->isCrawler())
        ) {
            $this->redirect(Yii::app()->createUrl('/user/login'));
        }
        $this->httpCache();
        $search_query = '';
        $model = MainMenu::model()->find('url=:url AND status!=0', [':url' => $name]);
        if (!$model) {
            throw new CHttpException (404, Yii::t('main', 'Неверный запрос'));
        }
        if (!$ds_source && isset($model->ds_source)) {
            $ds_source = $model->ds_source;
        }
        if (isset($model->query)) {
            $search_query = $model->query;
        }
        if (preg_match('/(?:^|&)(?:user_id|seller_id)=(\d+)/i', $search_query, $matches)) {
            $lang = Utils::transLang();
            //СЕО настройки
            //TODO: вобще непонятно, что такое !!! Думается, сюда никогда не попадает
            $nick = $model->{$lang};
            $this->redirect(
              $this->createUrl('seller/index', [$ds_source => $ds_source, 'nick' => $nick, 'seller_id' => $matches[1]])
            );
        }
        $params = [
          'query'      => $query,
          'name'       => $name,
          'props'      => $props,
          'cid'        => $model->cid,
          'cid_query'  => str_replace('/', ' ', $search_query),
          'price_min'  => $price_min,
          'price_max'  => $price_max,
          'sales_min'  => $sales_min,
          'sales_max'  => $sales_max,
          'rating_min' => $rating_min,
          'rating_max' => $rating_max,
          'sort_by'    => $sort_by,
          'original'   => $original,
          'recommend'  => $recommend,
          'not_unique' => $not_unique,
          'page'       => $page,
          'ds_source'  => $ds_source,
        ];
        if (count($_POST)) {
            foreach ($params as $k => $param) {
                if (isset($_POST[$k])) {
                    $params[$k] = $_POST[$k];
                }
            }
        }
        if (is_array($params['props']) && count($params['props'])) {
            $propsStr = '';
            foreach ($params['props'] as $k => $v) {
                if ($v !== '') {
                    if (strpos($propsStr, $k . ':' . $v . ';') === false) {
                        $propsStr .= $k . ':' . $v . ';';
                    }
                }
            }
            if ($propsStr) {
                $params['props'] = $propsStr;
            }
        }

        $search = new Search('search');
        $search->params = $params;
        $res = $search->execute();

        $this->breadcrumbs = $res->breadcrumbs;

        foreach ($params as $k => $v) {
            if (!(bool) $v) {
                unset($params[$k]);
            }
        }
        $orig_params = $params;
        unset($orig_params['original']);
        unset($orig_params['not_unique']);

        $lang = Utils::transLang();
        //СЕО настройки
        $this->pageTitle = cms::meta($model->url, 'title');
        $this->meta_desc = cms::meta($model->url, 'description');
        $this->meta_keyword = cms::meta($model->url, 'keywords');
        reset($this->breadcrumbs);
        end($this->breadcrumbs);
        $breadCrumbTitle = key($this->breadcrumbs);
        if (is_numeric($breadCrumbTitle)) {
            $breadCrumbTitle = end($this->breadcrumbs);
        }
        $this->pageTitle = trim($breadCrumbTitle . ', ' . $this->pageTitle, ', ');
        $this->meta_desc = trim($breadCrumbTitle . ', ' . $this->meta_desc, ', ');
        //end
        //Pagination
        if (isset($res->total_results)) {
            $pages = new CPagination($res->total_results);
            $pages->pageSize = $res->pageSize;
            $pages->currentPage = $page - 1;
            $pages->params = $params;
        } else {
            $pages = false;
        }

        $this->params['params'] = $params;
        $this->params['cids'] = $res->cids;
        $this->params['bids'] = $res->bids;
        $this->params['groups'] = $res->groups;
        $this->params['filters'] = $res->filters;
        $this->params['multiFilters'] = $res->multiFilters;
        $this->params['suggestions'] = $res->suggestions;
        $this->params['priceRange'] = $res->priceRange;

        if (isset($res->error) || !isset($res->items) || (isset($res->items) && !count($res->items))) {
            header('HTTP/1.1 503 Service Unavailable', true, 503);
        }

        $this->render(
          '/search/index',
          [
            'res'         => $res,
            'params'      => $params,
            'sort_by'     => $sort_by,
            'pages'       => $pages,
            'orig_params' => $orig_params,
            'category'    => $model,
          ]
        );
    }

    function actionList()
    {
        $this->httpCache();
        $this->pageTitle = Yii::t('main', 'Все категории');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];

        $lang = Utils::appLang();
        $cache = @Yii::app()->cache->get('MainMenu-getList-' . $lang . '-' . $this->frontTheme);
        if ($cache == false) {
            $mainMenu = MainMenu::getMainMenu(0, $lang, 1, [2, 3]);
            @Yii::app()->cache->set(
              'MainMenu-getList-' . $lang . '-' . $this->frontTheme,
              [$mainMenu],
              60 * 60 * 4
            );
        } else {
            [$mainMenu] = $cache;
        }

        $this->params['params'] = false;
        $this->params['cids'] = [];
        $this->params['bids'] = [];
        $this->params['groups'] = [];
        $this->params['filters'] = [];
        $this->params['multiFilters'] = [];
        $this->params['suggestions'] = [];
        $this->params['priceRange'] = [];
        $this->render('list', ['categories' => $mainMenu]);
    }

    function actionMenu($lang = 'none', $topLevelCount = 1000)
    {
//        $detect = new Mobile_Detect;
//        if ($detect->isMobile()) {
//            $tmp=true;
//        }
//        $this->renderPartial('menu', array(), FALSE, TRUE);
//      Yii::app()->end();
        header(
          'Access-Control-Allow-Origin: ' .
          (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] :
            (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '*'))
        );
        header('Access-Control-Allow-Credentials: true');
        /* if (!DSConfig::getVal('search_cache_enabled') && Yii::app()->user && in_array(
            Yii::app()->user->role,
            array('superAdmin')
          )
        ) {
            MainMenu::clearMenuCache($topLevelCount);
        }
        */
        if (defined('DEBUG_MENU') && DEBUG_MENU) {
            Yii::app()->db->createCommand("TRUNCATE TABLE cache")->execute();
            Yii::app()->memCache->flush();
        }
        if ($lang == 'none') {
            $_lang = Utils::transLang();
        } else {
            $_lang = $lang;
        }
        if (Yii::app()->request->isAjaxRequest) {
            Yii::app()->language = $_lang;
        }
        $ttl = 60 * 60 * 4;

        $cache = @Yii::app()->cache->get(
          'MainMenu-getTree-rendering-' . $_lang . '-' . $topLevelCount . '-' . $this->frontTheme
        );
        if (!$cache || (count($cache) != 3)) {
            $res = $this->renderPartial(
              'menu',
              ['lang' => $_lang, 'topLevelCount' => $topLevelCount],
              true,
              false
            );
            ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
            ini_set('pcre.recursion_limit', 1024 * 1024);
            $res = preg_replace('/([ \t]){2,}/s', ' ', $res);
            $Etag = md5(serialize($res) . $_lang);
            $last_modified_time = time();
            if (preg_match('/Error\s+in/', $res)) {
                echo $res;
                Yii::app()->end();
            } else {
                @Yii::app()->cache->set(
                  'MainMenu-getTree-rendering-' . $_lang . '-' . $topLevelCount . '-' . $this->frontTheme,
                  [$res, $last_modified_time, $Etag],
                  $ttl
                );
            }
        } else {
            try {
                [$res, $last_modified_time, $Etag] = $cache;
                if (!is_long($last_modified_time)) {
                    MainMenu::clearMenuCache($topLevelCount);
                }
            } catch (Exception $e) {
                MainMenu::clearMenuCache($topLevelCount);
            }
        }
        header('Content-Type: text/plain');
        header('Cache-Control: public, max-age=' . $ttl);
        header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
        header('Etag: ' . $Etag);
        if ((isset($_SERVER['HTTP_IF_NONE_MATCH']) && (trim($_SERVER['HTTP_IF_NONE_MATCH']) == $Etag)) &&
          (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && (@strtotime(
                $_SERVER['HTTP_IF_MODIFIED_SINCE']
              ) == $last_modified_time))
        ) {
            if (DSConfig::getVal('search_cache_enabled') == 1) {
                header('HTTP/1.1 304 Not Modified');
            } else {
                echo $res;
            }
            Yii::app()->end();
        }
        echo $res;
        Yii::app()->end();
    }

    function actionPage($page_id)
    {
        $this->httpCache();
        $mainMenu = MainMenu::getMainMenu(0, Utils::appLang(), (int) $page_id);
        $mainMenuRoot = MainMenu::getMainMenuRecord(Utils::transLang(), (int) $page_id);
        if (count($mainMenuRoot) > 0) {
            $mainMenuRoot[(int) $page_id]['children'] = $mainMenu;

            $this->pageTitle = $mainMenuRoot[(int) $page_id]['view_text'];
            $this->breadcrumbs = [
              $this->pageTitle,
            ];
        }
        $this->params['params'] = false;
        $this->params['cids'] = [];
        $this->params['bids'] = [];
        $this->params['filters'] = [];
        $this->params['multiFilters'] = [];
        $this->params['suggestions'] = [];
        $this->params['priceRange'] = [];

        $this->render('page', ['links' => $mainMenuRoot, 'lang' => Utils::transLang()]);
    }

    public function filters()
    {
        if (AccessRights::GuestIsDisabled()) {
            return array_merge(
              [
                'Rights', // perform access control for CRUD operations
              ],
              parent::filters()
            );
        } else {
            return parent::filters();
        }
    }
}