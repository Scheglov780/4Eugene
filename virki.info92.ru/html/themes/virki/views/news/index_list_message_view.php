<?
/**
 * @var News $data
 */
?>
<?
// Вот так получется текст мессаги
//$plainText = Blogs::prepareBody($data['body'], 512);
// Вот так получяем путь к картинке
//$img = Blogs::getImageFromBody($data['body']);
// А если нет картинки выведим дефолтую
//if (!$img) {
//    $img = $this->frontThemePath . '/images/blog/nophotos.png';
//}
?>
<div class="singleComment" id="news-block-<?= $data->news_id ?>">
    <? /*    <img src="images/author/c1.jpg" alt=""> */ ?>
  <h3 class="singComTitle"><a href="#"><?= $data->news_header ?></a></h3>
  <h4 class="comauthor"
      data-toggle="tooltip"
      data-placement="left"
      title="Автор сообщения"><?= $data->news_author_name ?></h4>
  <h5 class="comdate"
      data-toggle="tooltip"
      data-placement="left"
      title="Дата и время создания сообщения"><?= Utils::pgDateToStr($data->created, 'd.m.Y H:i') ?></h5>
  <p>
      <?= $data->news_body ?>
  </p>
  <div class="clearfix">
      <? if (Yii::app()->user->inRole(['superAdmin', 'topManager', 'contentManager'])) { ?>
        <a class="btn btn-info" title="<?= Yii::t('main', 'Изменение сообщения и его параметров') ?>"
           data-toggle="tooltip"
           data-placement="top"
           href="<?= News::getUpdateLink($data->news_id, true) ?>"
           target="_blank"><i class="fa fa-pencil"></i>&nbsp;Редактировать</a>
      <? } ?>
      <? if ($data->confirmation_needed && Yii::app()->user->id) {
          if (!$data->is_confirmed_by_current_user) { ?><?// !News::isConfirmed($data->news_id, Yii::app()->user->id) ?>
            <a class="btn btn-success"
               id="news-confirm-button-<?= $data->news_id ?>"
               title="<?= Yii::t(
                 'main',
                 'Обязательно подтвердите, что Вы ознакомились с изложенной выше информацией!'
               ) ?>"
               data-toggle="tooltip"
               data-placement="top"
               href="<?= Yii::app()->createUrl(
                 '/news/confirm/',
                 [
                   'id' => $data->news_id,
                 ]
               ) ?>"
               onclick="newsConfirm(this,'<?= $data->news_id ?>'); return false;"><i class="fa fa-check"></i>&nbsp;Всё
              понятно!</a>
          <? }
      } ?>
      <? if (Yii::app()->user->inRole(
          ['superAdmin', 'topManager', 'contentManager']
        ) && $data->confirmation_needed && $data->confirmators_count) { ?>
        <a class="btn btn-default"
           href="#news-block-<?= $data->news_id ?>"
           onclick="dsAlert('Подтверждено прочтений: <?= $data->confirmed_count ?> из <?= $data->confirmators_count ?>','Статистика прочтения',true); return false;"><i
              class="fa fa-check-square-o"></i>&nbsp;Подтверждено прочтение:
            <?= round(100 * $data->confirmed_count / $data->confirmators_count, 1) ?>%
        </a>
      <? } ?>
  </div>
</div>

