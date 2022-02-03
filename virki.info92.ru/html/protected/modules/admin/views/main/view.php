<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="view.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /*=============================================================*/ ?>
<? $module = Yii::app()->controller->module->id;
/** @var CustomAdminController $this */
?>
<? //TODO: Исключить загрузку дэшборда при открытии документов по ссылке admin/main/open
?>
<?
if (($this->action->id != 'open'
      //  && !preg_match('/admin\/main\/open\?/is',$_SERVER['HTTP_REFERER'])
  )
  &&
  (Yii::app()->request->isAjaxRequest &&
    ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != 'admin-tabs-history-grid') || !(isset($_REQUEST['ajax']))))
) {
    ?>
  <!-- Main content -->
  <section class="content" id="main-view-content-section">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info"> <? /*  box-default collapsed-box */ ?>
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Управление данными</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body"> <? /* style="display: none;"*/ ?>
              <?
              $this->renderPartial('view_part_data_management');
              ?>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div> <? /* Управление данными */ ?>
    <div class="row no-padding">
      <div class="col-md-12">
        <div class="box box-warning"> <? /*  box-default collapsed-box */ ?>
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Активность пользователей в системе</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row no-padding">
              <div class="col-md-7">
                  <?
                  unset($serie, $series, $seriesData, $serieData, $sql);
                  $sql = "
                          select to_char(max(tt.date), 'TMDy, DD-MM-YYYY') AS \"date\"
                                             from log_user_activity tt
                                            where tt.date >= now() - interval '1 year' 
                                             group by to_char(tt.date, 'YYYYMMWDD') -- потом сделать YYYYMMW
                                            order by to_char(tt.date, 'YYYYMMWDD')  
                                            ";
                  $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
                    $sql
                  )->queryColumn();
                  $sql = "  select dd.date_order, dd.date, 
                                    (select count(0) from (select 'x' from log_user_activity odv2, users uu 
                                    where odv2.uid = uu.uid and uu.role not in ('landlord','associate','leaseholder') 
																		and uu.status=1 and to_char(odv2.date, 'YYYYMMWDD') = dd.date_order
                                    group by odv2.uid) odv3
                                    ) as active_admins_count,
                                   (select count(0) from (select 'x' from log_user_activity odv4, users uu 
                                    where odv4.uid = uu.uid and uu.role in ('landlord','associate','leaseholder') 
																		and uu.status=1 and to_char(odv4.date, 'YYYYMMWDD') = dd.date_order
                                    group by odv4.uid) odv5
                                    ) as active_users_count,																		
                                    (select count(0) from users uu 
                                    where uu.status=1 
																		and to_char(uu.created, 'YYYYMMWDD') <= dd.date_order) as total_users_count
                                    from
                                    (select to_char(tt.date, 'YYYYMMWDD') as date_order, 
                                    to_char(max(tt.date), 'TMDy, DD-MM-YYYY') AS \"date\"
                                    from log_user_activity tt 
                                    where tt.date >= now() - interval '1 year' 
                                     group by to_char(tt.date, 'YYYYMMWDD')) dd -- потом сделать YYYYMMW
                                     order by dd.date_order ";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))
                    ->createCommand(
                      $sql
                    )
                    ->queryAll();
                  $series = [];
                  if (count($XValues)) {
                      $serieAdmin = [
                        'name'  => 'Администрация',
                        'data'  => array_fill(0, count($XValues), 0),
                        'stack' => 'main',
                      ];
                      $serieUser = [
                        'name'  => 'Абоненты',
                        'data'  => array_fill(0, count($XValues), 0),
                        'stack' => 'main',
                      ];
                      $serieUnactive = [
                        'name'  => 'Не активно',
                        'data'  => array_fill(0, count($XValues), 0),
                        'stack' => 'main',
                      ];

                      foreach ($XValues as $i => $XValue) {
                          foreach ($seriesData as $j => $serieData) {
                              if ($serieData['date'] == $XValue) { //&& $serieData['device_id'] == $seriesName
                                  $serieAdmin['data'][$i] = (int) $serieData['active_admins_count'];
                                  $serieUser['data'][$i] = (int) $serieData['active_users_count'];
                                  $serieUnactive['data'][$i] =
                                    (int) $serieData['total_users_count'] -
                                    (int) $serieData['active_users_count'] -
                                    (int) $serieData['active_admins_count'];
                                  //unset($seriesData[$j]);
                                  break;
                              }
                          }
                      }
                      $series[] = $serieAdmin;
                      $series[] = $serieUser;
                      $series[] = $serieUnactive;
                      $this->Widget(
                        'ext.highcharts.HighchartsWidget',
                        [
                          'htmlOptions' => [
                            'id' => 'dashboard-all-users-activity-chart',
                          ],
                          'scripts'     => [
                            'highcharts-more',
                              // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                            'highcharts-3d',
                            'modules/exporting',
                              // adds Exporting button/menu to chart
                            'themes/grid-light'
                              // applies global 'grid' theme to all charts
                          ],
                          'options'     => [
                            'chart'       => [
                              'type'      => 'column',
                              'options3d' => [
                                'enabled'      => true,
                                'alpha'        => 10,
                                'beta'         => 5,
                                'viewDistance' => 35,
                                'depth'        => 40,
                              ]
                                // 'style' => 'width:100%;'
                            ],
                            'plotOptions' => [
                              'column' => [
                                'stacking'   => 'percent',
                                'depth'      => 40,
                                'dataLabels' => [
                                  'enabled' => false,
                                  'skew3d'  => true,
                                ],
                                'animation'  => [
                                  'duration' => 0,
                                  'defer'    => 0,
                                ],
                              ],
                            ],
                            'credits'     => ['enabled' => false],
                            'title'       => false,
                            'tooltip'     => [
                              'formatter' => "js:function(){
    return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Всего: ' + this.point.stackTotal;
}",
                                //      'pointFormat' => '{series.name}: <b>{point.y:.1f}</b>'
                            ],
                            'xAxis'       => [
                              'categories'        => $XValues,
                              'labels'            => [
                                'skew3d' => true,
                              ],
                              'tickmarkPlacement' => 'on',
                              'title'             => [
                                'enabled' => false,
                              ],
                            ],
                            'yAxis'       => [
                              'min'         => 0,
                              'title'       => [
                                'text'   => 'Пользователей, в % от зарегистрированных',
                                'skew3d' => true,
                              ],
                              'stackLabels' => [
                                'enabled' => true,
                                'skew3d'  => true,
                              ],
                            ],
                            'series'      => $series,
                          ],
                        ]
                      );
                  } else { ?>
                    <p>Нет данных</p>
                  <? } ?>
                  <?
                  unset($i, $j, $serie, $series, $serieData, $seriesData, $sql);
                  ?>
              </div>
              <div class="col-md-5">
                  <?
                  $sql = "select odv2.uid, 'Менеджмент' as serie, uu.fullname, count(0) as requests_count from log_user_activity odv2, users uu 
