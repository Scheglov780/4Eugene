<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var EventsLog $model */
?>
<div id='events-log-create-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Create events-log</h3>
  </div>

  <div class="modal-body">

    <div class="form">

        <?php

        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'events-log-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["events-log/create"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_eventsLog ();
                                        }
                                     }',

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
            'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
            'htmlOptions' => ['onclick' => 'create_eventsLog ();'],
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
    </fieldset>

      <?php
      $this->endWidget(); ?>

  </div>

</div><!--end modal-->

<script type="text/javascript">
    function create_eventsLog() {

        var data = $('#events-log-create-form').serialize();


        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/events-log/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#events-log-create-modal').modal('hide');
                    $.fn.yiiGridView.update('events-log-grid', {});

                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderCreateForm_eventsLog() {
        $('#events-log-create-form').each(function () {
            this.reset();
        });
        $('#events-log-create-modal').modal('show');
    }

</script>
