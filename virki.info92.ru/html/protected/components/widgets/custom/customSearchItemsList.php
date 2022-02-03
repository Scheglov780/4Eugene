<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchItemsList.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customSearchItemsList extends CustomWidget
{
    public $controlAddToFavorites = false;
    public $controlAddToFeatured = false;

//  public $searchResItem = FALSE;
//  public $newLine = NULL;
    public $controlAddToShop = false;
    public $controlDeleteFromFavorites = false;
    public $controlDeleteFromShop = false;
    public $dataProvider = false;
    public $dataType = false;
    public $disableItemForSeo = true;
    public $id = 'search-items-list';
    public $imageFormat = '_160x160.jpg';
    public $itemBlockClass = 'col-lg-3 col-md-3 col-sm-4 col-xs-6';
    public $itemsCssClass = 'items';//'{pager}{items}{pager}'; //{sorter}{summary}
    public $itemsTagName = 'div';
    public $lazyLoad = true;
    public $maxButtonCount = 10;
    public $maxButtonCountMobile = 4;
    public $nextPageLabel = '&gt;';
    public $pageSize = 8;//'<i class="fa fa-angle-left fa-fw"></i>',
    public $pagerCssClass = 'pagination';//'<i class="fa fa-angle-right fa-fw"></i>',
    public $prevPageLabel = '&lt;';// 'box-heading',
    public $showControl = null;
    public $showEmptyPager = false;
    public $template = '{pager}{items}';
    public $title = '<span></span>';

    public function run()
    {
        //TODO: Тут при листании страниц рефрешатся все!!! виджеты, а не один. Полная ерунда!!!
        if (!$this->dataProvider && !$this->dataType) {
            return;
        }

        if (!$this->dataProvider) {
            switch ($this->dataType) {
                case 'itemsRecommended':
                    $this->dataProvider = null;/*customSearchLocal::getFeatured(
                      'recommended',
                      $this->pageSize
                    ); */
                    break;
                case 'itemsPopular':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'popular',
                      $this->pageSize
                    ); */
                    break;
                case 'itemsRecentUser':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'recentUser',
                      $this->pageSize
                    ); */
                    break;
                case 'itemsRecentAll':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'recentAll',
                      $this->pageSize
                    ); */
                    break;
                case 'itemsFavorite':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'favorite',
                      $this->pageSize
                    ); */
                    break;
                default:
                    return;
                    break;
            }
        } else {
            $this->dataProvider->pagination->pageSize = $this->pageSize;
        }
        if (!$this->dataProvider) {
            echo Yii::t('main', 'Нет данных');
            return;
        }
//== Weight calculation ========================
        /*        if (is_array($this->dataProvider)) {
                    $data = $this->dataProvider;
                } else {
                    $data = $this->dataProvider->getData();
                }
                Weights::getItemWeightForArray($data);
                if (is_array($this->dataProvider)) {
                    $this->dataProvider = $data;
                } else {
                    $this->dataProvider->setData($data);
                }
        */
