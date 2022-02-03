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
/** @var ReportsSystem $model */
?>
<div id='reports-system-update-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><?= Yii::t('main', 'Отчёт') ?> <strong style="color:#0093f5;">#<?php echo $model->id; ?></strong></h3>
  </div>

  <div class="modal-body">
    <div class="form">
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'reports-system-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["reportsSystem/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_reportsSystem (); } " /* Do ajax call when user presses enter key */
            ],
          ]
        ); ?>
      <h6><?= Yii::t('main', 'Поля обозначенные ') ?><span class="required">*&nbsp;</span><?= Yii::t(
            'main',
            'обязательны для заполнения'
          ) ?></h6>
        <?php echo $form->errorSummary($model, 'Opps!!!', null, ['class' => 'alert alert-error span12']); ?>
      <div class="row-fluid">
        <div class="span6">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField(
              $model,
              'name',
              ['size' => 60, 'class' => 'span12', 'maxlength' => 2048]
            ); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="span6">
            <?php echo $form->hiddenField($model, 'id', []); ?>
            <?php echo $form->labelEx($model, 'internal_name'); ?>
            <?php echo $form->textField(
              $model,
              'internal_name',
              ['size' => 60, 'class' => 'span12', 'maxlength' => 512]
            ); ?>
            <?php echo $form->error($model, 'internal_name'); ?>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea(
              $model,
              'description',
              ['rows' => 1, 'class' => 'span12', 'cols' => 50]
            ); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
            <?php echo $form->labelEx($model, 'script'); ?>
            <?php echo $form->textArea(
              $model,
              'script',
              ['id' => 'reportsSystemScriptUpdate', 'rows' => 12, 'class' => 'span12', 'cols' => 50]
            ); ?>
            <?php echo $form->error($model, 'script'); ?>
          <script>
              if (reportsSystemScriptUpdateVar != undefined) {
                  reportsSystemScriptUpdateVar.toTextArea();
              }
              var reportsSystemScriptUpdateVar = CodeMirror.fromTextArea(
                  document.getElementById('reportsSystemScriptUpdate')
                  , {
                      //lineNumbers: true,
                      mode: 'text/x-php',//'text/x-mariadb', 'application/x-httpd-php',//'htmlmixed',//'text/html',
                      matchBrackets: true,
                  });
              reportsSystemScriptUpdateVar.setSize(null, 240);
              reportsSystemScriptUpdateVar.refresh();
          </script>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span4">
            <?php echo $form->labelEx($model, 'group'); ?>
            <?php echo $form->textField(
              $model,
              'group',
              ['size' => 60, 'class' => 'span12', 'maxlength' => 512]
            ); ?>
            <?php echo $form->error($model, 'group'); ?>
        </div>
        <div class="span4">
            <?php echo $form->labelEx($model, 'order'); ?>
            <?php echo $form->textField(
              $model,
              'order',
              ['size' => 16, 'class' => 'span12', 'maxlength' => 16]
            ); ?>
            <?php echo $form->error($model, 'order'); ?>
        </div>
        <div class="span3">
            <?php echo $form->labelEx($model, 'enabled'); ?>
            <?= $form->checkBox($model, 'enabled', ['class' => 'span3']); ?>
            <?php echo $form->error($model, 'enabled'); ?>
        </div>
      </div>
    </div>

  </div><!--end modal body-->
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
          'htmlOptions' => ['onclick' => 'reportsSystemScriptUpdateVar.save(); update_reportsSystem();'],
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
  </div><!--end modal footer-->
    <?php $this->endWidget(); ?>
</div><!--end modal-->



