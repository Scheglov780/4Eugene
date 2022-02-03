<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="main.php">
 * </description>
 * Главная страница сайта (не путать с лэйаутом)
 * var $itemsPopular = true
 * var $itemsRecommended = true
 * var $itemsRecentUser = false
 * var $itemsRecentAll = true
 **********************************************************************************************************************/
?>
<!-- our Teammates Start-->
<section class="teammatesSec  bggray">
  <div class="container lula">
      <?php
      $style = /** @lang CSS */
        <<<STYLE1
      .record .blue {
        color: blue;
      }

      .record .green {
        color: green;
      }

      .record .red {
        color: red;
      }

      .record .gray {
        color: darkgray;
      }

      .record .num {
        text-align: right;
      }

      .lula table, .lula th, .lula td {
        border: 1px solid black;
        font-size: 17px;
      }
      .lula tr.header-top {
        border-top: 3px solid black;
        font-size: 17px;
      }

      .lula table td.descr {
        font-size: 16px;
      }

      table.records .image img {
        width: 300px;
        height: auto;
      }

      .lula table a {
        color: #1a0dab;
      }

      .lula table a:hover {
        text-decoration: underline;
        padding-top: 5px;
      }

      .lula table a:visited {
        color: #660099;
      }
STYLE1;
      Yii::app()->clientScript->registerCss('lulaCss', $style);
      Yii::app()->clientScript->registerScriptFile(
        $this->frontThemePath . '/js/' . (YII_DEBUG ? 'jquery.lazyload.js' : 'jquery.lazyload.min.js'),
        CClientScript::POS_HEAD
      );
      $lazyScript = /** @lang JavaScript */
        <<<LAZY
        $(function () {
            // Disabling any price and detail blocks
            $('img.lazy').each(function () {
              });

            // Callback enabling any price and detail blocks
            function onLazyLoad(element, el_left, settings) {
            }

            $("img.lazy").show().lazyload({
               // load: onLazyLoad,
                effect: "fadeIn",
                effect_speed: 500,
                skip_invisible: false,
                threshold: 200
//                failure_limit: 60,
//                event : 'load'
            });
        });
LAZY;
      Yii::app()->clientScript->registerScript('lulaLazy', $lazyScript, CClientScript::POS_LOAD);
      ?>

      <?php
      $sql = /** @lang PostgreSQL */
        <<<PGQUERY
select 
ll.id,
ll.is_private,
price,
--dev_price,
dev_perc_price,
-- price_meter,
--dev_price_meter,
dev_perc_price_meter,
--price_sotka,
--dev_price_sotka,
dev_perc_price_sotka,
round(0.7*dev_perc_price_meter + 0.3*dev_perc_price_sotka) as dev_perc_total,
is_agency,
agency,       
address,
house_area,
land_area,
link, image, description
from lulav ll 
left join lateral (select round(avg(ll2.price)) as avg_price, round(avg(0.7*ll2.price/ll2.house_area)) as avg_price_meter, 
round(avg(0.3*ll2.price/ll2.land_area)) as avg_price_sotka,
round(percentile_cont(0.5) within group (order by ll2.price)) as perc_price,
round(percentile_cont(0.5) within group (order by 0.7*ll2.price/ll2.house_area)) as perc_price_meter, 
round(percentile_cont(0.5) within group (order by 0.3*ll2.price/ll2.land_area)) as perc_price_sotka
 from lulav ll2) llavg on 1=1
 left join lateral (select id, (round(100*((price/avg_price)-1))) as dev_price,
(round(100*((price/perc_price)-1))) as dev_perc_price,
round(0.7*price/house_area) as price_meter,
(round(100*(((0.7*price/house_area)/avg_price_meter)-1))) as dev_price_meter,
(round(100*(((0.7*price/house_area)/perc_price_meter)-1))) as dev_perc_price_meter,
round(0.3*price/land_area) as price_sotka,
(round(100*(((0.3*price/land_area)/avg_price_sotka)-1))) as dev_price_sotka,
(round(100*(((0.3*price/land_area)/perc_price_sotka)-1))) as dev_perc_price_sotka from lulav ll3) ll5 on ll5.id = ll.id 
order by ll.is_private desc, dev_perc_total asc, address, is_agency
PGQUERY;
      $recs = Yii::app()->db->createCommand($sql)->queryAll();
      ?>
    <table class="records table table-striped table-bordered table-condensed">
        <?
        //is_private	price	is_agency	address	house_area	land_area	link	image	description
        foreach ($recs as $i => $rec) {
            ?>
          <tr class="header-top">
            <th>#</th>
            <th>ИЖС</th>
            <th>Цена</th>
            <th>Рынок</th>
            <th>Дом</th>
            <th>Участок</th>
            <th colspan="2">&nbsp;</th>
          </tr>
          <tr class="record">
            <td rowspan="2" class="cnt"><?= $i ?></td>
            <td>
                <?php
                $res = '<span class="gray">СНТ</span>';
                if ($rec['is_private'] == 2) {
                    $res = '<span class="green">ИЖС</span>';
                } else {
                    if ($rec['is_private'] == 1) {
                        $res = '<span class="blue">?</span>';
                    }
                }
                echo $res;
                ?>
            </td>
            <td class="num" title="Цена, млн.">
                <?= number_format(round($rec['price'] / 1000000, 2), 2) ?>млн.<?//&#8381;?>
            </td>
            <td class="num" title="На сколько интегральная цена ниже или выше рынка">
                <span class="<?= ($rec['dev_perc_total'] < 0 ? 'green text-bold' : 'gray') ?>"><?= number_format(
                      $rec['dev_perc_total'],
                      0
                    );
                    ?>%</span>
            </td>
            <td class="num" title="Площаль дома">
                <?= number_format($rec['house_area'], 0); ?>м<sup>2</sup>
            </td>
            <td class="num" title="Площадь участка">
                <?= number_format($rec['land_area'], 1); ?>сот.
            </td>
              <? $queryForYandex = urlencode('Севастополь ' . $rec['address']); ?>
            <td title="Адрес">Адрес (см. на карте): <a href="https://yandex.ru/maps/?text=<?= $queryForYandex ?>"
                                                       title="Показать на карте в новой вкладке"
                                                       target="_blank"><?= $rec['address']
                    ?></a></td>
            <td class="agency" title="Агентство?">
                <? if ($rec['is_agency']) {
                    $queryForYandex = urlencode('Севастополь агентство недвижимости "' . $rec['agency'] . '"');
                    ?>
                  <a href="https://yandex.ru/search/?text=<?= $queryForYandex ?>"
                     title="Показать информацию об агентстве в новой вкладке"
                     target="_blank"><span class="agency red">Агентство (см. инфо):</span> <?= $rec['agency'] ?></a>
                <? } ?>
            </td>
          </tr>
          <tr>
            <td colspan="5" class="image">
                <?
                $img = str_replace('<img ', '<img class="lazy img-responsive" ', $rec['image']);
                $img = str_replace(
                  'src=',
                  'src="' .
                  Yii::app()->request->baseUrl .
                  '/themes/' .
                  Yii::app()->theme->name .
                  '/images/Hourglass.png" data-original=',
                  $img
                );
                ?>
              <a href="<?= $rec['link'] ?>" title="Посмотреть детали лота и контакты"
                 target="_blank"><?= $img ?></a></td>
            <td colspan="2" class="descr"><?= $rec['description'] ?>&nbsp;
              <a href="<?= $rec['link'] ?>" title="Посмотреть детали лота и контакты" target="_blank">см. контакты,
                детали...</a></td>
          </tr>
            <?php
        }
        ?>
    </table>
  </div>
</section>
