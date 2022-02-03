<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="currencyBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customlanguageBlock extends CustomWidget
{

    function run()
    {
        $lang_array = explode(',', DSConfig::getVal('site_language_block'));
        if (count($lang_array) > 1) {
            $this->render('themeBlocks.languageBlock.languageBlock', ['lang_array' => $lang_array]);
        }
    }

}