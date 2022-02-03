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
        'id'     => 'tariffs-acceptors-search-form',
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
      <? /** @var TariffsAcceptors $model */ ?>
      <?php echo $form->textFieldRow(
        $model,
        'tariff_acceptors_id',
        ['id' => 'tariffs-acceptors_tariff_acceptors_id_search']
      ); ?>

      <?php echo $form->textFieldRow($model, 'name', ['id' => 'tariffs-acceptors_name_search']); ?>

      <?php echo $form->textFieldRow($model, 'address', ['id' => 'tariffs-acceptors_address_search']); ?>

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
            'onclick' => "$('#tariffs-acceptors-search-form').slideToggle('fast');return false;",
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



