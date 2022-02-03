<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?= Yii::t('main', 'Список сообщений блогов') ?></h3>
      </div>
      <div class="box-body">
          <?php
          if (Blogs::allowCreatePost()) {
              $this->widget(
                'booster.widgets.TbMenu',
                [
                  'type'  => 'pills',
                  'items' => [
                    [
                      'label'       => Yii::t('main', 'Создать'),
                      'icon'        => 'fa fa-plus',
                      'url'         => 'javascript:void(0);',
                      'linkOptions' => ['onclick' => 'renderCreateBlogPostsForm()'],
                    ],
                  ],
                ]
              );
          } else {
              ?>
            <p><?= Yii::t('main', 'У Вас нет прав для создания сообщений'); ?></p>
              <?
          }
          ?>
          <?php
          $adminMode = $this->adminMode;
          $this->widget(
            'booster.widgets.TbGridView',
            [
              'id'              => 'blog-posts-grid',
              'fixedHeader'     => true,
              'headerOffset'    => 0,
              'dataProvider'    => $model->search(25),
              'filter'          => $model,
              'type'            => 'bordered condensed',
              'template'        => '{summary}{items}{pager}',
              'responsiveTable' => true,
              'columns'         => [
                [
                  'name'   => 'id',
                  'filter' => false,
                  'header' => Yii::t('main', 'ID'),
                ],
                [
                  'name'   => 'category_id',
                  'header' => Yii::t('main', 'Категория'),
                  'filter' => Blogs::getCategoriesArray(),
                  'value'  => '$data->categoryName',
                ],
                [
                  'name'   => 'uid',
                  'header' => Yii::t('main', 'Пользователь'),
                  'filter' => Blogs::getAuthorsArray(),
                  'value'  => '$data->authorName',
                ],
                [
                  'name'   => 'message',
                  'header' => Yii::t('main', 'Сообщение'),
                  'filter' => false,
                  'type'   => 'raw',
                  'value'  => function ($data) use (&$adminMode) {
                      Yii::app()->controller->widget(
                        'application.components.widgets.BlogPostBlock',
                        [
                          'adminMode' => $adminMode,
                          'blogId'    => $data->id,
                          'blogData'  => $data,
                        ]
                      );
                  },
                ],
              ],
            ]
          );

          $this->render($this->_viewPath . '._posts_ajax_update');
          $this->render($this->_viewPath . '._posts_ajax_create_form', ["model" => $model]);
          $this->render($this->_viewPath . '._comments_ajax_update');
          $this->render($this->_viewPath . '._comments_ajax_create_form', ["model" => new BlogComments()]);
          ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function deleteBlogPostsRecord(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/postsDelete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('blog-posts-grid', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>

<script type="text/javascript">
    function deleteBlogCommentsRecord(id, postId) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/commentsDelete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('blog-comments-grid-' + postId, {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>

<script type="text/javascript">
    function createBlogComments(postId) {
        var data = $('#blog-comments-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/blogs/commentsCreate"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data);
                if (data !== 'false') {
                    $('#blog-comments-create-modal').modal('hide');
                    $.fn.yiiGridView.update('blog-comments-grid-' + postId, {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateBlogCommentsForm(postId) {
        $('#blog-comments-create-form').each(function () {
            this.reset();
        });
        $('#BlogComments_post_id').val(postId);
        $('#commentsAjaxCreateFormSubmitButton').off('click');
        $('#commentsAjaxCreateFormSubmitButton').on('click', function () {
            createBlogComments(postId);
            return false;
        });
        $('#blog-comments-create-modal').modal('show');
    }
</script>
<script type="text/javascript">
    function updateBlogComments(postId) {
        var data = $('#blog-comments-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/commentsUpdate"
            ); ?>',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    $('#blog-comments-update-modal').modal('hide');
                    $('#blog-comments-update-modal').data('modal', null);
                    $.fn.yiiGridView.update('blog-comments-grid-' + postId, {});
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }

    function renderUpdateBlogCommentsForm(id) {
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/commentsUpdate"
            ); ?>',
            data: data,
            success: function (data) {
                // alert("succes:"+data);
                $('#blog-comments-update-modal-container').html(data);
                $('#blog-comments-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
