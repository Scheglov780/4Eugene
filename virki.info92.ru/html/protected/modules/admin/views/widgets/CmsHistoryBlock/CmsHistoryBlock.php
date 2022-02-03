<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleNewsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?
/** @var CActiveDataProvider $dataProvider */
$data = $dataProvider->data;
?>
<? if ($data && is_array($data) && count($data)) { ?>
  <div class="btn-group">
    <button type="button" class="btn btn-default"><?= Yii::t('main', 'История') ?></button>
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
      <span class="sr-only"><?= Yii::t('main', 'Список') ?></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <? foreach ($data as $rec) { ?>
          <li><a href="#" title="<?= Yii::t('main', 'Восстановить') ?>"
                 onclick="cmsHistoryRestore('<?= $rec['id'] ?>'); return false;"><?= $rec['date'] ?></a></li>
        <? } ?>
    </ul>
  </div>
<? } ?>