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
      <?= Yii::t('main', 'Платежные системы') ?>
    <small><?= Yii::t('main', 'Настройка систем приёма платежей') ?></small>
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
                //array('label'=>Yii::t('main','Создать'), 'icon'=>'fa fa-plus', 'url'=>'javascript:void(0);','linkOptions'=>array('onclick'=>'renderCreateForm_paysystems ()')),
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
          <h3 class="box-title"><?= Yii::t('main', 'Список систем приема платежей') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>

            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'pay-systems-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->search(),
                'type'            => 'striped bordered condensed',
                'template'        => '{summary}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  'id',
                  [
                    'name'           => 'enabled',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->enabled==1',
                    'header'         => Yii::t('main', 'Вкл.'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  'logo_img',
                  'int_name',
                  'name_ru',
                  'name_en',
                    /*
                    'descr_ru',
                    'descr_en',
                    'parameters',
                    'form_ru',
                    'form_en',
                    */
                  [
                    'type'  => 'raw',
                    'value' => 'CHtml::link(Yii::t("main","конфигурация"), array("paysystems/config", "id"=>$data->id), array("onclick"=>"getContent(this,\"$data->name_en\",false);return false;","title"=>Yii::t("main","Конфигурирование платёжной системы")))',
                  ],
                  [

                    'type'  => 'raw',
                    'value' => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\'renderUpdateForm_paysystems (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      <a href=\'javascript:void(0);\' onclick=\'delete_record_paysystems (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
		      </div>
		     "',
                      //'htmlOptions' => array('style' => 'width:150px;')
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
    function delete_record_paysystems(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/paysystems/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('pay-systems-grid', {});

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

