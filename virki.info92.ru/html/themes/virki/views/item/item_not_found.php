<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_not_found.php">
 * </description>
 * Рендеринг сообщения о ненайденном товаре
 **********************************************************************************************************************/
?>
<? $seo_disable_items_index = DSConfig::getVal('seo_disable_items_index') == 1;
if ($seo_disable_items_index) {
    Yii::app()->clientScript->registerMetaTag('noindex', 'robots');
} ?>
<? $this->widget(
  'application.components.widgets.UserNavigationHistory',
  [
    'type' => '\/(item)\/',
    'count' => 10,
  ]
);
?>
<br/>
<div class="item-block">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="alert alert-danger">
          <p class="notfound text-center"><?= Yii::t('main', 'Увы, данного товара нет в наличии...') ?></p>
        </div><!--End:Alert-->
      </div><!--End:Col-->
    </div><!--End:Row-->
  </div><!--End:container-->

</div>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <? $seo_disable_items_index = DSConfig::getVal('seo_disable_items_index') == 1; ?>
        <? include_once __DIR__ . '/_ajaxRecentUserItemslistForItem.php' ?>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <? include_once __DIR__ . '/_ajaxRecentAllItemslistForItem.php' ?>
    </div>
  </div>
</div>


