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

class customcurrencyBlock extends CustomWidget
{

    function run()
    {
        $currency = DSConfig::getCurrency();
        $this->render('themeBlocks.currencyBlock.currencyBlock', ['currency' => $currency]);
    }

}