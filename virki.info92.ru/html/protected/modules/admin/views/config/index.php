<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://market.info92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('admin', 'Конфигурация') ?>
    <small><?= Yii::t('admin', 'Управление конфигурационными параметрами') ?></small>
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
          'booster.widgets.TbGridView',
          [
            'id'              => 'config-grid',
            'fixedHeader'     => true,
            'headerOffset'    => 0,
            'dataProvider'    => $model->search(),
            'filter'          => $model,
            'type'            => 'striped bordered condensed',
            'template'        => '{summary}{items}{pager}',
            'responsiveTable' => true,
            'columns'         => [
              [
                'name'   => 'id',
                'filter' => [
                  'billing_'    => Yii::t('admin', 'billing - Расчеты с менеджерами'),
                  'checkout_'   => Yii::t('admin', 'checkout - Оформление заказа'),
                  'delivery_'   => Yii::t('admin', 'delivery - Доставка'),
                  'ext_'        => Yii::t('admin', 'ext - Внешние сервисы'),
                  'featured_'   => Yii::t('admin', 'featured - Рекомендованные товары'),
                  'keys_'       => Yii::t('admin', 'keys - Ключи переводчика'),
                  'price_'      => Yii::t('admin', 'price - Ценообразование'),
                  'profiler_'   => Yii::t('admin', 'profiler - Профайлер'),
                  'proxy_'      => Yii::t('admin', 'proxy - Настройки DSProxy'),
                  'rate_'       => Yii::t('admin', 'rate - Курсы валют'),
                  'search_'     => Yii::t('admin', 'search - Поиск'),
                  'seo_'        => Yii::t('admin', 'seo - Поисковая оптимизация'),
                  'site_'       => Yii::t('admin', 'site - Общие настройки сайта'),
                  'skidka_'     => Yii::t('admin', 'skidka - Скидки от количества'),
                  'translator_' => Yii::t('admin', 'translator - Настройки переводчика'),
                  'weight_'     => Yii::t('admin', 'weight - Расчет веса'),
                ],
                'type'   => 'raw',
                'value'  => '$data->id.Utils::getHelp($data->id)',
              ],

              [
                'name'  => 'label',
                'type'  => 'raw',
                'value' => function ($data) {
                    return Yii::t('admin', $data->label);
                },
              ],

              [
                'name'  => 'value',
                'type'  => 'raw',
                'value' => function ($data) {
                    if (mb_strlen($data->value) > 64) {
                        return htmlentities(mb_substr($data->value, 0, 64) . "...", null, 'UTF-8');
                    } else {
                        return htmlentities($data->value, null, 'UTF-8');
                    }
                },
              ],
                /*
                array(
                  'name'  => 'default_value',
                  'type'  => 'raw',
                  'value' => function ($data) {
                      if (mb_strlen($data->default_value) > 64) {
                          return htmlentities(mb_substr($data->default_value, 0, 64) . "...", null, 'UTF-8');
                      } else {
                          return htmlentities($data->default_value, null, 'UTF-8');
                      }
                  },
                ),
                */
//		'in_wizard',
              [

                'type'  => 'raw',
                'value' => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\"renderUpdateForm_config (\'".$data->id."\')\"   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      </div>
		     "',
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
    function delete_record_config(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/config/delete"); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('config-grid', {});
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