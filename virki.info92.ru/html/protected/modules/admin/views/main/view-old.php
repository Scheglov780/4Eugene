<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="view.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? //$userAsManager?>
<? /*=============================================================*/ ?>
<? $news = true; ?>
<? //TODO: Исключить загрузку дэшборда при открытии документов по ссылке admin/main/open ?>
<? if (($this->action != 'open'
    //  && !preg_match('/admin\/main\/open\?/is',$_SERVER['HTTP_REFERER'])
)
&&
(Yii::app()->request->isAjaxRequest &&
  ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != 'admin-tabs-history-grid') || !(isset($_REQUEST['ajax']))))
) { ?>
<div id="accordion-board">
    <? if (Yii::app()->user && Yii::app()->user->inRole(['superAdmin', 'topManager'])) { ?>
      <h3 class="acchdr"><?= Yii::t('main', 'Резервная копия данных') ?></h3>
      <div style="padding: 10px !important;">
        <div class="row-fluid">
          <div class="span12">
            <strong>
                <?= Yii::t(
                  'main',
                  'Сохраняйте каждые 3-5 дней важные данные с сайта в архив на свой компьютер, чтобы не потерять их в случае проблем с хостингом и т.п.'
                ) ?>
            </strong><br/>
              <?= Yii::t(
                'main',
                'Будут сохранены: шаблон дизайна фронта, настройки сайта, данные о пользователях, заказах, баланс и платежи, контент страниц и блоков,
        другая информация, которая позволит восстановить сайт в случае потери данных.'
              ) ?>
              <? $this->widget(
                'booster.widgets.TbMenu',
                [
                  'type'  => 'pills',
                  'items' => [
                    [
                      'label'       => Yii::t('main', 'Сохранить данные'),
                      'icon'        => 'fa fa-gears',
                      'url'         => '/' . Yii::app()->controller->module->id . '/main/backup',
                      'linkOptions' => [
                        'target'  => '_blank',
                        'title'   => Yii::t('main', 'Скачать архив с данными на свой компьютер')
                          ,
                        'visible' => true,
                      ],
                    ],
                  ],
                ]
              ); ?><br>
              <?
              $secret = Yii::app()->db->createCommand("SELECT password FROM users WHERE uid=:uid LIMIT 1")
                ->queryScalar([':uid' => Yii::app()->user->id]);
              ?>
            <strong><?= Yii::t('main', 'Так же всегда можно использовать уникальную ссылку:') ?></strong>
              <?= Yii::app()->createAbsoluteUrl(
                '/' . Yii::app()->controller->module->id . '/main/backup',
                ['secret' => $secret]
              ) ?>
          </div>
        </div>
      </div>
    <? } ?>
    <? if (Yii::app()->user && Yii::app()->user->inRole(['superAdmin', 'topManager'])) { ?>
      <h3 class="acchdr"><?= Yii::t('main', 'Статистика работы') ?></h3>
      <div>
        <div class="row-fluid">
          <div class="span12">
            <div style="margin: 10px;">
                <?= Yii::t('main', 'Более подробная статистика и аналитика представлена в разделе') ?>&nbsp;
              <a href="/<?= Yii::app()->controller->module->id ?>/sitestat"
                 onclick="getContent(this,'<?= addslashes(Yii::t('main', 'Статистика')) ?>',false); return false;">
                <i class="fa fa-fixed-width fa fa-bar-chart"></i><?= Yii::t('main', 'Статистика') ?></a>
            </div>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span6">
            <div class="summary"><h4><strong><?= Yii::t('main', 'Основные параметры') ?></strong></h4>
            </div>
            <div>
                <? //========================================================================================?>
              <table class="table table-striped table-bordered table-condensed">
                <tr>
                  <th><?= Yii::t('main', 'Параметр') ?></th>
                  <th><?= Yii::t('main', 'Значение') ?></th>
                </tr>
                <tr>
                  <td><?= Yii::t('main', 'Использование DSGProxy') ?></td>
                  <td><?
                      $result = DSGDownloader::checkProxy(true);
                      echo $result;
                      ?>
                  </td>
                </tr>
                <tr>
                  <td><?= Yii::t('main', 'Переведено символов, за 24 часа') ?></td>
                  <td><?
                      if (class_exists('SoapClient', false)) {
                          try {
                              $url = 'https://' . preg_replace(
                                  '/\/.*/',
                                  '',
                                  DSConfig::getVal('translator_block_mode_url')
                                ) . '/dsapi/wsdl';
                              $cacheKey = $url . '/getProxyStatProxyTranslatorQueries24';
                              $cache = @Yii::app()->cache->get($cacheKey);
                              if (!$cache) {
                                  if (DSNetworking::urlExists($url)) {
                                      ini_set("default_socket_timeout", 5);
                                      $client = new SoapClient($url);
                                      $hostIp = gethostbyname(gethostname());//'176.9.9.21'
                                      $result = CJSON::decode(
                                        $client->getProxyStatProxyTranslatorQueries24($hostIp)
                                      );
                                      @Yii::app()->cache->set($cacheKey, $result, 3600);
                                  } else {
                                      $result = false;
                                  }
                              } else {
                                  $result = $cache;
                              }
                              if (isset($result) && $result && isset($result['sqlData'][0])) {
                                  echo $result['sqlData'][0]['remote'] . ' / ' . $result['sqlData'][0]['local'];
                              }
                          } catch (Exception $e) {
                              echo Yii::t('main', 'Нет данных');
                          }
                      } else {
                          echo Yii::t('main', 'Нет данных');
                      }
                      ?>
                  </td>
                </tr>
                <tr>
                  <td><?= Yii::t('main', 'Заказано товаров, за 30 дней') ?></td>
                  <td><?
                      $res = Yii::app()->db->cache(0)->createCommand(
                        "
        SELECT sum(oi.num) AS items_count, round(sum(oi.source_price*oi.num),2) AS items_summ
FROM orders_items oi, orders oo
WHERE oi.oid=oo.id
        AND oo.date>=extract(epoch from Now() - INTERVAL '30 DAY')
        "
                      )->queryRow();
                      $itemsCount = ($res['items_count'] ? $res['items_count'] : 0);
                      $itemsTotal = ($res['items_summ'] ? $res['items_summ'] : 0);
                      echo $itemsCount . ' на сумму ' . $itemsTotal . ' cny';
                      ?>
                  </td>
                </tr>
                <tr>
                  <td><?= Yii::t('main', 'Просмотрено товаров, за 30 дней') ?></td>
                  <td><?
                      $res = Yii::app()->db->cache(0)->createCommand(
                        "
        SELECT count(0) AS cnt FROM log_dsg ss
         WHERE ss.date>=(Now() - INTERVAL '30 DAY') AND ss.type IN ('DSGItem')
        "
                      )->queryScalar();
                      $itemsView = ($res ? $res : 0);
                      echo $itemsView;
                      ?>
                  </td>
                </tr>
                <tr>
                  <td><?= Yii::t('main', 'Конверсия просмотра товаров, за 30 дней') ?></td>
                  <td><?
                      if ($itemsView) {
                          $itemsConversion = round(100 * $itemsCount / $itemsView, 3);
                      } else {
                          $itemsConversion = 0;
                      }
                      echo $itemsConversion . '%';
                      ?>
                  </td>
                </tr>
                <tr>
                  <td><?= Yii::t('main', 'Вклад просмотра в оборот, за 30 дней') ?></td>
                  <td><?
                      if ($itemsView) {
                          $itemsCost = round($itemsTotal / $itemsView, 4);
                      } else {
                          $itemsCost = 0;
                      }
                      echo $itemsCost . ' cny';
                      ?>
                  </td>
                </tr>
              </table>
                <? //========================================================================================?>
            </div>
          </div>
          <div class="span6">
            <div class="summary"><h4><strong><?= Yii::t(
                          'main',
                          'Запросов к серверу за 24 часа, по результатам'
                        ) ?></strong></h4></div>
              <?
              $sqlSeries = Yii::app()->db->cache(1200)->createCommand(
                "
            SELECT DISTINCT CASE WHEN ss.result LIKE 'OK%' THEN SUBSTRING(ss.result,'(.+?\s.+?)\s') ELSE SUBSTRING(ss.result,'(.+?):') END AS result FROM log_dsg ss
           WHERE 
             ss.date_day in (extract(day from now()),extract(day from Now() - INTERVAL '23 HOUR')) and
             ss.\"date\">=(Now() - INTERVAL '23 HOUR') -- and ss.result not like 'Timeout:%'
/* GROUP BY CASE WHEN ss.result LIKE 'OK%' THEN SUBSTRING(ss.result,'(.+?\s.+?)\s') ELSE SUBSTRING(ss.result,'(.+?):') END
  ORDER BY ss.result */"
              )->queryColumn();

              $sqlCategories = Yii::app()->db->cache(1200)->createCommand(
                "
            SELECT distinct concat(extract(hour from ll.\"date\"),':00') AS \"hour\" FROM log_dsg ll
WHERE 
ll.date_day in (extract(day from now()),extract(day from Now() - INTERVAL '23 HOUR')) and
ll.\"date\">=(Now() - INTERVAL '23 HOUR')
-- GROUP BY extract( hour from ll.\"date\")
-- ORDER BY ll.\"date\"
"
              )->queryColumn();

              if (count($sqlSeries) && count($sqlCategories)) {
                  $sqlData = Yii::app()->db->cache(1200)->createCommand(
                    "
            SELECT DISTINCT concat(extract(hour from ll.\"date\"),':00') AS \"hour\",
            CASE WHEN ll.result LIKE 'OK%' THEN SUBSTRING(ll.result,'(.+?\s.+?)\s') ELSE SUBSTRING(ll.result,'(.+?):') END AS result, count(0) AS cnt FROM log_dsg ll
            WHERE 
            ll.date_day in (extract(day FROM now()),extract(day from (Now() - INTERVAL '23 HOUR'))) and
            ll.\"date\">=(Now() - INTERVAL '23 HOUR') -- and ll.result not like 'Timeout:%'
            -- GROUP BY extract(hour from ll.\"date\"), CASE WHEN ll.result LIKE 'OK%' THEN SUBSTRING(ll.result,'(.+?\s.+?)\s') ELSE SUBSTRING(ll.result,'(.+?):') END
            -- ORDER BY ll.\"date\", ll.result
            "
                  )->queryAll();
                  $series = [];
                  foreach ($sqlSeries as $sqlSerie) {
                      $serie = [
                        'name' => $sqlSerie,
                        'data' =>
                          array_fill(0, count($sqlCategories), 0),
                      ];
                      foreach ($sqlData as $sqlRow) {
                          if ($sqlRow['result'] == $sqlSerie) {
                              $serie['data'][array_search(
                                $sqlRow['hour'],
                                $sqlCategories
                              )] = (float) $sqlRow['cnt'];
                          }
                      }
                      $series[] = $serie;
                  }
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'scripts' => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting',
                          // adds Exporting button/menu to chart
                        'themes/grid-light'
                          // applies global 'grid' theme to all charts
                      ],
                      'options' => [
                        'credits' => ['enabled' => false],
                        'title'   => false,
                        'xAxis'   => [
                          'categories' => $sqlCategories,
                        ],
                        'yAxis'   => [
                          'min'   => 0,
                          'title' => ['text' => Yii::t('main', 'Количество вызовов')],
                        ],
                        'series'  => $series,
                      ],
                    ]
                  );
              } else {
                  echo '<div>' . Yii::t('main', 'Нет данных') . '</div>';
              }
              ?>
          </div>
        </div>
        <div class="row-fluid">
          <div class="span6">
            <div class="summary"><h4><strong><?= Yii::t(
                          'main',
                          'Запросов к серверу за 24 часа, по типам'
                        ) ?></strong></h4></div>
              <?
              $sqlSeries = Yii::app()->db->cache(600)->createCommand(
                "
            SELECT DISTINCT CASE WHEN ss.type LIKE 'DSG%' THEN ss.type ELSE 'Direct' END AS type FROM log_dsg ss
           WHERE ss.\"date\">=(Now() - INTERVAL '30 DAY')
           -- GROUP BY CASE WHEN ss.type LIKE 'DSG%' THEN ss.type ELSE 'Direct' END
           -- ORDER BY type
           "
              )->queryColumn();

              $sqlCategories = Yii::app()->db->cache(600)->createCommand(
                "
            SELECT DISTINCT concat(extract(hour from ll.\"date\"),':00') AS \"hour\" FROM log_dsg ll
WHERE 
ll.date_day in (extract(day from now()),extract(day from Now() - INTERVAL '23 HOUR')) and
ll.\"date\">=(Now() - INTERVAL '23 HOUR')
-- GROUP BY extract(hour from ll.\"date\")
-- ORDER BY ll.\"date\"
"
              )->queryColumn();

              if (count($sqlSeries) && count($sqlCategories)) {
                  $sqlData = Yii::app()->db->cache(600)->createCommand(
                    "
            SELECT DISTINCT extract(hour from ll.\"date\") AS \"hour\", CASE WHEN ll.type LIKE 'DSG%' THEN ll.type ELSE 'Direct' END AS type, count(0) AS cnt FROM log_dsg ll
WHERE 
ll.date_day in (extract(day from now()),extract(day from Now() - INTERVAL '23 HOUR')) and
ll.\"date\">=(Now() - INTERVAL '23 HOUR')
-- GROUP BY extract(hour from ll.\"date\"), CASE WHEN ll.type LIKE 'DSG%' THEN ll.type ELSE 'Direct' END
-- ORDER BY ll.\"date\", type
            "
                  )->queryAll();
                  $series = [];
                  foreach ($sqlSeries as $sqlSerie) {
                      $serie = [
                        'name' => $sqlSerie,
                        'data' =>
                          array_fill(0, count($sqlCategories), 0),
                      ];
                      foreach ($sqlData as $sqlRow) {
                          if ($sqlRow['type'] == $sqlSerie) {
                              $serie['data'][array_search(
                                $sqlRow['hour'] . ':00',
                                $sqlCategories
                              )] = (float) $sqlRow['cnt'];
                          }
                      }
                      $series[] = $serie;
                  }
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'scripts' => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting',
                          // adds Exporting button/menu to chart
                        'themes/grid-light'
                          // applies global 'grid' theme to all charts
                      ],
                      'options' => [
                        'credits' => ['enabled' => false],
                        'title'   => false,
                        'xAxis'   => [
                          'categories' => $sqlCategories,
                        ],
                        'yAxis'   => [
                          'min'   => 0,
                          'title' => ['text' => Yii::t('main', 'Количество вызовов')],
                        ],
                        'series'  => $series,
                      ],
                    ]
                  );
              } else {
                  echo '<div>' . Yii::t('main', 'Нет данных') . '</div>';
              }
              ?>
          </div>
          <div class="span6">
            <div class="summary"><h4><strong><?= Yii::t(
                          'main',
                          'Среднее время выполнения запроса за 24 часа'
                        ) ?></strong></h4></div>
              <?
              $sqlSeries = Yii::app()->db->cache(3600)->createCommand(
                "
            SELECT DISTINCT CASE WHEN ss.result LIKE 'OK%' THEN SUBSTRING(ss.result,'^(.+?\s.+?)\s') ELSE SUBSTRING(ss.result,'^(.+?):') END AS result FROM log_dsg ss
           WHERE 
           ss.date_day in (extract(day from now()),extract(day from (Now() - INTERVAL '24 HOUR'))) and
           ss.\"date\">=(Now() - INTERVAL '24 HOUR')
           /* GROUP BY CASE WHEN ss.result LIKE 'OK%' THEN SUBSTRING(ss.result,'^(.+?\s.+?)\s') ELSE SUBSTRING(ss.result,'^(.+?):') END
           ORDER BY result */"
              )->queryColumn();

              $categories = Yii::app()->db->cache(3600)->createCommand(
                "
            SELECT DISTINCT CASE WHEN ss.type LIKE 'DSG%' THEN ss.type ELSE 'Direct' END AS type FROM log_dsg ss
           WHERE 
           ss.date_day in (extract(day from now()), extract(day from (Now() - INTERVAL '24 HOUR'))) and
           ss.\"date\">=(Now() - INTERVAL '24 HOUR')
           -- GROUP BY CASE WHEN ss.type LIKE 'DSG%' THEN ss.type ELSE 'Direct' END
           -- ORDER BY type
           "
              )->queryColumn();

              $sqlData = Yii::app()->db->cache(3600)->createCommand(
                "
SELECT DISTINCT CASE WHEN ll.type LIKE 'DSG%' THEN ll.type ELSE 'Direct' END AS type,
CASE WHEN ll.result LIKE 'OK%' THEN SUBSTRING(ll.result,'^(.+?\s.+?)\s') ELSE SUBSTRING(ll.result,'^(.+?):') END AS result,
round(/* avg */(ll.duration),2) AS duration FROM log_dsg ll
WHERE 
ll.date_day in (extract(day from now()),extract(day from (Now() - INTERVAL '23 HOUR'))) and
ll.\"date\">=(Now() - INTERVAL '24 HOUR') AND result LIKE 'OK:%'
-- GROUP BY CASE WHEN ll.type LIKE 'DSG%' THEN ll.type ELSE 'Direct' END,
-- CASE WHEN ll.result LIKE 'OK%' THEN SUBSTRING(ll.result,'^(.+?\s.+?)\s') ELSE SUBSTRING(ll.result,'^(.+?):') END
-- ORDER BY type, result
            "
              )->queryAll(true,
                //array(':uid' => Yii::app()->user->id)
                []
              );
              if (count($sqlSeries) > 0 && count($sqlData) > 0 && count($categories) > 0) {
                  $series = [];
                  foreach ($sqlSeries as $sqlSerie) {
                      $serie = ['name' => $sqlSerie, 'data' => array_fill(0, count($categories), 0)];
                      foreach ($sqlData as $sqlRow) {
                          if ($sqlRow['result'] == $sqlSerie) {
                              $serie['data'][array_search(
                                $sqlRow['type'],
                                $categories
                              )] = (float) $sqlRow['duration'];
                          }
                      }
                      $series[] = $serie;
                  }
                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'scripts' => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'modules/exporting',
                          // adds Exporting button/menu to chart
                        'themes/grid-light'
                          // applies global 'grid' theme to all charts
                      ],
                      'options' => [
                        'chart'   => [
                          'type' => 'column',
                        ],
                        'credits' => ['enabled' => false],
                        'title'   => false,
                        'xAxis'   => [
                          'categories' => $categories,
                        ],
                        'yAxis'   => [
                          'min'   => 0,
                          'title' => ['text' => Yii::t('main', 'Время выполнения')],
                        ],
                        'series'  => $series,
                      ],
                    ]
                  );
              } else {
                  echo '<div>' . Yii::t('main', 'Нет данных') . '</div>';
              }
              ?>
          </div>
        </div>
      </div>
    <? } ?>
    <? if (Yii::app()->user && Yii::app()->user->inRole(['superAdmin', 'topManager'])) { ?>
  <h3 class="acchdr"><?= Yii::t('main', 'Новости и сообщения') ?></h3>
  <div>
    <div class="row-fluid">
      <div class="span6">
        <div class="summary"><?= Yii::t('main', 'Добро пожаловать') ?>, <?= $userAsManager->fullname ?>
          !
        </div>
        <div class="hello" style="display: inline-flex !important;">
          <p style="margin: 5px !important;"><strong><?= Yii::t('main', 'Номер счета') ?>
              :</strong><br>&nbsp;<span><?= Yii::app()->user->getPersonalAccount() ?></span></p>
            <? if (true) { ?>
              <p style="margin: 5px !important;"><strong><?= Yii::t('main', 'Ваш персональный промо-код') ?>
                  :</strong><br>&nbsp;<span><?= Users::getPromoByUid(
                        Yii::app()->user->id
                      ) ?></span></p>
            <? } ?>
          <p style="margin: 5px !important;"><strong><?= Yii::t('main', 'Остаток на счете') ?>:</strong><br>
            <span><?= Formulas::priceWrapper(
                  Formulas::convertCurrency(
                    Users::getBalance(Yii::app()->user->id),
                    DSConfig::getVal('site_currency'),
                    DSConfig::getCurrency()
                  ),
                  DSConfig::getCurrency()
                ); ?></span</p>
            <? if ($userAsManager->manager) { ?>
              <p style="margin: 5px !important;"><strong><?= Yii::t('main', 'Ваш персональный менеджер') ?> -
                      <?= Yii::t('main', 'EMail') ?>:</strong><br><a
                    href="email:<?= $userAsManager->manager->email ?>"><?= $userAsManager->manager->email ?></a>
              </p>
            <? } ?>
            <? } ?>
        </div>
        <h2><?= Yii::t('main', 'Новости проекта'); ?></h2>
        <div class="poject-news">
            <? $this->renderPartial('whatsnew', [], false, true); ?>
        </div>
      </div>
      <div class="span6">
        <div class="summary"><?= Yii::t('main', 'Новости') ?></div>
          <? $this->widget(
            'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.ModuleNewsBlock',
            [
              'id'       => 'module-news-desktop',
              'pageSize' => 10,
            ]
          );
          ?>
      </div>
    </div>
  </div>
    <? } ?>
</div>
<? /*=============================================================*/ ?>
<script>
    $(function () {
        $('#accordion-board').accordion({
            header: 'h3.acchdr',
            collapsible: true,
            active: <?=(($news && Yii::app()->user && Yii::app()->user->role == 'superAdmin') ? 2 : 'false')?>,
            heightStyle: 'content'
            //disabled: true
        });
    });
    //  ordr-header-block
</script>

<div class="row-fluid">
  <div class="span12">
      <? /*
            $this->widget(
              'application.modules.'.Yii::app()->controller->module->id.'.components.widgets.BillsListBlock',
              array(
                'type'       => null,
                'name'       => Yii::t('main', 'Заказы Ваших клиентов по статусам'),
                'idPrefix'   => 'desktop',
                'narrowView' => true,
                'manager'    => Yii::app()->user->id,
                'filter'     => true,
                'pageSize'   => 10,
              )
            );
 */
      ?>
  </div>
</div>
<div class="row-fluid">
  <div class="span6"> <!-- События по заказам -->
    <h3><?= Yii::t('main', 'События по заказам') ?></h3>
    <div style="display: block;height: 500px;overflow-x: auto;overflow-y: scroll;">
        <?php
        $this->widget(
          'booster.widgets.TbGridView',
          [
            'id'              => 'orders-events-desktop',
            'dataProvider'    => $userAsManager->usersOrdersEvents,
            'type'            => 'striped bordered condensed',
            'template'        => '{summary}{items}{pager}', //{summary}{pager}
            'responsiveTable' => true,
//    'ajaxUpdate'=>'headerblock-messages-subtabs',
              //'afterAjaxUpdate'=>'function () {makeSubTabs();}',
            'columns'         => [
//      'id',
//      'oid',
              [
                'type'   => 'raw',
                'name'   => 'subject_id',
                'header' => Yii::t('main', 'Заказ'),
                'value'  => function ($data) {
                    $res = CHtml::link(
                      $data['subject_id'],
                      ['orders/view', 'id' => $data["subject_id"]],
                      [
                        'title'   => Yii::t('main', 'Профиль заказа'),
                        'onclick' => 'getContent(this,"' . addslashes(
                            Yii::t(
                              'main',
                              'Заказ'
                            ) . ' ' . $data['subject_id']
                          ) . '",false);return false;',
                      ]
                    );
                    $res = $res . "&nbsp;" .
                      CHtml::link(
                        '<span class="fa fa-search-plus" style="display:inline-block;cursor: pointer;"></span>',
                        ["orders/view", "id" => $data["subject_id"]],
                        [
                          "class"   => "order_open",
                          "title"   => Yii::t('main', "Профиль заказа"),
                          'onclick' => 'getContent(this,"' . addslashes(
                              Yii::t(
                                'main',
                                'Заказ'
                              ) . ' ' . $data['subject_id']
                            ) . '",false);return false;',
                        ]
                      );
                    return $res;
                },
              ],
              [
                'name'   => 'date',
                'header' => Yii::t('main', 'Дата'),
              ],
              [
                'name'   => 'eventName',
                'header' => Yii::t('main', 'Событие'),
              ],
              [
                'name'   => 'subject_value',
                'header' => Yii::t('main', 'Параметры'),
              ],
              [
                'name'   => 'fromName',
                'header' => Yii::t('main', 'Инициатор'),
              ],
            ],
          ]
        );
        ?>
    </div>
  </div>
  <div class="span6">
    <h3><?= Yii::t('main', 'Сообщения по заказам') ?></h3> <!-- Сообщения по заказам -->
    <div style="display: block;height: 500px;overflow-y: auto; overflow-x: auto;">
        <?php $this->widget(
          'booster.widgets.TbGridView',
          [
            'id'              => 'grid-orders-comments-desktop',
            'dataProvider'    => $userAsManager->usersOrdersMessages,
            'type'            => 'striped bordered condensed',
            'template'        => '{summary}{items}{pager}', //{summary}{pager}
            'responsiveTable' => true,
            'columns'         => [
              [
                'type'   => 'raw',
                'name'   => 'obj_id',
                'header' => Yii::t('main', 'Заказ'),
                'value'  => function ($data) {
                    $res = CHtml::link(
                      $data['obj_id'],
                      ['orders/view', 'id' => $data["obj_id"]],
                      [
                        'title'   => Yii::t('main', 'Профиль заказа'),
                        'onclick' => 'getContent(this,"' . addslashes(
                            Yii::t(
                              'main',
                              'Заказ'
                            ) . ' ' . $data['obj_id']
                          ) . '",false);return false;',
                      ]
                    );
                    $res = $res . "&nbsp;" .
                      CHtml::link(
                        '<span class="fa fa-search-plus" style="display:inline-block;cursor: pointer;"></span>',
                        ["orders/view", "id" => $data["obj_id"]],
                        [
                          "class"   => "order_open",
                          "title"   => Yii::t('main', "Профиль заказа"),
                          'onclick' => 'getContent(this,"' . addslashes(
                              Yii::t(
                                'main',
                                'Заказ'
                              ) . ' ' . $data['obj_id']
                            ) . '",false);return false;',
                        ]
                      );
                    return $res;
                },
              ],
              [
                'name'        => 'fromName',
                'header'      => Yii::t('main', 'Отправитель'),
                'htmlOptions' => ['style' => 'width:50px;font-size:0.9em;'],
              ],
              [
                'name'        => 'date',
                'header'      => Yii::t('main', 'Дата'),
                'htmlOptions' => ['style' => 'width:45px;font-size:0.9em;'],
              ],
              [
                'name'        => 'message',
                'header'      => Yii::t('main', 'Сообщение'),
                'type'        => 'html',
                'htmlOptions' => ['style' => 'width:auto;'],
              ],
            ],
          ]
        );
        ?>
    </div>
  </div>
</div>
<hr/>
<div>
  <h3><?= Yii::t('main', 'Ваши клиенты') ?></h3>
    <?php $this->widget(
      'booster.widgets.TbGridView',
      [
        'id'              => 'users-grid-desktop',
        'fixedHeader'     => true,
        'headerOffset'    => 0,
        'dataProvider'    => $userAsManager->users->search(20),
        'filter'          => $userAsManager->users,
        'type'            => 'striped bordered condensed',
        'template'        => '{summary}{items}{pager}',
        'responsiveTable' => true,
        'columns'         => [
          [
            'type'   => 'raw',
            'filter' => false,
            'name'   => 'uid',
            'value'  => 'CHtml::link($data->uid, array("users/view", "id"=>$data->uid), array("title"=>Yii::t(\'main\',"Профиль пользователя"),"onclick"=>"getContent(this,\"".addslashes($data->email)."\",false);return false;"))',
          ],
          'fullname',
          [
            'type'  => 'raw',
            'name'  => 'email',
            'value' => 'CHtml::link($data->email, array("users/view", "id"=>$data->uid), array("title"=>Yii::t(\'main\',"Профиль пользователя"),"onclick"=>"getContent(this,\"".addslashes($data->email)."\",false);return false;"))',
          ],
          [
            'name'           => 'status',
            'class'          => 'CCheckBoxColumn',
            'checked'        => '$data->status==1',
            'header'         => Yii::t('main', 'Вкл.'),
              //'disabled'=>'true',
            'selectableRows' => 0,
          ],
          'userBalance',
        ],
      ]
    );
    ?>
</div>
<div>
  <h3><?= Yii::t('main', 'История Вашего счета') ?></h3>
    <?php
    $this->widget(
      'booster.widgets.TbGridView',
      [
        'id'              => 'payment-grid-desktop',
        'fixedHeader'     => true,
        'headerOffset'    => 0,
        'dataProvider'    => $userAsManager->payments->search(null, 20),
        'filter'          => $userAsManager->payments,
        'type'            => 'striped bordered condensed',
        'template'        => '{summary}{items}{pager}',
        'responsiveTable' => true,
        'columns'         => [
          'id',
          'sum',
          'description',
          [
            'name'   => 'status',
            'filter' => [
              1 => Yii::t('main', 'Зачисление или возврат средств') . '(1)',
              2 => Yii::t('main', 'Снятие средств') . '(2)',
              3 => Yii::t('main', 'Ожидание зачисления средств') . '(3)',
              4 => Yii::t('main', 'Отмена ожидания зачисления средств') . '(4)',
              5 => Yii::t('main', 'Отправка внутреннего перевода средств') . '(5)',
              6 => Yii::t('main', 'Получение внутреннего перевода средств') . '(6)',
            ],
            'value'  => '$data->status_name." (".$data->status.")"',
          ],
          [
            'type'  => 'raw',
            'name'  => 'date',
            'value' => 'date("Y-m-d H:i:s", $data->date)',
          ],
        ],
      ]
    );
    ?>
</div>
<? /* } else { ?>
    <div class="row-fluid">
        <div class="span12">
            <strong><?= Yii::t('main', 'Загрузка данных...'); ?></strong><br/>
            <div><img src="/themes/admin/images/preloader.gif"></div>
        </div>
    </div>
<? } */ ?>
<?
$monthDay = (int) date('d');
if (($monthDay >= 28 || $monthDay <= 3) && Yii::app()->user->role == 'superAdmin' && !YII_DEBUG) { ?>
  <div id='donate-reminder-modal' class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
       aria-hidden="true" style="width: 730px !important; border-radius: 8px !important;">
    <div class="modal-header"
         style="background-color: #C9E0ED; border-top-left-radius: 8px; border-top-right-radius: 8px;">
      <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
      <h2><i>. . . <?= Yii::t('main', 'Вот и прошел месяц'); ?> . . .</i></h2>
    </div>

    <div class="modal-body">
      <div style="font-size: 103% !important; font-family: Arial !important;">
        <p><?= Yii::t(
              'main',
              'Мы делали всё, от нас зависящее, чтобы Ваш сайт-магазин
                исправно работал. Внедряли новые функции, исправляли ошибки,
                администрировали Ваш хостинг.'
            ); ?></p>
        <p><?= Yii::t(
              'main',
              'Сейчас нам требуется Ваша посильная и скромная поддержка
                для того, чтобы мы могли оплатить очередной месяц работы
                серверов, обеспечивающих <big><i>для всех магазинов</i></big>
                перевод с одного языка на другой и получение данных с источника.'
            ); ?></p>
        <p><?= Yii::t('main', 'Мы будем благодарны лично Вам за любую финансовую помощь.'); ?></p>
        <p><i><?= Yii::t('main', 'И большое спасибо всем, кто уже поддержал проект!'); ?></i></p>
        <p style="font-size: smaller"><?= Yii::t(
              'main',
              'Это сообщение выдаётся с 28 по 3 число каждого месяца. И Вы можете его игнорировать без каких-либо последствий.'
            ); ?></p>
      </div>

      <iframe frameborder="0" allowtransparency="true" scrolling="no"
              src="https://money.yandex.ru/embed/shop.xml?account=410011342071716&quickpay=shop&payment-type-choice=on&mobile-payment-type-choice=on&writer=seller&targets=
                <?= urlencode(
                'Поддержка от сайта ' . DSConfig::getVal('site_domain') . ': спасибо за работу.'
              ) ?>&targets-hint=&default-sum=1000&button-text=01&successURL=" width="450" height="218"></iframe>

      <img src="/themes/admin/images/pusy-cat.jpg"
           style="display: block; height: 218px; float: right; border-radius: 8px;"/>

    </div><!--end modal body-->
    <div class="modal-footer">
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'button',
              //'id'=>'sub2',
            'type'        => 'danger',
            'icon'        => 'remove white',
            'label'       => Yii::t('main', 'Обойдётесь!'),
            'htmlOptions' => ['onclick' => "$('#donate-reminder-modal').modal('hide');"],
          ]
        );
        ?>
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'button',
              //'id'=>'sub2',
            'type'        => 'success',
            'icon'        => 'ok white',
            'label'       => Yii::t('main', 'Я уже помог в этом месяце'),
            'htmlOptions' => ['onclick' => "$('#donate-reminder-modal').modal('hide');"],
          ]
        );
        ?>
    </div><!--end modal footer-->
  </div><!--end modal-->

  <script>
      $('#donate-reminder-modal').modal('show');
  </script>
<? } ?>
<script>
    if (typeof deferredDashboard != 'undefined') {
        deferredDashboard.resolve(true);
    }
</script>

