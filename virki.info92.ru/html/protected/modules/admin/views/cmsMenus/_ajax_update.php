<section id="cms-menus-update-modal-container" style="display: none;">
</section>
<script type="text/javascript">
    function update_cmsMenus() {

        var data = $('#cms-menus-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsMenus/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#cms-menus-update-modal').modal('hide');
                    $('#cms-menus-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('cms-menus-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_cmsMenus(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsMenus/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#cms-menus-update-modal').remove();
                $('#cms-menus-update-modal-container').closest('.content').append(data);
                $('#cms-menus-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
