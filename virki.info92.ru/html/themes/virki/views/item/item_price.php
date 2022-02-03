<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="item_price.php">
 * </description>
 * Рендеринг цены товара
 * $item->top_item->promotion_price - цена на таобао со скидкой в юанях
 * $item->top_item->userPromotionResUserPrice - цена на сайте со скидкой в текущей валюте, с доставкой
 * или, если есть вилка цен, то
 * $item->top_item->userPromotionResUserPrice1  - мин. цена на сайте со скидкой в текущей валюте, с доставкой
 * $item->top_item->userPromotionResUserPrice2  - макс. цена на сайте со скидкой в текущей валюте, с доставкой
 * $item->top_item->userPromotionPriceNoDelivery - цена на сайте со скидкой в текущей валюте, без доставки
 * или, если есть вилка цен, то
 * $item->top_item->userPromotionPrice1NoDelivery - мин.цена на сайте со скидкой в текущей валюте, без доставки
 * $item->top_item->userPromotionPrice2NoDelivery - макс.цена на сайте со скидкой в текущей валюте, без доставки
 * $item->top_item->price - цена на таобао без скидки в юанях
 * $item->top_item->userPriceNoDelivery - цена на сайте без скидки в текущей валюте, без доставки
 * или, если есть вилка цен, то
 * $item->top_item->userPrice1NoDelivery - мин. цена на сайте без скидки в текущей валюте, без доставки
 * $item->top_item->userPrice2NoDelivery - макс. цена на сайте без скидки в текущей валюте, без доставки
 * $item->top_item->userDelivery - стоимость доставки без скидок
 * $item->top_item->userPromotionDelivery - стоимость досткавки со скидками
 * или, если есть вилка цен, то
 * $item->top_item->userPromotionDelivery1 - мин. стоимость доставки
 * $item->sku->price - цена артикула на таобао без скидок в юанях
 * $item->sku->promotion_price - цена артикула на таобао со скидками в юанях
 * $item->sku->userPrice - цена артикула на сайте в текущей валюте без скидок
 * $item->sku->userPromotionPrice - цена артикула на сайте в текущей валюте со скидками
 **********************************************************************************************************************/
