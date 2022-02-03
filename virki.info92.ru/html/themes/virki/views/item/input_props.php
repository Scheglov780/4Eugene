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
<? if ((is_array($input_props) || $input_props instanceof ArrayAccess) && (count($input_props) > 0)) { ?>
    <? foreach ($input_props as $pid => $prop) {
        if (isset($prop->haveImages) && $prop->haveImages) {
            echo Yii::app()->controller->renderPartial(
              'input_props_img',
              ['pid' => $pid, 'prop' => $prop],
              true,
              false
            );
        } else {
            echo Yii::app()->controller->renderPartial(
              'input_props_text',
              ['pid' => $pid, 'prop' => $prop],
              true,
              false
            );
        }
    }
    $script = /** @lang JavaScript */
      '
        $(".selectable").selectable(
          {
              filter: "li",
//    tolerance: "fit",
              stop: function (event, ui) {
                  var el_id = $(this).attr("id");
                  var result = $("#selres" + "-" + el_id).empty();
                  $("#input" + "-" + el_id).prop("value", 0);
                  var liobj = $("#" + el_id + " .ui-selected");
                  var liobjId = undefined;
                  if (liobj !== undefined) {
                      liobjId = liobj.prop("id");
                      if (liobjId !== undefined) {
                          $("#input" + "-" + el_id).prop("value", liobjId);
                          if (liobj.html().match(/<\s*img/i)) {
                          var liobjImg = $("#" + el_id + " .ui-selected img").prop("src");
                          var smallImg=liobjImg.replace(\'_40x40.\',\'_360x360.\');
                          var bigImg=liobjImg.replace(\'_40x40.jpg\',\'\');
                          MagicZoom.update(\'Zoomer\', bigImg, smallImg, \'\');
                          }
                          result.append(liobj.html());
                          reloadSku();
                      } else {
                          $("#input" + "-" + el_id).prop("value", 0);
                          result.append("' . Yii::t('main', 'Не выбрано') . '");
                          $("#item_num").html("&dash;&dash;&dash;");
                          $("#item_totalcount").prop("value", 0);
                          $("#inputprops-processed").prop("value", 0);
                          $(".buy-btn").prop("disabled", true);
                          $("#buy-btn-cart").prop("disabled", true);
                          //$("#buy-btn-buy").prop("disabled", true);                          
                      }
                  }
              }
          }
        );';

} elseif ($totalCount > 0) {
    $script = '$("#buy-btn-cart").removeAttr("disabled"); $(".buy-btn").removeAttr("disabled");';
} else {
    $script = '';
}
if (Yii::app()->request->isAjaxRequest) {
    echo '<script>' . $script . '</script>';
} else {
    Yii::app()->clientScript->registerScript('inputProps', $script, CClientScript::POS_READY);
}