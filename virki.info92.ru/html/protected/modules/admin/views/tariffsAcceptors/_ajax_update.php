<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="tariffs-acceptors-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_tariffs_acceptors() {
        var data = $('#tariffs-acceptors-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/tariffsAcceptors/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#tariffs-acceptors-update-modal').modal('hide');
                    $('#tariffs-acceptors-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('tariffs-acceptors-grid', {});
                    dsAlert(data, 'Message', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_tariffs_acceptors(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/tariffsAcceptors/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#tariffs-acceptors-update-modal').remove();
                $('#tariffs-acceptors-update-modal-container').closest('.content').append(data);
                $('#tariffs-acceptors-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
