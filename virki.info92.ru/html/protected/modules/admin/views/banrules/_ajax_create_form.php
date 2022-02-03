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
/** @var Banrules $model */
?>
<div class="modal fade" id="banrules-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новое условие'); ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'banrules-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["banrules/create"],
            'type'                   => 'vertical',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_banrules ();
                                        }
                                     }',
            ],

          ]
        ); ?>
      <div class="modal-body">
        <div class="box">
          <div class="box-body">
              <?php echo $form->errorSummary($model); ?>
              <?php echo $form->textAreaRow($model, 'description'); ?>
              <?php echo $form->textFieldRow($model, 'request_rule'); ?>
            <script>
                if (banRulesCreateVar != undefined) {
                    banRulesCreateVar.toTextArea();
                }
                var banRulesCreateVar = CodeMirror.fromTextArea(
                    document.getElementById('banRulesCreate')
                    , {
                        //lineNumbers: true,
                        mode: 'text/x-c++src',//'application/x-httpd-php',//'htmlmixed',//'text/html',
                        matchBrackets: true,
                    });
                banRulesCreateVar.setSize(null, 100);
                banRulesCreateVar.refresh();
            </script>
              <?php echo $form->textFieldRow($model, 'rule_order'); ?>
              <?php echo $form->checkboxRow($model, 'enabled'); ?>
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
                  'htmlOptions' => ['onclick' => 'banRulesCreateVar.save(); create_banrules ();'],
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
      </div>
    </div>
    <!--Script section-->
    <script type="text/javascript">
        function create_banrules() {
            var data = $('#banrules-create-form').serialize();
            jQuery.ajax({
                type: 'POST',
                url: '<?php
                  echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/banrules/create"); ?>',
                data: data,
                success: function (data) {
                    //alert("succes:"+data);
                    if (data !== 'false') {
                        $('#banrules-create-modal').modal('hide');
                        $.fn.yiiGridView.update('banrules-grid', {});
                    }
                },
                error: function (data) { // if error occured
                    dsAlert(JSON.stringify(data), 'Error', true);
                },
                dataType: 'html'
            });
        }

        function renderCreateForm_banrules() {
            $('#banrules-create-form').each(function () {
                this.reset();
            });
            $('#banrules-create-modal').modal('show');
        }
    </script>
