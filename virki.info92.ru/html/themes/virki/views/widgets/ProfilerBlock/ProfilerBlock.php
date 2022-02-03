<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ProfilerBlock.php">
 * </description>
 * Виджет отображения информации профайлера
 **********************************************************************************************************************/
?>
<? if (isset($profiling) && is_array($profiling)) { ?>
  <div class="profiler" translate="no">
    <div class="block" id="search-terms">
      <h4><?= Yii::t('main', 'Время выполнения') ?></h4>

      <div class="block-content">
      <span style="font-size: 12px;">
      <? foreach ($profiling as $rec => $i) {
          if (strpos($i, '*') === 0) {
              ?>
            <i><?= $i ?></i><br/>
              <?
          } else {
              if (($rec <> 'start') && ($rec <> 'stop')) {
                  $s = $rec;
                  if ($rec == 'duration') {
                      $s = '<u>' . 'Total' . '</u>';
                  }
                  ?>
                <b><?= $s ?>:</b>&nbsp;<?= $i ?>s.<br/>
                  <?
              }
          }
      } ?>
      </span>
      </div>
    </div>
  </div>
<? } ?>