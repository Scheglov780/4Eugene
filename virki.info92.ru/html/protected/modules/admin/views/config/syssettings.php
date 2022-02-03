<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="syssettings.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  Yii::t('admin', 'Настройки системы'),
];

$this->menu = [
  ['label' => Yii::t('admin', 'Добавить параметр'), 'url' => ['create']],
];
?>

  <h1><?= Yii::t('admin', 'Настройки системы') ?></h1>

<?php foreach ($systemsettings as $setting) { ?>
  <a href="<?= $this->createUrl('/' . Yii::app()->controller->module->id . '/config/update/id/' . $setting['id']) ?>"
     onclick="getContent(this,'<?= addslashes($setting['label']) ?>',false);return false;">
    <div class="view">
      <b><?= $setting['label'] ?>:</b><span class="fa fa-pencil"></span><br>
        <?= $setting['id'] ?>
      <b><?= $setting['value'] ?></b>
    </div>
  </a>
<?php } ?>