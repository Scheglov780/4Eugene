<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?
/** @var Votings $model */
$module = Yii::app()->controller->module->id;
?>
<section class="content-header">
  <h1><?= Yii::t('main', 'Голосование') ?>: #<?= $model->votings_id ?> <?= Utils::getHelp(
        'update',
        true
      ) ?></h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <? /** @var Votings $model */
        ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= Yii::t('main', 'Редактирование голосования') ?>
            #<?= $model->votings_id ?></h3>
        </div>
          <? /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'votings-update-form-single-' . $model->votings_id,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["votings/update"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",/* Disable normal form submit */
                  //'onkeypress'=>" if(event.keyCode == 13){ update_votings (); } "
                  /* Do ajax call when land presses enter key */
              ],
            ]
          ); ?>
        <div class="box-body">
            <?php echo $form->errorSummary($model); ?>
            <?php echo $form->uneditableRow(
              $model,
              'votings_id',
              ['id' => 'votings_votings_id_update-single-' . $model->votings_id]
            ); ?>
            <?
            $htmlOptions['id'] = 'votings_votings_type_update-single-' . $model->votings_id;
            echo $form->dropDownListRow(
              $model,
              'votings_type',
              [
                'widgetOptions' => [
                  'data'        => DicCustom::getVals('VOTING_TYPE'),
                  'htmlOptions' => $htmlOptions,
                ],
              ]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'votings_header',
              ['id' => 'votings_votings_header_update-single-' . $model->votings_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'votings_query',
              ['id' => 'votings_votings_query_update-single-' . $model->votings_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'votings_variants',
              ['id' => 'votings_votings_variants_update-single-' . $model->votings_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'votings_summary',
              ['id' => 'votings_votings_summary_update-single-' . $model->votings_id]
            ); ?>
            <?php
            echo $form->uneditableRow(
              $model,
              'votings_author_name',
              ['id' => 'votings_votings_author_update-single-' . $model->votings_id]
            ); ?>
            <?php
            $model->date_actual_start = Utils::pgDateToStr($model->date_actual_start, 'Y-m-d');
            echo $form->dateFieldRow(
              $model,
              'date_actual_start',
              ['id' => 'votings_date_actual_start_update-single-' . $model->votings_id]
            ); ?>
            <?php
            $model->date_actual_end = Utils::pgDateToStr($model->date_actual_end, 'Y-m-d');
            echo $form->dateFieldRow(
              $model,
              'date_actual_end',
              ['id' => 'votings_date_actual_end_update-single-' . $model->votings_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'recipients',
              ['id' => 'votings_recipients_update-single-' . $model->votings_id]
            ); ?>
            <?php
            $model->created = Utils::pgDateToStr($model->created);
            echo $form->uneditableRow(
              $model,
              'created',
              ['id' => 'votings_created_update-single-' . $model->votings_id]
            ); ?>
            <?php echo $form->checkboxRow(
              $model,
              'enabled',
              ['id' => 'votings_enabled_update-single-' . $model->votings_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'comments',
              ['id' => 'votings_comments_update-single-' . $model->votings_id]
            ); ?>
        </div>
        <div class="box-footer">
            <?php $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'type'        => 'default',
                  //'size' => 'mini',
                'icon'        => 'fa fa-check',
                'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t(
                  'main',
                  'Сохранить'
                ),
                'htmlOptions' => [
                  'class'   => 'pull-right',
                  'onclick' => "update_votings_{$model->votings_id} ();",
                ],
              ]
            );
            ?>
            <?php $this->widget(
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
          <?php
          $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Результаты голосования</h3>
        </div>
        <div class="box-body">
            <?php
            $this->widget(
              'booster.widgets.TbMenu',
              [
                'type'  => 'pills',
                'items' => [
                    //   array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
                  [
                    'label'       => Yii::t('main', 'Добавить голос'),
                    'icon'        => 'fa fa-plus',
                    'url'         => 'javascript:void(0);',
                    'linkOptions' => ['onclick' => "renderCreateForm_votings_vote_{$model->votings_id} ()"],
                    'visible'     => true,
                  ],
                ],
              ]
            );
            ?>
            <?php
            $dataDataProvider = Votings::getVotingsVotes($model->votings_id, 100);
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'votings-vote-grid-' . $model->votings_id,
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',//
                'dataProvider'    => $dataDataProvider,
                  //'filter'          => false,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                    //votings_vote_id	votings_id	row_num	percent	uid	created	created_left	total_left	result	fullname
                  [
                    'type'   => 'raw',
                    'name'   => 'created',
                    'header' => 'Дата голосования',
                    'value'  => function ($data) {
                        return Utils::pgDateToStr($data['created']);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'created_left',
                    'header' => 'Прошло с момента голосования',
                    'value'  => function ($data) {
                        return Utils::pgIntervalToStr($data['created_left']);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'total_left',
                    'header' => 'Прошло с начала голосования',
                    'value'  => function ($data) {
                        return Utils::pgIntervalToStr($data['total_left']);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'fullname',
                    'header' => 'Абонент',
                    'value'  => function ($data) {
                        return $data['fullname'];
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'percent',
                    'header' => 'Процент проголосовавших',
                    'value'  => function ($data) {
                        return $data['percent'];
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'result_name',
                    'header' => 'Голос',
                    'value'  => function ($data) {
                        return $data['result_name'];
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'voting_result',
                    'header' => 'Итог',
                    'value'  => function ($data) {
                        return $data['voting_result'];
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) use (&$model) {
                        ?>
                      <div class="btn-group" role="group">
                          <?/* <a href='javascript:void(0);' title="Редактировать"
                                           onclick='renderUpdateForm_votings_vote_<?= $model->votings_id ?> ("<?= $data['votings_results_id'] ?>")'
                                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a> */ ?>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_votings_vote_<?= $model->votings_id ?> ("<?= $data['votings_results_id'] ?>")'
                           class='btn btn-default btn-sm'><i
                              class='fa fa-trash'></i></a>
                      </div>
                        <?
                    },
                  ],
                ],
              ]
            );
            $modelVote = new votingsVoteForm();
            $modelVote->votings_id = $model->votings_id;
            $this->renderPartial("_ajax_update_vote", ['votingsId' => $model->votings_id]);
            $this->renderPartial("_ajax_create_form_vote", ['model' => $modelVote]);
            ?>
        </div>
          <? /* <div class="box-footer">
                </div> */ ?>
      </div>
    </div>
  </div>
</section>
<script>
    $(function () {
        var instance = CKEDITOR.instances['votings_votings_query_update-single-<?=$model->votings_id?>'];
        if (instance) {
            instance.destroy(true);
            console.log('CKEDITOR instance destroyed');
        }
        CKEDITOR.replace('votings_votings_query_update-single-<?=$model->votings_id?>');
        console.log('CKEDITOR replaced');
    });

    function delete_record_votings_vote_<?= $model->votings_id ?>(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/votings/deleteVote'
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('votings-vote-grid-<?=$model->votings_id?>', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function update_votings_<?=$model->votings_id?>() {
        var instance = CKEDITOR.instances['votings_votings_query_update-single-<?=$model->votings_id?>'];
        if (instance) {
            instance.updateElement();
            console.log('CKEDITOR element updated');
        }
        var data = $('#votings-update-form-single-<?=$model->votings_id?>').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?=Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/votings/update')?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    dsAlert(data, 'Голосование', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

</script>