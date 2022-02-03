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
/** @var Events $model */
?>
<div class="modal fade" id="events-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новое событие') ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'events-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["events/create"],
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
                                          create_events ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'event_name'); ?>
          <?php echo $form->textFieldRow($model, 'enabled'); ?>
          <?php echo $form->textAreaRow($model, 'event_descr'); ?>
          <?php echo $form->textAreaRow($model, 'event_rules', ['id' => 'eventsRulesCreate']); ?>
        <script>
            if (eventsRulesCreateVar != undefined) {
                eventsRulesCreateVar.toTextArea();
            }
            var eventsRulesCreateVar = CodeMirror.fromTextArea(
                document.getElementById('eventsRulesCreate')
                , {
                    //lineNumbers: true,
                    mode: 'text/x-mariadb',//'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            eventsRulesCreateVar.setSize(null, 70);
            eventsRulesCreateVar.refresh();
        </script>
          <?php echo $form->textAreaRow(
            $model,
            'event_action',
            ['id' => 'eventsActionCreate', 'class' => 'span12', 'rows' => 6, 'cols' => 50]
          ); ?>
        <script>
            if (eventsActionCreateVar != undefined) {
                eventsActionCreateVar.toTextArea();
            }
            var eventsActionCreateVar = CodeMirror.fromTextArea(
                document.getElementById('eventsActionCreate')
                , {
                    //lineNumbers: true,
                    mode: 'text/x-mariadb',//'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            eventsActionCreateVar.setSize(null, 150);
            eventsActionCreateVar.refresh();
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
              'htmlOptions' => ['onclick' => 'eventsActionCreateVar.save();eventsRulesCreateVar.save(); create_events ();'],
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
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script type="text/javascript">
    function create_events() {
        var data = $('#events-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/events/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#events-create-modal').modal('hide');
                    $.fn.yiiGridView.update('events-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateForm_events() {
        $('#events-create-form').each(function () {
            this.reset();
        });
        $('#events-create-modal').modal('show');
    }
</script>
