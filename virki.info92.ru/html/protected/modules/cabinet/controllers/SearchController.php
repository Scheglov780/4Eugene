<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="SearchController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class SearchController extends CustomCabinetController
{
    public $breadcrumbs;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
//      $session=new CHttpSession;
//      $session->open();
//      $criteria = new CDbCriteria();
        $model = new IntSearch('search');
        $isAjax = false;
        if (isset($_GET['query'])) {
            $isAjax = true;
            $model->query = $_GET['query'];
//          if (!empty($model->query)) $criteria->addCondition('query = "'.$model->query.'"');
        }
//      $session['Search_records']=Search::model()->findAll($criteria);
        $this->renderPartial(
          'index',
          [
            'isAjax' => $isAjax,
            'model'  => $model,
          ],
          false,
          true,
          true
        );

    }
}
