<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="password.php">
 * </description>
 **********************************************************************************************************************/
?>
<? /*
<div class="blue-tabs">
    <a href="<?= Yii::app()->createUrl('/cabinet/profile') ?>">
        <span><?= Yii::t('main', 'Личные данные') ?></span>
    </a>
    <a href="<?= Yii::app()->createUrl('/cabinet/profile/email') ?>">
        <span><?= Yii::t('main', 'Изменить E-mail') ?></span>
    </a>

    <div class="active-tab">
        <span><?= $this->pageTitle ?></span>
    </div>
    <a href="<?= Yii::app()->createUrl('/cabinet/profile/address') ?>">
        <span><?= Yii::t('main', 'Список адресов') ?></span>
    </a>
</div>
*/ ?>
<? /*
<div class="cabinet-content">
    <div class="form">
        <?= $form ?>
    </div>
</div>
*/ ?>
<section class="servicesDetails">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-title">
          <h2><?= $this->pageTitle ?></h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
        <div class="cabinet-content">
          <div class="form-group">

            <form method="post" action="<?= Yii::app()->createUrl('/cabinet/profile/password') ?>">

              <div class="row">
                <label class="required" for="CabinetForm_password"><?= Yii::t(
                      'main',
                      'Текущий пароль'
                    ) ?>
                  <span class="sss">*</span></label>
                <input type="password" id="CabinetForm_password" name="CabinetForm[password]"
                       maxlength="128" value="" class="input3 form-control"/>

              </div>
              <div class="row clearfix f-space10"></div>
              <div class="row field_new_password">
                <label class="required" for="CabinetForm_new_password"><?= Yii::t(
                      'main',
                      'Новый пароль'
                    ) ?>
                  <span
                      class="sss">*</span></label>
                <input type="password" name="CabinetForm[new_password]" maxlength="128" value=""
                       class="input3 form-control"/>

              </div>
              <div class="row clearfix f-space10"></div>
              <div class="row field_new_password2">
                <label class="required" for="CabinetForm_new_password2"><?= Yii::t(
                      'main',
                      'Повторите новый пароль'
                    ) ?> <span
                      class="sss">*</span></label>
                <input type="password" name="CabinetForm[new_password2]" maxlength="128" value=""
                       class="input3 form-control"/>

              </div>
              <div class="row clearfix f-space10"></div>
              <div class="row buttons">
                <button type="submit" name="submit" class="btn pull-right color2"
                        style="position: relative; padding: 10px; top:10px;">
                    <?= Yii::t('main', 'Сохранить') ?>
                </button>
              </div>

            </form>

              <? /*
                    <?= new CForm(array(
                    'elements' => array(
                    'password'      => array(
                    'type'      => 'password',
                    'maxlength' => 128,
                    ),
                    'new_password'  => array(
                    'type'      => 'password',
                    'maxlength' => 128,
                    ),
                    'new_password2' => array(
                    'type'      => 'password',
                    'maxlength' => 128,
                    ),
                    ),
                    'buttons'  => array(
                    'submit' => array(
                    'type'  => 'submit',
                    'label' => Yii::t('main', 'Сохранить'),
                    'class' => 'blue-btn bigger'
                    ),
                    ), ), $model
                    );
                    ?>
*/ ?>

          </div>
        </div>
      </div><!--End:Col-->
    </div><!--End:Row-->
  </div><!--End:Container-->
</section>