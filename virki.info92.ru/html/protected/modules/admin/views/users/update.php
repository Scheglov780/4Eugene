<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var Users $model */ ?>
<? $module = Yii::app()->controller->module->id;
/** @var Lands $lands */
$lands = new Lands('search');
$lands->unsetAttributes();
$landsCriteria = new CDbCriteria();
$landsCriteria->join = "inner join obj_users_lands uu2 on uu2.lands_id = t.lands_id AND uu2.deleted is null AND uu2.uid = :uid
";
$landsCriteria->params = [
  ':uid' => $model->uid,
];
$landsDataProvider = $lands->search($landsCriteria, 100);
/** @var Lands $firstLand */
if (isset($landsDataProvider->data[0])) {
    $firstLand = $landsDataProvider->data[0];
} else {
    $firstLand = null;
}

/** @var Devices $devices */
$devices = new Devices('search');
$devices->unsetAttributes();
$devicesCriteria = new CDbCriteria();
$devicesCriteria->join = "inner join obj_lands_devices uu2 on uu2.devices_id = t.devices_id AND 
uu2.lands_id in (select uu3.lands_id from obj_users_lands uu3 where uu3.uid = :uid and uu3.deleted is null) 
and uu2.deleted is null
";
$devicesCriteria->params = [
  ':uid' => $model->uid,
];
$devicesDataProvider = $devices->search($devicesCriteria, 100);
/** @var Devices $firstDevice */
if (isset($devicesDataProvider->data[0])) {
    $firstDevice = $devicesDataProvider->data[0];
} else {
    $firstDevice = null;
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Профиль') ?>: <?= $model->fullname . ' (ID:' . $model->uid . ')'; ?>
  </h1>
</section>
<!-- Main content -->
<section class="content" id="user-update-content-section-<?= $model->uid ?>">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-xs-12">
      <div class="box">
        <div class="box-body box-profile">
          <img class="profile-user-img img-responsive img-circle"
               src="/themes/<?= Yii::app()->controller->module->id ?>/dist/img/user4-128x128.jpg"
               alt="<?= $model->fullname ?>">
          <h3 class="profile-username"><?= $model->fullname ?></h3>
          <p class="text-muted"><?= AccessRights::getRoleDescriptionByRole($model->role) ?></p>
          <h3><a href="tel:<?= $model->phone ?>"
                 title="Позвонить"><i class="fa fa-phone margin-r-5"></i><?= $model->phone ?></a></h3>
            <?
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'size'        => 'mini',
                'type'        => 'success',
                'icon'        => 'envelope white',
                'label'       => Yii::t('main', 'EMail'),
                'htmlOptions' => [
                  'class'   => 'pull-right',
                  'onclick' => '$("#new-internal-email-to-' . $model->uid . '").modal("show");return false;',
                ],
              ]
            );
            ?>
            <?
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'size'        => 'mini',
                'type'        => 'info',
                'icon'        => 'ok white',
                'label'       => Yii::t('main', 'Сообщение'),
                'htmlOptions' => [
                  'onclick' => '$("#new-internal-message-to-' .
                    $model->uid .
                    '").modal("show");return false;',
                ],
              ]
            );
            ?>
        </div>
        <div class="small-box">
          <a href="#box-for-user-data-<?= $model->uid ?>" class="small-box-footer">Подробнее <i
                class="fa fa-arrow-circle-right"></i></a>
        </div>
        <!-- /.box-body -->
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-9 col-xs-12">
      <div class="row">
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
                <? if ($firstLand) { ?>
                  <h3><?= $firstLand->land_group . '/№' . $firstLand->land_number ?></h3>
                    <? if ($firstLand->address) { ?>
                    <p><?= $firstLand->address ?></p>
                    <? } else { ?>
                    <p>Адрес не указан</p>
                    <? } ?>
                <? } else { ?>
                  <h3><a href="#box-for-user-data-<?= $model->uid ?>">Нет участков</a></h3>
                  <p>Адрес не указан</p>
                <? } ?>
            </div>
            <div class="icon">
              <i class="ion ion-android-home"></i>
            </div>
            <a href="#box-for-user-lands-<?= $model->uid ?>" class="small-box-footer">Подробнее <i
                  class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <? if ($firstDevice) { ?>
                  <h3><?= $firstDevice->source . '/' . $firstDevice->devices_id ?></h3>
                  <p><?= Utils::pgDateToStr($firstDevice->data_updated) . ' (' . Utils::pgIntervalToStr(
                        $firstDevice->data_updated_left
                      ) . ')' ?></p>
                <? } else { ?>
                  <h3><a href="#box-for-user-data-<?= $model->uid ?>">Нет приборов</a></h3>
                  <p>Данные не получены</p>
                <? } ?>
            </div>
            <div class="icon">
              <i class="ion ion-radio-waves"></i>
            </div>
            <a href="#box-for-user-devices-<?= $model->uid ?>" class="small-box-footer">Подробнее <i
                  class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Счёт: 0.00 руб</h3>

              <p>Долг: 0.00 руб</p>
            </div>
            <div class="icon">
              <i class="ion ion-card"></i>
            </div>
            <a href="#box-for-user-payments-<?= $model->uid ?>" class="small-box-footer">Подробнее <i
                  class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="#"><span class="info-box-icon bg-gray"><i class="ion ion-document"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Документы</span>
              <span class="info-box-number">0<small></small></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="#"><span class="info-box-icon bg-red"><i class="fa ion-wrench"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Обращения</span>
              <span class="info-box-number">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="#"><span class="info-box-icon bg-green"><i class="ion ion-pie-graph"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Опросы</span>
              <span class="info-box-number">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <div class="row">
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="#"><span class="info-box-icon bg-yellow"><i class="ion ion-podium"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Голосования</span>
              <span class="info-box-number">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <a href="#"><span class="info-box-icon bg-blue"><i class="fa fa-info"></i></span></a>

            <div class="info-box-content">
              <span class="info-box-text">Объявления</span>
              <span class="info-box-number">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
  <!-- Main row -->
  <div class="row">
    <!-- Left col -->
    <div class="col-md-6">
      <!-- MAP & BOX PANE -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Показания приборов учёта</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <? if ($firstDevice) { ?>
                <?
                if ($firstDevice->source == 'manual') {
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
                    ':device_id' => $firstDevice->devices_id,
                  ]
                );
                /*                        if ($firstDevice->source == 'manual') {
                                            $sql = "
                select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)
                from obj_devices_data_view tt
                    left join obj_devices_manual odm on tt.device_id = odm.devices_id
                where tt.device_id = :device_id
                 and tt.data_updated >= now() - interval '120 day'
                 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text)";
                                        } else {
                                            $sql = "
                select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)
                from obj_devices_data_view tt
                    left join obj_devices_manual odm on tt.device_id = odm.devices_id
                where tt.device_id = :device_id
                 and tt.data_updated >= now() - interval '30 day'
                 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text)";
                                        }
                                        $seriesNames = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
                                          $sql
                                        )->queryColumn(
                                          array(
                                            ':device_id' => $firstDevice->devices_id,
                                          )
                                        );
                                        */
                $seriesNames = [
                  ['Все тарифы', 'Общий тариф'],
                  ['Тариф "дневной"', 'День-ночь'],
                  ['Тариф "ночной"', 'День-ночь'],
                ];
                if ($firstDevice->source == 'manual') {
                    $sql = "
select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)   as device_id,
to_char(max(tt.data_updated), 'TMMon, YYYY') AS \"date\", 
round(coalesce(avg(tt.delta_tariff1),0)::numeric,3) as tariff1,
round(coalesce(avg(tt.delta_tariff2),0)::numeric,3) as tariff2,
round(coalesce(avg(tt.delta_tariff3),0)::numeric,3) as tariff3       
from obj_devices_data_view tt
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.device_id = :device_id
and tt.data_updated >= now() - interval '120 day' 
 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text), to_char(tt.data_updated, 'YYYYMM')
