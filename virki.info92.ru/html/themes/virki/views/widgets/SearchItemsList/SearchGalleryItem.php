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
<div class="<?= $this->itemBlockClass ?>">
  <div class="product-block" id="item<?= $data->num_iid ?>" itemscope itemtype="http://schema.org/Product">
    <meta itemprop="name" content="<?= $item->title ?>">
      <? if ($item->isLocal && DSConfig::getVal('local_shop_mode') == 'mixed') { ?>
        <div class="product-label product-sale"><span>Sale</span></div>
      <? } elseif (isset($item->tmall) && $item->tmall) { ?>
        <div class="product-label product-sale"><span>TMall</span></div>
      <? } ?>
    <div class="image">
      <a class="img" href="<?= Yii::app()->createUrl(
        '/item/index',
        [
          'dsSource' => $item->ds_source,
          'iid'      => $item->num_iid,
        ]
      ) ?>"
         target="_blank"
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
    <div class="product-meta">
        <? if (isset($item->notOnSale) && $item->notOnSale) { ?>
          <div class="small-price-up">
                <span itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="price-new"
                      title="<?= Yii::t('main', 'Нет в наличии') ?>">
                    <meta itemprop="price" content="<?= $item->userPromotionPrice ?>">
                    <meta itemprop="priceCurrency" content="<?= DSConfig::getCurrency(false) ?>">
                    <?= Yii::t('main', 'Нет в наличии') ?>
                </span>
          </div>
          <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="small-price-up">
                <span itemprop="price" class="price-new"><?= Yii::t('main', 'Нет в наличии') ?>
          </div>
        <? } else { ?>
          <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="small-price-up">
            <meta itemprop="price" content="<?= $item->userPromotionPrice ?>">
            <meta itemprop="priceCurrency" content="<?= DSConfig::getCurrency(false) ?>">
            <span itemprop="price" class="price-new"><?= Formulas::priceWrapper(
                  $item->userPromotionPrice
                ) ?></span>
              <? if (($item->userPrice > $item->userPromotionPrice) && DSConfig::getVal(
                  'source_show_old_price'
                )) { ?>
                <span class="price-old"><?= $item->userPrice ?></span>
              <? } ?>

          </div>
        <? } ?>
      <div class="big-price">
        <div class="small-btns btn-up">
            <? if ($showControl) { ?>
                <? if ($controlAddToFeatured) { ?>
                <a class="btn btn-default btn-compare pull-left"
                   title="<?= Yii::t('main', 'Добавить в рекомендованное') ?>" data-toggle="tooltip"
                   data-placement="top" rel="nofollow" href="<?= Yii::app()->createUrl(
                  '/' . Yii::app()->controller->module->id . '/featured/add/',
                  [
                    'dsSource' => ($data->ds_source),
                    'id'       => ($data->num_iid),
                  ]
                ) ?>"
                   onclick="addFeatured(this,'<?= $data->num_iid ?>'); return false;">
                  <i class="fa fa-anchor fa-fw"></i>
                </a>
                <? } ?>
                <? if ($controlAddToFavorites) { ?>
                <a class="btn btn-default btn-wishlist pull-left"
                   title="<?= Yii::t('main', 'Добавить в избранное') ?>" data-toggle="tooltip"
                   data-placement="top" rel="nofollow" href="<?= Yii::app()->createUrl(
                  '/cabinet/favorite/add',
                  [
                    'dsSource' => $data->ds_source,
                    'iid'      => $data->num_iid,
                  ]
                ) ?>"
                   onclick="addFavorite(this,'<?= $data->num_iid ?>'); return false;">
                  <i class="fa fa-heart fa-fw"></i>
                </a>
                <? } ?>
                <? if ($controlDeleteFromFavorites) { ?>
                <a class="btn btn-default btn-wishlist pull-left"
                   title="<?= Yii::t('main', 'Удалить из избранного') ?>" data-toggle="tooltip"
                   data-placement="top" rel="nofollow" href="<?= Yii::app()->createUrl(
                  '/cabinet/favorite/delete',
                  ['id' => $data->id]
                ) ?>"
                   onclick="deleteFavorite(this,'<?= $data->num_iid ?>'); return false;">
                  <i class="fa fa-trash-o fa-fw"></i>
                </a>
                <? } ?>
            <? } ?>
        </div>
      </div>

        <? if (isset($item->seller_rate) && ($item->seller_rate > 0)) {
            ?>
          <div class="rating pull-right">
            <? /*
            <span class="price-new pull-right" data-toggle="tooltip" data-placement="right"
                  title="<?= Yii::t('main', 'Количество продаж') ?>">
                            <i class="fa fa-battery-half"></i> <?= $item->soldItems ?>
                        </span>
            */ ?>
          <i class="i-rating rating_<?= DSGSeller::getCrownsFromSales($item->seller_rate) - 1 ?>"></i>
          </div><? //= $item->seller_rate ?>
            <?
        } elseif (isset($item->tmall) && $item->tmall) { ?>
          <div class="rating pull-right">
            <? /*
            <span class="price-new pull-right" data-toggle="tooltip" data-placement="right"
                  title="<?= Yii::t('main', 'Количество продаж') ?>">
                            <i class="fa fa-battery-half"></i> <?= $item->soldItems ?>
                        </span>
            */ ?>
          <i class="i-rating rating_21"></i>
          </div><? //= $item->seller_rate ?>
        <? } ?>

      <div class="small-btns">
        <a class="btn btn-default btn-addtocart pull-right" data-toggle="tooltip" data-placement="top"
           title="<?= Yii::t('main', 'Положить в корзину') ?>"
           rel="nofollow" href="<?= Yii::app()->createUrl(
          '/cart/add',
          [
            'dsSource' => $item->ds_source,
            'iid'      => $item->num_iid,
          ]
        ) ?>"
           onclick="addCart(this,'<?= $item->num_iid ?>'); return false;">
          <i class="fa fa-shopping-cart fa-fw"></i>
        </a>
      </div><!--small-btns-->

    </div>
    <div class="meta-back"></div>
    <span itemprop="name" style="display: none"><?= $item->title ?></span>
  </div><!--product-block-->
</div>
<!--/col-->
<!-- end: Product -->
