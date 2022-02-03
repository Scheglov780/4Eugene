<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="main.php">
 * </description>
 * Лэйаут фронта сайта
 **********************************************************************************************************************/
?>

<!DOCTYPE html>
<!--[if IE 7 ]>
<html class="ie ie7 lte9 lte8 lte7" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= Utils::appLang() ?>"
      lang="<?= Utils::appLang() ?>"><![endif]-->
<!--[if IE 8]>
<html class="ie ie8 lte9 lte8" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= Utils::appLang() ?>"
      lang="<?= Utils::appLang() ?>">    <![endif]-->
<!--[if IE 9]>
<html class="ie ie9 lte9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= Utils::appLang() ?>"
      lang="<?= Utils::appLang() ?>"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="noIE" xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?= Utils::appLang() ?>"
      lang="<?= Utils::appLang() ?>">
<!--<![endif]-->

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="format-detection" content="telephone=no"/>
  <link rel="icon" href="<?= $this->frontThemePath ?>/images/favicon.png" type="image/png"/>
  <link rel="shortcut icon" href="<?= $this->frontThemePath ?>/images/favicon.png" type="image/png"/>

  <title><?= $this->pageTitle ?></title>
    <? // Подкеширование DNS для картинок ?>
    <? if (DSConfig::getVal('seo_img_cache_enabled')) { ?>
      <meta http-equiv="x-dns-prefetch-control" content="on">
        <? if (DSConfig::getVal('seo_img_cache_subdomains')) {
            $imgsubdomains = explode(',', DSConfig::getVal('seo_img_cache_subdomains'));
        } else {
            $imgsubdomains = [];
        }
        if (DSConfig::getVal('item_ajax_loading_subdomains')) {
            $itemsubdomains = explode(',', DSConfig::getVal('item_ajax_loading_subdomains'));
        } else {
            $itemsubdomains = [];
        }
        $imgsubdomains = array_merge($imgsubdomains, $itemsubdomains);
        $imgsubdomains[] = 'data';
        $domain = Yii::app()->getBaseUrl(true);
        foreach ($imgsubdomains as $imgsubdomain) { ?>
          <link rel="dns-prefetch"
                href="<?= preg_replace('/(http[s]*:\/\/)/iu', '//' . $imgsubdomain . '.', $domain); ?>">
        <? }
    } ?>
    <? /* Подключение css и javaScript, которые используются во всех представлениях фронта,
          для сомнительного удобства вынесено в отдельные файлы.*/
    ?>
    <? $this->renderPartial('//layouts/dropshopGlobalCss', [], false, false, false); ?>
  <!--[if lt IE 9]>
    <script src="<?= $this->frontThemePath ?>/js/html5shiv.js"></script>
    <script src="<?= $this->frontThemePath ?>/js/respond.min.js"></script>
    <![endif]-->
  <!-- Сообщение для IE ниже восьмого -->
    <?
    if (!function_exists('maxsite_testIE')) {
        function maxsite_testIE()
        {
            $user_agent = Yii::app()->request->userAgent;
            $browserIE = false;
            if (stristr($user_agent, 'MSIE 7.0')) {
                $browserIE = true;
            } // IE7
            if (stristr($user_agent, 'MSIE 6.0')) {
                $browserIE = true;
            } // IE6
            if (stristr($user_agent, 'MSIE 5.0')) {
                $browserIE = true;
            } // IE5
            return $browserIE;
        }
    }
    ?>
    <?php
    if (maxsite_testIE()) {
        echo '
    <div class="ie">' .
          Yii::t(
            'main',
            'Внимание! Вы используете Internet Explorer версии 8 или ниже. Возможна некорректная работа сайта!'
          ) . '<br />
  ' . Yii::t('main', 'Рекомендуем установить другой браузер, например:') . '
  <a href="http://opera.com/">Opera</a>, <a href="http://www.mozilla-europe.org/ru/products/firefox/">Firefox</a>, <a href="http://www.google.com.ua/intl/ru/chrome/">Google Chrome</a>
  </div>
  ';
    }
    ?>
</head>

<body class="fixed"> <? /*  class="fixed" */ ?>
<? if ((DSConfig::getVal('site_front_theme_use_preloader') == 1) &&
  ($this->id == 'site' && $this->action->id == 'index')) { ?>
  <div class="preloader">
    <img src="<?= $this->frontThemePath ?>/images/loader4.gif"
         alt="СНТ Вирки-2, Ленинградская область, Всеволжский район: загрузка страницы">
  </div>
<? } ?>
<!-- ========= Color Preset ========== -->
<? if (in_array(Yii::app()->user->role, ['admin', 'superAdmin'])) { ?>
  <div class="colorPresetArea">
    <div class="switchTittle">
      <p class="pull-left"><?= Yii::t('main', 'Цветовая схема') ?></p>
      <a href="#" class="gearBtn pull-right"><i class="fa fa-cog"></i></a>
      <div class="clearfix"></div>
    </div>
    <div class="switches">
      <div class="singleSwitch light">
        <p><?= Yii::t('main', 'Выберите основной цвет') ?>:</p>
        <div class="switch mainColors">
          <a href="color1" class="color1 active"></a>
          <a href="color2" class="color2"></a>
          <a href="color3" class="color3"></a>
          <a href="color4" class="color4"></a>
          <a href="color5" class="color5"></a>
          <a href="color6" class="color6"></a>
          <a href="color7" class="color7"></a>
          <a href="color8" class="color8"></a>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="singleSwitch light">
        <p><?= Yii::t('main', 'Выберите стиль') ?>:</p>
        <div class="switch">
          <a href="wide" class="wide layout active"><span></span>Wide</a>
          <a href="box" class="boxed layout"><span></span>Boxed</a>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="singleSwitch" id="patterns">
        <p><?= Yii::t('main', 'Выберите фон') ?>:</p>
        <div class="switch">
          <a href="pat1" class="pat1"></a>
          <a href="pat2" class="pat2"></a>
          <a href="pat3" class="pat3"></a>
          <a href="pat4" class="pat4"></a>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
  </div>
<? } ?>
<!-- ========= End Color Preset ========== -->

