<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var Lands $model */
$module = Yii::app()->controller->module->id;
?>
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Участок') ?>
    : <?= $model->land_group . '/№' . $model->land_number ?>        <?= Utils::getHelp(
        'update',
        true
      ) ?></h1>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title"><?= Yii::t('main', 'Редактирование участка') ?>:
              <?= $model->land_group . '/' . $model->land_number ?></h3>
        </div>
          <? /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'lands-update-form-single-' . $model->lands_id,
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
        <div class="box-body">
            <?php echo $form->errorSummary($model); ?>
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <?php echo $form->hiddenField(
                  $model,
                  'lands_id',
                  ['id' => 'Lands_land_id_update_single-' . $model->lands_id]
                ); ?>
                <?php $model->created = Utils::pgDateToStr($model->created);
                echo $form->uneditableRow(
                  $model,
                  'created',
                  ['id' => 'Lands_created_update_single-' . $model->lands_id]
                ); ?>
                <? $htmlOptions = ['id' => 'Lands_land_group_update_single-' . $model->lands_id];
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
                <?php echo $form->textFieldRow(
                  $model,
                  'land_number',
                  ['id' => 'Lands_land_number_update_single-' . $model->lands_id]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'land_number_cadastral',
                  ['id' => 'Lands_land_number_cadastral_update_single-' . $model->lands_id]
                ); ?>
                <?php echo $form->textAreaRow(
                  $model,
                  'address',
                  ['id' => 'Lands_address_update_single-' . $model->lands_id]
                ); ?>
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
                <?php echo $form->numberFieldRow(
                  $model,
                  'land_area',
                  ['id' => 'Lands_land_area_update_single-' . $model->lands_id]
                ); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <?php echo $form->numberFieldRow(
                  $model,
                  'land_geo_latitude',
                  ['id' => 'Lands_land_geo_latitude_update_single-' . $model->lands_id]
                ); ?>
                <?php echo $form->numberFieldRow(
                  $model,
                  'land_geo_longitude',
                  ['id' => 'Lands_land_geo_longitude_update_single-' . $model->lands_id]
                ); ?>
                <?php echo $form->textAreaRow(
                  $model,
                  'comments',
                  ['id' => 'Lands_comments_update_single-' . $model->lands_id]
                ); ?>
                <? // select2 test ?>
              <div class="form-group<?= ($model->hasErrors('devices') ? ' has-error' : '') ?>">
                <label class="col-sm-3 control-label"
                       for="Lands_devices_update_single-<?= $model->lands_id ?>">Приборы</label>
                <div class="col-sm-9">
                  <select id="Lands_devices_update_single-<?= $model->lands_id ?>"
                          class="form-control select2 select2-hidden-accessible"
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
              <div class="form-group<?= ($model->hasErrors('tariffs') ? ' has-error' : '') ?>">
                <label class="col-sm-3 control-label"
                       for="Lands_tariffs_update_single-<?= $model->lands_id ?>">Тарифы</label>
                <div class="col-sm-9">
                  <select id="Lands_tariffs_update_single-<?= $model->lands_id ?>"
                          class="form-control select2 select2-hidden-accessible"
                          multiple="multiple" data-placeholder="Клик для выбора приборов"
                    <?= (Yii::app()->user->notInRole(
                      ['superAdmin', 'topManager']
                    ) ? 'disabled="disabled"' : '') ?>
                          name="Lands[tariffs][]" style="width: 100%;"
                          aria-hidden="true">
                      <?
                      $tariffsList = Tariffs::getListForLand();
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
              <div class="form-group<?= ($model->hasErrors('users') ? ' has-error' : '') ?>">
                <label class="col-sm-3 control-label" for="Lands_users_update_single-<?= $model->lands_id ?>">Пользователи</label>
                <div class="col-sm-9">
                  <select id="Lands_users_update_single-<?= $model->lands_id ?>"
                          class="form-control select2 select2-hidden-accessible"
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
                                    value="<?= $user['uid'] ?>"<?= $selected ?>><?= addslashes(
                                  $user['fullname']
                                ) ?></option>
                          <? }
                      } ?>
                  </select>
                </div>
              </div>
                <?php echo $form->checkboxRow(
                  $model,
                  'status',
                  ['id' => 'Lands_status_update_single-' . $model->lands_id]
                ); ?>
            </div>
          </div>
        </div>
        <div class="box-footer">
            <?php $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'type'        => 'default',
                  //'size' => 'mini',
                'icon'        => 'fa fa-check',
                'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t(
                  'main',
                  'Сохранить'
                ),
                'htmlOptions' => [
                  'class'   => 'pull-right',
                  'onclick' => "update_lands_{$model->lands_id} ();",
                ],
              ]
            );
            ?>
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
          <?php
          $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box box-primary  collapsed-box">
        <div class="box-header with-border">
          <h3 class="box-title" data-widget="collapse">Расположение участка</h3>
          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
          </div>
        </div>
        <div class="box-body">
            <? if (isset($model) && $model->land_geo_longitude) { ?>
              <div class="YandexMap" id="dsYandexMap-land-<?= $model->lands_id ?>">
                <iframe
                    src="https://yandex.ru/map-widget/v1/?ll=<?= $model->land_geo_longitude ?>%2C<?= $model->land_geo_latitude ?>&z=18"
                    width="100%" height="600" frameborder="0" allowfullscreen="false"
                    style="position:relative; pointer-events: none;"
                ></iframe>
              </div>
              <script>
                  $('#dsYandexMap-land-<?=$model->lands_id?> > iframe').on('load', function () {
// создаём элемент <div>, который будем перемещать вместе с указателем мыши пользователя
                      $('body').find('#dsYandexMap-land-<?=$model->lands_id?>').each(
                          function () {
                              fixYandexMapScroll(this);
                          });
                  });
              </script>
            <? } else { ?>
              <p class="text-center">
                <strong>Координаты участка не определены</strong>
              </p>
            <? } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
    $(function () {
        /* var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
        if (instance) {
            instance.destroy(true);
        }
        CKEDITOR.replace('news_news_body_update-single-');
         */
        $('#Lands_devices_update_single-<?=$model->lands_id?>').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора приборов',
                templateSelection: function (state) {
                    if (!state.id) {
                        return state.text.trim(); // optgroup
                    } else {
                        return state.text.trim() +
                            '&nbsp;<a href="/<?=Yii::app(
                            )->controller->module->id?>/devices/view/id/' + state.id + '" title="Просмотр профиля прибора" onclick="getContent(this,\'' +
                            state.text.trim() +
                            '\',false);return false;"><i class="fa fa-external-link fa-fw text-white"></i></a>';
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            }
        );
        $('#Lands_tariffs_update_single-<?=$model->lands_id?>').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора тарифов'
            }
        );
        $('#Lands_users_update_single-<?=$model->lands_id?>').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора пользователей',
                templateSelection: function (state) {
                    if (!state.id) {
                        return state.text.trim(); // optgroup
                    } else {
                        return state.text.trim() +
                            '&nbsp;<a href="/<?=Yii::app(
                            )->controller->module->id?>/users/view/id/' + state.id + '" title="Просмотр профиля пользователя" onclick="getContent(this,\'' +
                            state.text.trim() +
                            '\',false);return false;"><i class="fa fa-external-link fa-fw text-white"></i></a>';
                    }
                },
                escapeMarkup: function (markup) {
                    return markup;
                }
            }
        );
    });

    function update_lands_<?=$model->lands_id?>() {
        /* var instance = CKEDITOR.instances['news_news_body_update-single-//=$model->id'];
        if (instance) {
            instance.updateElement();
        }
        */
        var data = $("#lands-update-form-single-<?=$model->lands_id?>").serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?=Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/lands/update')?>',
            data: data,
            success: function (data) {
                reloadSelectedTab(event);
                if (data !== 'false') {
                    dsAlert(data, 'Участок сохранён', true);
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });

    }
</script>
