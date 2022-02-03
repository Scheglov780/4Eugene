<div id="scheduled-jobs-update-modal-container">

</div>

<script type="text/javascript">
    function update_scheduledJobs() {

        var data = $('#scheduled-jobs-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/scheduled-jobs/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#scheduled-jobs-update-modal').modal('hide');
                    $('#scheduled-jobs-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('scheduled-jobs-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_scheduledJobs(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/scheduled-jobs/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data); 
                $('#scheduled-jobs-update-modal-container').html(data);
                $('#scheduled-jobs-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
