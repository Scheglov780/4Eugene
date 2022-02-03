<? $module = Yii::app()->controller->module->id; ?>

<ul class="sidebar-menu" data-widget="tree">
  <li class="header"><?= Yii::t('main', 'ГЛАВНОЕ МЕНЮ') ?></li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/questions/index')) { ?>
      <li><?= AdminUtils::adminMenu(
            'questions',
            '/' . Yii::app()->controller->module->id . '/questions',
            Yii::t('main', 'Диспетчерская'),
            Yii::t('main', 'Вопросы клиентов'),
            'fa-question-circle',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/structure/index')) { ?>
      <li><?= AdminUtils::adminMenu(
            'structure',
            '/' . Yii::app()->controller->module->id . '/structure',
            Yii::t('main', 'Структура объектов'),
            Yii::t('main', 'Общий вид, обзор всех объектов, их связи и зависимости...'),
            'fa-cubes',
            false
          ) ?></li>
    <? } ?>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main','Списки абонентов, контактных данных, объектов собственности, адресов и т.п.') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-address-book-o"></i>
      <span><?= Yii::t('main', 'Реестр') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/users/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'users',
                '/' . Yii::app()->controller->module->id . '/users',
                Yii::t('main', 'Пользователи'),
                Yii::t('main', 'Управление пользователями, история операций, счета'),
                'fa-users',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/lands/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'lands',
                '/' . Yii::app()->controller->module->id . '/lands',
                Yii::t('main', 'Участки'),
                Yii::t('main', 'Управление участками, кадастр, площадь, локация и т.п.'),
                'fa-fort-awesome',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
  <li class="treeview">
    <a href="#"
      <? /* title = "<?= Yii::t('main', 'Учет расхода элетроэнергии, приборы учета, показания, тарифы...') ?>"
            data - toggle = "tooltip"
            data - placement = "right" */ ?>
    >
      <i class="fa fa-dashboard"></i>
      <span><?= Yii::t('main', 'АСКУ(Э)') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/devices/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'devices',
                '/' . Yii::app()->controller->module->id . '/devices',
                Yii::t('main', 'Устройства'),
                Yii::t('main', 'Управление приборами учёта и контроля'),
                'fa-podcast',
                false
              ) ?></li>
          <li><?= AdminUtils::adminMenu(
                'manageReadings',
                '/' . Yii::app()->controller->module->id . '/devices/manageReadings',
                Yii::t('main', 'Управление показаниями'),
                Yii::t('main', 'Быстрое внесение и изменение показаний приборов учёта'),
                'fa-check',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main', 'Взносы, сборы, счета, платежи...') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-rub"></i>
      <span><?= Yii::t('main', 'Финансы') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/tariffs/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'tariffs',
                '/' . Yii::app()->controller->module->id . '/tariffs',
                Yii::t('main', 'Тарифы'),
                Yii::t('main', 'Управление тарифами'),
                'fa-calculator',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/tariffsAcceptors/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'tariffsAcceptors',
                '/' . Yii::app()->controller->module->id . '/tariffsAcceptors',
                Yii::t('main', 'Получатели платежей'),
                Yii::t('main', 'реквизиты получателей платежей...'),
                'fa-bank',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/bills/dashboard')) { ?>
          <li><?= AdminUtils::adminMenu(
                'bills',
                '/' . Yii::app()->controller->module->id . '/bills/dashboard',
                Yii::t('main', 'Счета к оплате'),
                Yii::t('main', 'Просмотр выставленных счетов и их оплаты...'),
                'fa-trash',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/payments/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'userPayments',
                '/' . Yii::app()->controller->module->id . '/payments',
                Yii::t('main', 'Платежи'),
                Yii::t('main', 'Просмотр платежей, зачисление и списание средств...'),
                'fa-cc-visa',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main', 'Новости, объявления, рассылки...') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-bell"></i>
      <span><?= Yii::t('main', 'Оповещение') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/news/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'news',
                '/' . Yii::app()->controller->module->id . '/news',
                Yii::t('main', 'Новости и объявления'),
                Yii::t('main', 'Новости от администрации и объявления абонентов'),
                'fa-newspaper-o',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess('@sendMailToAll')) { ?>
          <li>
            <a href="#" onclick="$('#new-internal-email-to-all').modal('show');return false;"
               title="<?= Yii::t('main', 'Отправка почтового сообщения всем пользователям') ?>">
              <i class="fa fa-envelope"></i> <span><?= Yii::t('main', 'Рассылка') ?></span>
            </a>
          </li>
        <? } ?>
    </ul>
  </li>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main', 'Опросы и голосования...') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-balance-scale"></i>
      <span><?= Yii::t('main', 'Обратная связь') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/votings/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'votings',
                '/' . Yii::app()->controller->module->id . '/votings',
                Yii::t('main', 'Голосования и опросы'),
                Yii::t(
                  'main',
                  'Неформальные опросы мнения абонентов по любым произвольным вопросам, легитимные голосования по ФЗ'
                ),
                'fa-hand-paper-o',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/documents/index')) { ?>
      <li><?= AdminUtils::adminMenu(
            'documents',
            '/' . Yii::app()->controller->module->id . '/documents',
            Yii::t('main', 'Документы'),
            Yii::t('main', 'Документация, база знаний'),
            'fa-file-word-o',
            false
          ) ?></li>
    <? } ?>
  <li class="header"><?= Yii::t('main', 'САЙТ') ?></li>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main', 'Настройки страниц, ссылок, баннеров, текстов...') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-th"></i>
      <span><?= Yii::t('main', 'Контент') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsMenus/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-menus',
                '/' . Yii::app()->controller->module->id . '/cmsMenus',
                Yii::t('main', 'CMS: меню'),
                Yii::t('main', 'Управление меню фронта сайта'),
                'fa-th-list',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsPages/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-pages',
                '/' . Yii::app()->controller->module->id . '/cmsPages',
                Yii::t('main', 'CMS: страницы'),
                Yii::t('main', 'Управление страницами фронта сайта'),
                'fa-list-alt',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsPagesContent/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-pages-content',
                '/' . Yii::app()->controller->module->id . '/cmsPagesContent',
                Yii::t('main', 'CMS: контент страниц'),
                Yii::t('main', 'Управление контентом страниц фронта сайта'),
                'fa-indent',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsCustomContent/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-custom-content',
                '/' . Yii::app()->controller->module->id . '/cmsCustomContent',
                Yii::t('main', 'CMS: контент блоков'),
                Yii::t('main', 'Управление контентом блоков фронта сайта'),
                'fa-th-large',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/banrules/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'banrules',
                '/' . Yii::app()->controller->module->id . '/banrules',
                Yii::t('main', 'CMS: фильтр URL'),
                Yii::t('main', 'Правила обработки перенаправления URL'),
                'fa-lock',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsEmailEvents/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'cms-email-contents',
                '/' . Yii::app()->controller->module->id . '/cmsEmailEvents',
                Yii::t('main', 'CMS: Оповещения'),
                Yii::t('main', 'Правила обработки оповещений, событий и рассылок'),
                'fa-mail-reply-all',
                false
              ) ?></li>
        <? } ?>
        <? if (DSConfig::getVal('blogs_enabled')) { ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/blogs/index')) { ?>
            <li><?= AdminUtils::adminMenu(
                  'blogs',
                  '/' . Yii::app()->controller->module->id . '/blogs',
                  Yii::t('main', 'Блоги'),
                  Yii::t('main', 'Управление блогами'),
                  'fa-commenting',
                  false
                ) ?></li>
            <? } ?>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/banners/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'appearance',
                '/' . Yii::app()->controller->module->id . '/banners',
                Yii::t('main', 'Баннеры'),
                Yii::t('main', 'Управление баннерами на главной странице сайта'),
                'fa-film',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/translation/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'translation',
                '/' . Yii::app()->controller->module->id . '/translation',
                Yii::t('main', 'Перевод интерфейса'),
                Yii::t('main', 'Корректировка автоматического перевода интерфейса'),
                'fa-language',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/imagelib/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'imagelib',
                '/' . Yii::app()->controller->module->id . '/imagelib',
                Yii::t('main', 'Библиотека картинок'),
                Yii::t('main', 'Управление библиотекой стандартных изображений'),
                'fa-file-image-o',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/ModuleNews/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'ModuleNews',
                '/' . Yii::app()->controller->module->id . '/ModuleNews',
                Yii::t('main', 'Внутренние новости'),
                Yii::t('main', 'Управление внутренними новостями и объявлениями'),
                'fa-newspaper-o',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main', 'Настройки платежных систем, формул, событий...') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-wrench"></i>
      <span><?= Yii::t('main', 'Настройки') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/paysystems/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'paySystems',
                '/' . Yii::app()->controller->module->id . '/paysystems',
                Yii::t('main', 'Платёжные системы'),
                Yii::t('main', 'Настройки параметров платёжных систем'),
                'fa-money',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/dicCustom/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'dicCustom',
                '/' . Yii::app()->controller->module->id . '/dicCustom',
                Yii::t('main', 'Константы'),
                Yii::t('main', 'Общий справочник предопределенных значений полей и параметров'),
                'fa-dot-circle-o',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/formulas/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'formulas',
                '/' . Yii::app()->controller->module->id . '/formulas/index',
                Yii::t('main', 'Формулы'),
                Yii::t('main', 'Формулы ценообразования, расчета прибыли, бонусов и т.п.'),
                'fa-balance-scale',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/events/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'events',
                '/' . Yii::app()->controller->module->id . '/events/index',
                Yii::t('main', 'Обработка событий'),
                Yii::t('main', 'Настройки обработки событий'),
                'fa-bell-o',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? //================================================================== ?>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t('main', 'Настройки сайта') ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-gears"></i>
      <span><?= Yii::t('main', 'Система') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? /* if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cache/index')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'cache-control',
                      '/'.Yii::app()->controller->module->id.'/cache',
                      Yii::t('main', 'Управление кешем'),
                      Yii::t('main', 'Контроль и очистка внутреннего кэша'),
                      false,
                      false
                    ) ?></li>
            <? } */ ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/config/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'parameterAll',
                '/' . Yii::app()->controller->module->id . '/config/index',
                Yii::t('main', 'Параметры'),
                Yii::t('main', 'Настройки технических параметров системы'),
                'fa-gear',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/accessrights/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'accessrights',
                '/' . Yii::app()->controller->module->id . '/accessrights/index',
                Yii::t('main', 'Права доступа'),
                Yii::t('main', 'Управление правами доступа'),
                'fa-key',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/translatorkeys/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'parameterBing',
                '/' . Yii::app()->controller->module->id . '/translatorkeys',
                Yii::t('main', 'Ключи переводчика'),
                Yii::t('main', 'Настройка ключей переводчика'),
                'fa-globe',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/sitestat/index')) { ?>
      <li><?= AdminUtils::adminMenu(
            'site-stat',
            '/' . Yii::app()->controller->module->id . '/sitestat',
            Yii::t('main', 'Статистика'),
            Yii::t('main', 'Статистика работы сайта'),
            'fa-signal',
            false
          ) ?></a></li>
    <? } ?>
  <li class="header"><?= Yii::t('main', 'ИСТОРИЯ ВКЛАДОК') ?></li>
    <?
    /** @var CustomAdminController $this */
    $this->renderPartial('menu_history_block');
    ?>
