<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div id="log-site-errors-update-modal-container">

</div>

<script type="text/javascript">
    function update_errorlog() {

        var data = $('#log-site-errors-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/errorlog/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#log-site-errors-update-modal').modal('hide');
                    $('#log-site-errors-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('log-site-errors-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_errorlog(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/errorlog/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data); 
                $('#log-site-errors-update-modal-container').html(data);
                $('#log-site-errors-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
