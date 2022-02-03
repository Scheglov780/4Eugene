<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var deviceDataForm $model */
?>
<div class="modal fade" id="devices-create-data-modal-<?= $model->device_id ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новые показания прибора') ?><?= Utils::getHelp(
              'createData',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'devices-create-data-form-' . $model->device_id,
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["devices/createData"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => "js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_devices_data_{$model->device_id} ();
                                        }
                                     }",
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php
          //data_id,device_id,data_updated,tariff,uid
          echo $form->uneditableRow(
            $model,
            'device_id',
            ['id' => 'devices_data_device_id_' . $model->device_id]
          );
          echo $form->numberFieldRow(
            $model,
            'tariff1',
            ['id' => 'devices_data_tariff1_' . $model->device_id, 'min' => $model->tariff1]
          );
          echo $form->numberFieldRow(
            $model,
            'tariff2',
            ['id' => 'devices_data_tariff2_' . $model->device_id, 'min' => $model->tariff2]
          );
          echo $form->numberFieldRow(
            $model,
            'tariff3',
            ['id' => 'devices_data_tariff3_' . $model->device_id, 'min' => $model->tariff3]
          );
          ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size'        => 'mini',
              'icon'        => 'fa fa-check',
              'label'       => Yii::t('main', 'Добавить'),
              'htmlOptions' => ['onclick' => "create_devices_data_{$model->device_id} ();"],
            ]
          );
          ?>
          <?
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
                //'id'=>'sub2',
              'type'        => 'default',
              'icon'        => 'fa fa-close', //fa-inverse
              'label'       => Yii::t('main', 'Отмена'),
              'htmlOptions' => ['data-dismiss' => 'modal'],
            ]
          );
          ?>
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'type'        => 'default',
                //'size'       => 'mini',
              'icon'        => 'fa fa-rotate-left',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function create_devices_data_<?=$model->device_id?> () {
        var data = $("#devices-create-data-form-<?=$model->device_id?>").serialize();
        jQuery.ajax({
                type: 'POST',
                url: '<?php
                  echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/devices/createData"); ?>',
                data: data,
                success: function (data) {
                    if (data !== 'false') {
                        $('#devices-create-data-modal-<?=$model->device_id?>').modal('hide');
                        $.fn.yiiGridView.update('device-data-grid-<?=$model->device_id?>', {});
                        dsAlert(data, 'Сохранение', true);
                    }

                },
                error: function (data) { // if error occured
                    dsAlert(JSON.stringify(data), 'Error', true);
                },

                dataType: 'html'
            }
        )
        ;

    }

    function renderCreateForm_devices_data_<?=$model->device_id?>() {
        $('#devices-create-data-form-<?=$model->device_id?>').each(function () {
            this.reset();
        });
        $('#devices-create-data-modal-<?=$model->device_id?>').modal('show');
    }

</script>
