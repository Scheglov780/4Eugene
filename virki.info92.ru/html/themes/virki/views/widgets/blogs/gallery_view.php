<?
/**
 * @var BlogPosts $data
 */
?>
<?
// Вот так получется текст мессаги
$plainText = Blogs::prepareBody($data['body'], 512);
// Вот так получяем путь к картинке
$img = Blogs::getImageFromBody($data['body']);
// А если нет картинки выведим дефолтую
if (!$img) {
    $img = $this->frontThemePath . '/images/blog/nophotos.png';
}
?>
<div class="col-sm-4 col-xs-12">
  <div class="singleBlog">
    <div class="blImg">
      <img src="<?= $img ?>" alt="<?= htmlentities($data['title'], null, 'UTF-8') ?>">
    </div>
    <div class="sbCont">
      <h2 class="sbblogTit"><a
            href="<?= Yii::app()->createUrl('/blog/posts', ['id' => $data['id']]) ?>"><?= htmlentities(
                $data['title'],
                null,
                'UTF-8'
              ) ?></a></h2>
      <p>
          <?= $plainText ?>
      </p>
      <a class="sbrm" href="<?= Yii::app()->createUrl('/blog/posts', ['id' => $data['id']]) ?>"><?= Yii::t(
            'main',
            'Читать'
          ) ?> <i class="fa fa-angle-right"></i></a>
    </div>
  </div>
</div>

