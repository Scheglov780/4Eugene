<?
/**
 * @var CActiveForm $form
 */
?>
<? $this->beginWidget(
  'booster.widgets.TbModal',
  [
    'id'          => 'blog-posts-create-modal',
    'htmlOptions' => ['translate' => "no"],
      /*
    'scriptFile' => false,
// additional javascript options for the dialog plugin
    'options'    => array(
      'title'     => Yii::t('main', 'Новое сообщение'),
      'autoOpen'  => false,
      'modal'     => true,
      'resizable' => true,
      //'width'     => '975',
      //'height'    => '600',
        //'htmlOptions' => array('width'=>'975px','height'=>'545px'),
    ),
    */
  ]
);
?>
<!------------------------------------->
<? /*
<div class="modal fade" id="blog-posts-create-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
*/ ?>
<div class="modal-header" translate="no">
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <? if (empty($model->body)) { ?>
      <h3 class="modal-title" id="myModalLabel"><?= Yii::t('main', 'Новая статья'); ?></h3>
    <? } else { ?>
      <h3 class="modal-title" id="myModalLabel"><?= Yii::t('main', 'Новый отзыв'); ?></h3>
    <? } ?>
</div><!--End:Modal-header-->
<div class="modal-body" translate="no">
    <? $form = $this->beginWidget(
      'CActiveForm',
      [
        'id'                     => 'blog-posts-create-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => false,
        'method'                 => 'post',
        'action'                 => ["/blog/postsCreate"],
        'htmlOptions'            => [
          'onsubmit' => "return false;",// Disable normal form submit
        ],
        'clientOptions'          => [
          'validateOnType'   => true,
          'validateOnSubmit' => true,
          'afterValidate'    => 'js:function(form, data, hasError) {
                                     if (!hasError)
                                        {
                                          create();
                                        }
                                     }',
        ],
      ]
    ); ?>

    <?= $form->errorSummary($model, 'Opps!!!', null, ['class' => 'alert alert-error']); ?>

  <div>
      <? $model->uid = Yii::app()->user->id; ?>
    <input type="hidden" name="BlogPosts[uid]" value="<?= $model->uid ?>">
      <? /*
                    <? $user = Users::getUser($model->uid) ?>
                    <label><?= Yii::t('main', 'Автор') ?></label>
                    <input type="text" name="user_name" readonly value="<?= ($user ? $user->email : '-'); ?>">
                    */ ?>
  </div>

  <div class="form-group">
      <?= $form->labelEx($model, 'title'); ?>
      <?= $form->textField($model, 'title', ['class' => 'input3 form-control']); ?>
      <?= $form->error($model, 'title'); ?>
  </div>
  <br/>
  <div class="form-group">
    <label><?= Yii::t('main', 'Категория') ?></label>

      <? $blogCategories = BlogCategories::model()->findAll('enabled=1');
      $filter = [];
      if ($blogCategories) {
          foreach ($blogCategories as $category) {
              if (Blogs::checkAccessByCategory($category['access_rights_post'])) {
                  $filter[(string) $category['id']] = $category['name'];
              }
          }
      }
      ?>

      <?= $form->dropDownList(
        $model,
        'category_id',
        $filter,
        ['class' => 'input3 form-control']
      );
      ?>

      <?= $form->error($model, 'category_id'); ?>
  </div>

  <br/><br/>

  <div class="ext-edit">
      <?= $form->labelEx($model, 'body'); ?>
      <? /* php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); */ ?>
      <?
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
      ); ?>

      <?= $form->error($model, 'body'); ?>

  </div>

  <br/>

  <div class="form-group">
      <?= $form->labelEx($model, 'tags'); ?>
      <?= $form->textField($model, 'tags', ['class' => 'input3 form-control']); ?>
      <?= $form->error($model, 'tags'); ?>
  </div>

  <br/>
  <div class="row">
    <div class="col-md-6">
        <?= $form->labelEx($model, 'start_date'); ?>
        <?= $form->dateField(
          $model,
          'start_date',
          ['class' => "datepicker input3", 'data-provide' => "datepicker"]
        ); ?>
        <?= $form->error($model, 'start_date'); ?>
    </div>
    <div class="col-md-6">
        <?= $form->labelEx($model, 'end_date'); ?>
        <?= $form->dateField(
          $model,
          'end_date',
          ['class' => "datepicker input3", 'data-provide' => "datepicker"]
        ); ?>
        <?= $form->error($model, 'end_date'); ?>
    </div>
  </div>

  <script>
      $(function () {
          //var datepicker = $.fn.datepicker.noConflict();
          $('.hasDatepicker').last().datepicker('refresh');
          $('#BlogPosts_start_date').datepicker({format: 'yy-mm-dd', locale: 'ru'});
          $('#BlogPosts_end_date').datepicker({format: 'yy-mm-dd', locale: 'ru'});
      });
  </script>

  <br/>

