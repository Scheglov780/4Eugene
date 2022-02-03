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
$this->breadcrumbs = [
  'Log Site Errors',
];
?>

<div class="row-fluid">
  <div class="span8">
    <h1><?= Yii::t('main', 'Ошибки в работе сайта') ?></h1>
  </div>
  <div class="span4">
      <?php
      $this->beginWidget(
        'zii.widgets.CPortlet',
        [
          'htmlOptions' => [
            'class' => '',
          ],
        ]
      );
      $this->widget(
        'booster.widgets.TbMenu',
        [
          'type'  => 'pills',
          'items' => [
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
      $this->endWidget();
      ?>
  </div>
</div>

<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'log-site-errors-grid',
    'fixedHeader'     => true,
    'headerOffset'    => 0,
    'dataProvider'    => $model->search(),
    'type'            => 'striped bordered condensed',
    'template'        => '{summary}{items}{pager}',
    'responsiveTable' => true,
    'columns'         => [
      'id',
      'error_date',
      'error_message',
//		'error_description',
      'error_label',
//		'error_request',
      [

        'type'  => 'raw',
        'value' => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\'renderUpdateForm_errorlog (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      <a href=\'javascript:void(0);\' onclick=\'delete_record_errorlog (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
		      </div>>
		     "',
          //'htmlOptions' => array('style' => 'width:150px;')
      ],

    ],
  ]
);

$this->renderPartial("_ajax_update");
$this->renderPartial("_ajax_create_form", ["model" => $model]);
$this->renderPartial("_ajax_view");

?>

<script type="text/javascript">
    function delete_record_errorlog(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/errorlog/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('log-site-errors-grid', {});

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
    function printDiv_errorlog() {

        window.print();

    }
</script>
 

