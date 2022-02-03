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

/**
 * Class customBlogAttachedBlock - блок постов (прошу прощения за каламбур) для комментирования товара или категории
 */
class customBlogAttachedBlock extends customBlogBlock
{
    /**
     * @var string - Предварительно отрендеренный шаблон отзыва
     */
    public $body = '';
    /**
     * @var string - Текст, обозначаюший название категории по умолчанию для этого аттача
     */
    public $category = 'No category';
    /**
     * @var int - количество постов на одной странице
     */
    public $pageSize = 25;
    /**
     * @var string - Тэг для этого аттача, например - item345345345 или category345345
     */
    public $tag = 'untagged';
    /**
     * @var string - Заголовок нового поста
     */
    public $title = 'New review';

    public function run()
    {
        $model = new BlogPosts('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BlogPosts'])) {
            $model->attributes = $_GET['BlogPosts'];
        }
        $category = BlogCategories::model()->find('name=:category', [':category' => $this->category]);
        if (!$category) {
            $category = new BlogCategories();
            $category->name = $this->category;
            $category->enabled = 1;
            $category->save();
        }
        if (!$this->condition) {
            $this->condition = 't.enabled=1 and (t.start_date is null or t.start_date <= Now()) and (t.end_date is null or t.end_date >= Now())
                       and t.category_id = :category_id and t.tags ~* :tags';
        }
        if (!count($this->params)) {
            $this->params = [
              ':category_id' => $category->id,
              ':tags'        => "([,;]|^)[[:space:]]*{$this->tag}[[:space:]]*([,;]|$)",
            ];
        }
        $newModel = new BlogPosts();
        //Проверить и создать!
        $newModel->category_id = $category->id;
        $newModel->title = $this->title;
        $newModel->tags = $this->tag;
        $newModel->body = $this->body;
        if (!$this->_viewPath) {
            $this->_viewPath = 'themeBlocks.blogs';
        }
        if (!$this->_viewFileInPath) {
            $this->_viewFileInPath = 'attached_index';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'model' => $model,
            'newModel' => $newModel,
          ]
        );
    }
}
