<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="email.php">
 * </description>
 **********************************************************************************************************************/
?>
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
      <div class="col-lg-3 col-sm-4 col-xs-12">
          <? // Виджет меню кабинета
          $this->widget('application.components.widgets.cabinetMenuBlock'); ?>
      </div><!--/col-->
      <div class="col-lg-9 col-sm-8 col-xs-12">
        <div class="tab-content">
          <div class="alert alert-info"><?= Yii::t('main', 'Текущий E-mail') ?>: <?= $user->email ?></div>
          <div class="form-group">
            <div class="row profile">
              <form method="post" action="<?= Yii::app()->createUrl('/cabinet/profile/email') ?>">
                <div class="row">
                  <div class="col-md-4">
                    <label class="required" for="CabinetForm_email"><?= Yii::t(
                          'main',
                          'Новый E-mail'
                        ) ?> <span class="required">*</span></label>
                  </div>
                  <div class="col-md-8">
                    <input class="input3 form-control" type="text" name="CabinetForm[email]"
                           maxlength="128"
                           value="<?= $model->email; ?>"/>
                  </div>
                </div>
                <div class="row clearfix f-space10"></div>
                <div class="row">
                  <div class="col-md-4">
                    <label class="required" for="CabinetForm_password"><?= Yii::t(
                          'main',
                          'Текущий пароль'
                        ) ?> <span class="sss">*</span></label>
                  </div>
                  <div class="col-md-8">
                    <input class="input3 form-control" type="password"
                           name="CabinetForm[password]"
                           maxlength="128"
                           value=""/>
                  </div>
                </div>
                <div class="row clearfix f-space10"></div>
                <div class="row">
                  <div class="col-md-12">
                    <button type="submit" name="submit" class="btn color2 pull-right"
                            style="position: relative; top: 15px; padding: 10px;"><?= Yii::t(
                          'main',
                          'Сохранить'
                        ) ?></button>
                  </div>
                </div>

              </form>
            </div><!--End:Row-->
              <? /*
                    <?= new CForm(array(
                      'elements' => array(
                        'email'    => array(
                          'type'      => 'text',
                          'maxlength' => 128,
                        ),
                        'password' => array(
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
                      ),
                      ), $model
                    );
                    ?>
*/ ?>
          </div>
        </div>
      </div><!--End:Col-->

    </div><!--End:Row-->
  </div><!--End:Container-->
</section>