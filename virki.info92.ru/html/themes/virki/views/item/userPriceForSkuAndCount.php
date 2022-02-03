<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="input_props.php">
 * </description>
 * Рендеринг блока выбора свойств товара в карте товара
 * var $item
 * var $input_props
 * var $props
 * var $seller
 * var $sellerRelated
 * var $itemRelated
 * var $ajax
 * var $lang
 * var $item
 * var $totalCount
 **********************************************************************************************************************/
?>
<span style="left:170px;top:-116px;position:absolute; font-size: 40px" id="count-price"
      title="<?= Yii::t('main', 'цена одного товара без доставки') ?>">
    x&nbsp;&nbsp;&nbsp;<?= Formulas::priceWrapper(
      ($resUserPriceForOneItem ? $resUserPriceForOneItem->price - $resUserPriceForOneItem->delivery :
        ((isset($item->top_item->userPromotionPriceNoDelivery)) ? $item->top_item->userPromotionPriceNoDelivery :
          $item->top_item->userPromotionPrice1NoDelivery)
      )
    ) ?>

</span>

<div class="pull-left" style="color:black !important;font-size:140% !important;">
    <span title="<?= Yii::t('main', 'доставка от продавца') ?>" style="position:relative;top:-10px;"><?= Yii::t(
          'main',
          'Доставка с источника'
        ) ?>:
        <?= Formulas::priceWrapper(
          $resUserPrice ? $resUserPrice->delivery :
            ((isset($item->top_item->userDelivery)) ? $item->top_item->userDelivery : $item->top_item->userDelivery1)
        ) ?>
    </span>
  <br/>
  <span style="font-size: 200%;"><?= Yii::t('main', 'Итого'); ?>: &nbsp;</span>
  <span id="sum" style="font: 700 40px 'Arial' !important; color: #e65a4b;"
        title="<?= Yii::t('main', 'Итоговая цена за указанное количество'); ?>">
        <?= Formulas::priceWrapper(
          $resUserPrice ? $resUserPrice->price :
            ((isset($item->top_item->userPromotionPrice)) ? $item->top_item->userPromotionPrice
              : $item->top_item->userPromotionPrice1)
        ) ?>
    </span>
</div>

<? /* x
                <span id="count-price">
                <?= (isset($item->sku)) ? Formulas::priceWrapper($item->sku->userPriceFinal) : Formulas::priceWrapper(
                  $item->top_item->userPriceFinal
                ) ?>
                </span> =
                <span id="sum">
                    <?= (isset($item->sku)) ? $item->sku->userPromotionPrice : (isset($item->top_item->userPromotionPrice)) ? $item->top_item->userPromotionPrice : $item->top_item->userPromotionPrice1 . '-' . $item->top_item->userPromotionPrice2 ?>
                </span>
*/ ?>
