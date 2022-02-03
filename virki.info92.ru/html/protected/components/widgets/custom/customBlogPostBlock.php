<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogPostBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

/**
 * Class customBlogPostBlock - отображение поста блога
 */
class customBlogPostBlock extends customBlogBlock
{
    /**
     * @var null|BlogPosts - объект или запись поста
     */
    public $blogData = null;
    /**
     * @var int - id поста
     */
    public $blogId = 0;
    /**
     * @var int - количество комментариев на одной странице
     */
    public $commentsPageSize = 25;
    /**
     * @var bool - отображать комментарии
     */
    public $showComments = true;
    /**
     * @var int - максимальная длина текста превью поста
     */
    public $textLength = 0;

    public function run()
    {
        if (!$this->blogData) {
            if ($this->blogId) {
                $model = BlogPosts::model()->findByPk($this->blogId);
                if ($model) {
                    $rec = Yii::app()->db->createCommand(
                      "
         SELECT cc.name AS categoryName,
         cc.access_rights_post AS accessRightsPost, 
        cc.access_rights_comment AS accessRightsComment,
             coalesce(uu.fullname,'unknown') AS authorName,
        (SELECT count(0) as cnt FROM blog_comments bc WHERE bc.post_id = t.id) AS commentsCount,
         (SELECT round(avg(bc.rating)) as res FROM blog_comments bc WHERE bc.post_id = t.id) AS rating
        FROM blog_posts t
        LEFT JOIN blog_categories cc ON cc.id=t.category_id
                                   LEFT JOIN users uu ON uu.uid=t.uid
                                                   WHERE t.id=:id
                "
                    )->queryRow(true, [':id' => $this->blogId]);
                    if ($rec) {
                        $model->categoryName = $rec['categoryName'];
                        $model->accessRightsPost = $rec['accessRightsPost'];
                        $model->accessRightsComment = $rec['accessRightsComment'];
                        $model->authorName = $rec['authorName'];
                        $model->commentsCount = $rec['commentsCount'];
                        $model->rating = $rec['rating'];
                        $this->blogData = $model;
                    }
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
            $this->_viewFileInPath = 'post_preview';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'blogData' => $this->blogData,
          ]
        );
    }
}
