<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="recommended.php">
 * </description>
 * Рендеринг недавно просмотренных, рекомендованных и прочихвспомогательных товаров
 **********************************************************************************************************************/
?>
<? $this->widget(
  'application.components.widgets.SearchItemsList',
  [
    'id'                         => 'RecentAllItemslist',
    'title'                      => '<span>' . Yii::t('main', 'Это может быть интересно') . '</span>',
    'controlAddToFavorites'      => true,
    'controlAddToFeatured'       => false,
    'controlDeleteFromFavorites' => false,
    'lazyLoad'                   => true,
    'dataType'                   => 'itemsRecentAll',
    'pageSize'                   => 24,
    'imageFormat'                => '_240x240.jpg',
    'template'                   => '{pager}{items}',
    'disableItemForSeo'          => DSConfig::getVal('seo_disable_items_index') == 1,
    'prevPageLabel'              => '<i class="fa fa-angle-left fa-fw"></i>',
    'nextPageLabel'              => '<i class="fa fa-angle-right fa-fw"></i>',
    'pagerCssClass'              => 'box-heading',
    'showEmptyPager'             => true,
    'itemsCssClass'              => 'row items',
    'itemsTagName'               => 'div',
  ]
);