order by to_char(tt.data_updated, 'YYYYMM') asc ";
                } else {
                    $sql = "
select tt.source ||'/'|| coalesce(odm.name::text, tt.device_id::text)   as device_id,
to_char(max(tt.data_updated), 'TMDy, DD TMMon, YYYY') AS \"date\", 
round(coalesce(avg(tt.delta_tariff1),0)::numeric,3) as tariff1,
round(coalesce(avg(tt.delta_tariff2),0)::numeric,3) as tariff2,
round(coalesce(avg(tt.delta_tariff3),0)::numeric,3) as tariff3       
from obj_devices_data_view tt    
    left join obj_devices_manual odm on tt.device_id = odm.devices_id
where tt.device_id = :device_id
 and tt.data_updated >= now() - interval '30 day' 
 group by tt.source, tt.device_id, coalesce(odm.name::text, tt.device_id::text), tt.data_updated
order by tt.data_updated asc ";
                }
                $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))->createCommand(
                  $sql
                )->queryAll(
                  true,
                  [
                    ':device_id' => $firstDevice->devices_id,
                  ]
                );
                $series = [];
                if (count($XValues)) {
                    foreach ($seriesNames as $t => $seriesName) {
                        $serie = [
                          'name'  => $seriesName[0],
                          'stack' => $seriesName[1],
                          'data'  => array_fill(0, count($XValues), 0),
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
                          'id' => 'user-' . $model->uid . '-device-' . $firstDevice->devices_id . '-chart',
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
                          'xAxis'       => [
                            'categories'        => $XValues,
                            'tickmarkPlacement' => 'on',
                            'title'             => [
                              'enabled' => false,
                            ],
                          ],
                          'yAxis'       => [
                            'min'   => 0,
                            'title' => ['text' => 'kWh'],
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
        <!-- /.box-body -->
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-6">
      <!-- Info Boxes Style 2 -->
      <div class="box box-default">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Расположение участка</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <? if (isset($firstLand) && $firstLand->land_geo_longitude) { ?>
              <div class="YandexMap" id="dsYandexMap-land-firstland-<?= $firstLand->lands_id ?>">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=<?= $firstLand->land_geo_longitude ?>%2C<?= $firstLand->land_geo_latitude ?>&z=18"
                    width="100%" height="396" frameborder="0" allowfullscreen="false"
                    style="position:relative; pointer-events: none;"
                ></iframe>
              </div>
              <script>
                  $('#dsYandexMap-land-firstland-<?=$firstLand->lands_id?> > iframe').on('load', function () {
// создаём элемент <div>, который будем перемещать вместе с указателем мыши пользователя
                      $('.YandexMap').parent().find('#dsYandexMap-land-firstland-<?=$firstLand->lands_id?>').each(
                          function () {
                              fixYandexMapScroll(this);
                          });
                  });
              </script>
            <? } else { ?>
              <p class="text-center">
                <strong>Координаты участка не определены</strong>
              </p>
            <? } ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default" id="box-for-user-payments-<?= $model->uid ?>">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Платежи</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              <div class="btn-group" role="group">
                  <?
                  $userId = $model->uid;
                  $this->widget(
                    'application.modules.' .
                    Yii::app()->controller->module->id .
                    '.components.widgets.NewInternalPaymentBlock',
                    [
                      'id'                    => false,
                      'buttonType'            => 'default',
                      'buttonIcon'            => 'fa fa-cc-visa',
                      'buttonHtmlOptions'     => [],
                      'yiiGridViewIdToUpdate' => "#payment-grid-{$userId},#profile-bill-payments-grid-bill-payments-all-{$userId},#user-finances-details-{$userId}",
                      'yiiListViewIdToUpdate' => 'empty',
                      'model'                 => $model,
                      'uid'                   => false, //$userId
                    ]
                  );
                  ?>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a
                        href="#user-finances-structure-<?= ($model->uid ? $model->uid : 'all') ?>"
                        data-toggle="tab"><?= Yii::t(
                            'main',
                            'Структура платежей'
                          ) ?></a></li>
                  <li><a href="#user-finances-orders-<?= ($model->uid ? $model->uid : 'all') ?>"
                         data-toggle="tab"><?= Yii::t('main', 'Платежи по счетам') ?></a>
                  </li>
                  <li><a href="#user-finances-details-<?= ($model->uid ? $model->uid : 'all') ?>"
                         data-toggle="tab"><?= Yii::t(
                            'main',
                            'Детали платежей'
                          ) ?></a></li>
                </ul>
                <div class="tab-content">
                  <div class="active tab-pane" id="user-finances-structure-<?= $model->uid ?>">
                    <!-- ==================  Платежи ==================== -->
                      <?
                      $payments = new Payment('search');
                      $payments->uid = $model->uid;
                      $this->widget(
                        'booster.widgets.TbGridView',
                        [
                          'id'              => 'payment-grid-' . ($model->uid ? $model->uid : 'all'),
                          'fixedHeader'     => true,
                          'headerOffset'    => 0,
                          'dataProvider'    => $payments->search(null, 50),
                            //'filter'    => $model->payments
                          'type'            => 'striped bordered condensed',
                          'template'        => '{summary}{items}{pager}',
                          'responsiveTable' => true,
                          'columns'         => [
                            'id',
                            [
                              'name'  => 'sum',
                              'value' => function ($data) {
                                  return sprintf('%01.2f', $data->sum);
                              },
                            ],
                            'description',
                            [
                              'name'   => 'status',
                              'filter' => [
                                1 => Yii::t('main', 'Зачисление или возврат средств') . '(1)',
                                2 => Yii::t('main', 'Снятие средств') . '(2)',
                                3 => Yii::t('main', 'Ожидание зачисления средств') . '(3)',
                                4 => Yii::t('main', 'Отмена ожидания зачисления средств') . '(4)',
                                5 => Yii::t('main', 'Отправка внутреннего перевода средств') . '(5)',
                                6 => Yii::t('main', 'Получение внутреннего перевода средств') . '(6)',
                              ],
                              'value'  => function ($data) {
                                  return $data->status_name . ' (' . $data->status . ')';
                              },
                            ],
                            [
                              'type'  => 'raw',
                              'name'  => 'date',
                              'value' => function ($data) {
                                  return Utils::pgDateToStr($data->date);
                              },
                            ],
                            [
                              'type'  => 'raw',
                              'name'  => 'fullname',
                              'value' => function ($data) {
                                  return Users::getUpdateLink($data->uid);
                              },
                            ],
                            [
                              'type'  => 'raw',
                              'name'  => 'phone',
                              'value' => function ($data) {
                                  return Utils::phonePretty($data->phone, true);
                              },
                            ],
                            [
                              'type'  => 'raw',
                              'name'  => 'manager_name',
                              'value' => function ($data) {
                                  return Utils::fullNameWithInitials($data->manager_name);
                              },
                            ],
                          ],
                        ]
                      );
                      ?>
                  </div>
                  <div class="tab-pane"
                       id="user-finances-orders-<?= ($model->uid ? $model->uid : 'all') ?>">
                      <? $this->widget(
                        'application.modules.' .
                        Yii::app()->controller->module->id .
                        '.components.widgets.BillPaymentsBlock',
                        [
                          'billId'   => false,
                          'userId'   => ($model->uid ? $model->uid : null),
                          'pageSize' => 50,
                        ]
                      );
                      ?>
                  </div>
                  <div class="tab-pane"
                       id="user-finances-details-<?= ($model->uid ? $model->uid : 'all') ?>">
                      <?
                      $this->widget(
                        'booster.widgets.TbGridView',
                        [
                          'id'              => 'user-finances-grid-' . ($model->uid ? $model->uid : 'all'),
                          'dataProvider'    => Users::financesDataProvider(
                            ($model->uid ? $model->uid : null),
                            100
                          ),
//      'filter'       => $model,
                          'fixedHeader'     => true,
                          'headerOffset'    => 0,
                          'type'            => 'striped bordered condensed',
                          'template'        => '{summary}{items}{pager}',
                          'responsiveTable' => true,
                          'columns'         => [
                            [
                              'name' => 'id',
                              'type' => 'raw',
                            ],
                            [
                              'name'        => 'formula',
                              'header'      => Yii::t('main', 'Проводка'),
                              'type'        => 'raw',
                              'htmlOptions' => ['style' => 'width:170px;'],
                            ],
                            [
                              'name'   => 'summ',
                              'header' => Yii::t('main', 'Сумма'),
                              'type'   => 'raw',
                            ],
                            [
                              'name'   => 'total',
                              'header' => Yii::t('main', 'Баланс'),
                              'type'   => 'raw',
                            ],
                            [
                              'name'   => 'date',
                              'header' => Yii::t('main', 'Дата'),
                              'type'   => 'raw',
                            ],
                            [
                              'name'   => 'manager_name',
                              'header' => Yii::t('main', 'Инициатор'),
                              'type'   => 'raw',
                              'value'  => function ($data) {
                                  return Utils::fullNameWithInitials($data['manager_name']);
                              },
                            ],
                            [
                              'name'        => 'comment',
                              'header'      => Yii::t('main', 'Описание операции'),
                              'type'        => 'raw',
                              'value'       => function ($data) {
                                  $result = $data['comment'];
                                  if ($data['type'] == '+') {
                                      $result = $result . ' (' . Yii::t('main', 'счёт') . ')';
                                  }
                                  return $result;
                              },
                              'htmlOptions' => ['style' => 'width:250px;'],
                            ],
                              /*                        array(
                                                        'name' => 'uid',
                                                        'type' => 'raw',
                                                        ),
                              */
                            [
                              'name'   => 'oid',
                              'header' => Yii::t('main', 'Заказ'),
                              'type'   => 'raw',
                            ],
                          ],
                        ]
                      );
                      ?>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="box box-default" id="box-for-user-data-<?= $model->uid ?>">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Данные пользователя</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
            </button>
          </div>
        </div>
          <?php
          /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'users-profile-update-form-' . $model->uid,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["users/update"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",
                  /* Disable normal form submit */
                  //'onkeypress'=>" if(event.keyCode == 13){ update_users (); } " /* Do ajax call when user presses enter key */
              ],
            ]
          ); ?>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo $form->errorSummary($model, 'Необходимо исправить следующие проблемы:'); ?>
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <?php echo $form->uneditableRow(
                  $model,
                  'uid',
                  ['id' => 'Users_uid_profile_update_' . $model->uid]
                ); ?>
                <?php $model->created = Utils::pgDateToStr($model->created);
                echo $form->uneditableRow(
                  $model,
                  'created',
                  ['id' => 'Users_created_profile_update_' . $model->uid]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'fullname',
                  ['id' => 'Users_fullname_profile_update_' . $model->uid]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'new_password',
                  ['id' => 'Users_new_password_profile_update_' . $model->uid]
                ); ?>
                <?php
                $model->new_email = $model->email;
                echo $form->textFieldRow(
                  $model,
                  'new_email',
                  [
                    'id'             => 'Users_new_email_profile_update_' . $model->uid,
                    'data-inputmask' => "'mask': /^\S*@?\S*$/",
                    'data-mask'      => null,
                  ]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'phone',
                  [
                    'id'             => 'Users_phone_profile_update_' . $model->uid,
                    'data-inputmask' => "'mask': '89999999999'",
                    'data-mask'      => null,
                  ]
                ); ?>
                <?php echo $form->textAreaRow(
                  $model,
                  'contacts',
                  ['id' => 'Users_contacts_profile_update_' . $model->uid]
                ); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <?php echo $form->textAreaRow(
                  $model,
                  'comments',
                  ['id' => 'Users_comments_profile_update_' . $model->uid]
                ); ?>
                <? // select2 test ?>
              <div class="form-group<?= ($model->hasErrors('lands') ? ' has-error' : '') ?>">
                <label class="col-sm-3 control-label"
                       for="Users_lands_profile_update_<?= $model->uid ?>">Участки</label>
                <div class="col-sm-9">
                  <select id="Users_lands_profile_update_<?= $model->uid ?>"
                          class="form-control select2 select2-hidden-accessible"
                          multiple="multiple" data-placeholder="Клик для выбора участков"
                    <?= (Yii::app()->user->notInRole(
                      ['superAdmin', 'topManager']
                    ) ? 'disabled="disabled"' : '') ?>
                          name="Users[lands][]" style="width: 100%;"
                          aria-hidden="true">
                      <?
                      $landsList = Lands::getList();
                      $landsOfUser = Lands::getList($model->uid);
                      if (!is_array($landsOfUser)) {
                          $landsOfUser = [];
                      }
                      if ($landsList && is_array($landsList)) {
                          foreach ($landsList as $land) {
                              //lands_id, land_group, land_number, users
                              if (in_array($land['lands_id'], $landsOfUser)) {
                                  $selected = ' selected="selected"';
                              } else {
                                  $selected = '';
                              }
                              ?>
                            <option title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>"
                                    value="<?= $land['lands_id'] ?>"<?= $selected ?>>
                                <?= addslashes($land['land_group'] . '/№' . $land['land_number']) ?>
                            </option>
                          <? }
                      } ?>
                  </select>
                </div>
              </div>
                <? if (Yii::app()->user->notInRole(['superAdmin', 'topManager'])) {
                    $htmlOptions = ['disabled' => 'disabled', 'readonly' => 'readonly'];
                } else {
                    $htmlOptions = [];
                }
                $htmlOptions['id'] = 'Users_status_profile_update_' . $model->uid;
                echo $form->dropDownListRow(
                  $model,
                  'status',
                  [
                    'widgetOptions' => [
                      'data'        => [
                        '0'  => Yii::t('main', 'Не активирован'),
                        '1'  => Yii::t('main', 'Активирован'),
                        '-1' => Yii::t('main', 'Заблокирован'),
                      ],
                      'htmlOptions' => $htmlOptions,
                    ],
                  ]
                ); ?>
                <?
                $htmlOptions['id'] = 'Users_role_profile_update_' . $model->uid;
                echo $form->dropDownListRow(
                  $model,
                  'role',
                  [
                    'widgetOptions' => [
                      'data'        => AccessRights::getRoles(),
                      'htmlOptions' => $htmlOptions,
                    ],
                  ]
                ); ?>
                <?php
                $htmlOptions['id'] = 'Users_default_manager_profile_update_' . $model->uid;
                $allowedManagers = Users::getAllowedManagersForUser(null, null, null);
                echo $form->dropDownListRow(
                  $model,
                  'default_manager',
                  [
                    'widgetOptions' => [
                      'data'        => $allowedManagers,
                      'htmlOptions' => $htmlOptions,
                    ],
                  ]
                );

                ?>
                <?php echo $form->checkboxRow(
                  $model,
                  'checked',
                  ['id' => 'Users_status_profile_update_' . $model->uid]
                ); ?>
            </div>
          </div>
        </div>
        <div class="box-footer">
            <?php
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType' => 'reset',
                'type'       => 'default',
                  //'size'       => 'mini',
                'icon'       => 'fa fa-rotate-left',
                'label'      => Yii::t('main', 'Сброс'),
                  //'htmlOptions' => array('class' => 'pull-right'),
              ]
            ); ?>
            <?php
            $onClickUrl = Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/users/update');
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'type'        => 'default',
                  //'size'        => 'mini',
                'icon'        => 'fa fa-check',
                'label'       => Yii::t('main', 'Сохранить'),
                'htmlOptions' => [
                  'class'   => 'pull-right',
                  'onclick' =>
                  /** @lang JavaScript */ "(function () {
        var data = $('#users-profile-update-form-{$model->uid}').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '{$onClickUrl}',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    //$('#users-update-modal').modal('hide');
                    //$('#users-update-modal').data('modal', null);
                    //$.fn.yiiGridView.update('users-grid', {});
                    reloadSelectedTab(event);
                    alert(data);                  
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data),'Error',true);

            },

            dataType: 'html'
        });})();",
                ],
              ]
            );
            ?>
        </div>
          <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="box box-default" id="box-for-user-lands-<?= $model->uid ?>">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Участки</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?
            $this->widget(
              'booster.widgets.TbListView',
              [
                'id'            => 'user-lands-list-' . $model->uid,
                'dataProvider'  => $landsDataProvider,
                'itemView'      => 'application.modules.' .
                  Yii::app()->controller->module->id .
                  '.views.users.landListView',
                'itemsCssClass' => 'lands-list',
                  /* 'enableSorting'      => true,
                  'sortableAttributes' => array(
                    '#'          => '#',
                    'miner_type' => Yii::t('main', 'Тип'),
                    'uptimeSec'  => 'Uptime',
                    'int_ip'     => 'IP',
                    'gpus_count' => Yii::t('main', 'Кол-во PU'),
                    'hashRate'   => Yii::t('main', 'Hash rate'),
                  ),
                  'sorterHeader'       => '',
                    //'template'      => '{summary}{pager}{items}{pager}',
                  'template'           => '{sorter}{items}',
                  */
              ]
            );
            ?>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="box box-default" id="box-for-user-devices-<?= $model->uid ?>">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Приборы</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                  class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <?
            $this->widget(
              'booster.widgets.TbListView',
              [
                'id'            => 'user-devices-list-' . $model->uid,
                'dataProvider'  => $devicesDataProvider,
                'itemView'      => 'application.modules.' .
                  Yii::app()->controller->module->id .
                  '.views.users.deviceListView',
                'itemsCssClass' => 'devices-list',
                  /* 'enableSorting'      => true,
                  'sortableAttributes' => array(
                    '#'          => '#',
                    'miner_type' => Yii::t('main', 'Тип'),
                    'uptimeSec'  => 'Uptime',
                    'int_ip'     => 'IP',
                    'gpus_count' => Yii::t('main', 'Кол-во PU'),
                    'hashRate'   => Yii::t('main', 'Hash rate'),
                  ),
                  'sorterHeader'       => '',
                    //'template'      => '{summary}{pager}{items}{pager}',
                  'template'           => '{sorter}{items}',
                  */
              ]
            );
            ?>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<script>
    $('#Users_lands_profile_update_<?=$model->uid?>').select2(
        {
            allowClear: true,
            placeholder: 'Клик для выбора участков',
            templateSelection: function (state) {
                if (!state.id) {
                    return state.text.trim(); // optgroup
                } else {
                    return state.text.trim() +
                        '&nbsp;<a href="/<?=Yii::app(
                        )->controller->module->id?>/lands/view/id/' + state.id + '" title="Просмотр профиля участка" ' +
                        'onclick="getContent(this,\'' + state.text.trim() +
                        '\',false);return false;"><i class="fa fa-external-link fa-fw text-white"></i></a>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }
    );
</script>
<? //****************************************************************************************************************** ?>
<? //- Internal message ----------------------------------------------?>
<div class="modal fade" id="new-internal-message-to-<?= $model->uid ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Сообщение пользователю') . ' ' . $model->email ?></h4>
      </div>
      <div class="modal-body">
        <form id="new-internal-message-form-to-<?= $model->uid ?>" role="form">
          <input type="hidden" name="message[uid]" value="<?= $model->uid ?>"/>
          <div class="form-group">
            <label for="message-<?= $model->uid ?>"><?= Yii::t('main', 'Текст сообщения') ?></label>
            <textarea class="form-control"
                      placeholder="<?= Yii::t('main', 'Введите текст сообщения для отправки') ?>"
                      name="message[message]" id="message-<?= $model->uid ?>"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-right" onclick="
            $('#new-internal-message-to-<?= $model->uid ?>').modal('hide');
            var msg = $('#new-internal-message-form-to-<?= $model->uid ?>').serialize();
            $.post('/<?= Yii::app()->controller->module->id ?>/message/sendNote',msg, function(){
            $('#message-<?= $model->uid ?>').val('');
            },'text');
            return false;"><?= Yii::t('main', 'Отправить') ?></button>
        &nbsp;&nbsp;
        <button type="button" class="btn btn-default"
                onclick="$('#new-internal-message-to-<?= $model->uid ?>').modal('hide');
                    $('#message-<?= $model->uid ?>').val('');
                    return false;"><?= Yii::t('main', 'Отмена') ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<? //- Internal email ----------------------------------------------?>
<div class="modal fade" id="new-internal-email-to-<?= $model->uid ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'EMail пользователю') . ' ' . $model->email ?></h4>
      </div>
      <div class="modal-body">
        <form id="new-internal-email-form-to-<?= $model->uid ?>" role="form">
          <input type="hidden" name="message[uid]" value="<?= $model->uid ?>"/>
          <div class="form-group">
            <label for="email-<?= $model->uid ?>"><?= Yii::t('main', 'Текст сообщения') ?></label>
            <textarea class="form-control"
                      placeholder="<?= Yii::t('main', 'Введите текст сообщения для отправки') ?>"
                      name="message[message]" id="email-<?= $model->uid ?>"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-right" onclick="
            $('#new-internal-email-to-<?= $model->uid ?>').modal('hide');
            var msg = $('#new-internal-email-form-to-<?= $model->uid ?>').serialize();
            $.post('/<?= Yii::app()->controller->module->id ?>/message/sendMail',msg, function(){
            $('#message-<?= $model->uid ?>').val('');
            },'text');
            return false;"><?= Yii::t('main', 'Отправить') ?></button>
        &nbsp;&nbsp;
        <button type="button" class="btn btn-default"
                onclick="$('#new-internal-email-to-<?= $model->uid ?>').modal('hide');
                    $('#email-<?= $model->uid ?>').val('');
                    return false;"><?= Yii::t('main', 'Отмена') ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<? /*
<script type="text/javascript" src="<?= Yii::app(
)->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard.js' : 'dashboard.js' ?>"></script>
<script type="text/javascript" src="<?= Yii::app(
)->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard2.js' : 'dashboard2.js' ?>"></script>
*/ ?>
