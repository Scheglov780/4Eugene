<?php
/** @var Devices $device */
$device = $data;
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
$valueIsOld = Utils::pgDateToLeftSec($device->last_active) > 2 * 31 * 24 * 3600;
$boxColor = 'box-default';
if ($device->starting_date) {
    if (((float) $device->starting_value1 && (float) $device->value1)
      || (((float) $device->starting_value2 && (float) $device->value2)
        && ((float) $device->starting_value3 && (float) $device->value3))) {
        $boxColor = 'box-success';
    } else {
        $boxColor = 'box-warning';
    }
} else {
    $boxColor = 'box-danger';
}
$deviceValuesValid = (((float) $device->starting_value1 && (float) $device->value1)
  || (((float) $device->starting_value2 && (float) $device->value2)
    && ((float) $device->starting_value3 && (float) $device->value3)));
if (!function_exists('colorizeInputs')) {
    function colorizeInputs($start_value, $value): stdClass
    {
        $_start_value = (float) $start_value;
        $_value = (float) $value;
        $result = new stdClass();
        $result->start_value_color = '';
        $result->value_color = '';
        $result->start_value_icon = '';
        $result->value_icon = '';
        if ($_value && $_start_value && ($_value > $_start_value)) {
            $result->start_value_color = 'has-success';
            $result->start_value_icon = '<i class="fa fa-check"></i>';
            $result->value_color = 'has-success';
            $result->value_icon = '<i class="fa fa-check"></i>';
        } elseif (empty($_value) && empty($_start_value)) {
            $result->start_value_color = 'has-warning';
            $result->start_value_icon = '<i class="fa fa-bell-o"></i>';
            $result->value_color = 'has-warning';
            $result->value_icon = '<i class="fa fa-bell-o"></i>';
        } elseif ($_start_value && empty($_value)) {
            $result->start_value_color = 'has-success';
            $result->start_value_icon = '<i class="fa fa-check"></i>';
            $result->value_color = 'has-warning';
            $result->value_icon = '<i class="fa fa-bell-o"></i>';
        } elseif (empty($_start_value) && $_value) {
            $result->start_value_color = 'has-error';
            $result->start_value_icon = '<i class="fa fa-times-circle-o"></i>';
            $result->value_color = 'has-success';
            $result->value_icon = '<i class="fa fa-check"></i>';
        }
        return $result;
    }
}
?>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-solid <?= $boxColor ?>">
        <div class="box-header with-border">
          <h3 class="box-title" style="font-size: inherit">
            <strong><?= $device->source .
                ' / ' .
                ($device->name ? $device->name :
                  ($device->device_serial_number ? $device->device_serial_number :
                    $device->device_usage_name)) ?></strong>
              <?= ($device->name ? ' (' . $device->name . ')' : '') ?></h3>
        </div>
        <!-- /.box-header -->
          <?php
          /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'form-readings-' . $device->devices_id,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["#"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",
              ],
              'clientOptions'          => [
                'validateOnType'   => false,
                'validateOnSubmit' => false,
                'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                        }
                                     }',
              ],
            ]
          ); ?>
        <div class="box-body">
          <div class="col-md-3">
            <div class="box box-solid">
              <div class="box-header">
                <h3 class="box-title" style="font-size: inherit"><strong>Один тариф</strong></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                  <? $id = "readings[{$device->devices_id}][devices_id]"; ?>
                <input id="<?= $id ?>" name="<?= $id ?>" type="hidden" value="<?= $device->devices_id ?>">
                  <? $colorize = colorizeInputs($device->starting_value1, $device->value1) ?>
                <div class="form-group <?= $colorize->start_value_color ?>">
                    <? $id = "readings[{$device->devices_id}][starting_value1]"; ?>
                  <label class="control-label col-sm-4" for="<?= $id ?>"><span
                        class="text-nowrap"><?= $colorize->start_value_icon ?> V1<sub>нач</sub></span></label>
                  <div class="col-sm-8">
                    <input id="<?= $id ?>" name="<?= $id ?>"
                           class="form-control text-right input-sm device-value-lg"
                           type="text" data-inputmask="'mask': '9', 'repeat': 8, 'greedy' : false"
                           data-mask value="<?= sprintf('%01.0f', $device->starting_value1) ?>">
                  </div>
                </div>
                <div class="form-group <?= $colorize->value_color ?>">
                    <? $id = "readings[{$device->devices_id}][value1]"; ?>
                  <label class="control-label col-sm-4" for="<?= $id ?>"><span
                        class="text-nowrap"><?= $colorize->value_icon ?> V1<sub>тек</sub></span></label>
                  <div class="col-sm-8">
                    <input id="<?= $id ?>" name="<?= $id ?>"
                           class="form-control text-right input-sm device-value-lg"
                           type="text" data-inputmask="'mask': '9', 'repeat': 8, 'greedy' : false"
                           data-mask value="<?= sprintf('%01.0f', $device->value1) ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-solid">
              <div class="box-header">
                <h3 class="box-title" style="font-size: inherit"><strong>Два тарифа</strong></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-md-6">
                      <? $colorize = colorizeInputs($device->starting_value2, $device->value2) ?>
                    <div class="form-group <?= $colorize->start_value_color ?>">
                        <? $id = "readings[{$device->devices_id}][starting_value2]"; ?>
                      <label class="control-label col-sm-4" for="<?= $id ?>"><span
                            class="text-nowrap"><?= $colorize->start_value_icon ?> V2<sub>нач</sub></span></label>
                      <div class="col-sm-8">
                        <input id="<?= $id ?>" name="<?= $id ?>"
                               class="form-control text-right input-sm device-value-lg"
                               type="text"
                               data-inputmask="'mask': '9', 'repeat': 8, 'greedy' : false"
                               data-mask
                               value="<?= sprintf('%01.0f', $device->starting_value2) ?>">
                      </div>
                    </div>
                    <div class="form-group <?= $colorize->value_color ?>">
                        <? $id = "readings[{$device->devices_id}][value2]"; ?>
                      <label class="control-label col-sm-4" for="<?= $id ?>"><span
                            class="text-nowrap"><?= $colorize->value_icon ?> V2<sub>тек</sub></span></label>
                      <div class="col-sm-8">
                        <input id="<?= $id ?>" name="<?= $id ?>"
                               class="form-control text-right input-sm device-value-lg"
                               type="text"
                               data-inputmask="'mask': '9', 'repeat': 8, 'greedy' : false"
                               data-mask
                               value="<?= sprintf('%01.0f', $device->value2) ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                      <? $colorize = colorizeInputs($device->starting_value3, $device->value3) ?>
                    <div class="form-group <?= $colorize->start_value_color ?>">
                        <? $id = "readings[{$device->devices_id}][starting_value3]"; ?>
                      <label class="control-label col-sm-4" for="<?= $id ?>"><span
                            class="text-nowrap"><?= $colorize->start_value_icon ?> V3<sub>нач</sub></span></label>
                      <div class="col-sm-8">
                        <input id="<?= $id ?>" name="<?= $id ?>"
                               class="form-control text-right input-sm device-value-lg"
                               type="text"
                               data-inputmask="'mask': '9', 'repeat': 8, 'greedy' : false"
                               data-mask
                               value="<?= sprintf('%01.0f', $device->starting_value3) ?>">
                      </div>
                    </div>
                    <div class="form-group <?= $colorize->value_color ?>">
                        <? $id = "readings[{$device->devices_id}][value3]"; ?>
                      <label class="control-label col-sm-4" for="<?= $id ?>"><span
                            class="text-nowrap"><?= $colorize->value_icon ?> V3<sub>тек</sub></span></label>
                      <div class="col-sm-8">
                        <input id="<?= $id ?>" name="<?= $id ?>"
                               class="form-control text-right input-sm device-value-lg"
                               type="text"
                               data-inputmask="'mask': '9', 'repeat': 8, 'greedy' : false"
                               data-mask
                               value="<?= sprintf('%01.0f', $device->value3) ?>">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                      <? if ($device->last_active && $device->last_active_left) { ?>
                        <p <?= ($valueIsOld ? 'class ="text-danger"' : '') ?>>
                                                <span title="Время последних показаний"><?= Utils::pgDateToStr(
                                                      $device->last_active
                                                    ) ?></span>
                          <span title="Прошло с момента полсдедних показаний">(<?= Utils::pgIntervalToStr(
                                $device->last_active_left
                              ) ?>)</span>
                        </p>
                      <? } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="box box-solid">
              <div class="box-header">
                <h3 class="box-title" style="font-size: inherit"><strong>Начальное сальдо</strong></h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="form-group">
                    <? $id = "readings[{$device->devices_id}][starting_balance]"; ?>
                  <label class="control-label col-sm-4" for="<?= $id ?>"><span
                        class="text-nowrap">Сумма</span></label>
                  <div class="col-sm-8">
                    <input id="<?= $id ?>" name="<?= $id ?>"
                           class="form-control text-right input-sm device-value-lg"
                           type="text" data-inputmask="'alias': 'currency'"
                           data-mask value="<?= sprintf('%01.2f', $device->starting_balance) ?>">
                  </div>
                </div>
                <div class="form-group">
                    <? $id = "readings[{$device->devices_id}][starting_date]"; ?>
                  <label class="control-label col-sm-4" for="<?= $id ?>"><span
                        class="text-nowrap">Дата</span></label>
                  <div class="col-sm-8">
                    <input id="<?= $id ?>" name="<?= $id ?>" readonly
                           class="form-control text-right input-sm device-value-lg"
                           type="text" value="<?= Utils::pgDateToStr($device->starting_date) ?>">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="box-footer">
            <?php
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType' => 'reset',
                'type'       => 'default',
                  //'size'        => 'extra_small',
                'icon'       => 'fa fa-rotate-left',
                'tooltip'    => Yii::t('main', 'Отмена сделанных изменений'),
                'label'      => Yii::t('main', 'Отмена'),
                  //'htmlOptions' => array('class' => 'pull-right'),
              ]
            ); ?>
            <?php
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'type'        => 'info',
                  //'size'        => 'extra_small',
                'icon'        => 'fa fa-check',
                'label'       => Yii::t('main', 'Сохранить'),
                'htmlOptions' => [
                  'class'   => 'pull-right',//'btn-flat',
                  'onclick' => "saveDeviceReadings({$device->devices_id});",
                ],
              ]
            );
            ?>
        </div>
          <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>

