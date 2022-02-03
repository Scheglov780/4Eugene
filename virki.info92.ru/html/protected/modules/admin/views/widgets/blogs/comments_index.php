<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?= Yii::t('main', 'Список комментариев блогов') ?></h3>
      </div>
      <div class="box-body">
          <?php
          if (Blogs::allowCreateComment($this)) {
              $this->widget(
                'booster.widgets.TbMenu',
                [
                  'type'  => 'pills',
                  'items' => [
                    [
                      'label'       => Yii::t('main', 'Создать'),
                      'icon'        => 'fa fa-plus',
                      'url'         => 'javascript:void(0);',
                      'linkOptions' => ['onclick' => 'renderCreateBlogCommentsForm(' . $this->postId . ')'],
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
          $postId = $this->postId;
          $this->widget(
            'booster.widgets.TbGridView',
            [
              'id'              => 'blog-comments-grid-' . $this->postId,
              'fixedHeader'     => true,
              'headerOffset'    => 0,
              'dataProvider'    => $model->search($this->postId, 5),
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
                        'application.components.widgets.BlogCommentBlock',
                        [
                          'adminMode'   => $adminMode,
                          'commentId'   => $data->id,
                          'commentData' => $data,
                        ]
                      );
                  },
                ],
              ],
            ]
          );
          ?>
      </div>
    </div>
  </div>
</div>