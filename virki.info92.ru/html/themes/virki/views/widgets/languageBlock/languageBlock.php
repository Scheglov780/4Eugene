<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="languageBlock.php">
 * </description>
 * Виджет переключателя языков фронта сайта
 * $lang_array
 **********************************************************************************************************************/
?>
<?
Yii::app()->clientScript->registerCssFile($this->frontThemePath . '/css/flags/16x16/sprite-flags-16x16.css');
?>
<? if (count($lang_array) > 1) { ?>
    <? foreach ($lang_array as $val) {
        if (Yii::app()->language == $val) {
            continue;
        }
        ?>
    <li>
      <a rel="nofollow" title="<?= Utils::langToLangName($val) ?>" href="/user/setlang/<?= $val ?>">
        <i class="flag flag-16 flag-<?= Utils::langToCountry($val) ?>"></i><?= Utils::langToLangName($val) ?>
      </a>
    </li>
    <? } ?>
<? } ?>
