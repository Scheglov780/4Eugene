<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
      <?= Yii::t('main', 'Страницы') ?>
    <small><?= Yii::t('main', 'Редактирование ссылок на страницы фронта') ?></small>
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
                'label'       => Yii::t('main', 'Создать'),
                'icon'        => 'fa fa-plus',
                'url'         => 'javascript:void(0);',
                'linkOptions' => ['onclick' => 'renderCreateForm_cmsPages ()'],
              ],
                //array('label'=>Yii::t('main','Список'), 'icon'=>'fa fa-th-list', 'url'=>Yii::app()->controller->createUrl('index'),'active'=>true, 'linkOptions'=>array()),
//		array('label'=>Yii::t('main','Поиск'), 'icon'=>'fa fa-search', 'url'=>'#', 'linkOptions'=>array('class'=>'search-button')),
//		array('label'=>Yii::t('main','PDF'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GeneratePdf'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
//		array('label'=>Yii::t('main','Excel'), 'icon'=>'fa fa-download', 'url'=>Yii::app()->controller->createUrl('GenerateExcel'), 'linkOptions'=>array('target'=>'_blank'), 'visible'=>true),
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
          <h3 class="box-title"><?= Yii::t('main', 'Список ссылок на страницы фронта') ?> <small><?= Yii::t(
                    'main',
                    'Вы можете использовать мышь для перетаскивания'
                  ) ?></small></h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body"> <? /* pre-x-scrollable */ ?>
            <?php
            $this->widget(
              'ext.DVTreeGridView.DVTreeGridView',
              [
                'id'                  => 'cms-pages-grid',
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
                        return '<span class="tree-draggable">' . $data['title'] . '</span>';
                    },
                  ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        ?>
                      <div class="btn-group">
                        <a href="javascript:void(0);" onclick="treeCommandPages('top','<?= $data['id'] ?>')"
                           class="btn btn-default btn-sm" title="<?= Yii::t('main', 'На уровень выше') ?>"><i
                              class="fa fa-arrow-left"></i></a>
                        <a href="javascript:void(0);" onclick="treeCommandPages('up','<?= $data['id'] ?>')"
                           class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Вверх') ?>"><i
                              class="fa fa-arrow-up"></i></a>
                        <a href="javascript:void(0);" onclick="treeCommandPages('down','<?= $data['id'] ?>')"
                           class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Вниз') ?>"><i
                              class="fa fa-arrow-down"></i></a>
                      </div>
                        <?
                    },
                      //'htmlOptions' => array('style' => 'width:135px;')
                  ],
                [
                  'name'   => 'page_id',
                  'header' => Yii::t('main', 'ID страницы'),
                  'type'   => 'raw',
                  'value'  => function ($data) {
                      return $data['page_id'];
                  },
                ],
                [
                  'name'   => 'content',
                  'header' => Yii::t('main', 'Контент'),
                  'type'   => 'raw',
                  'value'  => function ($data) {
                      $result = '';
                      $contents = explode(',', $data['content']);
                      if (is_array($contents)) {
                          foreach ($contents as $i => $content) {
                              $content_data = explode('-', $content);
                              if (is_array($content_data) && count($content_data) == 2) {
                                  $content_id = $content_data[0];
                                  $content_label = $content_data[1];
                                  $result = $result . '&nbsp;<a href="' . Yii::app()->createUrl(
                                      '/' . Yii::app()->controller->module->id . '/cmsPagesContent/update',
                                      ['id' => $content_id]
                                    ) . '" title="' . Yii::t(
                                      'main',
                                      'Редактирование страницы'
                                    ) . '" onclick="getContent(this,\'' . Yii::t(
                                      'main',
                                      'Страница '
                                    ) . addslashes($content_id) . '\',false);return false;">' . $content_label . '</a>';
                              }
                          }
                      }
                      return $result;
                      //return CHtml::link('/article/'.$data['url'],Yii::app()->createUrl('/article/'.$data['url']),array('target'=>'_blank'));
                  },
                ],
                [
                  'name'  => 'url',
                  'type'  => 'raw',
                  'value' => function ($data) {
                      return CHtml::link(
                        '/article/' . $data['url'],
                        Yii::app()->createUrl('/article/' . $data['url']),
                        ['target' => '_blank']
                      );
                  },
                    /*
                    'value'  => function ($data) {
                                        return CHtml::link(
                                          $data['url'],
                                          Yii::app()->createUrl('/category/' . $data['url']),
                                          array('target' => '_blank')
                                        );
                                    }
                    */
                ],
                [
                  'name'           => 'enabled',
                  'class'          => 'CCheckBoxColumn',
                  'checked'        => '$data["enabled"]==1',
                  'header'         => Yii::t('main', 'Вкл.'),
                    //'disabled'=>'true',
                  'selectableRows' => 0,
                ],
                [
                  'name'           => 'SEO',
                  'header'         => Yii::t('main', 'SEO'),
                  'class'          => 'CCheckBoxColumn',
                  'checked'        => '$data["SEO"]==1',
                    //'disabled'=>'true',
                  'selectableRows' => 0,
                ],
                  [
                    'type'  => 'raw',
                    'value' => function ($data) {
                        ?>
                      <a href="javascript:void(0);" onclick="renderUpdateFormPages('<?= $data['id'] ?>')"
                         class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Редактировать') ?>"><i
                            class="fa fa-pencil"></i></a>
                      <a href="javascript:void(0);" onclick="delete_recordPages('<?= $data['id'] ?>')"
                         class="btn btn-default btn-sm" title="<?= Yii::t('main', 'Удалить') ?>"><i
                            class="fa fa-trash"></i></a>
                        <?
                    },
                      // 'htmlOptions' => array('style' => 'width:90px;')
                  ],
                ],
              ]
            );

            $this->renderPartial("_ajax_update");
            $this->renderPartial("_ajax_create_form", ["model" => $model]);
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
<?
$cs = Yii::app()->getClientScript();
$deleteMessage = Yii::t('main', 'Вы уверены, что хотите удалить эту страницу и весь её контент?');
$errorMessage = Yii::t('main', 'Ошибка удаления страницы');
$cs->registerScript(
  'cmsPagesServiceScript',
  <<<PAGESSERVICESCRIPT
function treeCommandPages(command,id)
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
                        $('#cms-pages-grid .items').treetable('move', id, data);
                        $('#cms-pages-grid .items').treetable('reveal', id);
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
                            $('#cms-pages-grid .items').treetable('collapseNode', id);
                            // $('#cms-pages-grid .items').treetable('unloadBranch', id);
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
                            $('#cms-pages-grid .items').treetable('collapseNode', id);
                            // $('#cms-pages-grid .items').treetable('unloadBranch', id);
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
             $('#cms-pages-grid .items').treetable('removeNode', id);
          }
         else
           dsAlert("{$errorMessage}",'Error',true);
      },
   error: function(data) { // if error occured
           dsAlert(JSON.stringify(data),'Error',true);
    },
  dataType:'json'
  });
}
PAGESSERVICESCRIPT
); ?>


