<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title"><?= Yii::t('main', 'Список категорий блогов') ?></h3>
      </div>
      <div class="box-body">
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
                  'linkOptions' => ['onclick' => 'renderCreateBlogCategoriesForm()'],
                ],
              ],
            ]
          );
          ?>
          <?php $this->widget(
            'booster.widgets.TbGridView',
            [
              'id'              => 'blog-categories-grid',
              'fixedHeader'     => true,
              'headerOffset'    => 0,
              'dataProvider'    => $model->search(),
              'type'            => 'striped bordered condensed',
              'template'        => '{summarypager}{items}{pager}',
              'responsiveTable' => true,
              'columns'         => [
                [
                  'name'   => 'id',
                  'header' => Yii::t('main', 'ID'),
                ],
                'name',
                'description',
                'lastActivityDate',
                'postsCount',
                'commentsCount',
                'authorsCount',
                [
                  'name'           => 'enabled',
                  'class'          => 'CCheckBoxColumn',
                  'checked'        => '$data->enabled==1',
                  'header'         => Yii::t('main', 'Вкл.'),
                    //'disabled'=>'true',
                  'selectableRows' => 0,
                ],
                [

                  'type'        => 'raw',
                  'value'       => function ($data) { ?>
                    <div class="btn-group">
                      <a href='javascript:void(0);' onclick='renderUpdateBlogCategoriesForm(<?= $data->id ?>)'
                         class='btn btn-default btn-sm'><i class='fa fa-pencil'></i></a>
                      <a href='javascript:void(0);' onclick='deleteBlogCategoriesRecord(<?= $data->id ?>)'
                         class='btn btn-default btn-sm'><i class='fa fa-trash'></i></a>
                    </div>
                  <? },
                  'htmlOptions' => ['style' => 'width:100px;'],
                ],

              ],
            ]
          );
          $this->render($this->_viewPath . '._categories_ajax_update');
          $this->render($this->_viewPath . '._categories_ajax_create_form', ["model" => $model]);
          ?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    function deleteBlogCategoriesRecord(id) {
        if (!confirm("<?=Yii::t('main', 'Вы уверены, что хотите удалить эту запись?')?>"))
            return;
        var data = 'id=' + id;
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl(
              Yii::app()->controller->module->id . "/blogs/categoriesDelete"
            ); ?>',
            data: data,
            success: function (data) {
                if (data == 'true') {
                    $.fn.yiiGridView.update('blog-categories-grid', {});
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