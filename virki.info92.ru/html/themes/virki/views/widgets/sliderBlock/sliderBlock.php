<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="sliderBlock.php">
 * </description>
 * Виджет отображает слайдер баннеров на главной
 * $banners - массив моделей banners
 **********************************************************************************************************************/
?>

<ul>
    <? foreach ($banners as $banner) { ?>
        <?= $banner->html_content ?>
    <? } ?>
</ul>
<? /* Example Progress Bar, with a height and background color added to its style attribute */ ?>
<? /* <div class=”tp-bannertimer” style="height: 5px; background-color: rgba(0, 0, 0, 0.25);"></div> */ ?>

