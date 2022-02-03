<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var Tariffs $model */
?>
<div class="modal fade" id="tariffs-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование тарифа') ?>
          #<?= $model->tariff_name ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'tariffs-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["tariffs/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_tariffs (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo
          $form->hiddenField($model, 'tariffs_id', []); ?>
          <?php echo $form->uneditableRow($model, 'tariffs_id', ['id' => 'tariffs_tariffs_id_update']); ?>
          <?php echo $form->textAreaRow($model, 'tariff_name', ['id' => 'tariffs_tariff_name_update']); ?>
          <?php echo $form->textFieldRow($model, 'tariff_short_name', ['id' => 'tariffs_tariff_short_name_update']); ?>
          <?php echo $form->textAreaRow(
            $model,
            'tariff_description',
            ['id' => 'tariffs_tariff_description_update']
          ); ?>
          <?php echo $form->textAreaRow($model, 'tariff_rules', ['id' => 'tariffs_tariff_rules_update']); ?>
          <?php echo $form->uneditableRow($model, 'created', ['id' => 'tariffs_created_update']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'tariffs_comments_update']); ?>
          <?
          $htmlOptions['id'] = 'tariffs_acceptor_update';
          echo $form->dropDownListRow(
            $model,
            'acceptor_id',
            [
              'widgetOptions' => [
                'data'        => TariffsAcceptors::getList(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'tariffs_enabled_update']); ?>
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
              'htmlOptions' => ['onclick' => 'update_tariffs ();'],
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




