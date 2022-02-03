<?= '<?' ?> /*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
<description file="_search.php">
  *
</description>
**********************************************************************************************************************/ ?>
<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<div class="box box-default">
    <?php echo "<?php "; ?>
  /** @var TbActiveForm $form */
  $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
  'id'=>'<?= $this->class2id($this->modelClass); ?>-search-form',
  'type' => 'inline',
  'action'=>Yii::app()->createUrl($this->route),
  'method'=>'get',
  )
  ); ?>
  <div class="box-header with-border">
    <h3 class="box-title"><?= '<?' ?>= Yii::t('admin', 'Поиск по атрибутам') ?></h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
      <?= '<?' ?> /** @var <?= $this->modelClass ?> $model */ ?>
      <?php foreach ($this->tableSchema->columns as $column) { ?>
          <?php
          $field = $this->generateInputField($this->modelClass, $column);
          if (strpos($field, 'password') !== false) {
              continue;
          }
          ?>
          <?php echo "<?php echo " . $this->generateActiveRow($this->modelClass, $column, 'search') . "; ?>\n"; ?>

      <?php } ?>
  </div>
  <div class="box-footer">
      <?php echo "<?php"; ?>
    $this->widget(
    'booster.widgets.TbButton',
    array('buttonType'=>'submit',
    'type'=>'default',
    'icon' => 'fa fa-check',
    'label' => Yii::t('admin', 'Поиск'),
    'htmlOptions' => array('class' => 'pull-right')
    )
    ); ?>
      <?php echo "<?php"; ?>
    $this->widget(
    'booster.widgets.TbButton',
    array('buttonType'=>'button',
    'type' => 'default',
    'icon' => 'fa fa-close',
    'label' => Yii::t('admin', 'Отмена'),
    'htmlOptions' => array('class' => 'pull-right', 'onclick' => "$('#<?= str_replace(
        '-',
        '_',
        $this->class2id(
          $this->modelClass
        )
      ); ?>-search-form').slideToggle('fast');return false;"),
    )
    ); ?>
      <?php echo "<?php"; ?>
    $this->widget(
    'booster.widgets.TbButton',
    array('buttonType'=>'reset',
    'type' => 'default',
    //'size' => 'mini',
    'icon' => 'fa fa-rotate-left',
    'label' => Yii::t('admin', 'Сброс'),
    'htmlOptions' => array('class' => 'pull-left'),
    )
    ); ?>
  </div>
    <?php echo "<?php \$this->endWidget(); ?>\n"; ?>
</div>