?>
<?
$delivery_source_fee_in_price = DSConfig::getValDef('delivery_source_fee_in_price', 0) == 1;
if ($delivery_source_fee_in_price) {
    $userPrice = 'userPrice';
    $userPromotionPrice = 'userPromotionPrice';
    $userPrice1 = 'userPrice1';
    $userPrice2 = 'userPrice2';
    $userPromotionPrice1 = 'userPromotionPrice1';
    $userPromotionPrice2 = 'userPromotionPrice2';
} else {
    $userPrice = 'userPriceNoDelivery';
    $userPromotionPrice = 'userPromotionPriceNoDelivery';
    $userPrice1 = 'userPrice1NoDelivery';
    $userPrice2 = 'userPrice2NoDelivery';
    $userPromotionPrice1 = 'userPromotionPrice1NoDelivery';
    $userPromotionPrice2 = 'userPromotionPrice2NoDelivery';
}
if (isset($item->top_item->userPriceFinal)) {
    $userPriceForMeta = $item->top_item->userPriceFinal;
} elseif (isset($item->top_item->$userPromotionPrice)) {
    $userPriceForMeta = $item->top_item->$userPromotionPrice;
} elseif (isset($item->top_item->$userPromotionPrice1)) {
    $userPriceForMeta = $item->top_item->$userPromotionPrice1;
} else {
    $userPriceForMeta = 0;
}
?>
<div id="_offers4" itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="item-price">
  <meta itemprop="price" content="<?= $userPriceForMeta; ?>">
  <meta itemprop="priceCurrency" content="<?= DSConfig::getCurrency(false) ?>">
    <? if (!$delivery_source_fee_in_price) { ?>
      <span
          style="color: black !important; text-shadow: 0 0 0 !important; font: 400 16px 'Arial' !important;"><?= Yii::t(
            'main',
            'Цена без доставки, за 1 шт.'
          ) ?>:</span>&nbsp;
    <? } ?>
    <? /* В зависимости от того, выбран ли конкретный артикул товара, цена выводится по-разному */ ?>
    <? if (!isset($item->sku)) {
        // Артикул не выбран - используем общие цены товара
        if (($item->top_item->price > $item->top_item->promotion_price) && DSConfig::getVal('source_show_old_price')) {
            // Есть скидка (ну понятно, цена больше цены со скидкой)
            ?>
          <span><?= DSConfig::getCurrency(true) ?></span>&nbsp;<span id="price">
                <? if (isset($item->top_item->$userPromotionPrice)) {
                    // Вилки цен нет ?>
                  <meta itemprop="price"
                        content="<?= DSConfig::getCurrency(false) ?> <?= $userPriceForMeta; ?>">
                  <span
                      title="<?=
                      (Yii::app()->user->inRole(
                        'superAdmin'
                      )) ? $item->top_item->userPromotionResUserPrice->report() :
                        '' ?>"><?= $item->top_item->$userPromotionPrice; ?></span>
                    <?
                } else { //Есть вилка цен
                    ?>
                  <meta itemprop="price"
                        content="<?= DSConfig::getCurrency(false) ?> <?= $userPriceForMeta; ?>">
                  <span
                      title="<?=
                      (Yii::app()->user->inRole(
                        'superAdmin'
                      )) ? $item->top_item->userPromotionResUserPrice1->report() :
                        '' ?>"><?= $item->top_item->$userPromotionPrice1; ?></span>
                                -
                                <span
                      title="<?=
                      (Yii::app()->user->inRole(
                        'superAdmin'
                      )) ? $item->top_item->userPromotionResUserPrice2->report() :
                        '' ?>"><?= $item->top_item->$userPromotionPrice2; ?></span>
                <? } ?><s>
                        <? if (isset($item->top_item->$userPrice)) { //Вилки цен нет ?>
                            <?= $item->top_item->$userPrice; ?>
                            <?
                        } else { // Есть вилка цен
                            if ($item->top_item->$userPrice1 == $item->top_item->$userPrice2) {
                                //Есть вилка цен но цены равны
                                ?>
                                <?= $item->top_item->$userPrice1; ?>
                                <?
                            } else { //Вывод вилки цен
                                ?>
                                <?= $item->top_item->$userPrice1; ?>-<?= $item->top_item->$userPrice2; ?>
                                <?
                            }
                        } ?></s></span>
            <?
        } else {
            // Скидки нет - просто выводим цену
            ?>
            <? if (isset($item->top_item->$userPromotionPrice)) {
                // Вилки цен нет ?>
            <meta itemprop="price"
                  content="<?= DSConfig::getCurrency(false) ?> <?= $userPriceForMeta; ?>">
            <span>
                    <?= DSConfig::getCurrency(true) ?>
                    <span
                        title="<?=
                        (Yii::app()->user->inRole(
                          'superAdmin'
                        )) ? $item->top_item->userPromotionResUserPrice->report() : '' ?>"><span
                          id="price"><?= $item->top_item->$userPromotionPrice; ?></span>
                    </span>
                    </span>
                <?
            } else {
                if (isset($item->top_item->$userPromotionPrice1)) { //Есть вилка цен
                    ?>
                  <meta itemprop="price"
                        content="<?= DSConfig::getCurrency(false) ?> <?= $userPriceForMeta; ?>">
                  <span>
                    <?= DSConfig::getCurrency(true) ?>
                    <span id="price">
                    <span
                        title="<?=
                        (Yii::app()->user->inRole(
                          'superAdmin'
                        )) ? $item->top_item->userPromotionResUserPrice1->report() :
                          '' ?>"><?= $item->top_item->$userPromotionPrice1; ?></span>
                    -
                    <span
                        title="<?=
                        (Yii::app()->user->inRole(
                          'superAdmin'
                        )) ? $item->top_item->userPromotionResUserPrice2->report() :
                          '' ?>"><?= $item->top_item->$userPromotionPrice2; ?></span>
                    </span>
                    </span>
                <? }
            } ?>

        <? } ?>
      <input type="hidden" name="price" value="<?= $item->top_item->promotion_price ?>" id="price_val"/>
        <?
    } else {
        // Артикул выбран - используем цены артикула
        if (($item->sku->price > $item->sku->promotion_price) && DSConfig::getVal('source_show_old_price')) {
            // Если есть скидка
            ?>

          <span><?= DSConfig::getCurrency(true) ?></span>&nbsp;<span
              id="price"><?= $item->sku->userPromotionPrice ?>
                &nbsp;<s><?= $item->sku->userPrice ?></s></span>
            <?
        } else {
            // Если скидки нет
            ?>
          <meta itemprop="price" content="<?= DSConfig::getCurrency(false) ?> <?= $userPriceForMeta; ?>">
          <span><?= DSConfig::getCurrency(true) ?></span>&nbsp;<span
              id="price"><?= $item->sku->userPromotionPrice ?></span>
        <? } ?>
      <input type="hidden" name="price" value="<?= $item->sku->promotion_price ?>" id="price_val"/>
    <? } ?>
