<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="itemRelatedBlock.php">
 * </description>
 * Связанные товары
 **********************************************************************************************************************/
?>
<? if (isset($itemRelated->items) && is_array($itemRelated->items) && (count($itemRelated->items) > 0)) { ?>
  <div class="products-list featured" style="width: 100%">
    <div class="list-view">
      <div class="box-heading">
        <div><span><?= Yii::t('main', 'Сопутствующие товары') ?></span>
          <ul class="pagination pull-right">
            <li class=""></li>
          </ul>
          <div style="clear: both;"></div>
        </div>
      </div>

      <div class="products-list featured">
          <? $seo_disable_items_index = DSConfig::getVal('seo_disable_items_index') == 1; ?>
          <? $this->widget(
            'application.components.widgets.SearchItemsGallery',
            [
              'id'                         => 'itemRelatedItemsGallery',
              'loadJs'                     => true,
              'controlAddToFavorites'      => true,
              'controlAddToFeatured'       => false,
              'controlDeleteFromFavorites' => false,
              'dataProvider'               => $itemRelated->items,
              'dataType'                   => 'itemRelated',
              'disableItemForSeo'          => $seo_disable_items_index,
              'imageFormat'                => '_240x240.jpg',
              'lazyLoad'                   => false,
              'itemBlockClass'             => 'col-lg-3 col-md-3 col-sm-6 col-xs-12',
              'magicScrollExtraOptions'    => "
                                                    'items': 4,
                                                    'speed': 15000,
                                                    'lazyLoad': true,
                                                    'width': 1110,
                                                    'height': 260,
                                                    'arrows': 'outside',
                                                    'arrows-opacity': 20,
                                                    'arrows-hover-opacity': 100,
                                                    'step': 4,
                                                    'item-tag': 'div'
                                                    ",
            ]
          );
          ?>
      </div>
    </div>
  </div>
<? } ?>