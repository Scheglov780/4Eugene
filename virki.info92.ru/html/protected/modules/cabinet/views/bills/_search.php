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
    <?php /** @var TbActiveForm $form */
    $form = $this->beginWidget(
      'booster.widgets.TbActiveForm',
      [
        'id'     => 'bills-search-form',
        'type'   => 'inline',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
      ]
    ); ?>
  <div class="box-header with-border">
    <h3 class="box-title"><?= Yii::t('main', 'Поиск по атрибутам') ?></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <? /** @var Bills $model */ ?>
      <?php echo $form->textFieldRow($model, 'id', ['id' => 'bills_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'tariff_object_id', ['id' => 'bills_tariff_object_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'status', ['id' => 'bills_status_search']); ?>

      <?php echo $form->textFieldRow($model, 'date', ['id' => 'bills_date_search']); ?>

      <?php echo $form->textFieldRow($model, 'manager_id', ['id' => 'bills_manager_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'tariff_id', ['id' => 'bills_tariff_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'summ', ['id' => 'bills_summ_search']); ?>

      <?php echo $form->textFieldRow($model, 'code', ['id' => 'bills_code_search']); ?>

      <?php echo $form->textFieldRow($model, 'manual_summ', ['id' => 'bills_manual_summ_search']); ?>

      <?php echo $form->textFieldRow($model, 'frozen', ['id' => 'bills_frozen_search']); ?>

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
      <?php $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'button',
          'type'        => 'default',
          'icon'        => 'fa fa-close',
          'label'       => Yii::t('main', 'Отмена'),
          'htmlOptions' => [
            'class'   => 'pull-right',
            'onclick' => "$('#bills-search-form').slideToggle('fast');return false;",
          ],
        ]
      ); ?>
      <?php $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'reset',
          'type'        => 'default',
            //'size' => 'mini',
          'icon'        => 'fa fa-rotate-left',
          'label'       => Yii::t('main', 'Сброс'),
          'htmlOptions' => ['class' => 'pull-left'],
        ]
      ); ?>
  </div>
    <?php $this->endWidget(); ?>
</div>



