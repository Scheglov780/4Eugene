<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="userBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customuserBlock extends CustomWidget
{

    function run()
    {
        $isGuest = Yii::app()->user->isGuest;
        if (!$isGuest) {
            $user = (Yii::app()->user->email ? Yii::app()->user->email : Yii::app()->user->phone);
        } else {
            $user = '';
        }

        $this->render('themeBlocks.userBlock.userBlock', ['guest' => $isGuest, 'user' => $user]);
    }

}