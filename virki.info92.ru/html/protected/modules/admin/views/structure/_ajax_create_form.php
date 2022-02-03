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
/** @var Lands $model */
?>
<div class="modal fade" id="lands-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание участка') ?><?= Utils::getHelp('create', true) ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'lands-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["lands/create"],
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
                                          create_lands ();
                                        }
                                     }',
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
          <? $htmlOptions = ['id' => 'Lands_land_group_create'];
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
          <?php echo $form->textFieldRow($model, 'land_number', ['id' => 'Lands_land_number_create']); ?>
          <?php echo $form->textFieldRow($model, 'land_number_cadastral', ['id' => 'Lands_land_number_cadastral_create']
          ); ?>
          <?php echo $form->textAreaRow($model, 'address', ['id' => 'Lands_address_create']); ?>
          <?
          $htmlOptions['id'] = 'Lands_land_type_create';
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
          <?php echo $form->numberFieldRow($model, 'land_area', ['id' => 'Lands_land_area_create']); ?>
          <?php echo $form->numberFieldRow($model, 'land_geo_latitude', ['id' => 'Lands_land_geo_latitude_create']); ?>
          <?php echo $form->numberFieldRow($model, 'land_geo_longitude', ['id' => 'Lands_land_geo_longitude_create']
          ); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'Lands_comments_create']); ?>
          <? // select2 test ?>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Lands_devices_create">Приборы</label>
          <div class="col-sm-9">
            <select id="Lands_devices_create" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора приборов"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Lands[devices][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $devicesList = Devices::getList();
                if ($devicesList && is_array($devicesList)) {
                    foreach ($devicesList as $device) {
                        //lands_id, land_group, land_number, users
                        ?>
                      <option <?/* title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>" */ ?>
                          value="<?= $device['devices_id'] ?>">
                          <?= $device['source'] ?>/<?= ($device['name'] ? $device['name'] : $device['devices_id']) ?>
                      </option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Lands_users_create">Пользователи</label>
          <div class="col-sm-9">
            <select id="Lands_users_create" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора пользователей"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Lands[users][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $usersList = Users::getList();
                if ($usersList && is_array($usersList)) {
                    foreach ($usersList as $user) {
                        //lands_id, land_group, land_number, users
                        ?>
                      <option title="<?= ($user['lands'] ? 'Участков: ' . $user['lands'] : 'Нет участков') ?>"
                              value="<?= $user['uid'] ?>"><?= $user['fullname'] ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
          <?php echo $form->checkboxRow($model, 'status', ['id' => 'Lands_status_create']); ?>
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
              'htmlOptions' => ['onclick' => 'create_lands ();'],
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
    function create_lands() {
        var data = $('#lands-create-form').serialize();
        jQuery.ajax({
                type: 'POST',
                url: '<?php
                  echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/lands/create'); ?>',
                data: data,
                success: function (data) {
                    //alert("succes:"+data);
                    if (data !== 'false') {
                        $('#lands-create-modal').modal('hide');
                        $.fn.yiiGridView.update('lands-grid', {
                            //alert(data);
                        });

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

    function renderCreateForm_lands() {
        $('#lands-create-form').each(function () {
            this.reset();
        });
        $('#Lands_devices_create').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора приборов'
            }
        );
        $('#Lands_users_create').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора пользователей'
            }
        );
        $('#lands-create-modal').modal('show');
    }

</script>
