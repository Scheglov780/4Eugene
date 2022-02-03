<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Платежи') ?>
    <small><?= Yii::t('main', 'пополнения счёта, оплаты по счетам') ?></small>
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
//		array('label'=>Yii::t('main','Создать'), 'icon'=>'fa fa-plus', 'url'=>'javascript:void(0);','linkOptions'=>array('onclick'=>'renderCreateForm_payments ()')),
                //array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
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
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список платежей') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#index-finances-structure-<?= ($model->uid ? $model->uid : 'all') ?>"
                                    data-toggle="tab"><?= Yii::t(
                        'main',
                        'Структура платежей'
                      ) ?></a></li>
              <li><a href="#index-finances-orders-<?= ($model->uid ? $model->uid : 'all') ?>"
                     data-toggle="tab"><?= Yii::t('main', 'Платежи по счетам') ?></a>
              </li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="index-finances-structure-<?= ($model->uid ? $model->uid : 'all') ?>">
                <!-- ==================  Платежи ==================== -->
                  <?
                  $this->widget(
                    'booster.widgets.TbGridView',
                    [
                      'id'              => 'payment-grid-' . ($model->uid ? $model->uid : 'all'),
                      'fixedHeader'     => true,
                      'headerOffset'    => 0,
                      'dataProvider'    => $model->search(null, 50),
                      'filter'          => $model,
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
                          /*
                          'check_summ',
                          */
                        [

                          'type'  => 'raw',
                          'value' => function ($data) {
                              ?>
                            <div class="btn-group">
                              <a href="javascript:void(0);"
                                 onclick="renderUpdateForm_payments('<?= $data->id ?>')"
                                 class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
                            </div>
                              <?
                              /*		      <a href=\'javascript:void(0);\' onclick=\'delete_record_payments (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
                                                            //'htmlOptions' => array('style' => 'width:70px;')
                              */
                          },
                        ],
                      ],
                    ],
                  );
                  $this->renderPartial("_ajax_update", ['model' => $model]);
                  ?>
              </div>
              <div class="tab-pane" id="index-finances-orders-<?= ($model->uid ? $model->uid : 'all') ?>">
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
            </div>
            <!-- /.tab-content -->
          </div>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row">
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
          <img class="img-responsive pad" src="/images/TZ/008-struktura-plateji.jpg">
        </div>
        <!-- /.box-body -->
      </div>
    </div>
  </div>
</section>
<!-- /.content -->