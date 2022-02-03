<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= Yii::app()->controller->module->displayedName; ?> | <?= DSConfig::getVal('site_name') ?></title>
    <? $theme = DSConfig::getVal('site_front_theme') ?>
    <? $module = Yii::app()->controller->module->id; ?>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/images/favicon.ico" type="image/x-icon"
        rel="icon"/>
  <link href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/images/favicon.ico" type="image/x-icon"
        rel="shortcut icon"/>
  <!-- bootstrap framework -->
    <? /*
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/css/jquery-ui.css"/>
    */ ?>
  <!-- Yii view styles -->
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/gridview/styles.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/listview/styles.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/detailview/styles.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/treeview/jquery.treeview.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/pager/pager.css"/>
    <? /* <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/bower_components/datatables.net-bs/css/dataTables.bootstrap.css"/> */ ?>
  <!-- ================= -->
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/main.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/blog.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/css/popup.css"/>
    <? /*
    <link rel="stylesheet" type="text/css" href="<?= Yii::app()->request->baseUrl ?>/themes/<?=$module?>/css/layout-default-latest.css"/>
    */ ?>
    <? /*
    <link rel="stylesheet" type="text/css"
          href="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/css/font-awesome.css"/>*/ ?>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/css/flags/16x16/sprite-flags-16x16.css"/>
  <link rel="stylesheet" type="text/css"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/css/jquery.ui.dstabs.css"/>
  <script type="text/javascript"
          src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/<?= YII_DEBUG ? 'jquery.ui.dstabs.js' :
            'jquery.ui.dstabs.min.js' ?>"></script>
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= Yii::app(
  )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/Ionicons/css/ionicons.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/plugins/iCheck/all.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/morris.js/morris.min.css">
  <!-- jvectormap -->
  <link rel="stylesheet"
        href="<?= Yii::app(
        )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/jvectormap/jquery-jvectormap.min.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= Yii::app(
  )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= Yii::app(
  )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/bootstrap-daterangepicker/daterangepicker.min.css">

  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?= Yii::app(
  )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap Data Grid -->
    <? /*<link rel="stylesheet" href="<?= Yii::app(
    )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"> */ ?>
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?= Yii::app(
  )->request->baseUrl; ?>/themes/<?= $module ?>/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet"
        href="<?= Yii::app(
        )->request->baseUrl; ?>/themes/<?= $module ?>/bower_components/select2/dist/css/select2.min.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet"
        href="<?= Yii::app(
        )->request->baseUrl; ?>/themes/<?= $module ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet"
        href="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/css/skins/_all-skins.min.css">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
      var baseUrl = "<?=Yii::app()->request->baseUrl?>";
  </script>
    <? Yii::app()->clientScript->registerScript(YII_DEBUG ? 'jquery.js' : 'jquery.min.js', CClientScript::POS_HEAD); ?>
    <? // JQuery 3.x compatibility debug and fix ?>
    <? /* <script type="text/javascript" src="<?= Yii::app()->request->baseUrl ?>/themes/<?=$module?>/js/jquery-migrate-3.1.0.js"></script> */ ?>
    <? Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
  <style>
    .modal-block .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .modal-block .modal {
      background: transparent !important;
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<input type="hidden" name="manager_id" id="manager_id" value="<?= $this->manager ?>"/>
<div class="wrapper">
  <header class="main-header">
    <!-- Logo -->
    <a href="/" class="logo" title="На сайт">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img height="50" width="50"
                                   src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/images/favicon.ico"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img height="50" width="50"
                                 src="<?= Yii::app(
                                 )->request->baseUrl; ?>/themes/<?= $module ?>/images/favicon.ico"><?= Yii::app(
          )->controller->module->displayedName; ?></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button"
         title="<?= Yii::t('main', 'Переключить панель навигации') ?><">
        <span class="sr-only"><?= Yii::t('main', 'Переключить панель навигации') ?></span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <? $lang_array = explode(',', DSConfig::getVal('site_language_supported'));
            if ($lang_array and (count($lang_array) > 1)) { ?>
              <li class="dropdown" title="<?= Yii::t('main', 'Язык') ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                   aria-haspopup="true"
                   aria-expanded="false"><i class="flag flag-16 flag-<?= Utils::langToCountry(
                      Yii::app()->language
                    ) ?>"></i> <?= Utils::langToLangName(Yii::app()->language) ?> <span
                      class="caret"></span></a>
                <ul class="dropdown-menu">
                    <? foreach ($lang_array as $interfaceLang) { ?>
                      <li><a href="/user/setlang/<?= $interfaceLang ?>"><i
                              class="flag flag-16 flag-<?= Utils::langToCountry(
                                $interfaceLang
                              ) ?> "></i> <?= Utils::langToLangName($interfaceLang) ?></a></li>
                    <? } ?>
                </ul>
              </li>
            <? } ?>
            <? /*
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-envelope-o"></i>
                      <span class="label label-success">4</span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">You have 4 messages</li>
                      <li>
                          <!-- inner menu: contains the actual data -->
                          <ul class="menu">
                              <li><!-- start message -->
                                  <a href="#">
                                      <div class="pull-left">
                                          <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                      </div>
                                      <h4>
                                          Support Team
                                          <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                  </a>
                              </li>
                              <!-- end message -->
                              <li>
                                  <a href="#">
                                      <div class="pull-left">
                                          <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                      </div>
                                      <h4>
                                          AdminLTE Design Team
                                          <small><i class="fa fa-clock-o"></i> 2 hours</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <div class="pull-left">
                                          <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                      </div>
                                      <h4>
                                          Developers
                                          <small><i class="fa fa-clock-o"></i> Today</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <div class="pull-left">
                                          <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                                      </div>
                                      <h4>
                                          Sales Department
                                          <small><i class="fa fa-clock-o"></i> Yesterday</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <div class="pull-left">
                                          <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?=$module?>/dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                                      </div>
                                      <h4>
                                          Reviewers
                                          <small><i class="fa fa-clock-o"></i> 2 days</small>
                                      </h4>
                                      <p>Why not buy a new awesome theme?</p>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li class="footer"><a href="#">See All Messages</a></li>
                  </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o"></i>
                      <span class="label label-warning">10</span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">You have 10 notifications</li>
                      <li>
                          <!-- inner menu: contains the actual data -->
                          <ul class="menu">
                              <li>
                                  <a href="#">
                                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                                      page and may cause design problems
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-users text-red"></i> 5 new members joined
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                                  </a>
                              </li>
                              <li>
                                  <a href="#">
                                      <i class="fa fa-user text-red"></i> You changed your username
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <li class="footer"><a href="#">View all</a></li>
                  </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-flag-o"></i>
                      <span class="label label-danger">9</span>
                  </a>
                  <ul class="dropdown-menu">
                      <li class="header">You have 9 tasks</li>
                      <li>
                          <!-- inner menu: contains the actual data -->
                          <ul class="menu">
                              <li><!-- Task item -->
                                  <a href="#">
                                      <h3>
                                          Design some buttons
                                          <small class="pull-right">20%</small>
                                      </h3>
                                      <div class="progress xs">
                                          <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                              <span class="sr-only">20% Complete</span>
                                          </div>
                                      </div>
                                  </a>
                              </li>
                              <!-- end task item -->
                              <li><!-- Task item -->
                                  <a href="#">
                                      <h3>
                                          Create a nice theme
                                          <small class="pull-right">40%</small>
                                      </h3>
                                      <div class="progress xs">
                                          <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                              <span class="sr-only">40% Complete</span>
                                          </div>
                                      </div>
                                  </a>
                              </li>
                              <!-- end task item -->
                              <li><!-- Task item -->
                                  <a href="#">
                                      <h3>
                                          Some task I need to do
                                          <small class="pull-right">60%</small>
                                      </h3>
                                      <div class="progress xs">
                                          <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                              <span class="sr-only">60% Complete</span>
                                          </div>
                                      </div>
                                  </a>
                              </li>
                              <!-- end task item -->
                              <li><!-- Task item -->
                                  <a href="#">
                                      <h3>
                                          Make beautiful transitions
                                          <small class="pull-right">80%</small>
                                      </h3>
                                      <div class="progress xs">
                                          <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                                               aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                              <span class="sr-only">80% Complete</span>
                                          </div>
                                      </div>
                                  </a>
                              </li>
                              <!-- end task item -->
                          </ul>
                      </li>
                      <li class="footer">
                          <a href="#">View all tasks</a>
                      </li>
                  </ul>
              </li>
              */ ?>
          <!-- User Account: style can be found in dropdown.less -->
            <?php $userAsManager = Users::getUserAsManager(Yii::app()->user->id); ?>
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"
               title="Текущая учетная запись - дополнительно...">
              <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user2-160x160.jpg"
                   class="user-image"
                   alt="<?= Yii::t('main', 'Фото') ?>">
              <span class="hidden-xs"><?= Utils::fullNameWithInitials($userAsManager->fullname) ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user2-160x160.jpg"
                     class="img-circle" alt="<?= Yii::t('main', 'Фото') ?>">

                <p>
                    <?= $userAsManager->fullname ?>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <small><?= AccessRights::getRoleDescriptionByRole($userAsManager->role) ?></small>
                  <? /*
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                               */ ?>
              </li>

              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="/<?= Yii::app()->controller->module->id ?>/users/view/id/<?= $userAsManager->uid ?>"
                     onclick="getContent(this,'<?= addslashes(
                       Utils::fullNameWithInitials($userAsManager->fullname)
                     ) ?>',false);return false;"
                     class="btn btn-default btn-flat"><?= Yii::t('main', 'Профиль') ?></a>
                </div>
                <div class="pull-right">
                  <a href="<?= Yii::app()->request->baseUrl ?>/user/logout"
                     class="btn btn-default btn-flat"><?= Yii::t('main', 'Выход') ?></a>
                </div>
              </li>
            </ul>
          </li>
          <li>
            <a href="<?= DSConfig::getVal('support_tracker_base_url'); ?>"
               title="На сайт сопровождения проекта"
               target="_blank"><i
                  class="fa fa-bug"></i></a>
          </li>
          <li>
            <a href="<?= Utils::getHelp('main'); ?>"
               title="На сайт документации проекта"
               target="_blank"><i class="fa fa-question"></i></a>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"
               title="Настройки интерфейса"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
        <? /*<div class="user-panel">
                <div class="pull-left image">
                    <img src="<?= Yii::app()->request->baseUrl; ?>/themes/<?= $module ?>/dist/img/user2-160x160.jpg"
                         class="img-circle" alt="<?= Yii::t('main', 'Фото') ?>">
                </div>
                <div class="pull-left info">
                    <p><?= Utils::fullNameWithInitials($userAsManager->fullname) ?></p>
                    <a href="#"><i class="fa fa-circle text-success"></i> <?= $userAsManager->role; ?></a>
                </div>
            </div>*/ ?>
      <!-- search form -->
      <form action="#" method="post" class="sidebar-form" onsubmit="mainSearch(); return false;">
        <div class="input-group">
          <input id="main-search-q" type="text" name="q" class="form-control"
                 placeholder="<?= Yii::t('main', 'Поиск...') ?>">
          <span class="input-group-btn">
                <button type="button" name="search" id="search-btn" class="btn btn-flat"
                        onclick="mainSearch(); return false;"
                ><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <script>
          $(window).on('load', function () {
              $('#main-search-q').on('keypress', function (event) {
                  if (event.which == 13) {
                      mainSearch();
                      return false;
                  }
              });
          });
      </script>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
        <? $this->renderPartial('/main/menu', []); ?>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <? /* <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    */ ?>
    <!-- !!!!!!!!!!!!!!!!!!!!!!!! -->
    <section class="content">
      <div id="admin-content" class="nav-tabs-customXXX">
          <? /*TODO */ ?>
          <? //php $this->widget('application.components.widgets.MessagesBlock') ?>
        <ul id="admin-content-tabs" class="navXXX nav-tabsXXX">
            <? ////data.<?=DSConfig::getVal('site_domain')?>
          <li><a href="/<?= Yii::app()->controller->module->id ?>/main/dashboard"><span><?= Yii::t(
                        'main',
                        'Рабочий стол'
                      ) ?></span></a>
            <a class="ds-ui-tab-button" role="tabRefresh" href="javascript:void(0);">
              <i class="fa fa-refresh"></i><i class="fa fa-spinner fa-spin hidden"></i>
            </a>
          </li>
        </ul>
        <div class="tab-panels-content-wrapper tab-content22"> <? // pre-scrollable ?>
          <div id="ui-tabs-1" class="tab-panel-content-wrapper tab-pane22">
            <section class="content">
            </section>
          </div>
        </div>
      </div>
    </section>
    <!-- !!!!!!!!!!!!!!!!!!!!!!!! -->
    <!-- Main content -->
    <a href="#" id="backToTop"><i class="fa fa-angle-up"></i></a>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> <?= '0.9.0' ?>
    </div>
      <? if (date('Y') <= 2020) {
          $copyrightYers = '2020';
      } else {
          $copyrightYers = '2020-' . date('Y');
      } ?>
    <strong>&copy; <?= $copyrightYers; ?> <a href="/"><?= DSConfig::getVal('site_name') ?></a>.</strong>
    Все права защищены.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark" style="display: none;">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">Общие настройки</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Делать всегда всё хорошо
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Независимо от того, включен или выключен этот режим, всегда всё будет делаться хорошо
            </p>
          </div>
          <!-- /.form-group -->
            <? /*
                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Expose author name in posts
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Allow the user to show his name in blog posts
                        </p>
                    </div>
                    <!-- /.form-group -->

                    <h3 class="control-sidebar-heading">Chat Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Show me as online
                            <input type="checkbox" class="pull-right" checked>
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Turn off notifications
                            <input type="checkbox" class="pull-right">
                        </label>
                    </div>
                    <!-- /.form-group -->

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Delete chat history
                            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
                        </label>
                    </div>
*/ ?>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

