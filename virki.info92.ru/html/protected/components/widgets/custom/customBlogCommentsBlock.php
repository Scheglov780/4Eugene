<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogCommentsBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

/**
 * Class customBlogCommentsBlock - отображение списка комментариев к посту
 */
class customBlogCommentsBlock extends customBlogBlock
{
    /**
     * @var string - права доступа к комментариям
     */
    public $accessRightsComment = '';
    /**
     * @var string - права доступа к посту
     */
    public $accessRightsPost = '';
    /**
     * @var int - количество комментариев на одной странице
     */
    public $pageSize = 25;
    /**
     * @var bool - разрешено ли добавление комментариев?
     */
    public $postCommentsEnabled = false;
    /**
     * @var int - id поста блога
     */
    public $postId = 0;

    public function run()
    {
        $model = new BlogComments('search');
        $model->unsetAttributes();  // clear any default values
        $model->post_id = $this->postId;
        if (isset($_GET['BlogComments'])) {
            $model->attributes = $_GET['BlogComments'];
        }
        if (!$this->_viewPath) {
            if ($this->adminMode) {
                $this->_viewPath = 'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.blogs';
            } else {
                $this->_viewPath = 'themeBlocks.blogs';
            }
        }
        if (!$this->_viewFileInPath) {
            $this->_viewFileInPath = 'comments_index';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'model' => $model,
          ]
        );
    }
}
