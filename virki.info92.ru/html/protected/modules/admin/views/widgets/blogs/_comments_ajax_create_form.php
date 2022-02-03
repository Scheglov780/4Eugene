<div class="modal fade" id="blog-comments-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новый комментарий') ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'blog-comments-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ['/' . Yii::app()->controller->module->id . '/blogs/commentsCreate'],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_blogs ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <? $model->uid = Yii::app()->user->id; ?>
        <input type="hidden" name="BlogComments[uid]" value="<?= $model->uid ?>">
          <? $user = Users::model()->findByPkEx($model->uid) ?>
        <div class="form-group">
          <label for="blog_comments_user_name_<?= $model->uid ?>" class="control-label"><?= Yii::t(
                'main',
                'Автор'
              ) ?></label>
          <input id="blog_comments_user_name_<?= $model->uid ?>" class="form-control" type="text"
                 name="user_name" readonly value="<?= $user->email; ?>">
        </div>
        <input type="hidden" name="BlogComments[post_id]" id='BlogComments_post_id'
               value="<?= $model->post_id ?>">
          <?= $form->textFieldRow($model, 'title'); ?>
        <div class="form-group">
            <?= $form->labelEx($model, 'body'); ?>
            <?
            $editor = new SRichTextarea();
            $editor->init();
            $editor->model = $model;
            $editor->attribute = 'body';
            $editor->htmlOptions = ['class' => 'form-control'];
            $editor->run(true);
            ?>
        </div>
          <?= $form->checkBoxRow($model, 'enabled'); ?>
          <?= $form->textFieldRow($model, 'rating'); ?>
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
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['id' => 'commentsAjaxCreateFormSubmitButton'],
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
        <? $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->