<? if (Yii::app()->user->checkAccess('admin/message/sendMail')) { ?>
    <? //- Internal email ----------------------------------------------?>
  <div class="modal fade" id="new-internal-email-to-all" title="<?= Yii::t('main', 'EMail всем пользователям') ?>"
       tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><?= Yii::t('main', 'EMail всем пользователям') ?></h4>
        </div>
        <div class="modal-body">
          <div class="box-body">

            <form id="new-internal-email-form-to-all" class="form-horizontal">
              <input type="hidden" name="message[uid]" value="<?= 'all' ?>"/>
              <div class="form-group">
                <select name="message[template_id]" class="form-control">
                    <? $templates = Yii::app()->db->createCommand(
                      "SELECT ee.id, ee.template FROM cms_email_events ee 
                     where ee.class='Mail' and ee.action='sendMailToAll' and ee.enabled=1"
                    )->queryAll();
                    if ($templates) {
                        foreach ($templates as $template) {
                            $res = preg_match(
                              '/<\?\s*\/\/(.*?)\?>/isu',
                              $template['template'],
                              $matches
                            );
                            if ($res) {
                                $templateName = $matches[1] . ' (ID=' . $template['id'] . ')';
                            } else {
                                $templateName = Yii::t(
                                    'main',
                                    'Без названия'
                                  ) . ' (ID=' . $template['id'] . ')';
                            }
                            ?>
                          <option
                              value="<?= $template['id'] ?>" <?= (!isset($templateWasSelected) ? 'selected' : '') ?>>
                              <?= Yii::t('main', $templateName) ?>
                              <? $templateWasSelected = true; ?>
                          </option>
                        <? }
                    } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="message-all" class="control-label"><?= Yii::t(
                      'main',
                      'Текст сообщения (обязательно, даже если это не предусмотрено шаблоном)'
                    ) ?>:</label>
                <textarea class="form-control" name="message[message]" id="message-all"></textarea>
              </div>
            </form>
          </div>
          <p class="margin"><?= Yii::t(
                'main',
                'Не используйте длинных сообщений! Изучите и настройте шаблоны рассылки для события Mail.sendMailToAll'
              ) ?>
          </p>
          <p class="margin"><?= Yii::t('main', 'Если Вы не видите новый шаблон - обновите страницу.') ?></p>
          <p class="margin"><?= Yii::t(
                'main',
                'Рекомендуем для рассылок использовать спец. инструменты, получив список адресов в разделе "Пользователи".'
              ) ?></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" onclick="
              $('#new-internal-email-to-all').modal('hide');
              var msg = $('#new-internal-email-form-to-all').serialize();
              $.post('/<?= Yii::app()->controller->module->id ?>/message/sendMail',msg, function(){
              $('#message-all').val('');
              },'text');
              return false;"><?= Yii::t('main', 'Отправить') ?></button>
          &nbsp;&nbsp;
          <button type="button" class="btn btn-default pull-left" data-dismiss="modal" onclick="$('#new-internal-email-to-all').modal('hide');
      $('#message-all').val('');
      return false;"><?= Yii::t('main', 'Отмена') ?></button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
<? } ?>
<!-- ======================================================================= -->
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<? // codemirror ?>
<script src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/lib/codemirror.js"></script>
<link rel="stylesheet"
      href="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/lib/codemirror.css">
