<section id="blog-categories-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function updateBlogCategories() {
        var data = $('#blog-categories-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/categoriesUpdate"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#blog-categories-update-modal').modal('hide');
                    $('#blog-categories-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('blog-categories-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderUpdateBlogCategoriesForm(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/categoriesUpdate"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#blog-categories-update-modal').remove();
                $('#blog-categories-update-modal-container').closest('.content').append(data);
                $('#blog-categories-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
