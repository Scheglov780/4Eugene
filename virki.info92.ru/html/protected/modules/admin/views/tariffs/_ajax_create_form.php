<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?><? /** @var Tariffs $model */
?>
<div class="modal fade" id="tariffs-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание тарифа') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'tariffs-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["tariffs/create"],
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
            create_tariffs();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textAreaRow($model, 'tariff_name', ['id' => 'tariffs_tariff_name_create']); ?>
          <?php echo $form->textFieldRow($model, 'tariff_short_name', ['id' => 'tariffs_tariff_short_name_create']); ?>
          <?php echo $form->textAreaRow(
            $model,
            'tariff_description',
            ['id' => 'tariffs_tariff_description_create']
          ); ?>
          <?php echo $form->textAreaRow($model, 'tariff_rules', ['id' => 'tariffs_tariff_rules_create']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'tariffs_comments_create']); ?>
          <?
          $htmlOptions['id'] = 'tariffs_acceptor_create';
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
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'tariffs_enabled_create']); ?>

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
              'htmlOptions' => ['onclick' => 'create_tariffs();'],
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
    function create_tariffs() {
        var data = $('#tariffs-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/tariffs/create"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#tariffs-create-modal').modal('hide');
                    $.fn.yiiGridView.update('tariffs-grid', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_tariffs() {
        $('#tariffs-create-form').each(function () {
            this.reset();
        });
        $('#tariffs-create-modal').modal('show');
    }

</script>
