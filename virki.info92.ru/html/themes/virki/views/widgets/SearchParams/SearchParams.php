<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchParams.php">
 * </description>
 * Рендеринг параметров поиска
 * var $type = 'category'|'search' - тип рендеринга
 * var $cids = array() - список рекомендованных категорий
 * var $groups = array - список групп уточняющего поиска
 * (
 * 0 => stdClass#1
 * (
 * [title] => '<translation editable=\"1\" translated=\"0\" url=\"/site/translate\" type=\"parseFilter\"
 * from=\"zh-CHS\" to=\"ru\" uid=\"0\" id=\"plain0\" title=\"plain[0]: 电饭煲多功能\" >电饭煲多功能<translate
 * onclick=\"editTranslation(event,this.parentNode,\'plain\',\'0\'); stopPropagation(event); return false;\" ><span
 * class=\"ui-icon ui-icon-pencil\"><span></translate></translation>'
 * [values] => array
 * (
 * 0 => stdClass(...)
 * ...
 * 7 => stdClass(...)
 * )))
 * var $filters = array() - список фильтров
 * var $multiFilters = array - список мультифильтров
 * (0 => stdClass#1
 * ([title] => '<translation editable=\"1\" translated=\"0\" url=\"/site/translate\" type=\"parseMultiFilter\"
 * from=\"zh-CHS\" to=\"ru\" uid=\"0\" id=\"plain0\" title=\"plain[0]: 形状\" >形状<translate
 * onclick=\"editTranslation(event,this.parentNode,\'plain\',\'0\'); stopPropagation(event); return false;\" ><span
 * class=\"ui-icon ui-icon-pencil\"><span></translate></translation>'
 * [values] => array
 * (0 => stdClass(...)
 * 1 => stdClass(...)
 * )))
 * var $suggestions = array() - список синонимов поиска, типа "так же рекомендуем посмотреть..."
 * var $priceRange = array - массив значений для построения графика цен
 * (0 => stdClass#1
 * ([start] => '0'
 * [end] => '20'
 * [percent] => '0'
 * ))
 * var $params = параметры, переданные в запросе
 * array
 * ('name' => 'mainmenu-kuxonnye-elektropribory-elektricheskie-risovarki')
 * var $cur_props = array()
 **********************************************************************************************************************/
