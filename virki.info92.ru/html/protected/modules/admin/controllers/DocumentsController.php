<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DeviesController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DocumentsController extends CustomAdminController
{
    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->renderPartial(
          'index',
          [
          ],
          false,
          true
        );

    }
}
