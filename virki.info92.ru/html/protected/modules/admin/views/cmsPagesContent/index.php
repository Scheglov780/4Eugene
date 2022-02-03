<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Контент страниц') ?>
    <small><?= Yii::t('main', 'Редактирование контента страниц') ?></small>
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
      <div class="box">
          <?php
          $this->widget(
            'booster.widgets.TbMenu',
            [
              'type'  => 'pills',
              'items' => [
                [
                  'label'       => Yii::t('main', 'Создать'),
                  'icon'        => 'fa fa-plus',
                  'url'         => 'javascript:void(0);',
                  'linkOptions' => ['onclick' => 'renderCreateForm_cmsPagesContent ()'],
                ],
                [
                  'label'       => Yii::t('main', 'Экспорт в HTML'),
                  'icon'        => 'fa fa-gears',
                  'url'         => '/' . Yii::app()->controller->module->id . '/cmsPagesContent/exportHtml',
                  'linkOptions' => [
                    'target'  => '_blank',
                    'title'   => Yii::t('main', 'Экспорт в HTML для копирайтеров')
                      ,
                    'visible' => true,
                  ],
                ],
//array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
//		array('label'=>Yii::t('main','Поиск'), 'icon'=>'fa fa-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
//		array('label'=>Yii::t('main','PDF'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
//		array('label'=>Yii::t('main','Excel'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
              ],
            ]
          );
          ?>
          <? $form = $this->beginWidget(
            'booster.widgets.TbActiveForm',
            [
              'id'                     => 'form-upload-pages-content',
              'enableAjaxValidation'   => false,
              'enableClientValidation' => false,
              'method'                 => 'post',
              'action'                 => [
                Yii::app()->createUrl(
                  '/' . Yii::app()->controller->module->id . '/cmsPagesContent/exportHtml'
                ),
              ],
              'type'                   => 'inline',
              'htmlOptions'            => [
                'class'   => 'pull-right',
                'enctype' => 'multipart/form-data',
              ],
            ]
          );
          ?>
        <div class="form-group">
          <input type="file" id="upload-pages-content" name="uploadedFile"
                 title="<?= Yii::t('main', 'Загрузить HTML') ?>" onchange="
            $('#form-upload-pages-content' ).submit();
            " accept="text/*">
        </div>
          <? $this->endWidget(); ?>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xs-12">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#tab-pages-content-tree" data-toggle="tab"><?= Yii::t(
                    'main',
                    'Структура'
                  ) ?></a></li>
          <li><a href="#tab-pages-content-table" data-toggle="tab"><?= Yii::t('main', 'Таблица') ?></a></li>
        </ul>
        <div class="tab-content">
          <div class="active tab-pane" id="tab-pages-content-tree">
              <? $this->widget(
                'ext.DVTreeGridView.DVTreeGridView',
                [
                  'id'                  => 'cms-pages-content-tree',
                  'type'                => 'bordered condensed',
                  'template'            => '{summary}{items}',
                  'treeViewOptions'     => [
                    'initialState'       => 'expanded',
                    'expandable'         => true,
                    'clickableNodeNames' => true,
                    'indent'             => 25,
                    'stringCollapse'     => Yii::t('main', 'Свернуть (двойной клик)'),
                    'stringExpand'       => Yii::t('main', 'Развернуть (двойной клик)'),
                  ],
                  'rootId'              => 1,
                  'idColumn'            => 'id',
                  'parentColumn'        => 'parent',
                  'childrenCountColumn' => 'children',
                  'dataProvider'        => CmsPages::cmsPagesDataProvider(1),
                  'initialDepth'        => 100,
                  'lazyMode'            => false,
                  'lazyNodeUrl'         => '',
                  'setParentUrl'        => '/' . Yii::app()->controller->module->id . '/cmsPages/setParent',
                  'isPartialRendering'  => false,
                  'columns'             => [
                    [
                      'name'   => 'title',
                      'header' => Yii::t('main', 'title'),
                      'type'   => 'raw',
                      'value'  => function ($data) {
                          return '<span class="tree-draggable">' .
                            ($data['title'] ? $data['title'] : $data['page_id']) .
                            '</span>';
                      },
                    ],
                    [
                      'type'  => 'raw',
                      'value' => function ($data) {
                          ?>
                        <div class="btn-group">
                          <a href="javascript:void(0);"
                             onclick="treeCommandPagesContent('top','<?= $data['id'] ?>')"
                             class="btn btn-default btn-sm" title="<?= Yii::t('main', 'На уровень выше') ?>"><i
                                class="fa fa-arrow-left"></i></a>
                          <a href="javascript:void(0);"
                             onclick="treeCommandPagesContent('up','<?= $data['id'] ?>')"
                             class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Вверх') ?>"><i
                                class="fa fa-arrow-up"></i></a>
                          <a href="javascript:void(0);"
                             onclick="treeCommandPagesContent('down','<?= $data['id'] ?>')"
                             class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Вниз') ?>"><i
                                class="fa fa-arrow-down"></i></a>
                          <a href="javascript:void(0);" onclick="updateEx('<?= $data['page_id'] ?>')"
                             class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Редактировать') ?>"><i
                                class="fa fa-pencil"></i></a>
                        </div>
                          <?
                      },
                        // 'htmlOptions' => array('style' => 'width:145px;')
                    ],
                  ],
                ]
              ); ?>
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab-pages-content-table">
              <? try { ?>
                  <?php $this->widget(
                    'booster.widgets.TbGridView',
                    [
                      'id'              => 'cms-pages-content-grid',
                      'fixedHeader'     => true,
                      'headerOffset'    => 0,
                      'dataProvider'    => $model->search(),
                      'filter'          => $model,
                      'type'            => 'striped bordered condensed',
                      'responsiveTable' => true,
                      'template'        => '{summary}{items}{pager}',
                      'columns'         => [
//		'id',
                        'page_id',
                        'lang',
                        [
                          'type'   => 'raw',
                          'filter' => false,
                          'name'   => 'content_data',
                          'value'  => function ($data) {
                              return '<code>' . Utils::textSnippet($data->content_data, 120) . '</code>';
                          },
                        ],
                        'title',
                        'description',
                        'keywords',
                        [

                          'type'  => 'raw',
                          'value' => function ($data) { ?>
                            <div class="btn-group">
                              <a href='<?= $data->link ?>' target='_blank' class='btn btn-default btn-sm'
                                 title='<?= Yii::t('main', 'Просмотр оригинала') ?>'><i
                                    class='fa fa-external-link'></i></a>
                              <a href='/<?= Yii::app(
                              )->controller->module->id ?>/cmsPagesContent/update/id/<?= $data->id ?>'
                                 onclick='getContent(this,"Page <?= addslashes(
                                   $data->page_id
                                 ) ?>",false); return false;'
                                 class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Редактировать') ?>"><i
                                    class='fa fa-pencil'></i></a>
                              <a href='javascript:void(0);'
                                 onclick='delete_recordPagesContent("<?= $data->id ?>")'
                                 class='btn btn-default btn-sm' title="<?= Yii::t('main', 'Удалить') ?>"><i
                                    class='fa fa-trash'></i></a>
                            </div>
                          <? },
                            //'htmlOptions' => array('style' => 'width:135px;')
                        ],

                      ],
                    ]
                  );
                  ?>
              <? } catch (Exception $e) {
                  CVarDumper::dump($e, 10, true);
              }
              ?>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
      <!-- /.nav-tabs-custom -->
    </div>
  </div>
  <div class="row">
    <div class="col-xs-12">
      <div class="box" id="cmsPagesContentLoader">
          <? /*TODO Сделать экшен. updateEx Не забыть id записи в хайден в форму */ ?>
          <?= Yii::t('main', 'Загрузите выбранный контент кнопкой') ?>&nbsp;
        <a href="javascript:void(0);" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i></a>
      </div>
    </div>
  </div>
    <?
    $this->renderPartial("_ajax_update");
    $this->renderPartial("_ajax_create_form", ["model" => $model]);
    //$this->renderPartial("_ajax_view");
    ?>
