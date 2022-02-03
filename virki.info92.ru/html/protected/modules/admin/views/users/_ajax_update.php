<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="users-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_users() {

        var data = $('#users-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/users/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#users-update-modal').modal('hide');
                    $('#users-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('users-grid', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_users(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/users/update'); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data); 
                //$('#users-update-modal-container').html(null);
                $('#users-update-modal').remove();
                $('#users-update-modal-container').closest('.content').append(data);
                $('#Users_lands_update').select2(
                    {
                        allowClear: true,
                        placeholder: 'Клик для выбора участков'
                    }
                );
                $('#users-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
