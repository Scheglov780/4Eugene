<?
/**
 * @var BlogPosts      $blogData
 * @var BlogPostsBlock $this
 */
?>
<? //=============================================================?>
<div class="blogRightsidebar" itemscope itemtype="http://schema.org/Article">
  <div class="singleBlogDetails">
    <div class="sblogDec blogDetailsDec">
      <h2 class="blogTitle">
        <a href="<?= ($this->showComments ? '#' : Yii::app()->controller->createUrl(
          '/blog/posts',
          ['id' => $blogData->id]
        )) ?>" title="<?= htmlentities($blogData->title, null, 'UTF-8') ?>">
          <span itemprop="name"><?= $blogData->title ?></span>
        </a>
      </h2>

      <span itemprop="articleBody">
                <?= Blogs::prepareBody($blogData->body, 0) ?>
            </span>
    </div>
  </div>
  <div class="socialShare">
    <p><?= $blogData->created ?> / <a href="<?= Yii::app()->controller->createUrl(
          '/blog/categories',
          ['id' => $blogData->category_id]
        ) ?>"
                                      title="<?= Yii::t('main', 'Категория') ?>"><?= Yii::t('main', 'Категория') ?>
        &nbsp;&gt;&nbsp;<span itemprop="articleSection"><?= $blogData->categoryName ?></span></a>
      <span class="bloginfo" itemprop="author" itemscope itemtype="http://schema.org/Person" itemprop="name">
                    <? /* Рейтинг */ ?>
                <input id="raiting-input-id" class="rating" type="number" data-size="xs" step="1" max="5" min="0"
                       value="<?= $blogData->rating; ?>" disabled/>

                    <span>
                        <i class="fa fa-clock-o"></i>

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
                    &nbsp;&nbsp;

                    <a href="<?= Yii::app()->controller->createUrl('/blog/authors', ['id' => $blogData->uid]) ?>"
                       title="<?= Yii::t('main', 'Все сообщения автора') ?>">
                        <i class="fa fa-user fa-fw"></i>
                        <?= $blogData->authorName ?>
                    </a>
                    &nbsp;&nbsp;
                    <span>
                        <i class="fa fa-comments fa-fw"></i>
                        <?= $blogData->commentsCount ?>
                    </span>

                <? /* Отображается только админам */ ?>
          <? if (Yii::app()->user->checkAccess('@manageAnyBlogsContent')) { ?>
            &nbsp;&nbsp;
            <span>
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
                        </span>
                        &nbsp;&nbsp;
                        <span>
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
                        </span>
          <? } ?>
          <? /* //Отображается только админам */ ?>
          <? if (Blogs::allowEditPost($blogData)) { ?>
    <p>
    <div class="pull pull-right">
      <a href='javascript:void(0);' onclick='renderUpdateBlogPostsForm(<?= $blogData->id ?>)'
         class='btn btn-warning btn-small view' title="<?= Yii::t('main', 'Редактировать') ?>">
        <i class='fa fa-pencil'></i>
          <?= Yii::t('main', 'Редактировать') ?>
      </a>
      <a href='javascript:void(0);' onclick='deleteBlogPostsRecord(<?= $blogData->id ?>)'
         class='btn btn-danger btn-small view' title="<?= Yii::t('main', 'Удалить') ?>">
        <i class='fa fa-trash'></i>
          <?= Yii::t('main', 'Удалить') ?>
      </a>
    </div>
    </p>
      <? } ?>
    </span>
    </p>
    <p>
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
            [
              'id' => urlencode($tag),
            ]
          ) ?>" class="tag-item" title="<?= Yii::t('main', 'Поиск по тэгу') ?>: <?= $tag ?>"><?= htmlentities(
                $tag,
                null,
                'UTF-8'
              ) ?></a>
        <? } ?>
    </p>
    <div class="shareSocial">
      <span><?= Yii::t('main', 'Соцсети') ?>: </span>
      <a href="#"><i class="fa fa-facebook"></i></a>
      <a href="#"><i class="fa fa-twitter"></i></a>
      <a href="#"><i class="fa fa-google-plus"></i></a>
      <a href="#"><i class="fa fa-pinterest-p"></i></a>
    </div>
  </div>
    <? if ($this->showComments) { ?>
      <div class="comment">
        <h3 class="commentTitle"><?= Yii::t('main', 'Комментарии') ?></h3>
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
</div>


