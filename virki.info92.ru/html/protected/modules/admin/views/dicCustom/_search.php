<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_search.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="box box-default">
    <?php
    /** @var TbActiveForm $form */
    $form = $this->beginWidget(
      'booster.widgets.TbActiveForm',
      [
        'id'     => 'diccustom-search-form',
        'type'   => 'inline',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
      ]
    ); ?>
  <div class="box-header with-border">
    <h3 class="box-title"><?= Yii::t('main', 'Поиск значения по атрибутам') ?></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <?php /** @var DicCustom $model */
      echo $form->textFieldRow($model, 'val_group', ['id' => 'Diccustom_val_group_search']); ?>
      <?php echo $form->textFieldRow($model, 'val_name', ['id' => 'Diccustom_val_name_search']); ?>
      <?php echo $form->textFieldRow($model, 'val_description', ['id' => 'Diccustom_val_description_search']); ?>
  </div>
  <div class="box-footer">
      <?php $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'submit',
          'type'        => 'default',
          'icon'        => 'fa fa-check',
          'label'       => Yii::t('main', 'Поиск'),
          'htmlOptions' => ['class' => 'pull-right'],
        ]
      ); ?>
      <?
      $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'button',
            //'id'=>'sub2',
          'type'        => 'default',
          'icon'        => 'fa fa-close', //fa-inverse
          'label'       => Yii::t('main', 'Отмена'),
          'htmlOptions' => [
            'class'   => 'pull-right',
            'onclick' => "$('#diccustom-search-form').slideToggle('fast');return false;",
          ],
        ]
      );
      ?>
      <?php
      $this->widget(
        "booster.widgets.TbButton",
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