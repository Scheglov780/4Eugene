<?php

class CmsHistoryController extends CustomAdminController
{
    public $breadcrumbs;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    public function actionRestore()
    {
        // Uncomment the following line if AJAX validation is needed
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['id'])) {
                $model = CmsContentHistory::model()->findByPk($_POST['id']);
                if ($model) {
                    $content = $model->content;
                    $content_id = $model->content_id;
                    $lang = $model->lang;

                    if ($model['table_name'] == 'cms_menus') {
                        Yii::app()->db->createCommand(
                          "UPDATE cms_menus tt
            SET menu_data = :menu_data
            WHERE tt.menu_id=:menu_id"
                        )->execute(
                          [
                            ':menu_data' => $content,
                            ':menu_id'   => $content_id,
                          ]
                        );
                    } elseif ($model['table_name'] == 'cms_pages_content') {
                        Yii::app()->db->createCommand(
                          "UPDATE cms_pages_content tt
            SET content_data = :content_data
            WHERE tt.page_id=:content_id AND tt.lang=:lang"
                        )->execute(
                          [
                            ':content_data' => $content,
                            ':content_id'   => $content_id,
                            ':lang'         => $lang,
                          ]
                        );
                    } elseif ($model['table_name'] == 'cms_custom_content') {
                        Yii::app()->db->createCommand(
                          "UPDATE cms_custom_content tt
            SET content_data = :content_data
            WHERE tt.content_id=:content_id AND tt.lang=:lang"
                        )->execute(
                          [
                            ':content_data' => $content,
                            ':content_id'   => $content_id,
                            ':lang'         => $lang,
                          ]
                        );
                    }
                    echo Yii::t('admin', 'Контент восстановлен из истории изменений');
                } else {
                    echo Yii::t('admin', 'Ошибка восстановления контента из истории изменений');
                }
            }
            return;
        }
    }
}
