<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="view.php">
 * </description>
 **********************************************************************************************************************/ ?>
<? /*=============================================================*/ ?>
<? $module = Yii::app()->controller->module->id;
/** @var CustomCabinetController $this */
?>
<? //todo: Исключить загрузку дэшборда при открытии документов по ссылке cabinet/main/open ?>
<? if (($this->action->id != 'open'
      //  && !preg_match('/cabinet\/main\/open\?/is',$_SERVER['HTTP_REFERER'])
  )
  &&
  (Yii::app()->request->isAjaxRequest &&
    ((isset($_REQUEST['ajax']) && $_REQUEST['ajax'] != 'admin-tabs-history-grid') || !(isset($_REQUEST['ajax']))))
) {
    /** @var Users $user */
    $user = Users::model()->findByPkEx(Yii::app()->user->id);
    ?>
  <!-- Main content -->
  <section class="content" id="main-view-content-section">
    <div class="row">
      <div class="col-md-12">
        <div class="box box-info"> <? /*  box-default collapsed-box */ ?>
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Управление данными</h3>
            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <div class="box-body"> <? /* style="display: none;"*/ ?>
              <?
              $this->renderPartial('view_part_data_management', ['user' => $user]);
              ?>
          </div>
          <!-- /.box-body -->
        </div>
      </div>
    </div> <? /* Управление данными */ ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default" id="box-for-user-lands-<?= $user->uid ?>">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Участки</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
              <?
              /** @var Lands $lands */
              $lands = new Lands('search');
              $lands->unsetAttributes();
              $landsCriteria = new CDbCriteria();
              $landsCriteria->join = "inner join obj_users_lands uu2 on uu2.lands_id = t.lands_id AND uu2.deleted is null AND uu2.uid = :uid
";
              $landsCriteria->params = [
                ':uid' => $user->uid,
              ];
              $landsDataProvider = $lands->search($landsCriteria, 100);

              $this->widget(
                'booster.widgets.TbListView',
                [
                  'id'            => 'user-lands-list-' . $user->uid,
                  'dataProvider'  => $landsDataProvider,
                  'itemView'      => 'application.modules.' .
                    Yii::app()->controller->module->id .
                    '.views.profile.landListView',
                  'itemsCssClass' => 'lands-list',
                    /* 'enableSorting'      => true,
                    'sortableAttributes' => array(
                      '#'          => '#',
                      'miner_type' => Yii::t('main', 'Тип'),
                      'uptimeSec'  => 'Uptime',
                      'int_ip'     => 'IP',
                      'gpus_count' => Yii::t('main', 'Кол-во PU'),
                      'hashRate'   => Yii::t('main', 'Hash rate'),
                    ),
                    'sorterHeader'       => '',
                      //'template'      => '{summary}{pager}{items}{pager}',
                    'template'           => '{sorter}{items}',
                    */
                ]
              );
              ?>
          </div>
        </div>
      </div>
    </div> <? /* Участки */ ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-default" id="box-for-user-devices-<?= $user->uid ?>">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Приборы</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
            </div>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
              <?
              /** @var Devices $devices */
              $devices = new Devices('search');
              $devices->unsetAttributes();
              $devicesCriteria = new CDbCriteria();
              $devicesCriteria->join = "inner join obj_lands_devices uu2 on uu2.devices_id = t.devices_id AND 
uu2.lands_id in (select uu3.lands_id from obj_users_lands uu3 where uu3.uid = :uid and uu3.deleted is null) 
and uu2.deleted is null
";
              $devicesCriteria->params = [
                ':uid' => $user->uid,
              ];
              $devicesDataProvider = $devices->search($devicesCriteria, 100);

              $this->widget(
                'booster.widgets.TbListView',
                [
                  'id'            => 'user-devices-list-' . $user->uid,
                  'dataProvider'  => $devicesDataProvider,
                  'itemView'      => 'application.modules.' .
                    Yii::app()->controller->module->id .
                    '.views.profile.deviceListView',
                  'itemsCssClass' => 'devices-list',
                    /* 'enableSorting'      => true,
                    'sortableAttributes' => array(
                      '#'          => '#',
                      'miner_type' => Yii::t('main', 'Тип'),
                      'uptimeSec'  => 'Uptime',
                      'int_ip'     => 'IP',
                      'gpus_count' => Yii::t('main', 'Кол-во PU'),
                      'hashRate'   => Yii::t('main', 'Hash rate'),
                    ),
                    'sorterHeader'       => '',
                      //'template'      => '{summary}{pager}{items}{pager}',
                    'template'           => '{sorter}{items}',
                    */
                ]
              );
              ?>
          </div>
        </div>
      </div>
    </div> <? /* Приборы учёта */ ?>
    <div class="row">
      <div class="col-md-12">
        <div class="box box-primary box-solid collapsed-box">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse">Для разработчиков</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-plus"></i>
              </button>
              <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                    class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-info"></i> Важно!</h4>
                  Везде сделать упор на Nekta\Lora!
                </div>
              </div>
              <div class="col-md-4">
                <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-info"></i> Архи важно!</h4>
                  Не забыть про аудит системы безопасности! Проверить всё в контроллерах кабинета и админки!
                </div>
              </div>
              <div class="col-md-4">
                <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-info"></i> Важно!</h4>
                  Не забыть причесать куки!
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">

                <h3>Профиль</h3>
                <ul>
                  <li>ФИО</li>
                  <li>Проблемы</li>
                  <li>Ссылка на редактирование ###редактирвоание профиля</li>
                  <li>Видимо, какие-то общие суммы задолженностей и т.п.?</li>
                  <li>Ссылка на статистику</li>
                </ul>
                <h3>Экстренная связь</h3>
                <ul>
                  <li>Правление</li>
                  <li>Прочие контакты</li>
                </ul>
                <h3>Участки (листвью, виджет участка)</h3>
                <ul>
                  <li>Номер, адрес</li>
                  <li>Проблемы</li>
                  <li>Ссылка на редактирование ###редактирвоание профиля</li>
                  <li>Тарифы, привязанные к участкам</li>
                  <li>Ссылка на статистику</li>
                  <li>Не ваш участок, нет вашего участка?</li>
                </ul>
                <h3>Приборы учета (листвью, виджет прибора)</h3>
                <ul>
                  <li>Название, тип и т.п.</li>
                  <li>Проблемы</li>
                  <li>Ссылка на редактирование ###редактирвоание профиля</li>
                  <li>Тарифы, привязанные к приборам</li>
                  <li>Ссылка на статистику</li>
                  <li>Не ваш прибор учета, нет вашего прибора?</li>
                </ul>
                <h3>Везде кнопка "оплатить"</h3>
                <ul>
                  <li>Заплатить за всё подряд</li>
                </ul>
                <h3>Новости</h3>
                <ul>
                  <li>Виджет</li>
                </ul>
                <h3>Объявления</h3>
                <ul>
                  <li>Виджет</li>
                </ul>
                <h3>Опросы</h3>
                <ul>
                  <li>Виджет</li>
                </ul>
                <h3>Голосования</h3>
                <ul>
                  <li>Виджет</li>
                </ul>
                <h3>Обращения</h3>
                <ul>
                  <li>Пока не понятно...</li>
                </ul>
                <h3>Аналитика</h3>
                <ul>
                  <li>Виджет</li>
                </ul>
                <ul>
                  <li>Календарь событий</li>
                </ul>
                <h3>Личные сообщения</h3>
                <ul>
                  <li>От администрации? От соседей? Кстати, всё должно работать из магазина, подсмотреть в старом
                    кабинете
                  </li>
                </ul>
                <h5>~ Поиск:</h5>
                <ul>
                  <li>* для каждого модуля добавить ключевые слова, например: земля, участок, дом, адрес и т.п.</li>
                  <li>* сделать класс searchable</li>
                  <li>Участки - в справочник</li>
                  <li>Участки - в карту</li>
                  <li>Абоненты \ члены СНТ - в справочник</li>
                  <li>Абоненты - в карту</li>
                  <li>Объявления</li>
                  <li>Голосования</li>
                  <li>Новости</li>
                  <li>Опросы</li>
                  <li>Счета и платежи</li>
                </ul>
              </div>
              <div class="col-md-6">
                <h3>Отсюда структура меню</h3>
                <ul>
                  <li>Диспетчерская</li>
                  <li>Календарь событий!</li>
                  <li><s>Новости</s></li>
                  <li><s>Голосования</s></li>
                  <li><s>Платежи (и там все бэбехи)</s></li>
                  <li><s>Профиль</s></li>
                  <li><s>Участки</s>
                    <ul>
                      <li><s>Участок 1</s></li>
                      <li><s>Участок 2</s></li>
                    </ul>
                  </li>
                  <li><s>Приборы</s>
                    <ul>
                      <li><s>Прибор 1</s></li>
                      <li><s>Прибор 2</s></li>
                    </ul>
                  </li>

                  <li><s>Аналитика и статистика</s></li>
                  <li>Справочник?
                    <ul>
                      <li>Адреса, телефоны, ФИО - в смысле персональных данных, все члены СНТ и должны знать друг друга
                        в лицо!
                      </li>
                      <li>Карта, кадастр - открытые данные!</li>
                      <li>Какие-то документы СНТ для своих</li>
                    </ul>
                  </li>
                </ul>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-4">
        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-money"></i> Баланс</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
              <?
              $uid = Yii::app()->user->id;
              //$ordersByStatuses = OrdersStatuses::getAllStatusesListAndOrderCount($uid);
              ?>
            <div class="table-responsive">
              <table class="table table-hover no-margin">
                <tbody>
                <tr>
                  <td><strong>Ваш персональный счёт</strong></td>
                  <td><?= Yii::app()->user->getPersonalAccount() ?></td>
                </tr>
                <tr>
                  <td><strong>Ваш менеджер</strong></td>
                  <td><? if ($user->default_manager != null) { ?>
                          <?= $user->default_manager_name ?>
                      <? } else { ?>
                          <?= Yii::t('main', 'Не назначен') ?>
                      <? } ?>
                  </td>
                </tr>
                <tr>
                  <td><strong>Остаток средств</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          Users::getBalance(Yii::app()->user->id),
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?>
                  </td>
                </tr>
                <tr>
                  <td><strong>Сумма неоплаченных счетов</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?>
                  </td>
                </tr>
                <tr class="info">
                  <td><strong>Сальдо</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-exchange"></i> Движение средств
            </a>
            <a class="btn btn-app bg-light-blue" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-credit-card"></i> Пополнить картой
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-success box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-calculator"></i> Услуги</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-hover no-margin">
                <thead>
                <tr>
                  <th>Услуга</th>
                  <th>Тариф</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><strong>Членские взносы</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?></td>
                </tr>
                <tr>
                  <td><strong>Ежемесячный взнос на ТО</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?></td>
                </tr>
                <tr>
                  <td><strong>Нормативные потери ЭЭ</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?></td>
                </tr>
                <tr>
                  <td><strong>Ежегодное ТО</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?></td>
                </tr>
                <tr class="success">
                  <td><strong>Итого</strong></td>
                  <td><?=
                      Formulas::priceWrapper(
                        Formulas::convertCurrency(
                          100500,
                          DSConfig::getVal('site_currency'),
                          DSConfig::getCurrency()
                        ),
                        DSConfig::getCurrency()
                      ); ?></td>
                </tr>

                <? /* <tr>
                                    <td><a href="pages/examples/invoice.html">OR1848</a></td>
                                    <td>Samsung Smart TV</td>
                                    <td><span class="label label-warning">Pending</span></td>
                                    <td>
                                        <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                                    </td>
                                </tr> */ ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-calculator"></i> Детализация услуг
            </a>
            <a class="btn btn-app bg-green" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-money"></i> Оплатить всё
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-dashboard"></i> Приборы учёта</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-hover no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
            <dl class="dl-horizontal">
                <?
                //$devices = Devices::
                ?>
              <dt>Членские взносы</dt>
              <dd><?=
                  Formulas::priceWrapper(
                    Formulas::convertCurrency(
                      100500,
                      DSConfig::getVal('site_currency'),
                      DSConfig::getCurrency()
                    ),
                    DSConfig::getCurrency()
                  ); ?></dd>
              <dt>Ежемесячный взнос на ТО</dt>
              <dd><?=
                  Formulas::priceWrapper(
                    Formulas::convertCurrency(
                      100500,
                      DSConfig::getVal('site_currency'),
                      DSConfig::getCurrency()
                    ),
                    DSConfig::getCurrency()
                  ); ?></dd>
              <dt>Нормативные потери ЭЭ</dt>
              <dd><?=
                  Formulas::priceWrapper(
                    Formulas::convertCurrency(
                      100500,
                      DSConfig::getVal('site_currency'),
                      DSConfig::getCurrency()
                    ),
                    DSConfig::getCurrency()
                  ); ?></dd>
            </dl>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-dashboard"></i> История показаний
            </a>
            <a class="btn btn-app bg-yellow" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-check-square-o"></i> Передать показания
            </a>
          </div>
        </div>
      </div>
    </div>
      <? // ================ row 2 ================= ?>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-question-circle"></i> Ваши обращения</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-eye"></i> Подробнее
            </a>
            <a class="btn btn-app bg-yellow" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-question-circle"></i> Новое обращение
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-rub"></i> Неоплаченные счета</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-eye"></i> Подробнее
            </a>
            <a class="btn btn-app bg-red" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-money"></i> Оплатить всё
            </a>
          </div>
        </div>
      </div>
    </div>
      <? // ================ row 3 ================= ?>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-newspaper-o"></i> Новости</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-eye"></i> Подробнее
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-bell"></i> Объявления</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-eye"></i> Подробнее
            </a>
            <a class="btn btn-app bg-red" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-bell"></i> Сделать объявление
            </a>
          </div>
        </div>
      </div>
    </div>
      <? // ================ row 4 ================= ?>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-warning box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-hand-paper-o"></i> Голосования</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-eye"></i> Подробнее
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="box box-danger box-solid">
          <div class="box-header with-border">
            <h3 class="box-title" data-widget="collapse"><i class="fa fa-balance-scale"></i> Опросы</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                    class="fa fa-minus"></i>
              </button>
                <? /*<button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                        class="fa fa-times"></i></button>*/ ?>
            </div>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table no-margin">
                <thead>
                <tr>
                  <th>Order ID</th>
                  <th>Item</th>
                  <th>Status</th>
                  <th>Popularity</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-info">Processing</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                      90,80,-90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR1848</a></td>
                  <td>Samsung Smart TV</td>
                  <td><span class="label label-warning">Pending</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f39c12" data-height="20">
                      90,80,-90,70,61,-83,68
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR7429</a></td>
                  <td>iPhone 6 Plus</td>
                  <td><span class="label label-danger">Delivered</span></td>
                  <td>
                    <div class="sparkbar" data-color="#f56954" data-height="20">
                      90,-80,90,70,-61,83,63
                    </div>
                  </td>
                </tr>
                <tr>
                  <td><a href="pages/examples/invoice.html">OR9842</a></td>
                  <td>Call of Duty IV</td>
                  <td><span class="label label-success">Shipped</span></td>
                  <td>
                    <div class="sparkbar" data-color="#00a65a" data-height="20">
                      90,80,90,-70,61,-83,63
                    </div>
                  </td>
                </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer">
            <a class="btn btn-app" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-eye"></i> Подробнее
            </a>
            <a class="btn btn-app bg-red" href="#">
                <? /* <span class="badge bg-yellow">3</span> */ ?>
              <i class="fa fa-balance-scale"></i> Создать опрос
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Info boxes -->
  </section>
  <!-- /.content -->
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script type="text/javascript"
          src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard.js' :
            'dashboard.js' ?>"></script>
  <script type="text/javascript"
          src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/dist/js/pages/<?= YII_DEBUG ? 'dashboard2.js' :
            'dashboard2.js' ?>"></script>
<? } ?>
<script>
    if (typeof deferredDashboard !== 'undefined') {
        console.log('deferredDashboard resolved');
        deferredDashboard.resolve(true);
    }

    /*    $(function () {
    // -----------------
            // - SPARKLINE BAR -
            // -----------------
            /*
            $('.sparkbar').each(function () {
                var $this = $(this);
                $this.sparkline('html', {
                    type    : 'bar',
                    height  : $this.data('height') ? $this.data('height') : '30',
                    barColor: $this.data('color')
                });
            });
            */
    // -----------------
    // - SPARKLINE PIE -
    // -----------------
    /*
    $('.sparkpie').each(function () {
        var $this = $(this);
        $this.sparkline('html', {
            type       : 'pie',
            height     : $this.data('height') ? $this.data('height') : '90',
            sliceColors: $this.data('color')
        });
    });
    */
    // ------------------
    // - SPARKLINE LINE -
    // ------------------
    /*
    $('.sparkline').each(function () {
        var $this = $(this);
        $this.sparkline('html', {
            type     : 'line',
            height   : $this.data('height') ? $this.data('height') : '90',
            width    : '100%',
            lineColor: $this.data('linecolor'),
            fillColor: $this.data('fillcolor'),
            spotColor: $this.data('spotcolor')
        });
    });
     * /
}); */
</script>