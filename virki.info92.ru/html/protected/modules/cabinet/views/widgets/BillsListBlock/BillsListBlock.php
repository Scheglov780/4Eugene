<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsListBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="row">
  <div class="col-xs-12">
    <div class="box box-<?= $color ?>" id="<?= $idPrefix . $type ?>">
      <div class="box-header with-border">
        <h3 class="box-title" data-widget="collapse"><?= Yii::t(
              'main',
              $name
            ) ?></h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.box-header -->
      <div class="box-body"> <?php
          $columns = [
            [
              'type'   => 'raw',
              'name'   => 'id',
              'header' => 'Номер счёта',
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  return $data->id;
              },
            ],
            [
              'type'   => 'raw',
              'name'   => 'code',
              'header' => 'ID счёта',
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  return $data->code;
              },
            ],
            [
              'type'   => 'raw',
              'name'   => 'date',
              'header' => 'Дата',
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  return Utils::pgDateToStr($data->date, 'Y-m-d');
              },
            ],
            [
              'type'   => 'raw',
              'name'   => 'lands_id',
              'header' => 'Участок',
              'filter' => Lands::getListForFilter(),
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  return $data->land_name;
              },
            ],
            [
              'type'   => 'raw',
              'name'   => 'uid',
              'header' => 'Плательщик',
              'filter' => Users::getListData(),
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  return $data->user_name;
              },
            ],
            [
              'type'   => 'raw',
              'name'   => 'tariff_id',
              'header' => 'Назначение платежа',
              'filter' => Tariffs::getList(),
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  return $data->tariff_name;
              },
            ],
            [
              'type'        => 'raw',
              'name'        => 'summ',
              'header'      => 'Сумма',
              'htmlOptions' => ['style' => 'text-align: right;'],
              'value'       => function ($data, $row) {
                  /** @var Bills $data */
                  if (is_null($data->manual_summ)) {
                      return $data->summ;
                  } else {
                      return $data->manual_summ;
                  }
              },
            ],
            [
              'type'        => 'raw',
              'name'        => 'paid_summ',
              'header'      => 'Оплачено',
              'htmlOptions' => ['style' => 'text-align: right;'],
              'value'       => function ($data, $row) {
                  /** @var Bills $data */
                  return $data->paid_summ;
              },
            ],
            [
              'type'   => 'raw',
              'name'   => 'status',
              'header' => 'Статус',
              'filter' => BillsStatuses::getStatusListForFilter(),
              'value'  => function ($data, $row) {
                  /** @var Bills $data */
                  if ($data->ext_status_name) {
                      $extstatus = " (" . $data->ext_status_name . ")";
                  } else {
                      $extstatus = "";
                  }
                  return Yii::t('main', $data->status_name) . Yii::t('main', $extstatus);
              },
            ],
            [
              'name'           => 'frozen',
              'class'          => 'CCheckBoxColumn',
              'checked'        => '$data->frozen==1',
              'header'         => 'Заблокирован',
                //'disabled'=>'true',
              'selectableRows' => 0,
            ],
          ];

          $columns[] = [
            'type'  => 'raw',
            'value' => function ($data) use ($idPrefix, $type, $editable) {
                /** @var Bills $data */
                ?>
              <div class="btn-group" role="group">
                <a href='//<?= DSConfig::getVal('site_domain') ?>/blanks/bill?code=<?= $data->code ?>'
                   target="_blank" title="Печать"
                   class='btn btn-default btn-sm'><i class='fa fa-print'></i></a>
                  <? if ($editable) { ?>
                    <a href='javascript:void(0);' title="Редактировать"
                       onclick='renderUpdateForm_bills_<?= $idPrefix . ($type ? $type : 'all') ?> ("<?= $data->id ?>")'
                       class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                    <a href='javascript:void(0);' title="Удалить"
                       onclick='delete_record_bills_<?= $idPrefix . ($type ? $type : 'all') ?> ("<?= $data->id ?>")'
                       class='btn btn-default btn-sm'><i
                          class='fa fa-trash'></i></a>
                  <? } ?>
              </div>
            <? },
              //'htmlOptions' => array('style' => 'width:135px;')
          ];

          $this->widget(
            'booster.widgets.TbGridView',
            [
              'id'              => 'bills-grid-' . $idPrefix . ($type ? $type : 'all'),
              'fixedHeader'     => true,
              'headerOffset'    => 0,
                //'scrollableArea' =>'.pre-scrollable',//
              'dataProvider'    => $dataProvider,
              'filter'          => $filter,
              'type'            => 'striped bordered condensed',
              'template'        => '{summarypager}{items}{pager}',
              'responsiveTable' => true,
              'pager'           => [
                'class' => 'booster.widgets.TbPager',
                'id'    => 'bills-grid-pager-' . $idPrefix . ($type ? $type : 'all'),
              ],
              'columns'         => $columns,
            ]
          );

          //$this->render("_ajax_update",array('type'=>($type ? $type : 'all')));
          //$this->render("_ajax_create_form", array("model" => $model,'type'=>($type ? $type : 'all')));
          ?>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->
