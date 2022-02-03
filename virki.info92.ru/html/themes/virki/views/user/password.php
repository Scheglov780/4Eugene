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
<!--Blog start-->
<section class="blogSection">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="commentTitle"><?= $this->pageTitle ?></h2>
        <div class="commentForm">
          <form action="/user/password" method="post" id="passwordForm">
            <div class="row">
              <div class="col-lg-12 formmargin">
                  <?
                  $loginByPhone = (boolean) DSConfig::getVal('login_use_phone_as_login');
                  if (!$loginByPhone) {
                      ?>
                    <p><?= Yii::t('main', 'Для восстановления пароля введите ваш EMail') ?></p>
                    <input type="email" value="" placeholder="<?= Yii::t('main', 'Введите e-mail') ?>"
                           class="required" name="UserForm[email]">
                  <? } else { ?>
                    <p><?= Yii::t(
                          'main',
                          'Для восстановления пароля введите ваш EMail или телефон'
                        ) ?></p>
                    <input type="text" value=""
                           placeholder="<?= Yii::t('main', 'Введите телефон или e-mail') ?>"
                           class="required" name="UserForm[email]">
                  <? } ?>
              </div>
              <div class="col-lg-12">
                <button class="btn blogReadmore pull-right"
                        name="UserForm[doGo]" onclick="$('#passwordForm').submit();"><?= Yii::t(
                      'main',
                      'Далее'
                    ) ?>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
<!--Blog End-->