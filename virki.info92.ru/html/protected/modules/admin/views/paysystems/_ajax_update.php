<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="pay-systems-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_paysystems() {
        var data = $('#pay-systems-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/paysystems/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#pay-systems-update-modal').modal('hide');
                    $('#pay-systems-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('pay-systems-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderUpdateForm_paysystems(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/paysystems/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#pay-systems-update-modal').remove();
                $('#pay-systems-update-modal-container').closest('.content').append(data);
                $('#pay-systems-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }
</script>
