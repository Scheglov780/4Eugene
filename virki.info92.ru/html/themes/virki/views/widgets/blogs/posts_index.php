<?
/**
 * @var BlogPostsBlock $this
 * @var BlogPosts      $model
 */
?>
<div class="blogRightsidebar">
  <h1 class="widgetTitle"><?= Yii::t('main', 'Статьи') ?></h1>

    <? if (Blogs::allowCreatePost()) {
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'button',
              //'scriptFile'  => false,
              //  'name'        => 'btnCreateBlogPosts',
            'label'       => Yii::t('main', 'Создать новую статью'),
            'htmlOptions' => [
              'class'       => 'btn blogReadmore',
              'onclick'     => 'renderCreateBlogPostsForm(true)',
              'style'       => 'float: right',
              'data-toggle' => 'modal',
                //'data-target' => '#blog-posts-create-modal'
            ],
          ]
        );
    } else { ?>
      <div class="alert alert-danger" style="color: red"><?= Yii::t(
            'main',
            'У Вас нет прав для создания статей'
          ); ?></div>
    <? } ?>
  <div class="blogRightsidebarTable">
      <? $showComments = $this->showComments;
      $this->widget(
        'booster.widgets.TbGridView',
        [
          'id'              => 'blog-posts-grid',
          'dataProvider'    => $model->search($this->pageSize, $this->condition, $this->params),
            //'filter'          => false,
          'hideHeader'      => true,
          'selectableRows'  => 0,
          'template'        => '{items}{pager}',
          'pagerCssClass'   => 'pagerNoClass',
            //'rowCssClass' => array('blog-row', 'blog-row'),
          'columns'         => [
            [
              'name'  => 'message',
                //'header' => Yii::t('main', 'Сообщение'),
                //'header' => null,
                //'filter' => false,
                //'type'   => 'raw',
              'value' => function ($data) use (&$showComments) {
//                            switch ($data['category_id']) {
//                                case 1: $viewFileInPath = 'post_preview_cat1'; break;
//                                case 2: $viewFileInPath = 'post_preview_cat2'; break;
//                                case 3: $viewFileInPath = 'post_preview_cat3'; break;
//                                default: $viewFileInPath = false;
//                            }
                  Yii::app()->controller->widget(
                    'application.components.widgets.BlogPostBlock',
                    [
                      'adminMode'    => false,
                      'showComments' => $showComments,
                      'blogId'       => $data->id,
                      'blogData'     => $data,
                        //'_viewFileInPath' => $viewFileInPath,
                        //'textLength'   => 512,
                    ]
                  );
              },
            ],
          ],
          'afterAjaxUpdate' => "function() {
    jQuery('.rating').rating({'readOnly':true});
     }",
        ]
      );
      if (Blogs::allowCreatePost()) {
          $this->render($this->_viewPath . '._posts_ajax_create_form', ["model" => $model]);
      }
      ?>
  </div>
</div>

