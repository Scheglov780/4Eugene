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
/** @var Bills $model */
$module = Yii::app()->controller->module->id;
?>
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Профиль') ?>: #<?= $model->id ?>        <?= Utils::getHelp(
        'update',
        true
      ) ?></h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
        <? /** @var Bills $model */
        ?>
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= Yii::t('main', 'Редактирование') ?>
            #<?= $model->id ?></h3>
        </div>
          <? /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'bills-update-form-single-' . $model->id,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["bills/update"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",/* Disable normal form submit */
                  //'onkeypress'=>" if(event.keyCode == 13){ update_bills (); } "
                  /* Do ajax call when land presses enter key */
              ],
            ]
          ); ?>
        <div class="box-body">
            <?php echo $form->errorSummary($model); ?>
            <?php echo
            $form->hiddenField($model, 'id', []); ?>
            <?php echo $form->textFieldRow($model, 'id', ['id' => 'bills_id_update-single-$id']); ?>
            <?php echo $form->textFieldRow(
              $model,
              'tariff_object_id',
              ['id' => 'bills_tariff_object_id_update-single-$id']
            ); ?>
            <?php echo $form->textFieldRow(
              $model,
              'status',
              ['id' => 'bills_status_update-single-$id']
            ); ?>
            <?php echo $form->textFieldRow($model, 'date', ['id' => 'bills_date_update-single-$id']); ?>
            <?php echo $form->textFieldRow(
              $model,
              'manager_id',
              ['id' => 'bills_manager_id_update-single-$id']
            ); ?>
            <?php echo $form->textFieldRow(
              $model,
              'tariff_id',
              ['id' => 'bills_tariff_id_update-single-$id']
            ); ?>
            <?php echo $form->textFieldRow($model, 'summ', ['id' => 'bills_summ_update-single-$id']); ?>
            <?php echo $form->textFieldRow($model, 'code', ['id' => 'bills_code_update-single-$id']); ?>
            <?php echo $form->textFieldRow(
              $model,
              'manual_summ',
              ['id' => 'bills_manual_summ_update-single-$id']
            ); ?>
            <?php echo $form->textFieldRow(
              $model,
              'frozen',
              ['id' => 'bills_frozen_update-single-$id']
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
                  'onclick' => "update_bills_{$model->id} ();",
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
</section>
<script>
    /* $(function () {
         var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
         if (instance) {
             instance.destroy(true);
         }
         CKEDITOR.replace('news_news_body_update-single-');
     });
    */
    function update_bills_<?=$model->id?>() {
        /* var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
        if (instance) {
            instance.updateElement();
        }
        */
        var data = $("#bills-update-form-single-<?=$model->id?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?=Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/bills/update')?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    dsAlert(data, 'Профиль сохранён', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>