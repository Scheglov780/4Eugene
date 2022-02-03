<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_form_config.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="row">
  <div class="col-md-12">
    <div class="box">
        <? /** @var TbActiveForm $form */ ?>
        <?php $form = $this->beginWidget(
          'booster.widgets.TbActiveForm',
          [
            'id'                   => 'pay-systems-form-' . $model->id,
            'enableAjaxValidation' => false,
            'method'               => 'post',
            'type'                 => 'vertical',
            'htmlOptions'          => [
              'enctype' => 'multipart/form-data',
            ],
          ]
        ); ?>
      <div class="box-body">
          <?php echo $form->errorSummary($model); ?>
          <?php echo $form->textFieldRow($model, 'int_name'); ?>
          <?php echo $form->textFieldRow($model, 'name_ru'); ?>
          <?php echo $form->textFieldRow($model, 'name_en'); ?>
          <?php echo $form->textFieldRow($model, 'logo_img'); ?>
          <?php echo $form->checkboxRow($model, 'enabled'); ?>
          <?php echo $form->textAreaRow($model, 'descr_ru'); ?>
          <?php echo $form->textAreaRow($model, 'descr_en'); ?>
          <?php echo $form->textAreaRow(
            $model,
            'parameters',
            ['id' => 'paymentsFormConfigUpdate' . $model->id]
          ); ?>
        <script>
            if (paymentsFormConfigUpdateVar<?=$model->id?> != undefined) {
                paymentsFormConfigUpdateVar<?=$model->id?>.toTextArea();
            }
            var paymentsFormConfigUpdateVar<?=$model->id?> = CodeMirror.fromTextArea(
                document.getElementById('paymentsFormConfigUpdate<?=$model->id?>')
                , {
                    //lineNumbers: true,
                    mode: 'application/x-httpd-php',//'htmlmixed',//'text/html',
                    matchBrackets: true,
                });
            paymentsFormConfigUpdateVar<?=$model->id?>.setSize(null, 300);
            paymentsFormConfigUpdateVar<?=$model->id?>.refresh();
        </script>
        <div class="form-group">
            <?
            //echo $form->textAreaRow($model,'form_en',array('rows'=>6, 'cols'=>50, 'class'=>'span8'));
            echo $form->labelEx($model, 'form_ru'); ?>
          <div class="elrte-place">
              <? $editor = new SRichTextarea();
              $editor->init();
              $editor->model = $model;
              $editor->attribute = 'form_ru';
              //$editor->htmlOptions=array('rows'=>8, 'cols'=>80);
              $editor->run();
              ?>
          </div>
        </div>
        <div class="form-group">
            <?
            //echo $form->textAreaRow($model,'form_en',array('rows'=>6, 'cols'=>50, 'class'=>'span8'));
            echo $form->labelEx($model, 'form_en'); ?>
          <div class="elrte-place">
              <? $editor = new SRichTextarea();
              $editor->init();
              $editor->model = $model;
              $editor->attribute = 'form_en';
              //$editor->htmlOptions=array('rows'=>8, 'cols'=>80);
              $editor->run();
              ?>
          </div>
        </div>
      </div>
      <div class="box-footer">
          <?php
          $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'primary',
              'icon'        => 'ok white',
              'label'       => $model->isNewRecord ? Yii::t('main', 'Добавить') : Yii::t(
                'main',
                'Сохранить'
              ),
              'htmlOptions' => [
                'onclick' => "paymentsFormConfigUpdateVar" .
                  $model->id .
                  ".save(); savePaySystem(" .
                  $model->id .
                  "); return false;",
              ],
            ]
          ); ?>
          <?php $this->widget(
            'booster.widgets.TbButton',
            [
              'buttonType'  => 'reset',
              'icon'        => 'remove',
              'label'       => Yii::t('main', 'Сброс'),
              'htmlOptions' => ['class' => 'pull-left'],
            ]
          ); ?>
      </div>
        <?php $this->endWidget(); ?>
    </div>
  </div>
</div>
