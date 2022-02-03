<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="events-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_events() {

        var data = $('#events-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/events/update"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#events-update-modal').modal('hide');
                    $('#events-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('events-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_events(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/events/update"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#events-update-modal').remove();
                $('#events-update-modal-container').closest('.content').append(data);
                $('#events-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
