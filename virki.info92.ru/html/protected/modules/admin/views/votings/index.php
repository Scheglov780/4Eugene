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
/** @var Votings $model */
Yii::app()->clientScript->registerScript(
  'search',
  /** @lang JavaScript */
  "
$('#votings-search-button').click(function(){
    $('#votings-search-form').slideToggle('fast');
    return false;
});
$('#votings-search-form form').submit(function(){
    $.fn.yiiGridView.update('votings-grid', {
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
      <?= Yii::t('main', 'Опросы и голосования') ?>
    <small><?= Yii::t('main', 'Голосования с соблюдением ФЗ и опросы абонентов...') ?></small>
      <?= Utils::getHelp('index', true) ?>
  </h1>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
          'booster.widgets.TbMenu',
          [
            'type'  => 'pills',
            'items' => [
                //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
              [
                'label'       => Yii::t('main', 'Новое голосование'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_votings ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'votings-search-button', 'class' => 'search-button'],
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

      <div class="row">
        <div class="col-md-12">
          <section id="votings-search-form-section" class="search-form" style="display:none">
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
          <h3 class="box-title"><?= Yii::t('main', 'Список голосований и опросов') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'votings-grid',
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
                    'type'  => 'raw',
                    'name'  => 'votings_id',
                    'value' => function ($data, $row) {
                        /** @var Votings $data */
                        return Votings::getUpdateLink($data->votings_id, false, $data);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'votings_type',
                    'filter' => DicCustom::getVals('VOTING_TYPE'),
                    'value'  => function ($data, $row) {
                        /** @var Votings $data */
                        return $data->votings_type_name;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'votings_header',
                    'value' => function ($data, $row) {
                        /** @var Votings $data */
                        return Votings::getUpdateLink($data->votings_id, false, $data, $data->votings_header);
                    },
                  ],
                    /*
array(
'type'  => 'raw',
'name'  => 'votings_query',
'value' => function ($data, $row) {
///** @var Votings $data /
return $data->votings_query;
},
),
                    */
                    /*
                      array(
                    'type'  => 'raw',
                    'name'  => 'votings_variants',
                    'value' => function ($data, $row) {
                    ///** @var Votings $data /
                    return $data->votings_variants;
                    },
                    ),
                    */
                    /*
                array(
                'type'  => 'raw',
                'name'  => 'votings_summary',
                'value' => function ($data, $row) {
                ///** @var Votings $data /
                return $data->votings_summary;
                },
                ),
                    */
                  [
                    'type'  => 'raw',
                    'name'  => 'votings_author',
                    'value' => function ($data, $row) {
                        /** @var Votings $data */
                        return $data->votings_author_name;
                    },
                  ],
                  [
                    'name'           => 'enabled',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->enabled==1',
                    'header'         => Yii::t('main', 'Вкл'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'created',
                    'header' => 'Создано/проводится',
                    'value'  => function ($data, $row) {
                        /** @var Votings $data */
                        $result = Utils::pgDateToStr($data->created) . ' / ';
                        if ($data->date_actual_start) {
                            $result = $result . Utils::pgDateToStr($data->date_actual_start);
                        } else {
                            $result = $result . '*';
                        }
                        if ($data->date_actual_end) {
                            $result = $result . ' > ' . Utils::pgDateToStr($data->date_actual_end);
                        } else {
                            $result = $result . ' > *';
                        }
                        return $result;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'recipients',
                    'value' => function ($data, $row) {
                        ///** @var Votings $data /
                        return $data->recipients;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        /** @var Votings $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_votings ("<?= $data->votings_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_votings ("<?= $data->votings_id ?>")'
                           class='btn btn-default btn-sm'><i
                              class='fa fa-trash'></i></a>
                      </div>
                    <? },
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

<script type="text/javascript">
    function delete_record_votings(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;


        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/votings/delete'); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('votings-grid', {});
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


