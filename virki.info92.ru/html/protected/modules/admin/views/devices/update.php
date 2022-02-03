<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?
/** @var Devices $model */
$module = Yii::app()->controller->module->id;
?>
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Прибор') ?>: <?= $model->source .
      '/' .
      ($model->name ?? $model->devices_id) ?>        <?= Utils::getHelp(
        'update',
        true
      ) ?></h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary<?= $model->hasErrors() ? '' : ' collapsed-box' ?>">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse"><?= Yii::t('main', 'Редактирование прибора') ?>:
              <?= $model->source . '/' . ($model->name ?? $model->devices_id) ?></h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
          <? /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'devices-update-form-single-' . $model->devices_id,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["devices/update"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",/* Disable normal form submit */
                  //'onkeypress'=>" if(event.keyCode == 13){ update_devices (); } "
                  /* Do ajax call when land presses enter key */
              ],
            ]
          ); ?>
        <div class="box-body">
            <?php echo $form->errorSummary($model); ?>
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <? if ($model->source == 'manual') {
                    $htmlOptions = [];
                } else {
                    $htmlOptions = ['disabled' => 'disabled', 'readonly' => 'readonly'];
                }
                ?>
                <?php echo $form->hiddenField(
                  $model,
                  'devices_id',
                  ['id' => 'devices_devices_id_update-single-' . $model->devices_id]
                ); ?>
                <?php echo $form->uneditableRow(
                  $model,
                  'source',
                  array_merge($htmlOptions, ['id' => 'devices_source_update-single-' . $model->devices_id])
                ); ?>
                <?php echo $form->uneditableRow(
                  $model,
                  'devices_id',
                  array_merge(
                    $htmlOptions,
                    ['id' => 'devices_devices_id_update-single-' . $model->devices_id . '^']
                  )
                ); ?>
                <?php
                $model->created_at = Utils::pgDateToStr($model->created_at);
                echo $form->uneditableRow(
                  $model,
                  'created_at',
                  array_merge($htmlOptions, ['id' => 'devices_created_at_update-single-' . $model->devices_id])
                ); ?>
                <?
                $htmlOptions['id'] = 'devices_device_group_id_update-single-' . $model->devices_id;
                echo $form->dropDownListRow(
                  $model,
                  'device_group_id',
                  [
                    'widgetOptions' => [
                      'data'        => Devices::getGroups(),
                      'htmlOptions' => $htmlOptions,
                    ],
                  ]
                ); ?>
                <?
                $htmlOptions['id'] = 'devices_device_type_id_update-single-' . $model->devices_id;
                echo $form->dropDownListRow(
                  $model,
                  'device_type_id',
                  [
                    'widgetOptions' => [
                      'data'        => Devices::getTypes(),
                      'htmlOptions' => $htmlOptions,
                    ],
                  ]
                ); ?>
                <?
                $htmlOptions['id'] = 'devices_model_id_update-single-' . $model->devices_id;
                echo $form->dropDownListRow(
                  $model,
                  'model_id',
                  [
                    'widgetOptions' => [
                      'data'        => Devices::getModels(),
                      'htmlOptions' => $htmlOptions,
                    ],
                  ]
                ); ?>
                <? //@todo Под спойлер ?>
                <? /* echo $form->textAreaRow(
                      $model,
                      'properties',
                      array_merge($htmlOptions, array('id' => 'devices_properties_update-single-' . $model->devices_id))
                    ); ?>
                    <?php echo $form->textFieldRow(
                      $model,
                      'report_period_update',
                      array_merge(
                        $htmlOptions,
                        array('id' => 'devices_report_period_update_update-single-' . $model->devices_id)
                      )
                    ); */ ?>
                <?
                $htmlOptionsEditable = [];
                $htmlOptionsEditable['id'] = 'devices_device_usage_id_update-single-' . $model->devices_id;
                echo $form->dropDownListRow(
                  $model,
                  'device_usage_id',
                  [
                    'widgetOptions' => [
                      'data'        => DicCustom::getVals('DEVICE_USAGE'),
                      'htmlOptions' => $htmlOptionsEditable,
                    ],
                  ]
                ); ?>
                <?
                $htmlOptionsEditable = [];
                $htmlOptionsEditable['id'] = 'devices_device_status_id_update-single-' . $model->devices_id;
                echo $form->dropDownListRow(
                  $model,
                  'device_status_id',
                  [
                    'widgetOptions' => [
                      'data'        => DicCustom::getVals('DEVICE_STATE'),
                      'htmlOptions' => $htmlOptionsEditable,
                    ],
                  ]
                ); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <?php echo $form->textFieldRow(
                  $model,
                  'name',
                  array_merge(
                    [],//$htmlOptions,
                    [
                      'id'          => 'devices_name_update-single-' . $model->devices_id,
                      'placeholder' => 'Удобное и понятное имя этого прибора',
                      'title'       => 'Например: Эл-во уч.215',
                    ]
                  )
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'device_serial_number',
                  array_merge(
                    [],//$htmlOptions,
                    [
                      'id'          => 'devices_device_serial_number_update-single-' . $model->devices_id,
                      'placeholder' => 'Необходимо для обслуживания прибора',
                    ]
                  )
                ); ?>

                <?php echo $form->textAreaRow(
                  $model,
                  'desc',
                  array_merge(
                    [],//$htmlOptions,
                    ['id' => 'devices_desc_update-single-' . $model->devices_id]
                  )
                ); ?>
                <?php /* echo $form->textFieldRow(
                      $model,
                      'updated_at',
                     array_merge($htmlOptions, array('id' => 'devices_updated_at_update-single-' . $model->devices_id))
                    ); */ ?>
                <?php /* echo $form->textFieldRow(
                      $model,
                      'deleted_at',
                     array_merge($htmlOptions, array('id' => 'devices_deleted_at_update-single-' . $model->devices_id))
                    ); */ ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'starting_value1',
                  array_merge(
                    [],//$htmlOptions,
                    [
                      'id'          => 'devices_starting_value1_update-single-' . $model->devices_id,
                      'placeholder' => 'Начальное значение для однотарифного прибора',
                    ]
                  )
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'starting_value2',
                  array_merge(
                    [],//$htmlOptions,
                    [
                      'id'          => 'devices_starting_value2_update-single-' . $model->devices_id,
                      'placeholder' => 'Начальное значение "день" для двухтарифного прибора',
                    ]
                  )
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'starting_value3',
                  array_merge(
                    [],//$htmlOptions,
                    [
                      'id'          => 'devices_starting_value3_update-single-' . $model->devices_id,
                      'placeholder' => 'Начальное значение "ночь" для двухтарифного прибора',
                    ]
                  )
                ); ?>
              <div class="form-group">
                <label class="col-sm-3 control-label"
                       for="devices_lands_update-single-<?= $model->devices_id ?>">Участки</label>
                <div class="col-sm-9">
                  <select id="devices_lands_update-single-<?= $model->devices_id ?>"
                          class="form-control select2 select2-hidden-accessible"
                          multiple="multiple" data-placeholder="Клик для выбора участка"
                    <?= (Yii::app()->user->notInRole(
                      ['superAdmin', 'topManager']
                    ) ? 'disabled="disabled"' : '') ?>
                          name="Devices[lands][]" style="width: 100%;"
                          aria-hidden="true">
                      <?
                      $landsList = Lands::getList();
                      $landsOfDevice = Devices::getList($model->devices_id, true);
                      if (!is_array($landsOfDevice)) {
                          $landsOfDevice = [];
                      }
                      if ($landsList && is_array($landsList)) {
                          foreach ($landsList as $land) {
                              //lands_id, land_group, land_number, users
                              if (in_array($land['lands_id'], $landsOfDevice)) {
                                  $selected = ' selected="selected"';
                              } else {
                                  $selected = '';
                              }
                              ?>
                            <option <?/* title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>" */ ?>
                                value="<?= $land['lands_id'] ?>"<?= $selected ?>>
                                <?= addslashes($land['land_group'] . '/№' . $land['land_number']) ?>
                            </option>
                          <? }
                      } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"
                       for="devices_tariffs_update-single-<?= $model->devices_id ?>">Тарифы</label>
                <div class="col-sm-9">
                  <select id="devices_tariffs_update-single-<?= $model->devices_id ?>"
                          class="form-control select2 select2-hidden-accessible"
                          multiple="multiple" data-placeholder="Клик для выбора тарифов"
                    <?= (Yii::app()->user->notInRole(
                      ['superAdmin', 'topManager']
                    ) ? 'disabled="disabled"' : '') ?>
                          name="Devices[tariffs][]" style="width: 100%;"
                          aria-hidden="true">
                      <?
                      $tariffsList = Tariffs::getListForDevice();
                      $tariffsOfDevice = Tariffs::getListForDevice($model->devices_id);
                      if (!is_array($tariffsOfDevice)) {
                          $tariffsOfDevice = [];
                      }
                      if ($tariffsList && is_array($tariffsList)) {
                          foreach ($tariffsList as $tariff) {
                              //tariffs_id
                              if (in_array($tariff['tariffs_id'], $tariffsOfDevice)) {
                                  $selected = ' selected="selected"';
                              } else {
                                  $selected = '';
                              }
                              ?>
                            <option value="<?= $tariff['tariffs_id'] ?>"<?= $selected ?>><?= addslashes(
                                  $tariff['tariff_short_name']
                                ) ?></option>
                          <? }
                      } ?>
                  </select>
                </div>
              </div>
                <?php echo $form->checkboxRow(
                  $model,
                  'active',
                  array_merge(
                    [],//$htmlOptions,
                    ['id' => 'devices_active_update-single-' . $model->devices_id]
                  )
                ); ?>
            </div>
          </div>
        </div>
        <div class="box-footer">
            <?php $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'type'        => 'default',
                  //'size' => 'mini',
                'icon'        => 'fa fa-check',
                'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t(
                  'main',
                  'Сохранить'
                ),
                'htmlOptions' => [
                  'class'   => 'pull-right',
                  'onclick' => "update_devices_{$model->devices_id} ();",
                ],
              ]
            );
            ?>
            <?php $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'reset',
                'type'        => 'default',
                  //'size'       => 'mini',
                'icon'        => 'fa fa-rotate-left',
                'label'       => Yii::t('main', 'Сброс'),
                'htmlOptions' => ['class' => 'pull-left'],
              ]
            ); ?>
        </div>
          <?php
          $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">История потребления ресурса</h3>
        </div>
        <div class="box-body">
            <? if ($model) { ?>
                <?
                if ($model->source == 'manual') {
                    $sql = "
select to_char(max(tt.data_updated), 'TMMon, YYYY') AS \"date\"
 from obj_devices_data_view tt
where device_id = :device_id and 
tt.data_updated >= now() - interval '120 day' 
 group by to_char(tt.data_updated, 'YYYYMM')
order by to_char(tt.data_updated, 'YYYYMM') asc   ";
                } else {
                    $sql = "
select to_char(max(tt.data_updated), 'TMDy, DD TMMon, YYYY') AS \"date\"
 from obj_devices_data_view tt
where device_id = :device_id
 and tt.data_updated >= now() - interval '30 day' 
 group by to_char(tt.data_updated, 'YYYYMMDD')
order by to_char(tt.data_updated, 'YYYYMMDD') asc    ";
                }
                $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
                  $sql
                )->queryColumn(
                  [
                    ':device_id' => $model->devices_id,
                  ]
                );
                /*
                                        if ($model->source == 'manual') {
                                            $sql = "
                select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)
                    from obj_devices_data_view tt
                    left join obj_devices_manual odm on tt.device_id = odm.devices_id
                where tt.device_id = :device_id
                 and tt.data_updated >= now() - interval '120 day'
                 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text) ";
                                        } else {
                                            $sql = "
                select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)
                    from obj_devices_data_view tt
                    left join obj_devices_manual odm on tt.device_id = odm.devices_id
                where tt.device_id = :device_id
                 and tt.data_updated >= now() - interval '30 day'
                 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text) ";
                                        }
                                        $seriesNames = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
                                          $sql
                                        )->queryColumn(
                                          array(
                                            ':device_id' => $model->devices_id,
                                          )
                                        );
                */
                //$seriesNames = array('Общий тариф','Тариф "дневной"', 'Тариф "ночной"');
                $seriesNames = ['Тариф "дневной"', 'Тариф "ночной"'];
                if ($model->source == 'manual') {
                    $sql = "
select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)  as device_id,
to_char(max(tt.data_updated), 'TMMon, YYYY') AS \"date\", 
round(coalesce(sum(tt.delta_tariff1),0)::numeric,3) as tariff1,
round(coalesce(sum(tt.delta_tariff2),0)::numeric,3) as tariff2,
round(coalesce(sum(tt.delta_tariff3),0)::numeric,3) as tariff3
from obj_devices_data_view tt
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.device_id = :device_id
and tt.data_updated >= now() - interval '120 day' 
 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text), to_char(tt.data_updated, 'YYYYMM')
