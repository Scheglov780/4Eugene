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
<div class="modal fade" id="pools-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование') ?>
            <? //= $model->votings_id ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'pools-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["pools/update"],
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
          <?php echo $form->hiddenField($model, 'votings_id', ['id' => 'pools_votings_id_update']); ?>
        <div class="form-group">
          <div class="col-sm-12">
              <?php echo $form->textArea(
                $model,
                'votings_header',
                ['id' => 'pools_votings_header_update', 'class' => 'form-control']
              ); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              <?php echo $form->textArea(
                $model,
                'votings_query',
                ['id' => 'pools_votings_query_update', 'class' => 'form-control']
              ); ?>
          </div>
        </div>
          <?php
          echo $form->textAreaRow(
            $model,
            'votings_variants',
            ['id' => 'pools_votings_variants_update']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'votings_summary',
            ['id' => 'pools_votings_summary_update']
          ); ?>
          <?
          /*
63	NEWS_TYPE	Новость
64	NEWS_TYPE	Оповещение
65	NEWS_TYPE	Объявление
66	VOTING_TYPE	Голосование
67	VOTING_TYPE	Опрос
*/
          echo $form->hiddenField($model, 'votings_type', ['id' => 'pools_votings_type_update']);
          ?>
          <?php
          echo $form->uneditableRow(
            $model,
            'votings_author_name',
            ['id' => 'pools_votings_author_update']
          ); ?>
          <?php
          $model->created = Utils::pgDateToStr($model->created);
          echo $form->uneditableRow($model, 'created', ['id' => 'pools_created_update']); ?>
          <?php
          $model->date_actual_start = Utils::pgDateToStr($model->date_actual_start, 'Y-m-d');
          echo $form->dateFieldRow(
            $model,
            'date_actual_start',
            ['id' => 'pools_date_actual_start_update']
          ); ?>
          <?php
          $model->date_actual_end = Utils::pgDateToStr($model->date_actual_end, 'Y-m-d');
          echo $form->dateFieldRow(
            $model,
            'date_actual_end',
            ['id' => 'pools_date_actual_end_update']
          ); ?>
          <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'pools_recipients_update']); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'pools_enabled_update']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'pools_comments_update']); ?>
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
              'htmlOptions' => ['onclick' => 'update_pools ();'],
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




