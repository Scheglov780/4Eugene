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
/** @var Devices $model */
?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Управление показаниями') ?>
    <small><?= Yii::t('main', 'Быстрое внесение и изменение показаний приборов учёта') ?></small>
      <?= Utils::getHelp('manageReadings', true) ?>
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
    <? /*    <div class="row">
        <div class="col-xs-12">
            <?php
            $this->widget(
              'booster.widgets.TbMenu',
              array(
                'type'  => 'pills',
                'items' => array(
                    //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
                  array(
                    'label'   => Yii::t('main', 'Сохранить изменения'),
                    'icon'    => 'fa fa-save',
                    'url'     => 'javascript:void(0);',
                      //'linkOptions' => array('onclick' => 'renderCreateForm_devices ()'),
                    'visible' => true,
                  ),
                  array(
                    'label' => Yii::t('main', 'Отменить изменения'),
                    'icon'  => 'fa fa-search',
                    'url'   => '#',
                      //'linkOptions' => array('id' => 'devices-search-button', 'class' => 'search-button')
                  ),
                  array(
                    'label'       => Yii::t('main', 'Excel'),
                    'icon'        => 'fa fa-download',
                    'url'         => Yii::app()->controller->createUrl('manageReadingsGenerateExcel'),
                    'linkOptions' => array('target' => '_blank'),
                    'visible'     => true
                  ),
                ),
              )
            );
            ?>
        </div>
    </div>
*/ ?>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список устройств') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body printableArea">
            <?php $this->widget(
              'booster.widgets.TbListView',
              [
                'id'                 => 'devices-readings-view',
//                            'fixedHeader'     => true,
//                            'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',//
                'dataProvider'       => $model->search(null, 50),
//                            'filter'          => $model,
//                            'type'            => 'striped bordered condensed',
                'template'           => '{summary}{pager}{sorter}{items}{pager}',
                  //'responsiveTable' => true,
                'itemView'           => 'manageReadingsItem',
                'enableSorting'      => true,
                'sortableAttributes' => [
                  'lands',
                  'source',
                  'name',
                  'device_usage_name',
                  'starting_date' => 'Наличие стартовых показаний',
                ],
              ],
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

<script type="text/javascript">
    function saveDeviceReadings(deviceId) {

        var data = $('#form-readings-' + deviceId).serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/devices/manageReadings"
            ); ?>',
            data: data,
            success: function (data) {
                dsAlert(data, 'Сообщение', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }
</script>

<style type="text/css" media="print">
  body {
    visibility: hidden;
  }

  .printableArea {
    visibility: visible;
  }
</style>
<script type="text/javascript">
    function printDiv_manageReadings() {
        window.print();
    }
</script>


