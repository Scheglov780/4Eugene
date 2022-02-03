<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Блоки меню') ?>
    <small><?= Yii::t('main', 'Редактирование блоков меню фронта') ?></small>
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
                'linkOptions' => ['onclick' => 'renderCreateForm_cmsMenus ()'],
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
          <h3 class="box-title"><?= Yii::t('main', 'Список блоков меню') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>

            <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'cms-menus-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->search(),
                'filter'          => $model,
                'type'            => 'striped bordered condensed',
                'template'        => '{summary}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                    //'id',
                  'menu_id',
                  [
                    'type'   => 'raw',
                    'filter' => false,
                    'name'   => 'menu_data',
                    'value'  => function ($data) {
                        return '<code>' . Utils::textSnippet($data->menu_data, 120) . '</code>';
                    },
                      //'htmlOptions' => array('class' => 'pre') //,'style' => 'width:800px !important;'
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
                    'name'           => 'SEO',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->SEO==1',
                    'header'         => Yii::t('main', 'Доступно поисковикам'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  [

                    'type'  => 'raw',
                    'value' => function ($data) { ?>
                      <div class="btn-group">
                        <a href='/<?= Yii::app()->controller->module->id ?>/cmsMenus/update/id/<?= $data->id ?>'
                           onclick='getContent(this,"CMS:<?= Yii::t('main', 'меню') ?> <?= addslashes(
                             $data->menu_id
                           ) ?>",false); return false;'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' onclick='delete_record_cmsMenus ("<?= $data->id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
                      </div>
                    <? },
                      // 'htmlOptions' => array('style' => 'width:90px;')
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
    function delete_record_cmsMenus(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsMenus/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('cms-menus-grid', {});
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
