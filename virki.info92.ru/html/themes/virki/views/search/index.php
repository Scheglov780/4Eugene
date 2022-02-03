<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 * Рендеринг поисковой выдачи (вобще любой, по категориям, брэндам, пользователю, запросу и т.п.)
 **********************************************************************************************************************/
?>
<? $seo_disable_items_index = DSConfig::getVal('seo_disable_items_index') == 1; ?>
<!--<div class="row clearfix f-space10"></div>-->
<!-- Shop Page title -->
<section class="commonSection">
  <!-- end: Shop Page title -->
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3>Ничего не найдено</h3>
      </div>
    </div>
      <? if (is_object($res)) { ?>
        <div class="row"><!-- row -->
            <? if (isset($res->error) || !isset($res->items) || (isset($res->items) && !count($res->items))) { ?>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="filterCont">
                  <div class="alert alert-danger">
                    <h3><?= Yii::t(
                          'main',
                          'По Вашему запросу ничего не найдено, уточните Ваш запрос'
                        ) ?></h3>
                  </div>
                </div><!--End:Content-->
              </div><!--End:Col-->

            <? } else { ?>

              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="box-heading category-heading">
                <span>
                    <? if (isset($res->total_results) && ($res->total_results > 0) && isset($pages)) { ?>
                        <? /*<h1>*/ ?>
                        <?= Yii::t('main', 'Показано') ?>
                        <?= $pages->currentPage * $pages->pageSize + 1 ?> - <?= ($pages->currentPage *
                          $pages->pageSize) + count(
                          $res->items
                        ) ?>
                        <?= Yii::t('main', 'из') ?>
                        <?= $res->total_results ?>
                        <? /*</h1>*/ ?>
                    <? } //else { ?>
                    <? /* <div class="alert alert-warning"><?= Yii::t('main', 'Ничего не найдено') ?></div> */ ?>
                    <? //} ?>
                </span>
                  <ul class="nav nav-pills pull-right">
                    <li class="ass">
                        <? if (isset($res->dsSrcLangQuery) && ($res->dsSrcLangQuery)) { ?>
                          <div style="position: relative;">
                              <?= Yii::t('main', 'Поисковый запрос') ?>
                            &nbsp;:&nbsp; <?= $res->dsSrcLangQuery ?>
                          </div>
                        <? } ?>
                    </li>
                      <?
                      if (!isset($res->searchSortParameters) || !is_array($res->searchSortParameters)) {
                          throw new Exception('$res->searchSortParameters undefined!');
                      }
                      $sortOrders = $res->searchSortParameters;
                      if ($sortOrders && count($sortOrders)) {
                          ?>
                        <li class="dropdown">
                          <a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                             href="#">
                              <? $fAction = Yii::app()->createUrl('/' . $this->id . '/index', $params);
                              $sort_by =
                                ((isset($params['sort_by']) && (isset($sorts[$params['sort_by']]))) ?
                                  $params['sort_by'] : 'popularity_desc');
                              echo $sortOrders[$sort_by];
                              ?><i class="fa fa-sort fa-fw"></i>
                          </a>
                          <ul class="dropdown-menu" role="menu">
                              <? foreach ($sortOrders as $sort => $sortName) {
                                  if ($sort == $sort_by) {
                                      continue;
                                  } ?>
                                <li class="raiting-sells">
                                  <a rel="nofollow" href="<?= Yii::app()->createUrl(
                                    '/' . $this->id . '/index',
                                    array_merge($params, ['sort_by' => $sort])
                                  ) ?>"><?= $sortName ?>
                                  </a>
                                </li>
                              <? } ?>
                          </ul>
                        </li>
                      <? } ?>
                  </ul>
                </div><!--End:Box-Heading-->
              </div><!--End:Col-->

            <? } ?>
        </div>

          <? if (isset($res->total_results) && ($res->total_results > 0) && isset($pages)) { ?>
          <div class="row">
            <div class="filterCont">
                <? foreach ($res->items as $i => $item) { ?>
                    <? $this->widget(
                      'application.components.widgets.SearchItem',
                      [
                        'searchResItem' => $item,
                        'imageFormat'   => '_360x360.jpg',
                          //'newLine'       => $newLine,
                        'catPath'       => (isset($category->url) ? $category->url : ''),
                        'searchCat'     => $res->cid,
                        'searchQuery'   => $res->dsSrcLangQuery,
                      ]
                    ); ?><!-- End: Блок товара товароа-->
                <? } ?>

            </div>
          </div>
          <? } ?>

          <? if (isset($res->total_results) && ($res->total_results > 0) && isset($pages)) { ?>
          <span class="pull-left">
                    <?= Yii::t('main', 'Показано') ?>
              <?= $pages->currentPage * $pages->pageSize + 1 ?>
                    - <?= ($pages->currentPage * $pages->pageSize) + count(
                $res->items
              ) ?>
              <?= Yii::t('main', 'из') ?>
              <?= $res->total_results ?>
                </span>
          <? } ?>

          <? if ($pages) { ?><!-- Пагинатор -->
          <div class="pull-right">
              <? $this->renderPartial(
                '/search/pagination',
                [
                  'pages' => $pages,
                ]
              ); ?>
          </div>
          <? } ?>
      <? } ?>
  </div><!-- End: container-->
    <? //====================================================================================================================?>
</section>