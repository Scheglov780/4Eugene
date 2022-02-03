<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="payment-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_payments() {

        var data = $('#payment-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/payments/update'
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#payment-update-modal').modal('hide');
                    $('#payment-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('payment-grid-<?=($model->uid ? $model->uid : 'all')?>', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_payments(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/payments/update'
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#payment-update-modal').remove();
                $('#payment-update-modal-container').closest('.content').append(data);
                $('#payment-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
