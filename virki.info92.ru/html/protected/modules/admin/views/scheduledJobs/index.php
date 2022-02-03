<?php
$this->breadcrumbs = [
  'Scheduled Jobs',
];
?>

<h1>Scheduled Jobs</h1>
<hr/>

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
      [
        'label'       => Yii::t('main', 'Создать'),
        'icon'        => 'fa fa-plus',
        'url'         => 'javascript:void(0);',
        'linkOptions' => ['onclick' => 'renderCreateForm_scheduledJobs ()'],
      ],
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

<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'scheduled-jobs-grid',
    'fixedHeader'     => true,
    'headerOffset'    => 0,
    'dataProvider'    => $model->search(),
    'type'            => 'striped bordered condensed',
    'template'        => '{summarypager}{items}{pager}',
    'responsiveTable' => true,
    'columns'         => [
      'id',
      'job_script',
      'job_start_time',
      'job_stop_time',
      'job_interval',
      'job_description',
      [

        'type'        => 'raw',
        'value'       => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\'renderUpdateForm_scheduledJobs (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      <a href=\'javascript:void(0);\' onclick=\'delete_record_scheduledJobs (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
		      </div>
		     "',
        'htmlOptions' => ['style' => 'width:150px;'],
      ],

    ],
  ]
);

$this->renderPartial("_ajax_update");
$this->renderPartial("_ajax_create_form", ["model" => $model]);
$this->renderPartial("_ajax_view");

?>

<script type="text/javascript">
    function delete_record_scheduledJobs(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/scheduled-jobs/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('scheduled-jobs-grid', {});
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
    function printDiv_scheduledJobs() {

        window.print();

    }
</script>
 

