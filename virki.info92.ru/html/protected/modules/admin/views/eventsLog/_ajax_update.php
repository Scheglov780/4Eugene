<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div id="events-log-update-modal-container">

</div>

<script type="text/javascript">
    function update_eventsLog() {

        var data = $('#events-log-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/events-log/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#events-log-update-modal').modal('hide');
                    $('#events-log-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('events-log-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_eventsLog(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/events-log/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#events-log-update-modal-container').html(data);
                $('#events-log-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