?>
<? if ($this->beginCache(
  'SearchParams-' . implode('-', $params),
  [
    'duration' => (YII_DEBUG ||
      (Yii::app()->user->inRole(['contentManager', 'superAdmin']))
    ) ? 5 : 1200,
  ]
)
) {
    ?>
    <? if (isset($seller) && $seller) { ?>
    <div class="block" id="seller-info">
      <div class="block-content">
        <div class="box-heading"><span><?= Yii::t('main', 'Продавец') ?></span></div>
          <? // Информация о продавце из товара ?>
        <div class="shopby">
            <? /* <label><?= Yii::t('main', 'Продавец') ?>&nbsp;(ID:<?= $seller->user_id ?>):</label> */ ?>
          <span>ID&nbsp;:&nbsp;<?= $seller->user_id ?></span>
          <span class="pull-right">
                    <a href="<?= Yii::app()->createUrl(
                      '/seller/index',
                      [
                        'nick'            => $seller->seller_nick,
                        'seller_id'       => $seller->user_id,
                        'encryptedUserId' => (isset($seller->encryptedUserId) ? $seller->encryptedUserId : ''),
                      ]
                    ) ?>" class="seller-name">
                    <?= $seller->seller_nick ?>
                    </a>
                    </span>
            <? if ($seller->city) { ?><br>
              <span><?= Yii::t('main', 'Находится в') ?>:</span>
                <?= $seller->city ?>
                <?
            } ?>
          <br/>
            <? // Рейтинги - откуда и какие есть ?>
          <div id="seller-info-block">
            <span><?= Yii::t('main', 'Рейтинг') ?>:</span>
              <?= Yii::t('main', 'загрузка данных...'); ?>
            <script>
                var seller = 'seller=<?=urlencode(serialize($seller))?>';
                $.post('//data.' + document.domain + '/<?=Utils::appLang(
                )?>/seller/sellerInfo', seller, function (data) {
                    $('#seller-info-block').html(data);
                }, 'text');

            </script>
          </div>
        </div><!--End:Shopby-->
      </div>
    </div>
    <? } ?>
    <? // Фильтр поисковой выдачи?>
    <? $filterUrl = Yii::app()->createUrl('/' . $type . '/index', $params); ?>
  <form id="search-params" action="<?= $filterUrl ?>" method="GET">
      <? if (isset($params['recommend'])) { ?>
        <input type="hidden" name="recommend" value="<?= $params['recommend'] ?>">
      <? } ?>
      <? if ($type == 'search' && isset($params['query'])) { ?>
        <input type="hidden" name="query" value="<?= $params['query'] ?>">
      <? } ?>
    <div class="page-sidebar">
      <div class="box-heading"><span><?= Yii::t('main', 'Фильтр') ?></span></div>
      <!-- Filter by -->
      <div class="box-content">
        <div class="shopby">
            <? /*
                    //  График распределения цен ( может когда-то комуто будет нужен ??? )
                    <? if (isset($priceRange) && is_array($priceRange) && count($priceRange)) { ?>
                        <span><?= Yii::t('main', 'Распределение цен') ?></span>
                        <div class="pricegraph">
                            <? $this->render(
                              'themeBlocks.SearchParams.SearchParamsPriceGraph',
                              array('priceRange' => $priceRange,)
                            ); ?>
                        </div>
                        <hr>
                    <? } ?>
                    */ ?>
          <!-- Price Range -->
          <span><?= Yii::t('main', 'Цена (без доставки)') ?></span>

          <div class="pricerange">
            <input type="hidden" name="price_min" id="price-min"
                   value="<?= (isset($params['price_min'])) ? CHtml::encode($params['price_min']) : 0 ?>"/>
            <input type="hidden" name="price_max" id="price-max"
                   value="<?= (isset($params['price_max'])) ? CHtml::encode($params['price_max']) : '' ?>"/>

            <input type="text" id="price-range" name="price-range"/>
            <!-- 	data-from="30"                      // overwrite default FROM setting
