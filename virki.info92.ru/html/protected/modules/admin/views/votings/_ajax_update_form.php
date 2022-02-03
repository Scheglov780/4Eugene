<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var Votings $model */
?>
<div class="modal fade" id="votings-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование') ?>
          #<?= $model->votings_id ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'votings-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["votings/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_votings (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->uneditableRow($model, 'votings_id', ['id' => 'votings_votings_id_update']); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_header',
            ['id' => 'votings_votings_header_update']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_query',
            ['id' => 'votings_votings_query_update']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_variants',
            ['id' => 'votings_votings_variants_update']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_summary',
            ['id' => 'votings_votings_summary_update']
          ); ?>
          <?
          $htmlOptions['id'] = 'votings_votings_type_update';
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
          <?php
          echo $form->uneditableRow(
            $model,
            'votings_author_name',
            ['id' => 'votings_votings_author_update']
          ); ?>
          <?php
          $model->created = Utils::pgDateToStr($model->created);
          echo $form->uneditableRow($model, 'created', ['id' => 'votings_created_update']); ?>
          <?php
          $model->date_actual_start = Utils::pgDateToStr($model->date_actual_start, 'Y-m-d');
          echo $form->dateFieldRow(
            $model,
            'date_actual_start',
            ['id' => 'votings_date_actual_start_update']
          ); ?>
          <?php
          $model->date_actual_end = Utils::pgDateToStr($model->date_actual_end, 'Y-m-d');
          echo $form->dateFieldRow(
            $model,
            'date_actual_end',
            ['id' => 'votings_date_actual_end_update']
          ); ?>
          <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'votings_recipients_update']); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'votings_enabled_update']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'votings_comments_update']); ?>
      </div>
      <div class="modal-footer">
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size' => 'mini',
              'icon'        => 'fa fa-check',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'update_votings ();'],
            ]
          );
          ?>
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size' => 'mini',
              'icon'        => 'fa fa-close',
              'label'       => Yii::t('main', 'Отмена'),
              'htmlOptions' => ['data-dismiss' => 'modal'],
            ]
          ); ?>
          <?php $this->widget(
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




