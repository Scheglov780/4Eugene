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
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Опросы') ?>
    <small><?= Yii::t('main', 'только для членов товарищества') ?></small>
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
                'label'       => Yii::t('main', 'Новый опрос'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_pools ()'],
                'visible'     => true,
              ],
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
          <h3 class="box-title"><?= Yii::t('main', 'Список опросов') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <? $this->widget(
              'booster.widgets.TbListView',
              [
                'id'            => 'cabinet-pools-list-view',
                  //'ajaxUrl'       => Yii::app()->request->requestUri,
                  //'ajaxUpdate'    => true,
                'dataProvider'  => $dataProvider,
                'itemView'      => 'index_list_message_view',
                'enableSorting' => false,
                'template'      => "{summary}{pager}{items}{pager}",
                'summaryText'   => Yii::t('main', 'Опросы') . ' {start}-{end} ' . Yii::t(
                    'main',
                    'из'
                  ) . ' {count}',
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
    function delete_record_pools(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;


        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/pools/delete'); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiListView.update('cabinet-pools-list-view', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function poolsConfirm(addlink, id) {
        var url = $(addlink).attr('href');
        if (typeof url == 'undefined') {
            url = $(addlink).attr('formaction');
        }
        $.get(url, null,
            function (data) {
                $('#pools-confirm-button-' + id).tooltip('hide');
                $('#pools-confirm-button-' + id).remove();
                dsAlert(data, 'Подтверждение', true);
            },
            'text');
    }
</script>


