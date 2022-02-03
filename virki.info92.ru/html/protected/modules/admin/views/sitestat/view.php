<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="view.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?
if (Utils::transLang() == 'ru') {
//   setlocale(LC_ALL, 'rus');
    $date = date('d.m.Y, H:i');
} else {
    $date = date('d.m.Y, H:i');
} ?>

<? /*
$params = array();
$reportQueryCount = Yii::app()->db->createCommand(
  "SELECT count(0) FROM(
select d_date, count(0) as cnt from
(select DATE_FORMAT(ss.`date`, '%Y/%m/%d') as d_date  from log_http_requests ss
where `date` >= (NOW() - INTERVAL 30 DAY)
group by DATE_FORMAT(`date`, '%Y/%m/%d'), ip) ss
group by d_date
  ) cnt"
)->queryScalar($params);
$reportQuery = "select d_date, count(0) as cnt from
(select DATE_FORMAT(ss.`date`, '%Y/%m/%d') as d_date, 1 as cnt  from log_http_requests ss
where `date` >= (NOW() - INTERVAL 30 DAY)
group by DATE_FORMAT(`date`, '%Y/%m/%d'), ip) ss
group by d_date
 order by d_date desc";
$reportDataProvider = new CSqlDataProvider(
  Yii::app()->db->cache(3600)->createCommand($reportQuery),
  array(
    'id'             => 'reportDataProvider-' . uniqid('', true),
    'params'         => $params,
    'keyField'       => 'd_date',
    'totalItemCount' => $reportQueryCount,
    'pagination'     => false,
  )
);
//==============
$this->widget(
  'booster.widgets.TbGridView',
  array(
    'id'           => 'reportGrid-' . uniqid('', true),
    'dataProvider' => $reportDataProvider,
    'type'         => 'striped bordered condensed',
    'template'     => '{summary}{items}',
 'responsiveTable' => true,
    'columns'      => array(
      array(
        'header' => Yii::t('main', 'Количество'),
        'name'   => 'd_date'
      ),
      array(
        'header' => Yii::t('main', 'Запросов'),
        'name'   => 'cnt'
      ),
    )
  )
);*/
?>
<div class="row-fluid">
  <div class="span12">
      <?
      $this->widget(
        'application.components.widgets.ReportsBlock',
        [
          'title' => Yii::t('main', 'Работа сайта на') . ' ' . $date,
          'group' => 'SITE',
        ]
      );
      $this->widget(
        'application.components.widgets.ReportsBlock',
        [
          'title' => Yii::t('main', 'Маркетинг на') . ' ' . $date,
          'group' => 'MARKET',
        ]
      );
      $this->widget(
        'application.components.widgets.ReportsBlock',
        [
          'title' => Yii::t('main', 'Финансы на') . ' ' . $date,
          'group' => 'DEFAULT',
        ]
      );
      ?>
  </div>
</div>
<br><br><br><br>
