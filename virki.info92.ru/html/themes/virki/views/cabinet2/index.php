<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 * Главная страница кабинета
 * http://<domain.ru>/ru/cabinet
 * var $user = - данные о пользователе
 * var $ordersByStatuses = array - заказы по статусам
 * (0 => array(
 * 'id' => '21'
 * 'value' => 'IN_PROCESS'
 * 'name' => 'В процессе обработки'
 * 'descr' => 'Статус по умолчанию для всех новых заказов. Присваивается автоматически.'
 * 'manual' => '1'
 * 'aplyment_criteria' => 'select oo.id from orders oo where oo.status in (\'PAUSED\')
 * and (uid=:uid or :uid is null) and (manager=:manager or :manager is null)'
 * 'auto_criteria' => ''
 * 'order_in_process' => '0'
 * 'enabled' => '1'
 * 'count' => '36'
 * 'lastdate' => '1402398695'
 * 'totalsum' => '12920.15'
 * 'totalpayed' => '11056.76'
 * 'totalnopayed' => '-1863.39'
 * ))
 **********************************************************************************************************************/
?>
<section class="servicesDetails">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-title">
          <h2><a href="/"><?= Yii::t('main', 'Главная') ?></a> / <?= Yii::t('main', 'Добро пожаловать') ?>
            , <?= Yii::app()->user->fullname ?>
            <a href="<?= Yii::app()->createUrl('/cabinet/profile') ?>" class="edit-link"
               title="<?= Yii::t('main', 'Настроить профиль') ?>">
              <span class="pull-right"><i class="fa fa-sliders fa-2x color1"></i></span>
            </a>
          </h2>
        </div>
      </div>
    </div>
    <div class="row"><!-- row -->
        <? // Блок меню кабинета ?>
      <div class="col-lg-3 col-sm-4 col-xs-12">
          <? // Виджет меню кабинета
          $this->widget('application.components.widgets.cabinetMenuBlock'); ?>
      </div><!-- /col-->
      <div class="col-lg-9 col-sm-8 col-xs-12 main-column box-block">
        <div class="tab-content">
          <div class="alert alert-info">
            <span><?= Yii::t('main', 'Настройе параметры своего профиля') ?></span>
          </div>
        </div>
      </div> <!--/col-->
    </div><!-- /row -->
  </div><!-- /container-->
</section>
