<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="parserupdate.php">
 * </description>
 **********************************************************************************************************************/ ?>
<h3><?= Yii::t('admin', 'Настройки DropShop grabber') ?></h3>

<div id="dsg-tabs" style="overflow-y: auto">
  <ul>
    <li><a href="#tab-dsg-edit"><?= Yii::t('admin', 'XML') ?></a></li>
    <!-- <li><a href="#tab-dsg-debug"><? //=Yii::t('main','Отладка')?></a></li> -->
  </ul>
  <div id="tab-dsg-edit">
      <? echo $this->renderPartial('_parserform', ['model' => $settings]); ?>
  </div>
  <!--  <div id="tab-dsg-debug">
    <? // $this->renderPartial('_parserdebugform', array()); ?>
  </div> -->
</div>

<script>
    $(function makeDSGSubTabs() {
        $('#dsg-tabs').tabs({
            cache: false
        });
    });
</script>