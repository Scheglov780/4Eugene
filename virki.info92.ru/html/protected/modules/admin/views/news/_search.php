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
    $form = $this->beginWidget('booster.widgets.TbActiveForm', [
        'id'     => 'news-search-form',
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
      <? /** @var News $model */ ?>
      <?php echo $form->textFieldRow($model, 'news_id', ['id' => 'news_news_id_search']); ?>

      <?php echo $form->textAreaRow($model, 'news_header', ['id' => 'news_news_header_search']); ?>

      <?php echo $form->textAreaRow($model, 'news_body', ['id' => 'news_news_body_search']); ?>

      <?php echo $form->textFieldRow($model, 'news_author', ['id' => 'news_news_author_search']); ?>

      <?php echo $form->textFieldRow($model, 'created', ['id' => 'news_created_search']); ?>

      <?php echo $form->textAreaRow($model, 'comments', ['id' => 'news_comments_search']); ?>

      <?php echo $form->textFieldRow($model, 'enabled', ['id' => 'news_enabled_search']); ?>

      <?php echo $form->textFieldRow($model, 'news_type', ['id' => 'news_news_type_search']); ?>

      <?php echo $form->textFieldRow($model, 'date_actual_start', ['id' => 'news_date_actual_start_search']); ?>

      <?php echo $form->textFieldRow($model, 'date_actual_end', ['id' => 'news_date_actual_end_search']); ?>

      <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'news_recipients_search']); ?>

      <?php echo $form->textFieldRow($model, 'confirmation_needed', ['id' => 'news_confirmation_needed_search']); ?>

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
            'onclick' => "$('#news-search-form').slideToggle('fast');return false;",
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



