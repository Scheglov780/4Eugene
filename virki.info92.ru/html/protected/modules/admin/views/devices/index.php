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
Yii::app()->clientScript->registerScript(
  'search',
  "
$('#devices-search-button').click(function(){
    $('#devices-search-form').slideToggle('fast');
    return false;
});
$('#devices-search-form form').submit(function(){
    $.fn.yiiGridView.update('devices-grid', {
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
      <?= Yii::t('main', 'Устройства') ?>
    <small><?= Yii::t('main', 'Управление приборами учёта, показания, активность...') ?></small>
      <?= Utils::getHelp('index', true) ?>
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
  <div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
          'booster.widgets.TbMenu',
          [
            'type'  => 'pills',
            'items' => [
                //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
              [
                'label'       => Yii::t('main', 'Новый прибор'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_devices ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'devices-search-button', 'class' => 'search-button'],
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
          <section id="devices-search-form" class="search-form" style="display:none">
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
          <h3 class="box-title"><?= Yii::t('main', 'Список устройств') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'devices-grid',
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
                    'type'   => 'raw',
                    'name'   => 'source',
                    'filter' => Devices::getSources(),
                    'value'  => function ($data) {
                        /** @var Devices $data */
                        return $data->source;
                    },
                  ],
                  [
                    'type'  => 'raw',
                      //'filter' => false,
                    'name'  => 'devices_id',
                    'value' => function ($data) {
                        /** @var Devices $data */
                        return Devices::getUpdateLink($data->devices_id, false, $data, $data->devices_id);
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'name',
                    'value' => function ($data) {
                        /** @var Devices $data */
                        return Devices::getUpdateLink($data->devices_id, false, $data, $data->name);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'device_group_id',
                    'filter' => Devices::getGroups(),
                    'value'  => function ($data) {
                        /** @var Devices $data */
                        return $data->device_group_id_name;
                    },
                  ],
                    /* array(
                      'type'   => 'raw',
                      'name'   => 'model_id',
                      'filter' => Devices::getModels(),
                      'value'  => function ($data) {
                          /** @var Devices $data * /
                          return $data->model_id_name;
                      },
                    ), */
                    /* array(
                       'type'   => 'raw',
                       'name'   => 'device_usage_id',
                       'filter' => DicCustom::getVals('DEVICE_USAGE'),
                       'value'  => function ($data) {
                           /** @var Devices $data * /
                           return $data->device_usage_name;
                       },
                     ), */
                    /*                          array(
                                                'type'  => 'raw',
                                                'name'  => 'address',
                                                'value' => function ($data) {
                                                    /** @var Devices $data /
                                                    $addressObj = json_decode($data->address);
                                                    if ($addressObj && isset($addressObj->unrestricted_value)) {
                                                        return $addressObj->unrestricted_value;
                                                    } else {
                                                        return '';
                                                    }
                                                },
                                              ),
                    */
                    /* array(
                       'name'           => 'active',
                       'class'          => 'CCheckBoxColumn',
                       'checked'        => '$data->active==1',
                       'header'         => Yii::t('main', 'Активен'),
                         //'disabled'=>'true',
                       'selectableRows' => 0,
                     ),
                    */
                  [
                    'type'   => 'raw',
                    'name'   => 'device_status_id',
                    'filter' => DicCustom::getVals('DEVICE_STATE'),
                    'value'  => function ($data) {
                        /** @var Devices $data */
                        return $data->device_status_name;
                    },
                  ],
                    /* array(
                      'type'  => 'raw',
                      'name'  => 'created_at',
                      'value' => function ($data) {
                          /** @var Devices $data * /
                          return (Utils::pgDateToStr($data->created_at) . ' (' . Utils::pgIntervalToStr(
                              $data->created_at_left
                            ) . ')');
                      },
                    ), */
                    /*
                    array(
                      'type'  => 'raw',
                      'name'  => 'deleted_at',
                      'value' => function ($data) {
                          /** @var Devices $data */
                    /*       return Utils::pgDateToStr($data->deleted_at);
                       },
                     ),
                     */
                    /* array(
                      'type'   => 'raw',
                      'name'   => 'last_active',
                      'filter' => false,
                      'value'  => function ($data) {
                          /** @var Devices $data /
                          $result = Utils::pgDateToStr($data->last_active);
                          if ($data->last_active_left) {
                              $result = $result . ' (' . Utils::pgIntervalToStr($data->last_active_left) . ')';
                          }
                          return $result;
                      },
                    ),
                    */
                    /* array(
                       'type'  => 'raw',
                       'name'  => 'data_updated',
                       'filter' => false,
                       'value' => function ($data) {
                           /** @var Devices $data */
                    /*       $result = Utils::pgDateToStr($data->data_updated);
                           if ($data->data_updated_left) {
                               $result = $result . ' (' . Utils::pgIntervalToStr($data->data_updated_left) . ')';
                           }
                           return $result;
                       },
                     ),
                     */
                  [
                    'type'   => 'raw',
                    'name'   => 'value1',
                    'header' => 'Показания',
                    'filter' => false,
                    'value'  => function ($data, $row) {
                        /** @var Devices $data */
                        Yii::app()->controller->widget(
                          'application.modules.' .
                          Yii::app()->controller->module->id .
                          '.components.widgets.devicesBlock',
                          [
                            'devices' => [$data],
                          ]
                        );
                    },
                  ],

                  [
                    'type'   => 'raw',
                    'name'   => 'lands',
                      // 'header'  => 'Участки',
                    'filter' => false,
                    'value'  => function ($data, $row) {
                        /** @var Devices $data */
                        $lands = json_decode($data->lands);
                        if ($lands && count($lands)) {
                            foreach ($lands as $land) {
                                ?>
                              <span style="white-space: nowrap;">
                                            <?= Lands::getUpdateLink($land->lands_id, false, $land); ?>
                                    </span>
                                <?
                            }
                        }
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'tariffs',
                      // 'header'  => 'Участки',
                    'filter' => false,
                    'value'  => function ($data, $row) {
                        /** @var Devices $data */
                        $tariffs = json_decode($data->tariffs);
                        if ($tariffs && count($tariffs)) {
                            foreach ($tariffs as $tariff) {
                                ?>
                              <p>
                                  <?= $tariff->tariff_short_name ?>
                              </p>
                                <?
                            }
                        }
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'users',
                    'filter' => false,
                      // 'header'  => 'Участки',
                    'value'  => function ($data, $row) {
                        /** @var Devices $data */
                        $users = json_decode($data->users);
                        if ($users && count($users)) {
                            foreach ($users as $user) {
                                ?>
                              <span style="white-space: nowrap;">
                                        <?= Users::getUpdateLink($user->uid, false, $user) ?>
                                    </span>
                                <?
                            }
                        }
                    },
                  ],

                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        /** @var Devices $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_devices ("<?= $data->devices_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_devices ("<?= $data->devices_id ?>")'
                           class='btn btn-default btn-sm'><i
                              class='fa fa-trash'></i></a>
                      </div>
                        <?
                    },
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
          <img class="img-responsive pad" src="/images/TZ/004-structura-pribory-ucheta.jpg">
        </div>
        <!-- /.box-body -->
      </div>
      <!-- Content Header (Page header) -->

    </div>
  </div>
</section>
<!-- /.content -->

<script type="text/javascript">
    function delete_record_devices(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/devices/delete"); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('devices-grid', {});
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

<style type="text/css" media="print">
  body {
    visibility: hidden;
  }

  .printableArea {
    visibility: visible;
  }
</style>
<script type="text/javascript">
    function printDiv_devices() {

        window.print();

    }
</script>


