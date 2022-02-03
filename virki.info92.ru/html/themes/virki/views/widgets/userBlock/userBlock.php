<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="userBlock.php">
 * </description>
 * Рендеринг блока пользователя в лэйауте
 * var $guest = false
 * var $user = 'Root'
 **********************************************************************************************************************/
?>
<? /* <li><a href="<?= $this->createUrl('/knowledgebase') ?>">База знаний</a></li> */ ?>
<? if ($guest) { ?>
  <li>
    <a href="<?= Yii::app()->createUrl('/user/register') ?>">
      <i class="fa fa-sign-in fa-fw"></i><?= Yii::t('main', 'Регистрация') ?>
    </a>
  </li>
  <li>
    <a href="<?= Yii::app()->createUrl('/user/login') ?>">
      <i class="fa fa-key fa-fw"></i><?= Yii::t('main', 'Войти') ?>
    </a>
  </li>
    <?
} else {
    ?>
  <li>
    <a href="<?= Yii::app()->createUrl('/cabinet') ?>">
      <i class="fa fa-user fa-fw"></i>Кабинет <?= $user ?>
    </a>
  </li>
    <? if (Yii::app()->user->checkAccess('admin/main/*')) { ?>
    <li><a href="<?= Yii::app()->createUrl('/admin/main') ?>"><i class="fa fa-gear fa-fw"></i><?= Yii::t(
              'main',
              'Панель управления'
            ) ?></a>
    </li>
    <? } ?>
  <li>
    <a href="<?= Yii::app()->createUrl('/user/logout') ?>">
      <i class="fa fa-sign-out fa-fw"></i><?= Yii::t('main', 'Выйти') ?>
    </a>
  </li>
<? } ?>