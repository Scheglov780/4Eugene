<ul class="accordion">
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/search/index')) { ?>
      <li class="menu-point"><?= AdminUtils::adminMenu(
            'admin_search',
            '/admin/search/index',
            Yii::t('main', 'Поиск...'),
            Yii::t('main', 'Общий поиск заказов, пользователей, лотов...'),
            'fa fa-search',
            false
          ) ?></li>
    <? } ?>
    <? /* if (Yii::app()->user->checkAccess('admin/orders/dashboard')) { ?>
        <li class="menu-point"><?= AdminUtils::adminMenu(
              'orders_dashboard',
              '/admin/orders/dashboard',
              Yii::t('main', 'Заказы'),
              Yii::t('main', 'Обзор заказов'),
              'fa fa-shopping-cart',
              false
            ) ?></li>
    <? } */ ?>
    <? /* if (Yii::app()->user->checkAccess('admin/ordersItems/dashboard')) { ?>
        <li class="menu-point"><?= AdminUtils::adminMenu(
              'ordersItems_dashboard',
              '/admin/ordersItems/dashboard',
              Yii::t('main', 'Лоты'),
              Yii::t('main', 'Обзор лотов'),
              'fa fa-inbox',
              false
            ) ?></li>
    <? } */ ?>
    <? /* if (Yii::app()->user->checkAccess('admin/warehouse/income')) { ?>
        <li class="menu-point" id="warehouse" title="<?= Yii::t('main', 'Приёмка, размещение товаров на складе') ?>">
            <a href="javascript:void(0);"><i class="fa fa-fixed-width fa fa-th-large"></i> <?= Yii::t('main', 'Склад') ?>
            </a>
            <ul class="accordion-warehouse">
                <? if (Yii::app()->user->checkAccess('admin/warehousePlaceItem/index')) { ?>
                    <li><?= AdminUtils::adminMenu(
                          'warehouse-income',
                          '/admin/warehousePlaceItem/index/command/income',
                          Yii::t('main', 'Склад: приход'),
                          Yii::t('main', 'Приход товаров на склад'),
                          false,
                          false
                        ) ?></li>
                <? } ?>
                <? if (Yii::app()->user->checkAccess('/admin/warehousePlaceItem/index')) { ?>
                    <li><?= AdminUtils::adminMenu(
                          'warehouse-expenditure',
                          '/admin/warehousePlaceItem/index/command/expenditure',
                          Yii::t('main', 'Склад: расход'),
                          Yii::t('main', 'Комплектация посылок и расход со склада'),
                          false,
                          false
                        ) ?></li>
                <? } ?>
                <? if (Yii::app()->user->checkAccess('admin/warehouse/map')) { ?>
                    <li><?= AdminUtils::adminMenu(
                          'warehouse-map',
                          '/admin/warehouse/map',
                          Yii::t('main', 'Склад: управление'),
                          Yii::t('main', 'Управление складом и размещением лотов'),
                          false,
                          false
                        ) ?></li>
                <? } ?>
                <? if (Yii::app()->user->checkAccess('/admin/warehousePlaceItem/index')) { ?>
                    <li><?= AdminUtils::adminMenu(
                          'warehouse-history',
                          '/admin/warehousePlaceItem/index/command/history',
                          Yii::t('main', 'Склад: история'),
                          Yii::t('main', 'История движений по складу'),
                          false,
                          false
                        ) ?></li>
                <? } ?>
            </ul>
        </li>
    <? } */ ?>
    <? //=================================================================================================== ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/questions/index')) { ?>
      <li class="menu-point"><?= AdminUtils::adminMenu(
            'questions',
            '/admin/questions',
            Yii::t('main', 'Вопросы'),
            Yii::t('main', 'Вопросы клиентов'),
            'fa fa-question-circle',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->inRole(['superAdmin', 'topManager'])) { ?>
      <li class="menu-point"><?= AdminUtils::adminMenu(
            'operators',
            '/admin/operators/list',
            Yii::t('main', 'Менеджеры'),
            Yii::t('main', 'Просмотр распределения заказов по менеджерам'),
            'fa fa-user-md',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/users/index')) { ?>
      <li class="menu-point"><?= AdminUtils::adminMenu(
            'users',
            '/admin/users',
            Yii::t('main', 'Пользователи'),
            Yii::t('main', 'Управление пользователями, история операций, счета'),
            'fa fa-user',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/payments/index')) { ?>
      <li class="menu-point"><?= AdminUtils::adminMenu(
            'userPayments',
            '/admin/payments',
            Yii::t('main', 'Платежи'),
            Yii::t('main', 'Просмотр платежей пользователей'),
            'fa fa-credit-card',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess('@sendMailToAll')) { ?>
      <li class="menu-point"><a href="#" onclick="$('#new-internal-email-to-all').dialog('open');return false;"
                                title="<?= Yii::t('main', 'Отправка почтового сообщения всем пользователям') ?>">
          <i class="fa fa-fixed-width fa fa-envelope-o"></i><?= Yii::t('main', 'Рассылка') ?>
        </a>
      </li>
    <? } ?>
    <? if (DSConfig::getVal('blogs_enabled')) { ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/blogs/index')) { ?>
        <li class="menu-point"><?= AdminUtils::adminMenu(
              'blogs',
              '/admin/blogs',
              Yii::t('main', 'Блоги'),
              Yii::t('main', 'Управление блогами'),
              'fa fa-comments-o',
              false
            ) ?></li>
        <? } ?>
    <? } ?>
  <li class="menu-point" id="contents" title="<?= Yii::t('main', 'Настройки категорий, баннеров, текстов...') ?>">
    <a href="javascript:void(0);"><i class="fa fa-fixed-width fa fa-list"></i><?= Yii::t('main', 'Контент') ?></a>
    <ul class="accordion-orders">
        <? /* if (Yii::app()->user->checkAccess('admin/menu/index')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'menu-control',
                      '/admin/menu',
                      Yii::t('main', 'Категории'),
                      Yii::t('main', 'Управление виртуальными категориями, которые отображаются на сайте в каталоге'),
                      false,
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess('admin/brands/index')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'brands',
                      '/admin/brands',
                      Yii::t('main', 'Бренды'),
                      Yii::t('main', 'Управление брендами, которые отображаются на сайте'),
                      false,
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess('admin/featured/index')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'recomendations',
                      '/admin/featured',
                      Yii::t('main', 'Рекомендованное'),
                      Yii::t('main', 'Управление рекомендованными товарами, отображаемыми на главной странице сайта'),
                      false,
                      false
                    ) ?></li>
            <? } */ ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsMenus/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-menus',
                '/admin/cmsMenus',
                Yii::t('main', 'CMS: меню'),
                Yii::t('main', 'Управление меню фронта сайта'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsPages/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-pages',
                '/admin/cmsPages',
                Yii::t('main', 'CMS: страницы'),
                Yii::t('main', 'Управление страницами фронта сайта'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsPagesContent/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-pages-content',
                '/admin/cmsPagesContent',
                Yii::t('main', 'CMS: контент страниц'),
                Yii::t('main', 'Управление контентом страниц фронта сайта'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsPages/dataLoading')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-pages',
                '/admin/cmsPages/dataLoading',
                Yii::t('main', 'CMS: загрузка данных'),
                Yii::t('main', 'Загрузка внешних данных из папки [theme]/aritcle в таблицу cms_loaded'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsCustomContent/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'static-pages-custom-content',
                '/admin/cmsCustomContent',
                Yii::t('main', 'CMS: контент блоков'),
                Yii::t('main', 'Управление контентом блоков фронта сайта'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/banrules/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'banrules',
                '/admin/banrules',
                Yii::t('main', 'CMS: фильтр URL'),
                Yii::t('main', 'Правила обработки перенаправления URL'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cmsEmailEvents/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'cms-email-contents',
                '/admin/cmsEmailEvents',
                Yii::t('main', 'CMS: Оповещения'),
                Yii::t('main', 'Правила обработки оповещений, событий и рассылок'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/banners/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'appearance',
                '/admin/banners',
                Yii::t('main', 'Баннеры'),
                Yii::t('main', 'Управление баннерами на главной странице сайта'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/translation/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'translation',
                '/admin/translation',
                Yii::t('main', 'Перевод интерфейса'),
                Yii::t('main', 'Корректировка автоматического перевода интерфейса'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/imagelib/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'imagelib',
                '/admin/imagelib',
                Yii::t('main', 'Библиотека картинок'),
                Yii::t('main', 'Управление библиотекой стандартных изображений'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/ModuleNews/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'ModuleNews',
                '/admin/ModuleNews',
                Yii::t('main', 'Внутренние новости'),
                Yii::t('main', 'Управление внутренними новостями и объявлениями'),
                false,
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? /* if (DSConfig::getVal('local_shop_mode') !== 'off') { ?>
        <? if (Yii::app()->user->checkAccess('admin/shop')) { ?>
            <li class="menu-point" id="shop"
                title="<?= Yii::t('main', 'Локальные товары, товары пользователей...') ?>">
                <a href="javascript:void(0);"><i class="fa fa-fixed-width fa fa-qrcode"></i><?= Yii::t('main',
                      'Витрины'
                    ) ?></a>
                <ul class="accordion-orders">
                    <? if (Yii::app()->user->checkAccess('admin/shop/index')) { ?>
                        <li><?= AdminUtils::adminMenu(
                              'shop-control',
                              '/admin/shop/index',
                              Yii::t('main', 'Товары'),
                              Yii::t('main', 'Управление товарами, которые отображаются на витрине'),
                              false,
                              false
                            ) ?></li>
                    <? } ?>
                    <? if (Yii::app()->user->checkAccess('admin/shop/addItem')) { ?>
                        <li><?= AdminUtils::adminMenu(
                              'shop-addItem',
                              '/admin/shop/addItem',
                              Yii::t('main', 'Новый товар'),
                              Yii::t('main', 'Добавление нового товара'),
                              false,
                              false
                            ) ?></li>
                    <? } ?>
                </ul>
            </li>
        <? } ?>
    <? } */ ?>
    <? /* if (Yii::app()->user->checkAccess('admin/source/index')) { ?>
        <li class="menu-point"><?= AdminUtils::adminMenu(
              'source',
              '/admin/source',
              Yii::t('main', 'Источники'),
              Yii::t('main', 'Источники данных о товарах, поисковых категориях и т.п.'),
              'fa fa-fixed-width fa fa-download',
              false
            ) ?></li>
    <? } */ ?>
  <li class="menu-point" id="settings" title="<?= Yii::t('main', 'Настройки тарифов, скидок, наценок...') ?>">
    <a href="javascript:void(0);"><i class="fa fa-fixed-width fa fa-wrench"></i><?= Yii::t('main', 'Настройки') ?>
    </a>
    <ul class="accordion-orders">
        <? /* if (Yii::app()->user->checkAccess('admin/config/prices')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'prices',
                      '/admin/config/prices',
                      Yii::t('main', 'Ценообразование'),
                      Yii::t('main', 'Тарифы, наценки, скидки'),
                      false,
                      false
                    ) ?></li>
            <? } */ ?>
        <? /* if (Yii::app()->user->checkAccess('admin/deliveries')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'deliveries',
                      '/admin/deliveries',
                      Yii::t('main', 'Доставка'),
                      Yii::t('main', 'Настройки служб доставки и расценок на доставку'),
                      false,
                      false
                    ) ?></li>
            <? } */ ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/paysystems/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'paySystems',
                '/admin/paysystems',
                Yii::t('main', 'Платёжные системы'),
                Yii::t('main', 'Настройки параметров платёжных систем')
              ) ?></li>
        <? } ?>
        <? /* if (Yii::app()->user->checkAccess('admin/ordersStatuses/index')) { ?>
                <li><?= AdminUtils::adminMenu(
                      'ordersStatuses',
                      '/admin/ordersStatuses/index',
                      Yii::t('main', 'Статусы заказов'),
                      Yii::t('main', 'Настройки статусов заказов и их поведений'),
                      false,
                      false
                    ) ?></li>
            <? } */ ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/formulas/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'formulas',
                '/admin/formulas/index',
                Yii::t('main', 'Формулы'),
                Yii::t('main', 'Формулы ценообразования, расчета прибыли, бонусов и т.п.'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/events/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'events',
                '/admin/events/index',
                Yii::t('main', 'Обработка событий'),
                Yii::t('main', 'Настройки обработки событий'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/reportsSystem/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'mail-events',
                '/admin/reportsSystem',
                Yii::t('main', 'Настройка отчётов'),
                Yii::t('main', 'Управление отчётами и аналитикой'),
                false,
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
  <li class="menu-point" id="site-settings" title="<?= Yii::t('main', 'Настройки сайта') ?>">
    <a href="javascript:void(0);"><i class="fa fa-fixed-width fa fa-gears"></i><?= Yii::t('main', 'Система') ?></a>
    <ul class="accordion-orders">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/cache/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'cache-control',
                '/admin/cache',
                Yii::t('main', 'Управление кешем'),
                Yii::t('main', 'Контроль и очистка внутреннего кэша'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/config/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'parameterAll',
                '/admin/config/index',
                Yii::t('main', 'Параметры'),
                Yii::t('main', 'Настройки технических параметров системы'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/accessrights/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'accessrights',
                '/admin/accessrights/index',
                Yii::t('main', 'Права доступа'),
                Yii::t('main', 'Управление правами доступа'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/translatorkeys/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'parameterBing',
                '/admin/translatorkeys',
                Yii::t('main', 'Менеджер ключей переводчика'),
                Yii::t('main', 'Настройка ключей переводчика'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/utilites')) { ?>
          <li><?= AdminUtils::adminMenu(
                'service-utils',
                '/admin/utilites/index',
                Yii::t('main', 'Сброс'),
                Yii::t('main', 'Сброс параметров системы, сервис при изменении версий'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/errorlog/index')) { ?>
          <li><?= AdminUtils::adminMenu(
                'errorlog',
                '/admin/errorlog',
                Yii::t('main', 'Лог ошибок'),
                Yii::t('main', 'Лог обработанных ошибок сайта'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/fileman/view')) { ?>
          <li><?= AdminUtils::adminMenu(
                'fileman',
                '/admin/fileman/view',
                Yii::t('main', 'Менеджер файлов'),
                Yii::t('main', 'Управление файлами изображений иисходного кода'),
                false,
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess('dbadmin')) { ?>
          <!-- target="_blank" -->
          <li id="db-control" title="<?= Yii::t('main', 'Внешний менеджер управления СУБД') ?>"><a
                href="#"
                onclick="window.open('/dbadmin/login.php?USER=<?= Yii::app()->db->username ?>&PASS=<?= Yii::app(
                )->db->password ?>&DATABASE=<?= preg_replace(
                  '/^.*dbname=(.*?)(?:;.*|$)/is',
                  '\1',
                  Yii::app()->db->connectionString
                ) ?>',
                    '<?= Yii::t('main', 'Управление СУБД') ?>');"><?= Yii::t(
                    'main',
                    'Управление СУБД'
                  ) ?></a>
          </li>
          <li><?= AdminUtils::adminMenu(
                'serverstatus',
                '/server-status',
                Yii::t('main', 'Нагрузка веб-сервера'),
                Yii::t('main', 'Нагрузка и статистика веб-сервера'),
                false,
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/sitestat/index')) { ?>
      <li class="menu-point"><?= AdminUtils::adminMenu(
            'site-stat',
            '/admin/sitestat',
            Yii::t('main', 'Статистика'),
            Yii::t('main', 'Статистика работы сайта'),
            'fa fa-bar-chart',
            false
          ) ?></a></li>
    <? } ?>
</ul>
