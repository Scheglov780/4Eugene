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
/** @var CmsEmailEvents $model */
?>
<div class="modal fade" id="cms-email-events-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Изменение события') ?> #<?php echo $model->id; ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'cms-email-events-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["cmsEmailEvents/update"],
            'type'                   => 'vertical',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_cmsEmailEvents (); } " /* Do ajax call when user presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
        <div class="box">
          <div class="box-body">
              <?php echo $form->errorSummary($model); ?>
              <?php echo $form->hiddenField($model, 'id'); ?>
            <div class="nav-tabs-custom" id="cmsEmailEvents-update-tabs">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#cmsEmailEvents-update-tabs-template"
                                      data-toggle="tab"><? echo $form->labelEx(
                          $model,
                          'template'
                        ); ?></a></li>
                <li><a href="#cmsEmailEvents-update-tabs-template-sms"
                       data-toggle="tab"><? echo $form->labelEx($model, 'template_sms'); ?></a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="cmsEmailEvents-update-tabs-template">
                  <div class="form-group">
                      <?php
                      //TODO Тут какая-то лабуда и после повторного вызова модалки редакторы показываются по 2, 3 и т.п. раз
                      echo $form->textArea(
                        $model,
                        'template',
                        ['id' => 'cmsEmailEventsTemplateUpdate', 'class' => 'form-control']
                      ); ?>
                  </div>
                  <script>
                      if (cmsEmailEventsTemplateUpdateVar != undefined) {
                          cmsEmailEventsTemplateUpdateVar.toTextArea();
                      }
                      var cmsEmailEventsTemplateUpdateVar = CodeMirror.fromTextArea(
                          document.getElementById('cmsEmailEventsTemplateUpdate')
                          , {
                              //lineNumbers: true,
                              mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                              matchBrackets: true,
                          });
                      cmsEmailEventsTemplateUpdateVar.setSize(null, 200);
                      cmsEmailEventsTemplateUpdateVar.refresh();
                  </script>
                </div>
                <div class="tab-pane" id="cmsEmailEvents-update-tabs-template-sms">
                  <div class="form-group">
                      <?php echo $form->textArea(
                        $model,
                        'template_sms',
                        ['id' => 'cmsEmailEventsTemplateUpdateSms', 'class' => 'form-control']
                      ); ?>
                  </div>
                  <script>
                      if (cmsEmailEventsTemplateUpdateSmsVar != undefined) {
                          cmsEmailEventsTemplateUpdateSmsVar.toTextArea();
                      }
                      var cmsEmailEventsTemplateUpdateSmsVar = CodeMirror.fromTextArea(
                          document.getElementById('cmsEmailEventsTemplateUpdateSms')
                          , {
                              //lineNumbers: true,
                              mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                              matchBrackets: true,
                          });
                      cmsEmailEventsTemplateUpdateSmsVar.setSize(null, 200);
                      cmsEmailEventsTemplateUpdateSmsVar.refresh();
                  </script>
                </div>
              </div>
            </div>
            <script>
                /*
            $('#cmsEmailEvents-update-tabs').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                cmsEmailEventsTemplateUpdateVar.refresh();
                cmsEmailEventsTemplateUpdateSmsVar.refresh();
            })
                 */
            </script>
              <? /*
                <script>
                    $(function () {
                        $("#cmsEmailEvents-update-tabs").tabs({
                            activate: function (event, ui) {
                                if (ui.newPanel.attr('id') === 'cmsEmailEvents-update-tabs-template-sms') {
                                    cmsEmailEventsTemplateUpdateSmsVar.refresh();
                                }
                                }
                            }
                        );
                    });
                </script>
*/ ?>
              <?
              $layouts = Yii::app()->db->createCommand(
                "SELECT cc.content_id FROM cms_custom_content cc WHERE cc.content_id LIKE 'email:%' AND cc.enabled = 1"
              )
                ->queryColumn();
              $layoutList = ['' => Yii::t('main', 'нет')];
              if ($layouts) {
                  foreach ($layouts as $layout) {
                      $layoutList[$layout] = $layout;
                  }
              }
              ?>
              <?php echo $form->dropDownListRow(
                $model,
                'layout',
                [
                  'widgetOptions' => [
                    'data' => $layoutList,
                      //'htmlOptions' => $htmlOptions
                  ],
                ]
              );
              ?>
              <?php echo $form->textFieldRow($model, 'class'); ?>
              <?php echo $form->textFieldRow($model, 'action'); ?>
              <?php echo $form->textAreaRow($model, 'condition'); ?>
              <?php echo $form->textAreaRow($model, 'relevant_fields'); ?>
              <?php echo $form->textAreaRow($model, 'recipients'); ?>
              <?php echo $form->textAreaRow($model, 'tests'); ?>
              <?php echo $form->checkboxRow($model, 'regular'); ?>
              <?php echo $form->checkboxRow($model, 'enabled'); ?>
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
              'htmlOptions' => ['onclick' => ' cmsEmailEventsTemplateUpdateSmsVar.save(); cmsEmailEventsTemplateUpdateVar.save(); update_cmsEmailEvents ();'],
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