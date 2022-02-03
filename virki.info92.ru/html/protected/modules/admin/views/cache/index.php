<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="index.php">
 * </description>
 **********************************************************************************************************************/ ?>
<div style="width:100%;">
  <div class="summary"><?= Yii::t('main', 'Состояние кэша') ?>:</div>
  <div class="row-fluid">
    <div class="span3">
      <label><strong><?= Yii::t('main', 'Путь к кэшу') ?>:</strong></label>
        <?= Yii::app()->fileCache->cachePath ?>
        <? $cachedata = Cache::getDirectorySize(Yii::app()->fileCache->cachePath); ?>
    </div>
    <div class="span3">
      <label><strong><?= Yii::t('main', 'Количество файлов') ?>:</strong></label>
        <?= $cachedata['count']; ?>
    </div>
    <div class="span3">
      <label><strong><?= Yii::t('main', 'Занято кэшем на диске') ?>:</strong></label>
        <?= Cache::sizeFormat($cachedata['size']); ?>
    </div>
    <div class="span3">
      <label><strong><?= Yii::t('main', 'Свободно на диске') ?>:</strong></label>
        <?= Cache::sizeFormat($cachedata['free']); ?>
    </div>
  </div>
  <hr/>
  <div style="color=red !important;"><strong><?= Yii::t(
            'main',
            'Внимание! Очистка кэша нужна ТОЛЬКО в случае, если на диске недостаточно свободного места!'
          ) ?></strong></div>
  <div style="color=red !important;"><?= Yii::t(
        'main',
        'При очистке информация о товарах в корзинах пользователей и многие другие данные могут быть потеряны!'
      ) ?></div>
  <hr/>
  <div>
      <? $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'button',
            //'id'=>'sub2',
          'type'        => 'danger',
          'icon'        => 'remove white',
          'label'       => Yii::t('main', 'Очистить старый кэш'),
          'htmlOptions' => [
            'class'      => 'btn-block',
            'onclick'    => 'clearCache(this); return false;',
            'formaction' => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/cache/clear',
              ['all' => false]
            ),
          ],
        ]
      );
      ?>
      <? $this->widget(
        'booster.widgets.TbButton',
        [
          'buttonType'  => 'button',
            //'id'=>'sub2',
          'type'        => 'danger',
          'icon'        => 'remove white',
          'label'       => Yii::t('main', 'Очистить весь кэш'),
          'htmlOptions' => [
            'class'      => 'btn-block',
            'onclick'    => 'clearCache(this); return false;',
            'formaction' => Yii::app()->createUrl(
              '/' . Yii::app()->controller->module->id . '/cache/clear',
              ['all' => true]
            ),
          ],
        ]
      );
      ?>
  </div>
</div>