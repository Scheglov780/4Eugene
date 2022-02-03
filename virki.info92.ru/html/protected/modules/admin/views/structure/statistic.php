<?
$params = [':uid' => $model->uid];
$this->widget(
  'application.components.widgets.ReportsBlock',
  [
    'title' => Yii::t('main', 'Статистика пользователя на') . ' ' . date('d.m.Y, H:i'),
    'group' => 'USER',
    'params' => $params,
  ]
);
