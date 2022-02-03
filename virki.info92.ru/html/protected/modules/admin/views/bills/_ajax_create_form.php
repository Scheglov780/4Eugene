<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?><? /** @var Bills $model */
?>
<div class="modal fade" id="bills-create-modal-<?= ($type ? $type : 'all') ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание счёта') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'bills-create-form-' . ($type ? $type : 'all'),
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["bills/create"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
            if (!hasError)
            {
            create_bills();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php // echo $form->textFieldRow($model, 'id', array('id' => 'bills_id_create')); ?>
          <?php //echo $form->textFieldRow($model, 'code', array('id' => 'bills_code_create')); ?>
          <? $htmlOptions = ['id' => 'bills_tariff_object_id_create_lands-' . ($type ? $type : 'all')];
          echo $form->dropDownListRow(
            $model,
            'tariff_object_id_land',
            [
              'widgetOptions' => [
                'data'        => Lands::getListForDropDown(),
                'htmlOptions' => array_merge($htmlOptions, ['prompt' => 'Не выбрано']),
              ],
            ]
          ); ?>
          <? $htmlOptions = ['id' => 'bills_tariff_object_id_create_devices-' . ($type ? $type : 'all')];
          echo $form->dropDownListRow(
            $model,
            'tariff_object_id_device',
            [
              'widgetOptions' => [
                'data'        => Devices::getListForDropDown(),
                'htmlOptions' => array_merge($htmlOptions, ['prompt' => 'Не выбрано']),
              ],
            ]
          ); ?>
          <? $htmlOptions = ['id' => 'bills_status_create-' . ($type ? $type : 'all')];
          $model->status = 'IN_PROCESS';
          echo $form->hiddenField($model, 'status', $htmlOptions);
          /* echo $form->dropDownListRow(
            $model,
            'status',
            array(
              'widgetOptions' => array(
                'data'        => BillsStatuses::getAllowedStatusesForBill($id, $uid, $manager),
                'htmlOptions' => $htmlOptions
              )
            )
          ); */ ?>
          <? $htmlOptions = ['id' => 'bills_manager_id_create-' . ($type ? $type : 'all')];
          $model->manager_id = Yii::app()->user->id;
          echo $form->hiddenField($model, 'manager_id', $htmlOptions);
          /* echo $form->dropDownListRow(
            $model,
            'manager_id',
            array(
              'widgetOptions' => array(
                'data'        => Lands::getGroups(),
                'htmlOptions' => $htmlOptions
              )
            )
          ); */ ?>
          <? $htmlOptions = ['id' => 'bills_tariff_id_create-' . ($type ? $type : 'all')];
          echo $form->dropDownListRow(
            $model,
            'tariff_id',
            [
              'widgetOptions' => [
                'data'        => Tariffs::getList(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php
          $model->summ = 0;
          echo $form->numberFieldRow($model, 'summ', ['id' => 'bills_summ_create-' . ($type ? $type : 'all')]); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'manual_summ',
            ['id' => 'bills_manual_summ_create-' . ($type ? $type : 'all')]
          ); ?>
          <?php // echo $form->textFieldRow($model, 'date', array('id' => 'bills_date_create')); ?>
          <?php echo $form->checkboxRow($model, 'frozen', ['id' => 'bills_frozen_create-' . ($type ? $type : 'all')]
          ); ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size'=>'mini',
              'icon'        => 'fa fa-check',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'create_bills_' . ($type ? $type : 'all') . '();'],
            ]
          );
          ?>
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
              'icon'        => 'fa fa-close',
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
        <?php
        $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function create_bills_<?=($type ? $type : 'all')?>() {
        var data = $("#bills-create-form-<?=($type ? $type : 'all')?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/bills/create'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#bills-create-modal-<?=($type ? $type : 'all')?>').modal('hide');
                    $.fn.yiiGridView.update('bills-grid-<?=($type ? $type : 'all')?>', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_bills_<?=($type ? $type : 'all')?>() {
        $('#bills-create-form-<?=($type ? $type : 'all')?>').each(function () {
            this.reset();
        });
        $('#bills-create-modal-<?=($type ? $type : 'all')?>').modal('show');
    }

</script>
