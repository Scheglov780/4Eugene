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
        'id'     => 'votings-search-form',
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
      <? /** @var Votings $model */ ?>
      <?php echo $form->textFieldRow($model, 'votings_id', ['id' => 'votings_votings_id_search']); ?>

      <?php echo $form->textFieldRow($model, 'votings_type', ['id' => 'votings_votings_type_search']); ?>

      <?php echo $form->textAreaRow($model, 'votings_header', ['id' => 'votings_votings_header_search']); ?>

      <?php echo $form->textAreaRow($model, 'votings_query', ['id' => 'votings_votings_query_search']); ?>

      <?php echo $form->textFieldRow($model, 'votings_variants', ['id' => 'votings_votings_variants_search']); ?>

      <?php echo $form->textAreaRow($model, 'votings_summary', ['id' => 'votings_votings_summary_search']); ?>

      <?php echo $form->textFieldRow($model, 'votings_author', ['id' => 'votings_votings_author_search']); ?>

      <?php echo $form->textFieldRow(
        $model,
        'date_actual_start',
        ['id' => 'votings_date_actual_start_search']
      ); ?>

      <?php echo $form->textFieldRow($model, 'date_actual_end', ['id' => 'votings_date_actual_end_search']); ?>

      <?php echo $form->textAreaRow($model, 'recipients', ['id' => 'votings_recipients_search']); ?>

      <?php echo $form->textFieldRow($model, 'created', ['id' => 'votings_created_search']); ?>

      <?php echo $form->textFieldRow($model, 'enabled', ['id' => 'votings_enabled_search']); ?>

      <?php echo $form->textAreaRow($model, 'comments', ['id' => 'votings_comments_search']); ?>

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
            'onclick' => "$('#votings-search-form').slideToggle('fast');return false;",
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



