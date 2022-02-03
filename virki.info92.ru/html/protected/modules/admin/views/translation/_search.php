<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="_search.php">
 * </description>
 **********************************************************************************************************************/
?>
<div class="form">
    <?
    /** @var TbActiveForm $form */
    $form = $this->beginWidget(
      'booster.widgets.TbActiveForm',
      [
        'id'          => 'int-translation-form',
        'type'        => 'search',
        'method'      => 'post',
        'htmlOptions' => ['class' => 'well'],
      ]
    ); ?>
  <i class="fa fa-search"></i><input type="text"
                                     value="<?= (isset($model->search) && ($model->search)) ? $model->search : '' ?>"
                                     placeholder="<?= Yii::t('main', 'Введите текущий перевод') ?>" id="t-search"
                                     name="search"
                                     class="input-medium"
                                     style="width: 70%; height: 40px !important; margin: 0.2em 1em !important; padding: 5px !important;">
  <br/><i class="fa fa-edit"></i><input type="text"
                                        value="<?= (isset($model->replace) && ($model->replace)) ? $model->replace :
                                          '' ?>"
                                        placeholder="<?= Yii::t(
                                          'main',
                                          'Введите новый перевод или оставьте пустым для поиска без замены'
                                        ) ?>" id="t-replace"
                                        name="replace"
                                        class="input-medium"
                                        style="width: 70%; height: 40px !important; margin: 0.2em 1em !important; padding: 5px !important;">
    <?
    $this->widget(
      'booster.widgets.TbButton',
      [
        'buttonType'  => 'ajaxSubmit',
        'type'        => 'info',
        'icon'        => 'ok white',
        'label'       => Yii::t('main', 'Заменить'),
//            'loadingText'=>Yii::t('main','Выполняется...'),
//             'completeText'=>Yii::t('main','Выполнено'),
        'url'         => Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/translation/index', []),
        'htmlOptions' => [
          'onclick' => '$(\'#translation-content\').html(\'' . Yii::t(
              'main',
              'Замена, подождите несколько секунд...'
            ) . '\')',
        ],
        'ajaxOptions' => ['type' => 'POST', 'update' => '#translation-content'],
      ]
    );
    $this->endWidget();
    ?>

</div>
<? if (isset($model->search) && ($model->search)) { ?>
  <div><?= Yii::t('main', 'Вы искали') ?>: <?= $model->search ?></div>
<? } ?>
<?php
//    'onsubmit'=>"alert('test');$.fn.yiiGridView.update('search-grid', {data: $(this).serialize()});return false;",),
?>
