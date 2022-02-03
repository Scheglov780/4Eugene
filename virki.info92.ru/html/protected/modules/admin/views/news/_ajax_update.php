<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="news-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_news() {
        var instance = CKEDITOR.instances['news_news_body_update'];
        if (instance) {
            instance.updateElement();
        }
        var data = $('#news-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/news/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#news-update-modal').modal('hide');
                    $('#news-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('news-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_news(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/news/update'); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                var instance = CKEDITOR.instances['news_news_body_update'];
                if (instance) {
                    instance.destroy(true);
                }
                $('#news-update-modal').remove();
                $('#news-update-modal-container').closest('.content').append(data);
                CKEDITOR.replace('news_news_body_update');
                $('#news-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
