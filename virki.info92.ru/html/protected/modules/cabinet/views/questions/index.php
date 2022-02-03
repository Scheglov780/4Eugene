<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Вопросы') ?>
    <small><?= Yii::t('main', 'Обратная связь с клиентами, служба поддержки') ?></small>
      <?= Utils::getHelp('index', true) ?>
  </h1>
    <? /*
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">Buttons</li>
        </ol>
        */ ?>
</section>
<div class="row">
  <div class="col-md-12">
    <div class="box box-default collapsed-box">
      <div class="box-header with-border">
        <h3 class="box-title" data-widget="collapse">Черновики для разработчиков</h3>

        <div class="box-tools pull-right">
          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
          </button>
        </div>
        <!-- /.box-tools -->
      </div>
      <!-- /.box-header -->
      <div class="box-body" style="display: none;">
        <img class="img-responsive pad" src="/images/TZ/010-struktura-dispetcherskaya.jpg">
      </div>
      <!-- /.box-body -->
    </div>
  </div>
</div>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список вопросов в службу поддержки') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <? $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'question-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                  //'scrollableArea' =>'.pre-scrollable',
                'dataProvider'    => $model->search(),
                'filter'          => $model,
                'type'            => 'striped bordered condensed',
                'template'        => '{summarypager}{items}{pager}',
                'summaryText'     => Yii::t('main', 'Обращения') .
                  ' {start}-{end} ' .
                  Yii::t('main', 'из') .
                  ' {count}',
                'responsiveTable' => true,
                'columns'         => [
                  [

                    'type'  => 'raw',
                    'value' => function ($data) {
                        $res = "
            <div class=\"btn-group\">
            <a href='" .
                          Yii::app()->createUrl(
                            '/' . Yii::app()->controller->module->id . '/questions/view',
                            ['id' => $data->id]
                          ) .
                          "'
                 onclick='getContent(this,\"" .
                          addslashes(Yii::t('main', 'Вопрос') . " №" . $data->id) .
                          "\",false); return false;'
                 class='btn btn-default btn-sm'><i class='fa fa-folder-open'></i></a>
                 </div>";
                        return $res;
                    },
//  <a href=\'javascript:void(0);\' onclick=\'renderUpdateForm_questions (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
//  <a href=\'javascript:void(0);\' onclick=\'delete_record_questions (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
                  ],

                  [
                    'name'  => 'id',
                    'type'  => 'raw', //$model->id
                    'value' => '\'<i class="fa fa-comments-o"></i>\'.CHtml::link("Q0000".$data->id, array("/' .
                      Yii::app()->controller->module->id .
                      '/support/view", "id"=>$data->id))',
                  ],
                  [
                    'type'   => 'raw',
                    'filter' => false,
                    'name'   => 'email',
                    'value'  => function ($data) {
                        $user = Users::model()->findByPk($data->uid);
                        if ($user) {
                            if ($data->uid == 0 && ($data->email != $user->email)) {
                                if ($data->email) {
                                    echo '<i class="fa fa-comment-o" style="color:blue;"></i>' .
                                      $data->email .
                                      ' (' .
                                      Yii::t(
                                        'main',
                                        'гость'
                                      ) .
                                      ')';
                                } else {
                                    echo '<i class="fa fa-bug" style="color:red;"></i>' . Yii::t('main', 'Неизвестный');
                                }
                            } else {
                                echo '<i class="fa fa-user"  style="color:green;"></i>' . CHtml::link(
                                    (isset($data->u->email) ? $data->u->email : ''),
                                    ["profile/view", "id" => $data->uid],
                                    [
                                      "title"   => Yii::t('main', "Профиль пользователя"),
                                      "onclick" => "getContent(this,\"" .
                                        addslashes($data->u->email) .
                                        "\",false);return false;",
                                    ]
                                  );
                            }
                        } else {
                            echo '<i class="fa fa-bug"  style="color:red;"></i>' . Yii::t('main', 'Неизвестный');
                        }
                    },

                  ],
                  [
                    'name'   => 'category',
                    'filter' => [
                      1 => Yii::t('main', 'Общие вопросы'),
                      2 => Yii::t('main', 'Вопросы по моему заказу'),
                      3 => Yii::t('main', 'Рекламация'),
                      4 => Yii::t('main', 'Возврат денег'),
                      5 => Yii::t('main', 'Оптовые заказы'),
                    ],
                    'value'  => '$data->text_category',
                  ],
                  'theme',
                  [
                    'name'  => 'date',
                    'type'  => 'raw',
                    'value' => 'date("d.m.Y H:i",$data->date)',
                  ],
                  [
                    'name'  => 'date_change',
                    'type'  => 'raw',
                    'value' => '$data->date_change!=null ? date("d.m.Y H:i",$data->date_change) : date("d.m.Y H:i",$data->date)',
                  ],
                  [
                    'name'   => 'status',
                    'filter' => [
                      1 => Yii::t('main', 'На рассмотрении'),
                      2 => Yii::t('main', 'Получен ответ'),
                      3 => Yii::t('main', 'Закрыто'),
                    ],
                    'value'  => '$data->status_name',
                  ],
                ],
              ]
            );
            ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
<!-- /.content -->
