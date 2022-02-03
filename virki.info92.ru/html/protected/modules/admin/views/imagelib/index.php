<?
/**
 * @var Imagelib $model
 */
?>
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
      <?= Yii::t('main', 'Библиотека изображений') ?>
    <small><?= Yii::t('main', 'Управление библиотекой изображений') ?></small>
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
        <? $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'          => 'image-lib-search-form',
            'type'        => 'search',
            'method'      => 'post',
            'htmlOptions' => [
              'onsubmit' => "return false;",
              'class'    => 'well',
            ],
          ]
        ); ?>
      <select
          id="path"
          name="path"
          class="input-medium form-control"
          onchange="imageLibSearch();"
        <? //style="width: 20%; height: 40px !important; margin: 0.2em 1em !important; padding: 5px !important;"> ?>
        <?
        $pathes = Yii::app()->db->cache(600)->createCommand(
          "
                select * from (select DISTINCT SUBSTRING(min(ss.path), '^(.*?\/.*?)\/') as path from
(SELECT im.path FROM cms_knowledge_base_img im WHERE im.enabled=1 GROUP BY im.path) ss
UNION ALL
select DISTINCT SUBSTRING(min(ss.path), '^(.*?\/.*?\/.*?)\/') as path from
(SELECT im.path FROM cms_knowledge_base_img im WHERE im.enabled=1 GROUP BY im.path) ss
UNION ALL 
SELECT im.path FROM cms_knowledge_base_img im WHERE im.enabled=1 GROUP BY im.path) ff
-- where path !='' AND path not in (select im.path from cms_knowledge_base_img im WHERE im.enabled=1)
order by path
                "
        )->queryColumn();
        ?>
        <? if (!(isset($model->path) && $model->path)) { ?>
          <option selected value=""><?= Yii::t('main', 'Все категории') ?></option>
        <? } ?>
        <?
        foreach ($pathes as $path) {
            ?>
          <option <?= ((isset($model->path) && $model->path && $model->path == $path) ? 'selected ' : '') ?>
              value="<?= urlencode($path) ?>"><?= $path ?></option>
        <? } ?>
      </select>
      <input type="text"
             value="<?= (isset($model->query) && ($model->query)) ? $model->query : '' ?>"
             placeholder="<?= Yii::t('main', 'Введите строку для поиска') ?>" id="query"
             name="query"
             class="input-medium form-control"
             style="width: 50%; height: 40px !important; margin: 0.2em 1em !important; padding: 5px !important;">
        <?
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'ajax',
            'id'          => 'image-lib-search-button',
            'type'        => 'info',
            'icon'        => 'ok white',
            'label'       => Yii::t('main', 'Поиск'),
            'htmlOptions' => [
              'onclick' => 'imageLibSearch();',
            ],
          ]
        );
        $this->endWidget();
        ?>
    </div>
  </div>

    <?
    Yii::app()->clientScript->registerScript(
      'image-lib-search-script',
      "
$('#query').keyup(function(event){
    if(event.keyCode == 13){
        imageLibSearch();
    }
});
  
function imageLibSearch(){
    var ajaxUrl = '" . Yii::app()->request->requestUri . "';
    var ajaxRequest = $('#image-lib-search-form').serialize();
            $.fn.yiiListView.update(
// this is the id of the CListView
                'image-lib-view',
                {
                type:'GET',
                url:ajaxUrl,
                data: ajaxRequest
                }
            ) 
}
"
    );
    ?>
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><?= Yii::t('main', 'Список изображений библиотеки') ?></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <? $this->widget(
              'booster.widgets.TbListView',
              [
                'id'              => 'image-lib-view',
                'dataProvider'    => $model->search(120),
                'itemView'        => 'application.modules.' .
                  Yii::app()->controller->module->id .
                  '.views.imagelib.item',
                'enableSorting'   => false,
                'template'        => '{summarypager}{items}{pager}',
                'itemsCssClass'   => 'store-products-list',
//    'pager'         => false,
                'afterAjaxUpdate' => "function () {
                                             $('img.lazy').show().lazyload({                                           
                                             effect: 'fadeIn',
                                             effect_speed: 50,
                                             container : $('#image-lib-view').closest('div[class^=\"ui-tabs-panel\"]'),
                                             skip_invisible: true,
                                             threshold: 200
                                             });}",
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
</section>
<!-- /.content -->
<script type="text/javascript">
    function delete_record_imagelib(id) {

        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/imagelib/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data === 'true') {
                    $.fn.yiiGridView.update('image-lib-grid', {});
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

<script>
    //ui-tabs-panel
    $('img.lazy').show().lazyload({
        effect: 'fadeIn',
        effect_speed: 50,
        container: $('#image-lib-view').closest('div[class^="ui-tabs-panel"]'),
        skip_invisible: true,
        threshold: 200
    });
</script>
