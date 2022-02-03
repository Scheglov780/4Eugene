<?= '<?' ?> /*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
<description file="_ajax_create_form.php">
  *
</description>
**********************************************************************************************************************/ <?= '?>' ?>
<?= '<?' ?>
/** @var <?= $this->modelClass ?> $model */
<?= '?>' ?>
<div class="modal fade" id="<?= $this->class2id($this->modelClass); ?>-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= '<?' ?>= Yii::t('admin', 'Создание записи')<?= '?>' ?><?= '<?=' ?>
          Utils::getHelp('create',true)<?= '?>' ?></h4>
      </div>
        <?php echo "<?php\n"; ?>
      /** @var TbActiveForm $form */
      $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
      'id'=>'<?= $this->class2id($this->modelClass); ?>-create-form',
      'enableAjaxValidation'=>false,
      'enableClientValidation'=>false,
      'method'=>'post',
      'action'=>array("<?php echo lcfirst($this->modelClass); ?>/create"),
      'type'=>'horizontal',
      'htmlOptions'=>array(
      'onsubmit'=>"return false;",/* Disable normal form submit */
      //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key
      ),
      'clientOptions'=>array(
      'validateOnType'=>true,
      'validateOnSubmit'=>true,
      'afterValidate'=>'js:function(form, data, hasError) {
      if (!hasError)
      {
      create_<?= str_replace('-', '_', $this->class2id($this->modelClass)); ?>();
      }
      }'
      ),
      )
      ); ?>
      <div class="modal-body">
          <?php echo "<?php"; ?> echo $form->errorSummary($model); ?>
          <?php
          foreach ($this->tableSchema->columns as $column) {
              if ($column->autoIncrement) {
                  continue;
              }
              ?>
              <?php echo "<?php echo " . $this->generateActiveRow(
                  $this->modelClass,
                  $column,
                  'create'
                ) . "; ?>\n"; ?>
              <?php
          }
          ?>
      </div>
      <div class="modal-footer">
          <?php echo "<?php\n"; ?>
        $this->widget('booster.widgets.TbButton', array(
        'buttonType'=>'button',
        'type'=>'default',
        //'size'=>'mini',
        'icon' => 'fa fa-check',
        'label'=>$model->isNewRecord ? Yii::t('admin','Добавить') : Yii::t('admin','Сохранить'),
        'htmlOptions'=>array('onclick'=>'create_<?= str_replace('-', '_', $this->class2id($this->modelClass)) ?>();'),
        )
        );
        ?>
          <?php echo "<?php\n"; ?> $this->widget('booster.widgets.TbButton', array(
        'buttonType'=>'button',
        'type' => 'default',
        'icon'=>'fa fa-close',
        'label' => Yii::t('admin', 'Отмена'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
        )
        );
        ?>
          <?php echo "<?php\n"; ?>
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

<script type="text/javascript">
    function create_<?=str_replace('-', '_', $this->class2id($this->modelClass)); ?>() {
        var data = $("#<?=$this->class2id($this->modelClass); ?>-create-form").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?="<?php\n"; ?> echo Yii::app()->createAbsoluteUrl("admin/<?=lcfirst(
              $this->modelClass
            ); ?>/create"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#<?=$this->class2id($this->modelClass); ?>-create-modal').modal('hide');
                    $.fn.yiiGridView.update('<?=$this->class2id($this->modelClass); ?>-grid', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderCreateForm_<?=str_replace('-', '_', $this->class2id($this->modelClass)); ?>() {
        $('#<?=$this->class2id($this->modelClass); ?>-create-form').each(function () {
            this.reset();
        });
        $('#<?=$this->class2id($this->modelClass); ?>-create-modal').modal('show');
    }

</script>
