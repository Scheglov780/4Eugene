<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://drop-shop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="main.php">
 * </description>
 * Главная страница сайта (не путать с лэйаутом)
 * var $itemsPopular = true
 * var $itemsRecommended = true
 * var $itemsRecentUser = false
 * var $itemsRecentAll = true
 **********************************************************************************************************************/
?>
<?
/** @var Lands $data */
?>
<div class="land">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title" data-widget="collapse"><?=
          Lands::getUpdateLink(
            $data->lands_id,
            false,
            $data,
            $data->land_group . ', участок №' . $data->land_number
          ) ?></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl class="dl-horizontal">
        <dt><?= $data->getAttributeLabel('land_number_cadastral') ?>:</dt>
        <dd><? if ($data->land_number_cadastral) { ?>
            <a href="https://egrp365.ru/reestr?egrp=<?= $data->land_number_cadastral ?>"
               target="_blank"
               title="Смотреть кадастровые подробности"><?= $data->land_number_cadastral ?></a>
            <? } else { ?>не определено<? } ?></dd>
        <dt><?= $data->getAttributeLabel('address') ?>:</dt>
        <dd><? if ($data->address) { ?>
                <? if ($data->land_geo_latitude && $data->land_geo_longitude) { ?>
              <a href="https://yandex.ru/maps/?text=<?= $data->land_geo_latitude ?>%2C<?= $data->land_geo_longitude ?>"
                 target="_blank" title="Смотреть на карте"><?= $data->address ?></a>
                <? } else { ?>
                    <?= $data->address ?>
                <? }
            } else { ?>не определено<? } ?></dd>
        <dt><?= $data->getAttributeLabel('land_area') ?>:</dt>
        <dd><?= ($data->land_area ? $data->land_area : 'не определено') ?></dd>
        <dt><?= $data->getAttributeLabel('comments') ?>:</dt>
        <dd><?= ($data->comments ? $data->comments : 'не определено') ?></dd>
        <dt><?= $data->getAttributeLabel('created') ?>:</dt>
        <dd><?= ($data->created ? Utils::pgDateToStr($data->created) : 'не определено') ?></dd>

        <dt><?= $data->getAttributeLabel('users') ?>:</dt>
        <dd><? $users = json_decode($data->users);
            if ($users && count($users)) {
                foreach ($users as $user) {
                    ?>
                  <span style="white-space: nowrap;">
                                        <a href="<?= Users::getUpdateLink($user->uid, true) ?>"
                                           title="<?= Yii::t('main', 'Параметры пользователя - подробно') ?>">
                                            <?= $user->fullname ?><?= ($user->phone ? '<br>' . $user->phone : '') ?>
                                        </a>
                                    </span>
                    <?
                }
            } ?></dd>
        <dt><?= $data->getAttributeLabel('devices') ?>:</dt>
        <dd><? $devices = json_decode($data->devices);
            if ($devices && count($devices)) {
                foreach ($devices as $device) {
                    ?>
                  <span style="white-space: nowrap;">
                                          <a href="<?= Devices::getUpdateLink($device->devices_id, true) ?>"
                                             title="<?= Yii::t('main', 'Параметры прибора - подробно') ?>">
                                              <strong><?= $device->source . '/' . $device->devices_id ?></strong>
                                          </a> <?= ($device->active ?
                        '<span class="pull-right" style="color:green;">активен</span>' :
                        '<span style="color:red;">не активен</span>') ?><br>
                                          <span title="Время последнего опроса"><?= Utils::pgDateToStr(
                                                $device->last_active
                                              ) ?></span> <span
                        title="Прошло с последнего опроса">(<?= Utils::pgIntervalToStr(
                            $device->last_active_left
                          ) ?>)</span>
                                          <? if (isset($device->value1)) { ?>
                                            <br><span>Тариф1:</span><span
                                                class="device-value pull-right"><?= $device->value1 ?></span>
                                          <? } ?>
                      <? if (isset($device->value2)) { ?>
                        <br><span>Тариф2:</span><span
                            class="device-value pull-right"><?= $device->value2 ?></span>
                      <? } ?>
                      <? if (isset($device->value3)) { ?>
                        <br><span>Тариф3:</span><span
                            class="device-value pull-right"><?= $device->value3 ?></span>
                      <? } ?>
                                      </span>
                    <?
                }
            } ?></dd>
      </dl>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
