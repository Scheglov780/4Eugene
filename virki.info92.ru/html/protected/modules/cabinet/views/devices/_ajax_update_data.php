<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="devices-data-update-modal-container-<?= $deviceId ?>" style="display: none;">
</section>

<script type="text/javascript">
    function update_device_data_<?=$deviceId?>() {

        var data = $("#devices-data-update-form-<?=$deviceId?>").serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/devices/updateData"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#devices-data-update-modal-<?=$deviceId?>').modal('hide');
                    $('#devices-data-update-modal-<?=$deviceId?>').data('modal', null);
                    $.fn.yiiGridView.update('device-data-grid-<?=$deviceId?>', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_devices_data_<?=$deviceId?>(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/devices/updateData"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#devices-data-update-modal-<?=$deviceId?>').remove();
                $('#devices-data-update-modal-container-<?=$deviceId?>').closest('.content').append(data);
                $('#devices-data-update-modal-<?=$deviceId?>').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