</ul>
<? /* Original */ ?>
<? /*
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active"><a href="index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
            <li><a href="index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-files-o"></i>
            <span>Layout Options</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right">4</span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i> Top Navigation</a></li>
            <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i> Boxed</a></li>
            <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i> Fixed</a></li>
            <li><a href="pages/layout/collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/widgets.html">
            <i class="fa fa-th"></i> <span>Widgets</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">new</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-pie-chart"></i>
            <span>Charts</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i> ChartJS</a></li>
            <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i> Morris</a></li>
            <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i> Flot</a></li>
            <li><a href="pages/charts/inline.html"><i class="fa fa-circle-o"></i> Inline charts</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>UI Elements</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i> General</a></li>
            <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i> Icons</a></li>
            <li><a href="pages/UI/buttons.html"><i class="fa fa-circle-o"></i> Buttons</a></li>
            <li><a href="pages/UI/sliders.html"><i class="fa fa-circle-o"></i> Sliders</a></li>
            <li><a href="pages/UI/timeline.html"><i class="fa fa-circle-o"></i> Timeline</a></li>
            <li><a href="pages/UI/modals.html"><i class="fa fa-circle-o"></i> Modals</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>Forms</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i> General Elements</a></li>
            <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i> Advanced Elements</a></li>
            <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i> Editors</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span>Tables</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i> Simple tables</a></li>
            <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i> Data tables</a></li>
          </ul>
        </li>
        <li>
          <a href="pages/calendar.html">
            <i class="fa fa-calendar"></i> <span>Calendar</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red">3</small>
              <small class="label pull-right bg-blue">17</small>
            </span>
          </a>
        </li>
        <li>
          <a href="pages/mailbox/mailbox.html">
            <i class="fa fa-envelope"></i> <span>Mailbox</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-yellow">12</small>
              <small class="label pull-right bg-green">16</small>
              <small class="label pull-right bg-red">5</small>
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Examples</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pages/examples/invoice.html"><i class="fa fa-circle-o"></i> Invoice</a></li>
            <li><a href="pages/examples/profile.html"><i class="fa fa-circle-o"></i> Profile</a></li>
            <li><a href="pages/examples/login.html"><i class="fa fa-circle-o"></i> Login</a></li>
            <li><a href="pages/examples/register.html"><i class="fa fa-circle-o"></i> Register</a></li>
            <li><a href="pages/examples/lockscreen.html"><i class="fa fa-circle-o"></i> Lockscreen</a></li>
            <li><a href="pages/examples/404.html"><i class="fa fa-circle-o"></i> 404 Error</a></li>
            <li><a href="pages/examples/500.html"><i class="fa fa-circle-o"></i> 500 Error</a></li>
            <li><a href="pages/examples/blank.html"><i class="fa fa-circle-o"></i> Blank Page</a></li>
            <li><a href="pages/examples/pace.html"><i class="fa fa-circle-o"></i> Pace Page</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li class="treeview">
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li class="treeview">
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
        <li><a href="https://adminlte.io/docs"><i class="fa fa-book"></i> <span>Documentation</span></a></li>
        <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
*/ ?>
