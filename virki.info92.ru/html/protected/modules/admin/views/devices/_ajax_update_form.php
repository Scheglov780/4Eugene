<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_update_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var Devices $model */
?>
<div class="modal fade" id="devices-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование устройства ') ?>
            <?= $model->source . '/' . ($model->name ? $model->name : $model->devices_id); ?><?= Utils::getHelp(
              'update',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'devices-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["devices/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_devices (); } "
                /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <? if ($model->source == 'manual') {
              $htmlOptions = [];
          } else {
              $htmlOptions = ['disabled' => 'disabled', 'readonly' => 'readonly'];
          }
          ?>
          <?php echo $form->hiddenField($model, 'devices_id', ['id' => 'devices_id_update']); ?>
          <?php echo $form->uneditableRow(
            $model,
            'source',
            array_merge($htmlOptions, ['id' => 'devices_source_update'])
          ); ?>
          <?php echo $form->uneditableRow(
            $model,
            'devices_id',
            array_merge($htmlOptions, ['id' => 'devices_id_update^'])
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'name',
            array_merge(
              [],//$htmlOptions,
              [
                'id'          => 'devices_name_update',
                'placeholder' => 'Удобное и понятное имя этого прибора',
                'title'       => 'Например: Эл-во уч.215',
              ]
            )
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'device_serial_number',
            array_merge(
              [],//$htmlOptions,
              [
                'id'          => 'devices_device_serial_number_update',
                'placeholder' => 'Необходимо для обслуживания прибора',
              ]
            )
          ); ?>
          <?
          $htmlOptions['id'] = 'devices_device_group_id_update';
          echo $form->dropDownListRow(
            $model,
            'device_group_id',
            [
              'widgetOptions' => [
                'data'        => Devices::getGroups(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?
          $htmlOptions['id'] = 'devices_device_type_id_update';
          echo $form->dropDownListRow(
            $model,
            'device_type_id',
            [
              'widgetOptions' => [
                'data'        => Devices::getTypes(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?
          $htmlOptions['id'] = 'devices_model_id_update';
          echo $form->dropDownListRow(
            $model,
            'model_id',
            [
              'widgetOptions' => [
                'data'        => Devices::getModels(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'properties',
            array_merge($htmlOptions, ['id' => 'devices_properties_update'])
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'report_period_update',
            array_merge($htmlOptions, ['id' => 'devices_report_period_update_update'])
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'desc',
            array_merge(
              [],//$htmlOptions,
              ['id' => 'devices_desc_update']
            )
          ); ?>

          <?php
          $model->created_at = Utils::pgDateToStr($model->created_at);
          echo $form->uneditableRow(
            $model,
            'created_at',
            array_merge($htmlOptions, ['id' => 'devices_created_at_update'])
          ); ?>
          <?php /* echo $form->textFieldRow($model, 'updated_at',
                  array_merge($htmlOptions, array('id' => 'devices_updated_at_update'))); */ ?>
          <?php /* echo $form->textFieldRow($model, 'deleted_at',
                  array_merge($htmlOptions, array('id' => 'devices_deleted_at_update'))); */ ?>
          <?php echo $form->textFieldRow(
            $model,
            'starting_value1',
            array_merge(
              [],//$htmlOptions,
              [
                'id'          => 'devices_starting_value1_update',
                'placeholder' => 'Начальное значение для однотарифного прибора',
              ]
            )
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'starting_value2',
            array_merge(
              [],//$htmlOptions,
              [
                'id'          => 'devices_starting_value2_update',
                'placeholder' => 'Начальное значение "день" для двухтарифного прибора',
              ]
            )
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'starting_value3',
            array_merge(
              [],//$htmlOptions,
              [
                'id'          => 'devices_starting_value3_update',
                'placeholder' => 'Начальное значение "ночь" для двухтарифного прибора',
              ]
            )
          ); ?>
          <?
          $htmlOptionsEditable = [];
          $htmlOptionsEditable['id'] = 'devices_device_usage_id_update';
          echo $form->dropDownListRow(
            $model,
            'device_usage_id',
            [
              'widgetOptions' => [
                'data'        => DicCustom::getVals('DEVICE_USAGE'),
                'htmlOptions' => $htmlOptionsEditable,
              ],
            ]
          ); ?>
          <?
          $htmlOptionsEditable = [];
          $htmlOptionsEditable['id'] = 'devices_device_status_id_update';
          echo $form->dropDownListRow(
            $model,
            'device_status_id',
            [
              'widgetOptions' => [
                'data'        => DicCustom::getVals('DEVICE_STATE'),
                'htmlOptions' => $htmlOptionsEditable,
              ],
            ]
          ); ?>

          <? // select2 test ?>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="devices_lands_update">Участки</label>
          <div class="col-sm-9">
            <select id="devices_lands_update" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора участка"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Devices[lands][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $landsList = Lands::getList();
                $landsOfDevice = Devices::getList($model->devices_id, true);
                if (!is_array($landsOfDevice)) {
                    $landsOfDevice = [];
                }
                if ($landsList && is_array($landsList)) {
                    foreach ($landsList as $land) {
                        //lands_id, land_group, land_number, users
                        if (in_array($land['lands_id'], $landsOfDevice)) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        ?>
                      <option <?/* title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>" */ ?>
                          value="<?= $land['lands_id'] ?>"<?= $selected ?>>
                          <?= addslashes($land['land_group'] . '/№' . $land['land_number']) ?>
                      </option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="devices_tariffs_update">Тарифы</label>
          <div class="col-sm-9">
            <select id="devices_tariffs_update" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора тарифа"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Devices[tariffs][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $tariffsList = Tariffs::getListForDevice();
                $tariffsOfDevice = Tariffs::getListForDevice($model->devices_id);
                if (!is_array($tariffsOfDevice)) {
                    $tariffsOfDevice = [];
                }
                if ($tariffsList && is_array($tariffsList)) {
                    foreach ($tariffsList as $tariff) {
                        //tariffs_id
                        if (in_array($tariff['tariffs_id'], $tariffsOfDevice)) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        ?>
                      <option value="<?= $tariff['tariffs_id'] ?>"<?= $selected ?>><?= addslashes(
                            $tariff['tariff_short_name']
                          ) ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
          <?php echo $form->checkboxRow(
            $model,
            'active',
            array_merge(
              [],//$htmlOptions,
              ['id' => 'devices_active_update']
            )
          ); ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
              'icon'        => 'fa fa-check', // fa-inverse
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'update_devices ();'],
            ]
          );
          ?>
          <?
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
                //'id'=>'sub2',
              'type'        => 'default',
              'icon'        => 'fa fa-close', //fa-inverse
              'label'       => Yii::t('main', 'Отмена'),
              'htmlOptions' => ['data-dismiss' => 'modal'],
            ]
          ); ?>
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'type'        => 'default',
                //'size'       => 'mini',
              'icon'        => 'fa fa-rotate-left',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