data-to="70"                        // overwrite default TO setting
data-type="double"                  // slider type
data-step="10"                      // slider step
data-postfix=" pounds"              // postfix text
data-hasgrid="true"                 // enable grid
data-hideminmax="true"              // hide Min and Max fields
data-hidefromto="true"              // hide From and To fields
data-prettify="false"               // don't use spaces in large numbers, eg. 10000 than 10 000
 -->
            <button class="btn color1 normal pull-right" type="button"
                    onclick="$('#search-params').submit(); return false;">
                <?= Yii::t('main', 'Поиск') ?>
            </button>
          </div>
          <!--end: Price Range -->
        </div>
      </div>
      <!-- end: Filter by -->
        <? //=============================================================== ?>
        <? if (!function_exists('propSelector')) {
            function propSelector($props, $cur_props, $idSuffix)
            {
                foreach ($props as $prop) {
                    if (isset($prop->values[0])) {
                        $pidvid = explode(':', str_replace('%3A', ':', $prop->values[0]->values_props));
                        $pid = $pidvid[0]; ?>
                      <div class="panel panel-default">
                        <div class="panel-heading closed">
                          <a data-parent="#<?= $idSuffix ?>" href="#collapse<?= $pid ?>"
                             data-toggle="collapse">
                            <h4 class="panel-title">
                              <span class="fa fa-arrow-right"></span>
                              <span class="option-title"><?= $prop->title ?></span>
                              <span class="categorycount pull-right"><?= count($prop->values) ?></span>
                            </h4>
                          </a>
                        </div>
                        <div class="panel-collapse collapse<?= isset($cur_props[$pid]) ? ' in' : '' ?>"
                             id="collapse<?= $pid ?>">
                          <div class="panel-body">
                            <ul style="position: relative; left: 30px !important;">
                                <? if (isset($cur_props[$pid])) { ?>
                                  <li class="item" style="border-top: 0 !important; width: 85%;">
                                    <label class="radio">
                                      <input style="height: 16px !important;" type="radio"
                                             name="props[<?= $pid ?>]" value=""/>
                                        <?= Yii::t('main', 'Сбросить значения') ?>
                                    </label>
                                  </li>
                                <? } ?>
                                <? foreach ($prop->values as $value) { ?>
                                    <? $pidvid = explode(
                                      ':',
                                      str_replace('%3A', ':', $value->values_props)
                                    );
                                    $vid = $pidvid[1];
                                    ?>
                                  <li class="item" style="border-top: 0 !important;">
                                    <label class="radio">
                                      <input style="height: 16px !important;" type="radio"
                                             name="props[<?= $pid ?>]" value="<?= $vid ?>"
                                        <?= (isset($cur_props[$pid]) && $cur_props[$pid] == $vid) ? ' checked' :
                                          '' ?> />
                                      <span><?= $value->values_title ?>
                                          <? if (isset($value->values_count) && ($value->values_count > 0)) { ?>
                                            (<?= $value->values_count ?>)
                                          <? } ?>
                                        </span>
                                    </label>
                                  </li>
                                <? } ?>
                            </ul>
                          </div>
                        </div>
                      </div>
                    <? }
                }
            }
        }
        ?>
        <? if ((is_array($groups) && (count($groups) > 0)) || (is_array($filters) && (count(
                $filters
              ) > 0)) || (is_array($multiFilters) && (count($multiFilters) > 0))
        ) { ?>
          <div class="clearfix f-space10"></div>
        <? } ?>
      <!-- filling group filters -->
        <? if (is_array($groups) && (count($groups) > 0)) { ?>
          <div class="box-heading"><span><?= Yii::t('main', 'Группы товаров') ?></span></div>
          <!-- Categories -->
          <div class="box-content">
            <div class="panel-group" id="filter-groups">
                <? propSelector($groups, $cur_props, 'filter-groups') ?>
            </div>
          </div>
          <div class="clearfix f-space10"></div>
        <? } ?>
      <!-- filling filters -->
        <? if (is_array($filters) && (count($filters) > 0)) { ?>
          <div class="box-heading"><span><?= Yii::t('main', 'Свойства') ?></span></div>
          <!-- Categories -->
          <div class="box-content">
            <div class="panel-group" id="filter-filters">
                <? propSelector($filters, $cur_props, 'filter-filters') ?>
            </div>
          </div>
          <div class="clearfix f-space10"></div>
        <? } ?>

      <!-- filling multiFilters -->
        <? if (is_array($multiFilters) && (count($multiFilters) > 0)) { ?>
            <? /*    <div class="box-heading"><span><?= Yii::t('main', 'Дополнительно') ?></span></div> */ ?>
          <!-- Categories -->
          <div class="box-content">
            <div class="panel-group" id="filter-multifilters">
                <? propSelector($multiFilters, $cur_props, 'filter-multifilters') ?>
            </div>
          </div>
          <div class="clearfix f-space10"></div>
        <? } ?>

        <? if ((is_array($groups) && (count($groups) > 0)) || (is_array($filters) && (count(
                $filters
              ) > 0)) || (is_array($multiFilters) && (count($multiFilters) > 0))
        ) { ?>
          <button class="btn color1 normal pull-right" type="button"
                  onclick="$('#search-params').submit(); return false;">
              <?= Yii::t('main', 'Поиск') ?>
          </button>
        <? } ?>
      <!--<div class="clearfix f-space30"></div>-->
        <? if ($suggestions) { ?>
          <div class="clearfix f-space10"></div>
          <div class="box-content">
            <div class="panel-group" id="links-suggestions">
              <div class="panel panel-default">
                <div class="panel-heading closed" data-parent="#links-suggestions"
                     data-target="#collapseSuggestions"
                     data-toggle="collapse">
                  <h4 class="panel-title"><a href="#a"> <span
                          class="fa fa-arrow-right"></span> <?= Yii::t(
                            'main',
                            'Похожие результаты'
                          ) ?> </a><span
                        class="categorycount"><?= count($suggestions) ?></span></h4>
                </div>
                <div class="panel-collapse collapse" id="collapseSuggestions">
                  <div class="panel-body">
                    <ul>
                        <? if ($type == 'search' || $type == 'brand') {
                            foreach ($suggestions as $sugg) {
                                ?>
                                <? $paramsSugg = [];
                                $paramsSugg['cid'] = $sugg->cid;
                                $paramsSugg['query'] = $sugg->q;
                                ?>
                              <li class="item"><a rel="nofollow"
                                                  href="<?= Yii::app()->createUrl(
                                                    '/' . $type . '/index',
                                                    $paramsSugg
                                                  ) ?>">
                                      <?= $sugg->title ?>
                                </a></li>
                            <? } ?>
                            <?
                        } else {
                            foreach ($suggestions as $sugg) {
                                ?>
                                <? $paramsSugg = [];
                                $paramsSugg['cid'] = $sugg->cid;
                                $paramsSugg['query'] = $sugg->q;
                                ?>
                              <li class="item"><a rel="nofollow"
                                                  href="<?= Yii::app()->createUrl(
                                                    '/' . 'search' . '/index',
                                                    $paramsSugg
                                                  ) ?>">
                                      <?= $sugg->title ?>
                                </a></li>
                            <? } ?>
                        <? } ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <? } ?>

        <? if (Yii::app()->controller->id == 'favorite') { ?>
          <div class="clearfix f-space10"></div>
          <div class="box-content">
            <div class="panel-group" id="links-favorite">
              <div class="panel panel-default">
                <div class="panel-heading closed" data-parent="#links-favorite"
                     data-target="#collapseFavorite"
                     data-toggle="collapse">
                  <h4 class="panel-title"><a href="#a"> <span
                          class="fa fa-arrow-right"></span> <?= Yii::t(
                            'main',
                            'Избранное'
                          ) ?></a></h4>
                </div>
                <div class="panel-collapse collapse" id="collapseFavorite">
                  <div class="panel-body">
                      <? // Блок категорий избранного, который выводится ниже меню категорий?>
                      <?
                      $this->widget(
                        'application.components.widgets.FavoritesMenuBlock',
                        [
                          'adminMode' => false,
                        ]
                      );
                      ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <? } ?>

      <!-- search suggestions -->
        <? /* if ($suggestions) { ?>
        <div class="block" id="categories-block">

            <h4 class="title"><?= Yii::t('main', 'Похожие результаты') ?></h4>

            <div class="block-content categories">
                <ul id="search-categories">
                    <? if ($type == 'search' || $type == 'brand') {
                        foreach ($suggestions as $sugg) {
                            ?>
                            <? $paramsSugg = array();
                            $paramsSugg['cid'] = $sugg->cid;
                            $paramsSugg['query'] = $sugg->q;
                            ?>
                            <li><a rel="nofollow"
                                   href="<?= Yii::app()->createUrl('/' . $type . '/index', $paramsSugg) ?>">
                                    <?= $sugg->title ?>
                                </a></li>
                        <? } ?>
                    <?
                    } else {
                        foreach ($suggestions as $sugg) {
                            ?>
                            <? $paramsSugg = array();
                            $paramsSugg['cid'] = $sugg->cid;
                            $paramsSugg['query'] = $sugg->q;
                            ?>
                            <li><a rel="nofollow"
                                   href="<?= Yii::app()->createUrl('/' . 'search' . '/index', $paramsSugg) ?>">
                                    <?= $sugg->title ?>
                                </a></li>
                        <? } ?>
                    <? } ?>
                </ul>
            </div>
        </div>
    <? } */ ?>
    </div>
      <? //======================================================================================?>
  </form>

    <? /* /*Список выбраных опций*/ /*
    <div class="box-heading"><span>Compare</span></div>
    <!-- Compare -->
    <div class="box-content">
        <div class="compare"><span><a href="product.html">Ladies Stylish Handbag</a> <a href="#"
                                                                                        class="pull-right"><i
                      class="fa fa-times fa-fw"></i></a> </span> <span><a href="product.html">Female Strips
                    Handbag</a> <a
                  href="#" class="pull-right"><i class="fa fa-times fa-fw"></i></a> </span> <span><a
                  href="product.html">Blue
                    Fashion Bag</a> <a href="#" class="pull-right"><i class="fa fa-times fa-fw"></i></a> </span>
            <button class="btn color1 normal pull-right" type="submit">Compare</button>
        </div>

        <!-- Compare -->
    </div>
    */ ?>

    <? /* /*Форма обратной связи*/ /*
    <div class="clearfix f-space30"></div>
    <!-- Get Updates Box -->
    <div class="box-content">
        <div class="subscribe subscribe-filter">
            <div class="heading">
                <h3>Get updates</h3>
            </div>
            <div class="formbox">
                <form>
                    <i class="fa fa-envelope fa-fw"></i>
                    <input class="form-control" id="InputUserEmail" placeholder="Your e-mail..." type="text">
                    <button class="btn color1 normal pull-right" type="submit">Sign
                        up
                    </button>
                </form>
            </div>
        </div>
    </div>
    */ ?>
  <!-- end: Get Updates Box -->
  <script>
      (function ($) {
          'use strict';
          //Filter by Price Slider
          $('#price-range').ionRangeSlider({
              min: <?=min(
                ((isset($params['price_min'])) ? CHtml::encode($params['price_min']) : $minPrice),
                $minPrice
              )?>,// min value
              max: <?=max(
                ((isset($params['price_max'])) ? CHtml::encode($params['price_max']) : $maxPrice),
                $maxPrice
              )?>,// max value
              from: <?=((isset($params['price_min'])) ? CHtml::encode($params['price_min']) : $minPrice)?>,// overwrite default FROM setting
              to: <?=((isset($params['price_max'])) ? CHtml::encode($params['price_max']) : $maxPrice)?>,                         // overwrite default TO setting
              type: 'double',                 // slider type
              step: <?=$stepPrice?>,                       // slider step
              postfix: '<?= DSConfig::getCurrency(true) ?>',             		// postfix text
              //hasGrid: false,                  // enable grid
              gird: true,
              hideMinMax: false,               // hide Min and Max fields
              hideFromTo: false,               // hide From and To fields
              prettify: false,                 // separate large numbers with space, eg. 10 000
              /*                onChange: function (obj) {        // function-callback, is called on every change
               console.log(obj);
               },
               */
              onFinish: function (obj) {        // function-callback, is called once, after slider finished it's work
                  $('#price-min').val(obj.fromNumber);
                  $('#price-max').val(obj.toNumber);
                  //console.log(obj);
              }
          });
      })(jQuery);
  </script>
    <? /*    <div class="block" id="search-terms">
    <div class="block-content">
    <form id="search-params" action="<?= Yii::app()->createUrl('/' . $type . '/index', $params) ?>" method="post">
    <div class="form-item submit">
        <a href="javascript:void(0);" onclick="$('#search-params').submit(); return false;" class="search-terms-sbmt">
            <?= Yii::t('main', 'Поиск') ?>
        </a>
    </div>
    </form>
    </div>

    </div>
*/ ?>
    <? $this->endCache();
} ?>