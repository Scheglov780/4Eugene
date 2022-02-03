<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="dropshop.global.js.php">
 * </description>
 * Набор jawaScript, использующегося во всех view
 **********************************************************************************************************************/
?>
  <!-- default styles -->
<? // JQuery 1.x compatibility debug and fix
/** @var \nlac\NLSClientScript $cs */
$cs = Yii::app()->clientScript;
if (YII_DEBUG && JQUERY_MIGRATE) {
    $cs->scriptMap['jquery-migrate.js'] = $this->frontThemePath . '/js/jquery-migrate-3.1.0.min.js';
} else {
    $cs->scriptMap['jquery-migrate.js'] = false;
}
$deepJsDebug = false;
?>
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
<script src="<?= $this->frontThemePath ?>/js/html5shiv.min.js"></script>
<script src="<?= $this->frontThemePath ?>/js/respond.min.js"></script>
<![endif]-->

  <!-- Include All JS -->
<? /*
<script type="text/javascript" src="<?= $this->frontThemePath ?>/js/jquery.js"></script>
<script type="text/javascript" src="<?= $this->frontThemePath ?>/js/bootstrap.min.js"></script>
*/ ?>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'jquery.themepunch.tools.js' :
            'jquery.themepunch.tools.min.js' ?>"></script>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'jquery.themepunch.revolution.js' :
            'jquery.themepunch.revolution.min.js' ?>"></script>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'owl.carousel.js' :
            'owl.carousel.min.js' ?>"></script>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'jquery.magnific-popup.js' :
            'jquery.magnific-popup.min.js' ?>"></script>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'mixer.js' : 'mixer.min.js' ?>"></script>
  <script type="text/javascript"
          src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'theme.js' : 'theme.min.js' ?>"></script>

<? //AjaxQ ajax manager?>
  <script src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'ajaxq.js' : 'ajaxq.min.js' ?>"></script>

  <!-- Bootstrap STAR RAITING -->
  <!-- important mandatory libraries -->
  <script src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'star-rating.js' :
    'star-rating.min.js' ?>"></script>

  <!-- optionally if you need to use a theme, then include the theme JS file as mentioned below -->
  <!--<script src="<? //= $this->frontThemePath ?>/css/themes/krajee-svg/theme.js"></script>-->

  <!-- optionally if you need translation for your language then include locale file as mentioned below -->
<? if (Utils::appLang() != 'en') {
//TODO: Здесь потом проверить, а есть ли файлик в наличии?
    ?>
  <script defer src="<?= $this->frontThemePath ?>/js/locales/<?= Utils::appLang() ?>.js"></script>
<? } ?>
  <!-- Bootstrap Datepicker -->
  <script src="<?= $this->frontThemePath ?>/js/<?= YII_DEBUG && $deepJsDebug ? 'bootstrap-datepicker.js' :
    'bootstrap-datepicker.min.js' ?>"></script>
<? /*
<script defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<script defer type="text/javascript" src="<?= $this->frontThemePath ?>/js/gmaps.min.js"></script>
*/ ?>