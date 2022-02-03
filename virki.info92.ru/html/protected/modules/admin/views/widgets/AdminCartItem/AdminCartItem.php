<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="OrderItemAdmin.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?
$edit = (Yii::app()->user->checkAccess('@manageAnyInOrderAndItem') ||
    Yii::app()->user->inRole(['billManager']) &&
    (isset($order) && in_array($order->status, OrdersStatuses::getStatusesArrayWithChildren(['IN_PROCESS'])))) ||
  Yii::app()->user->inRole(['superAdmin', 'topManager']);
?>
<div class="cart-table">
    <? /* Status Block*/ ?>
  <div class="product-image">
    <ul class="hoverbox">
      <li>
        <a href="<?= Yii::app()->createUrl(
          '/item/index',
          [
            'iid' => $item->iid,
            'dsSource' => $item->ds_source,
          ]
        ) ?>" target="_blank">
          <img src="<?= Img::getImagePath($item->pic_url, $imageFormat) ?>" alt="" title=""/>
          <img class="preview"
               src="<?= Img::getImagePath($item->pic_url, $imageFormat) ?>" alt="" title=""/>
        </a>
      </li>
    </ul>
  </div>
  <div class="cart-info">
    <div>
        <?= $item->title; ?>
        <? if (isset($item->top_item) && isset($item->top_item->input_props) && (is_array(
              $item->top_item->input_props
            ) || $item->top_item->input_props instanceof ArrayAccess)
        ) { ?>
          <dl style="overflow: hidden;">
              <? foreach ($item->top_item->input_props as $pid => $input_prop) { ?>
                <dt style="float:left;width:120px; margin-right: 4px;">
                  <strong><?= $input_prop->name ?>:</strong></dt>
                <dd>
                    <? // Выбрано ли свойство?
                    $propSelected = false;
                    if (isset($input_prop->childs) && is_array($input_prop->childs)) {
                        foreach ($input_prop->childs as $child) {
                            if (preg_match(
                              '/(?:^|;)' . $pid . ':' . $child->vid . '(?:$|;)/',
                              $item->input_props
                            )) {
                                $propSelected = true;
                                break;
                            }
                        }
                    }
                    ?>
                  <select <?= ($readOnly) ? 'readonly="readonly" disabled' : '' ?>
                      name="selectedProps[<?= $item->id ?>][<?= $pid ?>]"<?= (!$propSelected) ?
                    ' style="background-color: #ffa6bc"' : '' ?>>
                    <option value="<?= $pid ?>:0" style="color: red;"><?= Yii::t(
                          'main',
                          'Не выбрано'
                        ) ?></option>
                      <? if (isset($input_prop->childs) && is_array($input_prop->childs)) {
                          foreach ($input_prop->childs as $child) { ?>
                            <option <?= (preg_match(
                              '/(?:^|;)' . $pid . ':' . $child->vid . '(?:$|;)/',
                              $item->input_props
                            )) ? ' selected ' : '' ?>
                                value="<?= $pid . ':' . $child->vid ?>"><?= $child->name ?></option>
                              <?
                          }
                      } ?>
                  </select>
                </dd>
              <? } ?>
          </dl>
        <? } ?>
    </div>
  </div>
  <div class="param" style="width: 245px !important;">
    <table border="0">
      <tbody>
      <tr>
        <td width="120"><label><?= Yii::t('main', 'Количество') ?>:</label></td>
        <td colspan="2" align="right">
            <? if ((!$readOnly) && ($allowDelete)) { ?>
              <div class="remove">
                <a href="<?= Yii::app()->createUrl('/cart/delete', ['id' => $item->id]) ?>">
                    <?= Yii::t('main', 'Удалить') ?><span class="fa fa-close"
                                                          style="display:inline-block;"></span>
                </a>
              </div>
            <? } ?>
        </td>
      </tr>
      <tr class="square">
        <td>
          <input <?= ($readOnly) ? 'readonly="readonly" disabled' : '' ?> type="text" id="num<?= $item->id ?>"
                                                                          name="num[<?= $item->id ?>]"
                                                                          value="<?= (isset($item->actual_num) &&
                                                                            $item->actual_num) ? $item->actual_num :
                                                                            $item->num ?>"
          />
        </td>
        <td align="right">
            <?
            if (DSConfig::getVal('source_show_old_price')) {
                $source_price = $item->price_no_discount;
                $taobao_delivery = 0;
                $sum_no_discount = $item->sum_no_discount;
            } else {
                if (DSConfig::getValDef('delivery_source_fee_in_price', 0) == 1) {
                    $source_price = $item->price;
                    $taobao_delivery = 0;
                } else {
                    $taobao_delivery = $item->sumDelivery;
                    if ($item->num && ($item->num > 0)) {
                        $source_price = Formulas::cRound(($item->sum - $taobao_delivery) / $item->num);
                    } else {
                        $source_price = 0;
                    }
                }
                $sum_no_discount = $item->sum;
            }
            if ($item->num && ($item->num > 0)) {
                $sum = $item->sum;
                $sumResUserPrice = $item->sumResUserPrice;
                $sum_no_discountResUserPrice = $item->sum_no_discountResUserPrice;
            } else {
                $sum = 0;
                $sumResUserPrice = 0;
                $sum_no_discountResUserPrice = 0;
                $sum_no_discount = 0;
                $taobao_delivery = 0;
            } ?>
          <div class="cost"
               style="padding:5px !important; width:145px !important; font: 400 15px 'Arial' !important;">
            <span style="color: black;">&nbsp;&times;&nbsp;</span><span
                title="<?= Yii::t('main', 'Стоимость 1 шт. товара') ?>"><?= Formulas::priceWrapper(
                    $source_price
                  ) ?></span>
              <? if (isset($taobao_delivery) && (DSConfig::getValDef('delivery_source_fee_in_price', 0) != 1)) { ?>
                <span style="color: black;">&nbsp;+&nbsp;</span><span
                    title="<?= Yii::t('main', 'Стоимость доставки от продавца') ?>"><?= Formulas::priceWrapper(
                        $taobao_delivery
                      ) ?></span>
              <? } ?>
          </div>
        </td>
        <td align="right">
          <div class="sum"
               style="padding:5px !important; width:80px !important; font: 400 15px 'Arial' !important;">
            <span style="color: black;">&nbsp;=&nbsp;</span>
              <? if ($sum != $sum_no_discount) { ?>
            <s>
                <? } ?>
              <span
                  title="<?=
                  (Yii::app()->user->inRole('superAdmin') && is_object(
                      $sum_no_discountResUserPrice
                    ) && (DSConfig::getVal(
                      'formulas_show_titles_hints'
                    ))) ? $sum_no_discountResUserPrice->report() : Yii::t(
                    'main',
                    'Стоимость лота с доставкой от продавца'
                  ); ?>"><?=
                  Formulas::priceWrapper(
                    (isset($item->status) && (in_array(
                        $item->status,
                        OrdersItemsStatuses::getOrderItemExcludedStatusesArray()
                      ))) ? 0 : $sum_no_discount
                  ) ?></span>
                <? if ($sum != $sum_no_discount) { ?>
            </s>
          <? } ?>
          </div>
        </td>
      </tr>
      <tr>
        <td width="120">
          <label <?= (DSConfig::getVal('checkout_weight_needed') != 1) ? 'hidden="hidden"' : '' ?>><?=
              Yii::t('main', 'Вес 1 шт, грамм') ?>:</label></td>
        <td>
          <input <?= ($readOnly) ? 'readonly="readonly" disabled' : '' ?> type="text" id="weight<?= $item->id ?>"
                                                                          name="weight[<?= $item->id ?>]"
                                                                          value="<?= (isset($item->calculated_actualWeight) &&
                                                                            $item->calculated_actualWeight) ?
                                                                            $item->calculated_actualWeight :
                                                                            $item->weight ?>"
            <?= (DSConfig::getVal('checkout_weight_needed') != 1) ? ' hidden="hidden"' : '' ?>
          />
        </td>
        <td align="right">
          <div class="sum">
              <? if ($sum != $sum_no_discount) { ?>
                <span title="<?=
                (Yii::app()->user->inRole('superAdmin') && is_object(
                    $sumResUserPrice
                  )) ? $sumResUserPrice->report() : ''; ?>">
                    <?=
                    Formulas::priceWrapper(
                      (isset($item->status) && (in_array(
                          $item->status,
                          OrdersItemsStatuses::getOrderItemExcludedStatusesArray()
                        ))) ? 0 : $sum
                    ) ?></span>
              <? } ?>
          </div>
        </td>
      </tr>
      <? if (isset($taobao_delivery) && DSConfig::getVal('source_show_old_price')) { ?>
        <tr>
          <td colspan="2">
              <? if (DSConfig::getVal('source_show_old_price')
                || Yii::app()->user->inRole(['manager', 'billManager', 'topManager', 'superAdmin'])
              ) { ?>
                <label><?= Yii::t('main', 'В т.ч. доставка от продавца') ?>:</label>
              <? } else { ?>
                &nbsp;
              <? } ?>
          </td>
          <td align="right">
              <? if (DSConfig::getVal('source_show_old_price')
                || Yii::app()->user->inRole(['manager', 'billManager', 'topManager', 'superAdmin'])
              ) { ?>
                <div class="cost">
                    <?=
                    (isset($item->status) && (in_array(
                        $item->status,
                        OrdersItemsStatuses::getOrderItemExcludedStatusesArray()
                      ))) ? Yii::t('main', '-') : Formulas::priceWrapper($taobao_delivery) ?>
                </div>
              <? } else { ?>
                &nbsp;
              <? } ?>
          </td>
        </tr>
      <? } ?>
      <tr>
        <td align="right" colspan="3">
            <? if (($item->num > 0) && !$readOnly && $allowDelete) { ?>
              <strong><?= Yii::t('main', 'Оставить в корзине') ?></strong>
              <input style="width: 30px !important;" type="checkbox"
                     name="store[<?= $item->id ?>]"
                     value="1" <?= ($item->store) ? ' checked ' : '' ?>
                     title="<?= Yii::t('main', 'Оставить лот в корзине после заказа (не удалять)') ?>">
              <br/>
            <? } ?>
            <? if (($item->num > 0) && !$readOnly && $allowDelete) { ?>
              <strong><?= Yii::t('main', 'Не включать в заказ') ?></strong>
              <input style="width: 30px !important;" type="checkbox"
                     name="order[<?= $item->id ?>]"
                     value="1" <?= (!$item->order) ? ' checked ' : '' ?>
                     title="<?= Yii::t('main', 'Не включать лот в текущий заказ') ?>">
            <? } ?>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</div>