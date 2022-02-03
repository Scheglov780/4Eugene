<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="image-lib-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_imagelib() {
        var data = $('#image-lib-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/imagelib/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#image-lib-update-modal').modal('hide');
                    $('#image-lib-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('image-lib-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderUpdateForm_imagelib(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/imagelib/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#image-lib-update-modal').remove();
                $('#image-lib-update-modal-container').closest('.content').append(data);
                $('#image-lib-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }
</script>
