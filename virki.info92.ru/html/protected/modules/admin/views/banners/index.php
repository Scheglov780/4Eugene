<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>

<?php
// Elfinder
$assetsUrl = Yii::app()->getAssetManager()->publish(
  Yii::getPathOfAlias('ext.elrte.lib'),
  false,
  -1,
  YII_DEBUG
);
$basePath = Yii::getPathOfAlias('webroot') . $assetsUrl;
$cs = Yii::app()->clientScript;
$cs->registerCssFile($assetsUrl . '/elfinder/css/elfinder.min.css');
$cs->registerCssFile($assetsUrl . '/elfinder/css/theme.css');
$cs->registerScriptFile($assetsUrl . '/elfinder/js/elfinder.min.js');
$basePath = Yii::getPathOfAlias('webroot') . $assetsUrl;
if (file_exists($basePath . '/elfinder/js/i18n/elfinder.' . Utils::appLang() . '.js')) {
    $cs->registerScriptFile(
      $assetsUrl . '/elfinder/js/i18n/elfinder.' . Utils::appLang() . '.js',
      null,
      ['charset' => 'utf-8']
    );
}

?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Баннеры') ?>
    <small><?= Yii::t('main', 'Управление слайдами') ?></small>
  </h1>
    <? /*
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">UI</a></li>
            <li class="active">Buttons</li>
        </ol>
        */ ?>
