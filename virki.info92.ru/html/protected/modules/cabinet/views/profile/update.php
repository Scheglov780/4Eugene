<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="update.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /** @var Users $model */ ?>
<? $module = Yii::app()->controller->module->id;
/** @var Lands $lands */
$lands = new Lands('search');
$lands->unsetAttributes();
$landsCriteria = new CDbCriteria();
$landsCriteria->join = "inner join obj_users_lands uu2 on uu2.lands_id = t.lands_id AND uu2.deleted is null AND uu2.uid = :uid
";
$landsCriteria->params = [
  ':uid' => $model->uid,
];
$landsDataProvider = $lands->search($landsCriteria, 100);
/** @var Lands $firstLand */
if (isset($landsDataProvider->data[0])) {
    $firstLand = $landsDataProvider->data[0];
} else {
    $firstLand = null;
}

/** @var Devices $devices */
$devices = new Devices('search');
$devices->unsetAttributes();
$devicesCriteria = new CDbCriteria();
$devicesCriteria->join = "inner join obj_lands_devices uu2 on uu2.devices_id = t.devices_id AND 
uu2.lands_id in (select uu3.lands_id from obj_users_lands uu3 where uu3.uid = :uid and uu3.deleted is null) 
and uu2.deleted is null
";
$devicesCriteria->params = [
  ':uid' => $model->uid,
];
$devicesDataProvider = $devices->search($devicesCriteria, 100);
/** @var Devices $firstDevice */
if (isset($devicesDataProvider->data[0])) {
    $firstDevice = $devicesDataProvider->data[0];
} else {
    $firstDevice = null;
}
?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Профиль') ?>: <?= $model->fullname . ' (ID:' . $model->uid . ')'; ?>
  </h1>
