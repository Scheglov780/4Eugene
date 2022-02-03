<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchItem.php">
 * </description>
 * Рендеринг списка товаров в поисковой выдаче посредством CListView
 * var $showControl - показывать кнопки
 * var $disableItemForSeo
 * var $imageFormat
 * var $controlAddToFavorites - кнопка Добавить в избранное
 * var $controlAddToFeatured - кнопка Добавить в рекомендованное
 * var $controlDeleteFromFavorites - кнопка Удалить (из избранного, в частности)
 * var $lazyLoad
 **********************************************************************************************************************/
?>
<!-- Product -->
<?
/**
 * @var customSearchItemResult $data
 */
$item = &$data;
?>
<div class="<?= $itemBlockClass ?>" id="item<?= $item->num_iid ?>">
  <div class="product-block" itemscope itemtype="http://schema.org/Product">
    <meta itemprop="name" content="<?= $item->title ?>">
    <div class="image">
      <a class="img" href="<?= Yii::app()->createUrl(
        '/item/index',
        [
          'dsSource' => $item->ds_source,
          'iid'      => $item->num_iid,
        ]
      ) ?>" target="_blank"
        <?= ($disableItemForSeo) ? ' rel="nofollow"' : '' ?> title="<?= $item->title ?>">
          <? if ($lazyLoad) { ?>
            <img class="lazy img-responsive"
                 src="<?= Yii::app()->request->baseUrl ?>/themes/<?= Yii::app()->theme->name ?>/images/Hourglass.png"
                 data-original="<?= Img::getImagePath($item->pic_url, $imageFormat) ?>"
                 alt="<?= $item->alt ?>">
            <noscript>
              <img itemprop="image" class="img-responsive"
                   src="<?= Img::getImagePath($item->pic_url, $imageFormat) ?>"
                   alt="<?= $item->alt ?>">
            </noscript>
              <?
          } else {
              ?>
            <img itemprop="image" class="img-responsive"
                 src="<?= Img::getImagePath($item->pic_url, $imageFormat) ?>"
                 alt="<?= $item->alt ?>">
          <? } ?>
      </a>
    </div>
      <? if (isset($item->notOnSale) && $item->notOnSale) { ?>
        <span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="price-new"
              title="<?= Yii::t('main', 'По договоренности') ?>">
                    <meta itemprop="price" content="<?= $item->userPromotionPrice ?>">
                    <meta itemprop="priceCurrency" content="<?= DSConfig::getCurrency(false) ?>">
                    <?= Yii::t('main', 'По договоренности') ?>
                </span>
      <? } else { ?>
        <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="small-price-up">
          <meta itemprop="price" content="<?= $item->userPromotionPrice ?>">
          <meta itemprop="priceCurrency" content="<?= DSConfig::getCurrency(false) ?>">

        </div>
      <? } ?>
    <span itemprop="name" style="display: none"><?= $item->title ?></span>
  </div><!--product-block-->
</div>
<!--/col-->
<!-- end: Product -->