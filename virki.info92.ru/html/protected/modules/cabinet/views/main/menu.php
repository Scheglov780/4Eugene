<? $module = Yii::app()->controller->module->id;
/** @var Users $UserData */
$userData = Users::model()->findByPkEx(Yii::app()->user->id);
?>

<ul class="sidebar-menu" data-widget="tree">
  <li class="header"><?= Yii::t('main', 'НАВИГАЦИЯ') ?></li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/questions/index')) { ?>
      <li><?= CabinetUtils::adminMenu(
            'questions',
            '/' . Yii::app()->controller->module->id . '/questions',
            Yii::t('main', 'Диспетчерская'),
            Yii::t('main', 'Ваши обращения в управляющую компанию'),
            'fa-question-circle',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/news/index')) { ?>
      <li><?= CabinetUtils::adminMenu(
            'news',
            '/' . Yii::app()->controller->module->id . '/news',
            Yii::t('main', 'Новости'),
            Yii::t('main', 'Новости от УК и Правления'),
            'fa-bell',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/adverts/index')) { ?>
      <li><?= CabinetUtils::adminMenu(
            'adverts',
            '/' . Yii::app()->controller->module->id . '/adverts',
            Yii::t('main', 'Объявления'),
            Yii::t('main', 'Объявления от УК, Правления и частные объявления'),
            'fa-thumb-tack',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/votings/index')) { ?>
      <li><?= CabinetUtils::adminMenu(
            'votings',
            '/' . Yii::app()->controller->module->id . '/votings',
            Yii::t('main', 'Голосования'),
            Yii::t('main', 'Официальные голосования по ФЗ'),
            'fa-hand-paper-o',
            false
          ) ?></li>
    <? } ?>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/pools/index')) { ?>
      <li><?= CabinetUtils::adminMenu(
            'pools',
            '/' . Yii::app()->controller->module->id . '/pools',
            Yii::t('main', 'Опросы'),
            Yii::t('main', 'Опросы от УК и Правления, частные опросы'),
            'fa-pencil-square-o',
            false
          ) ?></li>
    <? } ?>
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
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/bills/dashboard')) { ?>
          <li><?= CabinetUtils::adminMenu(
                'bills',
                '/' . Yii::app()->controller->module->id . '/bills/dashboard',
                Yii::t('main', 'Счета к оплате'),
                Yii::t('main', 'Просмотр выставленных счетов и их оплаты...'),
                'fa-trash',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/payments/index')) { ?>
          <li><?= CabinetUtils::adminMenu(
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
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/profile/view') ||
      Yii::app()->user->isGuest) { ?>
      <li><?= CabinetUtils::adminMenu(
            'profile',
            '/' . Yii::app()->controller->module->id . '/profile/view',
            Yii::t('main', 'Профиль'),
            Yii::t('main', 'Управление Вашим профилем, персональными и контактными данными'),
            'fa-user-secret',
            false
          ) ?></li>
    <? } ?>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t(
           'main',
           'Управление участками, кадастр, площадь, локация и т.п.'
         ) ?>"
         data-toggle="tooltip"
         data-placement="right" */ ?>
    >
      <i class="fa fa-fort-awesome"></i>
      <span><?= Yii::t('main', 'Участки') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? $userLands = json_decode($userData->lands);
        if ($userLands && is_array($userLands) && count($userLands)) {
            ?>
            <? /** @var Lands $userLand */
            foreach ($userLands as $userLand) {
                if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/lands/update')) { ?>
                  <li><?= CabinetUtils::adminMenu(
                        'lands-' . $userLand->lands_id,
                        Yii::app()->createAbsoluteUrl(
                          Yii::app()->controller->module->id . '/lands/view',
                          ['id' => $userLand->lands_id]
                        ),
                        $userLand->land_group . '/№' . $userLand->land_number,
                        Yii::t('main', 'Статус участка'),
                        'fa-adjust',
                        false
                      ) ?></li>
                <? }
            } ?>
        <? } else { ?>
          <li><?= CabinetUtils::adminMenu(
                'lands-not-found',
                '#',
                Yii::t('main', 'не зарегистрировано'),
                Yii::t('main', 'Для регистрации участков обращайтесь в УК и Правление'),
                'fa-adjust',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t(
           'main',
           'Управление приборами учёта и контроля'
         ) ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-podcast"></i>
      <span><?= Yii::t('main', 'Приборы учёта') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? $userDevices = json_decode($userData->devices);
        if ($userDevices && is_array($userDevices) && count($userDevices)) {
            ?>
            <? /** @var Devices $userDevice */
            foreach ($userDevices as $userDevice) {
                if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/devices/update')) { ?>
                  <li><?= CabinetUtils::adminMenu(
                        'devices-' . $userDevice->devices_id,
                        Yii::app()->createAbsoluteUrl(
                          Yii::app()->controller->module->id . '/devices/view',
                          ['id' => $userDevice->devices_id]
                        ),
                        $userDevice->source . ' / ' . ($userDevice->name ?? $userDevice->devices_id),
                        Yii::t('main', 'Статус прибора учёта'),
                        'fa-adjust',
                        false
                      ) ?></li>
                <? }
            } ?>
        <? } else { ?>
          <li><?= CabinetUtils::adminMenu(
                'devices-not-found',
                '#',
                Yii::t('main', 'не зарегистрировано'),
                Yii::t('main', 'Для регистрации приборов учёта обращайтесь в УК и Правление'),
                'fa-adjust',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/stat/index')) { ?>
      <li><?= CabinetUtils::adminMenu(
            'stat',
            '/' . Yii::app()->controller->module->id . '/stat',
            Yii::t('main', 'Статистика'),
            Yii::t('main', 'Статистика потребления ресурсов, платежей и т.п.'),
            'fa-signal',
            false
          ) ?></a></li>
    <? } ?>
  <li class="treeview">
    <a href="#"
      <? /* title="<?= Yii::t(
           'main',
           'Справочник членов СНТ, адреса, телефоны, участки, карта и т.п.'
         ) ?>"
            data-toggle="tooltip"
            data-placement="right" */ ?>
    >
      <i class="fa fa-info"></i>
      <span><?= Yii::t('main', 'Справочник') ?></span>
      <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
    </a>
    <ul class="treeview-menu">
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/info/index')) { ?>
          <li><?= CabinetUtils::adminMenu(
                'info',
                '/' . Yii::app()->controller->module->id . '/info',
                Yii::t('main', 'Адреса, контакты'),
                Yii::t('main', 'Справочник адресов и контактов членов СНТ'),
                'fa-phone',
                false
              ) ?></li>
        <? } ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id . '/map/index')) { ?>
          <li><?= CabinetUtils::adminMenu(
                'map',
                '/' . Yii::app()->controller->module->id . '/map',
                Yii::t('main', 'Карта'),
                Yii::t('main', 'Карта участков СНТ с поиском, кадастровыми данными и т.п.'),
                'fa-map-marker',
                false
              ) ?></li>
        <? } ?>
    </ul>
  </li>
    <? /* if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/services/index')) { ?>
        <li><?= CabinetUtils::adminMenu(
              'services',
              '/'.Yii::app()->controller->module->id.'/services',
              Yii::t('main', 'Услуги'),
              Yii::t('main', 'Управление дополнительными услугами'),
              'fa-calculator',
              false
            ) ?></li>
    <? } */ ?>
    <? /* if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/documents/index')) { ?>
        <li><?= CabinetUtils::adminMenu(
              'documents',
              '/'.Yii::app()->controller->module->id.'/documents',
              Yii::t('main', 'Документы'),
              Yii::t('main', 'Общая документация, формы бланков, отчетность и т.п.'),
              'fa-file-word-o',
              false
            ) ?></li>
    <? } */ ?>

    <? /*  if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/structure/index')) { ?>
        <li><?= CabinetUtils::adminMenu(
              'structure',
              '/'.Yii::app()->controller->module->id.'/structure',
              Yii::t('main', 'Структура объектов'),
              Yii::t('main', 'Общий вид, обзор всех объектов, их связи и зависимости...'),
              'fa-cubes',
              false
            ) ?></li>
    <? } ?>
    <li class="treeview">
        <a href="#" title="<?= Yii::t('main',
          'Списки абонентов, контактных данных, объектов собственности, адресов и т.п.'
        ) ?>"
         data-toggle="tooltip"
        data-placement="right"
 >
            <i class="fa fa-address-book-o"></i>
            <span><?= Yii::t('main', 'Реестр') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/users/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'users',
                      '/'.Yii::app()->controller->module->id.'/users',
                      Yii::t('main', 'Пользователи'),
                      Yii::t('main', 'Управление пользователями, история операций, счета'),
                      'fa-users',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/lands/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'lands',
                      '/'.Yii::app()->controller->module->id.'/lands',
                      Yii::t('main', 'Участки'),
                      Yii::t('main', 'Управление участками, кадастр, площадь, локация и т.п.'),
                      'fa-fort-awesome',
                      false
                    ) ?></li>
            <? } ?>
        </ul>
    </li>
    <li class="treeview">
        <a href="#" title="<?= Yii::t('main', 'Учет расхода элетроэнергии, приборы учета, показания, тарифы...') ?>"
         data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-dashboard"></i>
            <span><?= Yii::t('main', 'АСКУ(Э)') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/devices/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'devices',
                      '/'.Yii::app()->controller->module->id.'/devices',
                      Yii::t('main', 'Устройства'),
                      Yii::t('main', 'Управление приборами учёта и контроля'),
                      'fa-podcast',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/tariffs/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'tariffs',
                      '/'.Yii::app()->controller->module->id.'/tariffs',
                      Yii::t('main', 'Тарифы'),
                      Yii::t('main', 'Управление тарифами'),
                      'fa-calculator',
                      false
                    ) ?></li>
            <? } ?>
        </ul>
    </li>
    <li class="treeview">
        <a href="#" title="<?= Yii::t('main', 'Взносы, сборы, счета, платежи...') ?>"
         data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-rub"></i>
            <span><?= Yii::t('main', 'Финансы') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/fees/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'fees',
                      '/'.Yii::app()->controller->module->id.'/fees',
                      Yii::t('main', 'Взносы и сборы'),
                      Yii::t('main', 'Управление регулярными и единовременными взносами и сборами средств...'),
                      'fa-money',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/bills/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'bills',
                      '/'.Yii::app()->controller->module->id.'/bills',
                      Yii::t('main', 'Счета к оплате'),
                      Yii::t('main', 'Просмотр выставленных счетов и их оплаты...'),
                      'fa-trash',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/payments/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'userPayments',
                      '/'.Yii::app()->controller->module->id.'/payments',
                      Yii::t('main', 'Платежи'),
                      Yii::t('main', 'Просмотр платежей, зачисление и списание средств...'),
                      'fa-cc-visa',
                      false
                    ) ?></li>
            <? } ?>
        </ul>
    </li>
    <li class="treeview">
        <a href="#" title="<?= Yii::t('main', 'Новости, объявления, рассылки...') ?>"
         data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-bell"></i>
            <span><?= Yii::t('main', 'Оповещение') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/news/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'news',
                      '/'.Yii::app()->controller->module->id.'/news',
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
        <a href="#" title="<?= Yii::t('main', 'Опросы и голосования...') ?>"
         data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-balance-scale"></i>
            <span><?= Yii::t('main', 'Обратная связь') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
             <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/votings/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'votings',
                      '/'.Yii::app()->controller->module->id.'/votings',
                      Yii::t('main', 'Голосования и опросы'),
                      Yii::t('main', 'Неформальные опросы мнения абонентов по любым произвольным вопросам, легитимные голосования по ФЗ'),
                      'fa-hand-paper-o',
                      false
                    ) ?></li>
            <? } ?>
        </ul>
    </li>
*/ ?>
    <? /* if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/dicCustom/index')) { ?>
        <li><?= CabinetUtils::adminMenu(
              'dicCustom',
              '/'.Yii::app()->controller->module->id.'/dicCustom',
              Yii::t('main', 'Справочник'),
              Yii::t('main', 'Общий справочник предопределенных значений полей и параметров'),
              'fa-list',
              false
            ) ?></li>
    <? } ?>
    <? if (DSConfig::getVal('blogs_enabled')) { ?>
        <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/blogs/index')) { ?>
            <li><?= CabinetUtils::adminMenu(
                  'blogs',
                  '/'.Yii::app()->controller->module->id.'/blogs',
                  Yii::t('main', 'Блоги'),
                  Yii::t('main', 'Управление блогами'),
                  'fa-commenting',
                  false
                ) ?></li>
        <? } ?>
    <? } ?>
    <li class="header"><?= Yii::t('main', 'САЙТ') ?></li>
    <li class="treeview">
        <a href="#" title="<?= Yii::t('main', 'Настройки страниц, ссылок, баннеров, текстов...') ?>"
         data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-th"></i>
            <span><?= Yii::t('main', 'Контент') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cmsMenus/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'static-pages-menus',
                      '/'.Yii::app()->controller->module->id.'/cmsMenus',
                      Yii::t('main', 'CMS: меню'),
                      Yii::t('main', 'Управление меню фронта сайта'),
                      'fa-th-list',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cmsPages/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'static-pages-pages',
                      '/'.Yii::app()->controller->module->id.'/cmsPages',
                      Yii::t('main', 'CMS: страницы'),
                      Yii::t('main', 'Управление страницами фронта сайта'),
                      'fa-list-alt',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cmsPagesContent/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'static-pages-pages-content',
                      '/'.Yii::app()->controller->module->id.'/cmsPagesContent',
                      Yii::t('main', 'CMS: контент страниц'),
                      Yii::t('main', 'Управление контентом страниц фронта сайта'),
                      'fa-indent',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cmsCustomContent/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'static-pages-custom-content',
                      '/'.Yii::app()->controller->module->id.'/cmsCustomContent',
                      Yii::t('main', 'CMS: контент блоков'),
                      Yii::t('main', 'Управление контентом блоков фронта сайта'),
                      'fa-th-large',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/banrules/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'banrules',
                      '/'.Yii::app()->controller->module->id.'/banrules',
                      Yii::t('main', 'CMS: фильтр URL'),
                      Yii::t('main', 'Правила обработки перенаправления URL'),
                      'fa-lock',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cmsEmailEvents/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'cms-email-contents',
                      '/'.Yii::app()->controller->module->id.'/cmsEmailEvents',
                      Yii::t('main', 'CMS: Оповещения'),
                      Yii::t('main', 'Правила обработки оповещений, событий и рассылок'),
                      'fa-mail-reply-all',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/banners/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'appearance',
                      '/'.Yii::app()->controller->module->id.'/banners',
                      Yii::t('main', 'Баннеры'),
                      Yii::t('main', 'Управление баннерами на главной странице сайта'),
                      'fa-film',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/translation/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'translation',
                      '/'.Yii::app()->controller->module->id.'/translation',
                      Yii::t('main', 'Перевод интерфейса'),
                      Yii::t('main', 'Корректировка автоматического перевода интерфейса'),
                      'fa-language',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/imagelib/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'imagelib',
                      '/'.Yii::app()->controller->module->id.'/imagelib',
                      Yii::t('main', 'Библиотека картинок'),
                      Yii::t('main', 'Управление библиотекой стандартных изображений'),
                      'fa-file-image-o',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/ModuleNews/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'ModuleNews',
                      '/'.Yii::app()->controller->module->id.'/ModuleNews',
                      Yii::t('main', 'Внутренние новости'),
                      Yii::t('main', 'Управление внутренними новостями и объявлениями'),
                      'fa-newspaper-o',
                      false
                    ) ?></li>
            <? } ?>
        </ul>
    </li>
    <li class="treeview">
        <a href="#" title="<?= Yii::t('main', 'Настройки платежных систем, формул, событий...') ?>"
         data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-wrench"></i>
            <span><?= Yii::t('main', 'Настройки') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/paysystems/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'paySystems',
                      '/'.Yii::app()->controller->module->id.'/paysystems',
                      Yii::t('main', 'Платёжные системы'),
                      Yii::t('main', 'Настройки параметров платёжных систем'),
                      'fa-money',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/formulas/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'formulas',
                      '/'.Yii::app()->controller->module->id.'/formulas/index',
                      Yii::t('main', 'Формулы'),
                      Yii::t('main', 'Формулы ценообразования, расчета прибыли, бонусов и т.п.'),
                      'fa-balance-scale',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/events/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'events',
                      '/'.Yii::app()->controller->module->id.'/events/index',
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
        <a href="#" title="<?= Yii::t('main', 'Настройки сайта') ?>"
        data-toggle="tooltip"
        data-placement="right">
            <i class="fa fa-gears"></i>
            <span><?= Yii::t('main', 'Система') ?></span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
*/ ?>
    <? /* if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/cache/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'cache-control',
                      '/'.Yii::app()->controller->module->id.'/cache',
                      Yii::t('main', 'Управление кешем'),
                      Yii::t('main', 'Контроль и очистка внутреннего кэша'),
                      false,
                      false
                    ) ?></li>
            <? } */ ?>
    <? /* if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/config/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'parameterAll',
                      '/'.Yii::app()->controller->module->id.'/config/index',
                      Yii::t('main', 'Параметры'),
                      Yii::t('main', 'Настройки технических параметров системы'),
                      'fa-gear',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/accessrights/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'accessrights',
                      '/'.Yii::app()->controller->module->id.'/accessrights/index',
                      Yii::t('main', 'Права доступа'),
                      Yii::t('main', 'Управление правами доступа'),
                      'fa-key',
                      false
                    ) ?></li>
            <? } ?>
            <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/translatorkeys/index')) { ?>
                <li><?= CabinetUtils::adminMenu(
                      'parameterBing',
                      '/'.Yii::app()->controller->module->id.'/translatorkeys',
                      Yii::t('main', 'Ключи переводчика'),
                      Yii::t('main', 'Настройка ключей переводчика'),
                      'fa-globe',
                      false
                    ) ?></li>
            <? } ?>
        </ul>
    </li>
    <? if (Yii::app()->user->checkAccess(Yii::app()->controller->module->id.'/sitestat/index')) { ?>
        <li><?= CabinetUtils::adminMenu(
              'site-stat',
              '/'.Yii::app()->controller->module->id.'/sitestat',
              Yii::t('main', 'Статистика'),
              Yii::t('main', 'Статистика работы сайта'),
              'fa-signal',
              false
            ) ?></a></li>
    <? } ?>
*/ ?>
  <li class="header"><?= Yii::t('main', 'ИСТОРИЯ ВКЛАДОК') ?></li>
    <?
    /** @var CustomCabinetController $this */
    $this->renderPartial('menu_history_block');
    ?>
</ul>
<? /* Original */ ?>
<? /*
+Главная
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
    - В админку - управление, в кабинет - мои голосования
  Опросы(?) /polls
    - В админку - управление, в кабинет - мои опросы
  ?Должники /promisors
  Сервис /services
     Мониторинг
     Видеонаблюдение
     Безопасность
     Статистика
Документы
  #База знаний /knowledgebase
    - В админку - управление, в кабинет - мои документы
  #Отчетность /accounting
    - В админку - управление, в кабинет - моя отчетность

// Кабинетное
    Обращения /requests
    Услуги /services
    Показания /readings
    Счета /payable
    История расходов /payhistory
    Объекты и трекинг(?) /monitoring
    Пропуска /passblanks
    Лента событий /newsribbon
    Документы ++
    Профиль
    Тревога!
*/ ?>
</ul>