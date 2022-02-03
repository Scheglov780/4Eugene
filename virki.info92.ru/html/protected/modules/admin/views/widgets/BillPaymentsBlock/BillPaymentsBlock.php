<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillPaymentsBlock.php">
 * </description>
 * Виджет отображает платежи по заказу
 * var $dataProvider = CActiveDataProvider#1
 * (
 * [modelClass] => 'OrdersPayments'
 * )
 * var $blockId = 'order-payments-1916'
 **********************************************************************************************************************/
?>
<? $this

->widget(
'booster.widgets.TbGridView',
['id' => 'profile-bill-payments-grid-' . $blockId,
'dataProvider' => $dataProvider,
'type' => 'striped bordered condensed',
'template' => '{summary}{items}{pager}', //{summary}{pager}
'responsiveTable' => true,
'columns' => [[
  'name'  => 'manager_name',
  'type'  => 'raw',
  'value' => function ($data) {
      return Utils::fullNameWithInitials($data->manager_name);
  }
    //'htmlOptions' => array('style' => 'width:50px;font-size:0.9em;'),
],
[
  'name'  => 'summ',
  'type'  => 'raw',
  'value' => function ($data) {
      return sprintf('%01.2f', $data->summ);
  },
],
[
  'name'  => 'date',
  'type'  => 'raw',
  'value' => function ($data) {
      return Utils::pgDateToStr($data->date);
  }
    //'htmlOptions' => array('style' => 'width:45px;font-size:0.9em;'),
],
[
  'name'  => 'descr',
  'type'  => 'raw',
  'value' => function ($data) {
      return Yii::t('main', $data->descr);
  },
],
[
  'name'  => 'manager_name',
  'type'  => 'raw',
  'value' => function ($data) {
      return Utils::fullNameWithInitials($data->manager_name);
  }
    //'htmlOptions' => array('style' => 'width:50px;font-size:0.9em;'),
],
[
  'name'   => 'bid',
  'type'   => 'raw',
  'header' => 'Счёт',
  'value'  => function ($data) {
      return $data->code;
  },
],
['type' => 'raw',
'value' => function ($data) {
if ($data->bid) {
?>
<div class="btn-group" role="group">
  <a href='//<?= DSConfig::getVal('site_domain') ?>/blanks/bill?code=<?= $data->code ?>'
     target="_blank" title="Печать"
     class='btn btn-default btn-sm'><i class='fa fa-print'></i></a>
    <?
    }
    },],],]
    );
    ?>