</section>
<!-- Main content -->
<section class="content">
  <div class="row">
    <div class="col-xs-12">

        <?php
        $this->widget(
          'booster.widgets.TbMenu',
          [
            'type'  => 'pills',
            'items' => [
              [
                'label'       => Yii::t('main', 'Новый'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_banners ()'],
              ],
            ],
          ]
        );

        ?>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список слайдов') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>

            <?php
            $theme = Yii::app()->request->baseUrl . '/themes/' . Yii::app()->theme->name;
            $this->widget(
              'booster.widgets.TbGridView',
              [
                'id'              => 'banners-grid',
                'fixedHeader'     => true,
                'headerOffset'    => 0,
                'dataProvider'    => $model->search(),
                'type'            => 'striped bordered condensed',
                'template'        => '{summary}{items}{pager}',
                'responsiveTable' => true,
                'columns'         => [
                  [
                    'name'  => 'image',
                    'type'  => 'html',
                    'value' => function ($data) {
                        $result = Yii::t('main', 'Нет кода и изображения');
                        $imgSrc = '';
                        if ($data->html_content) {
//====================
                            $content = cms::render($data->html_content);
                            if (preg_match('/data\-iview:image\s*=\s*[\'"](.+?)[\'"]/is', $content, $matches)) {
                                $imgSrc = $matches[1];
                            }
//====================
                        } else {
                            $imgSrc = $data->img_src;
                        }
                        if ($imgSrc) {
                            if (preg_match("/^http/", $data->img_src)) {
                                $src = $imgSrc;
                            } else {
                                if (!preg_match('/^[\/]*themes\//is', $imgSrc)) {
                                    $src = Yii::app()->createAbsoluteUrl(
                                      Yii::app()->request->baseUrl .
                                      '/themes/' .
                                      ($data->front_theme ? $data->front_theme : DSConfig::getVal(
                                        "site_front_theme"
                                      )) .
                                      $imgSrc
                                    );
                                } else {
                                    $src = Yii::app()->createAbsoluteUrl($imgSrc);
                                }
                            }
                            $src = preg_replace(
                              '/\/(?:' . str_replace(
                                ',',
                                '|',
                                DSConfig::getVal('site_language_supported')
                              ) . ')\//i',
                              '/',
                              $src
                            );
                            $srcUrlHeader = get_headers($src);
                            if ((is_array(
                                  $srcUrlHeader
                                ) && isset($srcUrlHeader[0]) && $srcUrlHeader[0] == 'HTTP/1.1 404 Not Found')
                              || !$srcUrlHeader) {
                                $result = Yii::t('main', 'Неправильная ссылка на изображение');
                            } else {
                                $result = CHtml::image($src, "", ["style" => "height:70px"]);
                            }

                        }
                        return $result;
                    },
                  ],
                  'front_theme',
                  [
                    'name'  => 'img_src',
                    'type'  => 'raw',
                    'value' => function ($data) {
                        if ($data->img_src) {
                            $path =
                              ((preg_match("/^http/", $data->img_src)) ? $data->img_src :
                                Yii::app()->request->baseUrl .
                                "/themes/" .
                                ($data->front_theme ? $data->front_theme : DSConfig::getVal(
                                  "site_front_theme"
                                )) .
                                $data->img_src);
                            return "<a href='{$path}' target='_blank'>{$path}</a>";
                        }
                    },
                  ],
                  [
                    'name'   => 'img_params',
                    'header' => Yii::t('main', 'Параметры изображения'),
                    'type'   => 'raw',
                    'value'  => function ($data) {
                        if ($data->img_src) {
                            $path =
                              Yii::app()->basePath .
                              "/../themes/" .
                              ($data->front_theme ? $data->front_theme : DSConfig::getVal(
                                "site_front_theme"
                              )) .
                              $data->img_src;
                            if (file_exists($path) && !is_dir($path)) {
                                $imageinfo = [];
                                $size = getimagesize($path, $imageinfo);
                                return $size[3] . ' bits: ' . $size['bits'];
                            } else {
                                return Yii::t('main', 'Файл изображения не найден: ') . $path;
                            }
                        } else {
                            return Yii::t('main', 'Bootstrap HTML');
                        }

                    },
                  ],
                  [
                    'name'  => 'href',
                    'type'  => 'raw',
                    'value' => function ($data) {
                        return CHtml::link($data->href, [$data->href], ['target' => '_blank']);
                    },
                  ],
                  'title',
                  'banner_order',
                  [
                    'name'           => 'enabled',
                    'class'          => 'CCheckBoxColumn',
                    'checked'        => '$data->enabled==1',
                    'header'         => Yii::t('main', 'Вкл.'),
                      //'disabled'=>'true',
                    'selectableRows' => 0,
                  ],
                  [
                    'type'  => 'raw',
                    'value' => '"
		      <div class=\"btn-group\">
		      <a href=\'javascript:void(0);\' onclick=\'renderUpdateForm_banners (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-pencil\'></i></a>
		      <a href=\'javascript:void(0);\' onclick=\'duplicate_record_banners (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-copy\'></i></a>
              <a href=\'javascript:void(0);\' onclick=\'delete_record_banners (".$data->id.")\'   class=\'btn btn-default btn-sm\'  ><i class=\'fa fa-trash\'></i></a>
              </div>		      
		     "',
//        'htmlOptions' => array('style' => 'width:70px;')
                  ],

                ],
              ]
            );

            $this->renderPartial("_ajax_update");
            $this->renderPartial("_ajax_create_form", ["model" => $model]);
            //$this->renderPartial("_ajax_view");

            ?>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div id="banners-filemanager" class="box-body">
        </div>
      </div>
    </div>
  </div>
</section>
<!-- /.content -->
<script type="text/javascript" charset="utf-8">
    <? $elfinderUrl = '/' . Yii::app()->controller->module->id . '/fileman/index?path=' . urlencode(
        Yii::getPathOfAlias('webroot') . '/themes/' . DSConfig::getVal('site_front_theme') . '/images/banners'
      )
      . '&url=' . urlencode('/themes/' . DSConfig::getVal('site_front_theme') . '/images/banners');
    ?>
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $(document).ready(function () {
        $('#banners-filemanager').elfinder({
            url: '<?=$elfinderUrl;?>'  // connector URL (REQUIRED)
            , lang: '<?=Utils::appLang()?>'                    // language (OPTIONAL)
            , resizable: false
            , height: '400px'
            , width: '100%'
            , showFiles: '2'
        });
    });
</script>

<script type="text/javascript">
    function duplicate_record_banners(id) {
        if (!confirm("<?=Yii::t('main', 'Создать копию банера?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/banners/duplicate"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('banners-grid', {});
                } else
                    alert('duplicate failed');
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });
    }

    function delete_record_banners(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/banners/delete"); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('banners-grid', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },

            dataType: 'html'
        });

    }
</script>


 

