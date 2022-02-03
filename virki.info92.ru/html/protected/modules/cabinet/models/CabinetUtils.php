<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserUtils.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CabinetUtils
{
    public static function adminMenu($id, $href, $name, $title, $icon = false, $reloadable = true)
    {
        $divid = $id . '-a';
        $_reloadable = ($reloadable ? 'true' : "false");
        $safeName = addslashes($name);
        if (in_array($href, ['#', 'javascript:void(0);'])) {
            $res = "<a id='{$divid}' href='{$href}'>";
        } else {
            $res =
              "<a id='{$divid}' href='{$href}' onclick='getContent(this,\"{$safeName}\",{$_reloadable}); return false;'>";
        }
        if ($icon) {
            $res = $res . "<i class='fa {$icon}'></i> ";
        }
        $res = $res . "<span>{$name}</span></a>";
        $safeTitle = addslashes($title);
        Yii::app()->clientScript->registerScript(
          "{$divid}-script",
          /** @lang JavaScript */ "
       $('#{$divid}').parent().attr('id','{$id}');
       $('#{$id}').attr({
       'title':'{$safeTitle}',
       'data-toggle':'tooltip',
       'data-placement':'right'
       });
",
          CClientScript::POS_END
        );
        return $res;
    }
} ?>

