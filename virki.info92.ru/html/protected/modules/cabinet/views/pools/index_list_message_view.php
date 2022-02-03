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
<!-- Post -->
<div class="post" id="pools-block-<?= $data->votings_id ?>">
  <h3><a href="javascript:void(0);"><?= $data->votings_header ?></a></h3>
  <div class="user-block">
    <img class="img-circle img-bordered-sm"
         src="/themes/<?= Yii::app()->controller->module->id ?>/dist/img/user4-128x128.jpg" alt="Нет фото">
    <span class="username">
                          <a href="javascript:void(0);"><?= $data->votings_author_name ?></a>
                          <a href="javascript:void(0);" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
    <span class="description">Период проведения опроса: <?= Utils::pgDateToStr(
          $data->date_actual_start,
          'd.m.Y'
        ) ?> - <?= Utils::pgDateToStr($data->date_actual_end, 'd.m.Y') ?></span>
  </div>
  <!-- /.user-block -->
  <p class="clearfix">
      <?= $data->votings_query ?>
  </p>
  <ul class="list-inline clearfix">
      <? if (Yii::app()->user->inRole(['superAdmin', 'topManager', 'contentManager'])
        || Yii::app()->user->isOwner($data->news_author)
      ) { ?>
        <li><a class="btn btn-default btn-xs" title="<?= Yii::t('main', 'Изменение опроса и его параметров') ?>"
               data-toggle="tooltip"
               data-placement="top"
               href="javascript:void(0);"
               onclick="renderUpdateForm_pools('<?= $data->votings_id ?>')"><i class="fa fa-pencil margin-r-5"></i>&nbsp;Редактировать</a>
        </li>
        <li><a class="btn btn-default btn-xs" title="<?= Yii::t('main', 'Удаление опроса') ?>"
               data-toggle="tooltip"
               data-placement="top"
               href="javascript:void(0);"
               onclick="delete_record_pools ('<?= $data->votings_id ?>')"><i class="fa fa-trash margin-r-5"></i>&nbsp;Удалить</a>
        </li>
      <? } ?>
      <? /* <? if ($data->confirmation_needed && Yii::app()->user->id) {
                 if (!$data->is_confirmed_by_current_user) { ?><?// !News::isConfirmed($data->news_id, Yii::app()->user->id) ?>
                     <li><a class="btn btn-default btn-xs"
                            id="pools-confirm-button-<?= $data->news_id ?>"
                            title="<?= Yii::t(
                              'main',
                              'Обязательно подтвердите, что Вы ознакомились с изложенной выше информацией!'
                            ) ?>"
                           data-toggle="tooltip"
                        data-placement="top"
                         href="<?= Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/pools/confirm/',
                           array(
                             'id' => $data->news_id
                           )
                         ) ?>"
                            onclick="poolsConfirm(this,'<?= $data->news_id ?>'); return false;"><i
                                     class="fa fa-check margin-r-5"></i>&nbsp;Всё понятно!</a></li>
                 <? }
             } ?> */ ?>
      <? /* <? if ((Yii::app()->user->inRole(
                 array('superAdmin', 'topManager', 'contentManager')
               ) || Yii::app()->user->isOwner($data->news_author)) && $data->confirmation_needed && $data->confirmators_count) { ?>
                 <li class="pull-right"><a class="btn btn-default btn-xs"
                                           title = "Показать подробности..."
                                           data-toggle="tooltip"
                                           data-placement="top"
                                           href="#pools-block-<?= $data->news_id ?>"
                                           onclick="dsAlert('Проголосовало: <?= $data->confirmed_count ?> из <?= $data->confirmators_count ?>','Статистика прочтения',true); return false;"><i
                                 class="fa fa-check-square-o margin-r-5"></i>&nbsp;Подтверждено прочтение:
                         <?= round(100 * $data->confirmed_count / $data->confirmators_count, 1) ?>%
                     </a></li>
             <? } ?>
          </ul> */ ?>
</div>
<!-- /.post -->