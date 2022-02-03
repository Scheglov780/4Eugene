<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="seller_info.php">
 * </description>
 * Рендеринг информации о продавце
 **********************************************************************************************************************/
?>
<div class="newshow">
    <? if (isset($seller) && $seller) { ?>
        <? // Информация о продавце из товара ?>
      <label><?= Yii::t('main', 'Продавец') ?>&nbsp;(ID:<?= $seller->user_id ?>):</label>
      <a href="<?= Yii::app()->createUrl(
        '/seller/index',
        [
          'nick'            => $seller->seller_nick,
          'seller_id'       => $seller->user_id,
          'encryptedUserId' => (isset($seller->encryptedUserId) ? $seller->encryptedUserId : ''),
        ]
      ) ?>" class="seller-name">
          <?= $seller->seller_nick ?> ( <?= Yii::t('main', 'Все товары продавца') ?> )
      </a>
        <? if (isset($seller->city) && (string) $seller->city) { ?><br>
        <label><?= Yii::t('main', 'Находится в') ?>:</label>
            <?= $seller->city ?>
            <?
        } ?>
      <br/>
        <? // Рейтинги - откуда и какие есть ?>
      <div id="seller-info-block">
        <label><?= Yii::t('main', 'Рейтинг') ?>:</label>
          <?= Yii::t('main', 'загрузка данных...'); ?>
          <? if (!Yii::app()->request->isPostRequest &&
            !Yii::app()->request->isAjaxRequest &&
            !(isset($this->preLoading) && $this->preLoading)
          ) { ?>
            <script>
                var seller = 'seller=<?=urlencode(serialize($seller))?>';
                try {
                    $.post('//data.' + document.domain + '/<?=Utils::appLang(
                    )?>/seller/sellerInfo', seller, function (data) {
                        $('#seller-info-block').html(data);
                    }, 'text');
                } catch (err) {
                    console.log('Tb error: no seller info');
                }
            </script>
          <? } ?>
      </div>
    <? } ?>
</div>