order by to_char(tt.data_updated, 'YYYYMM') asc ";
                } else {
                    $sql = "
select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)  as device_id,
to_char(max(tt.data_updated), 'TMDy, DD TMMon, YYYY') AS \"date\", 
round(coalesce(sum(tt.delta_tariff1),0)::numeric,3) as tariff1, 
round(coalesce(sum(tt.delta_tariff2),0)::numeric,3) as tariff2,
round(coalesce(sum(tt.delta_tariff3),0)::numeric,3) as tariff3       
from obj_devices_data_view tt
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.device_id = :device_id
 and tt.data_updated >= now() - interval '30 day' 
 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text), to_char(tt.data_updated, 'YYYYMMDD')
order by to_char(tt.data_updated, 'YYYYMMDD') asc ";
                }
                $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
                  $sql
                )->queryAll(
                  true,
                  [
                    ':device_id' => $model->devices_id,
                  ]
                );
                $series = [];
                if (count($XValues)) {
                    foreach ($seriesNames as $t => $seriesName) {
                        $serie = [
                          'name' => $seriesName,
                          'data' => array_fill(0, count($XValues), 0),
                        ];
                        foreach ($XValues as $i => $XValue) {
                            foreach ($seriesData as $j => $serieData) {
                                if ($serieData['date'] == $XValue) { //&& $serieData['device_id'] == $seriesName
                                    $serie['data'][$i] = (float) $serieData['tariff' . ($t + 1)];
                                    //unset($seriesData[$j]);
                                    break;
                                }
                            }
                        }
                        $series[] = $serie;
                    }
                    $this->Widget(
                      'ext.highcharts.HighchartsWidget',
                      [
                        'htmlOptions' => [
                          'id' => 'device-' . $model->devices_id . '-chart',
                        ],
                        'scripts'     => [
                          'highcharts-more',
                            // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          'modules/exporting',
                            // adds Exporting button/menu to chart
                          'themes/grid-light'
                            // applies global 'grid' theme to all charts
                        ],
                        'options'     => [
                          'chart'       => [
                            'type' => 'area',
                              // 'style' => 'width:100%;'
                          ],
                          'plotOptions' => [
                            'area' => [
                              'stacking' => 'normal',
                            ],
                          ],
                          'credits'     => ['enabled' => false],
                          'title'       => false,
                          'tooltip'     => [
                            'pointFormat' => '{series.name}: <b>{point.y:.1f} kWh</b>',
                          ],
                          'xAxis'       => [
                            'categories'        => $XValues,
                            'tickmarkPlacement' => 'on',
                            'title'             => [
                              'enabled' => false,
                            ],
                          ],
                          'yAxis'       => [
                            'min'   => 0,
                            'title' => ['text' => 'Потребление за период, kWh'],
                          ],
                          'series'      => $series,
                        ],
                      ]
                    );
                } else { ?>
                  <p>Нет данных</p>
                <? } ?>
            <? } else { ?>
              <p>Нет данных</p>
            <? } ?>
        </div>
          <? /* <div class="box-footer">
                </div> */ ?>
      </div>
    </div>
  </div>
  <div class="row">
      <? if ($model) { ?>
          <?
          if ($model->source == 'manual') {
              $sqlPrev = "
select avg (sum_tariff1) as avg_tariff1, avg (sum_tariff2) as avg_tariff2, avg (sum_tariff3) as avg_tariff3
from (
select sum(delta_tariff1) as sum_tariff1, sum(delta_tariff2) as sum_tariff2, sum(delta_tariff3) as sum_tariff3
 from obj_devices_data_view tt
where -- tt.source = 'nekta' and
 device_id = :device_id and 
tt.data_updated between (now() - interval '240 day') and (now() - interval '120 day')
group by to_char(tt.data_updated, 'YYYYMM') ) ss
";
              $sqlLast = "
select avg (sum_tariff1) as avg_tariff1, avg (sum_tariff2) as avg_tariff2, avg (sum_tariff3) as avg_tariff3
from (
select sum(delta_tariff1) as sum_tariff1, sum(delta_tariff2) as sum_tariff2, sum(delta_tariff3) as sum_tariff3
 from obj_devices_data_view tt
where -- tt.source = 'nekta' and
 device_id = :device_id and 
tt.data_updated between (now() - interval '120 day') and (now() - interval '0 day')
group by to_char(tt.data_updated, 'YYYYMM') ) ss
";
          } else {
              $sqlPrev = "
select avg (sum_tariff1) as avg_tariff1, avg (sum_tariff2) as avg_tariff2, avg (sum_tariff3) as avg_tariff3
from (
select sum(delta_tariff1) as sum_tariff1, sum(delta_tariff2) as sum_tariff2, sum(delta_tariff3) as sum_tariff3
 from obj_devices_data_view tt
where -- tt.source = 'nekta' and
 device_id = :device_id and 
tt.data_updated between (now() - interval '60 day') and (now() - interval '30 day')
group by to_char(tt.data_updated, 'YYYYMM') ) ss
";
              $sqlLast = "
select avg (sum_tariff1) as avg_tariff1, avg (sum_tariff2) as avg_tariff2, avg (sum_tariff3) as avg_tariff3
from (
select sum(delta_tariff1) as sum_tariff1, sum(delta_tariff2) as sum_tariff2, sum(delta_tariff3) as sum_tariff3
 from obj_devices_data_view tt
where -- tt.source = 'nekta' and
 device_id = :device_id and 
tt.data_updated between (now() - interval '30 day') and (now() - interval '0 day')
group by to_char(tt.data_updated, 'YYYYMM') ) ss
";
          }
          $seriesDataPrev = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
            $sqlPrev
          )->queryRow(
            true,
            [
              ':device_id' => $model->devices_id,
            ]
          );
          $seriesDataLast = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
            $sqlLast
          )->queryRow(
            true,
            [
              ':device_id' => $model->devices_id,
            ]
          );
          $seriesNames = ['Общий тариф', 'Тариф "дневной"', 'Тариф "ночной"'];
          $seriesPrev = [];
          $seriesLast = [];
          $series = [];
          if ($seriesDataLast['avg_tariff2'] && $seriesDataLast['avg_tariff3']) {
              $seriesLast[] = [
                'name' => 'За текущий период',
                'data' => [
                  [
                    'name' => 'Тариф "дневной"',
                    'y'    => round($seriesDataLast['avg_tariff2']),
                  ],
                  [
                    'name' => 'Тариф "ночной"',
                    'y'    => round($seriesDataLast['avg_tariff3']),
                  ],
                ],
              ];
          } else {
              $seriesLast[] = [
                'name' => 'За текущий период',
                'data' => [
                  [
                    'name' => 'Тариф "общий"',
                    'y'    => round($seriesDataLast['avg_tariff1']),
                  ],
                ],
              ];
          }
          if ($seriesDataPrev['avg_tariff2'] && $seriesDataPrev['avg_tariff3']) {
              $seriesPrev[] = [
                'name' => 'За предыдущий период',
                'data' => [
                  [
                    'name' => 'Тариф "дневной"',
                    'y'    => round($seriesDataPrev['avg_tariff2']),
                  ],
                  [
                    'name' => 'Тариф "ночной"',
                    'y'    => round($seriesDataPrev['avg_tariff3']),
                  ],
                ],
              ];
          } else {
              $seriesPrev[] = [
                'name' => 'За предыдущий период',
                'data' => [
                  [
                    'name' => 'Тариф "общий"',
                    'y'    => round($seriesDataPrev['avg_tariff1']),
                  ],
                ],
              ];
          } ?>
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Доля тарифов в потреблении, за предыдущий период</h3>
            </div>
            <div class="box-body">
                <? if ($seriesDataPrev['avg_tariff1'] ||
                  ($seriesDataPrev['avg_tariff2'] && $seriesDataPrev['avg_tariff3'])) { ?>
                    <? $this->Widget(
                      'ext.highcharts.HighchartsWidget',
                      [
                        'htmlOptions' => [
                          'id' => 'device-' . $model->devices_id . '-chart-pie-tariff-prev',
                        ],
                        'scripts'     => [
                          'highcharts-more',
                            // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          'modules/exporting',
                            // adds Exporting button/menu to chart
                          'themes/grid-light'
                            // applies global 'grid' theme to all charts
                        ],
                        'options'     => [
                          'chart'       => [
                            'type' => 'pie',
                              // 'style' => 'width:100%;'
                          ],
                          'plotOptions' => [
                            'pie' => [
                              'allowPointSelect' => true,
                              'cursor'           => 'pointer',
                              'dataLabels'       => [
                                'enabled' => true,
                                'format'  => '<b>{point.name}</b>: {point.percentage:.1f}% {point.y:.1f} kWh',
                              ],
                              'showInLegend'     => false,
                            ],
                          ],
                          'credits'     => ['enabled' => false],
                          'title'       => false,
                          'tooltip'     => [
                            'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b> {point.y:.1f} kWh',
                          ],
                          'series'      => $seriesPrev,
                        ],
                      ]
                    );
                    ?>
                <? } else { ?>
                  <p>Нет данных</p>
                <? } ?>
            </div>
              <? /* <div class="box-footer">
                </div> */ ?>
          </div>
        </div>
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Доля тарифов в потреблении, за текущий период</h3>
            </div>
            <div class="box-body">
                <? if ($seriesDataLast['avg_tariff1'] ||
                  ($seriesDataLast['avg_tariff2'] && $seriesDataLast['avg_tariff3'])) { ?>
                    <? $this->Widget(
                      'ext.highcharts.HighchartsWidget',
                      [
                        'htmlOptions' => [
                          'id' => 'device-' . $model->devices_id . '-chart-pie-tariff-last',
                        ],
                        'scripts'     => [
                          'highcharts-more',
                            // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          'modules/exporting',
                            // adds Exporting button/menu to chart
                          'themes/grid-light'
                            // applies global 'grid' theme to all charts
                        ],
                        'options'     => [
                          'chart'       => [
                            'type' => 'pie',
                              // 'style' => 'width:100%;'
                          ],
                          'plotOptions' => [
                            'pie' => [
                              'allowPointSelect' => true,
                              'cursor'           => 'pointer',
                              'dataLabels'       => [
                                'enabled' => true,
                                'format'  => '<b>{point.name}</b>: {point.percentage:.1f}% {point.y:.1f} kWh',
                              ],
                              'showInLegend'     => false,
                            ],
                          ],
                          'credits'     => ['enabled' => false],
                          'title'       => false,
                          'tooltip'     => [
                            'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b> {point.y:.1f} kWh',
                          ],
                          'series'      => $seriesLast,
                        ],
                      ]
                    );
                    ?>
                <? } else { ?>
                  <p>Нет данных</p>
                <? } ?>
            </div>
          </div>
        </div>
      <? } else { ?>
        <div class="col=md-12">
          <p>Нет данных</p>
        </div>
      <? } ?>
  </div>
    <? if ($model->source == 'nekta') {
        $sql = " select to_char(max(tt.datetime), 'TMDy, DD TMMon, YYYY') AS \"date\"
 from src_nekta_data_type5 tt
where device_id = :device_id
 and tt.datetime >= now() - interval '30 day' 
 group by to_char(tt.datetime, 'YYYYMMDD')
order by to_char(tt.datetime, 'YYYYMMDD') asc ";
        $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
          $sql
        )->queryColumn(
          [
            ':device_id' => $model->devices_id,
          ]
        );
        $sql = "select odm.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)  as device_id,
