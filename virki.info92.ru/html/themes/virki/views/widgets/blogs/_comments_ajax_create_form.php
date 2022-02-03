<?
/**
 * @var CActiveForm $form
 */
?>
<? $this->beginWidget(
  'booster.widgets.TbModal',
  [
    'id'          => 'blog-comments-create-modal',
    'htmlOptions' => ['translate' => "no"],
      /*
      'scriptFile' => false,
  // additional javascript options for the dialog plugin
      'options' => array(
        'title'     => Yii::t('main', 'Новый комментарий'),
        'autoOpen'  => false,
        'modal'     => true,
        'resizable' => true,
        'width'     => '975',
        'height'    => '580',
          //'htmlOptions' => array('width'=>'975px','height'=>'545px'),
      ),
      */
  ]
);
?>
  <div class="modal-header" translate="no">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    <h3 class="modal-title" id="myModalCommentCreateLabel"><?= Yii::t('main', 'Новый комментарий'); ?></h3>
  </div><!--End:Modal-header-->
  <div class="modal-body" translate="no">
      <?
      $form = $this->beginWidget(
        'CActiveForm',
        [
          'id'                     => 'blog-comments-create-form',
          'enableAjaxValidation'   => false,
          'enableClientValidation' => false,
          'method'                 => 'post',
          'action'                 => ["#"],//array("/blog/commentsCreate"),
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
      <?= $form->errorSummary(
        $model,
        'Opps!!!',
        null,
        ['class' => 'alert alert-error']
      ); ?>
    <div>
        <? $model->uid = Yii::app()->user->id; ?>
      <input type="hidden" name="BlogComments[uid]" value="<?= $model->uid ?>">
        <? $user = Users::model()->findByPkEx($model->uid) ?>
      <label><?= Yii::t('main', 'Автор') ?></label>
      <input type="text" name="user_name" readonly value="<?= ($user ? $user->email : '-'); ?>"
             class="input3 form-control">
    </div>
    <input type="hidden" name="BlogComments[post_id]" id='BlogComments_post_id' value="<?= $model->post_id ?>">
    <div>
        <?= $form->labelEx($model, 'title'); ?>
        <?= $form->textField($model, 'title', ['class' => 'input3 form-control']); ?>
        <?= $form->error($model, 'title'); ?>
    </div>
    <br/>
    <div class="ext-edit">
        <?= $form->labelEx($model, 'body'); ?>
        <? // php echo $form->textArea($model, 'body', array('rows' => 6, 'cols' => 50)); ?>
        <?
        $this->widget(
          'ext.editMe.widgets.ExtEditMe',
          [
            'name'    => 'BlogComments[body]',
            'value'   => $model->body,
            'toolbar' => [
              'removeButtons' => 'Save,NewPage,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Embed,Flash,PageBreak,Iframe,About',
//        toolbarGroups = [
//		{ name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
//		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
//		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
//		{ name: 'forms', groups: [ 'forms' ] },
//		'/',
//		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
//		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
//		{ name: 'links', groups: [ 'links' ] },
//		{ name: 'insert', groups: [ 'insert' ] },
//		'/',
//		{ name: 'styles', groups: [ 'styles' ] },
//		{ name: 'colors', groups: [ 'colors' ] },
//		{ name: 'tools', groups: [ 'tools' ] },
//		{ name: 'others', groups: [ 'others' ] },
//		{ name: 'about', groups: [ 'about' ] }
//	    ];
            ],
          ]
        );
        ?>
        <?= $form->error($model, 'body'); ?>

    </div>

    <br/>
    <div class="form-group">
        <?= $form->labelEx($model, 'enabled'); ?>
        <?= $form->checkBox($model, 'enabled', []); ?>
        <?= $form->error($model, 'enabled'); ?>
    </div>
    <div class="row">
      <div class="col-md-12">
        <input id="BlogComments_create_rating" name="BlogComments[rating]" class="rating" type="number"
               data-size="xs" step="1" max="5" min="0" value="<?= $model->rating; ?>"/>
          <? /*
                $this->widget(
                  'CStarRating',
                  array(
                    'id'             => 'star-rating-comment-create',
                    'model'          => $model,
                    'attribute'      => 'rating',
                    'minRating'      => 1,
                    'maxRating'      => 5,
                    'ratingStepSize' => 1,
                    'starCount'      => 5,
//                  'readOnly' => true,
                  )
                );
*/
          ?>

        <div style="display: inline"><?= $form->error($model, 'rating'); ?></div>
      </div>
    </div>
      <? $this->endWidget('CActiveForm') ?>
  </div>
  <div class="modal-footer" translate="no">
      <?
      $this->widget(
        'booster.widgets.TbButton',
        [
          'id'          => 'commentsAjaxCreateFormSubmitButton',
            //'scriptFile' => false,
          'buttonType'  => 'button',
            //'name'        => 'btnCommentsCreate',
          'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t('main', 'Сохранить'),
            //
          'htmlOptions' => [
            'class'   => 'btn btn-primary',
            'onclick' => new CJavaScriptExpression('(function () {createBlogComments(0);})()'),
          ],
        ]
      );
      ?>
  </div>
<?
$this->endWidget('booster.widgets.TbModal');
?>