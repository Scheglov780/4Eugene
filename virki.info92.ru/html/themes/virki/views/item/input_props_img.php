<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="input_props_img.php">
 * </description>
 * Рендеринг блока выбора свойств товара в карте товара - для свойств с изображениями
 **********************************************************************************************************************/
?>
<div class="row clearfix f-space10"></div><!--Отступ для блока-->
<div class="item-space-box-prop">
  <div class="input-props-images">
    <div>
      <span style="font-weight: bold;"><?= $prop->name ?></span>
      <input hidden="hidden" id="input-<?= $pid ?>" class="input_params" value="0">
    </div>
    <div class="select">
      <span id="selres-<?= $pid ?>"><?= Yii::t('main', 'Не выбрано') ?></span>
    </div>
    <div>
      <ul class="selectable" id="<?= $pid ?>">
          <? foreach ($prop->childs as $i => $val) { ?>
              <? if (trim($val->name) !== '') { ?>
                  <? if ($val->url == '') { ?>
                <li class="ui-widget-content" style="width: auto; height: auto;"
                    id="<?= $pid ?>:<?= $val->vid ?>"><?= $val->name ?></li>
                  <? } else { ?>
                <li class="ui-widget-content" style="vertical-align: top;"
                    id="<?= $pid ?>:<?= $val->vid ?>">
                    <? //$imgTitle = Yii::app()->DVTranslator->translateHtmlProperty($val->name_zh,'zh',Utils::appLang());
                    $imgTitle = Utils::removeOnlineTranslation($val->name);
                    $imgPath = Img::getImagePath($val->url, '_40x40.jpg', false); ?>
                  <img title="<?= $imgTitle ?>" src="<?= $imgPath ?>">
                </li>
                  <? } ?>
              <? } ?>
          <? } ?>
      </ul>
    </div>
  </div>
</div>

