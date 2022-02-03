<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="cabinetMenuBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customcabinetMenuBlock extends CustomWidget
{

    function run()
    {
        $newAnswer = Message::model()->count('uid=:uid AND status = 2', [':uid' => Yii::app()->user->id]);
        $render = [
          'newAnswer' => $newAnswer,
        ];
        $this->render('themeBlocks.cabinetMenuBlock.cabinetMenuBlock', $render);
    }

}