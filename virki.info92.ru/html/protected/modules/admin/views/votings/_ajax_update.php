<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<section id="votings-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_votings() {
        var instance = CKEDITOR.instances['votings_votings_query_update'];
        if (instance) {
            instance.updateElement();
        }
        var data = $('#votings-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/votings/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#votings-update-modal').modal('hide');
                    $('#votings-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('votings-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderUpdateForm_votings(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/votings/update'); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                var instance = CKEDITOR.instances['votings_votings_query_update'];
                if (instance) {
                    instance.destroy(true);
                }
                $('#votings-update-modal').remove();
                $('#votings-update-modal-container').closest('.content').append(data);
                CKEDITOR.replace('votings_votings_query_update');
                $('#votings-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