<script src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/xml/xml.js"></script>
<script src="<?= Yii::app(
)->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/javascript/javascript.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/css/css.js"></script>
<script
    src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/clike/clike.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/php/php.js"></script>
<script src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/mode/sql/sql.js"></script>
<script
    src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/codemirror/addon/edit/matchbrackets.js"></script>
<? // end of codemirror ?>
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/js/<?= YII_DEBUG ? 'jquery.lazyload.js' :
          'jquery.lazyload.min.js' ?>"></script>
<!-- Morris.js charts -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/raphael/<?= YII_DEBUG ?
          'raphael.js' : 'raphael.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/morris.js/<?= YII_DEBUG ?
          'morris.js' : 'morris.min.js' ?>"></script>
<!-- Sparkline -->
<script type="text/javascript"
        src="<?= Yii::app(
        )->request->baseUrl ?>/themes/<?= $module ?>/bower_components/jquery-sparkline/dist/<?= YII_DEBUG ?
          'jquery.sparkline.js' : 'jquery.sparkline.min.js' ?>"></script>
<!-- jvectormap -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/jvectormap/<?= YII_DEBUG ?
          'jquery-jvectormap-1.2.2.min.js' : 'jquery-jvectormap-1.2.2.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/jvectormap/<?= YII_DEBUG ?
          'jquery-jvectormap-world-mill-en.js' : 'jquery-jvectormap-world-mill-en.js' ?>"></script>
