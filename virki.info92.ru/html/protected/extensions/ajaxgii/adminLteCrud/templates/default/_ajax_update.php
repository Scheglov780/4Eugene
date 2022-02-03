<?= '<?' ?> /*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* ====================================================================================================================
*
*
<description file="_ajax_update.php">
  *
  *
</description>
**********************************************************************************************************************/ <?= '?>' ?>

<section id="<?= $this->class2id($this->modelClass) ?>-update-modal-container" style="display: none;">
</section>

<script type="text/javascript">
    function update_<?=str_replace('-', '_', $this->class2id($this->modelClass))?>() {
        var data = $("#<?=$this->class2id($this->modelClass); ?>-update-form").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo "<?php"; ?> echo Yii::app()->createAbsoluteUrl("admin/<?php echo lcfirst(
              $this->modelClass
            ); ?>/update"); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#<?=$this->class2id($this->modelClass); ?>-update-modal').modal('hide');
                    $('#<?=$this->class2id($this->modelClass); ?>-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('<?=$this->class2id($this->modelClass); ?>-grid', {});
                    dsAlert(data, 'Message', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function renderUpdateForm_<?=str_replace('-', '_', $this->class2id($this->modelClass))?>(id) {
        var data = 'id=' + id;

        jQuery.ajax({
            type: 'POST',
            url: '<?php echo "<?php"; ?> echo Yii::app()->createAbsoluteUrl("admin/<?php echo lcfirst(
              $this->modelClass
            ); ?>/update"); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#<?=$this->class2id($this->modelClass); ?>-update-modal').remove();
                $('#<?=$this->class2id(
                  $this->modelClass
                ); ?>-update-modal-container').closest('.content').append(data);
                $('#<?=$this->class2id($this->modelClass); ?>-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>
