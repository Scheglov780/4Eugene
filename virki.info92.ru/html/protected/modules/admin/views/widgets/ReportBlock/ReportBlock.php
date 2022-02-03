<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ReportBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="row-fluid">
  <div class="span12">
    <h4 class="acchdr2-<?= $report->group ?>"><?= $report->name ?></h4>
    <div>
      <div class="row-fluid">
        <div class="span12">
            <?
            try {
                eval($report->script);
            } catch (Exception $e) {
                CVarDumper::dumpAsString($e, 3, true);
            }
            ?>
        </div>
      </div>
      <div class="row-fluid">
        <div class="span12">
            <?= $report->description ?>
        </div>
      </div>
    </div>
  </div>
</div>


