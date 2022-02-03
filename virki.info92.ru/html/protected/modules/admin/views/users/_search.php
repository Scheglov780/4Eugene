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
        'id'     => 'users-search-form',
        'type'   => 'inline',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
      ]
    ); ?>
  <div class="box-header with-border">
    <h3 class="box-title"><?= Yii::t('main', 'Поиск пользователя по атрибутам') ?></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <?php /** @var Users $model */
      echo $form->textFieldRow($model, 'uid', ['id' => 'Users_uid_search']); ?>
      <?php echo $form->textFieldRow($model, 'fullname', ['id' => 'Users_fullname_search']); ?>
      <?php echo $form->textFieldRow($model, 'email', ['id' => 'Users_email_search']); ?>
      <?php echo $form->textFieldRow($model, 'phone', ['id' => 'Users_phone_search']); ?>
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
            'onclick' => "$('#users-search-form').slideToggle('fast');return false;",
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


