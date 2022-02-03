<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DefaultController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?

class customDefaultController extends CustomFrontController
{
    public function actionIndex()
    {
        $this->body_class = 'cabinet';
        $this->pageTitle = Yii::t('main', 'Личный кабинет');
        $this->breadcrumbs = [
          $this->pageTitle,
        ];
        $uid = Yii::app()->user->id;
        $ordersByStatuses = [];//OrdersStatuses::getAllStatusesListAndOrderCount($uid);
        $user = Users::model()->findByPkEx($uid);
        $this->render(
          'webroot.themes.' . $this->frontTheme . '.views.cabinet.index',
          [
            'user' => $user,
            'ordersByStatuses' => $ordersByStatuses,
          ]
        );
    }

    public function filters()
    {
        return array_merge(
          [
            'Rights', // perform access control for CRUD operations
          ],
          parent::filters()
        );
    }
}