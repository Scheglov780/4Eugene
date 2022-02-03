<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?><? /** @var Votings $model */
?>
<div class="modal fade" id="votings-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание голосования') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'votings-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["votings/create"],
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
            create_votings();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_header',
            ['id' => 'votings_votings_header_create']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_query',
            ['id' => 'votings_votings_query_create']
          ); ?>
          <?php
          $model->votings_variants = DSConfig::getVal('votings_default_params');
          echo $form->textAreaRow(
            $model,
            'votings_variants',
            ['id' => 'votings_votings_variants_create']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_summary',
            ['id' => 'votings_votings_summary_create']
          ); ?>
          <?
          $htmlOptions['id'] = 'votings_votings_type_create';
          echo $form->dropDownListRow(
            $model,
            'votings_type',
            [
              'widgetOptions' => [
                'data'        => DicCustom::getVals('VOTING_TYPE'),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->dateFieldRow(
            $model,
            'date_actual_start',
            ['id' => 'votings_date_actual_start_create']
          ); ?>
          <?php echo $form->dateFieldRow(
            $model,
            'date_actual_end',
            ['id' => 'votings_date_actual_end_create']
          ); ?>
          <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'votings_recipients_create']); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'votings_enabled_create']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'votings_comments_create']); ?>
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
              'htmlOptions' => ['onclick' => 'create_votings();'],
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
    function create_votings() {
        var instance = CKEDITOR.instances['votings_votings_query_create'];
        if (instance) {
            instance.updateElement();
        }
        var data = $('#votings-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/votings/create'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#votings-create-modal').modal('hide');
                    $.fn.yiiGridView.update('votings-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_votings() {
        var instance = CKEDITOR.instances['votings_votings_query_create'];
        if (instance) {
            instance.destroy(true);
        }
        $('#votings-create-form').each(function () {
            this.reset();
        });
        CKEDITOR.replace('votings_votings_query_create');
        $('#votings-create-modal').modal('show');
    }

</script>
