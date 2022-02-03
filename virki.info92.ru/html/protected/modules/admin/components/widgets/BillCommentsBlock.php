<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillCommentsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class BillCommentsBlock extends CustomWidget
{

    public $imageFormat = '_160x160.jpg';
    public $orderId = false;
    public $orderItemId = false;
    public $pageSize = 5;
    public $public = true;
    public $showInternals = 0;

    public function run()
    {
        if ($this->orderId) {
            $dataProvider = OrdersComments::getOrderComments($this->orderId, $this->showInternals, $this->pageSize);
            $blockId = 'order-comments-' . $this->orderId;
            $parentId = $this->orderId;
            $isItem = false;
        } elseif ($this->orderItemId) {
            $dataProvider = OrdersItemsComments::getOrderItemComments(
              $this->orderItemId,
              $this->showInternals,
              $this->pageSize
            );
            $blockId = 'order-item-comments-' . $this->orderItemId;
            $parentId = $this->orderItemId;
            $isItem = true;
        } else {
            return;
        }
        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.BillCommentsBlock.BillCommentsBlock',
          [
            'dataProvider' => $dataProvider,
            'blockId'      => $blockId,
            'isItem'       => $isItem,
            'parentId'     => $parentId,
            'public'       => $this->public,
          ]
        );
        /*      echo '<script type="text/javascript">
        $(function () {
                $("#new-message-'.$blockId.'").dialog({
                    autoOpen: false,
                    width: "auto",
                    modal: true,
                    resizable: false
                });
                $("#accordion-comments-'.$blockId.'").accordion({
                    collapsible: true,
                    active: '.(($dataProvider->totalItemCount>0) ? '0' : 'false').'
        });
        });
        </script>';
        */
    }
}