<!-- jQuery Knob Chart -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/jquery-knob/dist/<?= YII_DEBUG ?
          'jquery.knob.min.js' : 'jquery.knob.min.js' ?>"></script>
<!-- daterangepicker -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/moment/min/<?= YII_DEBUG ?
          'moment.min.js' : 'moment.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= Yii::app(
        )->request->baseUrl ?>/themes/<?= $module ?>/bower_components/bootstrap-daterangepicker/<?= YII_DEBUG ?
          'daterangepicker.js' : 'daterangepicker.js' ?>"></script>
<!-- datepicker -->
<script type="text/javascript"
        src="<?= Yii::app(
        )->request->baseUrl ?>/themes/<?= $module ?>/bower_components/bootstrap-datepicker/dist/js/<?= YII_DEBUG ?
          'bootstrap-datepicker.js' : 'bootstrap-datepicker.min.js' ?>"></script>
<!-- bootstrap color picker -->
<script type="text/javascript"
        src="<?= Yii::app(
        )->request->baseUrl ?>/themes/<?= $module ?>/bower_components/bootstrap-colorpicker/dist/js/<?= YII_DEBUG ?
          'bootstrap-colorpicker.js' : 'bootstrap-colorpicker.min.js' ?>"></script>
<!-- bootstrap time picker -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/timepicker/<?= YII_DEBUG ?
          'bootstrap-timepicker.js' : 'bootstrap-timepicker.min.js' ?>"></script>
