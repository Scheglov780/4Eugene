<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_price_detail.php">
 * </description>
 * Рендеринг расклада цены товара
 **********************************************************************************************************************/
?>
<? if ($item->top_item->weight_calculated > 0
  && isset($item->top_item->totalWeight) && isset($item->top_item->totalDelivery)
) { ?>
  <label><?= Yii::t('main', 'Примерный вес 1 шт.') ?>:</label>&nbsp;
  <div class="item-info-param pull-right">
    <span id="item_weight"><?= Formulas::weightWrapper($item->top_item->weight_calculated) ?></span>&nbsp;
  </div>
  <br/>
  <label><?= Yii::t('main', 'Вес в заказе') ?>:</label>&nbsp;
  <div class="item-info-param pull-right">
    <span><?= Formulas::weightWrapper($item->top_item->totalWeight) ?></span>&nbsp;
  </div>

    <? if ($item->top_item->totalDelivery > 0) { ?>
    <br/>
    <label><?= Yii::t('main', 'Примерная стоимость доставки') ?>:</label>&nbsp;
    <div class="item-info-param pull-right">
      <span><?= Formulas::priceWrapper($item->top_item->totalDelivery) ?></span>&nbsp;
    </div>
    <? } ?>
<? } else { ?>
  <div class="item-info-param">
        <span id="item_weight" style="margin-left: 20px !important;">
            <div class="alert alert-info"> <?= Yii::t(
                  'main',
                  'Вес товара будет расcчитан при оформлении заказа'
                ) ?> </div>
        </span>&nbsp;
  </div>
<? } ?>
