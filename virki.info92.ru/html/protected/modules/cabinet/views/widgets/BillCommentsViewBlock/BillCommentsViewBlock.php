<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillCommentsViewBlock.php">
 * </description>
 * Собственно, виджет для рендеринга одного комментария
 * var $message = 'test' - текст сообщения
 * var $blockId = 'order-message-view-75'
 * var $isItem = false - выводим комментарий для заказа или для лота? Там разница в логике отображения.
 * var $parentId ='75'
 * var $pageSize =5
 * var $imageFormat ='_200x200.jpg'
 * var $newAttaches = OrdersCommentsAttaches#1
 * (
 * [uploadedFile] => null
 * [CActiveRecord:_new] => true
 * [CActiveRecord:_attributes] => array
 * (
 * 'comment_id' => '75'
 * )
 **********************************************************************************************************************/
?>
<div>
    <?= $message ?>
</div>
<div>
    <? if (!$isItem) { ?>
        <?= OrdersCommentsAttaches::getAttachesPreview(
          $parentId,
          'application.modules.' . Yii::app()->controller->module->id . '.views.orders.commentattachpreview'
        ) ?>
        <?
    } else {
        ?>
        <?= OrdersItemsCommentsAttaches::getAttachesPreview(
          $parentId,
          'application.modules.' . Yii::app()->controller->module->id . '.views.orders.commentattachpreview'
        ) ?>
    <? } ?>
</div>
<div class="clear"></div>
<div>
  <div>
      <? $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
          'id'                     => 'form-img-' . $blockId,
          'enableAjaxValidation'   => false,
          'enableClientValidation' => false,
          'method'                 => 'post',
          'action'                 => [Yii::app()->createUrl("/message/addimage")],
          'type'                   => 'inline',
          'htmlOptions'            => [
            'enctype'       => 'multipart/form-data',
            'acceptcharset' => 'UTF-8',
            'target'        => 'upload-target-' . $blockId,
              //'onsubmit'=>"
              //alert('submt');
              //return false;",/* Disable normal form submit */
              //'onkeypress'=>" if(event.keyCode == 13){ update(); } " /* Do ajax call when user presses enter key
          ],
        ]
      );
      ?>
    <!--    <fieldset> -->
      <? echo $form->errorSummary($newAttaches, 'Opps!!!', null, ['class' => 'alert alert-error span12']); ?>
    <div class="comment-select">
      <iframe hidden="hidden" id="upload-target-<?= $blockId ?>" name="upload-target-<?= $blockId ?>"
              src="" style="width:0; height:0; border:0 solid #ffffff;"></iframe>
      <input type="hidden" value="<?= ($isItem) ? 1 : 0 ?>" name="isItem"/>
      <input type="hidden" value="<?= $blockId ?>" name="blockId"/>

        <?
        echo $form->hiddenField($newAttaches, 'comment_id', []);
        echo $form->fileField(
          $newAttaches,
          'uploadedFile',
          [
            'id'       => 'uploadedFile-' . $blockId,
            'accept'   => 'image/*',
            'capture'  => 'camera',
            'onchange' => "
                var imgForm = $('#form-img-" . $blockId . "');
                var grid = imgForm.closest('.grid-view');
                imgForm.submit();
                setTimeout( function() { // Delay for Chrome
                $.fn.yiiGridView.update($(grid).attr('id'));
                }, 100);
            ",
              // 4Mel
            'title'    => Yii::t('main', 'Добавить изображение'),
          ]
        );
        ?>

    </div>
    <div class="comment-select-btn">+</div>
  </div>
  <!--  </fieldset> -->
    <? $this->endWidget(); ?>
</div>