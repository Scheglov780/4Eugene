<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="delivery.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
$this->breadcrumbs = [
  Yii::t('admin', 'Доставка'),
];

$this->menu = [
  ['label' => Yii::t('admin', 'Добавить параметр'), 'url' => ['create']],
];
?>

  <h1><?= Yii::t('admin', 'Доставка - настройки') ?></h1>

<?php foreach ($settings as $setting): ?>
  <div class="view">
    <b><?= $setting['id'] ?></b><br/>
    <i><?= $setting['label'] ?>:</i><br/><?= DSConfig::formatXML(
        nl2br(htmlspecialchars($setting['value'], ENT_QUOTES))
      ) ?><br/>
    <a href="<?= $this->createUrl('/' . Yii::app()->controller->module->id . '/config/update/id/' . $setting['id']) ?>"
       onclick="getContent(this,'<?= addslashes($setting['id']) ?>',false);return false;"><b><?= Yii::t(
              'main',
              'изменить'
            ) ?></b></a>
  </div>
<?php endforeach ?>