<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="MessagesBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customMessagesBlock extends CustomWidget
{

    public function run()
    {
        $messages = Yii::app()->user->getFlashes();
        if (count($messages)) {
            $this->render('themeBlocks.MessagesBlock.messages', ['messages' => $messages]);
        }
    }
}