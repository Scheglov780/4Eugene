<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserNavigationHistory.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customUserNavigationHistory extends CustomWidget
{
    public $count = false;
    public $type = false;

    public function run()
    {
        if (!$this->type && !$this->count) {
            return;
        }
        $links = false;//SiteLog::getPagesHistory($this->type, $this->count);
        if ($links) {
            $this->render('themeBlocks.UserNavigationHistory.UserNavigationHistory', ['links' => $links]);
        }
    }
}
