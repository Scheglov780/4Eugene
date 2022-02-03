<? /*******************************************************************************************************************
 * This file is the part of "DropShop" taobao(c) showcase project http://dropshop.pro
 * Copyright (C) 2013 - 2014 DanVit Labs http://danvit.ru
 * All rights reserved and protected by law. Certificate #40514-UA 21.12.2013
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="BillsListBlock.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class BillsListBlock extends CustomWidget
{

    public $editable = false;
    public $filter = false;
    public $idPrefix = '';
    public $manager = null;
    public $model = null;
    public $name = false;
    public $narrowView = false;
    public $orderBy = '';
//  public $manager = null;
    public $pageSize = 25;
    public $type = false;
    public $uid = null;

    public function run()
    {
        if ($this->name == false) {
            $this->name = Yii::t('main', 'Список выставленных счетов');
        } else {
            $this->name = 'Счета по статусу: ' . $this->name;
        }
//=================================================================================
        if (is_null($this->manager)) {
            if (is_null($this->uid)) {
                if (Yii::app()->user->inRole(['superAdmin', 'topManager'])) {
                    $this->manager = null;
                } elseif (Yii::app()->user->inRole(['billManager'])) {
                    $this->manager = Yii::app()->user->id;
                } else {
                    $this->uid = Yii::app()->user->id;
                    $this->manager = null;
                }
            }
        }
        $dataProvider = Bills::getAdminBillsList(
          $this->type,
          $this->uid,
          $this->manager,
          $this->pageSize,
          $this->orderBy,
          $this->model
        );
        if ($this->filter) {
            $filter = ($this->model ? $this->model : $dataProvider->model);
        } else {
            $filter = null;
        }
        if (in_array($this->type, ['CANCELED_BY_SERVICE', 'PAUSED'])) {
            $color = 'default';
        } elseif (in_array($this->type, ['CONFIRMED'])) {
            $color = 'success';
        } elseif (in_array($this->type, ['PAID', 'ACCEPTED', '20', '30', '40'])) {
            $color = 'warning';
        } elseif (in_array($this->type, ['EXPIRED'])) {
            $color = 'danger';
        } else {
            $color = 'info';
        }

//=================================================================================
        $this->render(
          'application.modules.' . Yii::app()->controller->module->id . '.views.widgets.BillsListBlock.BillsListBlock',
          [
            'dataProvider' => $dataProvider,
            'type'         => $this->type,
            'name'         => $this->name,
            'editable'     => $this->editable,
            'idPrefix'     => $this->idPrefix,
            'filter'       => $filter,
            'narrowView'   => $this->narrowView,
            'color'        => $color,
          ]
        );
    }
}