//==============================================
        if (is_null($this->showControl)) {
            $this->showControl = Yii::app()->user->checkAccess('Favorite/Add');
        }

        if (DSConfig::getVal('site_images_lazy_load') == 0) {
            $this->lazyLoad = false;
        }

        if ($this->lazyLoad) {
            $afterAjaxUpdate = "js:function(id, data) {
            // Disabling any price and detail blocks
            $('img.lazy').each(function() {
                $(this).parents('div.product-block').children('div.product-meta').each(function() {
                    $(this).hide();
                });
                $(this).parents('div.product-block').children('div.product-sale').each(function() {
                    $(this).hide();
                });
            });
            // Callback enabling any price and detail blocks
            function onLazyLoad(element, el_left, settings) {
                $(element).parents('div.product-block').children('div.product-meta').each(function() {
                    $(this).show();
                });
                $(element).parents('div.product-block').children('div.product-sale').each(function() {
                    $(this).show();
                });
            }            
    $('#" . $this->id . " img.lazy').show().lazyload({
      load: onLazyLoad,
      effect       : 'fadeIn',
      effect_speed : 500,
      skip_invisible : false,
      threshold : 200,
//      failure_limit : 60,
//      event : 'load'
    });
    }";
        } else {
            $afterAjaxUpdate = "js:function(id, data) {
        }";
        }
        /*
        if ($this->titleLink) {
                    $_title = CHtml::link($this->title, Yii::app()->createUrl($this->titleLink,array('dataType'=>$this->dataType)));
        } else {
                    $_title=$this->title;
        }*/
        if ($this->dataProvider && $this->dataProvider->totalItemCount) {

            if (isset(Yii::app()->components['booster'])) {
                $this->widget(
                  'booster.widgets.TbListView',
                  [
                    'id'              => $this->id,
                    'dataProvider'    => $this->dataProvider,
                    'itemView'        => 'webroot.themes.' .
                      $this->frontTheme .
                      '.views.widgets.SearchItemsList.SearchItem',
                      //themeBlocks.
                    'viewData'        => [
                      'showControl'                => $this->showControl,
                      'disableItemForSeo'          => $this->disableItemForSeo,
                      'imageFormat'                => $this->imageFormat,
                      'controlAddToFavorites'      => $this->controlAddToFavorites,
                      'controlAddToFeatured'       => $this->controlAddToFeatured,
                      'controlDeleteFromFavorites' => $this->controlDeleteFromFavorites,
                      'lazyLoad'                   => $this->lazyLoad,
                      'itemBlockClass'             => $this->itemBlockClass,
                    ],
                    'enableSorting'   => false,
//        'itemsCssClass'   => 'products-list',
                    'template'        => $this->template,
                    'pagerCssClass'   => $this->pagerCssClass,
                    'showEmptyPager'  => $this->showEmptyPager,
                    'pager'           => [
                      'class'                => 'TbSEOLinkPager',
                      'header'               => $this->title,
                      'maxButtonCount'       => $this->maxButtonCount,
                      'maxButtonCountMobile' => $this->maxButtonCountMobile,
                      'firstPageLabel'       => '',
                      'lastPageLabel'        => '',
                      'linkHtmlOptions'      => ['rel' => 'nofollow'],
//    'cssFile'=>false,
                      'prevPageLabel'        => $this->prevPageLabel,
                      'nextPageLabel'        => $this->nextPageLabel,
                    ],
                    'itemsCssClass'   => $this->itemsCssClass,
                    'itemsTagName'    => $this->itemsTagName,
                    'afterAjaxUpdate' => $afterAjaxUpdate,
                  ]
                );
            } else {
                $this->widget(
                  'bootstrap.widgets.TbListView',
                  [
                    'id'              => $this->id,
                    'dataProvider'    => $this->dataProvider,
                    'itemView'        => 'webroot.themes.' .
                      $this->frontTheme .
                      '.views.widgets.SearchItemsList.SearchItem',
                      //themeBlocks.
                    'viewData'        => [
                      'showControl'                => $this->showControl,
                      'disableItemForSeo'          => $this->disableItemForSeo,
                      'imageFormat'                => $this->imageFormat,
                      'controlAddToFavorites'      => $this->controlAddToFavorites,
                      'controlAddToFeatured'       => $this->controlAddToFeatured,
                      'controlDeleteFromFavorites' => $this->controlDeleteFromFavorites,
                      'lazyLoad'                   => $this->lazyLoad,
                      'itemBlockClass'             => $this->itemBlockClass,
                    ],
                    'enableSorting'   => false,
                    'itemsCssClass'   => 'products-list',
                    'template'        => $this->template,
                    'pagerCssClass'   => $this->pagerCssClass,
                    'pager'           => [
                      'class'           => 'CSEOLinkPager',
                      'header'          => $this->title,
                      'maxButtonCount'  => $this->maxButtonCount,
                      'firstPageLabel'  => '',
                      'lastPageLabel'   => '',
                      'linkHtmlOptions' => ['rel' => 'nofollow'],
//    'cssFile'=>false,
                      'prevPageLabel'   => $this->prevPageLabel,
                      'nextPageLabel'   => $this->nextPageLabel,
                    ],
                    'afterAjaxUpdate' => $afterAjaxUpdate,
                  ]
                );
            }
        }
    }
}