<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSGUtils.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DSGUtils
{
    public static function encode($string, $password = false)
    {
        if (!$password) {
            $password = Yii::app()->getBaseUrl(true);
        }
        $salt = 'BCurGWEtSweQFMN8';
        $strLen = strlen($string);
        $seq = $password;
        $gamma = '';
        while (strlen($gamma) < $strLen) {
            $seq = pack("H*", sha1($gamma . $seq . $salt));
            $gamma .= substr($seq, 0, 8);
        }
        return ($string ^ $gamma);
    }

    public static function parseChineseNumber($n)
    {
        $resstr = [];
        if ($n > 0) {
            $zhnum = $n;
            $res = preg_match('/([\d\.]+)/i', $zhnum, $resstr);
            if ($res > 0) {
                if (($zhnum != $resstr[1]) || (strpos($resstr[0], '.') > 0)) {
                    $resnum = round((float) $resstr[1] * 10000);
                } else {
                    $resnum = $zhnum;
                }
            } else {
                $resnum = 0;
            }
        } else {
            $resnum = 0;
        }
        return $resnum;
    }
}