<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://market.info92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="admin.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  Yii::t('admin', 'Настройки') => ['index'],
  Yii::t('admin', 'Управление'),
];

$this->menu = [
  ['label' => Yii::t('admin', 'Список параметров'), 'url' => ['index']],
  ['label' => Yii::t('admin', 'Добавить параметр'), 'url' => ['create']],

];
?>

<h1><?= Yii::t('admin', 'Управление параметрами настроек') ?></h1>

<p>
    <?= Yii::t('admin', 'Вы можете использовать операторы сравнения') ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>
    &gt;=</b>, <b>&lt;&gt;</b>
  or <b>=</b>)</p>

<?php echo CHtml::link(Yii::t('admin', 'Расширеный поиск'), '#', ['class' => 'search-button btn']); ?>
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
    'id'              => 'config-grid',
    'dataProvider'    => $model->search(),
    'filter'          => $model,
    'responsiveTable' => true,
    'columns'         => [
      'id',
      'label',
      'value',
      'default_value',
//		'in_wizard',
      [
        'class' => 'booster.widgets.TbButtonColumn',
      ],
    ],
  ]
); ?>
