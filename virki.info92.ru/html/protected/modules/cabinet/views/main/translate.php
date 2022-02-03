<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="translate.php">
 * </description>
 * Форма онлайн-редактирования переводов
 **********************************************************************************************************************/
?>
<? $qForm = new TranslateForm;
$form = $this->beginWidget(
  'booster.widgets.TbActiveForm',
  [
    'id' => 'translation-form',
    'enableAjaxValidation' => false,
  ]
);
$qForm->host = Yii::app()->request->serverName; //userHost;
if (Yii::app()->user) {
    $qForm->userid = Yii::app()->user->id;
} else {
    $qForm->userid = 0;
}
?>
<? echo $form->hiddenField($qForm, 'id'); ?>
<? echo $form->hiddenField($qForm, 'type'); ?>
<? echo $form->hiddenField($qForm, 'mode'); ?>
<? echo $form->hiddenField($qForm, 'from'); ?>
<? echo $form->hiddenField($qForm, 'to'); ?>
<? echo $form->hiddenField($qForm, 'userid'); ?>
<? echo $form->hiddenField($qForm, 'host'); ?>
<? echo $form->hiddenField($qForm, 'url'); ?>
  <div style="width:100%;">
    <div style="float:left;width:30%;">
        <?php echo $form->labelEx($qForm, 'source'); ?>
        <?php echo $form->textArea($qForm, 'source', ['rows' => 3, 'cols' => 24]); ?>
        <?php echo $form->error($qForm, 'source'); ?>
    </div>
    <div style="float:left;width:30%;">
        <?php echo $form->labelEx($qForm, 'message'); ?>
        <?php echo $form->textArea($qForm, 'message', ['rows' => 3, 'cols' => 24]); ?>
        <?php echo $form->error($qForm, 'message'); ?>
    </div>
  </div>
  <div style="float:left;margin-top: 15px;">
      <?php echo $form->labelEx($qForm, 'global'); ?>
      <?php echo $form->checkBox($qForm, 'global'); ?>
      <?php echo $form->error($qForm, 'global'); ?>
  </div>
  <div style="float:right;margin: 15px; 25px 0 0;">
    <input type="button" class="" value="<?= Yii::t('main', 'Сохранить') ?>" onClick="saveTranslation();">
  </div>
  <div class="clear"></div>
  <hr/>
  <iframe name="translate-bkrs" id="translate-bkrs" width="100%" height="450px"
          src="about:blank" frameborder="0"><?= Yii::t('main', 'Ваш браузер не поддерживает фрэймы...') ?></iframe>

<?php $this->endWidget(); ?>