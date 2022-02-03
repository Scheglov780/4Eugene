<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="currencyBlock.php">
 * </description>
 * Виджет переключателя валют фронта сайта
 * $currency = cny - текущая выбранная валюта
 **********************************************************************************************************************/
?>
<? $currency_array = explode(',', DSConfig::getVal('site_currency_block'));
foreach ($currency_array as $val) {
    if ($currency == $val) {
        continue;
    }
    ?>
    <? if (count($currency_array) > 1) { ?>
    <li class="currency-block">
      <a rel="nofollow" href="/user/setcurrency?curr=<?= $val ?>"><?= strtoupper($val) ?></a>
    </li>
    <? } ?>
<? } ?>