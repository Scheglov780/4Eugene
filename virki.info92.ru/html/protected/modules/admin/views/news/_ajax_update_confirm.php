<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="news-confirm-update-modal-container-<?= $newsId ?>" style="display: none;">
</section>

<script type="text/javascript">
    function update_news_confirm_<?=$newsId?>() {

        var data = $("#news-confirm-update-form-<?=$newsId?>").serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/news/updateConfirm'
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#news-confirm-update-modal-<?=$newsId?>').modal('hide');
                    $('#news-confirm-update-modal-<?=$newsId?>').data('modal', null);
                    $.fn.yiiGridView.update('news-confirm-grid-<?=$newsId?>', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_news_confirm_<?=$newsId?>(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/news/updateData'
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#news-confirm-update-modal-<?=$newsId?>').remove();
                $('#news-confirm-update-modal-container-<?=$newsId?>').closest('.content').append(data);
                $('#news-confirm-update-modal-<?=$newsId?>').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
