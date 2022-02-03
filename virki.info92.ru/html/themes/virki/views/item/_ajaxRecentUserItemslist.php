<? $this->widget(
  'application.components.widgets.SearchItemsList',
  [
    'id'                         => 'RecentUserItemslist',
    'controlAddToFavorites'      => true,
    'controlAddToFeatured'       => true,
    'controlDeleteFromFavorites' => false,
    'lazyLoad'                   => true,
    'dataType'                   => 'itemsRecentUser',
    'pageSize'                   => 10,
//      'showControl' => null,
    'disableItemForSeo'          => DSConfig::getVal('seo_disable_items_index') == 1,
    'imageFormat'                => '_240x240.jpg',
  ]
);