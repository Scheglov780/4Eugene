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
/** @var CmsEmailEvents $model */
?>
<div class="modal fade" id="cms-email-events-create-modal" tabindex="-1" role="dialog">
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
            'id'                     => 'cms-email-events-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["cmsEmailEvents/create"],
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
                                          create_cmsEmailEvents ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
        <div class="box">
          <div class="box-body">
              <?php echo $form->errorSummary($model); ?>
            <div class="nav-tabs-custom" id="cmsEmailEvents-create-tabs">
              <ul class="nav nav-tabs">
                <li class="active"><a href="#cmsEmailEvents-create-tabs-template"
                                      data-toggle="tab"><? echo $form->labelEx($model, 'template'); ?></a></li>
                <li><a href="#cmsEmailEvents-create-tabs-template-sms"
                       data-toggle="tab"><? echo $form->labelEx($model, 'template_sms'); ?></a></li>
              </ul>
              <div class="tab-content">
                <div class="active tab-pane" id="cmsEmailEvents-create-tabs-template">
                  <div class="form-group">
                      <?php
                      //TODO Тут какая-то лабуда и после повторного вызова модалки редакторы показываются по 2, 3 и т.п. раз
                      echo $form->textArea(
                        $model,
                        'template',
                        ['id' => 'cmsEmailEventsTemplateCreate', 'class' => 'form-control']
                      ); ?>
                  </div>
                  <script>
                      if (cmsEmailEventsTemplateCreateVar != undefined) {
                          cmsEmailEventsTemplateCreateVar.toTextArea();
                      }
                      var cmsEmailEventsTemplateCreateVar = CodeMirror.fromTextArea(
                          document.getElementById('cmsEmailEventsTemplateCreate')
                          , {
                              //lineNumbers: true,
                              mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                              matchBrackets: true,
                          });
                      cmsEmailEventsTemplateCreateVar.setSize(null, 200);
                      cmsEmailEventsTemplateCreateVar.refresh();
                  </script>
                </div>
                <div class="tab-pane" id="cmsEmailEvents-create-tabs-template-sms">
                  <div class="form-group">
                      <?php echo $form->textArea(
                        $model,
                        'template_sms',
                        ['id' => 'cmsEmailEventsTemplateCreateSms', 'class' => 'form-control']
                      ); ?>
                  </div>
                  <script>
                      if (cmsEmailEventsTemplateCreateSmsVar != undefined) {
                          cmsEmailEventsTemplateCreateSmsVar.toTextArea();
                      }
                      var cmsEmailEventsTemplateCreateSmsVar = CodeMirror.fromTextArea(
                          document.getElementById('cmsEmailEventsTemplateCreateSms')
                          , {
                              //lineNumbers: true,
                              mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                              matchBrackets: true,
                          });
                      cmsEmailEventsTemplateCreateSmsVar.setSize(null, 200);
                      cmsEmailEventsTemplateCreateSmsVar.refresh();
                  </script>
                </div>
              </div>
            </div>
            <script>
                /*
                $(function () {
                    $("#cmsEmailEvents-create-tabs").tabs({
                        activate: function (event, ui) {
                            if (ui.newPanel.attr('id') === 'cmsEmailEvents-create-tabs-template-sms') {
                                cmsEmailEventsTemplateCreateSmsVar.refresh();
                            }
                            }
                        }
                    );
                });
                 */
            </script>
              <?
              $layouts =
                Yii::app()->db->createCommand(
                  "select cc.content_id from cms_custom_content cc where cc.content_id like 'email:%' and cc.enabled = 1"
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
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'cmsEmailEventsTemplateCreateSmsVar.save(); cmsEmailEventsTemplateCreateVar.save(); create_cmsEmailEvents ();'],
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
<!--Script section-->
<script type="text/javascript">
    function create_cmsEmailEvents() {
        var data = $('#cms-email-events-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/cmsEmailEvents/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#cms-email-events-create-modal').modal('hide');
                    $.fn.yiiGridView.update('cms-email-events-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateForm_cmsEmailEvents() {
        $('#cms-email-events-create-form').each(function () {
            this.reset();
        });
        $('#cms-email-events-create-modal').modal('show');
    }
</script>
