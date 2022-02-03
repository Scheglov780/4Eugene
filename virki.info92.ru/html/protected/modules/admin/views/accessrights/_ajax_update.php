<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="accessrights-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_accessrights() {

        var data = $('#accessrights-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/accessrights/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#accessrights-update-modal').modal('hide');
                    $('#accessrights-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('accessrights-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_accessrights(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/accessrights/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#accessrights-update-modal').remove();
                $('#accessrights-update-modal-container').closest('.content').append(data);
                $('#accessrights-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
