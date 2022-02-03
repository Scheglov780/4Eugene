<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="TranslationController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class TranslationController extends CustomAdminController
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
        $model = new IntTranslation('search');
        $isAjax = false;
        if (isset($_POST['search']) && isset($_POST['replace'])) {
            $isAjax = true;
            $model->search = $_POST['search'];
            $model->replace = $_POST['replace'];
            //$model->apply = (isset($_POST['apply']) && $_POST['apply']?true:false);
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
          true
        );

    }

    public function actionUpdate()
    {
        if (isset($_POST['translationList']) && count($_POST['translationList'])) {
            TSourceMessage::updateList($_POST['translationList']);
        }
        echo Yii::t('admin', 'Сохранено');
    }
}
