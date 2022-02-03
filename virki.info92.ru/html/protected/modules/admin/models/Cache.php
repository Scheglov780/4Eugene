<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Cache.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class Cache
{
    public static function getDirectorySize($path)
    {
        $totalsize = 0;
        $totalcount = 0;
        $dircount = 0;
        $handle = opendir($path);
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                $nextpath = $path . '/' . $file;
                if ($file != '.' && $file != '..' && !is_link($nextpath)) {
                    if (is_dir($nextpath)) {
                        $dircount++;
                        $result = self::getDirectorySize($nextpath);
                        $totalsize += $result['size'];
                        $totalcount += $result['count'];
                        $dircount += $result['dircount'];
                    } elseif (is_file($nextpath)) {
                        $totalsize += filesize($nextpath);
                        $totalcount++;
                    }
                }
            }
        }
        closedir($handle);
        $total['size'] = $totalsize;
        $total['count'] = $totalcount;
        $total['dircount'] = $dircount;
        $total['free'] = disk_free_space($path); //Yii::app()->fileCache->cachePath
        return $total;
    }

    public static function sizeFormat($size)
    {
        if ($size < 1024) {
            return $size . " bytes";
        } else {
            if ($size < (1024 * 1024)) {
                $size = round($size / 1024, 1);
                return $size . " KB";
            } else {
                if ($size < (1024 * 1024 * 1024)) {
                    $size = round($size / (1024 * 1024), 1);
                    return $size . " MB";
                } else {
                    $size = round($size / (1024 * 1024 * 1024), 1);
                    return $size . " GB";
                }
            }
        }

    }
}