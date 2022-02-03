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
/** @var Users $model */
Yii::app()->clientScript->registerScript(
  'search',
  "
$('#users-search-button').click(function(){
    $('#users-search-form').slideToggle('fast');
    return false;
});
$('#users-search-form form').submit(function(){
    $.fn.yiiGridView.update('users-grid', {
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
      <?= Yii::t('main', 'Пользователи') ?>
    <small><?= Yii::t('main', 'Управление пользователями, их уровнем доступа, аккаунтами...') ?></small>
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
                'label'       => Yii::t('main', 'Новый пользователь'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_users ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'users-search-button', 'class' => 'search-button'],
              ],
              [
                'label'       => Yii::t('main', 'Excel'),
                'icon'        => 'fa fa-download',
                'url'         => Yii::app()->controller->createUrl('GenerateExcel'),
                'linkOptions' => ['target' => '_blank'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Список клиентов'),
                'icon'        => 'fa fa-download',
                'url'         => Yii::app()->controller->createUrl(
                  'GenerateMailList',
                  ['criteria' => 'role in (\'landlord\',\'associate\',\'leaseholder\') and status=1']
                ),
                'linkOptions' => ['target' => '_blank'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Список менеджеров'),
                'icon'        => 'fa fa-download',
                'url'         => Yii::app()->controller->createUrl(
                  'GenerateMailList',
                  ['criteria' => 'role ~* \'.*(admin|manager).*\' and status=1']
                ),
                'linkOptions' => ['target' => '_blank'],
                'visible'     => true,
              ],
            ],
          ]
        );
        ?>
      <div class="row">
        <div class="col-md-12">
          <section id="users-search-form" class="search-form" style="display:none">
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
          <h3 class="box-title"><?= Yii::t('main', 'Список пользователей') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'users-grid',
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
                    'filter' => false,
                    'name'   => 'uid',
                    'value'  => function ($data) {
                        /** @var Users $data */
                        return Users::getUpdateLink($data->uid, false, $data, $data->uid);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'fullname',
                    'header' => 'ФИО',
                    'value'  => function ($data) {
                        /** @var Users $data */
                        return Users::getUpdateLink($data->uid, false, $data);
                    },
                  ],
                  [
                    'type'        => 'raw',
                    'name'        => 'phone',
                    'value'       => function ($data) {
                        /** @var Users $data */
                        if ($data->phone) { ?>
                          <a href="tel:<?= $data->phone ?>" title="Позвонить"
                             target="_blank"><?= Utils::phonePretty($data->phone) ?></a>
                        <? }
                    },
                    'htmlOptions' => function ($data, $row) {
                        /** @var Users $data */
                        if (!$data->phone) {
                            return ['style' => 'background-color: rgba(255,0,0,0.07) !important;'];
                        } else {
                            return [];
                        }

                    },
                  ],
                  [
                    'type'        => 'raw',
                    'name'        => 'email',
                    'value'       => function ($data) {
                        /** @var Users $data */
                        ?>
                      <a href="javascript:void(0);" title="Написать Email"
                         onclick="
                             $('#new-internal-email-uid').val('<?= $data->uid ?>');
                             $('#new-internal-email-fullname').text('<?= Utils::fullNameWithInitials(
                           $data->fullname
                         ) ?>');
                             $('#new-internal-email').modal('show');return false;
                             "
                      ><?= $data->email ?></a>
                        <?
                    },
                    'htmlOptions' => function ($data, $row) {
                        /** @var Users $data */
                        /** @var int $row */
                        if (!$data->email) {
                            return ['style' => 'background-color: rgba(255,0,0,0.07) !important;'];
                        } else {
                            return [];
                        }

                    },
                  ],

                [
                  'name'           => 'status',
                  'class'          => 'CCheckBoxColumn',
                  'checked'        => '$data->status==1',
                  'header'         => Yii::t('main', 'Вкл.'),
                    //'disabled'=>'true',
                  'selectableRows' => 0,
                ],
                [
                  'type'  => 'raw',
                  'name'  => 'created',
                  'value' => function ($data) {
                      /** @var Users $data */
                      return Utils::pgDateToStr($data->created);
                  },
                ],
                [
                  'type'   => 'raw',
                  'name'   => 'role',
                  'filter' => AccessRights::getRoles(),
                  'value'  => function ($data, $row) {
                      /** @var Users $data */
                      /** @var int $row */
                      $res = '<span style="color: ' . ((in_array(
                          $data->role,
                          ['associate', 'landlord', 'leaseholder']
                        )) ? 'black' : 'green') . '" title="' . $data->role . '">' . $data->roleDescr . '</span>';
                      return $res;
                  },
                ],
                [
                  'type'   => 'raw',
                  'name'   => 'debtor_status',
                  'filter' => DicCustom::getVals('DEBTOR_STATUS'),
                  'value'  => function ($data) {
                      /** @var Users $data */
                      return $data->debtor_status_name;
                  },
                ],
                [
                  'type'   => 'raw',
                  'filter' => false,
                  'header' => 'Дополнительно',
                  'value'  => function ($data) {
                      /** @var Users $data */
                      $res = ($data->contacts ? $data->contacts : '') .
                        ($data->contacts && $data->comments ? '<br>' : '') .
                        ($data->comments ? $data->comments : '') .
                        '&nbsp;';
                      return $res;
                  },
                ],
                  [
                    'type'   => 'raw',
                    'filter' => false,
                    'name'   => 'lands',
                      // 'header'  => 'Участки',
                    'value'  => function ($data, $row) {
                        /** @var Users $data */
                        $lands = json_decode($data->lands);
                        if ($lands && count($lands)) {
                            foreach ($lands as $land) {
                                /** @var Lands $land */
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
                  'filter' => false,
                  'name'   => 'devices',
                    //'header'  => 'Приборы',
                  'value'  => function ($data, $row) {
                      /** @var Users $data */
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
                    /*
                    array(
                      'name'  => 'userBalance',
                      'value' => function($data) {
                         /** @var Users $data /
                          return Users::getBalance($data->uid);
                       },
                    ),
                    'ordersCNT',
                    'ordersLast',
                    array(
                      'type' => 'raw',
                      'name' => 'ordr_user_stat',
                    ),
                    'paymentsSUM',
                    /*
                      fullname,
                      contacts,
                      comments,
                     */
                  [

                    'type'  => 'raw',
                    'value' => function ($data) {
                        /** @var Users $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_users ("<?= $data->uid ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_users ("<?= $data->uid ?>")'
                           class='btn btn-default btn-sm'><i
                              class='fa fa-trash'></i></a>
                        <a href='javascript:void(0);' title="Сообщение"
                           onclick="
                               $('#new-internal-message-uid').val('<?= $data->uid ?>');
                               $('#new-internal-message-fullname').text('<?= Utils::fullNameWithInitials(
                             $data->fullname
                           ) ?>');
                               $('#new-internal-message').modal('show');return false;
                               " class='btn btn-default btn-sm'><i class='fa fa-envelope'></i></a>
                      </div>
                        <?
                        /*
                       class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Редактировать') ?>">

                         * */
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
<? //- Internal message ----------------------------------------------?>
<div class="modal fade" id="new-internal-message" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Сообщение пользователю') ?>: <span
              id="new-internal-message-fullname"></span></h4>
      </div>
      <div class="modal-body">
        <form id="new-internal-message-form" role="form">
          <input type="hidden" name="message[uid]" id="new-internal-message-uid" value=""/>
          <div class="form-group">
            <label for="message"><?= Yii::t('main', 'Текст сообщения') ?></label>
            <textarea class="form-control"
                      placeholder="<?= Yii::t('main', 'Введите текст сообщения для отправки') ?>"
                      name="message[message]" id="new-internal-message-message"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-right" onclick="
            $('#new-internal-message').modal('hide');
            var msg = $('#new-internal-message-form').serialize();
            $.post('/<?= Yii::app()->controller->module->id ?>/message/sendNote',msg, function(){
            $('#new-internal-message-message').val('');
            $('#new-internal-message-uid').val('');
            $('#new-internal-message[fullname').text('');
            },'text');
            return false;"><?= Yii::t('main', 'Отправить') ?></button>
        &nbsp;&nbsp;
        <button type="button" class="btn btn-default" onclick="$('#new-internal-message').modal('hide');
                        $('#new-internal-message-message').val('');
                        $('#new-internal-message-uid').val('');
                        $('#new-internal-message-fullname').text('');
                        return false;"><?= Yii::t('main', 'Отмена') ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<? //- Internal email ----------------------------------------------?>
<div class="modal fade" id="new-internal-email" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'EMail пользователю') ?>: <span
              id="new-internal-email-fullname"></span></h4>
      </div>
      <div class="modal-body">
        <form id="new-internal-email-form" role="form">
          <input type="hidden" name="message[uid]" id="new-internal-email-uid" value=""/>
          <div class="form-group">
            <label for="new-internal-email-message"><?= Yii::t('main', 'Текст сообщения') ?></label>
            <textarea class="form-control"
                      placeholder="<?= Yii::t('main', 'Введите текст сообщения для отправки') ?>"
                      name="message[message]" id="new-internal-email-message"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary pull-right" onclick="
            $('#new-internal-email').modal('hide');
            var msg = $('#new-internal-email-form').serialize();
            $.post('/<?= Yii::app()->controller->module->id ?>/message/sendMail',msg, function(){
            $('#new-internal-email-message').val('');
            $('#new-internal-email-uid').val('');
            $('#new-internal-email-fullname').text('');
            },'text');
            return false;"><?= Yii::t('main', 'Отправить') ?></button>
        &nbsp;&nbsp;
        <button type="button" class="btn btn-default" onclick="$('#new-internal-email').modal('hide');
                        $('#new-internal-email-message').val('');
                        $('#new-internal-email-uid').val('');
                        $('#new-internal-email-fullname').text('');
                        return false;"><?= Yii::t('main', 'Отмена') ?></button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function delete_record_users(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/users/delete'); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('users-grid', {});
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
    function printDiv_users() {
        window.print();
    }
</script>
