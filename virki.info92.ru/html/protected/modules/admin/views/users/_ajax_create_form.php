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
/** @var Users $model */
?>
<div class="modal fade" id="users-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Создание пользователя') ?><?= Utils::getHelp(
              'create',
              true
            ) ?></h4>
      </div>
        <?php
        if (Yii::app()->user->notInRole(['superAdmin', 'topManager'])) {
            $htmlOptions = ['disabled' => 'disabled', 'readonly' => 'readonly'];
        } else {
            $htmlOptions = [];
        }
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'users-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["users/create"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_users (); } " /* Do ajax call when user presses enter key */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_users ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'fullname', ['id' => 'Users_fullname_create']); ?>
          <?php
          $model->new_email = $model->email;
          echo $form->textFieldRow($model, 'email', ['id' => 'Users_email_create']); ?>
          <?php echo $form->textFieldRow($model, 'new_password', ['id' => 'Users_new_password_create']); ?>
          <?php echo $form->textFieldRow($model, 'phone', ['id' => 'Users_phone_create']); ?>
          <?php echo $form->textAreaRow($model, 'post_address', ['id' => 'Users_post_address_create']); ?>
          <?php echo $form->textAreaRow($model, 'personal_data', ['id' => 'Users_personal_data_create']); ?>
          <?php echo $form->textAreaRow($model, 'contacts', ['id' => 'Users_contacts_create']); ?>
          <?php echo $form->textAreaRow($model, 'contracts', ['id' => 'Users_contracts_create']); ?>
          <?
          $htmlOptions['id'] = 'Users_debtor_status_create';
          echo $form->dropDownListRow(
            $model,
            'debtor_status',
            [
              'widgetOptions' => [
                'data'        => DicCustom::getVals('DEBTOR_STATUS'),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'Users_comments_create']); ?>
          <? // select2 test ?>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Users_lands_create">Участки</label>
          <div class="col-sm-9">
            <select id="Users_lands_create" class="form-control select2"
                    multiple="multiple" data-placeholder="Выберите участки"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Users[lands][]" style="width: 100%;">
                <?
                $landsList = Lands::getList();
                if ($landsList && is_array($landsList)) {
                    foreach ($landsList as $land) {
                        //lands_id, land_group, land_number, users
                        ?>
                      <option title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>"
                              value="<?= $land['lands_id'] ?>"><?= $land['land_group'] ?>
                        /№<?= $land['land_number'] ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
          <?
          $htmlOptions['id'] = 'Users_status_create';
          echo $form->dropDownListRow(
            $model,
            'status',
            [
              'widgetOptions' => [
                'data'        => [
                  '0'  => Yii::t('main', 'Не активирован'),
                  '1'  => Yii::t('main', 'Активирован'),
                  '-1' => Yii::t('main', 'Заблокирован'),
                ],
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?
          $htmlOptions['id'] = 'Users_role_create';
          echo $form->dropDownListRow(
            $model,
            'role',
            [
              'widgetOptions' => [
                'data'        => AccessRights::getRoles(),
                'htmlOptions' => $htmlOptions,
              ],
            ]
          ); ?>
          <?php
          $htmlOptions['id'] = 'Users_default_manager_create';
          $allowedManagers = Users::getAllowedManagersForUser(null, null, null);
          echo $form->dropDownListRow(
            $model,
            'default_manager',
            [
              'widgetOptions' => [
                'data'        => $allowedManagers,
                'htmlOptions' => $htmlOptions,
              ],
            ]
          );
          ?>
          <?php echo $form->checkboxRow($model, 'checked', ['id' => 'Users_checked_create']); ?>
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
              'htmlOptions' => ['onclick' => 'create_users ();'],
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

<script>
    function create_users() {
        var data = $('#users-create-form').serialize();
        jQuery.ajax({
                type: 'POST',
                url: '<?php
                  echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/users/create'); ?>',
                data: data,
                //@todo: Отрефакторить. Возвращать может объект или json, может сделать функцию - везде-везде, типа dsResult
                success, done: function (data, textStatus) {
                    //alert("succes:"+data);
                    if (data !== 'false' && data.match(/^(Ошибка|Error)/i)) {
                        dsAlert(data, 'Error', true);
                    } else {
                        $('#users-create-modal').modal('hide');
                        dsAlert(data, 'Message', true);
                    }
                },
                error, fail: function (data, textStatus) { // if error occured
                    dsAlert(data, 'Error', true);
                },
                always, complete: function (data) { // if error occured
                    $.fn.yiiGridView.update('users-grid', {});
                },
                dataType: 'html'
            }
        );
    }

    function renderCreateForm_users() {
        $('#users-create-form').each(function () {
            this.reset();
        });
        $('#Users_lands_create').select2(
            {
                allowClear: true,
                placeholder: 'Клик для выбора участков'
            }
        );
        $('#users-create-modal').modal('show');
    }

</script>
