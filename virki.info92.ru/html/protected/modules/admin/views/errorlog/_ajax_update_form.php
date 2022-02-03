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
/** @var CActiveRecord $model */
?>
<div id='log-site-errors-update-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3><?= Yii::t('main', 'Ошибка') ?> <strong style="color:#0093f5;">#<?php echo $model->id; ?></strong></h3>
  </div>
  <div class="modal-body">
    <div class="form">
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'log-site-errors-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["errorlog/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_errorlog (); } " /* Do ajax call when user presses enter key */
            ],
          ]
        ); ?>
      <h6><?= Yii::t('main', 'Поля обозначенные ') ?><span class="required">*&nbsp;</span><?= Yii::t(
            'main',
            'обязательны для заполнения'
          ) ?></h6>
        <?php echo $form->errorSummary($model, 'Opps!!!', null, ['class' => 'alert alert-error span12']); ?>
      <div class="row-fluid">
        <div class="span4">
            <?php echo $form->hiddenField($model, 'id', []); ?>
            <?php echo $form->labelEx($model, 'error_message'); ?>
            <?php echo $form->textField(
              $model,
              'error_message',
              ['class' => 'span12', 'maxlength' => 4000]
            ); ?>
            <?php echo $form->error($model, 'error_message'); ?>
        </div>
        <div class="span4">
            <?php echo $form->labelEx($model, 'error_label'); ?>
            <?php echo $form->textField(
              $model,
              'error_label',
              ['class' => 'span12', 'maxlength' => 4000]
            ); ?>
            <?php echo $form->error($model, 'error_label'); ?>
        </div>
        <div class="span4">
            <?php echo $form->labelEx($model, 'error_date'); ?>
            <?php echo $form->textField($model, 'error_date', ['class' => 'span12']); ?>
            <?php echo $form->error($model, 'error_date'); ?>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span6">
            <?php echo $form->labelEx($model, 'error_description'); ?>
            <?php echo $form->textArea(
              $model,
              'error_description',
              ['rows' => 20, 'class' => 'span12']
            ); ?>
            <?php echo $form->error($model, 'error_description'); ?>
        </div>
        <div class="span6">
            <?php echo $form->labelEx($model, 'error_request'); ?>
            <?php echo $form->textArea($model, 'error_request', ['rows' => 20, 'class' => 'span12']); ?>
            <?php echo $form->error($model, 'error_request'); ?>
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
            'htmlOptions' => ['onclick' => 'update_errorlog ();'],
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
  </div>
</div><!--end modal-->



