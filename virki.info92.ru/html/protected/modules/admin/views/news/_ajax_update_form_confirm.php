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
/** @var newsConfirmationForm $model */
?>
<div class="modal fade" id="news-confirm-update-modal-<?= $model->news_id ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование подтверждения прочтения') ?>
            <?= $model->news_id; ?><?= Utils::getHelp('updateConfirm', true) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'news-confirm-update-form-' . $model->news_id,
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["news/updateConfirm"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_devices (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php
          //news_confirmations_id,news_id,uid,created,result
          echo $form->hiddenField($model, 'news_confirmations_id');
          echo $form->uneditableRow(
            $model,
            'news_id',
            ['id' => 'news_confirm_update_news_id_' . $model->news_id]
          );
          $htmlOptions['id'] = 'news_confirm_update_uid_' . $model->news_id;
          echo $form->dropDownListRow(
            $model,
            'uid',
            [
              'widgetOptions' => [
                'data'        => Users::getListData(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          );
          ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
              'icon'        => 'fa fa-check', // fa-inverse
              'label'       => Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => "update_news_confirm_{$model->news_id} ();"],
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
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




