<?
/**
 * @var BlogPosts      $blogData
 * @var BlogPostsBlock $this
 */
?>
<br/>
<div class="blogPost-view" itemscope itemtype="http://schema.org/Article">
  <!--------------------------------->
  <div class="container">
    <div class="blogpost row">
      <div class="blogcontent">
        <div class="blog-nav">
          <div class="blogPost-title">
            <a href="<?= Yii::app()->controller->createUrl(
              '/blog/categories',
              ['id' => $blogData->category_id]
            ) ?>"
               title="<?= Yii::t('main', 'Категория') ?>"><?= Yii::t('main', 'Категория') ?>
              &nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<span
                  itemprop="articleSection"><?= $blogData->categoryName ?></span></a>
          </div>
        </div>

        <div class="blogdetails col-md-2 col-xs-12 date">
            <? $imagePath = Blogs::getImageFromBody($blogData->body);
            if ($imagePath) { ?>
              <div class="img" style="position: relative; top: -16px;">
                <!--  <div class="blogimage">  -->
                <!-- <img src="images/blog/image1-lg.jpg" class="ani-image" alt="blog title img"> -->
                  <? if ($this->textLength) { ?>
                    <!--<div class="blogPost-image">-->
                    <img itemprop="image" src="<?= $imagePath ?>" class="ani-image"
                         alt="<?= htmlentities($blogData->title, null, 'UTF-8') ?>"/>
                    <!--</div>-->
                  <? } else { ?>
                    <img itemprop="image" src="<?= $imagePath ?>" class="ani-image"
                         alt="<?= htmlentities($blogData->title, null, 'UTF-8') ?>"/>
                  <? } ?>
              </div>
            <? } ?>

          <span>

                </span>
          <span>
                    <?= Yii::t('main', 'Публикуется') ?>
                    <? if (!$blogData->start_date && !$blogData->end_date) {
                        echo Yii::t('main', 'всегда');
                    } elseif ($blogData->start_date && $blogData->end_date) {
                        echo date('d.m.Y', strtotime($blogData->start_date)) . ' - ' . date(
                            'd.m.Y',
                            strtotime($blogData->end_date)
                          );
                    } elseif (!$blogData->start_date && $blogData->end_date) {
                        echo Yii::t('main', 'до') . ' ' . date('d.m.Y', strtotime($blogData->end_date));
                    } elseif ($blogData->start_date && !$blogData->end_date) {
                        echo Yii::t('main', 'с') . ' ' . date('d.m.Y', strtotime($blogData->start_date));
                    } else {
                        echo '-';
                    }
                    ?>
                </span>

          <a href="<?= ($this->showComments ? '#' : Yii::app()->controller->createUrl(
            '/blog/posts',
            ['id' => $blogData->id]
          )) ?>" class="btn color2 medium">
              <?= Yii::t('main', 'Подробней') ?>
          </a>
          <!-- Кнопки для автора и админа -->
            <? if (Blogs::allowEditPost($blogData)) { ?>
              <div class="blog-categories-btn" style="right: 10px;">
                <div class="btn-group">
                  <a href='javascript:void(0);' onclick='renderUpdateBlogPostsForm(<?= $blogData->id ?>)'
                     class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Редактировать') ?>">
                    <i class='fa fa-pencil' style="color: #f76b5c"></i>
                  </a>
                  <a href='javascript:void(0);' onclick='deleteBlogPostsRecord(<?= $blogData->id ?>)'
                     class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Удалить') ?>">
                    <i class='fa fa-trash' style="color: #f76b5c"></i>
                  </a>
                </div>
              </div>
            <? } ?>
        </div>

        <div class="col-md-10 col-xs-12 blog-summery">
          <a class="color1" href="#a">
            <h1>
              <a href="<?= ($this->showComments ? '#' : Yii::app()->controller->createUrl(
                '/blog/posts',
                ['id' => $blogData->id]
              )) ?>" title="<?= htmlentities($blogData->title, null, 'UTF-8') ?>">
                <span itemprop="name" style="color: black"><?= $blogData->title ?></span>
              </a>
            </h1>
          </a>
          <span class="bloginfo" itemprop="author" itemscope itemtype="http://schema.org/Person"
                itemprop="name">

                    <input id="raiting-input-id" class="rating" type="number" data-size="xs" step="1" max="5" min="0"
                           value="<?= $blogData->rating; ?>" disabled/>

                    <a href="<?= Yii::app()->controller->createUrl('/blog/authors', ['id' => $blogData->uid]) ?>"
                       title="<?= Yii::t('main', 'Все сообщения автора') ?>">
                        <i class="fa fa-user fa-fw"></i>
                        <?= $blogData->authorName ?>
                    </a>
                    &nbsp;&nbsp;
                    <a href="#a">
                        <i class="fa fa-comments fa-fw"></i>
                        <?= $blogData->commentsCount ?>
                    </a>
                        <? /* Отображается только админам */ ?>

              <? if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')) { ?>
                &nbsp;&nbsp;
                <a>
                            <?= Yii::t('main', 'Отображается'); ?>:
                                <? /*<i class="fa fa-eye" aria-hidden="true"></i>*/ ?>

                    <?
                    if ($blogData->enabled) {
                        //echo Yii::t('main', 'да');
                        echo('<i class="fa fa-eye" aria-hidden="true"></i>');
                    } else {
                        //echo Yii::t('main', 'нет');
                        echo('<i class="fa fa-eye-slash" aria-hidden="true"></i>');

                    }
                    ?>
                        </a>
                        &nbsp;&nbsp;
                        <a>
                            <?= Yii::t('main', 'Разрешить комментарии'); ?>:
                                <?
                                if ($blogData->comments_enabled) {
                                    //echo Yii::t('main', 'да');
                                    echo('<i class="fa fa-bell" aria-hidden="true"></i>');

                                } else {
                                    //echo Yii::t('main', 'нет');
                                    echo('<i class="fa fa-bell-slash" aria-hidden="true"></i>');
                                }
                                ?>
                        </a>
              <? } ?>
                </span>
          <p>
          <div class="blogPost-text1" itemprop="articleBody">
              <? //TODO: Володя, вот тут надо разобраться, где что и для чего??? ?>
              <?= Blogs::prepareBody($blogData->body, 0) ?>
          </div>
          <!--<a href="blog-single.html">подробней</a>-->
          </p>

          <div style="display: block; position: relative; width: 100%;" class="tags">
              <? $tagsArray = preg_split('/(?:[,;]|^)\s*|\s*(?:[,;]|$)/s', $blogData->tags);
              foreach ($tagsArray as $i => $tag) {
                  if (!trim($tag)) {
                      unset($tagsArray[$i]);
                  } else {
                      $tagsArray[$i] = trim($tag);
                  }
              }
              $tagsArray = array_unique(
                $tagsArray
              ); // SORT_REGULAR SORT_NUMERIC SORT_STRING SORT_LOCALE_STRING
              foreach ($tagsArray as $tag) {
                  ?>
                <a href="<?= Yii::app()->controller->createUrl(
                  '/blog/tags',
                  [
                    'id' => urlencode($tag),
                  ]
                ) ?>" class="tag-item"
                   title="<?= Yii::t('main', 'Поиск по тэгу') ?>: <?= $tag ?>"><?= htmlentities(
                      $tag,
                      null,
                      'UTF-8'
                    ) ?></a>
              <? } ?>
          </div>
        </div><!--End:Blog-summery-->

      </div><!--End:Blogcontent-->
    </div><!-- End:Blogpost-->

    <!-------------------------------->
      <? /*
    <? if (Blogs::allowEditPost($blogData)) { ?>
        <div class="blog-categories-btn" style="right: 10px;">
            <a href='javascript:void(0);' onclick='renderUpdateBlogPostsForm(<?= $blogData->id ?>)'
               class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Редактировать') ?>">
                <i class='fa fa-pencil' style="color: #f76b5c"></i>
            </a>
            <a href='javascript:void(0);' onclick='deleteBlogPostsRecord(<?= $blogData->id ?>)'
               class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Удалить') ?>">
                <i class='fa fa-trash' style="color: #f76b5c"></i>
            </a>
        </div>
    <? } ?>


    <div class="blog-nav">
        <div class="blogPost-title">
            <a href="<?= Yii::app()->controller->createUrl('/blog/categories', array('id' => $blogData->category_id)) ?>"
               title="<?= Yii::t('main', 'Категория') ?>"><?= Yii::t('main', 'Категория') ?>
                &nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<span itemprop="articleSection"><?= $blogData->categoryName ?></span></a>
        </div>
    </div>

    <br/><br />

        <h2><a href="<?= ($this->showComments ? '#' : Yii::app()->controller->createUrl(
              '/blog/posts',
              array('id' => $blogData->id)
            )) ?>" title="<?= htmlentities($blogData->title, null, 'UTF-8') ?>">
                <span itemprop="name"><?= $blogData->title ?></span></a>
        </h2>


    <div class="blogPost-prop">

        <br />
        <input id="raiting-input-id" class="rating" type="number" data-size="xs" step="1" max="5" min="0" value="<?= $blogData->rating; ?>" disabled/>
        
        <br/>
        <div class="blogPost-author">
            <span itemprop="datePublished"
                  content="<?= date('c', strtotime($blogData->created)); ?>"><?= $blogData->created ?></span>&nbsp;|&nbsp;<a
              href="<?= Yii::app()->controller->createUrl('/blog/authors', array('id' => $blogData->uid)) ?>"
              title="<?= Yii::t('main',
                'Все сообщения автора'
              ) ?>"><span itemprop="author" itemscope itemtype="http://schema.org/Person">
        <span itemprop="name"><?= $blogData->authorName ?></span></span></a>
        </div>
        <div style="height: 35%; float: left;">
            <?= Yii::t('main', 'Комментариев') ?>: <?= $blogData->commentsCount ?>
        </div>
        <br/>
        <div>
            <?= Yii::t('main', 'Публикуется') ?>: <?
            if (!$blogData->start_date && !$blogData->end_date) {
                echo Yii::t('main', 'всегда');
            } elseif ($blogData->start_date && $blogData->end_date) {
                echo date('d.m.Y',strtotime($blogData->start_date)) . ' - ' . date('d.m.Y',strtotime($blogData->end_date));
            } elseif (!$blogData->start_date && $blogData->end_date) {
                echo Yii::t('main', 'до') . ' ' . date('d.m.Y',strtotime($blogData->end_date));
            } elseif ($blogData->start_date && !$blogData->end_date) {
                echo Yii::t('main', 'с') . ' ' . date('d.m.Y',strtotime($blogData->start_date));
            } else {
                echo '-';
            }
            ?>
        </div>
*/ ?>
      <? /* Отображается только админам */ ?>
      <? /*
        <? if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')) { ?>

            <div>
                <?= Yii::t('main', 'Отображается') ?>:
                <?
                if ($blogData->enabled) {
                    echo Yii::t('main', 'да');
                } else {
                    echo Yii::t('main', 'нет');
                }
                ?>
            </div>
            <div>
                <?= Yii::t('main', 'Разрешить комментарии') ?>:
                <?
                if ($blogData->comments_enabled) {
                    echo Yii::t('main', 'да');
                } else {
                    echo Yii::t('main', 'нет');
                }
                ?>
            </div>
        <? } ?>

    </div>

    <? $imagePath = Blogs::getImageFromBody($blogData->body);
    if ($imagePath) {
        if ($this->textLength) { ?>

            <div class="blogPost-image">
                <img itemprop="image" src="<?= $imagePath ?>"
                     alt="<?= htmlentities($blogData->title, null, 'UTF-8') ?>"/>
            </div>
        <? } else { ?>
            <img itemprop="image" style="display: none;" src="<?= $imagePath ?>"
                 alt="<?= htmlentities($blogData->title, null, 'UTF-8') ?>"/>
        <? }
    } ?>

    <span style="display: none;" itemprop="headline">
        <?= Blogs::prepareBody($blogData->body, 90) ?>
    </span>

    <div class="blogPost-text" itemprop="articleBody">
        <?= Blogs::prepareBody($blogData->body, $this->textLength) ?>
    </div>
*/ ?>
      <? /* ТЭГИ */ ?>
      <? /*
    <div style="display: block; position: relative; width: 75%; float: left">
        <? $tagsArray = preg_split('/(?:[,;]|^)\s*|\s*(?:[,;]|$)/s', $blogData->tags);
        foreach ($tagsArray as $i => $tag) {
            if (!trim($tag)) {
                unset($tagsArray[$i]);
            } else {
                $tagsArray[$i] = trim($tag);
            }
        }
        $tagsArray = array_unique($tagsArray); // SORT_REGULAR SORT_NUMERIC SORT_STRING SORT_LOCALE_STRING
        foreach ($tagsArray as $tag) {
            ?>
            <a href="<?= Yii::app()->controller->createUrl(
              '/blog/tags',
              array(
                'id' => urlencode($tag)
              )
            ) ?>" class="tag-item" title="<?= Yii::t('main', 'Поиск по тэгу') ?>: <?= $tag ?>"><?= htmlentities(
                  $tag,
                  null,
                  'UTF-8'
                ) ?></a>
        <? } ?>
    </div>
*/ ?>

      <? if ($this->showComments) { ?>
        <div>
            <?
            $this->widget(
              'application.components.widgets.BlogCommentsBlock',
              [
                'adminMode'           => $this->adminMode,
                'pageSize'            => $this->commentsPageSize,
                'postId'              => $blogData->id,
                'postCommentsEnabled' => $blogData->comments_enabled,
                'condition'           => 't.enabled=1',
              ]
            );
            ?>
        </div>
      <? } ?>
  </div>

    <? if (!Yii::app()->clientScript->isScriptRegistered('blogPostScript', CClientScript::POS_END)
//  && !Yii::app()->request->isAjaxRequest
    ) {
        if (Blogs::allowEditPost($blogData)) {
            $this->render($this->_viewPath . '._posts_ajax_update');
        }
        if (!Yii::app()->request->isAjaxRequest) {
            if (!Yii::app()->user->isGuest) {
                $this->render($this->_viewPath . '._comments_ajax_update');
                $this->render($this->_viewPath . '._comments_ajax_create_form', ["model" => new BlogComments()]);
            }
        }

        $confirmDeletionMessage = Yii::t('main', 'Вы уверены, что хотите удалить эту запись?');
        $blogPostsDeleteUrl = Yii::app()->createAbsoluteUrl('/blog/postsDelete');;
        $blogCommentsDeleteUrl = Yii::app()->createAbsoluteUrl('/blog/commentsDelete');
        $blogCommentsCreateUrl = Yii::app()->createAbsoluteUrl('/blog/commentsCreate');
        $blogCommentsUpdateUrl = Yii::app()->createAbsoluteUrl('/blog/commentsUpdate');
        $scriptBody = '';
        if (Blogs::allowEditPost($blogData)) {
            $scriptBody = $scriptBody . "
    function deleteBlogPostsRecord(id) {
        if (!confirm('{$confirmDeletionMessage}'))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '{$blogPostsDeleteUrl}',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('blog-posts-grid', {});
                }
                else
                    dsAlert('deletion failed','Error',true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data),'Error',true);
            },

            dataType: 'html'
        });
    }    
    ";
        }
        if (!Yii::app()->user->isGuest) {
            $scriptBody = $scriptBody . "
    function createBlogComments(postId) {
        var data = $('#blog-comments-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '{$blogCommentsCreateUrl}',
            data: data,
            success: function (data) {
                if (data != 'false') {
                        $('#blog-comments-create-modal').modal('hide');
                        $.fn.yiiGridView.update('blog-comments-grid-' + postId, {});
                }
            },
            error: function (data) { // if error occured
                dsAlert('Err:' + data,'Error',true);
            },
            dataType: 'html'
        });
    }

    function renderCreateBlogCommentsForm(postId) {
        $('#blog-comments-create-form').each(function () {
            this.reset();
        });
        if (typeof CKEDITOR != 'undefined') {
        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
            CKEDITOR.instances[instance].setData('');
        }
        }
        $('#BlogComments_post_id').val(postId);
        //$('#commentsAjaxCreateFormSubmitButton').off('click');
        //$('#commentsAjaxCreateFormSubmitButton').on('click',function() {createBlogComments(postId);return false;});
        jQuery('#BlogComments_create_rating').rating({'readOnly':false});
        $('#blog-comments-create-modal').modal('show');
    }
