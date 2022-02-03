<? $this->widget(
  'application.components.widgets.SearchItemsList',
  [
    'id'                         => 'RecentAllItemslist',
    'controlAddToFavorites'      => false,
    'controlAddToFeatured'       => false,
    'controlDeleteFromFavorites' => false,
    'lazyLoad'                   => true,
    'dataType'                   => 'itemsRecentAll',
    'pageSize'                   => 10,
//      'showControl' => null,
    'disableItemForSeo'          => DSConfig::getVal('seo_disable_items_index') == 1,
    'imageFormat'                => '_169x109.jpg',
  ]
);