<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchItem.php">
 * </description>
 * Виджет, реализующий отображение товара в поисковой выдаче
 * var $newLine = ' first' - разница в рендеринге для виджета товара, начинающего новую строку в выдаче
 * var $showControl = true - отображать ли всякие "Добавить в избранное", "Добавить в рекомендованное" и т.п.
 * var $disableItemForSeo =  true - запрещать индексировать карту товара
 * var $imageFormat = '_160x160.jpg'
 * var $lazyLoad = true - ленивая загрузка изображений
 **********************************************************************************************************************/
?>
<!-- Product -->
<?
/**
 * @var customSearchItemResult $item
 */
?>
<div class="col-lg-4 col-xs-12 col-sm-6">
  <div class="singleProject">
    <div id="item<?= $item->num_iid ?>" itemscope itemtype="http://schema.org/Product">
      <meta itemprop="name" content="<?= $item->title ?>">
      <a href="<?= Yii::app()->createUrl(
        '/item/index',
        [
          'catpath' => $catPath,
          'dsSource' => $item->ds_source,
          'iid' => $item->num_iid,
        ]
      ) ?>"
         target="_blank"
        <?= ($disableItemForSeo) ? ' rel="nofollow"' : '' ?> title="<?= $item->title ?>">
        <div class="projectImg">
          <img itemprop="image"
               src="<?= Img::getImagePath($item->pic_url, $imageFormat) ?>"
               alt="<?= $item->alt ?>">
        </div>
      </a>
      <p>
          <?= $item->title ?>
      </p>
    </div>
  </div>
</div>