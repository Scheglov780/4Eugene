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
/** @var News $model */

Yii::app()->clientScript->registerScript(
  'search',
  "
$('#news-search-button').click(function(){
    $('#news-search-form').slideToggle('fast');
    return false;
});
$('#news-search-form form').submit(function(){
    $.fn.yiiGridView.update('news-grid', {
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
      <?= Yii::t('main', 'Новости и объявления') ?>
    <small><?= Yii::t('main', 'Новости администрации и объявления абонентов...') ?></small>
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
                'label'       => Yii::t('main', 'Новое сообщение'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_news ()'],
                'visible'     => true,
              ],
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => 'news-search-button', 'class' => 'search-button'],
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
          <section id="news-search-form-section" class="search-form" style="display:none">
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
          <h3 class="box-title"><?= Yii::t('main', 'Список сообщений') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <?php $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'news-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',//
                'dataProvider'    => $model->search(null, 100),
                'filter'          => $model,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'type'   => 'raw',
                    'name'   => 'news_id',
                    'header' => 'ID',
                    'value'  => function ($data, $row) {
                        /** @var News $data */
                        return News::getUpdateLink($data->news_id, false, $data, $data->news_id);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'news_header',
                    'header' => 'Заголовок',
                    'value'  => function ($data, $row) {
                        /** @var News $data */
                        return News::getUpdateLink($data->news_id, false, $data, $data->news_header);
                    },
                  ],
                    /*
                    array(
                      'type'  => 'raw',
                      'name'  => 'news_body',J
                      'header' => 'Сообщение',
                      'value' => function ($data, $row) {
                          /** @var News $data /
                          return $data->news_body;
                      },
                    ),
                    */
                  [
                    'type'  => 'raw',
                    'name'  => 'news_author',
                    'value' => function ($data, $row) {
                        /** @var News $data */
                        return Users::getUpdateLink($data->news_author, false);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'news_type',
                    'filter' => DicCustom::getVals('NEWS_TYPE'),
                    'value'  => function ($data, $row) {
                        ///** @var News $data /
                        return $data->news_type_name;
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
                    'header' => 'Создано/публикуется',
                    'value'  => function ($data, $row) {
                        /** @var News $data */
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
                        /** @var News $data */
                        return $data->recipients;
                    },
                  ],
                  [
                    'name'           => 'confirmation_needed',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->confirmation_needed==1',
                    'header'         => Yii::t('main', 'Подтверждать'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  [
                    'type'  => 'raw',
                    'name'  => 'absolute_order',
                    'value' => function ($data, $row) {
                        /** @var News $data */
                        return $data->absolute_order;
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        /** @var News $data */
                        ?>
                      <div class="btn-group" role="group">
                        <a href='javascript:void(0);' title="Редактировать"
                           onclick='renderUpdateForm_news ("<?= $data->news_id ?>")'
                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_news ("<?= $data->news_id ?>")'
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
    function delete_record_news(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;


        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/news/delete'); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('news-grid', {});
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


