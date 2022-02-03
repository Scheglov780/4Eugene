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
/** @var Events $model */
?>
<div class="modal fade" id="events-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Cобытие ') ?> #<?php echo $model->id; ?></h4>
        <div>
            <?php
            /** @var TbActiveForm $form */
            $form = $this->beginWidget(
              'booster.widgets.TbActiveForm',
              [
                'id'                     => 'events-update-form',
                'enableAjaxValidation'   => false,
                'enableClientValidation' => false,
                'method'                 => 'post',
                'action'                 => ["events/update"],
                'type'                   => 'horizontal',
                'htmlOptions'            => [
                  'onsubmit' => "return false;",
                    /* Disable normal form submit */
                    //'onkeypress'=>" if(event.keyCode == 13){ update_events (); } " /* Do ajax call when user presses enter key */
                ],
              ]
            ); ?>
          <div class="modal-body">
              <?php echo $form->errorSummary($model); ?>
              <?php echo $form->hiddenField($model, 'id'); ?>
              <?php echo $form->textFieldRow($model, 'event_name'); ?>
              <?php echo $form->textFieldRow($model, 'enabled'); ?>
              <?php echo $form->textAreaRow($model, 'event_descr'); ?>
              <?php echo $form->textAreaRow($model, 'event_rules', ['id' => 'eventsRulesUpdate']); ?>
            <script>
                if (eventsRulesUpdateVar != undefined) {
                    eventsRulesUpdateVar.toTextArea();
                }
                var eventsRulesUpdateVar = CodeMirror.fromTextArea(
                    document.getElementById('eventsRulesUpdate')
                    , {
                        //lineNumbers: true,
                        mode: 'text/x-mariadb',//'application/x-httpd-php',//'htmlmixed',//'text/html',
                        matchBrackets: true,
                    });
                eventsRulesUpdateVar.setSize(null, 70);
                eventsRulesUpdateVar.refresh();
            </script>
              <?php echo $form->textAreaRow($model, 'event_action', ['id' => 'eventsActionUpdate']); ?>
            <script>
                if (eventsActionUpdateVar != undefined) {
                    eventsActionUpdateVar.toTextArea();
                }
                var eventsActionUpdateVar = CodeMirror.fromTextArea(
                    document.getElementById('eventsActionUpdate')
                    , {
                        //lineNumbers: true,
                        mode: 'text/x-mariadb',//'application/x-httpd-php',//'htmlmixed',//'text/html',
                        matchBrackets: true,
                    });
                eventsActionUpdateVar.setSize(null, 150);
                eventsActionUpdateVar.refresh();
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
                  'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
                  'htmlOptions' => ['onclick' => 'eventsActionUpdateVar.save();eventsRulesUpdateVar.save(); update_events ();'],
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




