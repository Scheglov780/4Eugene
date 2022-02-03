<div class="row">
  <div class="col-md-12">
    <div class="box">
        <? /** @var TbActiveForm $form */ ?>
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                   => 'cms-pages-form' . $model->id,
            'enableAjaxValidation' => false,
            'method'               => 'post',
            'type'                 => 'vertical',
            'htmlOptions'          => [
              'enctype' => 'multipart/form-data',
            ],
          ]
        ); ?>
      <div class="box-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'page_id'); ?>
          <?php echo $form->checkBoxRow($model, 'enabled'); ?>
          <?php echo $form->checkBoxRow($model, 'SEO'); ?>
          <?php echo $form->textFieldRow($model, 'url'); ?>
      </div>
      <div class="box-footer">
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType' => 'submit',
              'type'       => 'primary',
              'icon'       => 'ok white',
              'label'      => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
            ]
          ); ?>
          <? $this->widget(
            'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.CmsHistoryBlock',
            [
              'id'        => 'cms_pages_content-' . urlencode($model->page_id),
              'tableName' => 'cms_pages',
              'contentId' => $model->page_id,
              'pageSize'  => 10,
            ]
          );
          ?>
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'icon'        => 'remove',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>

    </div>
  </div>
</div>