</div>
<? // Предварительная доставка ?>
<? if (isset($item->top_item->userPromotionDelivery) && ($item->top_item->userPromotionDelivery > 0)) {
    $chinaDelivery = $item->top_item->userDelivery;
} elseif (isset($item->top_item->userPromotionDelivery1) && ($item->top_item->userPromotionDelivery1 > 0)) {
    $chinaDelivery = $item->top_item->userPromotionDelivery1;
} elseif (isset($item->top_item->userDelivery) && ($item->top_item->userDelivery > 0)) {
    $chinaDelivery = $item->top_item->userDelivery;
} ?>
<? if (isset($chinaDelivery) && (Yii::app()->user->inRole('superAdmin') || (DSConfig::getValDef(
        'delivery_source_fee_in_price',
        0
      ) == 1))
) { ?>
  <div class="item-price-delivery" style="padding-left: 15px;">
      <?= ($delivery_source_fee_in_price ? Yii::t('main', 'В том числе предварительная доставка') : Yii::t(
        'main',
        'Стоимость предварительной доставки'
      )) ?>: <?= DSConfig::getCurrency(true) ?>
      <?= $chinaDelivery ?>
  </div>
<? } else { ?>
    <?= Yii::t('main', 'Бесплатная доставка от продавца') ?>
<? } ?>
<script>
    function applySku(data) {
        var delivery_source_fee_in_price = <?=($delivery_source_fee_in_price ? 'true' : 'false')?>;
        if (data.sku !== undefined) {
            if ((data.sku.price > data.sku.promotion_price) && !delivery_source_fee_in_price) {
                $('#price').html(data.sku.userPromotionPriceNoDelivery + '&nbsp;<s>' + data.sku.userPrice + '</s>');
            } else if (!delivery_source_fee_in_price) {
                $('#price').html(data.sku.userPromotionPriceNoDelivery);
            } else {
                $('#price').html(data.sku.userPromotionPrice);
            }
            if (data.sku.count > 0) {
                $('#item_num').html(data.sku.count);
            } else {
                $('#item_num').html('<?=Yii::t('main', 'нет в наличии')?>');
            }
            $('#item_totalcount').val(data.sku.count);
            if (data.sku.count > 0) {
                if (data.buttonsSection.allowBuy) {
                    $('#buy-btn-buy').removeAttr('disabled').removeAttr('data-original-title');
                } else {
                    $('#buy-btn-buy').attr('disabled', 'disabled');
                    $('#buy-btn-buy').attr('data-original-title', data.buttonsSection.notAllowBuyMessage);
                }
                if (data.buttonsSection.allowCart) {
                    $('#buy-btn-cart').removeAttr('disabled').removeAttr('data-original-title');
                } else {
                    $('#buy-btn-cart').attr('disabled', 'disabled');
                    $('#buy-btn-cart').attr('data-original-title', data.buttonsSection.notAllowCartMessage);
                }
            } else {
                if (!data.buttonsSection.allowBuy) {
                    $('#buy-btn-buy').attr('disabled', 'disabled');
                    $('#buy-btn-buy').attr('data-original-title', data.buttonsSection.notAllowBuyMessage);
                }
                if (!data.buttonsSection.allowCart) {
                    $('#buy-btn-cart').attr('disabled', 'disabled');
                    $('#buy-btn-cart').attr('data-original-title', data.buttonsSection.notAllowCartMessage);
                }
            }
            $('#price_val').val(data.sku.promotion_price);
            getUserPrice(true);
        } else {
            $('#item-count-price').html('<?=Yii::t('main', 'нет в наличии')?>');
            $('#item_num').html('<?=Yii::t('main', 'нет в наличии')?>');
            $('#price').html('<?=Yii::t('main', 'нет в наличии')?>');
            $('#price_val').val(0);
            $('#buy-btn-buy').attr('disabled', 'disabled');
            $('#buy-btn-buy').attr('data-original-title', data.buttonsSection.notAllowBuyMessage);
            $('#buy-btn-cart').attr('disabled', 'disabled');
            $('#buy-btn-cart').attr('data-original-title', data.buttonsSection.notAllowCartMessage);
        }
    }
</script>
