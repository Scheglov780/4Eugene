<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="warehousePlaceItemsItem.php">
 * </description>
 **********************************************************************************************************************/
?>
<div class="product">
    <?
    $filePath = Img::imglibGetPath($data['path'], $data['filename']);
    $url = Img::imglibPathToUrl($filePath);
    ?>
  <div style="text-align: right;">
    <a class="fa fa-pencil" style="display:inline-block; cursor: pointer;"
       title="<?= Yii::t('main', 'Изменить') ?>"
       href="javascript:void(0);"
       onclick="renderUpdateForm_imagelib('<?= $data['id'] ?>'); return false;"></a>
  </div>
  <div class="product-image">
    <img class="lazy"
         src="<?= Yii::app()->request->baseUrl ?>/themes/<?= DSConfig::getVal(
           'site_front_theme'
         ) ?>/images/zoomloader.gif"
         data-original="<?= Img::getSubdomainPath($url) ?>" alt="" title=""/>
  </div>
</div>