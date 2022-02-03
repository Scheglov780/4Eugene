<section id="cms-custom-content-update-modal-container" style="display: none;">
</section>
<script type="text/javascript">
    function update_cmsCustomContent() {

        var data = $('#cms-custom-content-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsCustomContent/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#cms-custom-content-update-modal').modal('hide');
                    $('#cms-custom-content-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('cms-custom-content-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_cmsCustomContent(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsCustomContent/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#cms-custom-content-update-modal').remove();
                $('#cms-custom-content-update-modal-container').closest('.content').append(data);
                $('#cms-custom-content-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
