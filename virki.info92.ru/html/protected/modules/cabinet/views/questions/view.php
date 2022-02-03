<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="view.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  Yii::t('main', 'Вопросы'),
];
$q_satuses = [
  1 => Yii::t('main', 'На рассмотрении'),
  2 => Yii::t('main', 'Получен ответ'),
  3 => Yii::t('main', 'Закрыто'),
];

$category_values = [
  1 => Yii::t('main', 'Общие вопросы'),
  2 => Yii::t('main', 'Вопросы по моему заказу'),
  3 => Yii::t('main', 'Рекламация'),
  4 => Yii::t('main', 'Возврат денег'),
  5 => Yii::t('main', 'Оптовые заказы'),
];
?>
<h1><?= Yii::t('main', 'Вопрос в службу поддержки') ?></h1>
<b><?= Yii::t('main', 'Номер') ?>:</b> Q0000<?= CHtml::encode($question->id) ?><br/>
<b><?= Yii::t('main', 'Категория') ?>:</b> <?= CHtml::encode($category_values[$question->category]) ?>
<h3></h3><b><?= Yii::t('main', 'Тема обращения') ?>:</b>
<?php echo CHtml::encode($question->theme); ?></h3>
<br/>
<b><?= Yii::t('main', 'Дата обращения') ?>:</b>
<?= date("d.m.Y H:i", $question->date) ?>
<br/>

<b><?= Yii::t('main', 'Дата последнего изменения') ?>:</b>
<?= $question->date_change ? date("d.m.Y H:i", $question->date_change) : date("d.m.Y H:i", $question->date) ?>
<br/>

<b><?= Yii::t('main', 'Статус') ?>:</b>
<?php echo $q_satuses[$question->status] ?>
<br/>

<? if ($question->order_id) { ?>
  <b><?= Yii::t('main', 'Номер заказа') ?>:</b>
    <?php echo $question->order_id ?>
  <br/>
<? } ?>
<? if ($question->file) { ?>
  <hr/>
  <p><?= Yii::t('main', 'Прикрепленный файл') ?>: <a href="<?= '/upload/' . $question->file ?>"
                                                     target="_blank"><?= $question->file ?></a></p>
<? } ?>

<div style="float: left; width: 100%;">
    <?php $this->widget(
      'booster.widgets.TbListView',
      [
        'dataProvider' => $messages,
        'itemView'     => '_viewForm',
        'id'           => 'questions-listview-' . $question->id,
        'ajaxUpdate'   => true,
      ]
    ); ?>
</div>