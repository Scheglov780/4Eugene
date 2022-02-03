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

class customBlogBlock extends CustomWidget
{
    /**
     * @var string Файл представления (view) виджета в папке _viewPath
     */
    public $_viewFileInPath = '';
    /**
     * @var string Путь к представлению (view) виджета
     */
    public $_viewPath = '';
    /**
     * @var bool Виджет вызывается из админки?
     */
    public $adminMode = true;
    /**
     * @var string Условие where для фильтра категорий
     */
    public $condition = '';
    /**
     * @var array Параметры для условия where фильтра категорий $condition
     */
    public $params = [];
    /*
        public function run()
        {
            $model = new BlogPosts('search');
            $model->unsetAttributes();  // clear any default values
            if (isset($_GET['BlogPosts'])) {
                $model->attributes = $_GET['BlogPosts'];
            }
            $category = BlogCategories::model()->find('name=:category', array(':category' => $this->category));
            if (!$category) {
                $category = new BlogCategories();
                $category->name = $this->category;
                $category->enabled = 1;
                $category->save();
            }
            $this->condition = 't.enabled=1 and (t.start_date is null or t.start_date <= Now()) and (t.end_date is null or t.end_date >= Now())
                           and t.category_id = :category_id and t.tags RLIKE :tags';
            $this->params = array(
              ':category_id' => $category->id,
              ':tags'        => "([,;]|^)[[:space:]]*{$this->tag}[[:space:]]*([,;]|$)"
            );
            $newModel = new BlogPosts();
            //Проверить и создать!
            $newModel->category_id = $category->id;
            $newModel->title = $this->title;
            $newModel->tags = $this->tag;
            $newModel->body = $this->body;
            $this->render(
              'themeBlocks.blogs.attached_index',
              array(
                'model'    => $model,
                'newModel' => $newModel
              )
            );
        }
    */
}
