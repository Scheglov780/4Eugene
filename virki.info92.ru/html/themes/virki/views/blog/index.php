<section class="blogSection">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
          <? $this->widget(
            'application.components.widgets.BlogCategoriesBlock',
            [
              'adminMode' => false,
              'condition' => '',
              'params'    => [],
            ]
          ); ?>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
          <? $this->widget(
            'application.components.widgets.BlogPostsBlock',
            [
              'adminMode' => false,
              'pageSize' => 10,
              'showComments' => false,
              'condition' => 't.enabled=1 and (t.start_date is null or t.start_date <= Now()) and (t.end_date is null or t.end_date >= Now())',
            ]
          );
          ?>
      </div>
    </div>
  </div>
</section>

