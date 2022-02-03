<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogPostsBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

/**
 * Class customBlogPostsBlock - список постов
 */
class customBlogPostsBlock extends customBlogBlock
{
    /**
     * @var int - количество постов на одну страницу
     */
    public $pageSize = 25;
    /**
     * @var bool - отображать ли комментарии?
     */
    public $showComments = true;

    public function run()
    {
        $model = new BlogPosts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BlogPosts'])) {
            $model->attributes = $_GET['BlogPosts'];
        }
        if (!$this->_viewPath) {
            if ($this->adminMode) {
                $this->_viewPath = 'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.blogs';
            } else {
                $this->_viewPath = 'themeBlocks.blogs';
            }
        }
        if (!$this->_viewFileInPath) {
            $this->_viewFileInPath = 'posts_index';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'model' => $model,
          ]
        );
    }
}
