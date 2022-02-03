<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var Bills $model */
?>
<div class="modal fade" id="bills-update-modal-<?= ($type ? $type : 'all') ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование счёта') ?>
          #<?= $model->id ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'bills-update-form-' . ($type ? $type : 'all'),
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["bills/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_bills (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo
          $form->hiddenField($model, 'id', []); ?>
          <?php echo $form->uneditableRow($model, 'code', ['id' => 'bills_code_update' . ($type ? $type : 'all')]); ?>
          <? $htmlOptions = ['id' => 'bills_tariff_object_id_update_lands' . ($type ? $type : 'all')];
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
          <? $htmlOptions = ['id' => 'bills_tariff_object_id_update_devices' . ($type ? $type : 'all')];
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
          <? $htmlOptions = ['id' => 'bills_status_update' . ($type ? $type : 'all')];
          echo $form->dropDownListRow(
            $model,
            'status',
            [
              'widgetOptions' => [
                'data'        => BillsStatuses::getAllowedStatusesForBill(
                  $model->id,
                  Yii::app()->user->id,
                  Yii::app()->user->id
                ),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <? $htmlOptions = ['id' => 'bills_tariff_id_update' . ($type ? $type : 'all')];
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
          $model->date = Utils::pgDateToStr($model->date);
          echo $form->uneditableRow($model, 'date', ['id' => 'bills_date_update' . ($type ? $type : 'all')]); ?>
          <? $htmlOptions = ['id' => 'bills_manager_id_update' . ($type ? $type : 'all')];
          echo $form->dropDownListRow(
            $model,
            'manager_id',
            [
              'widgetOptions' => [
                'data'        => Users::getListData(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->numberFieldRow($model, 'summ', ['id' => 'bills_summ_update' . ($type ? $type : 'all')]); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'manual_summ',
            ['id' => 'bills_manual_summ_update' . ($type ? $type : 'all')]
          ); ?>
          <?php echo $form->checkboxRow($model, 'frozen', ['id' => 'bills_frozen_update' . ($type ? $type : 'all')]); ?>
      </div>
      <div class="modal-footer">
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size' => 'mini',
              'icon'        => 'fa fa-check',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'update_bills_' . ($type ? $type : 'all') . ' ();'],
            ]
          );
          ?>
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size' => 'mini',
              'icon'        => 'fa fa-close',
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
        <?php
        $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




