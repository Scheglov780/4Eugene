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
/** @var Bills $model */
$typeVal = ($type ? $type : 'all');
Yii::app()->clientScript->registerScript(
  'search',
  /** @lang JavaScript */
  "
$('#bills-search-button-{$typeVal}').click(function(){
    $('#bills-search-form-section-{$typeVal}').slideToggle('fast');
    return false;
});
$('#bills-search-form-{$typeVal} form').submit(function(){
    $.fn.yiiGridView.update('bills-grid-{$typeVal}', {
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
      <?= Yii::t('main', 'Счета') ?>
    <small><?= Yii::t('main', 'выставленные к оплате, по статусам...') ?></small>
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
                /* array(
                  'label'       => Yii::t('main', 'Новая запись'),
                  'icon'        => 'fa fa-plus',
                  'url'         => 'javascript:void(0);',
                  'linkOptions' => array('onclick' => "renderCreateForm_bills_{$typeVal} ()"),
                  'visible'     => true,
                ), */
              [
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => ['id' => "bills-search-button-{$typeVal}", 'class' => 'search-button'],
              ],
              [
                'label'       => Yii::t('main', 'Excel'),
                'icon'        => 'fa fa-download',
                'url'         => Yii::app()->controller->createUrl(
                  'GenerateExcel',
                  ['type' => ($type ? $type : 'all'), 'uid' => Yii::app()->user->id],
                ),
                'linkOptions' => ['target' => '_blank'],
                'visible'     => true,
              ],
            ],
          ]
        );
        ?>

      <div class="row">
        <div class="col-md-12">
          <section id="bills-search-form-section-<?= ($type ? $type : 'all') ?>" class="search-form"
                   style="display:none">
              <?php $this->renderPartial(
                '_search',
                [
                  'model' => $model,
                  'type'  => ($type ? $type : 'all'),
                ]
              ); ?>
          </section><!-- search-form -->
        </div>
      </div>
    </div>
  </div>
    <?php
    $this->widget(
      'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.BillsListBlock',
      [
        'type'     => ($type ? $type : 'all'),
        'name'     => $name,
        'uid'      => Yii::app()->user->id,
        'editable' => false,
        'idPrefix' => '',
        'pageSize' => 500,
        'filter'   => true,
        'model'    => $model,
          //'orderBy'  => (in_array($type,array(100,200))?"STR_TO_DATE(last_payment_data,'%d.%m.%Y %H:%i') DESC, `date` DESC":''),
      ]
    );
    ?>
    <?
    //$this->renderPartial("_ajax_update",array('type' => ($type ? $type : 'all'),));
    //$this->renderPartial("_ajax_create_form", array("model" => $model,'type' => ($type ? $type : 'all'),));
    ?>
</section>
<!-- /.content -->

<script type="text/javascript">
    function delete_record_bills_<?=($type ? $type : 'all')?>(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/bills/delete'); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('bills-grid-<?=($type ? $type : 'all')?>', {});
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
<div class="row<?= (Utils::isDeveloperIp() ? '' : ' hide') ?>">
  <div class="col-md-12">
    <div class="box box-default collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title" data-widget="collapse">Черновики для разработчиков</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="display: none;">
        <img class="img-responsive pad" src="/images/TZ/007-struktura-Nachisleniya.jpg">
      </div>
      <!-- /.box-body -->
    </div>
  </div>
</div>