";
        }
        if (!Yii::app()->user->isGuest) {
            $scriptBody = $scriptBody . "    
    function deleteBlogCommentsRecord(id, postId) {
        if (!confirm('{$confirmDeletionMessage}'))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '{$blogCommentsDeleteUrl}',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('blog-comments-grid-' + postId, {});
                }
                else
                    dsAlert('deletion failed','Error',true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data),'Error',true);
            },

            dataType: 'html'
        });

    }

    function updateBlogComments(postId) {
        var data = $('#blog-comments-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '{$blogCommentsUpdateUrl}',
            data: data,
            success: function (data) {
                if (data != 'false') {
                    $('#blog-comments-update-modal').modal('hide');
                    $.fn.yiiGridView.update('blog-comments-grid-' + postId, {});
                }

            },
            error: function (data) { // if error occured
                dsAlert('Err:' + JSON.stringify(data),'Error',true);
            },
            dataType: 'html'
        });

    }

    function renderUpdateBlogCommentsForm(id) {
        var data = 'id=' + id;
        $(\"#blog-comments-update-modal\").modal(\"destroy\").remove();
        jQuery.ajax({
            type: 'POST',
            url: '{$blogCommentsUpdateUrl}',
            data: data,
            success: function (data) {
                $('#blog-comments-update-modal-container').html(data);
                $('#blog-comments-update-modal').modal('show');
            },
            error: function (data) { // if error occured
                dsAlert('Err:' + JSON.stringify(data),'Error',true);
            },
            dataType: 'html'
        });

    }
";
        }
        if ($scriptBody) {
            Yii::app()->clientScript->registerScript(
              'blogPostScript',
              /** @lang text */
              $scriptBody,
              CClientScript::POS_END
            );
        }
    }
    ?>

    <? /*
$link = $this->showComments ? '#' : Yii::app()->controller->createUrl('/blog/posts', array('id' => $blogData->id));
?>

<script>
        jQuery(".blog-item-title").each(function(){
        var review_full = jQuery(this).html();
        var review = review_full;

        if( review.length > 200 )
        {
        review = review.substring(0, 200);
        //jQuery(this).html( review + '<div class="read_more">&nbsp;... читать полностью</div>' );
        jQuery(this).html( review + '...<div class="read_more"> читать полностью </div>' );
        }
        jQuery(this).append('<div class="full_text" style="display: none;">' + review_full + '</div>');
        });

        jQuery(".read_more").click(function(){
        jQuery(this).parent().html( jQuery(this).parent().find(".full_text").html() );
        });
</script>
*/ ?>
    <? /*
<a href="<?= ($this->showComments ? '#' : Yii::app()->controller->createUrl(
  '/blog/posts', array('id' => $blogData->id))) ?>" title="<?= htmlentities($blogData->title, null, 'UTF-8') ?>">
    <span itemprop="name"><?= $blogData->title ?></span>
</a>
*/ ?>
</div>