</section>

<?
$cs = Yii::app()->getClientScript();
$deleteMessage = Yii::t('main', 'Вы уверены, что хотите удалить эту страницу и весь её контент?');
$errorMessage = Yii::t('main', 'Ошибка удаления страницы');
$cs->registerScript(
  'cmsPagesContentServiceScript',
  <<<PAGESCONTENTSERVICESCRIPT
function treeCommandPagesContent(command,id)
    {
        var data='command='+command+'&id='+id;
        jQuery.ajax({
            type: 'POST',
            async: false,
            url: '/admin/cmsPages/treeCommand',
            data:data,
            success:function(data){
                if (id!=data) {
                switch (command) {
                    case 'top':
                    if (data!=0) {
                        $('#cms-pages-content-tree .items').treetable('move', id, data);
                        $('#cms-pages-content-tree .items').treetable('reveal', id);
                        }
                        break;
                    case 'up':
                        var node=$('tr[data-tt-id="' + id + '"]');
                        var nodeParentId = node.attr('data-tt-parent-id');
                        var nodePrev = node.prev();
                        var nodePrevId = nodePrev.attr('data-tt-id');
                        if (nodePrevId!=nodeParentId) {
                            while (nodePrev && (nodePrev.attr('data-tt-parent-id') != nodeParentId)) {
                                nodePrev = nodePrev.prev();
                            }
                            nodePrevId = nodePrev.attr('data-tt-id');
                        }

                        if (id!=nodePrevId && (nodePrev.attr('data-tt-parent-id') == nodeParentId)) {
                            $('#cms-pages-content-tree .items').treetable('collapseNode', id);
                            // $('#cms-pages-content-tree .items').treetable('unloadBranch', id);
                            node.insertBefore($('tr[data-tt-id="' + nodePrevId + '"]'));
                        }
                        break;
                    case 'down':
                        var node=$('tr[data-tt-id="' + id + '"]');
                        var nodeParentId = node.attr('data-tt-parent-id');
                        var nodeParent = $('tr[data-tt-id="' + nodeParentId + '"]');
                        var nodeParentParentId = nodeParent.attr('data-tt-parent-id');
                        var nodeNext = node.next();
                        var nodeNextId = nodeNext.attr('data-tt-id');
                        var nodeNextParentId = nodeNext.attr('data-tt-parent-id');
                        while (nodeNext && (nodeNext.attr('data-tt-parent-id') != nodeParentId)
                        && (nodeNext.attr('data-tt-parent-id') != nodeParentParentId)
                        && nodeNext.attr('data-tt-parent-id')) {
                            nodeNext = nodeNext.next();
                            nodeNextId = nodeNext.attr('data-tt-id');
                        }
                        if (id!=nodeNextId && (nodeNext.attr('data-tt-parent-id') == nodeParentId)) {
                            $('#cms-pages-content-tree .items').treetable('collapseNode', id);
                            // $('#cms-pages-content-tree .items').treetable('unloadBranch', id);
                            node.insertAfter($('tr[data-tt-id="' + nodeNextId + '"]'));
                        }
                        break;
                    default: return; break;
                }
                };
            },
            error: function(data) { // if error occured
                dsAlert(JSON.stringify(data),'Error',true);
            },
            dataType:'json'
        });
    }

function delete_recordPages(id)
{
  if(!confirm("{$deleteMessage}"))
   return;
 var data="id="+id;
  jQuery.ajax({
   type: 'POST',
    url: '/admin/cmsPages/delete',
   data:data,
    success:function(data){
         if(!data.err)
          {
             $('#cms-pages-content-tree .items').treetable('removeNode', id);
          }
         else
           alert("{$errorMessage}");
      },
   error: function(data) { // if error occured
dsAlert(JSON.stringify(data),'Error',true);
    },
  dataType:'json'
  });
}
PAGESCONTENTSERVICESCRIPT
); ?>

<script type="text/javascript">
    function updateEx(page_id) {
        //var data="page_id="+page_id;
        var url = '/<?=Yii::app()->controller->module->id?>/cmsPagesContent/updateEx' + '/page_id/' + page_id;
        jQuery.ajax({
            type: 'GET',
            url: url,
            //data:data,
            success: function (data) {
                // alert("succes:"+data);
                $('#cmsPagesContentLoader').html(data);
                $(window).scrollTop($('#cmsPagesContentLoader').offset().top);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function updateExSave() {
        var data = $('#pagesContent-ex-update-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '/<?=Yii::app()->controller->module->id?>/cmsPagesContent/updateEx',
            data: data,
            success: function (data) {
                if (data !== 'false') {
                    alert('<?=Yii::t('main', 'Данные сохранены');?>');
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function delete_recordPagesContent(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/cmsPagesContent/delete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('cms-pages-content-grid', {});
                    $.fn.yiiGridView.update('cms-pages-content-tree', {});
                } else
                    dsAlert('deletion failed', 'Error', true);
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
                alert('Error occured, please try again');
                //  alert(data);
            },
            dataType: 'html'
        });
    }
</script>