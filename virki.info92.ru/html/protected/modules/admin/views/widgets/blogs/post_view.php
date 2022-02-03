<div class="blogPost-view">

    <? if (Blogs::allowEditPost($blogData)) { ?>
      <div class="blog-categories-btn" style="right: 10px;">
        <div class="btn-group">
          <a href='javascript:void(0);' onclick='renderUpdateBlogPostsForm(<?= $blogData->id ?>)'
             class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
          <a href='javascript:void(0);' onclick='deleteBlogPostsRecord(<?= $blogData->id ?>)'
             class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
        </div>
      </div>
    <? } ?>
  <div class="blogPost-title">
    <a href="#" title="<?= Yii::t('main', 'Категория') ?>"><?= $blogData->categoryName ?></a>
  </div>

  <h2><a href="#" title="<?= htmlentities($blogData->title, null, 'UTF-8') ?>"><?= $blogData->title ?></a></h2>
  <div class="blogPost-prop">
    <div class="blogPost-author"><?= $blogData->created ?>&nbsp;|&nbsp;<a href="#" title="<?= Yii::t(
          'main',
          'Все сообщения автора'
        ) ?>">
            <?= $blogData->authorName ?></a>
    </div>
    <div style="height: 35%; float: left;">
        <?= Yii::t('main', 'Комментариев') ?>: <?= $blogData->commentsCount ?>
    </div>
    <div>
        <?= Yii::t('main', 'Публикуется') ?>: <?
        if (!$blogData->start_date && !$blogData->end_date) {
            echo Yii::t('main', 'всегда');
        } elseif ($blogData->start_date && $blogData->end_date) {
            echo $blogData->start_date . ' - ' . $blogData->end_date;
        } elseif (!$blogData->start_date && $blogData->end_date) {
            echo Yii::t('main', 'до') . ' ' . $blogData->end_date;
        } elseif ($blogData->start_date && !$blogData->end_date) {
            echo Yii::t('main', 'с') . ' ' . $blogData->start_date;
        } else {
            echo '-';
        }
        ?>
    </div>
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
        <?= Yii::t('main', 'Комментарии') ?>:
        <?
        if ($blogData->comments_enabled) {
            echo Yii::t('main', 'да');
        } else {
            echo Yii::t('main', 'нет');
        }
        ?>
    </div>
  </div>

  <div>
    <div class="blogPost-text">
        <?= $blogData->body ?>
    </div>

    <div>
        <? /*&nbsp;|&nbsp;*/ ?>
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
              [
                'id' => urlencode($tag),
              ]
            ) ?>" class="tag-item" title="<?= Yii::t('main', 'Поиск по тэгу') ?>: <?= $tag ?>"><?= htmlentities(
                  $tag,
                  null,
                  'UTF-8'
                ) ?></a>
          <? } ?>
      </div>
    </div>

    <div>
        <?
        $this->widget(
          'application.components.widgets.BlogCommentsBlock',
          [
            'adminMode' => $this->adminMode,
            'postId' => $blogData->id,
            'postCommentsEnabled' => $blogData->comments_enabled,
            'accessRightsPost' => $blogData->accessRightsPost,
            'accessRightsComment' => $blogData->accessRightsComment,
          ]
        );
        ?>
    </div>
  </div>
