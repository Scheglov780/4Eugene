<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BrandsBlock.php">
 * </description>
 * Виджет отображает карусель логотипов брендов на главной
 * $brands - массив моделей Brands
 * = Array of
 * Array(
 * [id] => 373
 * [name] => Fossil
 * [enabled] => 1
 * [img_src] => brand_logo_27.jpg
 * [vid] => 46470
 * [query] => Fossil
 * [url] => fossil
 * )
 **********************************************************************************************************************/
?>

<? if ($this->dataProvider && is_array($this->dataProvider)) {
    if ($this->loadJs) {
        Yii::app()->clientScript->registerCssFile($this->frontThemePath . '/css/magicscroll.css', 'screen');
        Yii::app()->clientScript->registerScriptFile(
          $this->frontThemePath . '/js/' . (YII_DEBUG ? 'magicscroll.js' : 'magicscroll.min.js'),
          CClientScript::POS_END
        );
    }
    ?>
  <script>
      MagicScroll.extraOptions.<?=$this->id?> = {
          <?=$this->magicScrollExtraOptions ?>
      };
  </script>

  <div class="MagicScroll msborder" id="<?= $this->id ?>">
      <? foreach ($this->dataProvider as $data) { ?>
          <? $this->render(
            'webroot.themes.' . $this->frontTheme . '.views.widgets.SearchItemsList.SearchGalleryItem',
            [
              'data'                       => $data,
              'showControl'                => $this->showControl,
              'disableItemForSeo'          => $this->disableItemForSeo,
              'imageFormat'                => $this->imageFormat,
              'controlAddToFavorites'      => $this->controlAddToFavorites,
              'controlAddToFeatured'       => $this->controlAddToFeatured,
              'controlDeleteFromFavorites' => $this->controlDeleteFromFavorites,
              'lazyLoad'                   => false,
            ],
            false
          );
          ?>
      <? } ?>
  </div>
    <? if (!$this->loadJs) { ?>
    <script>
        if (!$('#<?=$this->id?>').is(':visible')) {
            MagicScroll.init(document.getElementById('<?=$this->id?>').parentNode);
        }
    </script>
    <? } ?>
<? } ?>