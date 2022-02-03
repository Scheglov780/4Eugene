<!--Blog start-->
<section class="blogSection">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <!------------------------------------------------------------>
        <!--<div class="content">-->
          <? $this->widget(
            'application.components.widgets.BlogCategoriesBlock',
            [
              'adminMode' => false,
              'condition' => '',
              'params'    => [],
            ]
          );
          ?>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
          <? Yii::app()->controller->widget(
            'application.components.widgets.BlogPostBlock',
            [
              'adminMode'        => false,
              'showComments'     => true,
              'commentsPageSize' => 25,
              'blogId'           => $postId,
              '_viewFileInPath'  => 'post_view_in_blog',
                //'blogData'  => $postData,
            ]
          );
          ?>
      </div>
    </div>
  </div>
</section>
<!--Blog End-->