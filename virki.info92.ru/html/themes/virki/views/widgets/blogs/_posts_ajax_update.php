<div id="blog-posts-update-modal-container">

</div>

<script type="text/javascript">
    function updateBlogPosts() {
        var data = $('#blog-posts-update-form').serialize();
        //noinspection AnonymousFunctionJS,AnonymousFunctionJS
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("blog/postsUpdate"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#blog-posts-update-modal').modal('hide');
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
        $('#blog-posts-update-modal').modal('hide');
        //noinspection AnonymousFunctionJS,AnonymousFunctionJS
        jQuery.ajax({
            type: 'POST',
            url: '<?= Yii::app()->createAbsoluteUrl("blog/postsUpdate"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#blog-posts-update-modal-container').html(data);
                //$("#BlogPosts_start_date").datepicker({dateFormat: "yy-mm-dd"});
                //$("#BlogPosts_end_date").datepicker({dateFormat: "yy-mm-dd"});
                $('#blog-posts-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
                dsAlert('Error occured, please try again', '', true);
            },
            dataType: 'html'
        });

    }
</script>
