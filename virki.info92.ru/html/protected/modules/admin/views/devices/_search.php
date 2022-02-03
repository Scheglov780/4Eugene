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
        'id'     => 'devices-search-form',
        'type'   => 'inline',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
      ]
    ); ?>
  <div class="box-header with-border">
    <h3 class="box-title"><?= Yii::t('main', 'Поиск прибора по атрибутам') ?></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <? /** @var Devices $model */ ?>
      <?php echo $form->textFieldRow($model, 'devices_id', ['id' => 'devices_devices_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'source', ['id' => 'devices_source_search']); ?>

      <?php echo $form->textFieldRow($model, 'name', ['id' => 'devices_name_search']); ?>
      <?php echo $form->textFieldRow($model, 'device_serial_number', ['id' => 'devices_device_serial_number_search']
      ); ?>

      <?php echo $form->textFieldRow($model, 'active', ['id' => 'devices_active_search']); ?>

      <?php echo $form->textFieldRow($model, 'properties', ['id' => 'devices_properties_search']); ?>

      <?php echo $form->textFieldRow($model, 'model_id', ['id' => 'devices_model_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'device_type_id', ['id' => 'devices_device_type_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'device_group_id', ['id' => 'devices_device_group_id_search']); ?>

      <?php echo $form->textFieldRow(
        $model,
        'report_period_update',
        ['id' => 'devices_report_period_update_search']
      ); ?>

      <?php echo $form->textAreaRow($model, 'desc', ['id' => 'devices_desc_search']); ?>

      <?php echo $form->textFieldRow($model, 'created_at', ['id' => 'devices_created_at_search']); ?>

      <?php echo $form->textFieldRow($model, 'updated_at', ['id' => 'devices_updated_at_search']); ?>

      <?php echo $form->textFieldRow($model, 'deleted_at', ['id' => 'devices_deleted_at_search']); ?>

      <?php echo $form->textFieldRow($model, 'starting_value1', [
        'id'          => 'devices_starting_value1_search',
        'placeholder' => 'Начальное значение для однотарифного прибора',
      ]); ?>

      <?php echo $form->textFieldRow($model, 'starting_value2', [
        'id'          => 'devices_starting_value2_search',
        'placeholder' => 'Начальное значение "день" для двухтарифного прибора',
      ]); ?>

      <?php echo $form->textFieldRow($model, 'starting_value3', [
        'id'          => 'devices_starting_value3_search',
        'placeholder' => 'Начальное значение "ночь" для двухтарифного прибора',
      ]); ?>

      <?php echo $form->textFieldRow($model, 'device_usage_id', ['id' => 'devices_device_usage_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'device_status_id', ['id' => 'devices_device_status_id_search']); ?>

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
            'onclick' => "$('#devices-search-form').slideToggle('fast');return false;",
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


