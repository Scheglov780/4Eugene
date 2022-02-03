<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillCommentsViewBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class BillCommentsViewBlock extends CustomWidget
{
    public $imageFormat = '_160x160.jpg';
    public $isItem = false;
    public $itemId = false;
    public $message;
    public $pageSize = 5;

    public function run()
    {
        if (!$this->isItem) {
            $newAttaches = new OrdersCommentsAttaches();
            $blockId = 'order-message-view-' . $this->itemId;
        } else {
            $newAttaches = new OrdersItemsCommentsAttaches();
            $blockId = 'order-item-message-view-' . $this->itemId;
        }
        $parentId = $this->itemId;
        $newAttaches->comment_id = $this->itemId;
        $newAttaches->scenario = 'update';

        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.BillCommentsViewBlock.BillCommentsViewBlock',
          [
//      'dataProvider' => $dataProvider,
            'message'     => $this->message,
            'blockId'     => $blockId,
            'isItem'      => $this->isItem,
            'parentId'    => $parentId,
            'pageSize'    => $this->pageSize,
            'imageFormat' => $this->imageFormat,
            'newAttaches' => $newAttaches,
          ]
        );
    }
}
