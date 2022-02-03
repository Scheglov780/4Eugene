<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="pools-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_pools() {
        var instance = CKEDITOR.instances['pools_votings_query_update'];
        if (instance) {
            instance.updateElement();
        }
        var data = $('#pools-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/pools/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#pools-update-modal').modal('hide');
                    $('#pools-update-modal').data('modal', null);
                    $.fn.yiiListView.update('cabinet-pools-list-view', {});
                    dsAlert(data, 'Сохранение', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_pools(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/pools/update'); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                var instance = CKEDITOR.instances['pools_votings_query_update'];
                if (instance) {
                    instance.destroy(true);
                }
                $('#pools-update-modal').remove();
                $('#pools-update-modal-container').closest('.content').append(data);
                CKEDITOR.replace('pools_votings_query_update');
                $('#pools-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });
    }
</script>
