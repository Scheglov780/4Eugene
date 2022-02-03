<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogCommentBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

/**
 * Class customBlogCommentBlock - отображение комментария к посту
 */
class customBlogCommentBlock extends customBlogBlock
{
    /**
     * @var null|BlogComments - объект или запись комментария к посту
     */
    public $commentData = null;
    /**
     * @var int - id комментария
     */
    public $commentId = 0;
    /**
     * @var int - максимальная длина текста превью комментария
     */
    public $textLength = 0;

    public function run()
    {
        if (!$this->commentData) {
            if ($this->commentId) {
                $model = BlogComments::model()->findByPk($this->commentId);
                if ($model) {
                    $this->commentData = $model;
                }
            }
        }
        if (!$this->_viewPath) {
            if ($this->adminMode) {
                $this->_viewPath = 'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.blogs';
            } else {
                $this->_viewPath = 'themeBlocks.blogs';
            }
        }
        if (!$this->_viewFileInPath) {
            $this->_viewFileInPath = 'comment_view';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'commentData' => $this->commentData,
          ]
        );
    }
}
