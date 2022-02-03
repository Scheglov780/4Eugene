<?

if (!function_exists('getObjectsWithProblemsCount')) {
    function getObjectsWithProblemsCount($objProblemsByObj, $boxDataType)
    {
        $result = 0;
        foreach ($objProblemsByObj as $msgs) {
            foreach ($msgs as $msg) {
                if ($msg[2] == $boxDataType) {
                    $result = $result + 1;
                    break;
                }
            }
        }
        return $result;
    }
}

$sql = "
select tree_id, tree_parent_id,tree_order_in_level,tree_children_count,
      obj_id,obj_type,obj_group,obj_name,obj_assigned,obj_data
 from obj_structure_view osv
where osv.tree_parent_id = 12000000000000 and obj_type = 'land' 
  and obj_id in (select oul.lands_id from obj_users_lands oul where oul.deleted is null and oul.uid = :uid)

";
$objsProblems = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))->createCommand(
  $sql
)->queryAll(true, [':uid' => $user->uid]);
$usersProblemsByType = ['info' => [], 'warning' => [], 'danger' => []];
$landsProblemsByType = ['info' => [], 'warning' => [], 'danger' => []];
$devicesProblemsByType = ['info' => [], 'warning' => [], 'danger' => []];
$usersProblemsByObj = [];
$landsProblemsByObj = [];
$devicesProblemsByObj = [];
if ($objsProblems) {
    foreach ($objsProblems as $objProblems) {
        $objProblemsData = ObjStructure::getLandReport($objProblems['obj_data']);
        if ($objProblemsData) {
            foreach ($objProblemsData as $problemIdxType => $objProblemData) {
                if ($objProblemData[0] == 'user') {
                    $usersProblemsByType[$objProblemData[2]][$objProblemData[1] . '-' . $problemIdxType] =
                      $objProblemData;
                    if (!isset($usersProblemsByObj[$objProblemData[1]])) {
                        $usersProblemsByObj[$objProblemData[1]] = [];
                    }
                    $usersProblemsByObj[$objProblemData[1]][$problemIdxType] = $objProblemData;
                } elseif ($objProblemData[0] == 'land') {
                    $landsProblemsByType[$objProblemData[2]][$objProblemData[1] . '-' . $problemIdxType] =
                      $objProblemData;
                    if (!isset($landsProblemsByObj[$objProblemData[1]])) {
                        $landsProblemsByObj[$objProblemData[1]] = [];
                    }
                    $landsProblemsByObj[$objProblemData[1]][$problemIdxType] = $objProblemData;
                } elseif ($objProblemData[0] == 'device') {
                    $devicesProblemsByType[$objProblemData[2]][$objProblemData[1] . '-' . $problemIdxType] =
                      $objProblemData;
                    if (!isset($devicesProblemsByObj[$objProblemData[1]])) {
                        $devicesProblemsByObj[$objProblemData[1]] = [];
                    }
                    $devicesProblemsByObj[$objProblemData[1]][$problemIdxType] = $objProblemData;
                }
            }
        }
    }
}
unset($objsProblems, $objProblems, $objProblemsData, $objProblemData);
$objProblems = [
  'usersProblemsByType' => $usersProblemsByType,
  'landsProblemsByType' => $landsProblemsByType,
  'devicesProblemsByType' => $devicesProblemsByType,
  'usersProblemsByObj' => $usersProblemsByObj,
  'landsProblemsByObj' => $landsProblemsByObj,
  'devicesProblemsByObj' => $devicesProblemsByObj,
];
unset(
  $usersProblemsByType,
  $landsProblemsByType,
  $devicesProblemsByType,
  $usersProblemsByObj,
  $landsProblemsByObj,
  $devicesProblemsByObj
);
?>
<div class="row">
  <div class="col-md-4">
    <!-- Widget: user widget style 1 -->
    <div class="box box-widget widget-user-2 small-box bg-aqua">
      <!-- Add the bg color to the header using any of the bg-* classes -->
      <div class="widget-user-header" style="min-height: 10em !important;">
        <div class="widget-user-image">
          <img class="img-circle"
               src="/themes/<?= Yii::app()->controller->module->id ?>/dist/img/user4-128x128.jpg"
               alt="<?= $user->fullname ?>">
        </div>
        <!-- /.widget-user-image -->
        <h3 class="widget-user-username" style="white-space: initial;"><?= $user->fullname ?></h3>
        <h5 class="widget-user-desc"><?= $user->roleDescr ?> ID:<?= $user->uid ?></h5>
      </div>
        <? /*   <div class="box-footer no-padding">
                <div class="inner">
                    <span class="progress-description">Необходимо принять меры по привлечению абонентов!</span>
                </div>
                <a href="/<?=Yii::app()->controller->module->id?>/profile/update" class="small-box-footer"
                   onclick="getContent(this,'Пользователи',false); return false;">Управление
                    <i class="fa fa-arrow-circle-right"></i></a>
                <ul class="nav nav-stacked">
                    <li><a href="#">Projects <span class="pull-right badge bg-blue">31</span></a></li>
                    <li><a href="#">Tasks <span class="pull-right badge bg-aqua">5</span></a></li>
                    <li><a href="#">Completed Projects <span class="pull-right badge bg-green">12</span></a></li>
                    <li><a href="#">Followers <span class="pull-right badge bg-red">842</span></a></li>
                </ul>
            </div> */ ?>
      <a href="<?= Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/profile/view') ?>"
         class="small-box-footer"
         onclick="getContent(this,'Профиль',false); return false;">Подробнее&nbsp;<i
            class="fa fa-arrow-circle-right"></i></a>
    </div>
    <!-- /.widget-user -->
      <? $boxDataType = 'info';
      $boxType = (count(
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'info' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['usersProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Количество уведомлений: ' . count(
              $objProblems['usersProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Уведомлений не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['usersProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['usersProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'>
                              <a href="<?= Yii::app()->createAbsoluteUrl(
                                Yii::app()->controller->module->id .
                                '/profile/view'
                              ) ?>" title="Профиль пользователя"
                                 onclick="getContent(this,'Профиль',false);return false;"><?= $msg[3] ?></a>
                            </li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
      <? $boxDataType = 'warning';
      $boxType = (count(
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'warning' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['usersProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Предупреждений: ' . count(
              $objProblems['usersProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Предупреждений не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['usersProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['usersProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'>
                              <a href="<?= Yii::app()->createAbsoluteUrl(
                                Yii::app()->controller->module->id .
                                '/profile/view'
                              ) ?>" title="Профиль пользователя"
                                 onclick="getContent(this,'Профиль',false);return false;"><?= $msg[3] ?></a>
                            </li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
      <? $boxDataType = 'danger';
      $boxType = (count(
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'danger' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['usersProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Обнаружено проблем: ' . count(
              $objProblems['usersProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Проблем не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['usersProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['usersProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'>
                              <a href="<?= Yii::app()->createAbsoluteUrl(
                                Yii::app()->controller->module->id .
                                '/profile/view'
                              ) ?>" title="Профиль пользователя"
                                 onclick="getContent(this,'Профиль',false);return false;"><?= $msg[3] ?></a>
                            </li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
    <!-- /.box -->
  </div>
  <!-- ./col -->
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-box bg-green">
        <?
        $lands = json_decode($user->lands);

        ?>
      <div class="inner" style="min-height: 10em !important;">
        <h3>Земельные участки</h3>
          <?
          /** @var Lands $land */
          if (is_array($lands) && count($lands)) {
              foreach ($lands as $land) { ?>
                <a href="<?= Yii::app()->createAbsoluteUrl(
                  Yii::app()->controller->module->id . '/lands/view',
                  ['id' => $land->lands_id]
                ) ?>"
                   class="small-box-footer h4"
                   onclick="getContent(this,'<?= $land->land_group .
                   '/№' .
                   $land->land_number ?>',false); return false;">
                    <?= $land->land_group . '/№' . $land->land_number ?>
                  <i class="fa fa-arrow-circle-right"></i></a>
              <? }
          } else {
              ?> <a href="#" class="small-box-footer h4">Участки не найдены</a>
          <? } ?>
      </div>
      <div class="icon">
        <i class="ion ion-home"></i>
      </div>
      <a href="#box-for-user-lands-<?= $user->uid ?>" class="small-box-footer">Подробнее&nbsp;<i
            class="fa fa-arrow-circle-right"></i></a>
    </div>
      <? $boxDataType = 'info';
      $boxType = (count(
        $objProblems['landsProblemsByType'][$boxDataType]
      ) ? 'info' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['landsProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Количество уведомлений: ' . count(
              $objProblems['landsProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Уведомлений не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['landsProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['landsProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Участок</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['landsProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= Lands::getUpdateLink($j) ?></td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'><?= $msg[3] ?></li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
      <? $boxDataType = 'warning';
      $boxType = (count(
        $objProblems['landsProblemsByType'][$boxDataType]
      ) ? 'warning' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['landsProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Предупреждений: ' . count(
              $objProblems['landsProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Предупреждений не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['landsProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['landsProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Участок</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['landsProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= Lands::getUpdateLink($j) ?></td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'><?= $msg[3] ?></li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
      <? $boxDataType = 'danger';
      $boxType = (count(
        $objProblems['landsProblemsByType'][$boxDataType]
      ) ? 'danger' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['landsProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Обнаружено проблем: ' . count(
              $objProblems['landsProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Проблем не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['landsProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['landsProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Участок</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['landsProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= Lands::getUpdateLink($j) ?></td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'><?= $msg[3] ?></li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <!-- ./col -->
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-box bg-yellow">
        <?
        $devices = json_decode($user->devices);
        ?>
      <div class="inner" style="min-height: 10em !important;">
        <h3>Приборы учёта</h3>
          <?
          /** @var Devices $device */
          if (is_array($devices) && count($devices)) {
              foreach ($devices as $device) { ?>
                <a href="<?= Yii::app()->createAbsoluteUrl(
                  Yii::app()->controller->module->id . '/devices/view',
                  ['id' => $device->devices_id]
                ) ?>"
                   class="small-box-footer h4"
                   onclick="getContent(this,'<?= $device->source .
                   '/' .
                   ($device->name ? $device->name : $device->devices_id) ?>',false); return false;">
                    <?= $device->source . '/' . ($device->name ? $device->name : $device->devices_id) ?>
                  <i class="fa fa-arrow-circle-right"></i></a>
                <p><?= Utils::pgDateToStr($device->data_updated) . ' (' . Utils::pgIntervalToStr(
                      $device->data_updated_left
                    ) . ')' ?></p>
              <? }
          } else { ?>
            <a href="#" class="small-box-footer h4">Нет приборов учёта</a>
          <? } ?>
      </div>
      <div class="icon">
        <i class="ion ion-wifi"></i>
      </div>
      <a href="#box-for-user-devices-<?= $user->uid ?>" class="small-box-footer">Подробнее&nbsp;<i
            class="fa fa-arrow-circle-right"></i></a>
    </div>
      <? $boxDataType = 'info';
      $boxType = (count(
        $objProblems['devicesProblemsByType'][$boxDataType]
      ) ? 'info' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['devicesProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Количество уведомлений: ' . count(
              $objProblems['devicesProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Уведомлений не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['devicesProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['devicesProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Прибор</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['devicesProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= Devices::getUpdateLink($j) ?></td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'><?= $msg[3] ?></li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
      <? $boxDataType = 'warning';
      $boxType = (count(
        $objProblems['devicesProblemsByType'][$boxDataType]
      ) ? 'warning' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['devicesProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Предупреждений: ' . count(
              $objProblems['devicesProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Предупреждений не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['devicesProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['devicesProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Прибор</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['devicesProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= Devices::getUpdateLink($j) ?></td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'><?= $msg[3] ?></li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
      <? $boxDataType = 'danger';
      $boxType = (count(
        $objProblems['devicesProblemsByType'][$boxDataType]
      ) ? 'danger' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['devicesProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Обнаружено проблем: ' . count(
              $objProblems['devicesProblemsByType'][$boxDataType]
            );
      } else {
          $caption = 'Проблем не обнаружено';
      }
      ?>
    <div class="box box-solid box-<?= $boxType ?> collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title h5" data-widget="collapse"><?= $caption ?></h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body <?= (count(
        $objProblems['devicesProblemsByType'][$boxDataType]
      ) ? 'no-padding' : '') ?>"
           style="overflow-y: auto;max-height: 60vh;">
          <? if (count($objProblems['devicesProblemsByType'][$boxDataType])) { ?>
            <table class="table table-condensed">
              <tr>
                <th style="width: 10px">#</th>
                <th>Прибор</th>
                <th>Инфо</th>
              </tr>
                <? $i = 1;
                foreach ($objProblems['devicesProblemsByObj'] as $j => $msgs) {
                    $actualMsgs = [];
                    foreach ($msgs as $msg) {
                        if ($msg[2] == $boxDataType) {
                            $actualMsgs[] = $msg;
                        }
                    }
                    if (!count($actualMsgs)) {
                        continue;
                    }

                    ?>
                  <tr>
                    <td><?= $i++ ?>.</td>
                    <td><?= Devices::getUpdateLink($j) ?></td>
                    <td>
                      <ul>
                          <? foreach ($actualMsgs as $msg) { ?>
                            <li class='bg-<?= $msg[2] ?>'><?= $msg[3] ?></li>
                          <? } ?>
                      </ul>
                    </td>
                  </tr>
                <? } ?>
            </table>
          <? } else { ?>
            <p class="text-center">нет данных</p>
          <? } ?>
      </div>
      <!-- /.box-body -->
    </div>
  </div>
  <!-- ./col -->
</div>

