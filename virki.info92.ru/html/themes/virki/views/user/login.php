<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="login.php">
 * </description>
 **********************************************************************************************************************/
?>
<!--Blog start-->
<section class="blogSection">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="commentTitle"><?= Yii::t('main', 'Войдите, или зарегистрируйтесь') ?></h2>
        <div class="commentForm">
          <form action="/user/login" method="post" id="loginForm">
            <div class="row">
              <div class="col-lg-12 formmargin">
                  <?
                  $loginByPhone = (boolean) DSConfig::getVal('login_use_phone_as_login');
                  if (!$loginByPhone) {
                      ?>
                    <input type="email" value="" placeholder="<?= Yii::t('main', 'Введите e-mail') ?>"
                           class="required" name="UserForm[email]">
                  <? } else { ?>
                    <input type="text" value=""
                           placeholder="<?= Yii::t('main', 'Введите телефон или e-mail') ?>"
                           class="required" name="UserForm[email]">
                  <? } ?>
                <input type="password" value="" placeholder="<?= Yii::t('main', 'Введите пароль') ?>"
                       class="required"
                       name="UserForm[password]">
                <section style="display: none">
                  <label class="checkbox" for="checkboxRememberMe">
                                                                        <span
                                                                          <? //class="text-center" style="top: 6px;position: relative;" ?>
                                                                        ><?= Yii::t('main', 'Запомнить меня') ?></span>
                  </label>
                  <input type="checkbox" value="1" checked id="checkboxRememberMe" data-toggle="checkbox"
                    <? //class="pull-left" style="margin-left: 10px;top:100px;" ?>
                         name="UserForm[rememberMe]">
                </section>
              </div>
              <div class="col-lg-12">
                <button class="btn blogReadmore danvitBtn pull-right"
                        name="UserForm[doGo]" onclick="$('#loginForm').submit();"><?= Yii::t(
                      'main',
                      'Войти'
                    ) ?></button>
                <a href="<?= $this->createUrl('/user/password') ?>"><?= Yii::t(
                      'main',
                      'Забыли пароль?'
                    ) ?></a>
                <a href="<?= $this->createUrl('/user/register') ?>"><?= Yii::t(
                      'main',
                      'Зарегистрируйтесь!'
                    ) ?></a>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Blog End-->
