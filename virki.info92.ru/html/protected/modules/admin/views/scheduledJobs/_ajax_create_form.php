<div id='scheduled-jobs-create-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Create scheduled-jobs</h3>
  </div>

  <div class="modal-body">

    <div class="form">

        <?php

        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'scheduled-jobs-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["scheduled-jobs/create"],
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
                                          create_scheduledJobs ();
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
            'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
            'htmlOptions' => ['onclick' => 'create_scheduledJobs ();'],
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
    function create_scheduledJobs() {

        var data = $('#scheduled-jobs-create-form').serialize();


        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/scheduled-jobs/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#scheduled-jobs-create-modal').modal('hide');
                    $.fn.yiiGridView.update('scheduled-jobs-grid', {});

                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderCreateForm_scheduledJobs() {
        $('#scheduled-jobs-create-form').each(function () {
            this.reset();
        });
        $('#scheduled-jobs-create-modal').modal('show');
    }

</script>
