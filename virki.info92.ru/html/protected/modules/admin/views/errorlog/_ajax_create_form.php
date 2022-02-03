<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://market.info92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var CActiveRecord $model */
?>
<div id='log-site-errors-create-modal' class="modal hide" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3>Create log site error</h3>
  </div>

  <div class="modal-body">

    <div class="form">

        <?php

        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'log-site-errors-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["errorlog/create"],
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
                                          create_errorlog ();
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
                <?php echo $form->labelEx($model, 'error_message'); ?>
                <?php echo $form->textField(
                  $model,
                  'error_message',
                  ['size' => 60, 'maxlength' => 4000]
                ); ?>
                <?php echo $form->error($model, 'error_message'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'error_description'); ?>
                <?php echo $form->textArea(
                  $model,
                  'error_description',
                  ['rows' => 6, 'cols' => 50]
                ); ?>
                <?php echo $form->error($model, 'error_description'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'error_label'); ?>
                <?php echo $form->textField(
                  $model,
                  'error_label',
                  ['size' => 60, 'maxlength' => 4000]
                ); ?>
                <?php echo $form->error($model, 'error_label'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'error_date'); ?>
                <?php echo $form->textField($model, 'error_date'); ?>
                <?php echo $form->error($model, 'error_date'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($model, 'error_request'); ?>
                <?php echo $form->textArea($model, 'error_request', ['rows' => 6, 'cols' => 50]); ?>
                <?php echo $form->error($model, 'error_request'); ?>
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
            'label'       => $model->isNewRecord ? Yii::t('admin', 'Добавить') : Yii::t('admin', 'Сохранить'),
            'htmlOptions' => ['onclick' => 'create_errorlog ();'],
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
            'label'       => Yii::t('admin', 'Отмена'),
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
            'label'       => Yii::t('admin', 'Сброс'),
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
    function create_errorlog() {

        var data = $('#log-site-errors-create-form').serialize();


        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/errorlog/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#log-site-errors-create-modal').modal('hide');
                    $.fn.yiiGridView.update('log-site-errors-grid', {});

                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderCreateForm_errorlog() {
        $('#log-site-errors-create-form').each(function () {
            this.reset();
        });
        $('#log-site-errors-create-modal').modal('show');
    }

</script>