<? /* if (is_array($devices)) {
    foreach ($devices

             as $device) { ?>
        <div class='device clearfix'>
            <div class="device-info">
                <i class="fa fa-2x fa-fw <?= (isset($deviceGroupIcons[$device->device_group_id]) ? $deviceGroupIcons[$device->device_group_id] : $deviceGroupIconDefault) ?>"></i>
                <?= Devices::getUpdateLink($device->devices_id, false, $device) ?>
                <?= ($device->active ? '<span class="pull-right" style="color:green;"><i class="fa fa-check"></i></span>' : '<span class="pull-right" style="color:red;"><i class="fa fa-close"></i></span>') ?>
                <br>
                <span title="Время последнего опроса"><?= Utils::pgDateToStr($device->last_active) ?></span>
                <span title="Прошло с последнего опроса">(<?= Utils::pgIntervalToStr($device->last_active_left) ?>)</span>
            </div>
            <? if (isset($device->value1)) { ?>
                <div class="device-value text-right"><?= Utils::formatDeviceValue($device->value1)?></div>
            <? } ?>

            <? if (isset($device->value2)) { ?>
                <div class="device-value  text-right"><?= Utils::formatDeviceValue($device->value2)?></div>
            <? } ?>

            <? if (isset($device->value3)) { ?>
                <div class="device-value  text-right"><?= Utils::formatDeviceValue($device->value3)?></div>
            <? } ?>
        </div>
    <? }
} */ ?>