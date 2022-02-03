<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="cabinetMenuBlock.php">
 * </description>
 * Виджет отображает левое вертикальное меню кабинета
 * newAnswer = 3 - количество новых обращений
 **********************************************************************************************************************/
?>
<? $action = Yii::app()->request->requestUri ?>
<div class="box-content">
  <div class="panel-group" id="cabinetcategories">
    <div class="panel panel-default">
        <? $opened = preg_match('/(?:\/cabinet$|\/mailevents)/isu', $action) ?>
      <div
          class="panel-heading <?= ($opened ? 'opened' : 'closed') ?>" data-parent="#cabinetcategories"
          data-toggle="collapse" data-target="#collapseOne">
        <h4 class="panel-title">
          <a href="javascript:void(0);">
            <span class="fa <?= ($opened ? 'fa-arrow-down' : 'fa-arrow-right') ?>"></span>
              <?= Yii::t('main', 'Личный кабинет') ?>
          </a>
        </h4>
      </div>
      <div class="panel-collapse collapse<?= ($opened ? ' in' : '') ?>" id="collapseOne">
        <div class="panel-body">
          <ul class="servicesNav">
            <li class="item"><a href="<?= Yii::app()->createUrl('/cabinet') ?>"><?= Yii::t(
                      'main',
                      'Общая информация'
                    ) ?></a>
            </li>
            <li class="item">
              <a href="<?= Yii::app()->createUrl('/cabinet/profile/mailevents') ?>">
                  <?= Yii::t('main', 'E-mail оповещения') ?></a>
            </li>

              <? if (Yii::app()->user->checkAccess('admin/main/*')) { ?>
                <li class="item"><a href="<?= Yii::app()->createUrl(
                      '/' . Yii::app()->controller->module->id . '/main'
                    ) ?>"><?= Yii::t(
                          'main',
                          'Панель управления'
                        ) ?></a>
                </li>
              <? } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
        <? $opened = preg_match('/profile\/(?:index|email|password|address)/isu', $action); ?>
      <div
          class="panel-heading <?= ($opened ? 'opened' : 'closed') ?>" data-parent="#cabinetcategories"
          data-target="#collapseFive" data-toggle="collapse">
        <h4 class="panel-title">
          <a href="javascript:void(0);">
            <span class="fa <?= ($opened ? 'fa-arrow-down' : 'fa-arrow-right') ?>"></span>
              <?= Yii::t('main', 'Профиль') ?>
          </a>
        </h4>
      </div>
      <div class="panel-collapse collapse<?= ($opened ? ' in' : '') ?>" id="collapseFive">
        <div class="panel-body">
          <ul class="servicesNav">
            <li class="item"><a href="<?= Yii::app()->createUrl('/cabinet/profile/index') ?>">
                    <?= Yii::t('main', 'Личные данные') ?></a>
            </li>
            <li class="item"><a href="<?= Yii::app()->createUrl('/cabinet/profile/email') ?>">
                    <?= Yii::t('main', 'Изменить E-mail') ?></a>
            </li>
            <li class="item"><a href="<?= Yii::app()->createUrl('/cabinet/profile/password') ?>">
                    <?= Yii::t('main', 'Изменить пароль') ?></a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
