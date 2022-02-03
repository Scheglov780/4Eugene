<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var Lands $model */
Yii::app()->clientScript->registerScript(
  'search',
  "
$('#lands-search-button').click(function(){
    $('#lands-search-form').slideToggle('fast');
    return false;
});
$('#lands-search-form form').submit(function(){
    $.fn.yiiGridView.update('lands-grid', {
        data: $(this).serialize()
    });
    return false;
});
"
);

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1><?= Yii::t('main', 'Структура объектов') ?>
    <small><?= Yii::t('main', 'Управление участками, владельцами и приборами учёта...') ?></small>
      <?= Utils::getHelp('index', true) ?>
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
        <?php
        /*
        $this->widget(
          'booster.widgets.TbMenu',
          array(
            'type'  => 'pills',
            'items' => array(
                //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
              array(
                'label'       => Yii::t('main', 'Новый участок'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => array('onclick' => 'renderCreateForm_lands ()'),
                'visible'     => true,
              ),
              array(
                'label'       => Yii::t('main', 'Поиск'),
                'icon'        => 'fa fa-search',
                'url'         => '#',
                'linkOptions' => array('id' => 'lands-search-button', 'class' => 'search-button')
              ),
              array(
                'label'       => Yii::t('main', 'Excel'),
                'icon'        => 'fa fa-download',
                'url'         => Yii::app()->controller->createUrl('GenerateExcel'),
                'linkOptions' => array('target' => '_blank'),
                'visible'     => true
              ),
            ),
          )
        );
        */
        ?>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Структура объектов') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <?
            $this->widget(
              'ext.DVTreeGridView.DVTreeGridView',
              [
                'id'                  => 'obj-structure-tree-grid',
                'type'                => 'bordered condensed',
                'template'            => '{items}',
                'responsiveTable'     => true,
                'fixedHeader'         => true,
                'headerOffset'        => 0,
                'treeViewOptions'     => [
                  'initialState'       => 'collapsed', //expanded, collapsed
                  'expandable'         => true,
                  'clickableNodeNames' => false,
                  'indent'             => 25,
                  'stringCollapse'     => Yii::t('main', 'Свернуть'),
                  'stringExpand'       => Yii::t('main', 'Развернуть'),
                ],
                'rootId'              => 0,
                'idColumn'            => 'tree_id',
                'parentColumn'        => 'tree_parent_id',
                'childrenCountColumn' => 'tree_children_count',
                'dataProvider'        => ObjStructure::getStructureDataProvider(0),
                'initialDepth'        => 4,
                'lazyMode'            => false,
                  //'lazyNodeUrl'         => '/admin/structure/node',
                  //'setParentUrl'        => '/admin/structure/setParent',
                'isPartialRendering'  => false,
                'columns'             => [
                  [
                    'name'        => 'obj_assigned',
                    'header'      => '',
                    'type'        => 'raw',
                    'value'       => function ($data) {
                        $icons = '';
                        if ($data['obj_type'] == 'land') {
                            $icons = '';
                            if ($data['obj_assigned'] === 3) {
                                $icons = "<i class='fa fa-user text-success fa-lg'></i>
                                           <i class='fa fa-podcast text-success fa-lg'></i>";
                            } elseif ($data['obj_assigned'] === 2) {
                                $icons = "<i class='fa fa-user  text-danger fa-lg'></i>
                                           <i class='fa fa-podcast text-success fa-lg'></i>";
                            } elseif ($data['obj_assigned'] === 1) {
                                $icons = "<i class='fa fa-user text-success fa-lg'></i>  
                                           <i class='fa fa-podcast text-danger fa-lg'></i>";
                            } elseif ($data['obj_assigned'] === 0) {
                                $icons = "<i class='fa fa-user text-danger fa-lg'></i>
                                           <i class='fa fa-podcast text-danger fa-lg'></i>";
                            }

                        }
                        return $icons;
                    },
                    'htmlOptions' => ['style' => 'width:85px;'],
                  ],
                  [
                    'name'   => 'obj_name',
                    'header' => Yii::t('main', 'Объект'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        if ($data['obj_group']) {
                            $name = $data['obj_group'] . '/' . $data['obj_name'];
                        } else {
                            $name = $data['obj_name'];
                        }
                        $result = '-';
                        // tree_id tree_parent_id tree_order_in_level tree_children_count obj_id
                        // obj_type obj_group obj_name obj_assigned
                        if ($data['obj_type'] == 'structure') {
                            $class = 'objStructureStructure';
                            $result = "<span class='{$class}'>{$name}</span> ({$data['tree_children_count']})";
                        } elseif ($data['obj_type'] == 'land') {
                            $class = 'objStructureLand';
                            $link = Lands::getUpdateLink($data['obj_id']);
                            $result = "<span class='{$class}'>{$link}</span>";
                        } elseif ($data['obj_type'] == 'user') {
                            $class = 'objStructureUser';
                            $link = Users::getUpdateLink($data['obj_id']);
                            $result = "<span class='{$class}'>{$link}</span>";
                        } elseif ($data['obj_type'] == 'device') {
                            $class = 'objStructureDevice';
                            $link = Devices::getUpdateLink($data['obj_id'], false, null, null, 'fa fa-podcast');
                            $result = "<span class='{$class}'>{$link}</span>";
                        }
                        return $result;
                    },
                  ],
                  [
                    'name'   => 'obj_data',
                    'header' => Yii::t('main', 'Проблемы структуры'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        if ($data['obj_type'] == 'land') {
                            $report = ObjStructure::getLandReport($data['obj_data']);
                            echo "<ul>";
                            foreach ($report as $message) {
                                echo "<li class='bg-{$message[2]}'>{$message[3]}</li>";
                            }
                            echo "</ul>";
                        } else {
                            return;
                        }
                    },
                  ],
                ],
              ]
            );
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