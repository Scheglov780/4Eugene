<section class="blogSection">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="comment">
          <div class="commentList">
              <?
              $this->widget(
                'booster.widgets.TbListView',
                [
                  'id'              => 'adverts-list-view',
                  'ajaxUrl'         => Yii::app()->request->requestUri,
                  'ajaxUpdate'      => true,
                  'dataProvider'    => $dataProvider,
                  'itemView'        => 'webroot.themes.' . $this->frontTheme . '.views.adverts.index_list_message_view',
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
                  'enableSorting'   => false,
                  'template'        => "{summary}\n{pager}\n{items}\n{pager}",
                  'summaryTagName'  => 'h3',
                  'summaryCssClass' => 'commentTitle',
                  'summaryText'     => Yii::t('main', 'Объявления') .
                    ' {start}-{end} ' .
                    Yii::t('main', 'из') .
                    ' {count}',
                  'pagerCssClass'   => 'pagination',
                  'pager'           => [
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
        </div>
      </div>
    </div>
  </div>
</section>

