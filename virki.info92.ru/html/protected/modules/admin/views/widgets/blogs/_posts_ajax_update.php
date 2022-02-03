<section id="blog-posts-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function updateBlogPosts() {
        var data = $('#blog-posts-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?= Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/blogs/postsUpdate"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#blog-posts-update-modal').modal('hide');
//                    $('#blog-posts-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('blog-posts-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderUpdateBlogPostsForm(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?= Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/blogs/postsUpdate"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#blog-posts-update-modal').remove();
                $('#blog-posts-update-modal-container').closest('.content').append(data);
                $('#blog-posts-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
