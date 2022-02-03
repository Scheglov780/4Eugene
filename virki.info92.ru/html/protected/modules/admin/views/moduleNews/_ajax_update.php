<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="module-news-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_ModuleNews() {
        var data = $('#module-news-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/ModuleNews/update'
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#module-news-update-modal').modal('hide');
                    $('#module-news-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('module-news-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_ModuleNews(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/ModuleNews/update'
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#module-news-update-modal').remove();
                $('#module-news-update-modal-container').closest('.content').append(data);
                $('#module-news-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
