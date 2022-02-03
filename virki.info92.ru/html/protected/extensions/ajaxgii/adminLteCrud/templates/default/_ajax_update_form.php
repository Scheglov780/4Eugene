<?= '<?' ?> /*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
<description file="_ajax_update_form.php">
  *
</description>
**********************************************************************************************************************/ ?>
<?= '<?' ?>
/** @var <?= $this->modelClass ?> $model */
?>
<div class="modal fade" id="<?= $this->class2id($this->modelClass); ?>-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= '<?' ?>= Yii::t('admin', 'Редактирование') ?>
          #<?= "<?" ?>=$model-><?= $this->tableSchema->primaryKey; ?>?><?= '<?' ?>= Utils::getHelp('update',
          true) ?></h4>
      </div>
        <?php echo "<?"; ?>
      /** @var TbActiveForm $form */
      $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
      'id'=>'<?= $this->class2id($this->modelClass); ?>-update-form',
      'enableAjaxValidation'=>false,
      'enableClientValidation'=>false,
      'method'=>'post',
      'action'=>array("<?php echo lcfirst($this->modelClass); ?>/update"),
      'type'=>'horizontal',
      'htmlOptions'=>array(
      'onsubmit'=>"return false;",/* Disable normal form submit */
      //'onkeypress'=>" if(event.keyCode == 13){ update_<?= str_replace(
          '-',
          '_',
          $this->class2id($this->modelClass)
        ); ?> (); } "
      /* Do ajax call when land presses enter key */
      ),
      )
      ); ?>
      <div class="modal-body">
          <?php echo "<?php"; ?> echo $form->errorSummary($model); ?>
          <?php echo "<?php"; ?> echo
        $form->hiddenField($model,'<?php echo $this->tableSchema->primaryKey; ?>',array()); ?>
          <?php
          foreach ($this->tableSchema->columns as $column) {
              if ($column->autoIncrement) {
                  continue;
              }
              ?>
              <?php echo "<?php echo " . $this->generateActiveRow(
                  $this->modelClass,
                  $column,
                  'update'
                ) . "; ?>\n"; ?>
              <?php
          }
          ?>
      </div>
      <div class="modal-footer">
          <?php echo "<?php"; ?>
        $this->widget('booster.widgets.TbButton', array(
        'buttonType'=>'button',
        'type'=>'default',
        //'size' => 'mini',
        'icon' => 'fa fa-check',
        'label' => $model->isNewRecord ? Yii::t('admin', 'Добавить') : Yii::t('admin', 'Сохранить'),
        'htmlOptions' => array('onclick' => 'update_<?= str_replace('-', '_', $this->class2id($this->modelClass)); ?>
        ();'),
        )
        );
        ?>
          <?php echo "<?php"; ?>
        $this->widget(
        'booster.widgets.TbButton',
        array(
        'buttonType' => 'button',
        'type' => 'default',
        //'size' => 'mini',
        'icon' => 'fa fa-close',
        'label' => Yii::t('admin', 'Отмена'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
        )
        ); ?>
          <?php echo "<?php"; ?>
        $this->widget(
        'booster.widgets.TbButton',
        array(
        'buttonType' => 'reset',
        'type' => 'default',
        //'size' => 'mini',
        'icon' => 'fa fa-rotate-left',
        'label' => Yii::t('admin', 'Сброс'),
        'htmlOptions' => array('class' => 'pull-left'),
        )
        ); ?>
      </div>
        <?php echo "<?php\n"; ?> $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




