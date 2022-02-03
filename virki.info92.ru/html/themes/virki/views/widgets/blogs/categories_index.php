<?
/**
 * @var BlogCategoriesBlock $this
 * @var BlogCategories      $model
 */
?>
<div class="blogSidebar">
  <aside class="widget">
    <h3 class="widgetTitle">Категории</h3>
      <? $this->widget(
        'booster.widgets.TbGridView',
        [
          'type'          => 'striped',
          'id'            => 'blog-categories-grid',
          'dataProvider'  => $model->search(25, $this->condition, $this->params, $this->adminMode),
          'template'      => '{items}{pager}',
          'pagerCssClass' => 'pagerNoClass',
          'columns'       => [
            [
              'name'  => 'name',
              'type'  => 'raw',
              'value' => function ($data) {
                  ?>
                <a href="<?= Yii::app()->controller->createUrl('/blog/categories', ['id' => $data->id]) ?>">
                    <?= $data->name ?>
                </a>
                  <?
              },
            ],
            [
              'name'  => 'description',
              'type'  => 'raw',
              'value' => function ($data) {
                  ?>
                  <?= $data->description ?>
                  <?
              },
            ],
            [
              'name'  => 'lastActivityDate',
              'type'  => 'raw',
              'value' => function ($data) {
                  ?>
                  <?= $data->lastActivityDate ?>
                  <?
              },
            ],
            [
              'name'  => 'postsCount',
              'type'  => 'raw',
              'value' => function ($data) {
                  ?>
                  <?= $data->postsCount ?>
                  <?
              },
            ],
            [
              'name'  => 'commentsCount',
              'type'  => 'raw',
              'value' => function ($data) {
                  ?>
                  <?= $data->commentsCount ?>
                  <?
              },
            ],
            [
              'name'  => 'authorsCount',
              'type'  => 'raw',
              'value' => function ($data) {
                  ?>
                  <?= $data->authorsCount ?>
                  <?
              },
            ],
          ],
        ]
      ); ?>
  </aside>
</div>
