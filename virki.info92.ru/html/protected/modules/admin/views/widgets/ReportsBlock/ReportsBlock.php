<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ReportsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="row-fluid">
  <div class="span12">
    <div id="reports-accordion-<?= $group ?>">
      <h3 class="acchdr-<?= $group ?>"><?= $title ?></h3>
      <div>
        <div id="report-accordion-<?= $group ?>">
            <? foreach ($reports as $report) { ?>
                <? $this->widget(
                  'application.components.widgets.ReportBlock',
                  [
                    'report' => $report,
                    'params' => $params,
                  ]
                );
                ?>
            <? } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(function () {
        $("#reports-accordion-<?=$group?>").accordion({
            header: 'h3.acchdr-<?=$group?>',
            collapsible: true,
            active: 0,
            heightStyle: 'content'
        });
        $("#report-accordion-<?=$group?> > div").accordion({
            header: 'h4.acchdr2-<?=$group?>',
            collapsible: true,
            active: 0,
            heightStyle: 'content'
        });
        $("#report-accordion-<?=$group?> > div").on('accordionactivate', function (event, ui) {
            if (ui.newPanel.length > 0) {
                //ui.newPanel.resize();
            }
        });
    });
</script>
