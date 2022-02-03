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
/** @var Banrules $model */
?>
<div class="modal fade" id="banrules-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Изменение условия'); ?> #<?php echo $model->id; ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'banrules-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["banrules/update"],
            'type'                   => 'vertical',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_banrules (); } " /* Do ajax call when user presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
        <div class="box">
          <div class="box-body">
              <?php echo $form->errorSummary($model); ?>
              <?php echo $form->hiddenField($model, 'id'); ?>
              <?php echo $form->textAreaRow($model, 'description', ['rows' => 1, 'class' => 'span11']); ?>
              <?php echo $form->textFieldRow($model, 'request_rule'); ?>
            <script>
                if (banRulesUpdateVar != undefined) {
                    banRulesUpdateVar.toTextArea();
                }
                var banRulesUpdateVar = CodeMirror.fromTextArea(
                    document.getElementById('banRulesUpdate')
                    , {
                        //lineNumbers: true,
                        mode: 'text/x-c++src',//'application/x-httpd-php',//'htmlmixed',//'text/html',
                        matchBrackets: true,
                    });
                banRulesUpdateVar.setSize(null, 100);
                banRulesUpdateVar.refresh();
            </script>
              <?php echo $form->textFieldRow($model, 'rule_order'); ?>
              <?php echo $form->checkboxRow($model, 'enabled'); ?>

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
                  'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
                  'htmlOptions' => ['onclick' => 'banRulesUpdateVar.save(); update_banrules ();'],
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