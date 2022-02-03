<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?><? /** @var News $model */
?>
<div class="modal fade" id="news-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание записи') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'news-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["news/create"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
            if (!hasError)
            {
            create_news();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textAreaRow($model, 'news_header', ['id' => 'news_news_header_create']); ?>
          <?php echo $form->textAreaRow($model, 'news_body', ['id' => 'news_news_body_create']); ?>
          <?
          $htmlOptions['id'] = 'news_news_type_create';
          echo $form->dropDownListRow(
            $model,
            'news_type',
            [
              'widgetOptions' => [
                'data'        => DicCustom::getVals('NEWS_TYPE'),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->dateFieldRow(
            $model,
            'date_actual_start',
            ['id' => 'news_date_actual_start_create']
          ); ?>
          <?php echo $form->dateFieldRow(
            $model,
            'date_actual_end',
            ['id' => 'news_date_actual_end_create']
          ); ?>
          <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'news_recipients_create']); ?>
          <?php echo $form->checkBoxRow(
            $model,
            'confirmation_needed',
            ['id' => 'news_confirmation_needed_create']
          ); ?>
          <?php echo $form->numberFieldRow($model, 'absolute_order', ['id' => 'news_absolute_order_create']); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'news_enabled_create']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'news_comments_create']); ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size'=>'mini',
              'icon'        => 'fa fa-check',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'create_news();'],
            ]
          );
          ?>
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
              'icon'        => 'fa fa-close',
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
        <?php
        $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function create_news() {
        var instance = CKEDITOR.instances['news_news_body_create'];
        if (instance) {
            instance.updateElement();
        }
        var data = $('#news-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/news/create'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#news-create-modal').modal('hide');
                    $.fn.yiiGridView.update('news-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_news() {
        var instance = CKEDITOR.instances['news_news_body_create'];
        if (instance) {
            instance.destroy(true);
        }
        $('#news-create-form').each(function () {
            this.reset();
        });
        /* if (typeof CKEDITOR != 'undefined') {
            for (var instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].destroy(true);
            }
        }
        */
        CKEDITOR.replace('news_news_body_create');
        $('#news-create-modal').modal('show');
    }

</script>
