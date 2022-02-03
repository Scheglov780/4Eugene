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
/** @var Devices $data */
?>
<div class="device">
  <div class="box box-default">
    <div class="box-header with-border">
      <h3 class="box-title" data-widget="collapse"><?= Devices::getUpdateLink($data->devices_id, false, $data) ?></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
        </button>
      </div>
      <!-- /.box-tools -->
    </div>
    <!-- /.box-header -->
    <div class="box-body">
      <dl class="dl-horizontal">
        <dt><?= $data->getAttributeLabel('name') ?>:</dt>
        <dd><?= ($data->name ? $data->name : 'не определено') ?></dd>
        <dt><?= $data->getAttributeLabel('device_type_id') ?>:</dt>
        <dd><?= $data->device_type_id . '/' . $data->device_group_id . '/' . $data->model_id ?></dd>
        <dt><?= $data->getAttributeLabel('address') ?>:</dt>
        <dd><? $addressObj = json_decode($data->address);
            if ($addressObj && isset($addressObj->unrestricted_value)) {
                echo $addressObj->unrestricted_value;
            } else {
                echo '';
            } ?></dd>
        <dt><?= $data->getAttributeLabel('created_at') ?>:</dt>
        <dd><?= (Utils::pgDateToStr($data->created_at) . ' (' . Utils::pgIntervalToStr(
                $data->created_at_left
              ) . ')') ?></dd>
        <dt><?= $data->getAttributeLabel('last_active') ?>:</dt>
        <dd><? $result = Utils::pgDateToStr($data->last_active);
            if ($data->last_active_left) {
                $result = $result . ' (' . Utils::pgIntervalToStr($data->last_active_left) . ')';
            }
            echo $result; ?></dd>
        <dt><?= $data->getAttributeLabel('data_updated') ?>:</dt>
        <dd><? $result = Utils::pgDateToStr($data->data_updated);
            if ($data->data_updated_left) {
                $result = $result . ' (' . Utils::pgIntervalToStr($data->data_updated_left) . ')';
            }
            echo $result; ?></dd>
        <dt><?= 'Показания' ?>:</dt>
        <dd><? if (isset($data->value1)) { ?>
            <span style="white-space: nowrap;">
                                              <span>Тариф1:</span><span
                  class="device-value pull-right"><?= $data->value1 ?></span>
                                    </span>
            <? } ?>

            <? if (isset($data->value2)) { ?>
              <br><span style="white-space: nowrap;">
                                        <span>Тариф2:</span><span
                    class="device-value pull-right"><?= $data->value2 ?></span>
                                        </span>
            <? } ?>

            <? if (isset($data->value3)) { ?>
              <br><span style="white-space: nowrap;">
                                        <span>Тариф3:</span><span
                    class="device-value pull-right"><?= $data->value3 ?></span>
                                    </span>
            <? } ?></dd>
        <dt><?= $data->getAttributeLabel('lands') ?>:</dt>
        <dd><? $lands = json_decode($data->lands);
            if ($lands && count($lands)) {
                foreach ($lands as $land) {
                    ?>
                  <span style="white-space: nowrap;">
                                        <a href="<?= Lands::getUpdateLink($land->lands_id, true) ?>"
                                           title="<?= Yii::t('main', 'Параметры участка - подробно') ?>">
                                            <?= $land->land_group . '/№' . $land->land_number ?><?= ($land->address ?
                                              '<br>' . $land->address : '') ?>
                                        </a>
                                    </span>
                    <?
                }
            } ?></dd>
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
      </dl>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
