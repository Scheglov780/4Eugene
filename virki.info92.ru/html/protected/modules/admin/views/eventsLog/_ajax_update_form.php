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
/** @var EventsLog $model */
?>
<div id='events-log-update-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Update events-log #<?php echo $model->id; ?></h3>
  </div>

  <div class="modal-body">

    <div class="form">
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'events-log-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["events-log/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_eventsLog (); } " /* Do ajax call when user presses enter key */
            ],

          ]
        ); ?>
      <fieldset>
        <legend>
          <p class="note">Fields with <span class="required">*</span> are required.</p>
        </legend>

          <?php echo $form->errorSummary(
            $model,
            'Opps!!!',
            null,
            ['class' => 'alert alert-error span12']
          ); ?>

        <div class="control-group">
          <div class="span4">

              <?php echo $form->hiddenField($model, 'id', []); ?>

            <div class="row">
                <?php echo $form->labelEx($model, 'date'); ?>
                <?php echo $form->textField($model, 'date'); ?>
                <?php echo $form->error($model, 'date'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'uid'); ?>
                <?php echo $form->textField($model, 'uid'); ?>
                <?php echo $form->error($model, 'uid'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'event_name'); ?>
                <?php echo $form->textField(
                  $model,
                  'event_name',
                  ['size' => 60, 'maxlength' => 128]
                ); ?>
                <?php echo $form->error($model, 'event_name'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'subject_id'); ?>
                <?php echo $form->textField($model, 'subject_id'); ?>
                <?php echo $form->error($model, 'subject_id'); ?>
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
            'htmlOptions' => ['onclick' => 'update_eventsLog ();'],
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
    </fieldset>

      <?php $this->endWidget(); ?>

  </div>

</div><!--end modal-->



