<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="lands-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_lands() {

        var data = $('#lands-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/lands/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#lands-update-modal').modal('hide');
                    $('#lands-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('lands-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_lands(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/lands/update'); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#lands-update-modal').remove();
                $('#lands-update-modal-container').closest('.content').append(data);
                $('#Lands_devices_update').select2(
                    {
                        allowClear: true,
                        placeholder: 'Клик для выбора приборов'
                    }
                );
                $('#Lands_users_update').select2(
                    {
                        allowClear: true,
                        placeholder: 'Клик для выбора пользователей'
                    }
                );
                $('#lands-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
