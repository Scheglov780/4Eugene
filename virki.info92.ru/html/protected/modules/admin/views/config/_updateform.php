<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_updateform.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="form">

    <?php $form = $this->beginWidget(
      'booster.widgets.TbActiveForm',
      [
        'id'                   => "config-form-$model->id",
        'enableAjaxValidation' => false,
      ]
    ); ?>
    <? if (in_array($model->id, ['search_CategoriesUpdate', 'search_PIM_grabbers'])) { ?>
      <div class="row buttons">
          <? $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
                //'id'=>'sub2',
              'type'        => 'info',
              'icon'        => 'ok white',
              'label'       => Yii::t('admin', 'Обновить версию'),
              'htmlOptions' => [
                'class'   => 'btn-block',
                'onclick' => "UpdateParamFromProxy('" . $model->id . "'); return false;",
              ],
            ]
          );
          ?>
      </div>

    <? } ?>

    <?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model, 'id'); ?>

  <div>
      <? //php echo $form->labelEx($model,'label'); ?>
      <? //php echo $form->error($model,'label'); ?>
  </div>

  <div>
      <?php echo $model->label; ?><br/>
      <?php
      $editor = new SRichTextarea();
      $editor->init();
      $editor->model = $model;
      $editor->attribute = 'value';
      $editor->run();
      ?>
      <?php echo $form->error($model, 'value'); ?>
  </div>

  <div class="row buttons">
      <? $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'button',
            //'id'=>'sub2',
          'type'        => 'warning',
          'icon'        => 'ok white',
          'label'       => Yii::t('admin', 'Сохранить'),
          'htmlOptions' => [
            'class'   => 'btn-block',
            'onclick' => 'saveConfig("' . $model->id . '"); return false;',
          ],
        ]
      );
      ?>
  </div>
    <?php $this->endWidget(); ?>

</div><!-- form -->