<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="EventsBlock.php">
 * </description>
 * Виджет истории заказа, например, в кабинете - просмотр заказа
 * var $dataProvider =  CActiveDataProvider#1
 * ( [modelClass] => 'EventsLog' [model] => EventsLog#2 )
 * var $blockId = 'events-1916'
 **********************************************************************************************************************/
?>
<div class="panel-group" id="accordion-events-<?= $blockId ?>" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading closed" data-parent="#accordion-events-<?= $blockId ?>"
         data-target="#heading-accordion-events-<?= $blockId ?>" data-toggle="collapse">
      <h4 class="panel-title">
        <span class="fa fa-arrow-right"></span>
        <a <?= ($dataProvider->totalItemCount <= 0) ? ' class="collapsed" ' : ' '; ?>
            href="#accordion-events-<?= $blockId ?>-100">
            <?= Yii::t('main', 'Статистика') ?>
            <? if ($dataProvider->totalItemCount > 0) { ?>
              : <?= $dataProvider->totalItemCount; ?>
            <? } ?>
        </a>
      </h4>
    </div>
    <div id="heading-accordion-events-<?= $blockId ?>"
         class="panel-collapse collapse<? //= ($dataProvider->totalItemCount <= 0) ? '' : ' in'; ?>" role="tabpanel"
         aria-labelledby="heading-accordion-events-<?= $blockId ?>">
      <div class="panel-body">
          <? $this->widget(
            'booster.widgets.TbGridView',
            [
              'id'           => 'grid-events-' . $blockId,
              'dataProvider' => $dataProvider,
              'type'         => 'striped bordered condensed',
              'template'     => '{items}{pager}', //{summary}{pager}
              'columns'      => [
                'date',
                [
                  'name'  => 'eventName',
                  'type'  => 'raw',
                  'value' => function ($data) {
                      return Yii::t('main', $data->eventName);
                  },
                ],
                [
                  'name'  => 'subject_value',
                  'type'  => 'raw',
                  'value' => function ($data) {
                      return Yii::t('main', $data->subject_value);
                  },
                ],
                'fromName',
              ],
            ]
          );
          ?>
      </div>
    </div>
  </div>
</div>
