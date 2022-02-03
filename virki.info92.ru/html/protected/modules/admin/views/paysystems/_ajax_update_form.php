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
/** @var PaySystems $model */
?>
<div class="modal fade" id="pay-systems-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Изменение платёжной системы ') ?> #<?php echo $model->id; ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'pay-systems-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["paysystems/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_paysystems (); } " /* Do ajax call when user presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->hiddenField($model, 'id', []); ?>
          <?php echo $form->checkboxRow($model, 'enabled'); ?>
          <?php echo $form->textFieldRow($model, 'logo_img'); ?>
          <?php echo $form->textFieldRow($model, 'int_name'); ?>
          <?php echo $form->textAreaRow($model, 'descr_ru'); ?>
          <?php echo $form->textAreaRow($model, 'descr_en'); ?>
          <?php echo $form->textAreaRow($model, 'parameters'); ?>
          <?php echo $form->textFieldRow($model, 'name_ru'); ?>
          <?php echo $form->textFieldRow($model, 'name_en'); ?>
          <?php echo $form->textAreaRow($model, 'form_ru', ['id' => 'paySystemsFormRuCodeUpdate']); ?>
        <script>
            if (paySystemsFormRuCodeUpdateVar != undefined) {
                paySystemsFormRuCodeUpdateVar.toTextArea();
            }
            var paySystemsFormRuCodeUpdateVar = CodeMirror.fromTextArea(
                document.getElementById('paySystemsFormRuCodeUpdate')
                , {
                    //lineNumbers: true,
                    mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            paySystemsFormRuCodeUpdateVar.setSize(null, 100);
            paySystemsFormRuCodeUpdateVar.refresh();
        </script>
          <?php echo $form->textAreaRow($model, 'form_en', ['id' => 'paySystemsFormEnCodeUpdate']); ?>
        <script>
            if (paySystemsFormEnCodeUpdateVar != undefined) {
                paySystemsFormEnCodeUpdateVar.toTextArea();
            }
            var paySystemsFormEnCodeUpdateVar = CodeMirror.fromTextArea(
                document.getElementById('paySystemsFormEnCodeUpdate')
                , {
                    //lineNumbers: true,
                    mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            paySystemsFormEnCodeUpdateVar.setSize(null, 100);
            paySystemsFormEnCodeUpdateVar.refresh();
        </script>
          <?php echo $form->textAreaRow($model, 'parameters', ['id' => 'paySystemsParametersUpdate']); ?>
        <script>
            if (paySystemsParametersUpdateVar != undefined) {
                paySystemsParametersUpdateVar.toTextArea();
            }
            var paySystemsParametersUpdateVar = CodeMirror.fromTextArea(
                document.getElementById('paySystemsParametersUpdate')
                , {
                    //lineNumbers: true,
                    mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            paySystemsParametersUpdateVar.setSize(null, 150);
            paySystemsParametersUpdateVar.refresh();
        </script>
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
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'paySystemsParametersUpdateVar.save(); paySystemsFormEnCodeUpdateVar.save(); paySystemsFormRuCodeUpdateVar.save(); update_paysystems ();'],
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
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




