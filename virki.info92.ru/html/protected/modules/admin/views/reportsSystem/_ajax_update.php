<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div id="reports-system-update-modal-container">

</div>

<script type="text/javascript">
    function update_reportsSystem() {

        var data = $('#reports-system-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/reportsSystem/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#reports-system-update-modal').modal('hide');
                    $('#reports-system-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('reports-system-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_reportsSystem(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/reportsSystem/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#reports-system-update-modal-container').html(data);
                $('#reports-system-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
