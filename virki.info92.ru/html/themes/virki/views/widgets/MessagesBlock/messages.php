<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="messages.php">
 * </description>
 * Виджет отображения инлайн-сообщений и оповещений
 **********************************************************************************************************************/
?>
<? /*
<div id="message-block">
    <a href="javascript:void(0);" id="message-close"></a>
    <? foreach ($messages as $key => $mess) { ?>
        <div class="message blue" id="message-<?= $key ?>">
            <div class="message-text">
                <h3 class="title"><?= Yii::t('main', 'Внимание') ?>!</h3>
                <?= $mess ?>
            </div>
            <div class="message-bottom"></div>
        </div>
    <? } ?>
</div>
*/ ?>
<div class="modal fade" tabindex="-1" role="dialog" id="message-block">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
              aria-hidden="true">x</span></button>
        <h3 class="title"><?= Yii::t('main', 'Внимание') ?>!</h3>
      </div>
      <div class="modal-body">
          <? foreach ($messages as $key => $mess) { ?>
            <div id="message-<?= $key ?>">
              <!--<p>One fine body&hellip;</p>-->
                <?= $mess ?>
            </div>
            <div class="message-bottom"></div>
          <? } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal"><?= Yii::t(
              'main',
              'Закрыть'
            ) ?></button>
        <!--
                        <button type="button" class="btn btn-primary"></button>
        -->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    $('#message-block').modal('show');
</script>
