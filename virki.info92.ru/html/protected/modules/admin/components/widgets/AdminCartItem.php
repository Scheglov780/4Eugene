<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="OrderItem.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class AdminCartItem extends CustomWidget
{
    public $allowDelete = true;
    public $imageFormat = '_160x160.jpg';
    public $orderItem = false;
    public $readOnly = false;

    public function run()
    {
        try {
            if (!$this->orderItem) {
                return;
            }
            $viewPath =
              'application.modules.' .
              Yii::app()->controller->module->id .
              '.views.widgets.AdminCartItem.AdminCartItem';
            $this->render(
              $viewPath,
              [
                'item'        => $this->orderItem,
                'readOnly'    => $this->readOnly,
                'allowDelete' => $this->allowDelete,
                'imageFormat' => $this->imageFormat,
              ]
            );
        } catch (Exception $e) {
            return;
        }
    }
}
