<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleNewsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?
/** @var Devices $device */
$deviceGroupIconDefault = 'fa-question-circle';
$deviceGroupIcons = [
  1 => 'fa-tint',//Счётчик воды
  2 => 'fa-fire',//Счётчик газа
  3 => 'fa-thermometer-half',//Счётчик тепла
  4 => 'fa-bolt',//Счётчик электричества
  5 => 'fa-flask',//Счетчик вещества
  6 => 'fa-dashboard',//Датчик
  7 => 'fa-info-circle',//Прочее
];
?>
<? if (is_array($devices)) {
    foreach ($devices

             as $device) {
        $deviceValuesValid = (($device->starting_value1 && $device->value1)
          || ($device->starting_value2 && $device->value2)
          || ($device->starting_value3 && $device->value3));
        ?>
      <div class='device clearfix'>
        <div class="device-info">
          <i class="fa fa-2x fa-fw <?= (isset($deviceGroupIcons[$device->device_group_id]) ?
            $deviceGroupIcons[$device->device_group_id] : $deviceGroupIconDefault) ?>"></i>
            <?= Devices::getUpdateLink($device->devices_id, false, $device) ?>
            <?= ($device->active && $deviceValuesValid ?
              '<span class="pull-right" style="color:green;"><i class="fa fa-check"></i></span>' :
              '<span class="pull-right" style="color:red;"><i class="fa fa-close"></i></span>') ?>
          <br>
            <? if ($device->last_active && $device->last_active_left) { ?>
              <span title="Время последнего опроса"><?= Utils::pgDateToStr($device->last_active) ?></span>
              <span title="Прошло с последнего опроса">(<?= Utils::pgIntervalToStr($device->last_active_left) ?>)</span>
            <? } ?>
        </div>
          <? if (isset($device->value1)) { ?>
            <div class="device-value text-right"><?= Utils::formatDeviceValue($device->value1) ?></div>
          <? } ?>

          <? if (isset($device->value2)) { ?>
            <div class="device-value  text-right"><?= Utils::formatDeviceValue($device->value2) ?></div>
          <? } ?>

          <? if (isset($device->value3)) { ?>
            <div class="device-value  text-right"><?= Utils::formatDeviceValue($device->value3) ?></div>
          <? } ?>
      </div>
    <? }
} ?>

