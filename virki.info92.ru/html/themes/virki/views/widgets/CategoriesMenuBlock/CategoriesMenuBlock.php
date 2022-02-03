<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CategoriesMenuBlock.php">
 * </description>
 * Виджет основного меню категорий
 * $mainMenu = массив описаний категорий с массивами описаний дочерних категорий
 * Array
 * (
 * [0] => Array
 * (
 * [pkid] => 2 - PK категории из таблицы categories_ext
 * [cid] => 0 - cid категории
 * [parent] => 1 - PK родительской категории, 1 - корень
 * [status] => 1 - вкл/выкл
 * [url] => mainmenu-odezhda - часть URL категории
 * [query] => 女装男装 - запрос на китайском языке
 * [level] => 2 - уровень в дереве категорий, начиная с 1 для корня
 * [order_in_level] => 200 - порядок вывода категории в уровне
 * [view_text] => Одежда - название категории
 * [children] => Array (...) - массив аналогичных структур для подкатегорий
 * )
 **********************************************************************************************************************/
?>
<? //=================================================================================================================?>
<?
$categoriesDataProvider = new CArrayDataProvider(
  $mainMenu, [
    'id'         => 'mainMenuDataProvider',
    'keyField'   => 'pkid',
    'pagination' => [
      'pageSize' => 10000,
    ],
  ]
);
$this->widget(
  'booster.widgets.TbListView',
  [
    'id'            => 'mainMenuListView',
    'dataProvider'  => $categoriesDataProvider,
    'itemView'      => 'webroot.themes.' . $this->frontTheme . '.views.widgets.CategoriesMenuBlock.menuItem',
      /*    'viewData'        => array(
            'showControl'                => $this->showControl,
            'disableItemForSeo'          => $this->disableItemForSeo,
            'imageFormat'                => $this->imageFormat,
            'controlAddToFavorites'      => $this->controlAddToFavorites,
            'controlAddToFeatured'       => $this->controlAddToFeatured,
            'controlDeleteFromFavorites' => $this->controlDeleteFromFavorites,
            'lazyLoad'                   => $this->lazyLoad,
            'itemBlockClass'             => $this->itemBlockClass,
          ),
      */
    'enableSorting' => false,
    'template'      => '{items}',
    'pagerCssClass' => 'pagination',
    'pager'         => [
      'class'          => 'TbSEOLinkPager',
      'header'         => false,
        //'maxButtonCount'  => 0,
      'firstPageLabel' => '',
      'lastPageLabel'  => '',
        //'linkHtmlOptions' => array('rel' => 'nofollow'),
        //'cssFile'=>false,
      'prevPageLabel'  => '&lt;',
      'nextPageLabel'  => '&gt;',
    ],
//    'afterAjaxUpdate' => $afterAjaxUpdate,
  ]
);
?>