where odv2.uid = uu.uid and uu.role not in ('landlord','associate','leaseholder') 
and uu.status=1 and odv2.date >= now() - interval '72 hour'
group by odv2.uid, uu.fullname
union all
select odv2.uid, 'Абоненты' as serie, uu.fullname, count(0) as requests_count from log_user_activity odv2, users uu 
where odv2.uid = uu.uid and uu.role in ('landlord','associate','leaseholder') 
and uu.status=1 and odv2.date >= now() - interval '72 hour'
group by odv2.uid, uu.fullname
order by requests_count desc";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))->createCommand(
                    $sql
                  )->queryAll();
                  $series = [
                    [
                      'name'      => 'Менеджмент',
                      'colorAxis' => 0,
                      'colorKey'  => 'value',
                      'data'      => [],
                    ],
                    [
                      'name'      => 'Абоненты',
                      'colorAxis' => 0,
                      'colorKey'  => 'value',
                      'data'      => [],
                    ],
                  ];
                  $seriesNames = ['Менеджмент', 'Абоненты'];

                  foreach ($seriesData as $serieData) {
                      $series[array_search($serieData['serie'], $seriesNames)]['data'][] = [
                        'name'  => Utils::fullNameWithInitials($serieData['fullname']),
                        'value' => (float) $serieData['requests_count'],
                      ];
                  }
                  $zMax = round((float) $seriesData[0]['requests_count']);
                  $zMin = round((float) end($seriesData)['requests_count']);
                  ?>
                  <?
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'htmlOptions' => [
                        'id' => 'dashboard-activity-all-top-active-users',
                      ],
                      'scripts'     => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          //'highcharts-3d',
                        'themes/grid-light',
                          // applies global 'grid' theme to all charts
                        'modules/coloraxis',
                      ],
                      'options'     => [
                        'credits'   => ['enabled' => false],
                        'chart'     => [
                          'type'       => 'packedbubble',
                          'styledMode' => false,
                            //'height' => '100%'
                        ],
                        'colorAxis' => [
                          [
                            'minColor' => 'rgba(0, 255, 0, 1)',//'#55BF3B',
                            'maxColor' => 'rgba(255, 0, 0, 1)',//'#DF5353',
                            'stops'    => [
                              [0, 'rgba(0, 255, 0, 1)'], // green #55BF3B
                              [0.15, '#90ee7e'], // green #55BF3B
                              [0.5, '#e3d257'], // yellow #DDDF0D
                              [0.85, '#f7a35c'], // red #DF5353
                              [1, 'rgba(255, 0, 0, 1)'], // green #55BF3B
                            ],
                            'labels'   => [
                              'enabled'   => false,
                              'formatter' => "js:function () {return Math.abs(this.value) + ' запросов';}",
                            ],
                          ],
                        ],
                        'title'     => [
                          'enabled' => true,
                          'text'    => 'Активность пользователей за 72 часа',
                            //'useHTML' => true
                        ],

                        'exporting' => [
                          'enabled' => false,
                        ],

                        'tooltip'     => [
                            //'useHTML'     => true,
                          'enabled'   => true,
                          'formatter' => "js:function () {return this.point.name;}",
                            //'<b>'+this.point.name+':</b> '+
                        ],
                        'plotOptions' => [
                          'packedbubble' => [
                            'minSize'         => '30%',
                            'maxSize'         => '120%',
                            'zMin'            => $zMin,
                            'zMax'            => $zMax,
                            'layoutAlgorithm' => [
                              'splitSeries'           => false,
                              'gravitationalConstant' => 0.02,
                            ],
                            'dataLabels'      => [
                              'enabled' => true,
                                //'useHTML' => true,
                              'format'  => '{point.name}',
                              'filter'  => [
                                'property' => 'value',
                                'operator' => '>',
                                'value'    => 0,
                              ],
                              'style'   => [
                                'color'       => 'black',
                                'textOutline' => 'none',
                                'fontWeight'  => 'normal',
                              ],
                            ],
                          ],
                        ],
                        'series'      => $series,
                      ],
                    ],
                  );
                  unset($seriesData, $serieData, $series, $sql);
                  ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <? /* Активность пользователей */ ?>
    <div class="row no-padding">
      <div class="col-md-12">
        <div class="box box-success"> <? /*  box-default collapsed-box */ ?>
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Энергетика</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="row no-padding">
              <div class="col-md-6">
                  <?
                  $sql = "select
       percentile_cont(0.99) within group (order by tt.power_a_plus) * 0.45/0.8
       -- max(tt.power_a_plus)*0.45/0.8 
    as power_max,
(select -- avg(dd1.power_a_plus) 
 percentile_cont(0.5) within group (order by dd1.power_a_plus)
 from
(select tt1.device_id, tt1.power_a_plus, tt1.datetime,
row_number() over (partition by tt1.device_id order by tt1.datetime desc) as rn
 from src_nekta_data_type5 tt1) dd1
 where dd1.rn = 1) as power_now,
(select count(0) from obj_devices_view odv) as total_devices_count														
from src_nekta_data_type5 tt
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.datetime >= now() - interval '1 month'";
                  $YValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 300))->createCommand(
                    $sql
                  )->queryRow();
                  ?>
                  <?
                  $nowVal = round(
                    (float) $YValues['power_now'] * (float) $YValues['total_devices_count']
                  );
                  $maxVal = round(
                      (float) $YValues['power_max'] * (float) $YValues['total_devices_count'] / 100
                    ) * 100 + 100;
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'htmlOptions' => [
                        'id' => 'dashboard-energy-all-devices-power-now-gauge',
                      ],
                      'scripts'     => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          //'highcharts-3d',
                        'modules/solid-gauge',
                          // adds Exporting button/menu to chart
                        'themes/grid-light'
                          // applies global 'grid' theme to all charts
                      ],
                      'options'     => [
                        'chart' => [
                          'type' => 'solidgauge',
                        ],

                        'title' => [
                          'enabled' => true,
                          'text'    => 'Текущая потребляемая мощность',
                          'useHTML' => true,
                        ],

                        'pane' => [
                          'center'     => ['50%', '85%'],
                          'size'       => '100%',//!!!
                          'startAngle' => -90,
                          'endAngle'   => 90,
                          'background' => [
                            'backgroundColor' => '#EEE',
                            'innerRadius'     => '60%',
                            'outerRadius'     => '100%',
                            'shape'           => 'arc',
                          ],
                        ],

                        'exporting' => [
                          'enabled' => false,
                        ],

                        'tooltip' => [
                          'enabled' => false,
                        ],

                        'plotOptions' => [
                          'solidgauge' => [
                            'dataLabels' => [
                              'y'           => 5,
                              'borderWidth' => 0,
                              'useHTML'     => true,
                            ],
                          ],
                        ],

                        'credits' => ['enabled' => false],

                          /* 'tooltip' => array(
                             'formatter' => "js:function(){
return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Всего: ' + this.point.stackTotal;
}",
                               //      'pointFormat' => '{series.name}: <b>{point.y:.1f}</b>'
                           ), */
                        'yAxis'   => [
                          'min'   => 0,
                          'max'   => $maxVal, //power_max, power_now, total_devices_count
                          'title' => [
                            'text'    => 'Ps<sub>тек</sub>',
                            'useHTML' => true,
                          ],
                            //'minColor' => 'rgba(0, 255, 0, 1)',//'#55BF3B',
                            //'maxColor' => 'rgba(255, 0, 0, 1)',//'#DF5353',
                          'stops' => [
                            [0, 'rgba(0, 255, 0, 1)'], // green #55BF3B
                            [0.15, '#90ee7e'], // green #55BF3B
                            [0.7, '#e3d257'], // yellow #DDDF0D
                            [0.85, '#f7a35c'], // red #DF5353
                            [1, 'rgba(255, 0, 0, 1)'], // green #55BF3B
                          ],
                            /*
                            'lineWidth'         => 0,
                            'tickWidth'         => 0,
                            'minorTickInterval' => null,
                            'tickAmount'        => 2,
                            'title'             => [
                              'y' => -70
                            ],
                            'labels'            => [
                              'y' => 16
                            ]
                            */
                        ],

                        'series' => [
                          [
                            'name'       => 'Ps',
                            'data'       => [$nowVal], //power_max, power_now, total_devices_count],
                            'dataLabels' => [
                              'format' => '<div style="text-align:center"><span style="font-size:35px">{y}</span><br/>
                                                <span style="font-size:14px;opacity:0.4">kW</span></div>',
                            ],
                            'tooltip'    => [
                              'valueSuffix' => ' kW',
                            ],
                          ],
                        ],

                      ],
                    ]
                  );
                  /*
                                                  Yii::app()->clientScript->registerScript(
                                                    'chartPowerSScript',
                                                    /** @lang JavaScript * / "
                                                  // Bring life to the dials
                  setInterval(function () {
                      let point,
                          nowVal, maxVal, tryVal,
                          inc;
                      let chartPowerS = $('#dashboard-energy-all-devices-power-now-gauge').highcharts();
                      if (typeof chartPowerS !== 'undefined') {
                          point = chartPowerS.series[0].points[0];
                          inc = Math.round((Math.random() - 0.5) * 5);
                   nowVal = {$nowVal};
                   maxVal = {$maxVal};
                    tryVal = nowVal + inc;
                          if (tryVal < 0 || tryVal > maxVal) {
                              tryVal = nowVal - inc;
                          }
                          //tryVal = Math.round(Math.random() * 0.95 * maxVal);
                          //point.update(tryVal);
                          chartPowerS.series[0].setData([tryVal]);
                      }
                  }, 15000);
                                                  "
                                                  );
                  */
                  unset($XValue, $XValues, $YValues, $i, $j, $maxVal, $nowVal, $serie, $series, $serieData, $seriesData);
                  ?>

              </div>
              <div class="col-md-6">
                  <?
                  $sql = "select dd1.device_id, coalesce(odm.name,odm.source||odm.devices_id) as device_name, 
 dd1.power_a_plus
 from
