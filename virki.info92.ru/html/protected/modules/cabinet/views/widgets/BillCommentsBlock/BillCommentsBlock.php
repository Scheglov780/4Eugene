<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillCommentsBlock.php">
 * </description>
 * Виджет отображает комментарии заказа, например при просмотре заказа вкабинете
 * var $dataProvider =
 * CActiveDataProvider#1
 * ([modelClass] => 'OrdersComments'
 * [model] => OrdersComments#2
 * (
 * [attaches] => null
 * [fromName] => null
 * )
 * var $blockId = 'order-comments-1916'
 * var $isItem = false - комментарий не к заказу а к лоту?
 * var $parentId = '1916' -id заказа\лота, к которому принадлежит комментарий
 * var $public = true - виджет используется во фронте и не отображаются внутренние комментарии
 **********************************************************************************************************************/
?>
<div id="accordion-comments-<?= $blockId ?>" class="accordion-comments-dialog">
  <h3><i class="icon-file"></i><?= Yii::t('main', 'Комментарии и фотоотчеты') ?>: <?= $dataProvider->totalItemCount ?>
  </h3>

  <div>
    <div class="comment-block">
        <?
        $this->widget(
          'booster.widgets.TbGridView',
          [
            'id'           => 'grid-' . $blockId,
            'dataProvider' => $dataProvider,
            'type'         => 'striped bordered condensed',
            'template'     => '{items}{pager}', //{summary}{pager}
            'columns'      => [
              [
                'name'        => 'fromName',
                'type'        => 'raw',
                'htmlOptions' => ['style' => 'width:15%;font-size:0.9em;color:#00BCFF;'],
                'value'       => function ($data) {
                    return (($data->internal) ? '<i class="icon-lock"></i>' : '') .
                      '<span>' .
                      $data->fromName .
                      '</span>';
                },

              ],
              [
                'name'        => 'date',
                'htmlOptions' => ['style' => 'width:15%;font-size:0.9em;'],
              ],
              [
                'name'        => 'message',
                'type'        => 'raw',
                'htmlOptions' => ['style' => 'width:70%;'],
                'value'       => function ($data) {
                    return Yii::app()->controller->widget(
                      "application.modules.'.Yii::app()->controller->module->id.'.components.widgets.BillCommentsViewBlock",
                      [
                        "message"     => $data->message,
                        "itemId"      => $data->id,
                        "isItem"      => isset($data->item_id),
                        "pageSize"    => 5,
                        "imageFormat" => "_200x200.jpg",
                      ],
                      true
                    );
                },
              ],

            ],
          ]
        );
        ?>

      <div class="comment-btn-1">
          <?
          $this->widget(
            'bootstrap.widgets.TbButton',
            [
              'buttonType'  => 'button',
              'type'        => 'success',
              'size'        => 'mini',
              'icon'        => 'ok white',
              'label'       => Yii::t('main', 'Добавить комментарий'),
              'htmlOptions' => [
                'style'   => '',
                'onclick' => '
                     $("#new-message-' . $blockId . '").dialog({
                     autoOpen: false,
                     width: "auto",
                     modal: true,
                     resizable: false
                     });
                      $("#new-message-' . $blockId . '").dialog("open");false;',
              ],
            ]
          );
          ?>
      </div>
    </div>
    <div id="new-message-<?= $blockId ?>" title="<?= Yii::t('main', 'Новое сообщение') ?>" style="display: none;">
      <form id="new-message-form-<?= $blockId ?>">
          <? if ($isItem) { ?>
            <label><b><?= Yii::t('main', 'Комментарий к лоту') ?>:</b></label><br/>
              <?
          } else {
              ?>
            <label><b><?= Yii::t('main', 'Комментарий к заказу') ?>:</b></label><br/>
          <? } ?>
        <input type="hidden" name="message[isItem]" value="<?= (int) $isItem ?>"/>
        <input type="hidden" name="message[parentId]" value="<?= $parentId ?>"/>
        <textarea cols="80" rows="3" name="message[message]" id="message-<?= $blockId ?>"></textarea>
          <? if ($public) { ?>
            <input type="hidden" name="message[public]" value="1"/>
              <?
          } else {
              ?>
            <br><input type="checkbox" name="message[public]" value="1"/><?=
              Yii::t(
                'main',
                'Виден заказчику'
              ) ?>
          <? } ?>
      </form>
      <br/>
      <button id="ok-<?= $blockId ?>" onclick="
          $('#new-message-<?= $blockId ?>').dialog('close');
          var msg = $('#new-message-form-<?= $blockId ?>').serialize();
          $.post('<?= Yii::app()->createUrl('/') ?>message/create',msg, function(){
          $('#message-<?= $blockId ?>').val('');
          $.fn.yiiGridView.update('grid-<?= $blockId ?>');
          },'text');
          return false;"><?= Yii::t('main', 'Сохранить') ?></button>
      &nbsp;&nbsp;
      <button id="cancel" onclick="$('#new-message-<?= $blockId ?>').dialog('close');
          $('#message-<?= $blockId ?>').val('');
          return false;"><?= Yii::t('main', 'Отмена') ?></button>
      <br><br>
    </div>
  </div>
</div>
<hr/>

<script type="text/javascript">
    $(function () {
        $("#accordion-comments-<?=$blockId?>").accordion({
            collapsible: true,
            heightStyle: 'content',
            active: <?=(($dataProvider->totalItemCount > 0) ? '0' : 'false')?>
        });
    });
</script>



