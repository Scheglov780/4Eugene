<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogAttachedBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class customSendMessageBlock extends CustomWidget
{
    /**
     * @var bool widget as button?
     */
    public $asButton = true;
    public $email = '';
    public $id = null;
    /**
     * @var string
     */
    public $label = 'New message';
    public $message = '';
    public $name = '';
    public $subj = '';
    /**
     * @var bool
     */
    public $useCaptcha = true;
    /**
     * @var string|null use sender email as from email?
     */
    public $useEmailAsSender = true;

    public function run()
    {
        if (!$this->id) {
            $this->id = uniqid('sendMessage-');
        }
        $model = new SendMessageForm();
        if ($this->email) {
            $model->email = $this->email;
        }
        if ($this->name) {
            $model->name = $this->name;
        }
        if ($this->subj) {
            $model->subj = $this->subj;
        }
        if ($this->message) {
            $model->message = $this->message;
        }
        $this->render(
          'themeBlocks.SendMessageBlock.sendMessage',
          ['model' => $model]
        );
    }
}
