<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="diccustom-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_diccustom() {

        var data = $('#diccustom-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/dicCustom/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#diccustom-update-modal').modal('hide');
                    $('#diccustom-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('diccustom-grid', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_diccustom(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/dicCustom/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#diccustom-update-modal').remove();
                $('#diccustom-update-modal-container').closest('.content').append(data);
                $('#diccustom-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