<!-- Header -->
<? // Header part for ALL pages
$this->renderPartial('//layouts/header', [], false, false, false); ?>
<? if ($this->id == 'site' && $this->action->id == 'index') { ?>
    <? // Header for main page
    $this->renderPartial('//layouts/_header_for_main', [], false, false, false);
} else {
    $this->renderPartial('//layouts/_header_for_other', [], false, false, false);
} ?>
<!-- end: Header -->

<? // Блок вывода всплывающих сообщений, если они есть?>
<? $this->widget('application.components.widgets.MessagesBlock') ?>
<? //====================================================================================================================?>
<?= $content ?>
<? //====================================================================================================================?>
<? // Footer part for ALL pages
$this->renderPartial('//layouts/footer', [], false, false, false); ?>
<a href="#" id="backToTop"><i class="fa fa-angle-up"></i></a>

<? // Диалог корректировки переводов - используется повсеместно?>
<? if ((Yii::app()->user->checkAccess('site/translate'))) { ?>
    <? /* $this->beginWidget(
      'booster.widgets.TbModal',
      array('id' => 'translationDialog')
    );
    */ ?>
  <div class="modal fade" id="translationDialog" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <a class="close" data-dismiss="modal">x</a>
          <h4><?= Yii::t('main', 'Редактирование перевода') ?></h4>
        </div>
        <div class="modal-body">
            <? $this->renderPartial('//site/translate', []); ?>
        </div>
        <div class="modal-footer">
        </div>

      </div>
    </div>
  </div>
    <? /* $this->endWidget(); ?>*/ ?>
<? } ?>

<? /* All JS liading */ ?>
<? $this->renderPartial('//layouts/dropshopGlobalJs', [], false, false, false); ?>
<script type="text/javascript" src="<?= $this->frontThemePath ?>/js/main.js?v=1.0"></script>
<? /* End of all JS liading */ ?>

<? //Ленивая загрузка изображений. Используется в самых разных местах?>
<? if (DSConfig::getVal('site_images_lazy_load') == 1) { ?>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG ? 'jquery.lazyload.js' :
            'jquery.lazyload.min.js' ?>"></script>
  <script type="text/javascript">
      $(function () {
          // Disabling any price and detail blocks
          $('img.lazy').each(function () {
              $(this).parents('div.product-block').children('div.product-meta').each(function () {
                  $(this).hide();
              });
              $(this).parents('div.product-block').children('div.product-sale').each(function () {
                  $(this).hide();
              });
          });

          // Callback enabling any price and detail blocks
          function onLazyLoad(element, el_left, settings) {
              $(element).parents('div.product-block').children('div.product-meta').each(function () {
                  $(this).show();
              });
              $(element).parents('div.product-block').children('div.product-sale').each(function () {
                  $(this).show();
              });
          }

          $('img.lazy').show().lazyload({
              load: onLazyLoad,
              effect: 'fadeIn',
              effect_speed: 500,
              skip_invisible: false,
              threshold: 200
//                failure_limit: 60,
//                event : 'load'
          });
      });
  </script>
<? } ?>
<!-- Скрипты и счетчики -->
<? /*
<script type="text/javascript">
    setTimeout(function () {
        (function (d, w, c) {
            (w[c] = w[c] || []).push(function () {
                try {
                    w.yaCounter32574110 = new Ya.Metrika({
                        id:32574110,
                        clickmap: true,
                        trackLinks: true,
                    accurateTrackBounce:true,
                    webvisor:true,
                    trackHash:true,
                    ecommerce:"dataLayer"
                    });
                } catch (e) {
                }
            });

            var n = d.getElementsByTagName("script")[0],
                s = d.createElement("script"),
                f = function () {
                    n.parentNode.insertBefore(s, n);
                };
            s.type = "text/javascript";
            s.async = true;
            s.defer = true;
            s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

            if (w.opera == "[object Opera]") {
                d.addEventListener("DOMContentLoaded", f, false);
            } else {
                f();
            }
        })(document, window, "yandex_metrika_callbacks");
    }, 20000);
</script>
<script type="text/javascript">
    setTimeout(function () {
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
            }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.defer = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-46882429-1', 'greenlan.net.ua');
        ga('send', 'pageview');
    }, 30000);

</script>
*/ ?>
<? //defer ?>
<? /*
<script crossorigin="anonymous" defer type="text/javascript"
        src="//api.pozvonim.com/widget/callback/v3/ba5b89597c4e847a7fbef3bfedb580d9/connect" id="check-code-pozvonim" charset="UTF-8">
</script>
*/ ?>
</body>
</html>