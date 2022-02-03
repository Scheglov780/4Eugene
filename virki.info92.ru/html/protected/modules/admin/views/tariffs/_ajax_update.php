<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="tariffs-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_tariffs() {
        var data = $('#tariffs-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/tariffs/update"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#tariffs-update-modal').modal('hide');
                    $('#tariffs-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('tariffs-grid', {});
                    dsAlert(data, 'Message', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_tariffs(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/tariffs/update"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#tariffs-update-modal').remove();
                $('#tariffs-update-modal-container').closest('.content').append(data);
                $('#tariffs-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
