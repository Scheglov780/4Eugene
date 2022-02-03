<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchItem.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class customSearchItem extends CustomWidget
{

    public $catPath = '';
    public $disableItemForSeo = true;
    public $imageFormat = '_160x160.jpg';
    public $newLine = null;
    public $number = null;
    public $searchCat = '';
    public $searchQuery = '';
    public $searchResItem = false;
    public $showControl = null;

    public function run()
    {
        if (!$this->searchResItem) {
            return;
        }
        if (is_null($this->newLine)) {
            $this->newLine = '';
        }
        if (is_null($this->showControl)) {
            $this->showControl = Yii::app()->user->checkAccess('admin/Featured/Add');
        }
        if ($this->disableItemForSeo) {
            $this->disableItemForSeo =
              false;//!Item::isItemCached($this->searchResItem->ds_source, $this->searchResItem->num_iid);
        }
        if (false && !isset($this->searchResItem->weight)) {
            $this->searchResItem->weight = Weights::getItemWeight(
              $this->searchResItem->ds_source,
              $this->searchResItem->cid,
              $this->searchResItem->num_iid
            );
        }

        $this->render(
          'themeBlocks.SearchItem.SearchItem',
          [
            'number'            => $this->number,
            'item'              => $this->searchResItem,
            'catPath'           => (isset($this->catPath) ? $this->catPath : ''),
            'searchCat'         => (isset($this->searchCat) ? $this->searchCat : ''),
            'searchQuery'       => (isset($this->searchQuery) ? $this->searchQuery : ''),
            'newLine'           => $this->newLine,
            'showControl'       => $this->showControl,
            'disableItemForSeo' => $this->disableItemForSeo,
            'imageFormat'       => $this->imageFormat,
            'lazyLoad'          => DSConfig::getVal('site_images_lazy_load') == 1,
          ]
        );
    }
}