to_char(max(tt.datetime), 'TMDy, DD TMMon, YYYY') AS \"date\", 
max(tt.power_a_plus) as power_a_plus,
(max(tt.power_a_plus)*1000/220)::numeric(10,1) as amper_a_plus
from src_nekta_data_type5 tt
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.device_id = :device_id
 and tt.datetime >= now() - interval '30 day' 
 group by odm.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text), to_char(tt.datetime, 'YYYYMMDD')
order by to_char(tt.datetime, 'YYYYMMDD') asc";
        $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
          $sql
        )->queryAll(
          true,
          [
            ':device_id' => $model->devices_id,
          ]
        );
        $series = [];
        if (count($XValues)) {
            $serie = [
              'name' => 'Пиковая сила тока за период',
              'data' => array_fill(0, count($XValues), 0),
            ];
            foreach ($XValues as $i => $XValue) {
                foreach ($seriesData as $j => $serieData) {
                    if ($serieData['date'] == $XValue) { //&& $serieData['device_id'] == $seriesName
                        $serie['data'][$i] = (float) $serieData['amper_a_plus'];
                        //unset($seriesData[$j]);
                        break;
                    }
                }
            }
            $series[] = $serie;
            ?>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Пиковая сила тока за период</h3>
                </div>
                <div class="box-body">
                    <?
                    $this->Widget(
                      'ext.highcharts.HighchartsWidget',
                      [
                        'htmlOptions' => [
                          'id' => 'device-' . $model->devices_id . '-chart-power-amper',
                        ],
                        'scripts'     => [
                          'highcharts-more',
                            // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          'modules/exporting',
                            // adds Exporting button/menu to chart
                          'themes/grid-light'
                            // applies global 'grid' theme to all charts
                        ],
                        'options'     => [
                          'chart'       => [
                            'type' => 'column',
                              // 'style' => 'width:100%;'
                          ],
                          'plotOptions' => [
                            'column' => [
                              'stacking' => 'normal',
                            ],
                          ],
                          'credits'     => ['enabled' => false],
                          'title'       => false,
                          'tooltip'     => [
                            'pointFormat' => '{series.name}: <b>{point.y:.1f} A</b>',
                          ],
                          'xAxis'       => [
                            'categories'        => $XValues,
                            'tickmarkPlacement' => 'on',
                            'title'             => [
                              'enabled' => false,
                            ],
                          ],
                          'yAxis'       => [
                            'min'   => 0,
                            'title' => ['text' => 'Сила тока Imax, А'],
                          ],
                          'series'      => $series,
                        ],
                      ]
                    );
                    ?>
                </div>
                  <? /* <div class="box-footer">
                </div> */ ?>
              </div>
            </div>
          </div>
        <? }
    } ?>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Показания прибора</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
            <?php
            if ($model->source == 'manual') {
                $this->widget(
                  'booster.widgets.TbMenu',
                  [
                    'type'  => 'pills',
                    'items' => [
                        //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
                      [
                        'label'       => Yii::t('main', 'Добавить показания'),
                        'icon'        => 'fa fa-plus',
                        'url'         => 'javascript:void(0);',
                        'linkOptions' => ['onclick' => "renderCreateForm_devices_data_{$model->devices_id} ()"],
                        'visible'     => true,
                      ],
                    ],
                  ]
                );
            }
            ?>
            <?php
            $dataDataProvider = Devices::getDeviceData($model->source, $model->devices_id, 100);
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'device-data-grid-' . $model->devices_id,
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',//
                'dataProvider'    => $dataDataProvider,
                  //'filter'          => false,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                    //pk,source,device_id,delta_data_updated,data_updated,tariff,delta_tariff,uid,fullname
                  [
                    'type'   => 'raw',
                    'name'   => 'data_updated',
                    'header' => 'Дата снятия показаний',
                    'value'  => function ($data) {
                        return Utils::pgDateToStr($data['data_updated']);
                    },
                  ],

                  [
                    'type'   => 'raw',
                    'name'   => 'delta_data_updated',
                    'header' => 'За период',
                    'value'  => function ($data) {
                        return Utils::pgIntervalToStr($data['delta_data_updated']);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'tariff1',
                    'header' => 'V1<sub>тек</sub>',
                    'value'  => function ($data) { ?>
                      <div class="device-value text-right"><?= Utils::formatDeviceValue($data['tariff1']) ?></div>
                    <? },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'tariff2',
                    'header' => 'V2<sub>тек</sub>',
                    'value'  => function ($data) { ?>
                      <div class="device-value text-right"><?= Utils::formatDeviceValue($data['tariff2']) ?></div>
                    <? },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'tariff3',
                    'header' => 'V3<sub>тек</sub>',
                    'value'  => function ($data) { ?>
                      <div class="device-value text-right"><?= Utils::formatDeviceValue($data['tariff3']) ?></div>
                    <? },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'delta_tariff1',
                    'header' => '&Delta;V1<sub>тек</sub>',
                    'value'  => function ($data) { ?>
                      <div class="device-value text-right"><?= Utils::formatDeviceValue($data['delta_tariff1']) ?></div>
                    <? },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'delta_tariff2',
                    'header' => '&Delta;V2<sub>тек</sub>',
                    'value'  => function ($data) { ?>
                      <div class="device-value text-right"><?= Utils::formatDeviceValue($data['delta_tariff2']) ?></div>
                    <? },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'delta_tariff3',
                    'header' => '&Delta;V3<sub>тек</sub>',
                    'value'  => function ($data) { ?>
                      <div class="device-value text-right"><?= Utils::formatDeviceValue($data['delta_tariff3']) ?></div>
                    <? },
                  ],

                [
                  'type'   => 'raw',
                  'name'   => 'power_avg',
                  'header' => 'W<sub>средн</sub>',
                  'value'  => function ($data) {
                      if ($data['delta_data_updated_sec'] > 0) {
                          return round(
                              $data['delta_tariff1'] / ($data['delta_data_updated_sec'] / 3600),
                              2
                            ) . 'kW (' . round(
                              ((1000 * $data['delta_tariff1'] / ($data['delta_data_updated_sec'] / 3600)) / (220 / SQRT(
                                    2
                                  ))),
                              2
                            ) . 'A)';
                      } else {
                          return '-';
                      }
                  },
                ],
                [
                  'type'   => 'raw',
                  'name'   => 'data_source_name',
                  'header' => 'Источник данных',
                  'value'  => function ($data) {
                      return $data['data_source_name'];
                  },
                ],
                [
                  'type'   => 'raw',
                  'name'   => 'fullname',
                  'header' => 'Корреспондент',
                  'value'  => function ($data) {
                      return $data['fullname'];
                  },
                ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) use (&$model) {
                        if ($model->source == 'manual') {
                            ?>
                          <div class="btn-group" role="group">
                            <a href='javascript:void(0);' title="Редактировать"
                               onclick='renderUpdateForm_devices_data_<?= $model->devices_id ?> ("<?= $data['pk'] ?>")'
                               class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                            <a href='javascript:void(0);' title="Удалить"
                               onclick='delete_record_devices_data_<?= $model->devices_id ?> ("<?= $data['pk'] ?>")'
                               class='btn btn-default btn-sm'><i
                                  class='fa fa-trash'></i></a>
                          </div>
                            <?
                        }
                    },
                  ],
                ],
              ]
            );
            if ($model->source == 'manual') {
                $minPosibleValue1 = Yii::app()->db->createCommand(
                  "select max(tt.tariff1_val) from 
            obj_devices_manual_data tt where tt.device_id =:device_id"
                )->queryScalar([':device_id' => $model->devices_id]);
                $minPosibleValue2 = Yii::app()->db->createCommand(
                  "select max(tt.tariff2_val) from 
            obj_devices_manual_data tt where tt.device_id =:device_id"
                )->queryScalar([':device_id' => $model->devices_id]);
                $minPosibleValue3 = Yii::app()->db->createCommand(
                  "select max(tt.tariff3_val) from 
            obj_devices_manual_data tt where tt.device_id =:device_id"
                )->queryScalar([':device_id' => $model->devices_id]);
                $modelData = new deviceDataForm();
                $modelData->source = 'manual';
                $modelData->devices_id = $model->devices_id;
                $modelData->value1 = $minPosibleValue1;
                $modelData->value2 = $minPosibleValue2;
                $modelData->value3 = $minPosibleValue3;
                $this->renderPartial("_ajax_update_data", ['deviceId' => $model->devices_id]);
                $this->renderPartial("_ajax_create_form_data", ['model' => $modelData]);
            }
            ?>
        </div>
          <? /* <div class="box-footer">
                </div> */ ?>
      </div>
    </div>
  </div>