(select tt1.device_id, tt1.power_a_plus, tt1.datetime,
row_number() over (partition by tt1.device_id order by tt1.datetime desc) as rn
 from src_nekta_data_type5 tt1
 where tt1.datetime >= now() - interval '120 min'
 ) dd1
     left join obj_devices_manual odm on dd1.device_id = odm.devices_id
 where dd1.rn = 1
 order by power_a_plus desc";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))->createCommand(
                    $sql
                  )->queryAll();
                  $series = [
                    [
                      'name'      => 'Все приборы учёта',
                      'colorAxis' => 0,
                      'colorKey'  => 'value',
                      'data'      => [],
                    ],
                  ];
                  foreach ($seriesData as $serieData) {
                      $series[0]['data'][] = [
                        'name'  => $serieData['device_name'],
                        'value' => round((float) $serieData['power_a_plus'], 3),
                      ];
                  }
                  if (is_array($seriesData) && count($seriesData)) {
                      $zMax = round((float) $seriesData[0]['power_a_plus'], 3);
                      $zMin = round((float) end($seriesData)['power_a_plus'], 3);
                      ?>
                      <?
                      $this->Widget(
                        'ext.highcharts.HighchartsWidget',
                        [
                          'htmlOptions' => [
                            'id' => 'dashboard-energy-all-top-power-devices-moment-real-gauge',
                          ],
                          'scripts'     => [
                            'highcharts-more',
                              // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                              //'highcharts-3d',
                            'themes/grid-light',
                              // applies global 'grid' theme to all charts
                            'modules/coloraxis',
                          ],
                          'options'     => [
                            'credits'   => ['enabled' => false],
                            'chart'     => [
                              'type'       => 'packedbubble',
                              'styledMode' => false,
                                //'height' => '100%'
                            ],
                            'colorAxis' => [
                              [
                                'minColor' => 'rgba(0, 255, 0, 1)',//'#55BF3B',
                                'maxColor' => 'rgba(255, 0, 0, 1)',//'#DF5353',
                                'stops'    => [
                                  [0, 'rgba(0, 255, 0, 1)'], // green #55BF3B
                                  [0.15, '#90ee7e'], // green #55BF3B
                                  [0.5, '#e3d257'], // yellow #DDDF0D
                                  [0.85, '#f7a35c'], // red #DF5353
                                  [1, 'rgba(255, 0, 0, 1)'], // green #55BF3B
                                ],
                                'labels'   => [
                                  'formatter' => "js:function () {return Math.abs(this.value) + 'kW';}",
                                ],
                              ],
                            ],
                            'title'     => [
                              'enabled' => true,
                              'text'    => 'ТОП приборов по текущей мощности',
                              'useHTML' => true,
                            ],

                            'exporting' => [
                              'enabled' => false,
                            ],

                            'tooltip'     => [
                              'useHTML'   => true,
                              'formatter' => "js:function () {return '<strong>' + this.point.name +'</strong><br>'+this.point.value+' kW'; }",
                                //'<b>'+this.point.name+':</b> '+
                            ],
                            'plotOptions' => [
                              'packedbubble' => [
                                'minSize'         => '10%',
                                'maxSize'         => '120%',
                                'zMin'            => $zMin,
                                'zMax'            => $zMax,
                                'layoutAlgorithm' => [
                                  'splitSeries'           => false,
                                  'gravitationalConstant' => 0.02,
                                ],
                                'dataLabels'      => [
                                  'enabled' => true,
                                    //'useHTML' => true,
                                  'format'  => '{point.name}',
                                    /*  'filter'  => [
                                    'property' => 'y',
                                    'operator' => '>',
                                    'value'    => 250
                                      ], */
                                  'style'   => [
                                    'color'       => 'black',
                                    'textOutline' => 'none',
                                    'fontWeight'  => 'normal',
                                  ],
                                ],
                              ],
                            ],
                            'series'      => $series,
                          ],
                        ],
                      );
                  } else {
                      ?>
                    <div class="alert alert-warning alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                        &times;
                      </button>
                      <h4><i class="icon fa fa-warning"></i> Внимание!</h4>
                      Недостаточно данных для обработки.
                    </div>
                      <?
                  }
                  unset($seriesData, $serieData, $series, $sql);
                  ?>
              </div>
            </div>
            <div class="row no-padding">
              <div class="col-md-6">
                  <?

                  $sql = "
select to_char(max(tt.data_updated), 'TMDy, DD-MM-YYYY') AS \"date\"
 from obj_devices_data_view tt
where tt.data_updated >= now() - interval '14 day' 
 group by to_char(tt.data_updated, 'YYYYMMDD')
