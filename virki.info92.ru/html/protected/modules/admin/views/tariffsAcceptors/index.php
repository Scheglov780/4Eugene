<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ================================================================================================================
 * <description file="index.php">
 * </description>
 ******************************************************************************************************************/ ?>
<?php
/** @var TariffsAcceptors $model */
Yii::app()->clientScript->registerScript(
  'search',
  //** @lang JavaScript */
  "
$('#tariffs-acceptors-search-button').click(function(){
    $('#tariffs-acceptors-search-form-section').slideToggle('fast');
    return false;
});
$('#tariffs-acceptors-search-form form').submit(function(){
    $.fn.yiiGridView.update('tariffs-acceptors-grid', {
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
      <?= Yii::t('main', 'Получатели платежей') ?>
    <small><?= Yii::t('main', 'Реквизиты получателей платежей...') ?></small>
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
                'linkOptions' => ['onclick' => 'renderCreateForm_tariffs_acceptors ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'tariffs-acceptors-search-button', 'class' => 'search-button'],
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
          <section id="tariffs-acceptors-search-form-section" class="search-form" style="display:none;">
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
          <h3 class="box-title"><?= Yii::t('main', 'Список реквизитов получателей платежей') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'tariffs-acceptors-grid',
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
                    'name'  => 'tariff_acceptors_id',
                    'value' => function ($data, $row) {
                        /** @var TariffsAcceptors $data */
                        return $data->tariff_acceptors_id;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'name',
                    'value' => function ($data, $row) {
                        /** @var TariffsAcceptors $data */
                        return $data->name;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'address',
                    'value' => function ($data, $row) {
                        /** @var TariffsAcceptors $data */
                        return $data->address;
                    },
                  ],
                    /* array(
                       'type'  => 'raw',
                       'name'  => 'OGRN',
                       'value' => function ($data, $row) {
                           ///** @var TariffsAcceptors $data /
                           return $data->OGRN;
                       },
                     ),
                     array(
                       'type'  => 'raw',
                       'name'  => 'INN',
                       'value' => function ($data, $row) {
                           ///** @var TariffsAcceptors $data /
                           return $data->INN;
                       },
                     ),
                     array(
                       'type'  => 'raw',
                       'name'  => 'KPPacceptor',
                       'value' => function ($data, $row) {
                           ///** @var TariffsAcceptors $data /
                           return $data->KPPacceptor;
                       },
                     ),
                    */
                  [
                    'type'  => 'raw',
                    'name'  => 'bank',
                    'value' => function ($data, $row) {
                        /** @var TariffsAcceptors $data */
                        return $data->bank;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'schet',
                    'value' => function ($data, $row) {
                        /** @var TariffsAcceptors $data */
                        return $data->schet;
                    },
                  ],
                    /*
                    array(
                    'type'  => 'raw',
                    'name'  => 'valuta',
                    'value' => function ($data, $row) {
                    ///** @var TariffsAcceptors $data /
                    return $data->valuta;
                    },
                    ),
                     */

                    /*
                    array(
                    'type'  => 'raw',
                    'name'  => 'KPPbank',
                    'value' => function ($data, $row) {
                    ///** @var TariffsAcceptors $data /
                    return $data->KPPbank;
                    },
                    ),
                    array(
                    'type'  => 'raw',
                    'name'  => 'BIK',
                    'value' => function ($data, $row) {
                    ///** @var TariffsAcceptors $data /
                    return $data->BIK;
                    },
                    ),
                    array(
                    'type'  => 'raw',
                    'name'  => 'korrSchet',
                    'value' => function ($data, $row) {
                    ///** @var TariffsAcceptors $data /
                    return $data->korrSchet;
                    },
                    ),
                    array(
                    'type'  => 'raw',
                    'name'  => 'created',
                    'value' => function ($data, $row) {
                    ///** @var TariffsAcceptors $data /
                    return $data->created;
                    },
                    ),
                    */
                  [
                    'type'  => 'raw',
                    'name'  => 'comments',
                    'value' => function ($data, $row) {
                        /** @var TariffsAcceptors $data */
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
                    'value' => function ($data) {
                        /** @var TariffsAcceptors $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_tariffs_acceptors ("<?= $data->tariff_acceptors_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_tariffs_acceptors ("<?= $data->tariff_acceptors_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
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
    function delete_record_tariffs_acceptors(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?=Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/tariffsAcceptors/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('tariffs-acceptors-grid', {});
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