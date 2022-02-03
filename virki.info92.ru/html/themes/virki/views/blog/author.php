<div class="row clearfix f-space10"></div>
<!-- Page title -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="page-title">
          <?= Yii::t('main', 'Автор') ?>: <?= $author->authorName ?>
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
            'condition' => 't.enabled=1 and (t.start_date is null or t.start_date <= Now()) and (t.end_date is null or t.end_date >= Now()) and t.uid = :authorId',
            'params' => [':authorId' => $author->uid],
          ]
        );
        ?>
    </div>
    <!-- end:sidebar -->
  </div>
  <!-- end:row -->
</div>
<!-- end: container-->
<!----------------------------------------------------------->
<? /*
            <div class="blogpost row">
                <div class="blogcontent col-md-12">
                    <div class="blogimage"> <a href="blog-single.html"> <img src="images/blog/image1-lg.jpg" class="ani-image" alt="blog title"> </a> </div>
                    <div class="blogdetails col-md-2 col-xs-12 date"> <span>05</span><span>Feb 2013</span> <a href="blog-single.html" class="btn color2 medium">More</a> </div>
                    <div class="col-md-10 col-xs-12 blog-summery"> <a class="color1" href="blog-single.html">
                            <h1>Distinctively conceptualize exceptional platforms before one-to-one bandwidth. Continually enable robust leadership skills.</h1>
                        </a> <span class="bloginfo"> <a href="#a"> <i class="fa fa-user fa-fw"></i>John Doe</a> <a href="#a"> <i class="fa fa-comments fa-fw"></i>14 Comments</a> </span>
                        <p> Dynamically supply customer directed metrics without enabled technologies. Competently transition sticky results with process-centric processes. Dynamically facilitate compelling potentialities with B2B information. Distinctively seize parallel communities rather than e-business e-tailers... <a href="blog-single.html">read more</a> </p>
                    </div>
                </div>
            </div>
            <div class="clearfix f-space30"></div>
            <div class="blogpost row">
                <div class="blogcontent col-md-12">
                    <div class="blogimage"> <a href="blog-single.html"> <img src="images/blog/image2.jpg" class="ani-image" alt="title"> </a> </div>
                    <div class="blogdetails col-md-2 col-xs-12 date"> <span>05</span><span>Feb 2013</span> <a href="blog-single.html" class="btn color2 medium">More</a> </div>
                    <div class="col-md-10 col-xs-12 blog-summery"> <a class="color1" href="blog-single.html">
                            <h1>Distinctively conceptualize exceptional platforms before one-to-one bandwidth. Continually enable robust leadership skills.</h1>
                        </a> <span class="bloginfo"> <a href="#a"> <i class="fa fa-user fa-fw"></i>John Doe</a> <a href="#a"> <i class="fa fa-comments fa-fw"></i>14 Comments</a> </span>
                        <p> Dynamically supply customer directed metrics without enabled technologies. Competently transition sticky results with process-centric processes. Dynamically facilitate compelling potentialities with B2B information. Distinctively seize parallel communities rather than e-business e-tailers... <a href="blog-single.html">read more</a> </p>
                    </div>
                </div>
            </div>
            <div class="clearfix f-space30"></div>
            <div class="blogpost row">
                <div class="blogcontent col-md-12">
                    <div class="blogimage"> <a href="blog-single.html"> <img src="images/blog/image1.jpg" class="ani-image" alt="image info"> </a> </div>
                    <div class="blogdetails col-md-2 col-xs-12 date"> <span>05</span><span>Feb 2013</span> <a href="blog-single.html" class="btn color2 medium">More</a> </div>
                    <div class="col-md-10 col-xs-12 blog-summery"> <a class="color1" href="blog-single.html">
                            <h1>Distinctively conceptualize exceptional platforms before one-to-one bandwidth. Continually enable robust leadership skills.</h1>
                        </a> <span class="bloginfo"> <a href="#a"> <i class="fa fa-user fa-fw"></i>John Doe</a> <a href="#a"> <i class="fa fa-comments fa-fw"></i>14 Comments</a> </span>
                        <p> Dynamically supply customer directed metrics without enabled technologies. Competently transition sticky results with process-centric processes. Dynamically facilitate compelling potentialities with B2B information. Distinctively seize parallel communities rather than e-business e-tailers... <a href="blog-single.html">read more</a> </p>
                    </div>
                </div>
            </div>
            <div class="clearfix f-space30"></div>
            <div class="pull-right">
                <ul class="pagination pagination-lg">
                    <li class="disabled"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                    <li  class="active"><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li><a href="#">6</a></li>
                    <li><a href="#">7</a></li>
                    <li><a href="#">8</a></li>
                    <li><a href="#"><i class="fa fa-angle-right"></i></a></li>
                </ul>
            </div>
        </div>
<?/*
        <!---------------------------------------------------------->
        <div class="f-space20"></div>
        <!-- side bar -->
        <div class="col-md-3 col-sm-12 col-xs-12 box-block page-sidebar">
            <div class="box-heading"><span>Blog Categories</span></div>
            <!-- Blog Categories -->
            <div class="box-content">
                <div class="panel-group" id="blogcategories">
                    <div class="panel panel-default">
                        <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseOne"
                             data-toggle="collapse">
                            <h4 class="panel-title"><a href="#a"> <span class="fa fa-plus"></span> Men Fashion </a></h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseOne">
                            <div class="panel-body">
                                <ul>
                                    <li class="item"><a href="#a">Jeans</a></li>
                                    <li class="item"><a href="#a">Shirts</a></li>
                                    <li class="item"><a href="#a">Shoes</a></li>
                                    <li class="item"><a href="#a">Sports Wear</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading opened" data-parent="#blogcategories" data-target="#collapseTwo"
                             data-toggle="collapse">
                            <h4 class="panel-title"><a href="#a"> <span class="fa fa-minus"></span> Women Fashion </a>
                            </h4>
                        </div>
                        <div class="panel-collapse collapse in" id="collapseTwo">
                            <div class="panel-body">
                                <ul>
                                    <li class="item"><a href="#a">Jeans</a></li>
                                    <li class="item"><a href="#a">Shirts</a></li>
                                    <li class="item"><a href="#a">Shoes</a></li>
                                    <li class="item"><a href="#a">Sports Wear</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseThree"
                             data-toggle="collapse">
                            <h4 class="panel-title"><a href="#a"> <span class="fa fa-plus"></span> Fragrance </a></h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseThree">
                            <div class="panel-body">
                                <ul>
                                    <li class="item"><a href="#a">Jeans</a></li>
                                    <li class="item"><a href="#a">Shirts</a></li>
                                    <li class="item"><a href="#a">Shoes</a></li>
                                    <li class="item"><a href="#a">Sports Wear</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseFour"
                             data-toggle="collapse">
                            <h4 class="panel-title"><a href="#a"> <span class="fa fa-plus"></span> Music </a></h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseFour">
                            <div class="panel-body">
                                <ul>
                                    <li class="item"><a href="#a">Jeans</a></li>
                                    <li class="item"><a href="#a">Shirts</a></li>
                                    <li class="item"><a href="#a">Shoes</a></li>
                                    <li class="item"><a href="#a">Sports Wear</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading closed" data-parent="#blogcategories" data-target="#collapseFive"
                             data-toggle="collapse">
                            <h4 class="panel-title"><a href="#a"> <span class="fa fa-plus"></span> Games </a></h4>
                        </div>
                        <div class="panel-collapse collapse" id="collapseFive">
                            <div class="panel-body">
                                <ul>
                                    <li class="item"><a href="#a">Jeans</a></li>
                                    <li class="item"><a href="#a">Shirts</a></li>
                                    <li class="item"><a href="#a">Shoes</a></li>
                                    <li class="item"><a href="#a">Sports Wear</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end: Blog Categories -->
            <div class="clearfix f-space30"></div>
            <div class="box-heading"><span>Best Sellers</span></div>
            <!-- Best Sellers Products -->
            <div class="box-content">
                <div class="box-products slide carousel-fade" id="productc4">
                    <ol class="carousel-indicators">
                        <li class="active" data-slide-to="0" data-target="#productc4"></li>
                        <li class="" data-slide-to="1" data-target="#productc4"></li>
                        <li class="" data-slide-to="2" data-target="#productc4"></li>
                    </ol>
                    <div class="carousel-inner">
                        <!-- item -->
                        <div class="item active">
                            <div class="product-block">
                                <div class="image">
                                    <div class="product-label product-hot"><span>HOT</span></div>
                                    <a class="img" href="product.html"><img alt="product info"
                                                                            src="images/products/product1.jpg"
                                                                            title="product title"></a></div>
                                <div class="product-meta">
                                    <div class="name"><a href="product.html">Ladies Stylish Handbag</a></div>
                                    <div class="big-price"><span class="price-new"><span class="sym">$</span>96</span>
                                    </div>
                                    <div class="big-btns"><a class="btn btn-default btn-view pull-left"
                                                             href="#">View</a> <a
                                          class="btn btn-default btn-addtocart pull-right" href="#">Add to
                                            Cart</a></div>
                                </div>
                                <div class="meta-back"></div>
                            </div>
                        </div>
                        <!-- end: item -->
                        <!-- item -->
                        <div class="item">
                            <div class="product-block">
                                <div class="image"><a class="img" href="product.html"><img alt="product info"
                                                                                           src="images/products/product2.jpg"
                                                                                           title="product title"></a>
                                </div>
                                <div class="product-meta">
                                    <div class="name"><a href="product.html">Ladies Stylish Handbag</a></div>
                                    <div class="big-price"><span class="price-new"><span
                                              class="sym">$</span>654.87</span></div>
                                    <div class="big-btns"><a class="btn btn-default btn-view pull-left"
                                                             href="#">View</a> <a
                                          class="btn btn-default btn-addtocart pull-right" href="#">Add to
                                            Cart</a></div>
                                </div>
                                <div class="meta-back"></div>
                            </div>
                        </div>
                        <!-- end: item -->
                        <!-- item -->
                        <div class="item">
                            <div class="product-block">
                                <div class="image"><a class="img" href="product.html"><img alt="product info"
                                                                                           src="images/products/product3.jpg"
                                                                                           title="product title"></a>
                                </div>
                                <div class="product-meta">
                                    <div class="name"><a href="product.html">Ladies Stylish Handbag</a></div>
                                    <div class="big-price"><span class="price-new"><span class="sym">$</span>1600</span>
                                    </div>
                                    <div class="big-btns"><a class="btn btn-default btn-view pull-left"
                                                             href="#">View</a> <a
                                          class="btn btn-default btn-addtocart pull-right" href="#">Add to
                                            Cart</a></div>
                                </div>
                                <div class="meta-back"></div>
                            </div>
                        </div>
                        <!-- end: item -->
                    </div>
                </div>
                <div class="carousel-controls"><a class="carousel-control left" data-slide="prev" href="#productc4"> <i
                          class="fa fa-angle-left fa-fw"></i> </a> <a class="carousel-control right" data-slide="next"
                                                                      href="#productc4"> <i
                          class="fa fa-angle-right fa-fw"></i> </a></div>
                <div class="nav-bg"></div>
            </div>
            <!-- end: Best Sellers Products -->
            <div class="clearfix f-space30"></div>
            <!-- Recent/Popular/Comments -->
            <!-- Nav tabs -->
            <ul class="nav nav-tabs blog-tabs nav-justified">
                <li class="active"><a href="#recent" data-toggle="tab">Recent</a></li>
                <li><a href="#popular" data-toggle="tab">Popular</a></li>
                <li><a href="#comments" data-toggle="tab"> <i class="fa fa-comments"></i> </a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="recent">
                    <ul class="recent-posts">
                        <li class="post-summery-list"><a class="small-post-image" href="#a" title="Blog Post One"> <img
                                  alt="post image" class="img" height="88" src="images/blog/noimage-sm.jpg"
                                  title="title" width="88"></a>
                            <div class="post-summery"><a href="#a" title="Blog Post One"><span class="title">Blog Post
                One...</span></a>
                                <p>Next generation meth odologies before and progr essive materials.</p>
                            </div>
                        </li>
                        <li class="post-summery-list"><a class="small-post-image" href="#a" title="Blog Post Two"> <img
                                  alt="post image" class="img" height="88" src="images/blog/noimage-sm.jpg"
                                  title="title" width="88"></a>
                            <div class="post-summery"><a href="#a" title="Blog Post Two"><span class="title">Blog Post
                Two...</span></a>
                                <p>Next generation meth odologies before and progr essive materials.</p>
                            </div>
                        </li>
                        <li class="post-summery-list"><a class="small-post-image" href="#a" title="Blog Post Three">
                                <img alt="post image" class="img" height="88" src="images/blog/noimage-sm.jpg"
                                     title="title" width="88"></a>
                            <div class="post-summery"><a href="#a" title="Blog Post Three"><span class="title">Blog Post
                Three...</span></a>
                                <p>Next generation meth odologies before and progr essive materials.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="popular">
                    <ul class="popular-posts">
                        <li class="post-summery-list"><a class="small-post-image" href="#a" title="Blog Post One"> <img
                                  alt="post image" class="img" height="88" src="images/blog/noimage-sm.jpg"
                                  title="title" width="88"></a>
                            <div class="post-summery"><a href="#a" title="Blog Post One"><span class="title">Blog Post
                One...</span></a>
                                <p>Next generation meth odologies before and progr essive materials.</p>
                            </div>
                        </li>
                        <li class="post-summery-list"><a class="small-post-image" href="#a" title="Blog Post Two"> <img
                                  alt="post image" class="img" height="88" src="images/blog/noimage-sm.jpg"
                                  title="title" width="88"></a>
                            <div class="post-summery"><a href="#a" title="Blog Post Two"><span class="title">Blog Post
                Two...</span></a>
                                <p>Next generation meth odologies before and progr essive materials.</p>
                            </div>
                        </li>
                        <li class="post-summery-list"><a class="small-post-image" href="#a" title="Blog Post Three">
                                <img alt="post image" class="img" height="88" src="images/blog/noimage-sm.jpg"
                                     title="title" width="88"></a>
                            <div class="post-summery"><a href="#a" title="Blog Post Three"><span class="title">Blog Post
                Three...</span></a>
                                <p>Next generation meth odologies before and progr essive materials.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="comments">
                    <ul class="recent-comments">
                        <li class="post-comments-list">
                            <div class="post-comments"><a href="#a" title="Blog Post One">Next generation meth odologies
                                    before
                                    and progr essive materials.</a> <em>- Posted on April 22, 2013</em></div>
                        </li>
                        <li class="post-comments-list">
                            <div class="post-comments"><a href="#a" title="Blog Post One">Next generation meth odologies
                                    before
                                    and progr essive materials.</a> <em>- Posted on April 22, 2013</em></div>
                        </li>
                        <li class="post-comments-list">
                            <div class="post-comments"><a href="#a" title="Blog Post One">Next generation meth odologies
                                    before
                                    and progr essive materials.</a> <em>- Posted on April 22, 2013</em></div>
                        </li>
                        <li class="post-comments-list">
                            <div class="post-comments"><a href="#a" title="Blog Post One">Next generation meth odologies
                                    before
                                    and progr essive materials.</a> <em>- Posted on April 22, 2013</em></div>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end: Tab panes -->
            <!-- end: Recent/Popular/Comments -->
            <div class="clearfix f-space30"></div>
            <!-- tags -->
            <div class="box-heading"><span>Tags</span></div>
            <div class="box-content">
                <div class="tags"><a href="#a">Free</a> <a href="#a">Minimal</a> <a href="#a">Clean</a> <a href="#a">Flatro</a>
                    <a href="#a">Metro</a> <a href="#a">Flat</a> <a href="#a">Blue</a> <a href="#a">Fashion</a> <a
                      href="#a">Best sale</a> <a href="#a">Popular</a> <a href="#a">Object</a> <a href="#a">UI/UX</a> <a
                      href="#a">Design</a> <a href="#a">Layout</a></div>
            </div>
            <!-- end: tags -->
        </div>
 */ ?>