</div><!--End:Modal-body-->
<div class="modal-footer" translate="no">

  <div style="display: inline-block; position: relative; float: left; left: 10px;">
    <div style="display: inline-block">
        <?= $form->labelEx($model, 'enabled'); ?>
        <?= $form->checkBox($model, 'enabled', []); ?>
        <?= $form->error($model, 'enabled'); ?>
    </div>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <div style="display: inline-block">
        <?= $form->labelEx($model, 'comments_enabled'); ?>
        <?= $form->checkBox($model, 'comments_enabled', []); ?>
        <?= $form->error($model, 'comments_enabled'); ?>
    </div>
  </div>

    <? $this->widget(
      'booster.widgets.TbButton',
      [
        'buttonType'  => 'button',
          //'scriptFile'  => false,
          //'name'        => 'btnPostsCreate',
        'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
        'htmlOptions' => [
          'class'   => 'btn btn-primary',
          'onclick' => new CJavaScriptExpression('(function(){createBlogPosts(); return false;})()'),
        ],
      ]
    );
    ?>

</div>
<? /*
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
*/ ?>
<? $this->endWidget(); ?>
<? $this->endWidget('booster.widgets.TbModal'); ?>
<!------------------------------------->

<? /*
<!----------------------------->
        <?php
        $this->widget('application.components.was.WasDatepicker',array(
          'model'=>$model,
          'attribute'=>'create_time',
            //model + attribute or 'name'=>'nameInput',
          'options'=>array(
            'language'=>'ru',
            'format'=>'dd.mm.yyyy',
            'autoclose'=>'true',
            'startDate'=>'3,9,2012',
            'endDate'=>'15,9,2012',
            'weekStart'=>1,
            'startView'=>2,
            'keyboardNavigation'=>true
          ),
          'htmlOptions'=>array(
            'value'=>date("d.m.Y"),
          ),
        ));
        ?>
<!------------------------>
*/ ?>

<script type="text/javascript">
    function createBlogPosts() {
        var data = $('#blog-posts-create-form').serialize();
        //noinspection AnonymousFunctionJS,AnonymousFunctionJS
        jQuery.ajax({
            type: 'POST',
            url: '<?php
              echo Yii::app()->createAbsoluteUrl("blog/postsCreate"); ?>',
            data: data,
            success: function (data) {
                //alert("succes:"+data); 
                if (data !== 'false') {
                    $('#blog-posts-create-modal').modal('hide');
                    $.fn.yiiGridView.update('blog-posts-grid', {});
                }
            },
            error: function (data) { // if error occured
                dsAlert('Error occured, please try again', '', true);
                dsAlert(data, '', true);
            },
            dataType: 'html'
        });
    }

    function renderCreateBlogPostsForm(clearBody) {
        //alert('123');
        if (clearBody) {
            $('#blog-posts-create-form').each(function () {
                this.reset();
            });
            if (typeof CKEDITOR != 'undefined') {
                for (var instance in CKEDITOR.instances) {
                    //CKEDITOR.instances[instance].updateElement();
                    CKEDITOR.instances[instance].setData('');
                }
            }
        }
        $('#BlogPosts_enabled').prop('checked', true);
        $('#BlogPosts_comments_enabled').prop('checked', true);
        $('#BlogPosts_start_date').datepicker({format: 'yy-mm-dd'});
        $('#BlogPosts_end_date').datepicker({format: 'yy-mm-dd'});
        $('#blog-posts-create-modal').modal('show');
    }
</script>
