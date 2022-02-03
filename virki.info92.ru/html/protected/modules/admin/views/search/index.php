<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/
?>
<? /* if (!$isAjax) { ?>
<div id="admin-search-content" class="well form-search">
    <? } */ ?>
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Результаты поиска') ?>
    <small><?= Yii::t('main', 'Вы искали') ?>: <strong><?= $model->query ?></strong></small>
  </h1>
    <? /*
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">Buttons</li>
        </ol>
        */ ?>
</section>
<!-- Main content -->
<section class="content">
    <? /*        <div class="row">
            <div class="col-xs-12">

    <div class="search-form">
        <?php $this->renderPartial('_search', array('model' => $model)); ?>
    </div>
    <!-- search-form -->
            </div>
        </div>
*/ ?>
  <div class="row">
    <div class="col-xs-12">
        <?php
        if ($model->query) {
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'admin-search-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->search(),
                  //'filter'       => FALSE,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'header' => Yii::t('main', 'Ссылка'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        try {
                            if (isset($data['type']) && method_exists($data['type'], 'getUpdateLink')) {
                                $result = $data['type']::getUpdateLink($data['pk']);
                            } else {
                                $result = '::getUpdateLink: ' . Yii::t('main', 'нет данных');
                            }
                            return $result;
                        } catch (Exception $e) {
                            return (isset($data['type']) ? $data['type'] : '') . '::getUpdateLink: ' . Yii::t(
                                'main',
                                'нет данных'
                              ) . ' (e)';
                        }
                    },
                  ],
                  [
                    'header' => Yii::t('main', 'Описание'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        try {
                            if (isset($data['type']) && method_exists($data['type'], 'getModelSearchSnippet')) {
                                $result = $data['type']::getModelSearchSnippet($data['pk'], $data['query']);
                            } else {
                                $result = '::getModelSearchSnippet: ' . Yii::t('main', 'нет данных');
                            }
                            return $result;
                        } catch (Exception $e) {
                            return (isset($data['type']) ? $data['type'] : '') . '::getModelSearchSnippet: ' . Yii::t(
                                'main',
                                'нет данных'
                              ) . ' (e)';
                        }
                    },
                  ],
                ],
              ]
            );
        } else {
            ?>
          <div><?= ($isAjax) ? Yii::t('main', 'Увы, ничего не найдено. Уточните запрос и повторите поиск...') :
                Yii::t(
                  'main',
                  'Введите имя или id клиента, трек-код и т.п.'
                ); ?></div>
        <? } ?>
    </div>
  </div>
</section>
<? /* if (!$isAjax) { ?>
</div>
<? } */ ?>
