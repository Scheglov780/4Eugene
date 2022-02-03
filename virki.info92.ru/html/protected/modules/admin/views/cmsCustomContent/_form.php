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
            'id'                   => 'cms-custom-content-form-' . (($model->id) ? $model->id : $model->content_id),
            'enableAjaxValidation' => false,
            'method'               => 'post',
            'action'               => ['/' . Yii::app()->controller->module->id . '/cmsCustomContent/update'],
            'type'                 => 'vertical',
            'htmlOptions'          => [
              'enctype' => 'multipart/form-data',
            ],
          ]
        ); ?>
      <div class="box-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'content_id'); ?>
          <?php echo $form->dropDownListRow(
            $model,
            'lang',
            [
              'widgetOptions' => [
                'data' => cms::getLangList(),
                  //'htmlOptions' => $htmlOptions
              ],
            ]
          ); ?>
          <?php echo $form->checkBoxRow($model, 'enabled'); ?>
          <? $site_default_texteditor = DSConfig::getVal('site_default_texteditor');
          if (in_array($site_default_texteditor, ['elrte', 'tiny'])) { ?>
            <div class="form-group">
                <? echo $form->labelEx($model, 'content_data'); ?>
                <?
                $editor = new SRichTextarea();
                $editor->init();
                $editor->model = $model;
                $editor->attribute = 'content_data';
                $editor->htmlOptions = ['class' => 'form-control'];
                $editor->run(true);
                ?>
            </div>
          <? } else { ?>
            <div class="form-group">
                <? echo $form->labelEx($model, 'content_data'); ?>
                <? echo $form->textArea(
                  $model,
                  'content_data',
                  ['id' => 'cmsContentDataUpdate' . $model->id]
                ); ?>
            </div>
            <script>
                if (cmsContentDataUpdateVar<?=$model->id?> != undefined) {
                    cmsContentDataUpdateVar<?=$model->id?>.toTextArea();
                }
                var cmsContentDataUpdateVar<?=$model->id?> = CodeMirror.fromTextArea(
                    document.getElementById('cmsContentDataUpdate<?=$model->id?>')
                    , {
                        //lineNumbers: true,
                        mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                        matchBrackets: true,
                    });
                cmsContentDataUpdateVar<?=$model->id?>.setSize(null, 500);
                cmsContentDataUpdateVar<?=$model->id?>.refresh();
            </script>
          <? } ?>
      </div>
      <div class="box-footer">
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'info',
              'size'        => 'mini',
              'icon'        => 'ok white',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t(
                'main',
                'Сохранить'
              ),
              'htmlOptions' => [
                'class'   => 'pull-right',
                'onclick' => "if (typeof cmsContentDataUpdateVar{$model->id} !== 'undefined') {cmsContentDataUpdateVar{$model->id}.save();} saveForm('cms-custom-content-form-" .
                  (($model->id) ? $model->id : $model->content_id) .
                  "'); return false;",
              ],
            ]
          ); ?>
          <? $this->widget(
            'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.CmsHistoryBlock',
            [
              'id'        => 'cms_custom_content_content-' . urlencode($model->content_id),
              'tableName' => 'cms_custom_content',
              'contentId' => $model->content_id,
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
      <div id="cms-custom-content-filemanager-<?= $model->id ?>" class="box-body">
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
        $('#cms-custom-content-filemanager-<?=$model->id?>').elfinder({
            url: '/'.Yii::app()
    ->
        controller->module->id.
        '/fileman/index'  // connector URL (REQUIRED)
            // , lang: 'ru'                    // language (OPTIONAL)
            , resizable;
    :
        false
            , height;
    :
        '400px'
            //, width: '83%'
            , showFiles;
    :
        '2';
    })
        ;
    });
</script>