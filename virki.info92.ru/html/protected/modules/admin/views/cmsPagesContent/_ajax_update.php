<section id="cms-pages-content-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_cmsPagesContent() {

        var data = $('#cms-pages-content-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsPagesContent/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#cms-pages-content-update-modal').modal('hide');
                    $('#cms-pages-content-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('cms-pages-content-grid', {});
                    $.fn.yiiGridView.update('cms-pages-content-tree', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_cmsPagesContent(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsPagesContent/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#cms-pages-content-update-modal').remove();
                $('#cms-pages-content-update-modal-container').closest('.content').append(data);
                $('#cms-pages-content-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
