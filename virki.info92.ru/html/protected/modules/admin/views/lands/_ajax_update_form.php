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
/** @var Lands $model */
?>
<div class="modal fade" id="lands-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование участка ') ?>
            <?= $model->land_group . '/' . $model->land_number; ?><?= Utils::getHelp('update', true) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'lands-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["lands/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key */
            ],
          ]
        ); ?>
        <? /*
            * lands_id
            * land_group
            * land_number
            * land_number_cadastral
            * address
            * land_area
            * land_geo_latitude
            * land_geo_longitude
            * created
            * status
            * comments
            */ ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <? $htmlOptions = ['id' => 'Lands_land_group_update'];
          echo $form->dropDownListRow(
            $model,
            'land_group',
            [
              'widgetOptions' => [
                'data'        => Lands::getGroups(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->hiddenField($model, 'lands_id', ['id' => 'Lands_land_id_update']); ?>
          <?php echo $form->textFieldRow($model, 'land_number', ['id' => 'Lands_land_number_update']); ?>
          <?php echo $form->textFieldRow($model, 'land_number_cadastral', ['id' => 'Lands_land_number_cadastral_update']
          ); ?>
          <?php echo $form->textAreaRow($model, 'address', ['id' => 'Lands_address_update']); ?>
          <?
          $htmlOptions['id'] = 'Lands_land_type_update';
          echo $form->dropDownListRow(
            $model,
            'land_type',
            [
              'widgetOptions' => [
                'data'        => DicCustom::getVals('LAND_TYPE'),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->textFieldRow($model, 'land_area', ['id' => 'Lands_land_area_update']); ?>
          <?php echo $form->textFieldRow($model, 'land_geo_latitude', ['id' => 'Lands_land_geo_latitude_update']); ?>
          <?php echo $form->textFieldRow($model, 'land_geo_longitude', ['id' => 'Lands_land_geo_longitude_update']); ?>
          <?php $model->created = Utils::pgDateToStr($model->created);
          echo $form->uneditableRow($model, 'created', ['id' => 'Lands_created_update']); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'Lands_comments_update']); ?>
          <? // select2 test ?>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Lands_devices_update">Приборы</label>
          <div class="col-sm-9">
            <select id="Lands_devices_update" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора приборов"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Lands[devices][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $devicesList = Devices::getList();
                $devicesOfLand = Devices::getList($model->lands_id);
                if (!is_array($devicesOfLand)) {
                    $devicesOfLand = [];
                }
                if ($devicesList && is_array($devicesList)) {
                    foreach ($devicesList as $device) {
                        //lands_id, land_group, land_number, users
                        if (in_array($device['devices_id'], $devicesOfLand)) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        ?>
                      <option <?/* title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>" */ ?>
                          value="<?= $device['devices_id'] ?>"<?= $selected ?>>
                          <?= addslashes(
                            $device['source'] . '/' . ($device['name'] ? $device['name'] : $device['devices_id'])
                          ) ?>
                      </option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Lands_tariffs_update">Тарифы</label>
          <div class="col-sm-9">
            <select id="Lands_tariffs_update" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора тарифов"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Lands[tariffs][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $tariffsList = Tariffs::getListForLand();
                //@todo: разобраться!
                $tariffsOfLand = Tariffs::getListForLand($model->lands_id);
                if (!is_array($tariffsOfLand)) {
                    $tariffsOfLand = [];
                }
                if ($tariffsList && is_array($tariffsList)) {
                    foreach ($tariffsList as $tariff) {
                        //lands_id, land_group, land_number, users
                        if (in_array($tariff['tariffs_id'], $tariffsOfLand)) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        ?>
                      <option <?/* title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>" */ ?>
                          value="<?= $tariff['tariffs_id'] ?>"<?= $selected ?>><?= addslashes(
                            $tariff['tariff_short_name']
                          ) ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
          <? // select2 test ?>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Lands_users_update">Пользователи</label>
          <div class="col-sm-9">
            <select id="Lands_users_update" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора пользователя"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Lands[users][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $usersList = Users::getList();
                $usersOfLand = Lands::getList($model->lands_id, true);
                if (!is_array($usersOfLand)) {
                    $usersOfLand = [];
                }
                if ($usersList && is_array($usersList)) {
                    foreach ($usersList as $user) {
                        //lands_id, land_group, land_number, users
                        if (in_array($user['uid'], $usersOfLand)) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        ?>
                      <option title="<?= ($user['lands'] ? 'Участков: ' . $user['lands'] : 'Нет участков') ?>"
                              value="<?= $user['uid'] ?>"<?= $selected ?>><?= addslashes($user['fullname']) ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>

          <?php echo $form->checkboxRow($model, 'status', ['id' => 'Lands_status_update']); ?>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size'        => 'mini',
              'icon'        => 'fa fa-check',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'update_lands ();'],
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
          );
          ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->




