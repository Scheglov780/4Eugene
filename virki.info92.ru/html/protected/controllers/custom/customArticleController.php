<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ArticleController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customArticleController extends CustomFrontController
{

    public function actionIndex($url = false)
    {
        $this->httpCache();
        if (!$url) {
            $this->pageTitle = Yii::t('main', 'Все статьи');
            $this->breadcrumbs = [
              $this->pageTitle,
            ];
            $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;

            $sql = "
        SELECT \"id\",\"parent\",\"order_in_level\",
        (SELECT count(0)  as cnt FROM cms_pages pp2 WHERE pp.id = pp2.parent) AS children,
        (SELECT cc.title FROM cms_pages_content cc WHERE cc.page_id = pp.page_id
          ORDER BY cc.lang=:lang DESC, cc.lang='*' DESC LIMIT 1) AS title,
        (SELECT cc.description FROM cms_pages_content cc WHERE cc.page_id = pp.page_id
          ORDER BY cc.lang=:lang DESC, cc.lang='*' DESC LIMIT 1) AS description,          
        (SELECT string_agg(concat(pc2.id,'-',pc2.lang), ',') as content FROM cms_pages_content pc2 WHERE pc2.page_id = pp.page_id) AS content,
        \"page_id\",\"url\", \"enabled\", \"SEO\"
          FROM \"cms_pages\" pp
          WHERE (pp.parent NOT IN (SELECT pf.id FROM cms_pages pf WHERE pf.page_id LIKE '@%'))
        ORDER BY pp.parent=1 DESC, pp.parent, pp.order_in_level, pp.id
        ";
            $articles = Yii::app()->db->createCommand($sql)->queryAll(true, [':lang' => Utils::appLang()]);
            $this->render('list', ['articles' => $articles]);
        } else {
            $page = CmsPages::model()->find('url=:url', [':url' => $url]);
            if ($page) {
                $id = $page->page_id;
            } else {
                $id = $url;
            }
            try {
                $article = cms::pageContent($id);
                if (!$page) {
                    $this->pageTitle = Yii::t('main', 'Эта страница не существует');
                    $this->breadcrumbs = [
                      $this->pageTitle,
                    ];
                    $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;

                    if (!in_array(Yii::app()->user->role, ['contentManager', 'topManager', 'superAdmin'])) {
                        throw new CHttpException(404, Yii::t('main', 'Эта страница не существует'));
                    } else {
                        header('HTTP/1.1 404 Not found', true, 404);
                        $this->render('new', ['article' => $article]);
                    }
                } else {
                    $this->breadcrumbs = [
                      $this->pageTitle,
                    ];
                    $this->pageTitle = DSConfig::getVal('site_name') . ' | ' . $this->pageTitle;
                    $this->render('index', ['article' => $article]);
                }
            } catch (Exception $e) {
                throw new CHttpException(404, Yii::t('main', 'Эта страница не существует'));
            }
        }
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