<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Контент блоков') ?>
    <small><?= Yii::t('main', 'Редактирование контента блоков') ?></small>
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
      <div class="box">
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
                  'linkOptions' => ['onclick' => 'renderCreateForm_cmsCustomContent ()'],
                ],
                [
                  'label'       => Yii::t('main', 'Экспорт в HTML'),
                  'icon'        => 'fa fa-gears',
                  'url'         => '/' . Yii::app()->controller->module->id . '/cmsCustomContent/exportHtml',
                  'linkOptions' => [
                    'target'  => '_blank',
                    'title'   => Yii::t('main', 'Экспорт в HTML для копирайтеров')
                      ,
                    'visible' => true,
                  ],
                ],
                  //array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
//		array('label'=>Yii::t('main','Поиск'), 'icon'=>'fa fa-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
//		array('label'=>Yii::t('main','PDF'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
//		array('label'=>Yii::t('main','Excel'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
              ],
            ]
          );
          ?>
          <? $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'form-upload-custom-content',
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => [
                Yii::app()->createUrl(
                  '/' . Yii::app()->controller->module->id . '/cmsCustomContent/exportHtml'
                ),
              ],
              'type'                   => 'inline',
              'htmlOptions'            => [
                'enctype' => 'multipart/form-data',
              ],
            ]
          );
          ?>
        <div class="form-group">
          <input type="file" id="upload-custom-content" name="uploadedFile"
                 title="<?= Yii::t('main', 'Загрузить HTML-контент') ?>" onchange="
            $('#form-upload-custom-content' ).submit();
            " accept="text/*">
        </div>
          <? $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
          'booster.widgets.TbGridView',
          [
            'id'              => 'cms-custom-content-grid',
            'fixedHeader'     => true,
            'headerOffset'    => 0,
            'dataProvider'    => $model->search(),
            'filter'          => $model,
            'type'            => 'striped bordered condensed',
            'template'        => '{summary}{items}{pager}',
            'responsiveTable' => true,
            'columns'         => [
//		'id',
              'content_id',
              'lang',
              [
                'type'   => 'raw',
                'filter' => false,
                'name'   => 'content_data',
                'value'  => function ($data) {
                    return '<code>' . Utils::textSnippet($data->content_data, 120) . '</code>';
                },
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

                'type'  => 'raw',
                'value' => function ($data) { ?>
                  <div class="btn-group">
                    <a href='/<?= Yii::app()->controller->module->id ?>/cmsCustomContent/update/id/<?= $data->id ?>'
                       onclick='getContent(this,"CMS:<?= Yii::t('main', 'блок') ?> <?= addslashes(
                         $data->content_id
                       ) ?>",false); return false;' class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                    <a href='javascript:void(0);' onclick='delete_record_cmsCustomContent ("<?= $data->id ?>)'
                       class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
                  </div>
                <? },
                  //'htmlOptions' => array('style' => 'width:90px;')
              ],

            ],
          ]
        );

        $this->renderPartial("_ajax_update");
        $this->renderPartial("_ajax_create_form", ["model" => $model]);
        ?>
    </div>
  </div>
</section>

<script type="text/javascript">
    function delete_record_cmsCustomContent(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsCustomContent/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('cms-custom-content-grid', {});

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


 

