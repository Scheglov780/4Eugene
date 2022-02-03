<?= '<?' ?> /*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
<description file="index.php">
  *
</description>
**********************************************************************************************************************/ ?>
<?php
/**
 * The following variables are available in this template:
 * - $this: the BootCrudCode object
 */
?>
<?php
echo "<?php\n"; ?>
/** @var <?= $this->modelClass ?> $model */
Yii::app()->clientScript->registerScript(
'search',
/** @lang JavaScript */
"
$('#<?= $this->class2id($this->modelClass) ?>-search-button').click(function(){
$('#<?= $this->class2id($this->modelClass) ?>-search-form-section').slideToggle('fast');
return false;
});
$('#<?= $this->class2id($this->modelClass) ?>-search-form form').submit(function(){
$.fn.yiiGridView.update('<?php echo $this->class2id($this->modelClass); ?>-grid', {
data: $(this).serialize()
});
return false;
});
");

?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= '<?' ?>= Yii::t('admin', 'Название') ?>
    <small><?= '<?' ?>= Yii::t('admin', 'Описание...') ?></small>
      <?= '<?' ?>=Utils::getHelp('index',true)?>
  </h1>
    <? /*
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">Buttons</li>
        </ol>
        */ ?>
</section>

<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
        <?php echo "<?php"; ?>
      $this->widget(
      'booster.widgets.TbMenu',
      array(
      'type' => 'pills',
      'items' => array(
      // array('label'=>Yii::t('admin','Список'), 'icon'=>'fa fa-th-list',
      'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
      array(
      'label' => Yii::t('admin', 'Новая запись'),
      'icon' => 'fa fa-plus',
      'url' => 'javascript:void(0);',
      'linkOptions' => array('onclick' => 'renderCreateForm_<?= str_replace(
          '-',
          '_',
          $this->class2id($this->modelClass)
        ); ?> ()'),
      'visible' => true,
      ),
      array(
      'label' => Yii::t('admin', 'Поиск'),
      'icon' => 'fa fa-search',
      'url' => '#',
      'linkOptions' => array('id' => '<?= $this->class2id($this->modelClass); ?>-search-button', 'class' =>
      'search-button')
      ),
      array(
      'label' => Yii::t('admin', 'Excel'),
      'icon' => 'fa fa-download',
      'url' => Yii::app()->controller->createUrl('GenerateExcel'),
      'linkOptions' => array('target' => '_blank'),
      'visible' => true
      ),
      ),
      )
      );
      ?>

      <div class="row">
        <div class="col-md-12">
          <section id="<?= $this->class2id($this->modelClass); ?>-search-form-section" class="search-form"
                   style="display:none">
              <?php echo "<?php \$this->renderPartial(
    '_search',
    array(
	 'model'=>\$model,
    )
   ); ?>\n"; ?>
          </section><!-- search-form -->
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= '<?' ?>= Yii::t('admin', 'Список') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <?php echo "<?php"; ?> $this->widget(
          'booster.widgets.TbGridView',
          array(
          'id'=>'<?= $this->class2id($this->modelClass); ?>-grid',
          'fixedHeader' => true,
          'headerOffset' => 0,
          //'scrollableArea' =>'.pre-scrollable',//
          'dataProvider'=>$model->search(),
          'filter' => $model,
          'type'=>'striped bordered condensed',
          'template'=>'{summarypager}{items}{pager}',
          'responsiveTable' => true,
          'columns'=>array(
            <?php
            $count = 0;
            foreach ($this->tableSchema->columns as $column) {
                if (++$count == 7) {
                    echo "\t\t/*\n";
                }
                ?>
              array(
              'type'  => 'raw',
              'name'  => '<?= $column->name ?>',
              'value' => function ($data, $row) {
              ///** @var <?= $this->modelClass ?> $data /
              return $data-><?= $column->name ?>;
              },
              ),
                <?
            }
            if ($count >= 7) {
                echo "\t\t*/\n";
            }
            ?>

          array(
          'type' => 'raw',
          'value' => function ($data) {
          /** @var <?= $this->modelClass ?> $data */
          ?>
          <div class="btn-group" role="group">
            <a href='javascript:void(0);' title="Редактировать"
               onclick='renderUpdateForm_<?= str_replace(
                 '-',
                 '_',
                 $this->class2id($this->modelClass)
               ) ?> ("<?= '<?' ?>=$data-><?= $this->tableSchema->primaryKey ?>?>")'
               class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
            <a href='javascript:void(0);' title="Удалить"
               onclick='delete_record_<?= str_replace(
                 '-',
                 '_',
                 $this->class2id($this->modelClass)
               ) ?> ("<?= '<?' ?>=$data-><?= $this->tableSchema->primaryKey ?>?>")'
               class='btn btn-default btn-sm'><i
                  class='fa fa-trash'></i></a>
          </div>
            <?= '<?' ?>
          },
          //'htmlOptions' => array('style' => 'width:135px;')
          ),

          ),
          )
          );

          $this->renderPartial("_ajax_update");
          $this->renderPartial("_ajax_create_form",array("model"=>$model));
          ?>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->

<script type="text/javascript">
    function delete_record_<?=str_replace('-', '_', $this->class2id($this->modelClass)); ?>(id) {

        if (!confirm("<?='<?'?>=Yii::t('admin','Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;


        jQuery.ajax({
            type: 'POST',
            url: '<?php echo "<?php"; ?> echo Yii::app()->createAbsoluteUrl("admin/<?=lcfirst(
              $this->modelClass
            ); ?>/delete"); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('<?=$this->class2id($this->modelClass); ?>-grid', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>


