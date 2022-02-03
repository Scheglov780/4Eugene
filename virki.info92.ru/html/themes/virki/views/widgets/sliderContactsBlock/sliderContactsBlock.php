<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="sliderBlock.php">
 * </description>
 * Виджет отображает слайдер баннеров на главной
 * $banners - массив моделей banners
 **********************************************************************************************************************/
?>
<div class="tp-caption sfb text-right"
     data-x="right"
     data-y="top"
     data-hoffset="0"
     data-voffset="0"
     data-speed="2000"
     data-start="3000"
     data-easing="Power4.easeOut">
  <div class="revCon">
    <section class="headerMiddle">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-sm-10 col-xs-10">
            <div class="logo">
              <a href="/">
                <img src="<?= $this->frontThemePath ?>/images/logo.png"
                     alt="СНТ Вирки-2, Ленинградская область, Всеволжский район">
              </a>
            </div>
          </div>
          <div class="col-lg-9 col-sm-2 col-xs-2">
            <div class="headMiddInfo">
              <div class="hidden-sm hidden-xs hidden-md">
                <div class="singMiddInfo phone">
                  <i class="fa fa-phone"></i>
                  <h4><?= Yii::t('main', 'ТЕЛЕФОН') ?></h4>
                  <p><?= cms::customContent('kd:phone') ?></p>
                </div>
                <div class="singMiddInfo email">
                  <i class="fa fa-envelope-o"></i>
                  <h4>EMAIL</h4>
                  <a href="mailto:<?= cms::customContent(
                    'kd:email',
                    true,
                    true,
                    false,
                    false
                  ) ?>"><?= cms::customContent('kd:email') ?></a>
                </div>
                <div class="singMiddInfo time">
                  <i class="fa fa-clock-o"></i>
                  <h4><?= Yii::t('main', 'ВРЕМЯ РАБОТЫ') ?></h4>
                  <p><?= cms::customContent('kd:timeToWork') ?></p>
                </div>
                <div class="headMiddBtn pull-right">
                    <? $this->widget(
                      'application.components.widgets.SendMessageBlock',
                      [
                        'label' => Yii::t('main', 'Написать письмо'),
                      ]
                    ); ?>
                </div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
          <div class="col-sm-12 col-xs-12 hidden-lg tabtopInfo">
            <div class="singMiddInfo phone">
              <i class="fa fa-phone"></i>
              <h4><?= Yii::t('main', 'ТЕЛЕФОН') ?></h4>
              <p><?= cms::customContent('kd:phone') ?></p>
            </div>
            <div class="singMiddInfo email">
              <i class="fa fa-envelope-o"></i>
              <h4>EMAIL</h4>
              <a href="mailto:<?= cms::customContent(
                'kd:email',
                true,
                true,
                false,
                false
              ) ?>"><?= cms::customContent('kd:email') ?></a>
            </div>
            <div class="singMiddInfo time">
              <i class="fa fa-clock-o"></i>
              <h4><?= Yii::t('main', 'ВРЕМЯ РАБОТЫ') ?></h4>
              <p><?= cms::customContent('kd:timeToWork') ?></p>
            </div>
            <div class="headMiddBtn pull-left">
                <? $this->widget(
                  'application.components.widgets.SendMessageBlock',
                  [
                    'label' => Yii::t('main', 'Написать письмо'),
                  ]
                ); ?>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>