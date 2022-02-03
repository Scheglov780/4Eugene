<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogGalleryBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

/**
 * Class customBlogGalleryBlock - галерея блогов
 */
class customBlogGalleryBlock extends customBlogBlock
{
    /**
     * @var null|string - URL на действие контроллера для обработки ajax-запросов
     */
    public $ajaxUrl = null;
    /**
     * @var bool|string - html-атрибут id для блока
     */
    public $id = false;
    /**
     * @var string - отображение элемента списка галереи
     */
    public $itemView = 'gallery_view';
    /**
     * @var int - размер страницы
     */
    public $pageSize = 8;
    /**
     * @var string - шаблон вывода пагинатора и записей
     */
    public $template = '{pager}{items}';

    public function run()
    {
        if (!$this->id) {
            $this->id = 'blog-gallery-block';
        }
        $model = new BlogPosts('search');
        $model->unsetAttributes();
        if (!$this->_viewPath) {
            $this->_viewPath = 'themeBlocks.blogs';
        }
        if (!$this->_viewFileInPath) {
            $this->_viewFileInPath = 'gallery_index';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'model' => $model,
          ]
        );
    }
}
