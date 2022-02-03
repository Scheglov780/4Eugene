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
/** @var Banners $model */
?>
<div class="modal fade" id="banners-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новый баннер') ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'banners-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["banners/create"],
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
                                          create_banners ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php
          $model->href = '#';
          $model->front_theme = DSConfig::getVal('site_front_theme');
          echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'front_theme'); ?>
          <?php echo $form->numberFieldRow($model, 'banner_order'); ?>
          <?php echo $form->checkboxRow($model, 'enabled'); ?>
          <?php echo $form->textAreaRow($model, 'html_content', ['id' => 'bannerUpdateHTMLEditorCreate']); ?>
        <script>
            if (bannerUpdateHTMLEditorCreateVar != undefined) {
                bannerUpdateHTMLEditorCreateVar.toTextArea();
            }
            var bannerUpdateHTMLEditorCreateVar = CodeMirror.fromTextArea(
                //$('#bannerUpdateHTMLEditor')
                document.getElementById('bannerUpdateHTMLEditorCreate')
                , {
                    //lineNumbers: true,
                    mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true
                });
            bannerUpdateHTMLEditorCreateVar.setSize(null, 100);
            bannerUpdateHTMLEditorCreateVar.refresh();
        </script>
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
              'htmlOptions' => ['onclick' => 'bannerUpdateHTMLEditorCreateVar.save(); create_banners ();'],
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
    function create_banners() {
        var data = $('#banners-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/banners/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#banners-create-modal').modal('hide');
                    $.fn.yiiGridView.update('banners-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateForm_banners() {
        $('#banners-create-form').each(function () {
            this.reset();
        });
        $('#banners-create-modal').modal('show');
    }
</script>
