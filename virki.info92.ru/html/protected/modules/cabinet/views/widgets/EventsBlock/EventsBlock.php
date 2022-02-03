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
<div id="accordion-events-<?= $blockId ?>">
  <h3><?= Yii::t('main', 'История заказа') ?>: <?= $dataProvider->totalItemCount ?></h3>

  <div class="events-widget-block">
      <? $this->widget(
        'booster.widgets.TbGridView',
        [
          'id'              => 'grid-' . $blockId,
          'dataProvider'    => $dataProvider,
          'type'            => 'striped bordered condensed',
          'template'        => '{summary}{items}{pager}',
          'responsiveTable' => true,
          'columns'         => [
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
<script type="text/javascript">
    $(function () {
        $("#accordion-events-<?=$blockId?>").accordion({
            collapsible: true,
            active: <?=($dataProvider->totalItemCount > 1) ? '0' : 'false';?>
            //disabled: true
        });
    });
</script>