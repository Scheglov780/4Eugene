<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="dashboard.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var Bills $model */
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Счета') ?>
    <small><?= Yii::t('main', 'выставленные к оплате, по статусам...') ?></small>
      <?= Utils::getHelp('index', true) ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-info">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse"><?= Yii::t('main', 'Список счетов по статусам') ?></h3>
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
              'booster.widgets.TbGridView',
              [
                'id'              => 'billsByStatuses-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $billsByStatusesDataProvider,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        if (!in_array(
                          $data['value'],
                          [
                            'ALL',
                            'CANCELED_BY_SERVICE',
                            'PAUSED',
                            'EXPIRED',
                            'ACCEPTED',
                          ]
                        )
                        ) { ?>
                          <div class="btn-group" role="group">
                          <a href="#dashboard_<?= $data['value'] ?>"
                             title="Просмотр"
                             class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                        <? }
                        if ($data['value'] == 'ALL') {
                            $typePath = '';
                        } else {
                            $typePath = '/type/' . $data['value'];
                        }
                        ?>
                      <a href="/<?= Yii::app()->controller->module->id ?>/bills/index<?= $typePath ?>"
                         title="В отдельной вкладке"
                         onclick="getContent(this,'<?= Yii::t('main', 'Счета') ?>: <?= Yii::t(
                           'main',
                           $data['name']
                         ) ?>',false); return false;"
                         class="btn btn-default btn-sm"><i class="fa fa-clone"></i></a>
                      </div>
                        <?
                    },
                      /*
                            array(
                              'CANCELED_BY_CUSTOMER',
                              'CANCELED_BY_SERVICE',
                              'PAUSED',
                              'SEND_TO_CUSTOMER',
                              'RECEIVED_BY_CUSTOMER',
                            )
                       */
                  ],
                  [
                    'header' => Yii::t('main', 'Статус счёта'),
                    'name'   => 'name',
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        if ($data['value'] == 'ALL') {
                            $typePath = '';
                        } else {
                            $typePath = '/type/' . $data['value'];
                        }
                        echo '<a href="/' . Yii::app()->controller->module->id . '/bills/index' . $typePath .
                          '" onclick="getContent(this,\'' . Yii::t('main', 'Счета') . ': ' . Yii::t(
                            'main',
                            Yii::t('main', $data['name'])
                          ) . '\',false); return false;" title="В отдельной вкладке">'
                          . (($data['manual'] == 1) ? '<b>' : '') . Yii::t(
                            'main',
                            $data['name']
                          ) . (($data['manual'] == 1) ? '</b>' : '') . '</a>';
                    },
                  ],
                  [
                    'header' => Yii::t('main', 'Количество'),
                    'name'   => 'count',
                  ],
                  [
                    'header' => Yii::t('main', 'На сумму'),
                    'name'   => 'totalsum',
                  ],
                  [
                    'header' => Yii::t('main', 'Оплачено'),
                    'name'   => 'totalpayed',
                  ],
                  [
                    'header' => Yii::t('main', 'Не оплачено'),
                    'name'   => 'totalnopayed',
                  ],
                  [
                    'header' => Yii::t('main', 'Изменено'),
                    'type'   => 'raw',
                    'value'  =>
                      function ($data, $row) {
                          return Utils::pgDateToStr($data['lastdate']);
                      },
                  ],
                  [
                    'header' => Yii::t('main', 'Описание'),
                    'name'   => 'descr',
                  ],
                ],
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
    <? foreach ($billsByStatusesArray as $billsByStatuses) {
//  if ($billsByStatuses['count']>0) {
        if (!in_array(
          $billsByStatuses['value'],
          [
            'ALL',
            'CANCELED_BY_SERVICE',
            'PAUSED',
            'EXPIRED',
            'ACCEPTED',
          ]
        )
        ) {
            ?>
          <div class="row">
            <div class="col-md-12">
                <?
                $idPrefix = 'dashboard_';
                $type = $billsByStatuses['value'];
                $this->widget(
                  'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.BillsListBlock',
                  [
                    'type'     => $type,
                    'name'     => $billsByStatuses['name'],
                    'filter'   => false,
                    'idPrefix' => $idPrefix,
                    'pageSize' => 25,
                    'editable' => true,
                  ]
                ); ?>
                <?
                $this->renderPartial("_ajax_update", ['type' => $idPrefix . ($type ? $type : 'all'),]);
                //$this->renderPartial("_ajax_create_form", array("model" => $model,'type' => ($type ? $type : 'all'),));
                ?>
              <script type="text/javascript">
                  function delete_record_bills_<?=$idPrefix . ($type ? $type : 'all')?>(id) {

                      if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
                          return;
                      var data = 'id=' + id;


                      jQuery.ajax({
                          type: 'POST',
                          url: '<?php echo Yii::app()->createAbsoluteUrl(
                            Yii::app()->controller->module->id . "/bills/delete"
                          ); ?>',
                          data: data,
                          success: function (data) {
                              if (data == 'true') {
                                  $.fn.yiiGridView.update('bills-grid-<?=$idPrefix . ($type ? $type : 'all')?>', {});
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
            </div>
          </div>
            <?
        }
//  }
    }
    ?>
</section>
<!-- /.content -->
<script>
    $('#billsByStatuses-grid').find('a[href^=\'#dashboard\']').on('click.billsByStatusesGrid',
        function (event) {
            var $href = $(this).attr('href');
            if (typeof $href !== 'undefined') {
                var $anchor = $($href).offset();
                if (typeof $anchor !== 'undefined') {
                    window.scrollTo($anchor.left, $anchor.top);
                    //$('body').animate({scrollTop: $anchor.top});
                }
            }
            return false;
        });
</script>