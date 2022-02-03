<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="input_props_text.php">
 * </description>
 * Рендеринг блока выбора свойств товара в карте товара - для свойств с текстом
 **********************************************************************************************************************/
?>
<div class="row clearfix f-space10"></div><!--Отступ для блока-->
<div class="item-space-box-prop">
  <div class="input-props-text">

    <input hidden="hidden" id="input-<?= $pid ?>" class="input_params" value="0">

    <div class="item-props-info">

      <lable style="font-weight: bold;"><?= $prop->name ?></lable>

      <div class="item-props-select">
        <a href="#">
          <div class="select">
                        <span id="selres-<?= $pid ?>" style="color: red;"><?= Yii::t(
                              'main',
                              'Не выбрано'
                            ) ?></span>
          </div>
        </a>
        <ul class="selectable input-props-info-text" id="<?= $pid ?>" role="menu" aria-labelledby="dLabel">
            <? foreach ($prop->childs as $i => $val) { ?>
                <? if (trim($val->name) !== '') { ?>
                <li class="ui-widget-content prop" id="<?= $pid ?>:<?= $val->vid ?>"><?= $val->name ?></li>
                <? } ?>
            <? } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
