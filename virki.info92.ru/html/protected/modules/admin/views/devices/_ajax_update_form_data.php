<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var deviceDataForm $model */
?>
<div class="modal fade" id="devices-data-update-modal-<?= $model->device_id ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование показаний прибора ') ?>
            <?= $model->source . '/' . $model->device_id; ?><?= Utils::getHelp('updateData', true) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'devices-data-update-form-' . $model->device_id,
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["devices/updateData"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_devices (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php
          echo $form->uneditableRow(
            $model,
            'data_id',
            ['id' => 'devices_data_update_data_id_' . $model->device_id]
          );
          echo $form->uneditableRow(
            $model,
            'device_id',
            ['id' => 'devices_data_update_device_id_' . $model->device_id]
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
              'icon'        => 'fa fa-check', // fa-inverse
              'label'       => Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => "update_device_data_{$model->device_id} ();"],
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
          ); ?>
          <?php $this->widget(
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