order by to_char(tt.data_updated, 'YYYYMMDD') 
                                            ";
                  $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
                    $sql
                  )->queryColumn();
                  /** @noinspection SqlAggregates */
                  $sql = "  select dd.date, dd.tariffs[6] as tariff_type, dd.tariffs[1] as tariff_day, 
                             dd.tariffs[2] as tariff_night,
                            dd.tariffs[3] as active_devices_count, 
                            dd.tariffs[4] as tariff_day_avg, 
                            dd.tariffs[5] as tariff_night_avg,
                            total_devices_count
                             from 
                            (
                            select to_char(tt.data_updated, 'YYYYMMDD') as date_to_order, 
														to_char(max(tt.data_updated), 'TMDy, DD-MM-YYYY') AS \"date\", 
                            case when coalesce(sum(tt.delta_tariff1),0)::numeric
                            >1.1*(coalesce(sum(tt.delta_tariff2),0)::numeric + coalesce(sum(tt.delta_tariff3),0)::numeric)
                            then 
														array[
														coalesce(sum(tt.delta_tariff1),0)::numeric,
														0,
                            round((coalesce(sum(tt.delta_tariff1),0)/coalesce(avg(tt.delta_tariff1),1))::numeric,0),
                            percentile_cont(0.5) within group (order by tt.delta_tariff1),
														0,
														1]
                            else  
                            array[
														coalesce(sum(tt.delta_tariff2),0)::numeric,
                            coalesce(sum(tt.delta_tariff3),0)::numeric,
                            round(coalesce(sum(tt.delta_tariff2)/(avg(tt.delta_tariff2) 
														-- * extract(days FROM date_trunc('month', max(tt.data_updated)) + interval '1 month - 1 day')
														),0)::numeric,0),
                            percentile_cont(0.5) within group (order by tt.delta_tariff2),
                            percentile_cont(0.5) within group (order by tt.delta_tariff3),
														2] end as tariffs,
                            (select count(0) from obj_devices_view odv where (odv.created_at <= (max(tt.data_updated)))
                            and (odv.last_active >= (max(tt.data_updated)-interval '1 day') or odv.last_active is null)) as total_devices_count
                            from 
														(
														select max(zz.data_updated) as data_updated, zz.device_id, 
														sum(zz.delta_tariff1) as delta_tariff1, sum(zz.delta_tariff2) as delta_tariff2, 
														sum(zz.delta_tariff3) as delta_tariff3
														from obj_devices_data_view zz 
														group by to_char(zz.data_updated, 'YYYYMMDD'), zz.device_id
														)
														tt
                                left join obj_devices_manual odm on tt.device_id = odm.devices_id
                            where tt.data_updated >= now() - interval '14 day' 
                             group by to_char(tt.data_updated, 'YYYYMMDD')
                            ) dd
                            order by date_to_order ";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))
                    ->createCommand(
                      $sql
                    )
                    ->queryAll();
                  $series = [];
                  if (count($XValues)) {
                      $serieCountedDay = [
                        'name' => 'Тариф "день" (учёт)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      $serieCountedNight = [
                        'name' => 'Тариф "ночь" (учёт)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      $serieForecastDay = [
                        'name' => 'Тариф "день" (прогноз)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      $serieForecastNight = [
                        'name' => 'Тариф "ночь" (прогноз)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      foreach ($XValues as $i => $XValue) {
                          foreach ($seriesData as $j => $serieData) {
                              if ($serieData['date'] == $XValue) { //&& $serieData['device_id'] == $seriesName
                                  //date, tariff_day, tariff_night, active_devices_count, tariff_day_avg, tariff_night_avg, total_devices_count
                                  $serieCountedDay['data'][$i] = round($serieData['tariff_day']);
                                  $serieCountedNight['data'][$i] = round($serieData['tariff_night']);
                                  $serieForecastDay['data'][$i] = round(
                                    $serieData['tariff_day_avg']
                                    * ($serieData['total_devices_count'] - $serieData['active_devices_count'])
                                  );
                                  $serieForecastNight['data'][$i] = round(
                                    $serieData['tariff_night_avg']
                                    * ($serieData['total_devices_count'] - $serieData['active_devices_count'])
                                  );
                                  //unset($seriesData[$j]);
                                  break;
                              }
                          }
                      }
                      $series = [
                        $serieCountedDay,
                        $serieCountedNight,
                        $serieForecastDay,
                        $serieForecastNight,
                      ];
                      $this->Widget(
                        'ext.highcharts.HighchartsWidget',
                        [
                          'htmlOptions' => [
                            'id' => 'dashboard-energy-all-devices-power-14days-chart',
                          ],
                          'scripts'     => [
                            'highcharts-more',
                              // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                            'highcharts-3d',
                            'modules/exporting',
                              // adds Exporting button/menu to chart
                            'themes/grid-light'
                              // applies global 'grid' theme to all charts
                          ],
                          'options'     => [
                            'chart'       => [
                              'type'      => 'column',
                              'options3d' => [
                                'enabled'      => true,
                                'alpha'        => 10,
                                'beta'         => 5,
                                'viewDistance' => 35,
                                'depth'        => 40,
                              ]
                                // 'style' => 'width:100%;'
                            ],
                            'plotOptions' => [
                              'column' => [
                                'stacking'   => 'normal',
                                'depth'      => 40,
                                'dataLabels' => [
                                  'enabled' => false,
                                  'skew3d'  => true,
                                ],
                                'animation'  => [
                                  'duration' => 0,
                                  'defer'    => 0,
                                ],
                              ],
                            ],
                            'credits'     => ['enabled' => false],
                            'title'       => [
                              'enabled' => true,
                              'text'    => 'История потребления за 14 дней',
                            ],
                            'tooltip'     => [
                              'formatter' => "js:function(){
    return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Всего: ' + this.point.stackTotal;
}",
                                //      'pointFormat' => '{series.name}: <b>{point.y:.1f}</b>'
                            ],
                            'xAxis'       => [
                              'categories'        => $XValues,
                              'labels'            => [
                                'skew3d' => true,
                              ],
                              'tickmarkPlacement' => 'on',
                              'title'             => [
                                'enabled' => false,
                              ],
                            ],
                            'yAxis'       => [
                              'min'         => 0,
                              'title'       => [
                                'text'   => 'Потреблене за 24 часа, kWh',
                                'skew3d' => true,
                              ],
                              'stackLabels' => [
                                'enabled' => true,
                                'skew3d'  => true,
                              ],
                            ],
                            'series'      => $series,
                          ],
                        ]
                      );
                  } else { ?>
                    <p>Нет данных</p>
                  <? } ?>
              </div>
              <div class="col-md-6">
                  <?
                  $sql = "
select to_char(max(tt.data_updated), 'TMMon YYYY') AS \"date\"
 from obj_devices_data_view tt
where tt.data_updated >= now() - interval '1 year' 
 group by to_char(tt.data_updated, 'YYYYMM')
order by to_char(tt.data_updated, 'YYYYMM') 
                                            ";
                  $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
                    $sql
                  )->queryColumn();
                  /** @noinspection SqlAggregates */
                  $sql = "  select dd.date, dd.tariffs[6] as tariff_type, dd.tariffs[1] as tariff_day, 
                             dd.tariffs[2] as tariff_night,
                            dd.tariffs[3] as active_devices_count, 
                            dd.tariffs[4] as tariff_day_avg, 
                            dd.tariffs[5] as tariff_night_avg,
                            total_devices_count
                             from 
                            (
                            select to_char(tt.data_updated, 'YYYYMM') as date_to_order, 
														to_char(max(tt.data_updated), 'TMMon YYYY') AS \"date\", 
                            case when coalesce(sum(tt.delta_tariff1),0)::numeric
                            >1.1*(coalesce(sum(tt.delta_tariff2),0)::numeric + coalesce(sum(tt.delta_tariff3),0)::numeric)
                            then 
														array[
														coalesce(sum(tt.delta_tariff1),0)::numeric,
														0,
                            round((coalesce(sum(tt.delta_tariff1),0)/coalesce(avg(tt.delta_tariff1),1))::numeric,0),
                            percentile_cont(0.5) within group (order by tt.delta_tariff1),
														0,
														1]
                            else  
                            array[
														coalesce(sum(tt.delta_tariff2),0)::numeric,
                            coalesce(sum(tt.delta_tariff3),0)::numeric,
                            round(coalesce(sum(tt.delta_tariff2)/(avg(tt.delta_tariff2) 
														-- * extract(days FROM date_trunc('month', max(tt.data_updated)) + interval '1 month - 1 day')
														),0)::numeric,0),
                            percentile_cont(0.5) within group (order by tt.delta_tariff2),
                            percentile_cont(0.5) within group (order by tt.delta_tariff3),
														2] end as tariffs,
                            (select count(0) from obj_devices_view odv where (odv.created_at <= (max(tt.data_updated)))
                            and (odv.last_active >= (max(tt.data_updated)-interval '1 day') or odv.last_active is null)) as total_devices_count
                            from 
														(
														select max(zz.data_updated) as data_updated, zz.device_id, 
														sum(zz.delta_tariff1) as delta_tariff1, sum(zz.delta_tariff2) as delta_tariff2, 
														sum(zz.delta_tariff3) as delta_tariff3
														from obj_devices_data_view zz 
														group by to_char(zz.data_updated, 'YYYYMM'), zz.device_id
														)
														tt
                                left join obj_devices_manual odm on tt.device_id = odm.devices_id
                            where tt.data_updated >= now() - interval '1 year' 
														group by to_char(tt.data_updated, 'YYYYMM')
                            ) dd
                            order by date_to_order ";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))
                    ->createCommand(
                      $sql
                    )
                    ->queryAll();
                  $series = [];
                  if (count($XValues)) {
                      $serieCountedDay = [
                        'name' => 'Тариф "день" (учёт)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      $serieCountedNight = [
                        'name' => 'Тариф "ночь" (учёт)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      $serieForecastDay = [
                        'name' => 'Тариф "день" (прогноз)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      $serieForecastNight = [
                        'name' => 'Тариф "ночь" (прогноз)',
                        'data' => array_fill(0, count($XValues), 0),
                          //'stack' => 'Активные',
                      ];
                      foreach ($XValues as $i => $XValue) {
                          foreach ($seriesData as $j => $serieData) {
                              if ($serieData['date'] == $XValue) { //&& $serieData['device_id'] == $seriesName
                                  //date, tariff_day, tariff_night, active_devices_count, tariff_day_avg, tariff_night_avg, total_devices_count
                                  $serieCountedDay['data'][$i] = round($serieData['tariff_day']);
                                  $serieCountedNight['data'][$i] = round($serieData['tariff_night']);
                                  $serieForecastDay['data'][$i] = round(
                                    $serieData['tariff_day_avg']
                                    * ($serieData['total_devices_count'] - $serieData['active_devices_count'])
                                  );
                                  $serieForecastNight['data'][$i] = round(
                                    $serieData['tariff_night_avg']
                                    * ($serieData['total_devices_count'] - $serieData['active_devices_count'])
                                  );
                                  //unset($seriesData[$j]);
                                  break;
                              }
                          }
                      }
                      $series = [
                        $serieCountedDay,
                        $serieCountedNight,
                        $serieForecastDay,
                        $serieForecastNight,
                      ];
                      $this->Widget(
                        'ext.highcharts.HighchartsWidget',
                        [
                          'htmlOptions' => [
                            'id' => 'dashboard-energy-all-devices-power-1year-chart',
                          ],
                          'scripts'     => [
                            'highcharts-more',
                              // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                            'highcharts-3d',
                            'modules/exporting',
                              // adds Exporting button/menu to chart
                            'themes/grid-light'
                              // applies global 'grid' theme to all charts
                          ],
                          'options'     => [
                            'chart'       => [
                              'type'      => 'column',
                              'options3d' => [
                                'enabled'      => true,
                                'alpha'        => 10,
                                'beta'         => 5,
                                'viewDistance' => 35,
                                'depth'        => 40,
                              ]
                                // 'style' => 'width:100%;'
                            ],
                            'plotOptions' => [
                              'column' => [
                                'stacking'   => 'normal',
                                'depth'      => 40,
                                'dataLabels' => [
                                  'enabled' => false,
                                  'skew3d'  => true,
                                ],
                                'animation'  => [
                                  'duration' => 0,
                                  'defer'    => 0,
                                ],
                              ],
                            ],
                            'credits'     => ['enabled' => false],
                            'title'       => [
                              'enabled' => true,
                              'text'    => 'История потребления за 12 месяцев',
                            ],
                            'tooltip'     => [
                              'formatter' => "js:function(){
    return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Всего: ' + this.point.stackTotal;
}",
                                //      'pointFormat' => '{series.name}: <b>{point.y:.1f}</b>'
                            ],
                            'xAxis'       => [
                              'categories'        => $XValues,
                              'labels'            => [
                                'skew3d' => true,
                              ],
                              'tickmarkPlacement' => 'on',
                              'title'             => [
                                'enabled' => false,
                              ],
                            ],
                            'yAxis'       => [
                              'min'         => 0,
                              'title'       => [
                                'text'   => 'Потреблене за 1 месяц, kWh',
                                'skew3d' => true,
                              ],
                              'stackLabels' => [
                                'enabled' => true,
                                'skew3d'  => true,
                              ],
                            ],
                            'series'      => $series,
                          ],
                        ]
                      );
                  } else { ?>
                    <p>Нет данных</p>
                  <? } ?>
                  <?
                  unset(
                    $XValue, $XValues, $i, $j, $serieCountedDay, $serieCountedNight,
                    $serieData, $serieForecastDay, $serieForecastNight, $series, $seriesData, $sql
                  );
                  ?>
              </div>
            </div>
            <div class="row no-padding">
              <div class="col-md-12">
                  <?
                  $sql = " select to_char(max(tt.datetime), 'TMMon, YYYY') AS \"date\"
 from src_nekta_data_type5 tt
