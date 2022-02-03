<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var News $model */
?>
<div class="modal fade" id="adverts-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование') ?>
            <? //= $model->news_id ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <? /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'adverts-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["adverts/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_adverts (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->hiddenField($model, 'news_id', ['id' => 'adverts_news_id_update']); ?>
        <div class="form-group">
          <div class="col-sm-12">
              <?php echo $form->textArea(
                $model,
                'news_header',
                ['id' => 'adverts_news_header_update', 'class' => 'form-control']
              ); ?>
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-12">
              <?php echo $form->textArea(
                $model,
                'news_body',
                ['id' => 'adverts_news_body_update', 'class' => 'form-control']
              ); ?>
          </div>
        </div>
          <?php echo $form->hiddenField($model, 'news_type', ['id' => 'adverts_news_type_update']); ?>
          <?php
          echo $form->uneditableRow($model, 'news_author_name', ['id' => 'adverts_news_author_update']); ?>
          <?php
          $model->created = Utils::pgDateToStr($model->created);
          echo $form->uneditableRow($model, 'created', ['id' => 'adverts_created_update']); ?>
          <?php
          $model->date_actual_start = Utils::pgDateToStr($model->date_actual_start, 'Y-m-d');
          echo $form->dateFieldRow(
            $model,
            'date_actual_start',
            ['id' => 'adverts_date_actual_start_update']
          ); ?>
          <?php
          $model->date_actual_end = Utils::pgDateToStr($model->date_actual_end, 'Y-m-d');
          echo $form->dateFieldRow(
            $model,
            'date_actual_end',
            ['id' => 'adverts_date_actual_end_update']
          ); ?>
          <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'adverts_recipients_update']); ?>
          <?php echo $form->checkboxRow(
            $model,
            'confirmation_needed',
            ['id' => 'adverts_confirmation_needed_update']
          ); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'absolute_order',
            ['id' => 'adverts_absolute_order_update']
          ); ?>
          <?php echo $form->checkboxRow($model, 'enabled', ['id' => 'adverts_enabled_update']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'adverts_comments_update']); ?>
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
              'htmlOptions' => ['onclick' => 'update_adverts ();'],
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




