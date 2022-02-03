<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="devices-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_devices() {

        var data = $('#devices-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/devices/update"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#devices-update-modal').modal('hide');
                    $('#devices-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('devices-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_devices(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/devices/update"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#devices-update-modal').remove();
                $('#devices-update-modal-container').closest('.content').append(data);
                $('#devices_lands_update').select2(
                    {
                        allowClear: true,
                        placeholder: 'Клик для выбора участков'
                    }
                );
                $('#devices_tariffs_update').select2(
                    {
                        allowClear: true,
                        placeholder: 'Клик для выбора тарифов'
                    }
                );
                $('#devices-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