</section>
<script>
    $(function () {
        /* var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
        if (instance) {
            instance.destroy(true);
        }
        CKEDITOR.replace('news_news_body_update-single-');
         */

        /*        function format(state) {
                    if (!state.id) return state.text; // optgroup
                    return state.text + " <i class='info'>link</i>";
                }

                var select2 = $("#select").select2({
                    formatResult: format,
                    formatSelection: format,
                    escapeMarkup: function(m) { return m; }
                }).data('select2');

                select2.onSelect = (function(fn) {
                    return function(data, options) {
                        var target;
                        if (options != null) {
                            target = $(options.target);
                        }

                        if (target && target.hasClass('link')) {
                            alert('click!');
                        } else {
                            return fn.apply(this, arguments);
                        }
                    }
                })(select2.onSelect);
        */


        $('#devices_lands_update-single-<?=$model->devices_id?>').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора участков',
                templateSelection: function (state) {
                    if (!state.id) {
                        return state.text.trim(); // optgroup
                    } else {
                        return state.text.trim() +
                            '&nbsp;<a href="/<?=Yii::app(
                            )->controller->module->id?>/lands/view/id/' + state.id + '" title="Просмотр профиля участка" onclick="getContent(this,\'' +
                            state.text.trim() +
                            '\',false);return false;"><i class="fa fa-external-link fa-fw text-white"></i></a>';
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            }
        );
        $('#devices_tariffs_update-single-<?=$model->devices_id?>').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора тарифов'
            }
        );
    });

    function delete_record_devices_data_<?= $model->devices_id ?>(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/devices/deleteData"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('device-data-grid-<?=$model->devices_id?>', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function update_devices_<?=$model->devices_id?>() {
        /* var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
        if (instance) {
            instance.updateElement();
        }
        */
        var data = $("#devices-update-form-single-<?=$model->devices_id?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?=Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/devices/update')?>',
            data: data,
            success: function (data) {
                reloadSelectedTab(event);
                if (data !== 'false') {
                    dsAlert(data, 'Профиль сохранён', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>