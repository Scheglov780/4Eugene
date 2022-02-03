<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="sliderBlock.php">
 * </description>
 * Рендеринг слайдера баннеров на главной
 **********************************************************************************************************************/ ?>
<?

class customsliderBlock extends CustomWidget
{

    function run()
    {
        $banners = Banners::model()->findAllBySql(
          "select * from banners bb 
                   where bb.enabled=1
                    and (bb.front_theme = :front_theme or bb.front_theme = '' or bb.front_theme is null)
                   order by bb.banner_order ASC",
          [
            'front_theme' => $this->frontTheme,
          ]
        );
        if ($banners) {
            foreach ($banners as $banner) {
                try {
                    $banner->html_content = cms::render($banner->html_content, Utils::appLang());
                } catch (Exception $e) {
                    continue;
                }
            }
        }
        $this->render('themeBlocks.sliderBlock.sliderBlock', ['banners' => $banners], false, true);
    }

}