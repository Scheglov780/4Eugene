<?
/**
 * @var BlogGalleryBlock $this
 * @var BlogPosts        $model
 */
?>
<div class="row">
    <?
    $this->widget(
      'booster.widgets.TbListView',
      [
        'id'            => $this->id,
        'ajaxUrl'       => ($this->ajaxUrl ? $this->ajaxUrl : null),
        'dataProvider'  => $model->search($this->pageSize, $this->condition, $this->params, 'BlogPostsDP-' . $this->id),
        'itemView'      => 'webroot.themes.' . $this->frontTheme . '.views.widgets.blogs.' . $this->itemView,
          /*    'viewData'        => array(
                'showControl'                => $this->showControl,
                'disableItemForSeo'          => $this->disableItemForSeo,
                'imageFormat'                => $this->imageFormat,
                'controlAddToFavorites'      => $this->controlAddToFavorites,
                'controlAddToFeatured'       => $this->controlAddToFeatured,
                'controlDeleteFromFavorites' => $this->controlDeleteFromFavorites,
                'lazyLoad'                   => $this->lazyLoad,
                'itemBlockClass'             => $this->itemBlockClass,
              ),
          */
        'enableSorting' => false,
        'template'      => $this->template,

        'pagerCssClass' => 'pagination',
        'pager'         => [
          'class'          => 'TbSEOLinkPager',
          'header'         => false,
            //'maxButtonCount'  => 0,
          'firstPageLabel' => '',
          'lastPageLabel'  => '',
            //'linkHtmlOptions' => array('rel' => 'nofollow'),
            //'cssFile'=>false,
          'prevPageLabel'  => '&lt;',
          'nextPageLabel'  => '&gt;',
        ],
//    'afterAjaxUpdate' => $afterAjaxUpdate,
      ]
    );
    ?>
</div>

