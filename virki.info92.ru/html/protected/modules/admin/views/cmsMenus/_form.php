<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_form.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="row">
  <div class="col-md-12">
    <div class="box">
        <? /** @var TbActiveForm $form */ ?>
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                   => 'cms-menus-form-' . $model->id,
            'enableAjaxValidation' => false,
            'method'               => 'post',
            'type'                 => 'vertical',
            'htmlOptions'          => [
              'enctype' => 'multipart/form-data',
            ],
          ]
        ); ?>
      <div class="box-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'menu_id'); ?>
          <?php echo $form->checkBoxRow($model, 'enabled'); ?>
          <?php echo $form->checkBoxRow($model, 'SEO'); ?>
          <?php echo $form->textAreaRow(
            $model,
            'menu_data',
            ['id' => 'cmsMenuMenuDataUpdate' . $model->id]
          ); ?>
        <script>
            if (cmsMenuMenuDataUpdateVar<?=$model->id?> != undefined) {
                cmsMenuMenuDataUpdateVar<?=$model->id?>.toTextArea();
            }
            var cmsMenuMenuDataUpdateVar<?=$model->id?> = CodeMirror.fromTextArea(
                document.getElementById('cmsMenuMenuDataUpdate<?=$model->id?>')
                , {
                    //lineNumbers: true,
                    mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            cmsMenuMenuDataUpdateVar<?=$model->id?>.setSize(null, 500);
            cmsMenuMenuDataUpdateVar<?=$model->id?>.refresh();
        </script>
      </div>
      <div class="box-footer">
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'info',
              'size'        => 'mini',
              'icon'        => 'ok white',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => [
                'class'   => 'pull-right',
                'onclick' => "if (typeof cmsMenuMenuDataUpdateVar{$model->id} !== 'undefined') {cmsMenuMenuDataUpdateVar{$model->id}.save();} saveForm('cms-menus-form-" .
                  (($model->id) ? $model->id : $model->menu_id) .
                  "'); return false;",
              ],
            ]
          ); ?>
          <? $this->widget(
            'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.CmsHistoryBlock',
            [
              'id'        => 'cms_menus_content-' . urlencode($model->menu_id),
              'tableName' => 'cms_menus',
              'contentId' => $model->menu_id,
              'pageSize'  => 10,
            ]
          );
          ?>
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType' => 'reset',
              'type'       => 'danger',
              'size'       => 'mini',
              'icon'       => 'remove white',
              'label'      => Yii::t('main', 'Сброс'),
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <div class="box">
      <div id="cms-menu-content-filemanager-<?= $model->id ?>" class="box-body">
      </div>
    </div>
  </div>
</div>
<? // Elfinder
$assetsUrl = Yii::app()->getAssetManager()->publish(
  Yii::getPathOfAlias('ext.elrte.lib'),
  false,
  -1,
  YII_DEBUG
);
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
<script type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $(document).ready(function () {
        $('#cms-menu-content-filemanager-<?=$model->id?>').elfinder({
            url: '/<?=Yii::app()->controller->module->id?>/fileman/index'  // connector URL (REQUIRED)
            // , lang: 'ru'                    // language (OPTIONAL)
            , resizable: false
            , height: '400px'
            //, width: '83%'
            , showFiles: '2'
        });
    });
</script>


