<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="config-update-modal-container" style="display: none;">
</section>
<script type="text/javascript">
    function update_config() {

        var data = $('#config-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/config/update"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#config-update-modal').modal('hide');
                    $('#config-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('config-grid', {});
                    $.fn.yiiGridView.update('config-grid-maink', {});
                    $.fn.yiiGridView.update('config-grid-currencyrates', {});
                    $.fn.yiiGridView.update('config-grid-pricerates', {});
                    $.fn.yiiGridView.update('config-grid-countrates', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_config(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/config/update"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#config-update-modal').remove();
                $('#config-update-modal-container').closest('.content').append(data);
                $('#config-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
