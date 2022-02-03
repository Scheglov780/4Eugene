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
/** @var Tariffs $model */
Yii::app()->clientScript->registerScript(
  'search',
  /** @lang JavaScript */
  "
$('#tariffs-search-button').click(function(){
    $('#tariffs-search-form-section').slideToggle('fast');
    return false;
});
$('#tariffs-search-form form').submit(function(){
    $.fn.yiiGridView.update('tariffs-grid', {
        data: $(this).serialize()
    });
    return false;
});
"
);

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Тарифы') ?>
    <small><?= Yii::t('main', 'Расценки за ресурсы, ставки взносов...') ?></small>
      <?= Utils::getHelp('index', true) ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
          'booster.widgets.TbMenu',
          [
            'type'  => 'pills',
            'items' => [
                //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
              [
                'label'       => Yii::t('main', 'Новая запись'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_tariffs ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'tariffs-search-button', 'class' => 'search-button'],
              ],
              [
                'label'       => Yii::t('main', 'Excel'),
                'icon'        => 'fa fa-download',
                'url'         => Yii::app()->controller->createUrl('GenerateExcel'),
                'linkOptions' => ['target' => '_blank'],
                'visible'     => true,
              ],
            ],
          ]
        );
        ?>

      <div class="row">
        <div class="col-md-12">
          <section id="tariffs-search-form-section" class="search-form" style="display:none">
              <?php $this->renderPartial(
                '_search',
                [
                  'model' => $model,
                ]
              ); ?>
          </section><!-- search-form -->
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список тарифов') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'tariffs-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',//
                'dataProvider'    => $model->search(),
                'filter'          => $model,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'type'  => 'raw',
                    'name'  => 'tariffs_id',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return $data->tariffs_id;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'tariff_name',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return $data->tariff_name;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'tariff_short_name',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return $data->tariff_short_name;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'tariff_description',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return $data->tariff_description;
                    },
                  ],
                    /* array(
                       'type'  => 'raw',
                       'name'  => 'tariff_rules',
                       'value' => function ($data, $row) {
                           ///** @var Tariffs $data /
                           return $data->tariff_rules;
                       },
                     ), */
                  [
                    'type'  => 'raw',
                    'name'  => 'created',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return Utils::pgDateToStr($data->created);
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'comments',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return $data->comments;
                    },
                  ],
                  [
                    'name'           => 'enabled',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->enabled==1',
                    'header'         => Yii::t('main', 'Вкл'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'acceptor_name',
                    'value' => function ($data, $row) {
                        /** @var Tariffs $data */
                        return $data->acceptor_name;
                    },
                  ],

                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        /** @var Tariffs $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_tariffs ("<?= $data->tariffs_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_tariffs ("<?= $data->tariffs_id ?>")'
                           class='btn btn-default btn-sm'><i
                              class='fa fa-trash'></i></a>
                      </div>
                    <? },
                      //'htmlOptions' => array('style' => 'width:135px;')
                  ],

                ],
              ]
            );

            $this->renderPartial("_ajax_update");
            $this->renderPartial("_ajax_create_form", ["model" => $model]);
            ?>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row<?= (Utils::isDeveloperIp() ? '' : ' hide') ?>">
    <div class="col-md-12">
      <div class="box box-default collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Черновики для разработчиков</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
          <!-- /.box-tools -->
        </div>
        <!-- /.box-header -->
        <div class="box-body" style="display: none;">
          <img class="img-responsive pad" src="/images/TZ/006-struktura-tarify.jpg">
          <img class="img-responsive pad" src="/images/TZ/006-1-Novaya-usluga.jpg">
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
<!-- /.content -->

<script type="text/javascript">
    function delete_record_tariffs(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;


        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/tariffs/delete"); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('tariffs-grid', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>


