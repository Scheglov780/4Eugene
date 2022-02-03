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

class customsliderContactsBlock extends CustomWidget
{

    function run()
    {
        $this->render('themeBlocks.sliderContactsBlock.sliderContactsBlock', [], false, true);
    }

}