where tt.datetime >= now() - interval '1 year' 
 group by to_char(tt.datetime, 'YYYYMM')
order by to_char(tt.datetime, 'YYYYMM')";
                  $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
                    $sql
                  )->queryColumn();
                  /** @noinspection SqlAggregates */
                  $sql = "select to_char(max(tt.datetime), 'TMMon, YYYY') AS \"date\", 
percentile_cont(0.99) within group (order by tt.power_a_plus)
       -- max(tt.power_a_plus) 
    as power_a_plus,
percentile_cont(0.99) within group (order by tt.power_a_plus)*0.45/0.8 as power_a_plus_kpower_cosf,
percentile_cont(0.5) within group (order by tt.power_a_plus) as power_a_plus_05,
avg(tt.power_a_plus) as  power_a_plus_avg,
(select count(0) from obj_devices_view odv where (odv.created_at <= (max(tt.datetime)))
                            and (odv.last_active >= (max(tt.datetime)-interval '1 day') or odv.last_active is null)) as total_devices_count,
(select count(0) from obj_devices_view odv) as total_now_devices_count														
from src_nekta_data_type5 tt
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.datetime >= now() - interval '1 year' 
 group by to_char(tt.datetime, 'YYYYMM')
order by to_char(tt.datetime, 'YYYYMM')";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
                    $sql
                  )->queryAll();
                  $series = [];
                  if (count($XValues)) {
                      $seriePmax = [
                        'name' => 'Ps max',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePmaxKpowerCosF = [
                        'name' => 'Ps ✕ Kc ✕ cosφ',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePmedian = [
                        'name' => 'Me(Ps)',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePavg = [
                        'name' => 'μ(Ps)',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePmaxN = [
                        'name' => 'M(Ps max)',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePmaxKpowerCosFN = [
                        'name' => 'M(Ps ✕ Kc ✕ cosφ)',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePmedianN = [
                        'name' => 'M(Me(Ps))',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      $seriePavgN = [
                        'name' => 'M(μ(Ps))',
                        'data' => array_fill(0, count($XValues), 0),
                      ];
                      foreach ($XValues as $i => $XValue) {
                          foreach ($seriesData as $j => $serieData) {
                              if ($serieData['date'] == $XValue) { //&& $serieData['device_id'] == $seriesName
                                  $seriePmax['data'][$i] = round(
                                    (float) $serieData['power_a_plus'] * $serieData['total_devices_count']
                                  );
                                  $seriePmaxN['data'][$i] = round(
                                    (float) $serieData['power_a_plus'] * $serieData['total_now_devices_count']
                                  );
                                  $seriePmaxKpowerCosF['data'][$i] = round(
                                    (float) $serieData['power_a_plus_kpower_cosf'] * $serieData['total_devices_count']
                                  );
                                  $seriePmaxKpowerCosFN['data'][$i] = round(
                                    (float) $serieData['power_a_plus_kpower_cosf'] *
                                    $serieData['total_now_devices_count']
                                  );
                                  $seriePmedian['data'][$i] = round(
                                    (float) $serieData['power_a_plus_05'] * $serieData['total_devices_count']
                                  );
                                  $seriePmedianN['data'][$i] = round(
                                    (float) $serieData['power_a_plus_05'] * $serieData['total_now_devices_count']
                                  );
                                  $seriePavg['data'][$i] = round(
                                    (float) $serieData['power_a_plus_avg'] * $serieData['total_devices_count']
                                  );
                                  $seriePavgN['data'][$i] = round(
                                    (float) $serieData['power_a_plus_avg'] * $serieData['total_now_devices_count']
                                  );
                                  //unset($seriesData[$j]);
                                  break;
                              }
                          }
                      }
                      $series = [
                        $seriePmax,
                        $seriePmaxN,
                        $seriePmaxKpowerCosF,
                        $seriePmaxKpowerCosFN,
                        $seriePmedian,
                        $seriePmedianN,
                        $seriePavg,
                        $seriePavgN,
                      ];
                      ?>
                    <div class="row no-padding">
                      <div class="col-md-12">
                          <?
                          $this->Widget(
                            'ext.highcharts.HighchartsWidget',
                            [
                              'htmlOptions' => [
                                'id' => 'dashboard-all-chart-power-P',
                              ],
                              'scripts'     => [
                                'highcharts-more',
                                  // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                                'highcharts-3d',
                                'modules/exporting',
                                  // adds Exporting button/menu to chart
                                'themes/grid-light'
                                  // applies global 'grid' theme to all charts
                              ],
                              'options'     => [
                                'chart'       => [
                                  'type' => 'line',
                                    // 'style' => 'width:100%;'
                                ],
                                'plotOptions' => [
                                  "line" => [
                                    'dataLabels'          => [
                                      'enabled' => true,
                                    ],
                                    'enableMouseTracking' => true,
                                  ],
                                ],
                                'credits'     => ['enabled' => false],
                                'title'       => [
                                  'text'    => 'Мощность учтенная и общая расчётная, пиковая, средняя и т.п.',
                                  'enabled' => true,
                                ],
                                'tooltip'     => [
                                  'formatter' => "js:function(){
    return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y +'kW';
}",
                                    //      'pointFormat' => '{series.name}: <b>{point.y:.1f}</b>'
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
                                  'title' => ['text' => 'Мощность P, kW'],
                                ],
                                'series'      => $series,
                              ],
                            ]
                          );
                          ?>
                          <?
                          unset(
                            $i, $j, $serieData, $seriePavg,
                            $seriePavgN, $seriePmax, $seriePmaxN,
                            $seriePmaxKpowerCosF, $seriePmaxKpowerCosFN,
                            $seriePmedian, $seriePmedianN, $series, $seriesData, $sql,
                            $XValue, $XValues
                          );
                          ?>
                      </div>
                    </div>
                  <? } ?>
              </div>
            </div>
            <div class="row no-padding">
              <div class="col-md-6">
                  <?
                  $sql = "select dd.device_id, coalesce(odv.name,odv.source||odv.devices_id) as device_name, 
       round(dd.tariffs[1]::float8 + dd.tariffs[2]::float8) as tariff
from
(select tt.device_id,
case when coalesce(sum(tt.delta_tariff1),0)::numeric
                            >1.1*(coalesce(sum(tt.delta_tariff2),0)::numeric + coalesce(sum(tt.delta_tariff3),0)::numeric)
                            then 
														array[
														coalesce(sum(tt.delta_tariff1),0)::numeric,
														0,
														1]
                            else  
                            array[
														coalesce(sum(tt.delta_tariff2),0)::numeric,
                            coalesce(sum(tt.delta_tariff3),0)::numeric,
														2] end as tariffs
 from obj_devices_data_view tt
where tt.data_updated >= now() - interval '30 day'
group by tt.device_id) dd
left join obj_devices_view odv on odv.devices_id = dd.device_id 
order by tariff desc";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))->createCommand(
                    $sql
                  )->queryAll();
                  $series = [
                    [
                      'name'      => 'Все приборы учёта',
                      'colorAxis' => 0,
                      'colorKey'  => 'value',
                      'data'      => [],
                    ],
                  ];
                  foreach ($seriesData as $serieData) {
                      $series[0]['data'][] = [
                        'name'  => $serieData['device_name'],
                        'value' => (float) $serieData['tariff'],
                      ];
                  }
                  $zMax = round((float) $seriesData[0]['tariff']);
                  $zMin = round((float) end($seriesData)['tariff']);
                  ?>
                  <?
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'htmlOptions' => [
                        'id' => 'dashboard-energy-all-top-power-devices-now-gauge',
                      ],
                      'scripts'     => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          //'highcharts-3d',
                        'themes/grid-light',
                          // applies global 'grid' theme to all charts
                        'modules/coloraxis',
                      ],
                      'options'     => [
                        'credits'   => ['enabled' => false],
                        'chart'     => [
                          'type'       => 'packedbubble',
                          'styledMode' => false,
                          'height'     => '100%',
                        ],
                        'colorAxis' => [
                          [
                            'minColor' => 'rgba(0, 255, 0, 1)',//'#55BF3B',
                            'maxColor' => 'rgba(255, 0, 0, 1)',//'#DF5353',
                            'stops'    => [
                              [0, 'rgba(0, 255, 0, 1)'], // green #55BF3B
                              [0.15, '#90ee7e'], // green #55BF3B
                              [0.5, '#e3d257'], // yellow #DDDF0D
                              [0.85, '#f7a35c'], // red #DF5353
                              [1, 'rgba(255, 0, 0, 1)'], // green #55BF3B
                            ],
                            'labels'   => [
                              'formatter' => "js:function () {return Math.abs(this.value) + 'kWh';}",
                            ],
                          ],
                        ],
                        'title'     => [
                          'enabled' => true,
                          'text'    => 'ТОП приборов по потреблению, за 30 дней',
                          'useHTML' => true,
                        ],

                        'exporting' => [
                          'enabled' => false,
                        ],

                        'tooltip'     => [
                            //'useHTML'     => true,
                          'formatter' => "js:function () {return '<strong>' + this.point.name +'</strong><br>' + this.point.value+' kWh'; }",
                            //'<b>'+this.point.name+':</b> '+
                        ],
                        'plotOptions' => [
                          'packedbubble' => [
                            'minSize'         => '10%',
                            'maxSize'         => '120%',
                            'zMin'            => $zMin,
                            'zMax'            => $zMax,
                            'layoutAlgorithm' => [
                              'splitSeries'           => false,
                              'gravitationalConstant' => 0.02,
                            ],
                            'dataLabels'      => [
                              'enabled' => true,
                                //'useHTML' => true,
                              'format'  => '{point.name}',
                                /*  'filter'  => [
                                    'property' => 'y',
                                    'operator' => '>',
                                    'value'    => 250
                                  ], */
                              'style'   => [
                                'color'       => 'black',
                                'textOutline' => 'none',
                                'fontWeight'  => 'normal',
                              ],
                            ],
                          ],
                        ],
                        'series'      => $series,
                      ],
                    ],
                  );
                  unset($seriesData, $serieData, $series, $sql);
                  ?>
              </div>
              <div class="col-md-6">
                  <?
                  $sql = "select dd.device_id, coalesce(odv.name,odv.source||odv.devices_id) as device_name, 
       power_a_plus_max,power_a_plus_05, power_a_plus_099
 from
(select tt.device_id,
max(tt.power_a_plus) as power_a_plus_max,
  percentile_cont(0.5) within group (order by tt.power_a_plus)
	 as power_a_plus_05,
	percentile_cont(0.99) within group (order by tt.power_a_plus) as power_a_plus_099
 from src_nekta_data_type5 tt
 where tt.datetime >= now() - interval '30 day'
group by tt.device_id
) dd
left join obj_devices_view odv on odv.devices_id = dd.device_id 
order by power_a_plus_max desc";
                  $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))->createCommand(
                    $sql
                  )->queryAll();
                  $series = [
                    [
                      'name'      => 'Все приборы учёта',
                      'colorAxis' => 0,
                      'colorKey'  => 'value',
                        /* 'marker'    => [
                           'fillColor' => [
                             'radialGradient' => ['cx' => 0.4, 'cy' => 0.3, 'r' => 0.7],
                             'stops'          => [
                               [0, 'rgba(0,0,0,0.01)'],
                               [1, 'rgba(128,128,128,0.01)'],
                             ]
                           ]
                         ],
                        */
                      'data'      => [],
                    ],
                  ];
                  foreach ($seriesData as $serieData) {
                      $series[0]['data'][] = [
                        'name'  => $serieData['device_name'],
                        'value' => round((float) $serieData['power_a_plus_099'], 3),
                      ];
                  }
                  $zMax = round((float) $seriesData[0]['power_a_plus_099'], 3);
                  $zMin = round((float) end($seriesData)['power_a_plus_099'], 3);
                  ?>
                  <?
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'htmlOptions' => [
                        'id' => 'dashboard-energy-all-top-power-devices-moment-gauge',
                      ],
                      'scripts'     => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                          //'highcharts-3d',
                        'themes/grid-light',
                          // applies global 'grid' theme to all charts
                        'modules/coloraxis',
                      ],
                      'options'     => [
                        'credits'   => ['enabled' => false],
                        'chart'     => [
                          'type'       => 'packedbubble',
                          'styledMode' => false,
                          'height'     => '100%',
                        ],
                        'colorAxis' => [
                          [
                            'minColor' => 'rgba(0, 255, 0, 1)',//'#55BF3B',
                            'maxColor' => 'rgba(255, 0, 0, 1)',//'#DF5353',
                            'stops'    => [
                              [0, 'rgba(0, 255, 0, 1)'], // green #55BF3B
                              [0.15, '#90ee7e'], // green #55BF3B
                              [0.5, '#e3d257'], // yellow #DDDF0D
                              [0.85, '#f7a35c'], // red #DF5353
                              [1, 'rgba(255, 0, 0, 1)'], // green #55BF3B
                            ],
                            'labels'   => [
                              'formatter' => "js:function () {return Math.abs(this.value) + 'kW';}",
                            ],
                          ],
                        ],
                        'title'     => [
                          'enabled' => true,
                          'text'    => 'ТОП приборов по пиковой мощности, за 30 дней',
                          'useHTML' => true,
                        ],

                        'exporting' => [
                          'enabled' => false,
                        ],

                        'tooltip'     => [
                            //'useHTML'     => true,
                          'formatter' => "js:function () {return '<strong>' + this.point.name +'</strong><br>'  +this.point.value+' kW'; }",
                            //'<b>'+this.point.name+':</b> '+
                        ],
                        'plotOptions' => [
                          'packedbubble' => [
                            'minSize'         => '10%',
                            'maxSize'         => '120%',
                            'zMin'            => $zMin,
                            'zMax'            => $zMax,
                            'layoutAlgorithm' => [
                              'splitSeries'           => false,
                              'gravitationalConstant' => 0.02,
                            ],
                            'dataLabels'      => [
                              'enabled' => true,
                                //'useHTML' => true,
                              'format'  => '{point.name}',
                                /*  'filter'  => [
                                'property' => 'y',
                                'operator' => '>',
                                'value'    => 250
                                  ], */
                              'style'   => [
                                'color'       => 'black',
                                'textOutline' => 'none',
                                'fontWeight'  => 'normal',
                              ],
                            ],
                          ],
                        ],
                        'series'      => $series,
                      ],
                    ],
                  );
                  unset($seriesData, $serieData, $series, $sql);
                  ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <? /* Энергетика */ ?>
    <div class="row<?= (Utils::isDeveloperIp() ? '' : ' hide') ?>">
      <div class="col-md-12">
        <div class="box box-default collapsed-box"> <? /*  box-default collapsed-box */ ?>
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Черновики для разработчиков</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-plus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body"> <? /* style="display: none;"*/ ?>
            <h1>Календарь событий запилить!</h1>
            <h1>bredcrumbs сделать как в adminLte!</h1>
            <h3>Финансы</h3>
            <ul>
              <li>Круговая диаграмма начислений по тарифам за 1 год факт\интерполированно</li>
              <li>Круговая диаграмма начислений по тарифам за учетный период факт\интерполированно</li>
              <li>Столбики начислений по тарифам по месяцам за год факт\интерполированно</li>
              <li>Столбики начислений\задолженности по тарифам по месяцам факт\интерполированно</li>
              <li>Перцентиль по топ плательщикам</li>
              <li>Перцентиль по топ должникам</li>
            </ul>
            <h3>Обращения</h3>
            <ul>
              <li>Пока ничего не понятно</li>
            </ul>
            <h3>Опросы</h3>
            <ul>
              <li>Пока ничего не понятно</li>
            </ul>
            <h3>Голосования</h3>
            <ul>
              <li>Пока ничего не понятно</li>
            </ul>
            <img class="img-responsive pad" src="/images/TZ/011-otchety.jpg">
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div> <? /* for Developers memo */ ?>
    <!-- Info boxes -->
    <div class="row<?= (Utils::isDeveloperIp() ? '' : ' hide') ?>">
      <div class="col-md-12">
        <div class="box box-default collapsed-box"> <? /*  box-default collapsed-box */ ?>
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Черновики для разработчиков</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-plus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              <div class="col-md-4">
                <!-- DIRECT CHAT -->
                <div class="box box-warning direct-chat direct-chat-warning">
                  <div class="box-header with-border">
                    <h3 class="box-title" data-widget="collapse">Direct Chat</h3>

                    <div class="box-tools pull-right">
                                            <span data-toggle="tooltip" title="3 New Messages"
                                                  class="badge bg-yellow">3</span>
                      <button type="button" class="btn btn-box-tool"
                              data-widget="collapse"><i
                            class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-box-tool" data-toggle="tooltip"
                              title="Contacts"
                              data-widget="chat-pane-toggle">
                        <i class="fa fa-comments"></i></button>
                      <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i
                            class="fa fa-times"></i>
                      </button>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <!-- Conversations are loaded here -->
                    <div class="direct-chat-messages">
                      <!-- Message. Default to the left -->
                      <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                          <span class="direct-chat-name pull-left">Alexander Pierce</span>
                          <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img"
                             src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user1-128x128.jpg"
                             alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          Is this template really for free? That's unbelievable!
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                      <!-- Message to the right -->
                      <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                          <span class="direct-chat-name pull-right">Sarah Bullock</span>
                          <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img"
                             src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user3-128x128.jpg"
                             alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          You better believe it!
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                      <!-- Message. Default to the left -->
                      <div class="direct-chat-msg">
                        <div class="direct-chat-info clearfix">
                          <span class="direct-chat-name pull-left">Alexander Pierce</span>
                          <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img"
                             src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user1-128x128.jpg"
                             alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          Working with AdminLTE on a great new app! Wanna join?
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                      <!-- Message to the right -->
                      <div class="direct-chat-msg right">
                        <div class="direct-chat-info clearfix">
                          <span class="direct-chat-name pull-right">Sarah Bullock</span>
                          <span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img"
                             src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user3-128x128.jpg"
                             alt="message user image">
                        <!-- /.direct-chat-img -->
                        <div class="direct-chat-text">
                          I would love to.
                        </div>
                        <!-- /.direct-chat-text -->
                      </div>
                      <!-- /.direct-chat-msg -->

                    </div>
                    <!--/.direct-chat-messages-->

                    <!-- Contacts are loaded here -->
                    <div class="direct-chat-contacts">
                      <ul class="contacts-list">
                        <li>
                          <a href="#">
                            <img class="contacts-list-img"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user1-128x128.jpg"
                                 alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Count Dracula
                                  <small class="contacts-list-date pull-right">2/28/2015</small>
                                </span>
                              <span class="contacts-list-msg">How have you been? I was...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user7-128x128.jpg"
                                 alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Sarah Doe
                                  <small class="contacts-list-date pull-right">2/23/2015</small>
                                </span>
                              <span class="contacts-list-msg">I will be waiting for...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user3-128x128.jpg"
                                 alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Nadia Jolie
                                  <small class="contacts-list-date pull-right">2/20/2015</small>
                                </span>
                              <span class="contacts-list-msg">I'll call you back at...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user5-128x128.jpg"
                                 alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Nora S. Vans
                                  <small class="contacts-list-date pull-right">2/10/2015</small>
                                </span>
                              <span class="contacts-list-msg">Where is your new...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user6-128x128.jpg"
                                 alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  John K.
                                  <small class="contacts-list-date pull-right">1/27/2015</small>
                                </span>
                              <span class="contacts-list-msg">Can I take a look at...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                        <li>
                          <a href="#">
                            <img class="contacts-list-img"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user8-128x128.jpg"
                                 alt="User Image">

                            <div class="contacts-list-info">
                                <span class="contacts-list-name">
                                  Kenneth M.
                                  <small class="contacts-list-date pull-right">1/4/2015</small>
                                </span>
                              <span class="contacts-list-msg">Never mind I found...</span>
                            </div>
                            <!-- /.contacts-list-info -->
                          </a>
                        </li>
                        <!-- End Contact Item -->
                      </ul>
                      <!-- /.contatcts-list -->
                    </div>
                    <!-- /.direct-chat-pane -->
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <form action="#" method="post">
                      <div class="input-group">
                        <input type="text" name="message" placeholder="Type Message ..."
                               class="form-control">
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-warning btn-flat">Send</button>
                          </span>
                      </div>
                    </form>
                  </div>
                  <!-- /.box-footer-->
                </div>
                <!--/.direct-chat -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <!-- Chat box -->
                <div class="box box-success">
                  <div class="box-header">
                    <i class="fa fa-comments-o"></i>

                    <h3 class="box-title" data-widget="collapse">Chat</h3>

                    <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                      <div class="btn-group" data-toggle="btn-toggle">
                        <button type="button" class="btn btn-default btn-sm active"><i
                              class="fa fa-square text-green"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm"><i
                              class="fa fa-square text-red"></i></button>
                      </div>
                    </div>
                  </div>
                  <div class="box-body chat" id="chat-box">
                    <!-- chat item -->
                    <div class="item">
                      <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user4-128x128.jpg"
                           alt="user image" class="online">

                      <p class="message">
                        <a href="#" class="name">
                          <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>
                            2:15</small>
                          Mike Doe
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                      </p>
                      <div class="attachment">
                        <h4>Attachments:</h4>

                        <p class="filename">
                          Theme-thumbnail-image.jpg
                        </p>

                        <div class="pull-right">
                          <button type="button" class="btn btn-primary btn-sm btn-flat">Open
                          </button>
                        </div>
                      </div>
                      <!-- /.attachment -->
                    </div>
                    <!-- /.item -->
                    <!-- chat item -->
                    <div class="item">
                      <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user3-128x128.jpg"
                           alt="user image" class="offline">

                      <p class="message">
                        <a href="#" class="name">
                          <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>
                            5:15</small>
                          Alexander Pierce
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                      </p>
                    </div>
                    <!-- /.item -->
                    <!-- chat item -->
                    <div class="item">
                      <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user2-160x160.jpg"
                           alt="user image" class="offline">

                      <p class="message">
                        <a href="#" class="name">
                          <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>
                            5:30</small>
                          Susan Doe
                        </a>
                        I would like to meet you to discuss the latest news about
                        the arrival of the new theme. They say it is going to be one the
                        best themes on the market
                      </p>
                    </div>
                    <!-- /.item -->
                  </div>
                  <!-- /.chat -->
                  <div class="box-footer">
                    <div class="input-group">
                      <input class="form-control" placeholder="Type message...">

                      <div class="input-group-btn">
                        <button type="button" class="btn btn-success"><i class="fa fa-plus"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.box (chat box) -->
              </div>
              <div class="col-md-4">
                <!-- quick email widget -->
                <div class="box box-info">
                  <div class="box-header">
                    <i class="fa fa-envelope"></i>

                    <h3 class="box-title">Quick Email</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                      <button type="button" class="btn btn-info btn-sm" data-widget="remove"
                              data-toggle="tooltip"
                              title="Remove">
                        <i class="fa fa-times"></i></button>
                    </div>
                    <!-- /. tools -->
                  </div>
                  <div class="box-body">
                    <form action="#" method="post">
                      <div class="form-group">
                        <input type="email" class="form-control" name="emailto"
                               placeholder="Email to:">
                      </div>
                      <div class="form-group">
                        <input type="text" class="form-control" name="subject"
                               placeholder="Subject">
                      </div>
                      <div>
                  <textarea class="textarea" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                      </div>
                    </form>
                  </div>
                  <div class="box-footer clearfix">
                    <button type="button" class="pull-right btn btn-default" id="sendEmail">Send
                      <i class="fa fa-arrow-circle-right"></i></button>
                  </div>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- Main row -->
            <div class="row">
              <!-- Left col -->
              <section class="col-lg-7 connectedSortable">
                <!-- TO DO List -->
                <div class="box box-primary">
                  <div class="box-header">
                    <i class="ion ion-clipboard"></i>

                    <h3 class="box-title" data-widget="collapse">To Do List</h3>

                    <div class="box-tools pull-right">
                      <ul class="pagination pagination-sm inline">
                        <li><a href="#">&laquo;</a></li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">&raquo;</a></li>
                      </ul>
                    </div>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="todo-list">
                      <li>
                        <!-- drag handle -->
                        <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                        <!-- checkbox -->
                        <input type="checkbox" value="">
                        <!-- todo text -->
                        <span class="text">Design a nice theme</span>
                        <!-- Emphasis label -->
                        <small class="label label-danger"><i class="fa fa-clock-o"></i> 2
                          mins</small>
                        <!-- General tools such as edit or delete-->
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                        <input type="checkbox" value="">
                        <span class="text">Make the theme responsive</span>
                        <small class="label label-info"><i class="fa fa-clock-o"></i> 4
                          hours</small>
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                        <input type="checkbox" value="">
                        <span class="text">Let theme shine like a star</span>
                        <small class="label label-warning"><i class="fa fa-clock-o"></i> 1
                          day</small>
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                        <input type="checkbox" value="">
                        <span class="text">Let theme shine like a star</span>
                        <small class="label label-success"><i class="fa fa-clock-o"></i> 3
                          days</small>
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                        <input type="checkbox" value="">
                        <span class="text">Check your messages and notifications</span>
                        <small class="label label-primary"><i class="fa fa-clock-o"></i> 1
                          week</small>
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                      <li>
                      <span class="handle">
                        <i class="fa fa-ellipsis-v"></i>
                        <i class="fa fa-ellipsis-v"></i>
                      </span>
                        <input type="checkbox" value="">
                        <span class="text">Let theme shine like a star</span>
                        <small class="label label-default"><i class="fa fa-clock-o"></i> 1
                          month</small>
                        <div class="tools">
                          <i class="fa fa-edit"></i>
                          <i class="fa fa-trash-o"></i>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer clearfix no-border">
                    <button type="button" class="btn btn-default pull-right"><i
                          class="fa fa-plus"></i> Add
                      item
                    </button>
                  </div>
                </div>
                <!-- /.box -->
              </section>
              <!-- /.Left col -->
              <!-- right col (We are only adding the ID to make the widgets sortable)-->
              <section class="col-lg-5 connectedSortable">

                <!-- Calendar -->
                <div class="box box-solid bg-green-gradient">
                  <div class="box-header">
                    <i class="fa fa-calendar"></i>

                    <h3 class="box-title">Calendar</h3>
                    <!-- tools box -->
                    <div class="pull-right box-tools">
                      <!-- button with a dropdown -->
                      <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm dropdown-toggle"
                                data-toggle="dropdown">
                          <i class="fa fa-bars"></i></button>
                        <ul class="dropdown-menu pull-right" role="menu">
                          <li><a href="#">Add new event</a></li>
                          <li><a href="#">Clear events</a></li>
                          <li class="divider"></li>
                          <li><a href="#">View calendar</a></li>
                        </ul>
                      </div>
                      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
                        <i
                            class="fa fa-minus"></i>
                      </button>
                      <button type="button" class="btn btn-success btn-sm" data-widget="remove"><i
                            class="fa fa-times"></i>
                      </button>
                    </div>
                    <!-- /. tools -->
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body no-padding">
                    <!--The calendar -->
                    <div id="calendar" style="width: 100%"></div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer text-black">
                    <div class="row">
                      <div class="col-sm-6">
                        <!-- Progress bars -->
                        <div class="clearfix">
                          <span class="pull-left">Task #1</span>
                          <small class="pull-right">90%</small>
                        </div>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-green"
                               style="width: 90%;"></div>
                        </div>

                        <div class="clearfix">
                          <span class="pull-left">Task #2</span>
                          <small class="pull-right">70%</small>
                        </div>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-green"
                               style="width: 70%;"></div>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6">
                        <div class="clearfix">
                          <span class="pull-left">Task #3</span>
                          <small class="pull-right">60%</small>
                        </div>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-green"
                               style="width: 60%;"></div>
                        </div>

                        <div class="clearfix">
                          <span class="pull-left">Task #4</span>
                          <small class="pull-right">40%</small>
                        </div>
                        <div class="progress xs">
                          <div class="progress-bar progress-bar-green"
                               style="width: 40%;"></div>
                        </div>
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  </div>
                </div>
                <!-- /.box -->
              </section>
              <!-- right col -->
            </div>
          </div>
        </div>
      </div>
    </div> <? /* for Developers AdminLTE */ ?>
    <!-- /.row (main row) -->
  </section>
  <!-- /.content -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script type="text/javascript"
          src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard.js' :
            'dashboard.js' ?>"></script>
  <script type="text/javascript"
          src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard2.js' :
            'dashboard2.js' ?>"></script>
<? } ?>
<script>
    if (typeof deferredDashboard !== 'undefined') {
        console.log('deferredDashboard resolved');
        deferredDashboard.resolve(true);
    }
</script>


