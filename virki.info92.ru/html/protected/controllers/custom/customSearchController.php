<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customSearchController extends CustomFrontController
{
    public $body_class = 'search';

    public function actionIndex(
      $query = '',
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
      $not_unique = false,
      $similarPath = false,
      $image = false,
      $ds_source = false
    ) {
        if (isset($page) && $page) {
            $page = (int) $page;
        }
        // Не нужно, пожалуйста, ставить здесь больше 10. Иначе поисковики мгновенно выберут все лимиты по получению данных с таобао - а эти лимиты существуют.
        if (($page >= 10 && Yii::app()->user->isGuest) || ((int) DSConfig::getVal(
              'seo_pages_count_for_crawler'
            ) > 3 && Yii::app()->user->isCrawler())
        ) {
            $this->redirect(Yii::app()->createUrl('/user/login'));
        }
        $this->httpCache();
//== Всякие поиски по id и тп ==============================================
        if (preg_match('/^(http[s]*:\/\/.+\.(?:jpg|jpeg|png))$/', trim($query), $matches)) {
            $res = DSGSearch::prepareSearchByImage($matches[0]);
            if ($res && isset($res['name']) && $res['name']) {
                $this->redirect(
                  $this->createUrl('/search/index', ['image' => str_rot13($res['name'])])
                );//base64_encode(DSGUtils::encode($res['name']))
            } else {
                $this->redirect($this->createUrl('site/error', []));
            }
        }
        if (preg_match('/^\d{9,13}$/', trim($query))) {
            $this->redirect($this->createUrl('item/index', ['iid' => trim($query)]));
        }
        $isNickQuery = strpos(trim($query), '@') === 0;
        if ($isNickQuery || ($cid === 'seller')) {
            $this->redirect(
              $this->createUrl(
                'seller/index',
                ['nick' => (($cid != 'seller') ? preg_replace('/^@/u', '', trim($query)) : trim($query))]
              )
            );
        }

        //$id=array();
        //%26id%3D
// Поиск товара по URL на таобао
        $res = preg_match(
          '/(?:(?:(?:item|detail).*(?:[?&]|%26|&amp;)(?:id|num_id|itemid|iid)(?:=|%3D))|(?:\/item[\/]*))(\d{9,13})/i',
          trim($query),
          $inId
        );
        if ($res > 0) {
            $this->redirect($this->createUrl('item/index', ['iid' => (string) $inId[1]]));
        }
        $res = preg_match(
          '/\/item\/[a-z0-9\-_]+\/(\d{9,13})/i',
          trim($query),
          $inId
        );
        if ($res > 0) {
            $this->redirect($this->createUrl('item/index', ['iid' => (string) $inId[1]]));
        }
        //Поиск вот по такому url https://777.danvit.ru/ru/item/taobao/543300021395
//==========================================================================
        $orig_params = [];
        $params = [];
        $res = '';
        $model = null;//MainMenu::model()->find('id=:cid AND status!=0', array(':cid' => $cid));
        if (trim($query) == '' && $cid == '0' && $similarPath == false && $image == false) {
            $this->redirect('/');
        } elseif ($model && (bool) $cid && $cid !== 'seller') { // && !(bool)$query
//==================================
            $params = [
              'name'        => $model->url,
              'query'       => $query,
              'cid'         => $cid,
              'page'        => 1,
              'props'       => $props,
              'price_min'   => $price_min,
              'price_max'   => $price_max,
              'sales_min'   => $sales_min,
              'sales_max'   => $sales_max,
              'rating_min'  => $rating_min,
              'rating_max'  => $rating_max,
              'sort_by'     => $sort_by,
              'original'    => $original,
              'recommend'   => $recommend,
              'not_unique'  => $not_unique,
              'similarPath' => $similarPath,
              'page'        => $page,
              'ds_source'   => $ds_source,
            ];
            if (count($_POST)) {
                foreach ($params as $k => $param) {
                    if (isset($_POST[$k])) {
                        $params[$k] = $_POST[$k];
                    }
                }
            }
//==================================
            $this->redirect($this->createUrl('/category/index', $params)); //array('name'=>$model->url,'query'=>$query)
//      else {
//        throw new CHttpException(400, Yii::t('main', 'Выбранная Вами категория товаров временно недоступна, повторите поиск позже.'));
//      }
        } else {
            // Поиск товара по URL на таобао
            //render all params
            /*
                   'query' => FALSE,
                  'name' => $name,
                  'props' => $props,
                  'cid' => $model->cid,
                  'virtual' => $virtual,
                  'price_min' => $price_min,
                  'price_max' => $price_max,
                  'sales_min' => $sales_min,
                  'sales_max' => $sales_max,
                  'rating_min' => $rating_min,
                  'rating_max' => $rating_max,
                  'sort_by' => $sort_by,
                  'original' => $original,
                  'recommend' => $recommend
              */
            /*      if (isset($_POST['props'])) {
                    $props = '';
                  }
            */
            $params = [
              'query'       => $query,
              'cid'         => $cid,
              'props'       => $props,
              'price_min'   => $price_min,
              'price_max'   => $price_max,
              'sales_min'   => $sales_min,
              'sales_max'   => $sales_max,
              'rating_min'  => $rating_min,
              'rating_max'  => $rating_max,
              'sort_by'     => $sort_by,
              'original'    => $original,
              'recommend'   => $recommend,
              'not_unique'  => $not_unique,
              'similarPath' => $similarPath,
              'image'       => str_rot13($image),//DSGUtils::encode(base64_decode($image))
              'page'        => $page,
              'ds_source'   => $ds_source,
            ];
            if (count($_POST)) {
                foreach ($params as $k => $param) {
                    if (isset($_POST[$k])) {
                        $params[$k] = $_POST[$k];
                    }
                }
            }

            if (is_array($params['props']) && count($params['props'])) {
                $propsCid = false;
                $propsStr = '';
                foreach ($params['props'] as $k => $v) {
                    if ($v !== '') {
                        if ($k != -1) {
                            if (strpos($propsStr, $k . ':' . $v . ';') === false) {
                                $propsStr .= $k . ':' . $v . ';';
                            }
                        } else {
                            $propsCid = $v;
                        }
                    }
                }
                if ($propsStr) {
                    $params['props'] = $propsStr;
                }
                if ($propsCid) {
                    $params['cid'] = $propsCid;
                }
            }
//===========================================
            $search = new Search('search');
            $search->params = $params;
            $res = $search->execute();
            if (isset($res) && isset($res->breadcrumbs)) {
                $this->breadcrumbs = $res->breadcrumbs;
            } else {
                $this->breadcrumbs = [];
            }

            foreach ($params as $k => $v) {
                if (!(bool) $v) {
                    unset($params[$k]);
                }
            }
            $orig_params = $params;
            unset($orig_params['original']);
            unset($orig_params['not_unique']);
        }
        if (isset($_GET['image'])) {
            $breadcrumb = ' ' . Yii::t('main', 'по изображению');
        } else {
            $breadcrumb = ' "' . CHtml::encode(isset($_GET['query']) ? $_GET['query'] : '*') . '"';
            if (isset($res->dsSrcLangQuery) && ($res->dsSrcLangQuery)) {
                $breadcrumb = $breadcrumb . ' / ' . Utils::removeOnlineTranslation($res->dsSrcLangQuery);
            }
        }
        $this->breadcrumbs[] = Yii::t('main', 'Результаты поиска') . $breadcrumb;

        //Pagination
        if (isset($res->total_results)) {
            $pages = new CPagination($res->total_results);
            $pages->pageSize = $res->pageSize;
            $pages->currentPage = $page - 1;
            $pages->params = $params;
        } else {
            $pages = false;
        }

        if ($query) {
            $this->pageTitle = Yii::t('main', 'Поиск') . ': ' . $query;
        } elseif (isset($params) && is_array($params) && isset($params['similarPath'])) {
            parse_str(
              $params['similarPath'],
              $titleParams
            );// type=similar&app=i2i&rec_type=1&uniqpid=-1188263820&nid=44828530639
            if (isset($titleParams['nid']) && $titleParams['nid']) {
                $titleNid = $titleParams['nid'];
            } else {
                $titleNid = '';
            }
            if (isset($titleParams['type']) && $titleParams['type']) {
                $titleType = ($titleParams['type'] == 'similar' ? Yii::t('main', 'Похожие товары') : Yii::t(
                  'main',
                  'У других продавцов'
                ));
            } else {
                $titleType = Yii::t('main', 'Расширенный поиск');
            }
            $this->pageTitle = $titleType . ($titleNid ? ': ' . $titleNid : '');
        } elseif (isset($params) && is_array($params) && isset($params['image'])) {
            $this->pageTitle = Yii::t('main', 'Поиск по изображению');
        } else {
            $this->pageTitle = Yii::t('main', 'Расширенный поиск');
        }
        $this->params['params'] = $params;
        /*
         $this->params['cids'] = $res->cids;
         $this->params['bids'] = $res->bids;
         $this->params['groups'] = $res->groups;
         $this->params['filters'] = $res->filters;
         $this->params['multiFilters'] = $res->multiFilters;
         $this->params['suggestions'] = $res->suggestions;
         $this->params['priceRange'] = $res->priceRange;
        */
        /*
                    if($res->total_results == 0 && $cid == 0){
                        self::sellers($query);
                    }
        */
        if (isset($res->error) || !isset($res->items) || (isset($res->items) && !count($res->items))) {
            header('HTTP/1.1 503 Service Unavailable', true, 503);
        }
        $this->render(
          'index',
          [
            'res' => $res,
              /*  'params'      => $params,
                'sort_by'     => $sort_by,
                'pages'       => $pages,
                'orig_params' => $orig_params,
              */
          ]
        );
    }

    public function actionSearchByImage()
    {
        if (!count($_FILES) && !count($_GET) && !count($_POST)) {
            throw new CHttpException(403, Yii::t('main', 'Не выбрано изображение для поиска'));
        }
        try {
            $res = DSGSearch::prepareSearchByImage();
            if ($res && isset($res['name']) && $res['name']) {
                header('HTTP/1.1 200 OK', true, 200);
                header('Content-Type: text/plain');
                echo $this->createAbsoluteUrl(
                  '/search/index',
                  ['image' => str_rot13($res['name'])]
                );//base64_encode(DSGUtils::encode($res['name']))
            } else {
                echo Yii::t('main', 'Ошибка загрузки изображения! Повторите попытку позже...');
            }
        } catch (Exception $e) {
            print_r($e);
        }

        Yii::app()->end();
    }

    public function actionSearchByList($dataType)
    {
        $this->render(
          'itemsList',
          [
            'dataType' => $dataType,
          ]
        );
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