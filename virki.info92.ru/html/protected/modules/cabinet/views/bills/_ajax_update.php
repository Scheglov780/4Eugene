<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="bills-update-modal-container-<?= ($type ? $type : 'all') ?>" style="display: none;">
</section>

<script type="text/javascript">
    function update_bills_<?=($type ? $type : 'all')?>() {
        var data = $("#bills-update-form-<?=($type ? $type : 'all')?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/bills/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#bills-update-modal-<?=($type ? $type : 'all')?>').modal('hide');
                    $('#bills-update-modal-<?=($type ? $type : 'all')?>').data('modal', null);
                    $.fn.yiiGridView.update('bills-grid-<?=($type ? $type : 'all')?>', {});
                    dsAlert(data, 'Message', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_bills_<?=($type ? $type : 'all')?>(id) {
        var data = {'id': id, 'type': '<?=($type ? $type : 'all')?>'};

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/bills/update'); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#bills-update-modal-<?=($type ? $type : 'all')?>').remove();
                $('#bills-update-modal-container-<?=($type ? $type : 'all')?>').closest('.content').append(data);
                $('#bills-update-modal-<?=($type ? $type : 'all')?>').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
