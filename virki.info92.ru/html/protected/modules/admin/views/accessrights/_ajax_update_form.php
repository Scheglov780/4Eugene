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
/** @var AccessRights $model */
?>
<div class="modal fade" id="accessrights-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Изменение роли') ?> #<?php echo $model->role; ?></h4>
      </div>

        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'accessrights-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["accessrights/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                // 'onkeypress'=>" if(event.keyCode == 13){ update_accessrights (); } " /* Do ajax call when user presses enter key */
            ],

          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->hiddenField($model, 'role'); ?>
          <?php echo $form->textFieldRow($model, 'role'); ?>
          <?php echo $form->textAreaRow($model, 'description'); ?>
          <?php echo $form->textAreaRow($model, 'allow'); ?>
          <?php echo $form->textAreaRow($model, 'deny'); ?>
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
              'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'update_accessrights ();'],
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
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




