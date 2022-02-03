<div id='scheduled-jobs-update-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">

    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Update scheduled-jobs #<?php echo $model->id; ?></h3>
  </div>

  <div class="modal-body">

    <div class="form">
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'scheduled-jobs-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["scheduled-jobs/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_scheduledJobs (); } " /* Do ajax call when user presses enter key */
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
                <?php echo $form->labelEx($model, 'job_script'); ?>
                <?php echo $form->textArea($model, 'job_script', ['rows' => 6, 'cols' => 50]); ?>
                <?php echo $form->error($model, 'job_script'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'job_start_time'); ?>
                <?php echo $form->textField($model, 'job_start_time'); ?>
                <?php echo $form->error($model, 'job_start_time'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'job_stop_time'); ?>
                <?php echo $form->textField($model, 'job_stop_time'); ?>
                <?php echo $form->error($model, 'job_stop_time'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'job_interval'); ?>
                <?php echo $form->textField(
                  $model,
                  'job_interval',
                  ['size' => 20, 'maxlength' => 20]
                ); ?>
                <?php echo $form->error($model, 'job_interval'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'job_description'); ?>
                <?php echo $form->textArea($model, 'job_description', ['rows' => 6, 'cols' => 50]); ?>
                <?php echo $form->error($model, 'job_description'); ?>
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
            'htmlOptions' => ['onclick' => 'update_scheduledJobs ();'],
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



