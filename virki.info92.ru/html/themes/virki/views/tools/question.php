<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="question.php">
 * </description>
 * Вопрос в службу поддержки
 **********************************************************************************************************************/
?>
<div class="f-space10"></div>
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <div class="box-heading">
        <span><?= $this->pageTitle ?></span>
      </div>
      <div class="alert alert-danger">
          <?= Yii::t('main', 'Символом * отмечены поля, обязательные для заполнения') ?>
      </div>
    </div><!--End:Col-->
  </div><!--End:row-->
  <div class="row">
    <div class="form">
      <div class="content">
        <div class="col-md-6">

          <div class="box-heading"><span><?= Yii::t('main', 'Задать вопрос в службу поддержки') ?></span>
          </div>
            <? $form = $this->beginWidget(
              'booster.widgets.TbActiveForm',
              [
                'id'                   => 'message-form',
                'htmlOptions'          => ['enctype' => 'multipart/form-data'],
                'enableAjaxValidation' => false,
              ]
            ); ?>

          <div>
              <?= $form->labelEx($model, 'category', []); ?>
              <?= $form->dropDownList(
                $model,
                'category',
                $category_values,
                ['class' => 'form-control input3', 'style' => 'height: 46px; position: relative;']
              ); ?>
          </div>

          <div>
              <?= $form->labelEx($model, 'theme', ['style' => '']); ?>
              <?= $form->textField(
                $model,
                'theme',
                [
                    //'size'      => 360,
                  'maxlength' => 128,
                  'class'     => 'input3 form-control',
                ]
              ); ?>
              <?= $form->error($model, 'theme'); ?>
          </div>
          <div>
              <?= $form->labelEx($model, 'question', ['style' => '']); ?>
              <?= $form->textArea(
                $model,
                'question',
                [
                  'rows'  => 6,
                  'cols'  => 50,
                  'class' => 'input3 form-control',
                ]
              ); ?>
              <?= $form->error($model, 'question'); ?>
          </div>
        </div><!--End:Col-->
        <div class="col-md-6">

          <div>
              <?= $form->labelEx($model, 'email', ['style' => '']); ?>
              <?= $form->textField(
                $model,
                'email',
                [
                    //'size'      => 60,
                  'maxlength' => 128,
                  'class'     => 'input3 form-control',
                ]
              ); ?>
              <?= $form->error($model, 'email'); ?>
          </div>

            <? /*<div>
                        <?= $form->labelEx($model, 'order_id', array('class' => 'form-control input3')); ?>
                        <? if ($orders && is_array($orders) && count($orders)) { ?>
                            <?= $form->dropDownList($model, 'order_id', $orders); ?>
                            <?
                        } else {
                            ?>
                            <?= $form->textField(
                              $model,
                              'order_id',
                              array(
                                'size'      => 360,
                                'maxlength' => 128,
                                'class'     => 'input3'
                              )
                            ); ?>
                        <? } ?>
                    </div> */ ?>
            <? /* <div>
                        <?= $form->labelEx($model, 'file', array('style' => 'width:180px;')); ?>
                        <?= $form->fileField(
                          $model,
                          'file',
                          array('style' => "width:230px;", 'id' => 'file_support')
                        ) ?>
                        <div class="hint"><p><?= Yii::t('main', 'Размер файла не должен превышать') ?> <?=ini_get('upload_max_filesize')?></p></div>
                    </div> */ ?>

            <? if (CCaptcha::checkRequirements()) { //&& Yii::app()->user->isGuest?>
              <div>
                <div class="img-responsive" style="width:50%;"><? $this->widget('CCaptcha'); ?></div>
                  <?= $form->labelEx($model, 'captcha'); ?>
                  <?= $form->textField(
                    $model,
                    'captcha',
                    [
                        //'size'      => 60,
                      'maxlength' => 128,
                      'class'     => 'input3 form-control',
                    ]
                  ); ?>
                  <?= $form->error($model, 'captcha'); ?>
              </div>
            <? } ?>
          <div class="f-space20"></div>
          <div class="row buttons">
              <?= CHtml::submitButton(
                Yii::t('main', 'Отправить вопрос'),
                [
                  'class' => 'btn btn-danger pull-right',
                ]
              ); ?>
              <? /* = CHtml::htmlButton(
                          Yii::t('main', 'Удалить файл'),
                          array(
                            'style' => "float:right;",
                            'class' => 'btn btn-warning',
                            'id'    => 'remove_file_support',
                            'onclick' =>'$("#file_support").val("");'
                          )
                        ); */ ?>
          </div>

            <? $this->endWidget(); ?>

        </div>
      </div><!--End:Content-->
    </div><!--End:Col-->
  </div>
  <div class="row f-space10"></div>
  <div class="row"
  <div class="col-md-12" style="padding: 15px">
    <div class="alert alert-info"><?= cms::customContent('support') ?></div>
  </div><!--End:Col-->
</div><!--End:Row-->
</div><!--End:Container-->