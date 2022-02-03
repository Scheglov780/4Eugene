<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?>

<? /** @var Votings $model */
?>
<div class="modal fade" id="pools-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новый опрос') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'pools-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["pools/create"],
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
            create_pools();
            }
            }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
        <div class="form-group">
          <div class="col-sm-12">
              <?php echo $form->textArea(
                $model,
                'votings_header',
                ['id' => 'pools_votings_header_create', 'class' => 'form-control']
              ); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              <?php echo $form->textArea(
                $model,
                'votings_query',
                ['id' => 'pools_votings_query_create', 'class' => 'form-control']
              ); ?>
          </div>
        </div>
          <?php
          $model->votings_variants = DSConfig::getVal('votings_default_params');
          echo $form->textAreaRow(
            $model,
            'votings_variants',
            ['id' => 'pools_votings_variants_create']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_summary',
            ['id' => 'pools_votings_summary_create']
          ); ?>
          <?
          /*
63	NEWS_TYPE	Новость
64	NEWS_TYPE	Оповещение
65	NEWS_TYPE	Объявление
66	VOTING_TYPE	Голосование
67	VOTING_TYPE	Опрос
           */
          $model->votings_type = 67;
          echo $form->hiddenField($model, 'votings_type', ['id' => 'pools_votings_type_create']);
          ?>
          <?php echo $form->dateFieldRow(
            $model,
            'date_actual_start',
            ['id' => 'pools_date_actual_start_create']
          ); ?>
          <?php echo $form->dateFieldRow(
            $model,
            'date_actual_end',
            ['id' => 'pools_date_actual_end_create']
          ); ?>
          <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'pools_recipients_create']); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'pools_enabled_create']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'pools_comments_create']); ?>
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
              'htmlOptions' => ['onclick' => 'create_pools();'],
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
    function create_pools() {
        var instance = CKEDITOR.instances['pools_votings_query_create'];
        if (instance) {
            instance.updateElement();
        }
        var data = $('#pools-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/pools/create'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#pools-create-modal').modal('hide');
                    $.fn.yiiListView.update('cabinet-pools-list-view', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_pools() {
        var instance = CKEDITOR.instances['pools_votings_query_create'];
        if (instance) {
            instance.destroy(true);
        }
        $('#pools-create-form').each(function () {
            this.reset();
        });
        CKEDITOR.replace('pools_votings_query_create');
        $('#pools-create-modal').modal('show');
    }

</script>
