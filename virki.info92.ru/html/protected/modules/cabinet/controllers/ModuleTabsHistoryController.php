<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleTabsHistoryController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class ModuleTabsHistoryController extends CustomCabinetController
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
        $model = new ModuleTabsHistory('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['ModuleTabsHistory'])) {
            $model->attributes = $_GET['ModuleTabsHistory'];
        }
//        Yii::app()->session->add('ModuleTabsHistory_records',ModuleTabsHistory::model()->findAll($criteria));
        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );

    }

    public function actionLog()
    {
        $model = new ModuleTabsHistory;
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['ModuleTabsHistory'])) {
                $model->attributes = $_POST['ModuleTabsHistory'];
                $model->href = preg_replace('/^([\/])*[a-z]{2}\//is', '\1', $model->href);
                $model->uid = Yii::app()->user->id;
                $model->module = Yii::app()->controller->module->id;
                $model->date = date("Y-m-d H:i:s", time());
                $model->save();
            }
        }
        Yii::app()->end();
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = ModuleTabsHistory::model()->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }
}
