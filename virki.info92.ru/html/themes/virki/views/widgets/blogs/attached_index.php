<?
/**
 * @var BlogAttachedBlock $this
 * @var BlogPosts         $model
 */
?>
<div class="container">
  <div class="row"></div>
  <div class="col-md-12">
    <div class="box-heading"><span><?= Yii::t('main', 'Отзывы') ?></span></div>
  </div>
</div>

<div class="container" translate="no">
  <div class="row">
    <div class="col-md-12">
        <? $this->widget(
          'booster.widgets.TbGridView',
          [
            'id'              => 'blog-attached-grid',
            'dataProvider'    => $model->search($this->pageSize, $this->condition, $this->params),
            'filter'          => false,
            'hideHeader'      => true,
            'selectableRows'  => 0,
            'template'        => '{items}{pager}',
            'pagerCssClass'   => 'pagination',
            'pager'           => [
              'class'           => 'CSEOLinkPager',
              'header'          => false,
              'maxButtonCount'  => 10,
              'firstPageLabel'  => '',
              'lastPageLabel'   => '',
              'linkHtmlOptions' => ['rel' => 'nofollow'],
                //    'cssFile'=>false,
              'prevPageLabel'   => '&lt;',
              'nextPageLabel'   => '&gt;',
            ],
            'columns'         => [
              [
                'name'   => 'message',
                'header' => Yii::t('main', 'Отзыв'),
                'filter' => false,
                'type'   => 'raw',
                'value'  => function ($data) {
                    Yii::app()->controller->widget(
                      'application.components.widgets.BlogPostBlock',
                      [
                        'adminMode'    => false,
                        'showComments' => false,
                        'blogId'       => $data->id,
                        'blogData'     => $data,
                        'textLength'   => 512,
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
        ?>
    </div>
  </div>
</div>

<div class="container" translate="no">
  <div class="row">
    <div class="col-md-12">
        <? if (Blogs::allowCreatePost()) {
            $this->render(
              'themeBlocks.blogs._posts_ajax_create_form',
              ['model' => (isset($newModel) ? $newModel : $model)]
            );
        }
        if (Blogs::allowCreatePost()) {
            $this->widget(
              'booster.widgets.TbButton',
              [
                  //'buttonType'  => 'button',
                  //'scriptFile' => false,
                  //'name'        => 'btnCreateBlogPosts',
                'label' => Yii::t('main', 'Создать новый отзыв'),
                  //'caption'     => Yii::t('main', 'Создать новый отзыв'),

                'htmlOptions' => [
                  'class'   => 'btn btn-info',
                  'onclick' => 'renderCreateBlogPostsForm(false)',
                  'style'   => 'float: right',
                ],
              ]
            );
        } else { ?>
          <div class="alert alert-danger"><?= Yii::t('main', 'У Вас нет прав для создания статей'); ?></div>
        <? } ?>
    </div>
  </div>
</div>

<div class="clearfix f-space10"></div>
