<!--Header Top Start-->
<section id="headersGroup">
    <?
    $mobile = new Mobile_Detect();
    if (!$mobile->isMobile()) {
        ?>
      <section class="headerTop">
        <div class="container">
          <div class="row hidden-xs">
            <div class="col-lg-7 col-md-7 col-sm-8 col-xs-8">
              <p>
                  <?= cms::customContent('kd:topTitle') ?>
              </p>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-4">
              <div class="Top pull-right">
                  <? $lang_array = explode(',', DSConfig::getVal('site_language_block')); ?>
                  <? if (count($lang_array) > 1) { ?>
                    <div class="topSec countryFlug">
                      <a class="currentFlg dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                         href="#">
                        <i class="flag flag-16 flag-<?= Utils::langToCountry(
                          Yii::app()->language
                        ) ?>"></i>
                          <?= Utils::langToLangName(Yii::app()->language) ?>
                        <i class="fa fa-angle-down fa-fw"></i>
                      </a>
                        <? //TODO: если язык один - не показывать ?>
                      <ul class="flagList dropdown-menu" role="menu">
                          <? // Блок выбора языка отображения фронта?>
                          <? $this->widget('application.components.widgets.languageBlock'); ?>
                      </ul>
                    </div>
                  <? } ?>
                <div class="topSec socialLink">
                    <?= cms::customContent('kd:headerSocial') ?>
                    <? /* <div class="clearfix"></div> */ ?>
                </div>
                  <? /*
                    <div class="topSec singin">
                        <a class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"
                           href="<?= Yii::app()->createUrl('/cabinet') ?>">
                            <i class="fa fa-user"></i>
                            <span class="hidden-xs"><?= Yii::t('main', 'Кабинет') ?></span>
                        </a>
                        <ul class="dropdown-menu cabinet" role="menu">
                            <? // Блок логина, входа в кабинет?>
                            <? $this->widget('application.components.widgets.userBlock'); ?>
                        </ul>
                    </div>
                    */ ?>
              </div>
            </div>
          </div>
        </div>
      </section>
    <? } ?>
  <!--Header Top End-->
  <!--Header Start-->
  <header class="header" id="siteHeader" data-spy="affix" data-offset-top="50">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <nav class="mainnav">
            <div class="logoMobile hidden-lg"> <? /* hidden-sm hidden-xs */ ?>
              <a href="/">
                <img alt="На главную" src="<?= $this->frontThemePath ?>/images/logo2.png">
              </a>
            </div>
            <div class="mobileMenu">
              <span></span>
              <span></span>
              <span></span>
            </div>
            <ul class="fa-ul">
                <?
                /*
+Главная
-- О нас
+Медиа article/media
*Блоги
*Форум
*Галерея
+Экология article/eco
+Инфо
+Новости /news
?Объявления /notices
+Жильцам
Голосования /votings
Опросы(?) /polls
?Должники /promisors
Сервис /services
Мониторинг
Видеонаблюдение
Безопасность
Статистика
Документы
#База знаний /knowledgebase
#Отчетность /accounting
Контакты
+Кабинет
Профиль
Объекты и трекинг(?)
Пропуска
Услуги
Показания
Счета
История расходов
Лента событий
Обращения
Тревога!
                 */
                ?>
              <li class="<?= (Yii::app()->controller->id == 'site' ? ' active' : '') ?>">
                <i class="fa fa-li fa-home hidden-lg"></i><a href="/"><?= Yii::t('main', 'Главная') ?></a>
              </li>
              <li class="<?= ((Yii::app()->controller->id == 'article' &&
                isset($_REQUEST['url']) &&
                $_REQUEST['url'] == 'media') ? 'active' : '') ?>">
                <i class="fa fa-li fa-camera hidden-lg"></i>
                <a href="<?= $this->createUrl('/article/index', ['url' => 'media']) ?>">
                    <?= Yii::t('main', 'Медиа') ?></a></li>
              <li class="<?= ((Yii::app()->controller->id == 'article' &&
                isset($_REQUEST['url']) &&
                $_REQUEST['url'] == 'eco') ? ' active' : '') ?>">
                <i class="fa fa-li fa-leaf hidden-lg"></i>
                <a href="<?= $this->createUrl('/article/index', ['url' => 'eco']) ?>">
                    <?= Yii::t('main', 'Экология') ?></a></li>
                <? /*
                        <li class="<?=((Yii::app()->controller->id=='article' && isset($_REQUEST['url']) && $_REQUEST['url'] == 'services')?'active':'')?>"><a href="<?= $this->createUrl(
                              '/article/index',
                              array('url' => 'services')
                            ) ?>"><?= Yii::t('main', 'Услуги') ?></a>
                        </li>
                        <li><a href="/#ourProjectsLink"><?= Yii::t('main', 'Наши работы') ?></a>
                        </li>
                        <li><a href="/#allProjectsLink"><?= Yii::t('main', 'Каталог проектов') ?></a>
                        </li>
                        <? if (DSConfig::getVal('blogs_enabled')) {?>
                        <li class="<?=(Yii::app()->controller->id=='blog'?'active':'')?>"><a href="<?= $this->createUrl('/blog/index') ?>"><?= Yii::t('main',
                                  'Блог'
                                ) ?></a>
                        </li>
                        <? } ?>
                        */ ?>
              <li class="has-menu-items <?= (in_array(
                Yii::app()->controller->id,
                ['news', 'adverts']
              ) ? ' active' : '') ?>">
                <i class="fa fa-li fa-info hidden-lg"></i>
                <a href="#">
                    <?= Yii::t('main', 'Инфо') ?></a>
                <ul class="sub-menu">
                  <li><a href="<?= $this->createUrl('/news') ?>">Новости</a></li>
                  <li><a href="<?= $this->createUrl('/adverts') ?>">Объявления</a></li>
                    <? $pages = Yii::app()->db->cache(YII_DEBUG ? 0 : 600)->createCommand(
                      "select pp.url, pc.title from cms_pages pp, cms_pages_content pc
                                              where pp.page_id = pc.page_id and pp.enabled = 1
                                              and (pc.lang = '*' or pc.lang = :lang)
                                              and pp.page_group = 'МенюИнфо'
                                              -- and pp.order_in_level>=0
                                              order by abs(pp.order_in_level)"
                    )
                      ->queryAll(true, [':lang' => Yii::app()->language]);
                    if ($pages) { ?>
                      <li role="separator" class="divider"></li>
                        <? foreach ($pages as $page) { ?>
                        <li><a href="<?= $this->createUrl(
                              '/article/' . $page['url']
                            ) ?>"><?= $page['title'] ?></a></li>
                        <? }
                    } ?>
                </ul>
              </li>
              <li class="has-menu-items <?= (in_array(
                Yii::app()->controller->id,
                ['votings', 'polls', 'services']
              ) ? ' active' : '') ?>">
                <i class="fa fa-li fa-group hidden-lg"></i>
                <a href="#">
                    <?= Yii::t('main', 'Жильцам') ?></a>
                <ul class="sub-menu">
                  <li><a href="<?= $this->createUrl('/votings') ?>">Голосования</a></li>
                  <li><a href="<?= $this->createUrl('/polls') ?>">Опросы</a></li>
                    <? /* <li><a href="<?= $this->createUrl('/promisors') ?>">Должники</a></li> */ ?>
                  <li><a href="<?= $this->createUrl('/services') ?>">Инфраструктура</a></li>
                </ul>
              </li>
              <li class="has-menu-items <?= (in_array(
                Yii::app()->controller->id,
                ['blanks', 'accounting']
              ) ? ' active' : '') ?>">
                <i class="fa fa-li fa-files-o hidden-lg"></i>
                <a href="#">
                    <?= Yii::t('main', 'Документы') ?></a>
                <ul class="sub-menu">
                  <li><a href="<?= $this->createUrl('/blanks') ?>">Полезные файлы</a></li>
                  <li><a href="<?= $this->createUrl('/accounting') ?>">Отчётность</a></li>
                    <? $pages = Yii::app()->db->cache(YII_DEBUG ? 0 : 600)->createCommand(
                      "select pp.url, pc.title from cms_pages pp, cms_pages_content pc
                                              where pp.page_id = pc.page_id and pp.enabled = 1
                                              and (pc.lang = '*' or pc.lang = :lang)
                                              and pp.page_group = 'МенюДокументы'
                                              -- and pp.order_in_level>=0
                                              order by abs(pp.order_in_level)"
                    )
                      ->queryAll(true, [':lang' => Yii::app()->language]);
                    if ($pages) { ?>
                        <? //<li role="separator" class="divider"></li>?>
                        <? foreach ($pages as $page) { ?>
                        <li><a href="<?= $this->createUrl(
                              '/article/' . $page['url']
                            ) ?>"><?= $page['title'] ?></a></li>
                        <? }
                    } ?>
                </ul>
              </li>
              <li class="<?= ((Yii::app()->controller->id == 'article' &&
                isset($_REQUEST['url']) &&
                $_REQUEST['url'] == 'contacts') ? ' active' : '') ?>">
                <i class="fa fa-li fa-envelope-open hidden-lg"></i>
                <a href="<?= $this->createUrl(
                  '/article/index',
                  ['url' => 'contacts']
                ) ?>">
                    <?= Yii::t('main', 'Контакты') ?></a></li>
              <li class="has-menu-items">
                <i class="fa fa-li fa-briefcase hidden-lg"></i>
                <a href="<?= Yii::app()->createUrl('/cabinet') ?>">
                    <?= Yii::t('main', 'Кабинет') ?></a>
                <ul class="sub-menu">
                    <? // Блок логина, входа в кабинет?>
                    <? $this->widget('application.components.widgets.userBlock'); ?>
                </ul>
              </li>
            </ul>
          </nav>
        </div>
        <div class="col-lg-3">
            <? $this->widget('application.components.widgets.SearchQueryBlock'); ?>
        </div>
      </div>
    </div>
  </header>
  <!--Header End-->
</section>