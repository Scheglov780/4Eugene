<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php echo "<?php \$form=\$this->beginWidget('booster.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl(\$this->route),
	'method'=>'get',
)); ?>\n"; ?>

<?php foreach ($this->tableSchema->columns as $column): ?>
    <?php
    $field = $this->generateInputField($this->modelClass, $column);
    if (strpos($field, 'password') !== false) {
        continue;
    }
    ?>
    <?php echo "<?php echo " . $this->generateActiveGroup($this->modelClass, $column) . "; ?>\n"; ?>

<?php endforeach; ?>
  <div class="form-actions">
      <?php echo "<?php \$this->widget('booster.widgets.TbButton', array(
			'buttonType' => 'submit',
			'context'=>'primary',
			'label'=>'Search',
		)); ?>\n"; ?>
  </div>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>