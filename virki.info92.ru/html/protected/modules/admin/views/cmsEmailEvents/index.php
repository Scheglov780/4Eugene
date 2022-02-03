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
      <?= Yii::t('main', 'Почтовые события'); ?>
    <small><?= Yii::t('main', 'Редактирование почтовых событий') ?></small>
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
                'linkOptions' => ['onclick' => 'renderCreateForm_cmsEmailEvents ()'],
              ],
                //array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
//		array('label'=>Yii::t('main','Поиск'), 'icon'=>'fa fa-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
//		array('label'=>Yii::t('main','PDF'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
//		array('label'=>Yii::t('main','Excel'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
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
          <h3 class="box-title"><?= Yii::t('main', 'Список событий') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body pre-x-scrollable"> <? /* pre-x-scrollable */ ?>

            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'cms-email-events-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->search(),
                'filter'          => $model,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'name'   => 'id',
                    'filter' => false,
                    'type'   => 'raw',
                  ],
//		'mailevent_name',
                  [
                    'type'   => 'raw',
                    'filter' => false,
                    'name'   => 'template',
                      //'htmlOptions' => array('width' => '240px'),
                    'value'  => function ($data) {
                        $res = preg_match('/<\?\s*\/\/(.*?)\?>/is', $data->template, $matches);
                        if ($res) {
                            echo Yii::t('main', $matches[1]);
                        } else {
                            echo $data->template;
                        }
                    },
                  ],
                  'layout',
                  'class',
                  'action',
                  'condition',
                  'recipients',
                  [
                    'header' => Yii::t('main', 'Повтор'),
                    'name'   => 'regular',
                  ],
                  [
                    'name'           => 'enabled',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->enabled==1',
                    'header'         => Yii::t('main', 'Вкл.'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  [
                    'name'   => 'id',
                    'header' => Yii::t('main', 'Отправлено за 48 часов'),
                    'value'  => function ($data) {
                        $res = CmsEmailEvents::getEventStatistic($data->id);
                        if ($res) {
                            if (isset($res['cnt']) && $res['cnt']) {
                                return $res['cnt'] . ' / ' . $res['last_processed'];
                            } else {
                                return '-';
                            }
                        } else {
                            return '-';
                        }
                    },
                  ],
                  [

                    'type'  => 'raw',
                    'value' => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\'renderUpdateForm_cmsEmailEvents (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      <a href=\'javascript:void(0);\' onclick=\'emailEventTest(".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-check\'></i></a>
		      <a href=\'javascript:void(0);\' onclick=\'delete_record_cmsEmailEvents (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
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
    function delete_record_cmsEmailEvents(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsEmailEvents/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('cms-email-events-grid', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function emailEventTest(id) {
        jQuery.ajax({
            type: 'GET',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsEmailEvents/testEvent?id="
            )?>' + id,
            success: function (data) {
                dsAlert('<?=Yii::t(
                  'main',
                  'Тестовое событие инициировано - проверьте свой почтовый ящик или SMS'
                )?>', '', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }
</script>

