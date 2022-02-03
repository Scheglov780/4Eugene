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
      <?= Yii::t('main', 'Права доступа') ?>
    <small><?= Yii::t('main', 'Настройка разрешений доступа пользователей к страницам, ресурсам, функциям') ?></small>
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
              [
                'label'       => Yii::t('main', 'Создать'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_accessrights ()'],
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
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список разрешений прав доступа') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>

            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'accessrights-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->search(),
                'type'            => 'striped bordered condensed',
                'template'        => '{summary}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  'role',
                  'description',
                  'allow',
                  'deny',
                  [

                    'type'  => 'raw',
                    'value' => function ($data) { ?>
                      <div class="btn-group">
                        <a href='javascript:void(0);' onclick='renderUpdateForm_accessrights ("<?= $data->role ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' onclick='delete_record_accessrights ("<?= $data->role ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
                      </div>
                    <? },
//        'htmlOptions' => array('style' => 'width:150px;')
                  ],

                ],
              ]
            );

            $this->renderPartial("_ajax_update");
            $this->renderPartial("_ajax_create_form", ["model" => $model]);
            //$this->renderPartial("_ajax_view");

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
    function delete_record_accessrights(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/accessrights/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('accessrights-grid', {});

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

 

