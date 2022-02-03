<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserNoticeBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customUserNoticeBlock extends CustomWidget
{

    public function run()
    {
        $notices = UserNotice::model()->findAll('uid=:uid', [':uid' => Yii::app()->user->id]);
        if (count($notices)) {
            $this->render('themeBlocks.UserNoticeBlock.UserNotice', ['notices' => $notices]);
        }
    }

}