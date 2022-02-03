<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var Votings $model */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Голосования') ?>
    <small><?= Yii::t('main', 'только для членов товарищества, с соблюдением Устава и требований ФЗ...') ?></small>
      <?= Utils::getHelp('index', true) ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">
    <? /* <div class="row">
         <div class="col-xs-12">
             <?php $this->widget(
               'booster.widgets.TbMenu',
               array(
                 'type'  => 'pills',
                 'items' => array(
                     //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
               /*    array(
                     'label'       => Yii::t('main', 'Новое голосование'),
                     'icon'        => 'fa fa-plus',
                     'url'         => 'javascript:void(0);',
                     'linkOptions' => array('onclick' => 'renderCreateForm_votings ()'),
                     'visible'     => true,
                   ), * /
                 ),
               )
             );
             ?>
         </div>
     </div> */ ?>

  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список голосований') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <? $this->widget(
              'booster.widgets.TbListView',
              [
                'id'            => 'cabinet-votings-list-view',
                  //'ajaxUrl'       => Yii::app()->request->requestUri,
                  //'ajaxUpdate'    => true,
                'dataProvider'  => $dataProvider,
                'itemView'      => 'index_list_message_view',
                'enableSorting' => false,
                'template'      => "{summary}{pager}{items}{pager}",
                'summaryText'   => Yii::t('main', 'Опросы') . ' {start}-{end} ' . Yii::t(
                    'main',
                    'из'
                  ) . ' {count}',
              ]
            );
            ?>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->



