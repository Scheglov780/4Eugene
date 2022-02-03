<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var votingsVoteForm $model */
?>
<div class="modal fade" id="votings-create-vote-modal-<?= $model->votings_id ?>" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новое подтверждение прочтения') ?><?= Utils::getHelp(
              'createVote',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'votings-create-vote-form-' . $model->votings_id,
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["votings/createVote"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => "js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_votings_vote_{$model->votings_id} ();
                                        }
                                     }",
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php
          //votings_results_id votings_id uid created result
          echo $form->uneditableRow(
            $model,
            'votings_id',
            ['id' => 'votings_vote_create_votings_id_' . $model->votings_id]
          );
          $htmlOptions['id'] = 'votings_vote_create_uid_' . $model->votings_id;
          echo $form->dropDownListRow(
            $model,
            'uid',
            [
              'widgetOptions' => [
                'data'        => Users::getListData(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          );

          ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size'        => 'mini',
              'icon'        => 'fa fa-check',
              'label'       => Yii::t('main', 'Добавить'),
              'htmlOptions' => ['onclick' => "create_votings_vote_{$model->votings_id} ();"],
            ]
          );
          ?>
          <?
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
                //'id'=>'sub2',
              'type'        => 'default',
              'icon'        => 'fa fa-close', //fa-inverse
              'label'       => Yii::t('main', 'Отмена'),
              'htmlOptions' => ['data-dismiss' => 'modal'],
            ]
          );
          ?>
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'type'        => 'default',
                //'size'       => 'mini',
              'icon'        => 'fa fa-rotate-left',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
    function create_votings_vote_<?=$model->votings_id?> () {
        var data = $("#votings-create-vote-form-<?=$model->votings_id?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/votings/createVote'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#votings-create-vote-modal-<?=$model->votings_id?>').modal('hide');
                    $.fn.yiiGridView.update('votings-vote-grid-<?=$model->votings_id?>', {});
                    dsAlert(data, 'Сохранение', true);
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });
    }

    function renderCreateForm_votings_vote_<?=$model->votings_id?>() {
        $('#votings-create-vote-form-<?=$model->votings_id?>').each(function () {
            this.reset();
        });
        $('#votings-create-vote-modal-<?=$model->votings_id?>').modal('show');
    }

</script>
