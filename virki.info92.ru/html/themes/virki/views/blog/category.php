<div class="row clearfix f-space10"></div>
<!-- Page title -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page-title">
          <?= Yii::t('main', 'Категория блогов') ?>: <?= $category->name ?>
      </div>
    </div>
  </div>
</div>
<!-- end: Page title -->
<div class="row clearfix f-space10"></div>
<div class="container">
  <!-- row -->
  <div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12 main-column box-block">

      <!------------------------------------------------------------>
      <!--<div class="content">-->
        <? $this->widget(
          'application.components.widgets.BlogCategoriesBlock',
          [
            'adminMode' => false,
            'condition' => '',
            'params'    => [],
          ]
        ); ?>

        <? $this->widget(
          'application.components.widgets.BlogPostsBlock',
          [
            'adminMode' => false,
            'pageSize' => 10,
            'showComments' => false,
            'condition' => 't.enabled=1 and (t.start_date is null or t.start_date <= Now()) and (t.end_date is null or t.end_date >= Now()) and t.category_id = :categoryId',
            'params' => [':categoryId' => $category->id],
          ]
        );
        ?>
    </div>
    <!-- end:sidebar -->
  </div>
  <!-- end:row -->
</div>
<!-- end: container-->

