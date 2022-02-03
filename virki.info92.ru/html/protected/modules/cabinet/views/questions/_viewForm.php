<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_view.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div class="view<?= ($data->status == 3) ? ' answer' : '' ?>">
  <b>E-mail:</b> <?= $data->email ?><br/>
    <?= date("d.m.Y H:i:s", $data->date) ?>
    <? if ($data->uid !== false) { ?>, <?= Yii::t(
      'main',
      'пользователь'
    ) ?> <?= (isset($data->u->fullname)) ? $data->u->fullname : Yii::t(
      'main',
      'без регистрации'
    ) ?>
        <?= Yii::t('main', 'написал') ?>:<? } ?>
  <hr/>
  <p><?= $data->question ?></p>
    <? if ($data->status == 1) { ?>

      <div class="view answer">
        <div class="form">
          <form action="<?= $this->createUrl('/' . Yii::app()->controller->module->id . '/questions/save') ?>"
                id="message-answer-<?= $data->id ?>"
                method="post">
            <div class="row">
              <label><?= Yii::t('main', 'Ответ') ?>:</label>
                <?= CHtml::textArea('Message[question]') ?>
                <?= CHtml::hiddenField('Message[id]', $data->id) ?>
                <?= CHtml::hiddenField('Message[qid]', $data->qid) ?>
            </div>
            <div class="row buttons">
                <? $this->widget(
                  'booster.widgets.TbButton',
                  [
                    'buttonType' => 'button',
                      //'id'=>'sub2',
                    'type' => 'primary',
                    'icon' => 'ok white',
                    'label' => Yii::t('main', 'Ответить'),
                    'htmlOptions' => ['onclick' => 'saveQuestionForm(' . $data->id . '); return false;'],
                  ]
                );
                ?>
            </div>
          </form>
        </div>
      </div>
    <? }  /* elseif(!empty ($answers[$data->id])) { ?>
<?php $answer =  $answers[$data->id]; ?>
<div class="view answer">
    <p><?=Yii::t('main','Ответ')?>:</p>
    <b>E-mail:</b> <?=$answer->email?><br />
    <?=date("d.m.Y H:i:s",$answer->date)?>
    <? if($answer->uid!==FALSE){?>, <?=Yii::t('main','пользователь')?>: <?=$answer->user->firstname.' '.$answer->user->lastname?>
      <?=Yii::t('main','написал')?>:<? } ?>
    <hr />
    <p><?=$answer->question?></p>
</div>
<? } */ ?>

</div>