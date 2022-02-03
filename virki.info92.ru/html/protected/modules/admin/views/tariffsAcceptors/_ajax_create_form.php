<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?><? /** @var TariffsAcceptors $model */
?>
<div class="modal fade" id="tariffs-acceptors-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание записи') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'tariffs-acceptors-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["tariffsAcceptors/create"],
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
            create_tariffs_acceptors();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php /* echo $form->textFieldRow(
                  $model,
                  'tariff_acceptors_id',
                  array('id' => 'tariffs-acceptors_tariff_acceptors_id_create')
                ); */ ?>
          <?php echo $form->textAreaRow($model, 'name', ['id' => 'tariffs-acceptors_name_create']); ?>
          <?php echo $form->textAreaRow($model, 'address', ['id' => 'tariffs-acceptors_address_create']); ?>
          <?php echo $form->numberFieldRow($model, 'OGRN', ['id' => 'tariffs-acceptors_OGRN_create']); ?>
          <?php echo $form->numberFieldRow($model, 'INN', ['id' => 'tariffs-acceptors_INN_create']); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'KPPacceptor',
            ['id' => 'tariffs-acceptors_KPPacceptor_create']
          ); ?>
          <?php echo $form->numberFieldRow($model, 'schet', ['id' => 'tariffs-acceptors_schet_create']); ?>
          <?php echo $form->textFieldRow($model, 'valuta', ['id' => 'tariffs-acceptors_valuta_create']); ?>
          <?php echo $form->textAreaRow($model, 'bank', ['id' => 'tariffs-acceptors_bank_create']); ?>
          <?php echo $form->numberFieldRow($model, 'KPPbank', ['id' => 'tariffs-acceptors_KPPbank_create']); ?>
          <?php echo $form->numberFieldRow($model, 'BIK', ['id' => 'tariffs-acceptors_BIK_create']); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'korrSchet',
            ['id' => 'tariffs-acceptors_korrSchet_create']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'comments',
            ['id' => 'tariffs-acceptors_comments_create']
          ); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'tariffs-acceptors_enabled_create']); ?>
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
              'htmlOptions' => ['onclick' => 'create_tariffs_acceptors();'],
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
    function create_tariffs_acceptors() {
        var data = $('#tariffs-acceptors-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/tariffsAcceptors/create"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#tariffs-acceptors-create-modal').modal('hide');
                    $.fn.yiiGridView.update('tariffs-acceptors-grid', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_tariffs_acceptors() {
        $('#tariffs-acceptors-create-form').each(function () {
            this.reset();
        });
        $('#tariffs-acceptors-create-modal').modal('show');
    }

</script>
