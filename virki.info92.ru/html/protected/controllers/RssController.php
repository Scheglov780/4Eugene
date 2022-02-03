<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SiteController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * SiteController is the default controller to handle user requests.
 */
class RssController extends CustomFrontController
{

    public function actionIndex()
    {

        $feed = Yii::app()->db->createCommand(
          "SELECT * FROM blog_posts WHERE enabled = 1 ORDER BY created DESC LIMIT 30"
        )->queryAll();

        $this->renderPartial('index', ['feed' => $feed]);

    }

    public function actionSitemap()
    {
        echo SEOUtils::GetSitemap();
    }

    public function filters()
    {
        if (AccessRights::GuestIsDisabled()) {
            return array_merge(
              [
                'Rights', // perform access control for CRUD operations
              ],
              parent::filters()
            );
        } else {
            return parent::filters();
        }
    }

}