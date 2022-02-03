<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://market.info92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="prices.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  Yii::t('admin', 'Настройки'),
]; ?>

<h2><?= Yii::t('admin', 'Основная наценка') ?></h2>

<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'config-grid-maink',
    'dataProvider'    => $mainK,
    'type'            => 'striped bordered condensed',
    'template'        => '{summary}{items}{pager}',
    'enableSorting'   => false,
    'responsiveTable' => true,
    'columns'         => [
      'id',
      [
        'name'  => 'label',
        'value' => function ($data) {
            return Yii::t('admin', $data['label']);
        },
      ],
      'value',
      'default_value',
//		'in_wizard',
      [

        'type'        => 'raw',
        'value'       => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\"renderUpdateForm_config (\'".$data->id."\')\"   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      </div>
		     "',
        'htmlOptions' => ['style' => 'width:150px;'],
      ],

    ],
  ]
);
?>

<h2><?= Yii::t('admin', 'Скидка от суммы') ?></h2>

<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'config-grid-pricerates',
    'fixedHeader'     => true,
    'headerOffset'    => 0,
    'dataProvider'    => $priceRates,
    'type'            => 'striped bordered condensed',
    'template'        => '{summary}{items}{pager}',
    'enableSorting'   => false,
    'responsiveTable' => true,
    'columns'         => [
      'id',
      [
        'name'  => 'label',
        'value' => function ($data) {
            return Yii::t('admin', $data['label']);
        },
      ],
      'value',
      'value',
      'default_value',
//		'in_wizard',
      [

        'type'        => 'raw',
        'value'       => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\"renderUpdateForm_config (\'".$data->id."\')\"   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      </div>
		     "',
        'htmlOptions' => ['style' => 'width:150px;'],
      ],

    ],
  ]
);
?>

<h2><?= Yii::t('admin', 'Скидка от количества') ?></h2>

<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'config-grid-countrates',
    'fixedHeader'     => true,
    'headerOffset'    => 0,
    'dataProvider'    => $countRates,
    'type'            => 'striped bordered condensed',
    'template'        => '{summary}{items}{pager}',
    'enableSorting'   => false,
    'responsiveTable' => true,
    'columns'         => [
      'id',
      [
        'name'  => 'label',
        'value' => function ($data) {
            return Yii::t('admin', $data['label']);
        },
      ],
      'value',
      'value',
      'default_value',
//		'in_wizard',
      [

        'type'  => 'raw',
        'value' => '"
        <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\"renderUpdateForm_config (\'".$data->id."\')\"   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      </div>
		     "',
          //'htmlOptions' => array('style' => 'width:150px;')
      ],

    ],
  ]
);
?>

<h2><?= Yii::t('admin', 'Курсы валют') ?></h2>
<b><?= Yii::t('admin', 'Автообновление') ?>: </b><?= (DSConfig::getVal('rates_auto_update') == 1) ? Yii::t(
  'admin',
  'включено'
) : Yii::t('admin', 'выключено') ?><br/>
<b><?= Yii::t('admin', 'Последнее обновление') ?>: </b><?= (DSConfig::getVal('rates_auto_update_last_time')) ? date(
  'Y-m-d H:i',
  DSConfig::getVal('rates_auto_update_last_time')
) : Yii::t('admin', 'не обновлялось') ?><br/>
<?php
$currs = Utils::getCurrencyRatesFromBank();
$this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'config-grid-currencyrates',
    'fixedHeader'     => true,
    'headerOffset'    => 0,
    'dataProvider'    => $currencyRates,
    'type'            => 'striped bordered condensed',
    'template'        => '{summary}{items}{pager}',
    'enableSorting'   => false,
    'responsiveTable' => true,
    'columns'         => [
      'id',
      [
        'name'  => 'label',
        'value' => function ($data) {
            return Yii::t('admin', $data['label']);
        },
      ],
      'value',
      'value',
      'default_value',
      [
        'header' => Yii::t('main', 'Курс ЦБР к рублю'),
        'value'  => 'Utils::getCurrencyRatesFromBank($data->id)',
      ],
//		'in_wizard',
      [

        'type'        => 'raw',
        'value'       => '"
		      <a href=\'javascript:void(0);\' onclick=\"renderUpdateForm_config (\'".$data->id."\')\"   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
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
                    $.fn.yiiGridView.update('config-grid-maink', {});
                    $.fn.yiiGridView.update('config-grid-currencyrates', {});
                    $.fn.yiiGridView.update('config-grid-pricerates', {});
                    $.fn.yiiGridView.update('config-grid-countrates', {});

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
    function printDiv_config() {

        window.print();

    }
</script>
 

