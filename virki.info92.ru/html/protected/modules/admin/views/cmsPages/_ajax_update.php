<section id="cms-pages-update-modal-container" style="display: none;">
</section>
<script type="text/javascript">
    function update_cmsPages() {

        var data = $('#cms-pages-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsPages/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#cms-pages-update-modal').modal('hide');
                    $('#cms-pages-update-modal').data('modal', null);
//                  $.fn.yiiGridView.update('cms-pages-grid', {
//                         });
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateFormPages(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsPages/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#cms-pages-update-modal').remove();
                $('#cms-pages-update-modal-container').closest('.content').append(data);
                $('#cms-pages-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
