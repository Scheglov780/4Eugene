<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_parserdebugform.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php $form = $this->beginWidget(
  'booster.widgets.TbActiveForm',
  [
    'id'                     => 'banners-update-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => false,
    'method'                 => 'post',
    'action'                 => ["banners/update"],
    'type'                   => 'horizontal',
    'htmlOptions'            => [
      'onsubmit' => "return false;",/* Disable normal form submit */
        //'onkeypress'=>" if(event.keyCode == 13){ update_config (); } " /* Do ajax call when user presses enter key */
    ],

  ]
); ?>
  <fieldset>
      <? // echo $form->errorSummary($model,'Opps!!!', null,array('class'=>'alert alert-error span12')); ?>
    <div class="control-group">
      <div class="span4">
          <? // echo $form->hiddenField($model,'id',array()); ?>
        <div class="row">
            <? // echo $form->labelEx($model,'img_src'); ?>
            <? // echo $form->textField($model,'img_src',array('size'=>60,'maxlength'=>1024)); ?>
            <? // echo $form->error($model,'img_src'); ?>
        </div>
      </div>
    </div>

    </div><!--end modal body-->

    <div class="modal-footer">
        <?php
        $this->widget(
          'booster.widgets.TbButton',
          [
            'buttonType'  => 'button',
            'type'        => 'default',
              //'size'        => 'mini',
            'icon'        => 'fa fa-check',
            'label'       => Yii::t('main', 'Сохранить'),
            'htmlOptions' => ['onclick' => 'update_config ();'],
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
    </div>

  </fieldset>
<?php $this->endWidget(); ?>