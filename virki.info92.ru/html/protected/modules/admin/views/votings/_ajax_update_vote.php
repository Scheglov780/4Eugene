<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update.php">
 * </description>
 **********************************************************************************************************************/ ?>

<section id="votings-vote-update-modal-container-<?= $votingsId ?>" style="display: none;">
</section>

<script type="text/javascript">
    function update_votings_voting_<?=$votingsId?>() {

        var data = $("#votings-vote-update-form-<?=$votingsId?>").serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/votings/updateVote'
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#votings-vote-update-modal-<?=$votingsId?>').modal('hide');
                    $('#votings-vote-update-modal-<?=$votingsId?>').data('modal', null);
                    $.fn.yiiGridView.update('votings-vote-grid-<?=$votingsId?>', {});
                    dsAlert(data, 'Message', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_votings_vote_<?=$votingsId?>(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/votings/updateData'
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#votings-vote-update-modal-<?=$votingsId?>').remove();
                $('#votings-vote-update-modal-container-<?=$votingsId?>').closest('.content').append(data);
                $('#votings-vote-update-modal-<?=$votingsId?>').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
