<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="main.php">
 * </description>
 * Главная страница сайта (не путать с лэйаутом)
 * var $itemsPopular = true
 * var $itemsRecommended = true
 * var $itemsRecentUser = false
 * var $itemsRecentAll = true
 **********************************************************************************************************************/
?>
<div class="row clearfix f-space10"></div>
<!--  begin recomended  items -->
<div class="row clearfix"></div>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 main-column box-block">
        <?
        switch ($dataType) {
            case 'itemsRecommended':
                $title = Yii::t('main', 'Рекомендованные товары');
                break;
            case 'itemsPopular':
                $title = Yii::t('main', 'Популярные товары');
                break;
            case 'itemsRecentUser':
                $title = Yii::t('main', 'Просмотренные вами товары');
                break;
            case 'itemsRecentAll':
                $title = Yii::t('main', 'Просмотренные другими пользователями товары');
                break;
            case 'itemsFavorite':
                $title = Yii::t('main', 'Избранные товары');
                break;
            default:
                return;
                break;
        }
        ?>
        <? $this->widget(
          'application.components.widgets.SearchItemsList',
          [
            'id'                         => $dataType . '-itemslist',
            'title'                      => '<span style="position:relative; top:8px;">' . $title . '</span>',
            'controlAddToFavorites'      => true,
            'controlAddToFeatured'       => false,
            'controlDeleteFromFavorites' => false,
            'lazyLoad'                   => true,
            'dataType'                   => $dataType,
            'pageSize'                   => 60,
            'imageFormat'                => '_240x240.jpg',
            'template'                   => '{pager}{items}{pager}',
            'disableItemForSeo'          => DSConfig::getVal('seo_disable_items_index') == 1,
            'prevPageLabel'              => '<i class="fa fa-angle-left fa-fw"></i>',
            'nextPageLabel'              => '<i class="fa fa-angle-right fa-fw"></i>',
            'pagerCssClass'              => 'box-heading',
            'showEmptyPager'             => true,
            'itemsCssClass'              => 'row items',
            'itemsTagName'               => 'div',
          ]
        );
        ?>
    </div>
  </div>
</div>
<!-- Rectangle Banners -->
<div class="row clearfix f-space20"></div>
<div class="container">
  <div class="row">
      <?= cms::customContent('fs:rectangle_banners') ?>
  </div>
  <!--</div>--><!-- end: container -->
  <!-- end: Rectangle Banners -->
  <!-- Widgets -->
  <div class="row clearfix"></div>
  <div class="row">
    <!-- Brands -->
    <div class="col-md-12 main-column box-block brands-block">
        <? $this->widget('application.components.widgets.BrandsBlock'); ?><!-- Рендеринг блока брендов -->
    </div>
  </div>
  <!-- end: Brands -->
</div><!-- end: Container -->
<!-- end: Widgets -->