</section>
<!-- Main content -->
<section class="content" id="user-update-content-section-<?= $model->uid ?>">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-default" id="box-for-user-data-<?= $model->uid ?>">
        <div class="box-header with-border">
          <h3 class="box-title">Ваши персональные данные</h3> <? //data-widget="collapse"?>
            <? /*<div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                    </div> */ ?>
        </div>
          <?php
          /** @var TbActiveForm $form */
          $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'users-profile-update-form-' . $model->uid,
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => ["profile/update"],
              'type'                   => 'horizontal',
              'htmlOptions'            => [
                'onsubmit' => "return false;",
                  /* Disable normal form submit */
                  //'onkeypress'=>" if(event.keyCode == 13){ update_users (); } " /* Do ajax call when user presses enter key */
              ],
            ]
          ); ?>
        <!-- /.box-header -->
        <div class="box-body">
            <?php echo $form->errorSummary($model, 'Необходимо исправить следующие проблемы:'); ?>
          <div class="row">
            <div class="col-md-6 col-sm-12">
                <?php echo $form->uneditableRow(
                  $model,
                  'uid',
                  ['id' => 'Users_uid_profile_update_' . $model->uid]
                ); ?>
                <?php $model->created = Utils::pgDateToStr($model->created);
                echo $form->uneditableRow(
                  $model,
                  'created',
                  ['id' => 'Users_created_profile_update_' . $model->uid]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'fullname',
                  ['id' => 'Users_fullname_profile_update_' . $model->uid]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'new_password',
                  ['id' => 'Users_new_password_profile_update_' . $model->uid]
                ); ?>
                <?php
                $model->new_email = $model->email;
                echo $form->textFieldRow(
                  $model,
                  'new_email',
                  [
                    'id'             => 'Users_new_email_profile_update_' . $model->uid,
                    'data-inputmask' => "'mask': /^\S*@?\S*$/",
                    'data-mask'      => null,
                  ]
                ); ?>
                <?php echo $form->textFieldRow(
                  $model,
                  'phone',
                  [
                    'id'             => 'Users_phone_profile_update_' . $model->uid,
                    'data-inputmask' => "'mask': '89999999999'",
                    'data-mask'      => null,
                  ]
                ); ?>
                <?php echo $form->textAreaRow(
                  $model,
                  'contacts',
                  ['id' => 'Users_contacts_profile_update_' . $model->uid]
                ); ?>
            </div>
            <div class="col-md-6 col-sm-12">
                <?php echo $form->textAreaRow(
                  $model,
                  'comments',
                  ['id' => 'Users_comments_profile_update_' . $model->uid]
                ); ?>
                <? // select2 test ?>
              <div class="form-group<?= ($model->hasErrors('lands') ? ' has-error' : '') ?>">
                <label class="col-sm-3 control-label"
                       for="Users_lands_profile_update_<?= $model->uid ?>">Участки</label>
                <div class="col-sm-9">
                  <select id="Users_lands_profile_update_<?= $model->uid ?>"
                          class="form-control select2 select2-hidden-accessible"
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
                                    value="<?= $land['lands_id'] ?>"<?= $selected ?>>
                                <?= addslashes($land['land_group'] . '/№' . $land['land_number']) ?>
                            </option>
                          <? }
                      } ?>
                  </select>
                </div>
              </div>
                <? if (Yii::app()->user->notInRole(['superAdmin', 'topManager'])) {
                    $htmlOptions = ['disabled' => 'disabled', 'readonly' => 'readonly'];
                } else {
                    $htmlOptions = [];
                }
                $htmlOptions['id'] = 'Users_status_profile_update_' . $model->uid;
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
                $htmlOptions['id'] = 'Users_role_profile_update_' . $model->uid;
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
                $htmlOptions['id'] = 'Users_default_manager_profile_update_' . $model->uid;
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
                <?php echo $form->checkboxRow(
                  $model,
                  'checked',
                  ['id' => 'Users_status_profile_update_' . $model->uid]
                ); ?>
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
                  //'size'       => 'mini',
                'icon'       => 'fa fa-rotate-left',
                'label'      => Yii::t('main', 'Сброс'),
                  //'htmlOptions' => array('class' => 'pull-right'),
              ]
            ); ?>
            <?php
            $onClickUrl = Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/profile/update');
            $this->widget(
              'booster.widgets.TbButton',
              [
                'buttonType'  => 'button',
                'type'        => 'default',
                  //'size'        => 'mini',
                'icon'        => 'fa fa-check',
                'label'       => Yii::t('main', 'Сохранить'),
                'htmlOptions' => [
                  'class'   => 'pull-right',
                  'onclick' =>
                  /** @lang JavaScript */ "(function () {
        var data = $('#users-profile-update-form-{$model->uid}').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '{$onClickUrl}',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    //$('#users-update-modal').modal('hide');
                    //$('#users-update-modal').data('modal', null);
                    //$.fn.yiiGridView.update('users-grid', {});
                    reloadSelectedTab(event);
                    alert(data);                  
                }

            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data),'Error',true);

            },

            dataType: 'html'
        });})();",
                ],
              ]
            );
            ?>
        </div>
          <?php $this->endWidget(); ?>
      </div>
    </div>
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
<script>
    $('#Users_lands_profile_update_<?=$model->uid?>').select2(
        {
            allowClear: true,
            placeholder: 'Клик для выбора участков',
            templateSelection: function (state) {
                if (!state.id) {
                    return state.text.trim(); // optgroup
                } else {
                    return state.text.trim() +
                        '&nbsp;<a href="/<?=Yii::app(
                        )->controller->module->id?>/lands/view/id/' + state.id + '" title="Просмотр профиля участка" onclick="getContent(this,\'' +
                        state.text.trim() +
                        '\',false);return false;"><i class="fa fa-external-link fa-fw text-white"></i></a>';
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            }
        }
    );
</script>
<? /*
<script type="text/javascript" src="<?= Yii::app(
)->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard.js' : 'dashboard.js' ?>"></script>
<script type="text/javascript" src="<?= Yii::app(
)->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard2.js' : 'dashboard2.js' ?>"></script>
*/ ?>
