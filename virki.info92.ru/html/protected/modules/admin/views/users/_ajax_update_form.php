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
/** @var Users $model */
?>
<div class="modal fade" id="users-update-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Редактирование пользователя') ?>
            <?= Utils::fullNameWithInitials($model->fullname); ?><?= Utils::getHelp('update', true) ?></h4>
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
            'id'                     => 'users-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["users/update"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",
                /* Disable normal form submit */
                //'onkeypress'=>" if(event.keyCode == 13){ update_users (); } " /* Do ajax call when user presses enter key */
            ],
          ]
        ); ?>
      <div class="modal-body">
        <p><?= Yii::t('main', 'Будьте предельно осторожны при редактировании данных пользователя!') . '<br/>' .
            Yii::t(
              'main',
              'В обычных обстоятельствах изменять персональные данные должен ИСКЛЮЧИТЕЛЬНО САМ ПОЛЬЗОВАТЕЛЬ!'
            ) ?></p>
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->uneditableRow($model, 'uid', ['id' => 'Users_uid_update']); ?>
          <?php $model->created = Utils::pgDateToStr($model->created);
          echo $form->uneditableRow($model, 'created', ['id' => 'Users_created_update']); ?>
          <?php echo $form->textFieldRow($model, 'fullname', ['id' => 'Users_fullname_update']); ?>
          <?php echo $form->textFieldRow($model, 'new_password', ['id' => 'Users_new_password_update']); ?>
          <?php
          $model->new_email = $model->email;
          echo $form->textFieldRow($model, 'new_email', ['id' => 'Users_new_email_update']); ?>
          <?php echo $form->textFieldRow($model, 'phone', ['id' => 'Users_phone_update']); ?>
          <?php echo $form->textAreaRow($model, 'post_address', ['id' => 'Users_post_address_update']); ?>
          <?php echo $form->textAreaRow($model, 'personal_data', ['id' => 'Users_personal_data_update']); ?>
          <?php echo $form->textAreaRow($model, 'contacts', ['id' => 'Users_contacts_update']); ?>
          <?php echo $form->textAreaRow($model, 'contracts', ['id' => 'Users_contracts_update']); ?>
          <?
          $htmlOptions['id'] = 'Users_debtor_status_update';
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
          <?php echo $form->textAreaRow($model, 'comments', ['id' => 'Users_comments_update']); ?>
          <? // select2 test ?>
        <div class="form-group">
          <label class="col-sm-3 control-label" for="Users_lands_update">Участки</label>
          <div class="col-sm-9">
            <select id="Users_lands_update" class="form-control select2 select2-hidden-accessible"
                    multiple="multiple" data-placeholder="Клик для выбора участков"
              <?= (Yii::app()->user->notInRole(
                ['superAdmin', 'topManager']
              ) ? 'disabled="disabled"' : '') ?>
                    name="Users[lands][]" style="width: 100%;"
                    aria-hidden="true">
                <?
                $landsList = Lands::getList();
                $landsOfUser = Lands::getList($model->uid);
                if (!is_array($landsOfUser)) {
                    $landsOfUser = [];
                }
                if ($landsList && is_array($landsList)) {
                    foreach ($landsList as $land) {
                        //lands_id, land_group, land_number, users
                        if (in_array($land['lands_id'], $landsOfUser)) {
                            $selected = ' selected="selected"';
                        } else {
                            $selected = '';
                        }
                        ?>
                      <option title="<?= ($land['users'] ? 'Владельцев: ' . $land['users'] : 'Нет владельцев') ?>"
                              value="<?= $land['lands_id'] ?>"<?= $selected ?>><?= addslashes(
                            $land['land_group'] . '/№' . $land['land_number']
                          ) ?></option>
                    <? }
                } ?>
            </select>
          </div>
        </div>
          <?
          $htmlOptions['id'] = 'Users_status_update';
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
          $htmlOptions['id'] = 'Users_role_update';
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
          $htmlOptions['id'] = 'Users_default_manager_update';
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
          <?php echo $form->checkboxRow($model, 'checked', ['id' => 'Users_checked_update']); ?>
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
              'htmlOptions' => ['onclick' => 'update_users ();'],
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




