<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_images.php">
 * </description>
 * Рендеринг фото товара
 **********************************************************************************************************************/
?>
<? if (isset(Yii::app()->controller->preLoading) && Yii::app()->controller->preLoading) { ?>
  <div class="carousel">
      <? if (DSConfig::getVal('site_images_lazy_load') == 1) { ?>
        <img class="lazy"
             src="<?= Yii::app()->request->baseUrl ?>/themes/<?=
             Yii::app()->theme->name ?>/images/Hourglass.png"
             data-original="<?= Img::getImagePath($item->top_item->pic_url, '_360x360.jpg', false) ?>"
             alt="">
        <noscript><img itemprop="image"
                       src="<?= Img::getImagePath($item->top_item->pic_url, '_360x360.jpg', false) ?>"
                       alt=""></noscript>
          <?
      } else {
          ?>
        <img itemprop="image"
             src="<?= Img::getImagePath($item->top_item->pic_url, '_360x360.jpg', false) ?>"
             alt="">
      <? } ?>
  </div>
<? } else { ?>
  <div class="carousel">
    <a id="Zoomer" href="<?= Img::getImagePath($item->top_item->pic_url, '', false) ?>"
       class="MagicZoom"
       data-options="zoomMode: magnifier;
            lazyZoom: true;
            selectorTrigger: hover;
            rightClick: true;
            expandCaption: false;
            textHoverZoomHint: <?= Yii::t('main', 'Курсор для увеличения') ?>;
            textClickZoomHint: <?= Yii::t('main', 'Клик для увеличения') ?>;
            textExpandHint: <?= Yii::t('main', 'Клик для просмотра') ?>"
       data-mobile-options="textTouchZoomHint: <?= Yii::t('main', 'Прикоснитесь для увеличения') ?>;
           textClickZoomHint: <?= Yii::t('main', 'Два клика для увеличения') ?>;
           textExpandHint: <?= Yii::t('main', 'Клик для просмотра') ?>"
       title="">
        <? if (isset($item->top_item->pic_url) && ($item->top_item->pic_url != '')) { ?>
          <img itemprop="image" src="<?= Img::getImagePath($item->top_item->pic_url, '_770x497.jpg', false) ?>"/>
        <? } ?>
    </a>
  </div>
  <div class="carousel-indicators-mz">
      <? foreach ($item->top_item->item_imgs->item_img as $image) { ?>
        <a data-zoom-id="Zoomer" href="<?= Img::getImagePath($image->url, '', false) ?>"
           data-image="<?= Img::getImagePath($image->url, '_770x497.jpg', false) ?>">
          <img src="<?= Img::getImagePath($image->url, '_169x109.jpg', false) ?>"/>
        </a>
      <? } ?>
  </div>
<? } ?>
