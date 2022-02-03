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
/** @var Lands $model */
Yii::app()->clientScript->registerScript(
  'search',
  "
$('#lands-search-button').click(function(){
    $('#lands-search-form').slideToggle('fast');
    return false;
});
$('#lands-search-form form').submit(function(){
    $.fn.yiiGridView.update('lands-grid', {
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
      <?= Yii::t('main', 'Участки') ?>
    <small><?= Yii::t('main', 'Управление участками, кадастровыми и геоданными...') ?></small>
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
                'label'       => Yii::t('main', 'Новый участок'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_lands ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'lands-search-button', 'class' => 'search-button'],
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
          <section id="lands-search-form" class="search-form" style="display:none">
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
          <h3 class="box-title"><?= Yii::t('main', 'Список участков') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'lands-grid',
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
                    'name'   => 'land_group',
                    'filter' => Lands::getGroups(),
                    'value'  => function ($data) {
                        /** @var Lands $data */
                        return $data->land_group;
                    },
                  ],
                  [
                    'type'  => 'raw',
                      //'filter' => false,
                    'name'  => 'land_number',
                    'value' => function ($data) {
                        /** @var Lands $data */
                        return Lands::getUpdateLink($data->lands_id, false, $data, $data->land_number);
                    },
                  ],
                  [
                    'type'        => 'raw',
                    'name'        => 'land_number_cadastral',
                    'value'       => function ($data) {
                        /** @var Lands $data */
                        if ($data->land_number_cadastral) { ?>
                          <a href="https://egrp365.ru/reestr?egrp=<?= $data->land_number_cadastral ?>"
                             target="_blank"
                             title="Смотреть кадастровые подробности"><?= $data->land_number_cadastral ?></a>
                        <? }
                    },
                    'htmlOptions' => function ($data, $row) {
                        /** @var Lands $data */
                        if (!$data->land_number_cadastral) {
                            return ['style' => 'background-color: rgba(255,0,0,0.07) !important;'];
                        } else {
                            return [];
                        }

                    },
                  ],
                  [
                    'type'        => 'raw',
                    'name'        => 'address',
                    'value'       => function ($data) {
                        /** @var Lands $data */
                        if ($data->address) { ?>
                            <? if ($data->land_geo_latitude && $data->land_geo_longitude) { ?>
                            <a href="https://yandex.ru/maps/?text=<?= $data->land_geo_latitude ?>%2C<?= $data->land_geo_longitude ?>"
                               target="_blank" title="Смотреть на карте"><?= $data->address ?></a>
                            <? } else {
                                return $data->address;
                            } ?>
                        <? }
                    },
                    'htmlOptions' => function ($data, $row) {
                        /** @var Lands $data */
                        if (!$data->address) {
                            return ['style' => 'background-color: rgba(255,0,0,0.07) !important;'];
                        } else {
                            return [];
                        }

                    },
                  ],
                [
                  'type'   => 'raw',
                  'name'   => 'land_type',
                  'filter' => DicCustom::getVals('LAND_TYPE'),
                  'value'  => function ($data) {
                      /** @var Lands $data */
                      return $data->land_type_name;
                  },
                ],
                    /* array(
                      'type'  => 'raw',
                      'name'  => 'land_area',
                      'filter' => false,
                      'value' => function ($data) {
                          /** @var Lands $data * /
                          return $data->land_area;
                      },
                    ), */
                    /*  array(
                        'type'  => 'raw',
                        'name'  => 'comments',
                        'value' => function ($data) {
                            /** @var Lands $data * /
                            return $data->comments;
                        },
                      ), */
                    /* array(
                      'type'  => 'raw',
                      'name'  => 'created',
                      'value' => function ($data) {
                          /** @var Lands $data * /
                          return Utils::pgDateToStr($data->created);
                      },
                    ), */
                [
                  'type'   => 'raw',
                  'name'   => 'users',
                  'filter' => false,
                    // 'header'  => 'Участки',
                  'value'  => function ($data, $row) {
                      /** @var Lands $data */
                      $users = json_decode($data->users);
                      if ($users && count($users)) {
                          /** @var Users $user */
                          foreach ($users as $user) {
                              ?>
                              <?/* <span style="white-space: nowrap;"> */ ?>
                              <?= Users::getUpdateLink($user->uid, false, $user); ?>
                              <?/* </span> */ ?>
                              <?
                          }
                      }
                  },
                ],
                [
                  'type'   => 'raw',
                  'name'   => 'devices',
                  'filter' => false,
                    //'header'  => 'Приборы',
                  'value'  => function ($data, $row) {
                      /** @var Lands $data */
                      $devices = json_decode($data->devices);
                      /** @var Devices $data */
                      Yii::app()->controller->widget(
                        'application.modules.' .
                        Yii::app()->controller->module->id .
                        '.components.widgets.devicesBlock',
                        [
                          'devices' => $devices,
                        ]
                      );
                  },
                ],
                  [
                    'type'   => 'raw',
                    'name'   => 'tariffs',
                    'filter' => false,
                      //'header'  => 'Приборы',
                    'value'  => function ($data, $row) {
                        /** @var Lands $data */
                        $tariffs = json_decode($data->tariffs);
                        if ($tariffs && count($tariffs)) {
                            /** @var Tariffs $tariff */
                            foreach ($tariffs as $tariff) {
                                ?>
                                <?//=Tariffs::getUpdateLink($tariff->tariffs_id, false, $tariff);?>
                              <p><?= $tariff->tariff_short_name ?></p>
                                <?
                            }
                        }
                    },
                  ],
                [
                  'name'           => 'status',
                  'class'          => 'CCheckBoxColumn',
                  'checked'        => '$data->status==1',
                  'header'         => Yii::t('main', 'Проверен'),
                    //'disabled'=>'true',
                  'selectableRows' => 0,
                ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        /** @var Lands $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_lands ("<?= $data->lands_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_lands ("<?= $data->lands_id ?>")'
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
</section>
<!-- /.content -->

<script type="text/javascript">
    function delete_record_lands(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/lands/delete"); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('lands-grid', {});
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
    function printDiv_lands() {

        window.print();

    }
</script>