<!-- Bootstrap WYSIHTML5 -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/bootstrap-wysihtml5/<?= YII_DEBUG ?
          'bootstrap3-wysihtml5.all.js' : 'bootstrap3-wysihtml5.all.min.js' ?>"></script>
<!-- Slimscroll -->
<script type="text/javascript"
        src="<?= Yii::app(
        )->request->baseUrl ?>/themes/<?= $module ?>/bower_components/jquery-slimscroll/<?= YII_DEBUG ?
          'jquery.slimscroll.js' :
          'jquery.slimscroll.min.js' ?>"></script>
<!-- FastClick -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/fastclick/lib/<?= YII_DEBUG ?
          'fastclick.js' : 'fastclick.js' ?>"></script>
<!-- Select2 -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/select2/dist/js/<?= YII_DEBUG ?
          'select2.full.js' : 'select2.full.min.js' ?>"></script>
<!-- InputMask -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/input-mask/<?= YII_DEBUG ?
          'jquery.inputmask.js' : 'jquery.inputmask.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/input-mask/<?= YII_DEBUG ?
          'jquery.inputmask.date.extensions.js' : 'jquery.inputmask.date.extensions.min.js' ?>"></script>
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/input-mask/<?= YII_DEBUG ?
          'jquery.inputmask.extensions.js' : 'jquery.inputmask.extensions.min.js' ?>"></script>
