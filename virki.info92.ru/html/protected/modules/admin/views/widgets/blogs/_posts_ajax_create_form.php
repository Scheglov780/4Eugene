<div class="modal fade" id="blog-posts-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новое сообщение') ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'blog-posts-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ['/' . Yii::app()->controller->module->id . '/blogs/postsCreate'],
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
        <input type="hidden" name="BlogPosts[uid]" value="<?= $model->uid ?>">
          <? $user = Users::model()->findByPkEx($model->uid) ?>
        <div class="form-group">
          <label for="blog_comments_posts_user_name_<?= $model->uid ?>" class="control-label"><?= Yii::t(
                'main',
                'Автор'
              ) ?></label>
          <input id="blog_comments_posts_user_name_<?= $model->uid ?>" class="form-control" type="text"
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
            $editor->htmlOptions = ['class' => 'span12', 'rows' => 6, 'cols' => 50];
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
              'htmlOptions' => ['onclick' => 'createBlogPosts();'],
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
      <!-- /.modal-content -->
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</div>
<script type="text/javascript">
    function createBlogPosts() {
        var data = $('#blog-posts-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/blogs/postsCreate"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#blog-posts-create-modal').modal('hide');
                    $.fn.yiiGridView.update('blog-posts-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateBlogPostsForm() {
        $('#blog-posts-create-form').each(function () {
            this.reset();
        });
        $('#blog-posts-create-modal').modal('show');
    }
</script>
