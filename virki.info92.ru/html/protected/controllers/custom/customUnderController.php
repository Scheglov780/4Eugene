<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UnderController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customUnderController extends CController
{

    public function actionIndex()
    {
        header('HTTP/1.1 503 Service Temporarily Unavailable');
        header('Status: 503 Service Temporarily Unavailable');
        header('Retry-After: 3600');
        $this->renderPartial('webroot.themes.default.views.under.index');
    }

}
