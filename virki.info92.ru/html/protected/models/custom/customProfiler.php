<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Profiler.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customProfiler
{
    protected static $session_name = 'profiler';

    public static function get()
    {
        $session = Yii::app()->session;
        $arr = $session[self::$session_name];
        return $arr;
    }

    public static function message($name, $text)
    {
        $session = Yii::app()->session;
        $arr = $session[self::$session_name];
//     if (isset($arr[$name])) {
//     $arr[$name]=$text;
//     } else {
        $arr[] = '*' . $name . ': ' . $text;
//     }
        Yii::app()->session->add(self::$session_name, $arr);
    }

    public static function start($name, $new = false)
    {
        if ($new) {
            Yii::app()->session->add(self::$session_name, ['start' => microtime(true)]);
        }
        $session = Yii::app()->session;
        $arr = $session[self::$session_name];
        $arr[$name] = microtime(true);
        Yii::app()->session->add(self::$session_name, $arr);
    }

    public static function stop($name, $final = false)
    {
        $session = Yii::app()->session;
        $arr = $session[self::$session_name];
        if (isset($arr[$name])) {
            $arr[$name] = round(microtime(true) - $arr[$name], 2);
        } else {
            $arr[$name] = 0;
        }
        if ($final) {
            $arr['stop'] = microtime(true);
            if (isset($arr['stop']) && (isset($arr['start']))) {
                $arr['duration'] = round($arr['stop'] - $arr['start'], 2);
            } else {
                $arr['duration'] = 0;
            }
        }
        Yii::app()->session->add(self::$session_name, $arr);
    }
}