<!-- iCheck 1.0.1 -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/plugins/iCheck/<?= YII_DEBUG ? 'icheck.js' :
          'icheck.min.js' ?>"></script>
<!-- ChartJS -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/chart.js/<?= YII_DEBUG ?
          'Chart.js' : 'Chart.js' ?>"></script>
<? /*
<script type="text/javascript" src="<?= Yii::app()->request->baseUrl ?>/themes/<?=$module?>/bower_components/datatables.net-bs/js/<?=YII_DEBUG ? 'dataTables.bootstrap.js' : 'dataTables.bootstrap.min.js'?>"></script>
*/ ?>

<!-- AdminLTE App -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/dist/js/<?= YII_DEBUG ? 'adminlte.js' :
          'adminlte.min.js' ?>"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<? /* <script type="text/javascript" src="<?= Yii::app()->request->baseUrl ?>/themes/<?=$module?>/dist/js/pages/<?=YII_DEBUG ? 'dashboard.js' : 'dashboard.js'?>"></script> */ ?>
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/bower_components/ckeditor/<?= YII_DEBUG ?
          'ckeditor.js' : 'ckeditor.min.js' ?>"></script>
<!-- AdminLTE for demo purposes -->
<script type="text/javascript"
        src="<?= Yii::app()->request->baseUrl ?>/themes/<?= $module ?>/dist/js/<?= YII_DEBUG ? 'demo.js' :
          'demo.js' ?>"></script>
<script>
    $(function () {
        if (jQuery.support.leadingWhitespace == false) {
            alert('<?=Yii::t(
              'main',
              'Ваш браузер не поддерживает ряд необходимых для нормальной работы функций. Обновите его до последней версии.'
            )?>');
        }
    });
    //setTimeout(updateAdminNews, 60000);
    //========================
    // Back To Top
    //========================
    $(function () {
        if ($('#backToTop').length) {
            var scrollTrigger = 100, // px
                backToTop = function () {
                    var scrollTop = $(window).scrollTop();
                    if (scrollTop > scrollTrigger) {
                        $('#backToTop').addClass('showit');
                        $('#backToTop').show();
                    } else {
                        $('#backToTop').hide();
                        $('#backToTop').removeClass('showit');
                    }
                };
            backToTop();
            $(window).on('scroll', function () {
                backToTop();
            });
            $('#backToTop').on('click', function (e) {
                e.preventDefault();
                $('html,body').animate({
                    scrollTop: 0
                }, 700);
            });
        }
    });
</script>
</body>
</html>

