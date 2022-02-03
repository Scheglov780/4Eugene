<!--Slider Start-->
<section class="sliderSection">
  <div class="container-fluid">
    <div class="row">
      <div class="tp-banner">
          <? $this->widget('application.components.widgets.sliderBlock') ?>
      </div>
    </div>
  </div>
</section>
<!--Slider End-->
<!--Header Middle Start-->
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
      <div class="col-lg-9">
        <div class="row">
          <div class="col-lg-4 singMiddInfo phone">
            <a href="tel:<?= cms::customContent(
              'kd:phone',
              true,
              true,
              false,
              false
            ) ?>"><i class="fa fa-phone"></i>
              <h4><?= Yii::t('main', 'ТЕЛЕФОН') ?></h4>
              <p><?= cms::customContent('kd:phone') ?></p></a>
          </div>
          <div class="col-lg-4 singMiddInfo email">
            <a href="mailto:<?= cms::customContent(
              'kd:email',
              true,
              true,
              false,
              false
            ) ?>"><i class="fa fa-envelope-o"></i>
              <h4>EMAIL</h4>
              <p><?= cms::customContent('kd:email') ?></p></a>
          </div>
          <div class="col-lg-4 singMiddInfo map">
            <a href="<?= cms::customContent(
              'kd:maplink',
              true,
              true,
              false,
              false
            ) ?>" target="_blank" title="Посмотреть на карте"><i class="fa fa-map"></i>
              <h4><?= Yii::t('main', 'КАРТА') ?></h4>
              <p>посмотреть на карте</p></a>
          </div>
            <? /*
                    <div class="col-lg-4 singMiddInfo time">
                        <i class="fa fa-clock-o"></i>
                        <h4><?= Yii::t('main', 'ВРЕМЯ РАБОТЫ') ?></h4>
                        <p><?= cms::customContent('kd:timeToWork') ?></p>
                    </div>
                    */ ?>
        </div>
      </div>
        <? /*
            <div class="col-lg-9 col-sm-2 col-xs-2">
                <div class="headMiddInfo">
                    <div class="hidden-sm hidden-md hidden-xs">
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
                        <div class="singMiddInfo map">
                            <i class="fa fa-map"></i>
                            <h4><?= Yii::t('main', 'КАРТА') ?></h4>
                            <p><?= cms::customContent('kd:map-way') ?></p>
                        </div>
                        <div class="singMiddInfo time">
                            <i class="fa fa-clock-o"></i>
                            <h4><?= Yii::t('main', 'ВРЕМЯ РАБОТЫ') ?></h4>
                            <p><?= cms::customContent('kd:timeToWork') ?></p>
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
                <div class="singMiddInfo map">
                    <i class="fa fa-map"></i>
                    <h4><?= Yii::t('main', 'КАРТА') ?></h4>
                    <p><?= cms::customContent('kd:map-way') ?></p>
                </div>
                <div class="singMiddInfo time">
                    <i class="fa fa-clock-o"></i>
                    <h4><?= Yii::t('main', 'ВРЕМЯ РАБОТЫ') ?></h4>
                    <p><?= cms::customContent('kd:timeToWork') ?></p>
                </div>
            </div>
            */ ?>
    </div>
  </div>
</section>
<!--Header Middle End-->