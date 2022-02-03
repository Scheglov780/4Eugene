<div class="modal fade" id="cms-pages-content-create-modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?= Yii::t('main', 'Новый контент страницы') ?></h4>
      </div>
        <?php
        /** @var TbActiveForm $form */
        $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                     => 'cms-pages-content-create-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["cmsPagesContent/create"],
            'type'                   => 'horizontal',
            'htmlOptions'            => [
              'onsubmit' => "return false;",/* Disable normal form submit */
            ],
            'clientOptions'          => [
              'validateOnType'   => true,
              'validateOnSubmit' => true,
              'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {    
                                          create_cmsPagesContent ();
                                        }
                                     }',
            ],
          ]
        ); ?>
      <div class="modal-body">
        <div class="box">
          <div class="box-body">
              <?php echo $form->errorSummary($model); ?>
              <?
              $pages = Yii::app()->db->createCommand(
                "select cp.page_id from cms_pages cp order by cp.page_id"
              )->queryColumn();
              $pageFilter = [];
              if ($pages) {
                  foreach ($pages as $page) {
                      $pageFilter[$page] = $page;
                  }
              }
              ?>
              <?php echo $form->dropDownListRow(
                $model,
                'page_id',
                [
                  'widgetOptions' => [
                    'data' => $pageFilter,
                      //'htmlOptions' => $htmlOptions
                  ],
                ]
              );
              ?>
              <?php echo $form->textAreaRow($model, 'content_data'); ?>
              <?php echo $form->textFieldRow($model, 'lang'); ?>
              <?php echo $form->textAreaRow($model, 'description'); ?>
              <?php echo $form->textFieldRow($model, 'title'); ?>
              <?php echo $form->textAreaRow($model, 'keywords'); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'default',
                //'size'        => 'mini',
              'icon'        => 'fa fa-check',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
              'htmlOptions' => ['onclick' => 'create_cmsPagesContent ();'],
            ]
          );
          ?>
          <?
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
                //'id'=>'sub2',
              'type'        => 'default',
              'icon'        => 'fa fa-close', //fa-inverse
              'label'       => Yii::t('main', 'Отмена'),
              'htmlOptions' => ['data-dismiss' => 'modal'],
            ]
          );
          ?>
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'type'        => 'default',
                //'size'       => 'mini',
              'icon'        => 'fa fa-rotate-left',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
  </div>
</div>
<!--Script section-->
<script type="text/javascript">
    function create_cmsPagesContent() {
        var data = $('#cms-pages-content-create-form').serialize();
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . "/cmsPagesContent/create"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#cms-pages-content-create-modal').modal('hide');
                    $.fn.yiiGridView.update('cms-pages-content-grid', {});
                    $.fn.yiiGridView.update('cms-pages-content-tree', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert(JSON.stringify(data), 'Error', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateForm_cmsPagesContent() {
        $('#cms-pages-content-create-form').each(function () {
            this.reset();
        });
        $('#cms-pages-content-create-modal').modal('show');
    }
</script>
