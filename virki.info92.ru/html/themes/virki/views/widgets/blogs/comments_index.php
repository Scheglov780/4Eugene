<?
/**
 * @var BlogCommentsBlock $this
 * @var BlogComments      $model
 */
?>
<div>
    <?
    if (Blogs::allowCreateComment($this)) {
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'button',
              //'scriptFile' => false,
              //'name'        => 'btnCreateNewComment',
            'label'       => Yii::t('main', 'Добавить новый комментарий'),
            'htmlOptions' => [
              'class'   => 'btn btn-primary',
              'onclick' => 'renderCreateBlogCommentsForm(' . $this->postId . ')',
              'style'   => 'float: right',
            ],
          ]
        );
    } else {
        ?>
        <?= Yii::t('main', 'У Вас нет прав для создания комментариев'); ?>
        <?
    }
    ?>

</div>
<div class="commentList">
    <?
    $postId = $this->postId;
    $this->widget(
      'booster.widgets.TbGridView',
      [
        'id'              => 'blog-comments-grid-' . $this->postId,
        'dataProvider'    => $model->search($this->postId, $this->pageSize),
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
            'header' => Yii::t('main', 'Комментарий'),
            'filter' => false,
            'type'   => 'raw',
            'value'  => function ($data) {
                Yii::app()->controller->widget(
                  'application.components.widgets.BlogCommentBlock',
                  [
                    'adminMode'   => false,
                    'commentId'   => $data->id,
                    'commentData' => $data,
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
