<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var TariffsAcceptors $model */
?>
<div class="modal fade" id="tariffs-acceptors-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование') ?>
          #<?= $model->tariff_acceptors_id ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'tariffs-acceptors-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["tariffsAcceptors/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_tariffs_acceptors (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo
          $form->hiddenField($model, 'tariff_acceptors_id', []); ?>
          <?php echo $form->uneditableRow(
            $model,
            'tariff_acceptors_id',
            ['id' => 'tariffs-acceptors_tariff_acceptors_id_update']
          ); ?>
          <?php echo $form->textAreaRow($model, 'name', ['id' => 'tariffs-acceptors_name_update']); ?>
          <?php echo $form->textAreaRow($model, 'address', ['id' => 'tariffs-acceptors_address_update']); ?>
          <?php echo $form->numberFieldRow($model, 'OGRN', ['id' => 'tariffs-acceptors_OGRN_update']); ?>
          <?php echo $form->numberFieldRow($model, 'INN', ['id' => 'tariffs-acceptors_INN_update']); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'KPPacceptor',
            ['id' => 'tariffs-acceptors_KPPacceptor_update']
          ); ?>
          <?php echo $form->numberFieldRow($model, 'schet', ['id' => 'tariffs-acceptors_schet_update']); ?>
          <?php echo $form->textFieldRow($model, 'valuta', ['id' => 'tariffs-acceptors_valuta_update']); ?>
          <?php echo $form->textAreaRow($model, 'bank', ['id' => 'tariffs-acceptors_bank_update']); ?>
          <?php echo $form->numberFieldRow($model, 'KPPbank', ['id' => 'tariffs-acceptors_KPPbank_update']); ?>
          <?php echo $form->numberFieldRow($model, 'BIK', ['id' => 'tariffs-acceptors_BIK_update']); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'korrSchet',
            ['id' => 'tariffs-acceptors_korrSchet_update']
          ); ?>
          <?php echo $form->uneditableRow($model, 'created', ['id' => 'tariffs-acceptors_created_update']); ?>
          <?php echo $form->textAreaRow(
            $model,
            'comments',
            ['id' => 'tariffs-acceptors_comments_update']
          ); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'tariffs-acceptors_enabled_update']); ?>
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
              'htmlOptions' => ['onclick' => 'update_tariffs_acceptors ();'],
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




