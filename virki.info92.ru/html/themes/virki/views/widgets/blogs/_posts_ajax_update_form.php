<?
/**
 * @var CActiveForm $form
 */
?>
<? $this->beginWidget(
  'booster.widgets.TbModal',
  [
    'id' => 'blog-posts-update-modal',
      /*
      'scriptFile' => false,
  // additional javascript options for the dialog plugin
      'options' => array(
        'title'     => Yii::t('main', 'Сообщение') . ' #' . $model->id,
        'autoOpen'  => false,
        'modal'     => true,
        'resizable' => true,
        'width'     => '975',
        'height'    => '666',
          //'htmlOptions' => array('width'=>'975px','height'=>'545px'),
      ),
      */
  ]
);
?>
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h4 class="modal-title" id="blog-posts-update-modal"><?= Yii::t('main', 'Редактирование статьи') ?></h4>
  </div><!--End:Modal-header-->
  <div class="modal-body">

    <div class="post-update-modal-header">
        <? $form = $this->beginWidget(
          'CActiveForm',
          [
            'id'                     => 'blog-posts-update-form',
            'enableAjaxValidation'   => false,
            'enableClientValidation' => false,
            'method'                 => 'post',
            'action'                 => ["/blog/postsUpdate"],
            'htmlOptions'            => [
              'onsubmit' => "return false;", // Disable normal form submit
            ],
          ]
        ); ?>
        <?= $form->errorSummary(
          $model,
          'Opps!!!',
          null,
          ['class' => 'alert alert-error']
        ); ?>
      <div style="display: inline" class="form-group">
          <?= $form->hiddenField($model, 'id', []); ?>
        <div style="display: inline"><input type="hidden" name="BlogPosts[uid]" value="<?= $model->uid ?>">
        </div>
          <? $user = Users::model()->findByPkEx($model->uid) ?>
        <div><label><?= Yii::t('main', 'Автор') ?></label></div>
        <div style="display: inline;"><input class='form-control input3' type="text" name="user_name" readonly
                                             value="<?= ($user ? $user->email : '-'); ?>" style="cursor: none;">
        </div>
      </div>
      <br/>
      <div style="display: inline">
        <div style="display:inline;"><label><?= Yii::t('main', 'Категория') ?></label></div>
        <div style="display: inline">
            <?
            $blogCategories = BlogCategories::model()->findAll('enabled=1');
            $filter = [];
            if ($blogCategories) {
                foreach ($blogCategories as $category) {
                    if (Blogs::checkAccessByCategory($category['access_rights_post'])) {
                        $filter[$category['id']] = $category['name'];
                    }
                }
            }
            ?>
        </div>
        <div style="display: inline">
            <?= $form->dropDownList(
              $model,
              'category_id',
              $filter,
              ['class' => 'form-control input3', 'style' => 'padding: 0 !important;']
            );
            ?></div>
        <div style="display: inline"><?= $form->error($model, 'category_id'); ?></div>
      </div>
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <div style="display: inline;">
        <div><?= $form->labelEx($model, 'title'); ?></div>
        <div style="display: inline; color: #2b579a;"><?= $form->textField(
              $model,
              'title',
              ['class' => 'form-control input3']
            ); ?>
        </div>
        <div style="display: inline"><?= $form->error($model, 'title'); ?></div>
      </div>
      <br/>

      <div class="ext-edit">
          <?= $form->labelEx($model, 'body'); ?>
          <? // php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); ?>
          <?
          /** Переиним JQUERY - более не надо в Yii 1.17 **/
          /* $cs = Yii::app()->clientScript;
          $cs->scriptMap['jquery.js'] = $this->frontThemePath .'/js/jquery-1.11.3.js';
          $cs->scriptMap['jquery.min.js'] = $this->frontThemePath .'/js/jquery-1.11.3.min.js'; */

          $this->widget(
            'ext.editMe.widgets.ExtEditMe',
            [
              'name'    => 'BlogPosts[body]',
              'value'   => $model->body,
              'toolbar' => [
                'removeButtons' => 'Save,NewPage,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Embed,Flash,PageBreak,Iframe,About',
                  /*
      toolbarGroups = [
      { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
      { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
      { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
      { name: 'forms', groups: [ 'forms' ] },
      '/',
      { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
      { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
      { name: 'links', groups: [ 'links' ] },
      { name: 'insert', groups: [ 'insert' ] },
      '/',
      { name: 'styles', groups: [ 'styles' ] },
      { name: 'colors', groups: [ 'colors' ] },
      { name: 'tools', groups: [ 'tools' ] },
      { name: 'others', groups: [ 'others' ] },
      { name: 'about', groups: [ 'about' ] }
      ];
                  */
              ],
            ]
          );
          ?>
          <? //= $form->error($model, 'body'); ?>
      </div><!--End:Ext-Edit-->

      <br/>
      <div style="display: inline" class="form-group">
        <div style="display: inline"><?= $form->labelEx($model, 'tags'); ?></div>
        <div style="display: inline"><?= $form->textField(
              $model,
              'tags',
              ['class' => 'form-control']
            ); ?>
        </div>
          <?= $form->error($model, 'tags'); ?>
      </div>
      <br/>
      <div class="row">
        <div class="col-md-6">
            <?= $form->labelEx($model, 'start_date'); ?>
            <?= $form->dateField(
              $model,
              'start_date',
              ['id' => 'BlogPosts_start_date_update', 'class' => 'input3']
            ); ?>
            <?= $form->error($model, 'start_date'); ?>
        </div>
        <div class="col-md-6">
            <?= $form->labelEx($model, 'end_date'); ?>&nbsp;&nbsp;
            <?= $form->dateField(
              $model,
              'end_date',
              ['id' => 'BlogPosts_end_date_update', 'class' => 'input3']
            ); ?>
            <?= $form->error($model, 'end_date'); ?>
        </div>
      </div>
    </div>
    <script>
        $(function () {
            $('.hasDatepicker').last().datepicker('refresh');
            $('#BlogPosts_start_date_update').datepicker({dateFormat: 'yy-mm-dd'});
            $('#BlogPosts_end_date_update').datepicker({dateFormat: 'yy-mm-dd'});
        });
    </script>
    <br/>
  </div>
  <!--End:Modal-body-->

  <div class="modal-footer">
    <div style="display: inline; float: left; left: 20px;">
      <div style="display: inline"><?= $form->labelEx($model, 'enabled'); ?></div>
      <div style="display: inline"><?= $form->checkBox($model, 'enabled', []); ?></div>
      <div style="display: inline"><?= $form->error($model, 'enabled'); ?></div>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div style="display: inline; float: left; padding-left: 20px;">
      <div style="display: inline"><?= $form->labelEx($model, 'comments_enabled'); ?></div>
      <div style="display: inline"><?= $form->checkBox($model, 'comments_enabled', []); ?></div>
      <div style="display: inline"><?= $form->error($model, 'comments_enabled'); ?></div>
    </div>
    <div style="display: block; position: relative; float: right; right: 20px;">
        <?
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'button',
              //'scriptFile' => false,
              //'name'        => 'btnPostsUpdate',
            'label'       => $model->isNewRecord ? Yii::t('main', 'Создать') : Yii::t('main', 'Сохранить'),
            'htmlOptions' => [
              'class'   => 'btn btn-success',
              'onclick' => new CJavaScriptExpression(
                '(function(){updateBlogPosts(); $("#blog-posts-update-modal").modal("hide"); return false;})()'
              ),
            ],
          ]
        );
        ?>
    </div>
      <? $this->endWidget(); ?>
  </div><!--End:Modal-footer-->

<? $this->endWidget('booster.widgets.TbModal'); ?>