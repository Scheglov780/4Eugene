<div>
  <div class="rating-block" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
    <span style="display: none;" itemprop="ratingValue"><?= $commentData->rating; ?></span>
      <?
      $this->widget(
        'CStarRating',
        [
          'name'           => 'rating-' . $commentData->id,
          'id'             => 'rating-' . $commentData->id,
          'value'          => $commentData->rating,
          'minRating'      => 1,
          'maxRating'      => 5,
          'ratingStepSize' => 1,
          'starCount'      => 5,
          'readOnly'       => true,
        ]
      );
      ?>
  </div>

    <? if ($commentData->title) { ?>
      <h3><a href="#" title="<?= htmlentities($commentData->title, null, 'UTF-8') ?>"><?= $commentData->title ?></a>
      </h3>
    <? } ?>
  <div><?= $commentData->created ?>&nbsp;|&nbsp;<a href="#" title="<?= Yii::t(
        'main',
        'Все сообщения автора'
      ) ?>"><?= $commentData->authorName ?></a>
  </div>
  <div>
      <?= $commentData->body ?>
  </div>
  <div>
      <?= Yii::t('main', 'Отображается') ?>:
      <?
      if ($commentData->enabled) {
          echo Yii::t('main', 'да');
      } else {
          echo Yii::t('main', 'нет');
      }
      ?>
  </div>

    <? /*
    <div>
        <?= $commentData->rating ?>
    </div>
    */ ?>


    <? if (Blogs::allowEditComment($commentData)) { ?>
      <div style="display: block; position: relative; float: right; top:-30px; padding-right: 10px;">
        <div class="btn-group">
          <a href='javascript:void(0);' onclick='renderUpdateBlogCommentsForm(<?= $commentData->id ?>)'
             class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
          <a href='javascript:void(0);'
             onclick='deleteBlogCommentsRecord(<?= $commentData->id ?>,<?= $commentData->post_id ?>)'
             class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
        </div>
      </div>
    <? } ?>
</div>