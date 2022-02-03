<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillPaymentsBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?

class BillPaymentsBlock extends CustomWidget
{

    public $billId = false;
    public $pageSize = 20;
    public $userId = false;

    public function run()
    {
        /*
        if (($this->billId === false) && ($this->userId === false)) {
            return;
        }
        */
        $dataProvider = BillsPayments::getBillPayments($this->billId, $this->pageSize, false, $this->userId);
        $blockId =
          'bill-payments-' . ($this->billId ? $this->billId : 'all') . '-' . ($this->userId ? $this->userId : 'all');
        $this->render(
          'application.modules.' .
          Yii::app()->controller->module->id .
          '.views.widgets.BillPaymentsBlock.BillPaymentsBlock',
          [
            'dataProvider' => $dataProvider,
            'blockId'      => $blockId,
          ]
        );
    }
}
