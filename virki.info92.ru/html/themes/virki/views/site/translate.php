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
<?= $form->hiddenField($qForm, 'id'); ?>
<?= $form->hiddenField($qForm, 'type'); ?>
<?= $form->hiddenField($qForm, 'mode'); ?>
<?= $form->hiddenField($qForm, 'from'); ?>
<?= $form->hiddenField($qForm, 'to'); ?>
<?= $form->hiddenField($qForm, 'userid'); ?>
<?= $form->hiddenField($qForm, 'host'); ?>
<?= $form->hiddenField($qForm, 'url'); ?>
<div class="row">
  <div class="col-md-6">
      <?= $form->labelEx($qForm, 'source'); ?>
      <?= $form->textArea($qForm, 'source', ['rows' => 1, 'cols' => 36]); ?>
      <?= $form->error($qForm, 'source'); ?>
  </div>
  <div class="col-md-6">
      <?= $form->labelEx($qForm, 'message'); ?>
      <?= $form->textArea($qForm, 'message', ['rows' => 1, 'cols' => 32]); ?>
      <?= $form->error($qForm, 'message'); ?>
  </div>
</div>
<div class="row"></div>
<div class="row">
  <div class="col-md-6">
      <?= $form->labelEx($qForm, 'global'); ?>
      <?= $form->checkBox(
        $qForm,
        'global',
        [
          'data-toggle' => 'tooltip',
          'title'       => Yii::t('main', 'Изменить все вхождения перевода в любых контекстах'),
          'style'       => 'position:relative;top:20px',
        ]
      ); ?>
      <?= $form->error($qForm, 'global'); ?>
      <? /*
        </div>
        <div class="col-md-4">
        */ ?>
      <?= $form->labelEx($qForm, 'pinned', ['style' => 'position:relative;left:30px;',]); ?>
      <?= $form->checkBox(
        $qForm,
        'pinned',
        [
          'data-toggle' => 'tooltip',
          'title'       => Yii::t('main', 'Сохранить и использовать перевод для этого сайта'),
          'style'       => 'position:relative;top:20px;left:30px',
        ]
      ); ?>
      <?= $form->error($qForm, 'pinned'); ?>
  </div>
  <div class="col-md-6">
    <input type="button" class="btn bigger btn-danger pull-right" value="<?= Yii::t('main', 'Сохранить') ?>"
           onClick="saveTranslation();" style="position:relative;top:20px;right:20px;">
  </div>
</div>
<hr/>
<div class="row">
  <div class="col-md-12">
    <iframe name="translate-bkrs" id="translate-bkrs" width="100%" height="450px"
            src="about:blank" frameborder="0"> <?= Yii::t(
          'main',
          'Ваш браузер не поддерживает фрэймы...'
        ) ?> </iframe>
  </div>
</div>
<?php $this->endWidget(); ?>

