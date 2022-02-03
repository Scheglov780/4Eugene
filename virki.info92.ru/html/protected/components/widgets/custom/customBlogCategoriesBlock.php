<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="customBlogCategoriesBlock.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

/**
 * Class customBlogCategoriesBlock - виджет списка категорий блогов
 */
class customBlogCategoriesBlock extends customBlogBlock
{
    public function run()
    {
        $model = new BlogCategories('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['BlogCategories'])) {
            $model->attributes = $_GET['BlogCategories'];
        }
        if (!$this->_viewPath) {
            if ($this->adminMode) {
                $this->_viewPath = 'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.blogs';
            } else {
                $this->_viewPath = 'themeBlocks.blogs';
            }
        }
        if (!$this->_viewFileInPath) {
            $this->_viewFileInPath = 'categories_index';
        }
        $this->render(
          $this->_viewPath . '.' . $this->_viewFileInPath,
          [
            'model' => $model,
          ]
        );
    }
}
