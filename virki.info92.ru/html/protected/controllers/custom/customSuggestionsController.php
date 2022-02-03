<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SuggestionsController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customSuggestionsController extends CustomFrontController
{

    public function actionIndex($q = false)
    {
        if ($q <> '' && (!preg_match('/http[s]*|select|delete|[\/\\<>#@&*\.\$!]/is', $q))) {
            echo Suggestions::getSuggestions($q);
        }
    }

}