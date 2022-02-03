<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_ajax_create_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php
/** @var Devices $model */
?>
<div class="modal fade" id="devices-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание устройства') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'devices-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["devices/create"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_lands (); } " /* Do ajax call when land presses enter key */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_devices ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php
          $model->source = 'manual';
          echo $form->uneditableRow(
            $model,
            'source',
            ['id' => 'devices_source_create']
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'name',
            [
              'id'          => 'devices_name_create',
              'placeholder' => 'Удобное и понятное имя этого прибора',
              'title'       => 'Например: Эл-во уч.215',
            ]
          ); ?>
          <?php echo $form->textFieldRow(
            $model,
            'device_serial_number',
            [
              'id'          => 'devices_device_serial_number_create',
              'placeholder' => 'Необходимо для обслуживания прибора',
            ]
          ); ?>
          <?
          $htmlOptions = [];
          $htmlOptions['id'] = 'devices_device_group_id_create';
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
          $htmlOptions = [];
          $htmlOptions['id'] = 'devices_device_type_id_create';
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
          $htmlOptions = [];
          $htmlOptions['id'] = 'devices_model_id_create';
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
            ['id' => 'devices_properties_create']
          ); ?>
          <?php
          $model->report_period_update = 3600 * 24 * 31;
          echo $form->numberFieldRow(
            $model,
            'report_period_update',
            ['id' => 'devices_report_period_update_create']
          ); ?>
          <?php echo $form->textAreaRow(
            $model,
            'desc',
            ['id' => 'devices_desc_create']
          ); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'starting_value1',
            [
              'id'          => 'devices_starting_value1_create',
              'placeholder' => 'Начальное значение для однотарифного прибора',
            ]
          ); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'starting_value2',
            [
              'id'          => 'devices_starting_value2_create',
              'placeholder' => 'Начальное значение "день" для двухтарифного прибора',
            ]
          ); ?>
          <?php echo $form->numberFieldRow(
            $model,
            'starting_value3',
            [
              'id'          => 'devices_starting_value3_create',
              'placeholder' => 'Начальное значение "ночь" для двухтарифного прибора',
            ]
          ); ?>
          <?php $htmlOptionsEditable = [];
          $htmlOptionsEditable['id'] = 'devices_device_usage_id_create';
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
          <?php $htmlOptionsEditable = [];
          $htmlOptionsEditable['id'] = 'devices_device_status_id_create';
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
          <label class="col-sm-3 control-label" for="devices_lands_create">Участки</label>
          <div class="col-sm-9">
            <select id="devices_lands_create" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора участка"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Devices[lands][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $landsList = Lands::getList();
                if ($landsList && is_array($landsList)) {
                    foreach ($landsList as $land) {
                        ?>
                      <option <?/* title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>" */ ?>
                          value="<?= $land['lands_id'] ?>">
                          <?= $land['land_group'] ?>/№<?= $land['land_number'] ?>
                      </option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="devices_tariffs_create">Тарифы</label>
          <div class="col-sm-9">
            <select id="devices_tariffs_create" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора тарифа"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Devices[tariffs][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $tariffsList = Tariffs::getListForDevice();
                if ($tariffsList && is_array($tariffsList)) {
                    foreach ($tariffsList as $tariff) {
                        ?>
                      <option value="<?= $tariff['tariffs_id'] ?>"><?= $tariff['tariff_short_name'] ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
          <?php
          echo $form->checkboxRow(
            $model,
            'active',
            ['id' => 'devices_active_update']
          ); ?>
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
              'htmlOptions' => ['onclick' => 'create_devices ();'],
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
          <?php
          $this->widget(
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

<script type="text/javascript">
    function create_devices() {
        var data = $('#devices-create-form').serialize();
        jQuery.ajax({
                type: 'POST',
                url: '<?php
                  echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/devices/create"); ?>',
                data: data,
                success: function (data) {
                    if (data !== 'false') {
                        $('#devices-create-modal').modal('hide');
                        $.fn.yiiGridView.update('devices-grid', {});
                        dsAlert(data, 'Сохранение', true);
                    }

                },
                error: function (data) { // if error occured
                    dsAlert(JSON.stringify(data), 'Error', true);
                },

                dataType: 'html'
            }
        )
        ;

    }

    function renderCreateForm_devices() {
        $('#devices-create-form').each(function () {
            this.reset();
        });
        $('#devices_lands_create').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора участков'
            }
        );
        $('#devices_tariffs_create').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора тарифов'
            }
        );
        $('#devices-create-modal').modal('show');
    }

</script>
