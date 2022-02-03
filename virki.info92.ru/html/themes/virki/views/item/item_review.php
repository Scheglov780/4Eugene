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
<a href="<?= $this->createUrl($this->route, $_GET); ?>" target="_blank">
  <div style="float: left;">
    <img src="<?= Img::getImagePath($item->top_item->pic_url, '_120x120.jpg', false) ?>"/>
  </div>
  <div>
    <strong><?= $item->top_item->title ?></strong>
  </div>
</a>
<? if (isset($item->top_item->cat_path)) { ?>
  <br>
  <div>
    <strong><?= Yii::t('main', 'Товар из категории') ?>:</strong>
      <?= ($item->top_item->cat_path ? $item->top_item->cat_path : Yii::t('main', 'прочее')) ?>
  </div>
<? } ?>



