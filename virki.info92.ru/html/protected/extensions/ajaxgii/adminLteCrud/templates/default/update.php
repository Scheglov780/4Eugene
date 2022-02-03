<?= '<?' ?> /*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
<description file="update.php">
  *
</description>
**********************************************************************************************************************/ ?>
<?
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?= "<?\n"; ?>
/** @var <?= $this->modelClass ?> $model */
$module = Yii::app()->controller->module->id;
?>
<?
$nameColumn = $this->guessNameColumn($this->tableSchema->columns);
$label = $this->pluralize($this->class2name($this->modelClass));
?>
<section class="content-header">
  <h1>
      <?= '<?' ?>=Yii::t('admin', 'Профиль') ?>: #<?php echo "<?=\$model->{$this->tableSchema->primaryKey}?>"; ?>
      <?= '<?' ?>= Utils::getHelp('update',
    true) ?></h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <?= "<?" ?>
      /** @var <?= $this->modelClass ?> $model */
      ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= '<?' ?>= Yii::t('admin', 'Редактирование') ?>
            #<?= "<?" ?>=$model-><?= $this->tableSchema->primaryKey; ?>?></h3>
        </div>
          <?php echo "<?"; ?>
        /** @var TbActiveForm $form */
        $form=$this->beginWidget('booster.widgets.TbActiveForm',array(
        'id'=>'<?= $this->class2id($this->modelClass); ?>-update-form-single-'.
        $model-><?= $this->tableSchema->primaryKey; ?>,
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
        <div class="box-body">
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
                    'update-single-$id'
                  ) . "; ?>\n"; ?>
                <?php
            }
            ?>
        </div>
        <div class="box-footer">
            <?php echo "<?php"; ?>
          $this->widget(
          'booster.widgets.TbButton',
          array(
          'buttonType'=>'button',
          'type'=>'default',
          //'size' => 'mini',
          'icon' => 'fa fa-check',
          'label' => $model->isNewRecord ? Yii::t('admin', 'Добавить') : Yii::t('admin', 'Сохранить'),
          'htmlOptions' => array(
          'class' => 'pull-right',
          'onclick' => "update_<?= str_replace('-', '_', $this->class2id($this->modelClass)); ?>
          _{$model-><?php echo $this->tableSchema->primaryKey; ?>} ();"),
          )
          );
          ?>
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
          <?php echo "<?php\n"; ?>
        $this->endWidget(); ?>
      </div>
    </div>
  </div>
</section>
<script>
    /* $(function () {
         var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
         if (instance) {
             instance.destroy(true);
         }
         CKEDITOR.replace('news_news_body_update-single-<?//=$model->news_id?>');
    });
   */
    function update_<?=str_replace('-', '_', $this->class2id($this->modelClass)) .
    "_<?=\$model->{$this->tableSchema->primaryKey}?>"?>() {
        /* var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
        if (instance) {
            instance.updateElement();
        }
        */
        var data = $("#<?=$this->class2id(
          $this->modelClass
        ); ?>'update-form-single'<?='<?'?>=$model-><?= $this->tableSchema->primaryKey; ?>?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?="<?=Yii::app()->createAbsoluteUrl('admin/" . lcfirst($this->modelClass) . "/update')?>"?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    dsAlert(data, 'Профиль сохранён', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>