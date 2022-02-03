<?
/**
 * @var BlogComments      $commentData
 * @var BlogCommentsBlock $this
 */
?>
<div class="singleComment" itemprop="review" itemscope itemtype="http://schema.org/Review">
    <? if ($commentData->title) { ?>
      <h3 class="singComTitle"><?= $commentData->title ?></h3>
    <? } ?>
  <a class="comreplay"
     href="<?= Yii::app()->controller->createUrl('/blog/authors', ['id' => $commentData->uid]) ?>"
     title="<?= Yii::t(
       'main',
       'Все сообщения автора'
     ) ?>"><span itemprop="author" itemscope itemtype="http://schema.org/Person">
                    <span itemprop="name"><?= $commentData->authorName ?></span></span></a>
  <h5 class="comdate" itemprop="datePublished"
      content="<?= date('c', strtotime($commentData->created)); ?>"><?= $commentData->created ?></h5>
  <p itemprop="reviewBody">
      <?= Blogs::prepareBody($commentData->body, $this->textLength) ?>
  </p>
</div>

<div class="rating-block" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
  <span style="display: none;" itemprop="ratingValue"><?= $commentData->rating; ?></span>
  <input id="BlogComments_rating" name="BlogComments[rating]" class="rating" type="number" data-size="xs" step="1"
         max="5" min="0" value="<?= $commentData->rating; ?>" disabled/>
    <? /*
        $this->widget(
          'CStarRating',
          array(
            'name'           => 'rating-' . $commentData->id,
            'id'             => 'rating-' . $commentData->id,
            'value'          => $commentData->rating,
            'minRating'      => 1,
            'maxRating'      => 5,
            'ratingStepSize' => 1,
            'starCount'      => 5,
            'readOnly'       => true,
          )
        );
        */ ?>
</div>
<? if (Blogs::allowEditComment($commentData)) { ?>
  <div style="display: block; position: relative; float: right;">
    <div class="btn-group">
      <a href='javascript:void(0);' onclick='renderUpdateBlogCommentsForm(<?= $commentData->id ?>)'
         class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
      <a href='javascript:void(0);'
         onclick='deleteBlogCommentsRecord(<?= $commentData->id ?>,<?= $commentData->post_id ?>)'
         class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
    </div>
  </div>
<? } ?>
