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
";
$objsProblems = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))->createCommand(
  $sql
)->queryAll();
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
  'usersProblemsByType'   => $usersProblemsByType,
  'landsProblemsByType'   => $landsProblemsByType,
  'devicesProblemsByType' => $devicesProblemsByType,
  'usersProblemsByObj'    => $usersProblemsByObj,
  'landsProblemsByObj'    => $landsProblemsByObj,
  'devicesProblemsByObj'  => $devicesProblemsByObj,
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
    <!-- small box -->
    <div class="small-box bg-aqua">
        <?
        $sql = "
                                    select count(0) as users_total, sum(case when activity > 0 then 1 else 0 end) as users_active from
                                    (select sum(ua.count) as activity from users uu 
                                    left join log_user_activity ua on ua.uid = uu.uid and ua.date >= now() - interval '120 day'
                                    where uu.role in ('landlord','associate','leaseholder')
                                    group by uu.uid) uu1
                                        ";
        $usersTotalActive = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))
          ->createCommand(
            $sql
          )
          ->queryRow();

        ?>
      <div class="inner">
        <h3><?= Yii::t(
              'main',
              '{n} абонент|{n} абонента|{n} абонентов',
              $usersTotalActive['users_total']
            ) ?></h3>
        <h4>
            <?
            $percent = round(
              $usersTotalActive['users_active'] / $usersTotalActive['users_total'],
              2
            );
            ?>
          <span class="text-large"><strong><?= $usersTotalActive['users_active'] ?></strong></span>
          <small>(</small><strong><?= $percent ?><sub>%</sub></strong><small>)</small>
          активно</h4>
        <div class="progress">
          <div class="progress-bar" style="width: <?= $percent ?>%"></div>
        </div>
        <span class="progress-description">Необходимо принять меры по привлечению абонентов!</span>
      </div>
      <div class="icon">
        <i class="ion ion-person-stalker"></i>
      </div>
      <a href="/<?= Yii::app()->controller->module->id ?>/users" class="small-box-footer"
         onclick="getContent(this,'Пользователи',false); return false;">Управление
        <i class="fa fa-arrow-circle-right"></i></a>
    </div>
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} абоненту|{n} абонентам|{n} абонентам',
              $problemObjectsCount
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
                <th>Абонент</th>
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
                    <td><?= Users::getUpdateLink($j) ?></td>
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
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'warning' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['usersProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Предупреждений: ' . count(
              $objProblems['usersProblemsByType'][$boxDataType]
            ) . ' по ' . Yii::t(
              'main',
              '{n} абоненту|{n} абонентам|{n} абонентам',
              $problemObjectsCount
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
                <th>Абонент</th>
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
                    <td><?= Users::getUpdateLink($j) ?></td>
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
        $objProblems['usersProblemsByType'][$boxDataType]
      ) ? 'danger' : 'default');
      $problemObjectsCount = getObjectsWithProblemsCount(
        $objProblems['usersProblemsByObj'],
        $boxDataType
      );
      if ($problemObjectsCount) {
          $caption = 'Обнаружено проблем: ' . count(
              $objProblems['usersProblemsByType'][$boxDataType]
            ) . ' по ' . Yii::t(
              'main',
              '{n} абоненту|{n} абонентам|{n} абонентам',
              $problemObjectsCount
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
                <th>Абонент</th>
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
                    <td><?= Users::getUpdateLink($j) ?></td>
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
    <!-- /.box -->
  </div>
  <!-- ./col -->
  <div class="col-md-4">
    <!-- small box -->
    <div class="small-box bg-green">
        <?
        $sql = "
                                select count(0) as lands_total, sum(case when uu1.activity > 0 then 1 else 0 end) as lands_active from obj_lands ll
                                left join obj_users_lands oul on oul.lands_id = ll.lands_id and oul.deleted is null
                                left join 
                                (select uu.uid, sum(ua.count) as activity from users uu 
                                left join log_user_activity ua on ua.uid = uu.uid and ua.date >= now() - interval '120 day'
                                where uu.role in ('landlord','associate','leaseholder')
                                group by uu.uid) uu1 on uu1.uid = oul.uid
                                        ";
        $landsTotalActive = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))
          ->createCommand(
            $sql
          )
          ->queryRow();

        ?>
      <div class="inner">
        <h3><?= Yii::t(
              'main',
              '{n} участок|{n} участка|{n} участков',
              $landsTotalActive['lands_total']
            ) ?></h3>
        <h4>
            <?
            $percent = round(
              $landsTotalActive['lands_active'] / $landsTotalActive['lands_total'],
              2
            );
            ?>
          <span class="text-large"><strong><?= $landsTotalActive['lands_active'] ?></strong></span>
          <small>(</small><strong><?= $percent ?><sub>%</sub></strong><small>)</small>
          активно</h4>
        <div class="progress">
          <div class="progress-bar" style="width: <?= $percent ?>%"></div>
        </div>
        <span class="progress-description">Необходимо принять меры по привлечению абонентов и заполнению данных!</span>
      </div>
      <div class="icon">
        <i class="ion ion-home"></i>
      </div>
      <a href="/<?= Yii::app()->controller->module->id ?>/lands" class="small-box-footer"
         onclick="getContent(this,'Участки',false); return false;">Управление
        <i class="fa fa-arrow-circle-right"></i></a>
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} участку|{n} участкам|{n} участкам',
              $problemObjectsCount
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} участку|{n} участкам|{n} участкам',
              $problemObjectsCount
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} участку|{n} участкам|{n} участкам',
              $problemObjectsCount
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
        $sql = "
                                        select count(0) as devices_total, 
                                        sum(
                                        case when (odv.value1>0 or (odv.value2>0 and odv.value3>0))
                                         -- and (odv.starting_value1>0 or (odv.starting_value2>0 and odv.starting_value3>0))
                                        and (odv.last_active >= now() - interval '60 day')	then 1 else 0 end
                                        ) as devices_active from obj_devices_view odv
                                        ";
        $devicesTotalActive = Yii::app()->db->cache((YII_DEBUG ? 0 : 3600))
          ->createCommand(
            $sql
          )
          ->queryRow();

        ?>
      <div class="inner">
        <h3><?= Yii::t(
              'main',
              '{n} прибор|{n} прибора|{n} приборов',
              $devicesTotalActive['devices_total']
            ) ?></h3>
        <h4>
            <?
            $percent = round(
              $devicesTotalActive['devices_active'] / $devicesTotalActive['devices_total'],
              2
            );
            ?>
          <span class="text-large"><strong><?= $devicesTotalActive['devices_active'] ?></strong></span>
          <small>(</small><strong><?= $percent ?><sub>%</sub></strong><small>)</small>
          активно</h4>
        <div class="progress">
          <div class="progress-bar" style="width: <?= $percent ?>%"></div>
        </div>
        <span class="progress-description">Необходимо принять меры по вводу начальных показаний приборов учёта и сбору текущих!</span>
      </div>
      <div class="icon">
        <i class="ion ion-wifi"></i>
      </div>
      <a href="/<?= Yii::app()->controller->module->id ?>/devices" class="small-box-footer"
         onclick="getContent(this,'Устройства',false); return false;">Управление
        <i class="fa fa-arrow-circle-right"></i></a>
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} прибору|{n} приборам|{n} приборам',
              $problemObjectsCount
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} прибору|{n} приборам|{n} приборам',
              $problemObjectsCount
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
            ) . ' по ' . Yii::t(
              'main',
              '{n} прибору|{n} приборам|{n} приборам',
              $problemObjectsCount
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
<div class="row no-padding">
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title" data-widget="collapse">Активность сбора данных с приборов
          учёта</h3>
        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                class="fa fa-minus"></i>
          </button>
        </div>
      </div>
      <div class="box-body">

        <div class="row no-padding">
          <div class="col-md-8">
              <?
              $sql = "
                                            select to_char(max(tt.data_updated), 'TMMon, YYYY') AS \"date\"
                                             from obj_devices_data_view tt
                                            where tt.data_updated >= now() - interval '1 year' 
                                             group by to_char(tt.data_updated, 'YYYYMM')
                                            order by to_char(tt.data_updated, 'YYYYMM')  
                                            ";
              $XValues = Yii::app()->db->cache((YII_DEBUG ? 0 : 1200))->createCommand(
                $sql
              )->queryColumn();
              $sql = "
                                            select tt.source, count(0) as sourceCount
                                                from obj_devices_view tt
                                             group by tt.source";
              $seriesNames = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))
                ->createCommand(
                  $sql
                )
                ->queryAll();
              $sql = "
                                    select dd.date_order, dd.date, dd.source, 
                                    (select count(0) from (select 'x' from obj_devices_data_view odv2 
                                    where to_char(odv2.data_updated, 'YYYYMM') = dd.date_order
                                    and odv2.source = dd.source
                                    group by odv2.device_id) odv3
                                    ) as active_devices_count,
                                    (select count(0) from obj_devices_view odv4 
                                    where to_char(odv4.created_at, 'YYYYMM') <= dd.date_order
                                    and odv4.source = dd.source) as total_devices_count
                                    from
                                    (select to_char(tt.data_updated, 'YYYYMM') as date_order, 
                                    to_char(max(tt.data_updated), 'TMMon, YYYY') AS \"date\", 
                                    gg.source
                                    from obj_devices_data_view tt, (select * from (values('manual'),('nekta')) as g (source)) gg 
                                    where tt.data_updated >= now() - interval '1 year' 
                                     group by to_char(tt.data_updated, 'YYYYMM'), gg.source ) dd
                                     order by dd.date_order, dd.source ";
              $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))
                ->createCommand(
                  $sql
                )
                ->queryAll();
              $series = [];
              if (count($XValues)) {
                  foreach ($seriesNames as $seriesName) {
                      $serieActive = [
                        'name'  => $seriesName['source'] . ' - учтено',
                        'data'  => array_fill(0, count($XValues), 0),
                        'stack' => 'main',
                      ];
                      $serieUnused = [
                        'name'  => $seriesName['source'] . ' - нет данных',
                        'data'  => array_fill(0, count($XValues), 0),
                        'stack' => 'main',
                      ];
                      foreach ($XValues as $i => $XValue) {
                          foreach ($seriesData as $j => $serieData) {
                              if ($serieData['date'] == $XValue &&
                                $seriesName['source'] ==
                                $serieData['source']) { //&& $serieData['device_id'] == $seriesName
                                  $serieActive['data'][$i] = (float) $serieData['active_devices_count'];
                                  $serieUnused['data'][$i] =
                                    (float) $serieData['total_devices_count'] -
                                    (float) $serieData['active_devices_count'];
                                  //unset($seriesData[$j]);
                                  break;
                              }
                          }
                      }
                      $series[] = $serieActive;
                      $series[] = $serieUnused;
                  }
                  unset ($serieActive, $serieUnused);

                  $this->Widget(
                    'ext.highcharts.HighchartsWidget',
                    [
                      'htmlOptions' => [
                        'id' => 'dashboard-all-devices-activity-chart',
                      ],
                      'scripts'     => [
                        'highcharts-more',
                          // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                        'highcharts-3d',
                        'modules/exporting',
                          // adds Exporting button/menu to chart
                        'themes/grid-light'
                          // applies global 'grid' theme to all charts
                      ],
                      'options'     => [
                        'chart'       => [
                          'type'      => 'column',
                          'options3d' => [
                            'enabled'      => true,
                            'alpha'        => 10,
                            'beta'         => 5,
                            'viewDistance' => 35,
                            'depth'        => 40,
                          ]
                            // 'style' => 'width:100%;'
                        ],
                        'plotOptions' => [
                          'column' => [
                            'stacking'   => 'normal',
                            'depth'      => 40,
                            'dataLabels' => [
                              'enabled' => false,
                              'skew3d'  => true,
                            ],
                            'animation'  => [
                              'duration' => 0,
                              'defer'    => 0,
                            ],
                          ],
                        ],
                        'credits'     => ['enabled' => false],
                        'title'       => false,
                        'tooltip'     => [
                          'formatter' => "js:function (){
    return '<b>' + this.x + '</b><br/>' + this.series.name + ': ' + this.y + '<br/>' + 'Всего приборов: ' + this.point.stackTotal;
}",
                            //      'pointFormat' => '{series.name}: <b>{point.y:.1f}</b>'
                        ],
                        'xAxis'       => [
                          'categories'        => $XValues,
                          'labels'            => [
                            'skew3d' => true,
                          ],
                          'tickmarkPlacement' => 'on',
                          'title'             => [
                            'enabled' => false,
                          ],
                        ],
                        'yAxis'       => [
                          'min'         => 0,
                          'title'       => [
                            'text'   => 'Всего приборов и из них - учитываемых',
                            'skew3d' => true,
                          ],
                          'stackLabels' => [
                            'enabled' => true,
                            'skew3d'  => true,
                          ],
                        ],
                        'series'      => $series,
                      ],
                    ]
                  );
              } else { ?>
                <p>Нет данных</p>
              <? } ?>
              <?
              unset(
                $XValue, $XValues, $actualMsgs,
                $devicesTotalActive, $i, $j, $landsTotalActive,
                $msg, $msgs, $objProblems, $serie, $series, $seriesData,
                $seriesName, $seriesNames, $usersTotalActive
              );
              ?>
          </div>
          <div class="col-md-4">
              <?
              $sql = "select dd.source, 
                                        (select count(0) from (select 'x' from obj_devices_data_view odv2 
                                        where odv2.source = dd.source
                                        group by odv2.device_id) odv3
                                        ) as active_devices_count,
                                        (select count(0) from obj_devices_view odv4 
                                        where odv4.source = dd.source) as total_devices_count
                                        from
                                        (select gg.source
                                        from obj_devices_data_view tt, (select * from (values('manual'),('nekta')) as g (source)) gg 
                                        where tt.data_updated >= now() - interval '2 month' 
                                         group by gg.source ) dd
                                         order by dd.source";
              $seriesData = Yii::app()->db->cache((YII_DEBUG ? 0 : 7200))
                ->createCommand(
                  $sql
                )
                ->queryAll();
              $serie = [
                'name' => 'Установленные и учитываемые приборы',
                'data' => [],
              ];
              foreach ($seriesData as $serieData) {
                  //$seriesNames[] = $serieData['source']; active_devices_count
                  $serie['data'][] = [
                    'name' => $serieData['source'] . ': учтено',
                    'y'    => $serieData['active_devices_count'],
                  ];

                  $serie['data'][] = [
                    'name' => $serieData['source'] . ': не учтено',
                    'y'    => $serieData['total_devices_count'] - $serieData['active_devices_count'],
                  ];
              }
              $series = [$serie];
              $this->Widget(
                'ext.highcharts.HighchartsWidget',
                [
                  'htmlOptions' => [
                    'id' => 'dashboard-chart-pie-active-devices-last',
                  ],
                  'scripts'     => [
                    'highcharts-more',
                      // enables supplementary chart types (gauge, arearange, columnrange, etc.)
                    'highcharts-3d',
                    'modules/exporting',
                      // adds Exporting button/menu to chart
                    'themes/grid-light'
                      // applies global 'grid' theme to all charts
                  ],
                  'options'     => [
                    'chart'       => [
                      'type'      => 'pie',
                      'options3d' => [
                        'enabled'      => true,
                        'alpha'        => 25,
                        'beta'         => 5,
                        'viewDistance' => 35,
                        'depth'        => 40,
                      ]
                        // 'style' => 'width:100%;'
                    ],
                    'plotOptions' => [
                      'pie' => [
                        'allowPointSelect' => true,
                        'cursor'           => 'pointer',
                        'depth'            => 40,
                        'innerSize'        => 100,
                        'dataLabels'       => [
                          'enabled' => false,
                          'format'  => '{point.y} ({point.percentage:.1f}%)',
                          'skew3d'  => true,
                        ],
                        'showInLegend'     => true,
                      ],
                    ],
                    'credits'     => ['enabled' => false],
                    'title'       => false,
                    'tooltip'     => [
                      'pointFormat' => '{point.y} ({point.percentage:.1f}%)',
                    ],
                    'series'      => $series,
                  ],
                ]
              );
              ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
