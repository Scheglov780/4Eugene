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
    <? $form = $this->beginWidget(
      'booster.widgets.TbActiveForm',
      [
        'id'          => 'int-search-form',
        'type'        => 'search',
        'method'      => 'get',
        'htmlOptions' => ['class' => 'well'],//'enctype'=>'application/x-www-form-urlencoded'),
      ]
    ); ?>
  <i class="fa fa-search"></i><input type="text"
                                     value="<?= (isset($model->query) && ($model->query)) ? $model->query : '' ?>"
                                     placeholder="<?= Yii::t('main', 'Введите строку для поиска') ?>" id="query"
                                     name="query"
                                     class="input-medium"
                                     style="width: 70%; height: 40px !important; margin: 0.2em 1em !important; padding: 5px !important;">
    <?
    $this->widget(
      'booster.widgets.TbButton',
      [
        'buttonType'  => 'ajaxSubmit',
        'id'          => 'admin-search-button',
        'type'        => 'info',
        'icon'        => 'ok white',
        'label'       => Yii::t('main', 'Поиск'),
//            'loadingText'=>Yii::t('main','Выполняется...'),
//             'completeText'=>Yii::t('main','Выполнено'),
        'url'         => Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/search/index', []),
        'htmlOptions' => [
          'onclick' => '$(\'#admin-search-content\').html(\'' . Yii::t(
              'main',
              'Осуществляется поиск, подождите несколько секунд...'
            ) . '\')',
        ],
        'ajaxOptions' => [
          'type'    => 'GET',
          'success' => 'function(data) {$(\'#admin-search-content\').html(data);}',
        ],
      ]
    );
    $this->endWidget();
    ?>

</div>
<? if (isset($model->query) && ($model->query)) { ?>
  <div><?= Yii::t('main', 'Вы искали') ?>: <?= $model->query ?></div>
<? } ?>
<?php
//    'onsubmit'=>"alert('test');$.fn.yiiGridView.update('search-grid', {data: $(this).serialize()});return false;",),
?>
