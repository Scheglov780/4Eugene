<section id="formulas-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_formulas() {

        var data = $('#formulas-update-form').serialize();

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/formulas/update"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#formulas-update-modal').modal('hide');
                    $('#formulas-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('formulas-grid', {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);

            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_formulas(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/formulas/update"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#formulas-update-modal').remove();
                $('#formulas-update-modal-container').closest('.content').append(data);
                $('#formulas-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
