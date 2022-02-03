<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="UserNotice.php">
 * </description>
 * Виджет всплывающего сообщения
 **********************************************************************************************************************/
?>
<div id="message-block" class="notice">
  <a href="<?= Yii::app()->createUrl('/user/notice') ?>" id="message-close"></a>
    <? foreach ($notices as $key => $notice) { ?>
      <div class="message blue" id="message-<?= $key ?>">
        <div class="message-text">
            <? switch ($notice->status) {
                case 1:
                    $notice->data = CJSON::decode($notice->data);
                    ?>
                  <h3 class="title"><?= Yii::t('main', 'Возврат средств') ?>!</h3>
                  <a href="<?= Yii::app()->createUrl(
                    '/item/index',
                    ['iid' => $notice->data['iid'], 'dsSource' => $notice->data['ds_source']]
                  ) ?>"
                     style="float: left; margin: 0 10px 10px 0;">
                    <img src="<?= $notice->data['pic_url'] ?>_40x40.jpg" alt=""/>
                  </a>
                    <?= $notice->msg ?>
                    <? break;
                case 2:
                    $notice->data = CJSON::decode($notice->data);
                    ?>
                  <h3 class="title"><?= Yii::t('main', 'Оплата по заказу') ?>!</h3>
                    <? $checkout_order_reconfirmation_needed = DSConfig::getVal(
                    'checkout_order_reconfirmation_needed'
                  ) == 1;
                    if ($checkout_order_reconfirmation_needed) {
                        $order = Order::model()->findByPk($notice->data['oid']);
                        ?>
                        <?=
                        Yii::t(
                          'main',
                          'В результате уточнения стоимости заказа и доставки, по заказу'
                        ) ?> №<?= Yii::app()->user->id . '-' . $notice->data['oid'] ?> <?=
                        Yii::t(
                          'main',
                          'Вам необходимо оплатить'
                        ) ?>
                      <b><?=
                          Formulas::priceWrapper(
                            Formulas::convertCurrency(
                              $notice->sum + $order->sum,
                              DSConfig::getVal('site_currency'),
                              DSConfig::getCurrency()
                            )
                          ) ?></b>
                        <?
                    } else {
                        ?>
                        <?= Yii::t('main', 'В результате перерасчета, по заказу') ?> №<?=
                        Yii::app()->user->id . '-' . $notice->data['oid'] ?> <?=
                        Yii::t(
                          'main',
                          'Вам необходимо оплатить'
                        ) ?>
                      <b><?=
                          Formulas::priceWrapper(
                            Formulas::convertCurrency(
                              $notice->sum,
                              DSConfig::getVal('site_currency'),
                              DSConfig::getCurrency()
                            )
                          ) ?></b>
                    <? } ?>
                  <p>
                    <a href="<?=
                    Yii::app()
                      ->createUrl(
                        '/cabinet/balance/order',
                        ['oid' => $notice->data['oid']]
                      ) ?>"><?= Yii::t('main', 'сделать это прямо сейчас') ?></a>
                  </p>
                    <? break;
                case 3:
                    ?>
                  <h3 class="title"><?= Yii::t('main', 'Возврат средств') ?>!</h3>
                    <?= $notice->msg ?><br/>
                  <b><?= Yii::t('main', 'возвращено') ?> <?=
                      DSConfig::getVal(
                        'site_currency'
                      ) ?><?=
                      $notice->sum ?>.</b>
                    <? break;
                case 5:
                    ?>
                  <h3 class="title"><?= Yii::t('main', 'Смена способа доставки') ?>!</h3>
                  <p>
                      <?= $notice->msg ?>
                  </p>
                    <? break;
                case 6:
                    ?>
                  <h3 class="title"><?= Yii::t('main', 'Вам сообщение') ?>!</h3>
                  <p>
                      <?= $notice->msg ?>
                  </p>
                    <? break;
                default:
                    ?>
                  <h3 class="title"><?= Yii::t('main', 'Вам сообщение') ?>!</h3>
                  <p>
                      <?= $notice->msg ?>
                  </p>
                    <? break;
            } ?>
        </div>
        <div class="message-bottom"></div>
      </div>
    <? } ?>
</div>