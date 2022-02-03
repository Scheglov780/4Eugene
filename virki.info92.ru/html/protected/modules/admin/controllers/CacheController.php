<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CacheController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CacheController extends CustomAdminController
{

    public function actionClear($all = false)
    {
        if ($all) {
            if ($all == 2) {
                MainMenu::clearMenuCache();
                echo Yii::t('admin', "Кеш меню обновлен!");
            } else {
                try {
                    Yii::app()->fileCache->flush();
                    Yii::app()->cache->flush();
                    echo Yii::t('admin', "Кеш полностью очищен!");
                } catch (Exception $e) {
                    echo Yii::t('admin', "Кеш полностью очищен!");
                }
            }
        } else {
            try {
                Yii::app()->fileCache->gc();
                Yii::app()->cache->gc();
                echo Yii::t('admin', "Старый кэш очищен!");
            } catch (Exception $e) {
                echo Yii::t('admin', "Старый кэш очищен!");
            }
        }
    }

    public function actionIndex()
    {
        $this->pageTitle = Yii::t('admin', 'Управление кэшем');
        $this->renderPartial('index');
    }
}