<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="admin.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  'Reports Systems' => ['index'],
  'Manage',
];

$this->menu = [
  ['label' => Yii::t('main', 'Список'), 'url' => ['index']],
  ['label' => Yii::t('main', 'Добавить'), 'url' => ['create']],
];
?>

<h1><?= Yii::t('main', 'Управление отчётами') ?></h1>

<p>
  Вы можете использовать операторы сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
  or <b>=</b>)</p>

<?php echo CHtml::link(Yii::t('main', 'Advanced Search'), '#', ['class' => 'search-button btn']); ?>
<div class="search-form" style="display:none">
    <?php $this->renderPartial(
      '_search',
      [
        'model' => $model,
      ]
    ); ?>
</div><!-- search-form -->

<?php $this->widget(
  'booster.widgets.TbGridView',
  [
    'id'              => 'reports-system-grid',
    'dataProvider'    => $model->search(),
    'filter'          => $model,
    'responsiveTable' => true,
    'columns'         => [
      'id',
      'internal_name',
      'name',
      'description',
      'script',
      'group',
      'enabled',

      [
        'class' => 'booster.widgets.TbButtonColumn',
      ],
    ],
  ]
); ?>
