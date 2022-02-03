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
/** @var News $model */
$module = Yii::app()->controller->module->id;
?>
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Сообщение') ?>: <?php echo $model->news_id; ?></h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <? /** @var News $model */
        ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= Yii::t('main', 'Редактирование сообщения') ?>
            #<?= $model->news_id ?></h3>

        </div>
          <? /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'news-update-form-single-' . $model->news_id,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["news/update"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",/* Disable normal form submit */
                  //'onkeypress'=>" if(event.keyCode == 13){ update_news (); } "
                  /* Do ajax call when land presses enter key */
              ],
            ]
          ); ?>
        <div class="box-body">
            <?php echo $form->errorSummary($model); ?>

            <?php echo $form->uneditableRow(
              $model,
              'news_id',
              ['id' => 'news_news_id_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'news_header',
              ['id' => 'news_news_header_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'news_body',
              ['id' => 'news_news_body_update-single-' . $model->news_id]
            ); ?>
            <?
            $htmlOptions['id'] = 'news_news_type_update-single-' . $model->news_id;
            echo $form->dropDownListRow(
              $model,
              'news_type',
              [
                'widgetOptions' => [
                  'data'        => DicCustom::getVals('NEWS_TYPE'),
                  'htmlOptions' => $htmlOptions,
                ],
              ]
            ); ?>
            <?php
            echo $form->uneditableRow(
              $model,
              'news_author_name',
              ['id' => 'news_news_author_update-single-' . $model->news_id]
            ); ?>
            <?php
            $model->created = Utils::pgDateToStr($model->created);
            echo $form->uneditableRow(
              $model,
              'created',
              ['id' => 'news_created_update-single-' . $model->news_id]
            ); ?>
            <?php
            $model->date_actual_start = Utils::pgDateToStr($model->date_actual_start, 'Y-m-d');
            echo $form->dateFieldRow(
              $model,
              'date_actual_start',
              ['id' => 'news_date_actual_start_update-single-' . $model->news_id]
            ); ?>
            <?php
            $model->date_actual_end = Utils::pgDateToStr($model->date_actual_end, 'Y-m-d');
            echo $form->dateFieldRow(
              $model,
              'date_actual_end',
              ['id' => 'news_date_actual_end_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'recipients',
              ['id' => 'news_recipients_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->checkboxRow(
              $model,
              'confirmation_needed',
              ['id' => 'news_confirmation_needed_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->numberFieldRow(
              $model,
              'absolute_order',
              ['id' => 'news_absolute_order_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->checkboxRow(
              $model,
              'enabled',
              ['id' => 'news_enabled_update-single-' . $model->news_id]
            ); ?>
            <?php echo $form->textAreaRow(
              $model,
              'comments',
              ['id' => 'news_comments_update-single-' . $model->news_id]
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
                  'onclick' => "update_news_{$model->news_id} ();",
                ],
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
          <?php
          $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Подтверждения прочтения</h3>
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
                    'label'       => Yii::t('main', 'Добавить подтверждение прочтения'),
                    'icon'        => 'fa fa-plus',
                    'url'         => 'javascript:void(0);',
                    'linkOptions' => ['onclick' => "renderCreateForm_news_confirm_{$model->news_id} ()"],
                    'visible'     => true,
                  ],
                ],
              ]
            );
            ?>
            <?php
            $dataDataProvider = News::getNewsConfirmations($model->news_id, 100);
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'news-confirm-grid-' . $model->news_id,
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',//
                'dataProvider'    => $dataDataProvider,
                  //'filter'          => false,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                    //news_confirmations_id	news_id	row_num	percent	uid	created	created_left	total_left	result	fullname
                  [
                    'type'   => 'raw',
                    'name'   => 'created',
                    'header' => 'Дата подтверждения прочтения',
                    'value'  => function ($data) {
                        return Utils::pgDateToStr($data['created']);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'created_left',
                    'header' => 'Прошло с момента подтверждения',
                    'value'  => function ($data) {
                        return Utils::pgIntervalToStr($data['created_left']);
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'total_left',
                    'header' => 'Прошло с момента сообщения',
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
                    'header' => 'Процент подтвердивших',
                    'value'  => function ($data) {
                        return $data['percent'];
                    },
                  ],
                  [
                    'type'   => 'raw',
                    'name'   => 'result',
                    'header' => 'Результат',
                    'value'  => function ($data) {
                        return $data['result'];
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) use (&$model) {
                        ?>
                      <div class="btn-group" role="group">
                          <?/* <a href='javascript:void(0);' title="Редактировать"
                                           onclick='renderUpdateForm_news_confirm_<?= $model->news_id ?> ("<?= $data['news_confirmations_id'] ?>")'
                                           class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a> */ ?>
                        <a href='javascript:void(0);' title="Удалить"
                           onclick='delete_record_news_confirm_<?= $model->news_id ?> ("<?= $data['news_confirmations_id'] ?>")'
                           class='btn btn-default btn-sm'><i
                              class='fa fa-trash'></i></a>
                      </div>
                        <?
                    },
                  ],
                ],
              ]
            );
            $modelConfirm = new newsConfirmationForm();
            $modelConfirm->news_id = $model->news_id;
            $this->renderPartial("_ajax_update_confirm", ['newsId' => $model->news_id]);
            $this->renderPartial("_ajax_create_form_confirm", ['model' => $modelConfirm]);
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
        var instance = CKEDITOR.instances['news_news_body_update-single-<?=$model->news_id?>'];
        if (instance) {
            instance.destroy(true);
        }
        CKEDITOR.replace('news_news_body_update-single-<?=$model->news_id?>');
    });

    function delete_record_news_confirm_<?= $model->news_id ?>(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . '/news/deleteConfirm'
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('news-confirm-grid-<?=$model->news_id?>', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }

    function update_news_<?=$model->news_id?>() {
        var instance = CKEDITOR.instances['news_news_body_update-single-<?=$model->news_id?>'];
        if (instance) {
            instance.updateElement();
        }
        var data = $("#news-update-form-single-<?=$model->news_id?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/news/update'); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    dsAlert(data, 'Сообщение', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>