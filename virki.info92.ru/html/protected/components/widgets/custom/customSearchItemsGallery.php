<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchItemsList.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class customSearchItemsGallery extends CustomWidget
{
    public $controlAddToFavorites = false;
    public $controlAddToFeatured = false;

//  public $searchResItem = FALSE;
//  public $newLine = NULL;
    public $controlDeleteFromFavorites = false;
    public $dataProvider = false;
    public $dataType = false;
    public $disableItemForSeo = true;
    public $id = 'searchItemsGallery';
    public $imageFormat = '_160x160.jpg';
    public $itemBlockClass = 'col-lg-3 col-md-3 col-sm-4 col-xs-6';
    public $lazyLoad = true;
    public $loadJs = true;
    public $magicScrollExtraOptions = "'items': 4,'width': 720,'speed': 4000,'height': 180,'arrows': 'outside','arrows-opacity': 20,
                                      'arrows-hover-opacity': 100,'step': 4,'item-tag': 'div'";
    public $showControl = null;
    public $totalCount = 100;

    public function run()
    {
        if (!$this->dataProvider && !$this->dataType) {
            return;
        }
        if (!$this->dataProvider) {
            switch ($this->dataType) {
                case 'itemsRecommended':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'recommended',
                      $this->totalCount,
                      true
                    );*/
                    break;
                case 'itemsPopular':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'popular',
                      $this->totalCount,
                      true
                    ); */
                    break;
                case 'itemsRecentUser':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'recentUser',
                      $this->totalCount,
                      true
                    );*/
                    break;
                case 'itemsRecentAll':
                    $this->dataProvider = null; /* customSearchLocal::getFeatured(
                      'recentAll',
                      $this->totalCount,
                      true
                    ); */
                    break;
                case 'itemsFavorite':
                    $this->dataProvider = null;/* customSearchLocal::getFeatured(
                      'favorite',
                      $this->totalCount,
                      true
                    ); */
                    break;
                default:
                    return;
                    break;
            }
        }
        if (!$this->dataProvider) {
            echo Yii::t('main', 'Нет данных');
            return;
        }
//== Weight calculation ========================
        if (is_array($this->dataProvider)) {
            $data = $this->dataProvider;
        } else {
            $data = $this->dataProvider->getData();
        }
        //TODO: Уже посчитано ранее!
        //Weights::getItemWeightForArray($data);
        if (is_array($this->dataProvider)) {
            $this->dataProvider = $data;
        } else {
            $this->dataProvider->setData($data);
        }
//==============================================
        if (is_null($this->showControl)) {
            $this->showControl = Yii::app()->user->checkAccess('Favorite/Add');
        }

        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.widgets.SearchItemsGallery.SearchItemsGallery',
          [],
          false
        );
    }
}
