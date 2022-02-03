<div class="modal fade" id="blog-posts-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Сообщение') ?> #<?php echo $model->id; ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'blog-posts-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ['/' . Yii::app()->controller->module->id . '/blogs/postsUpdate'],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_blogs (); } " /* Do ajax call when user presses enter key */
            ],

          ]
        ); ?>
      <div class="modal-body">
        <div class="box">
          <div class="box-body">
              <?php echo $form->errorSummary($model); ?>
              <?= $form->hiddenField($model, 'id'); ?>
            <input type="hidden" name="BlogPosts[uid]" value="<?= $model->uid ?>">
              <? $user = Users::model()->findByPkEx($model->uid) ?>
            <div class="form-group">
              <label for="blog_comments_user_name_<?= $model->uid ?>" class="control-label"><?= Yii::t(
                    'main',
                    'Автор'
                  ) ?></label>
              <input id="blog_comments_user_name_<?= $model->uid ?>" class="form-control" type="text"
                     name="user_name" readonly value="<?= $user->email; ?>">
            </div>
              <?
              $blogCategories = BlogCategories::model()->findAll('enabled=1');
              $filter = [];
              if ($blogCategories) {
                  foreach ($blogCategories as $category) {
                      if (Blogs::checkAccessByCategory($category['access_rights_post'])) {
                          $filter[$category['id']] = $category['name'];
                      }
                  }
              }
              ?>
              <?= $form->dropDownListRow(
                $model,
                'category_id',
                [
                  'widgetOptions' => [
                    'data' => $filter,
                      //'htmlOptions' => $htmlOptions
                  ],
                ]
              );
              ?>
              <?= $form->textFieldRow($model, 'title'); ?>
            <div class="form-group">
                <?php echo $form->labelEx($model, 'body'); ?>
                <?php
                $editor = new SRichTextarea();
                $editor->init();
                $editor->model = $model;
                $editor->attribute = 'body';
                $editor->htmlOptions = ['class' => 'form-control'];
                $editor->run(true);
                ?>
            </div>
              <?= $form->textFieldRow($model, 'tags'); ?>
              <?= $form->dateFieldRow($model, 'start_date'); ?>
              <?= $form->dateFieldRow($model, 'end_date'); ?>
            <script>
                $(function () {
                    $('#BlogPosts_start_date').datepicker({dateFormat: 'yy-mm-dd'});
                    $('#BlogPosts_end_date').datepicker({dateFormat: 'yy-mm-dd'});
                });
            </script>
              <?= $form->checkBoxRow($model, 'enabled'); ?>
              <?= $form->checkBoxRow($model, 'comments_enabled'); ?>
          </div>
        </div>
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
              'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'updateBlogPosts();'],
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
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




