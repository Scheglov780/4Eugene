<? $this->widget(
  'application.components.widgets.SearchItemsList',
  [
    'id'                         => 'RecentUserItemslistForItem',
    'title'                      => '<span style="position:relative; top:7px;">' . Yii::t(
        'main',
        'Недавно Вы смотрели'
      ) . '</span>',
    'controlAddToFavorites'      => true,
      /*'controlAddToFeatured'       => true,*/
    'controlAddToFeatured'       => false,
    'controlDeleteFromFavorites' => false,
    'lazyLoad'                   => true,
    'dataType'                   => 'itemsRecentUser',
    'pageSize'                   => 12,
    'imageFormat'                => '_240x240.jpg',
    'disableItemForSeo'          => DSConfig::getVal('seo_disable_items_index') == 1,
      /**/
    'prevPageLabel'              => '<i class="fa fa-angle-left fa-fw"></i>',
    'nextPageLabel'              => '<i class="fa fa-angle-right fa-fw"></i>',
    'pagerCssClass'              => 'box-heading',
    'showEmptyPager'             => true,
  ]
);