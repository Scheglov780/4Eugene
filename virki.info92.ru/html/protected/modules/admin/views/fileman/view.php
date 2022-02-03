<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/* @var $this FeaturedController */
/* @var $dataProvider CActiveDataProvider */
$this->breadcrumbs = [
  Yii::t('main', 'Менеджер файлов'),
];
// Elfinder
$assetsUrl = Yii::app()->getAssetManager()->publish(
  Yii::getPathOfAlias('ext.elrte.lib'),
  false,
  -1,
  YII_DEBUG
);
$cs = Yii::app()->clientScript;
$cs->registerCssFile($assetsUrl . '/elfinder/css/elfinder.min.css');
$cs->registerCssFile($assetsUrl . '/elfinder/css/theme.css');
$cs->registerScriptFile($assetsUrl . '/elfinder/js/elfinder.min.js');
$basePath = Yii::getPathOfAlias('webroot') . $assetsUrl;
if (file_exists($basePath . '/elfinder/js/i18n/elfinder.' . Utils::appLang() . '.js')) {
    $cs->registerScriptFile(
      $assetsUrl . '/elfinder/js/i18n/elfinder.' . Utils::appLang() . '.js',
      null,
      ['charset' => 'utf-8']
    );
}
?>

<h1><?= Yii::t('main', 'Менеджер файлов') ?></h1>
<div id="standalone-filemanager"></div>
<script type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $(document).ready(function () {
        $('#standalone-filemanager').elfinder({
            url: '/<?=Yii::app()->controller->module->id?>/fileman/index'  // connector URL (REQUIRED)
            , lang: '<?=Utils::appLang()?>'                    // language (OPTIONAL)
            , resizable: false
            , height: '1024px'
            , width: '100%'
            , showFiles: '2'
        });
    });
</script>