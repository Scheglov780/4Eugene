<?php

class CmsPagesContentController extends CustomAdminController
{
    public $breadcrumbs;
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = 'main';

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model, $form_id)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === $form_id) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $model = new CmsPagesContent;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmspagescontent-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['CmsPagesContent'])) {
                $model->attributes = $_POST['CmsPagesContent'];
                if (!$model->page_id) {
                    $model->page_id = uniqid('page');
                }
                $pageExists =
                  CmsPages::model()->findBySql(
                    "select * from cms_pages where page_id = :page_id",
                    [':page_id' => $model->page_id]
                  );
                if (!$pageExists) {
                    $page = new CmsPages();
                    $page->page_id = $model->page_id;
                    $page->parent = 1;
                    $page->order_in_level = 0;
                    $page->url = $model->page_id;
                    $page->enabled = 1;
                    $page->SEO = 1;
                    $pageExists = $page->save();
                }
                if ($pageExists && $model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['CmsPagesContent'])) {
                $model->attributes = $_POST['CmsPagesContent'];
                $model->save();

            }

            $this->render(
              'create',
              [
                'model' => $model,
              ]
            );
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete()
    {
        $id = $_POST["id"];

        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset(Yii::app()->request->isAjaxRequest)) {
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : ['index']);
            } else {
                echo "true";
            }
        } else {
            if (!isset($_GET['ajax'])) {
                throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
            } else {
                echo "false";
            }
        }
    }

    public function actionExportHTML()
    {
        $currLang = Utils::appLang();
        if (!isset($_FILES['uploadedFile'])) {
            $data = Yii::app()->db->createCommand(
              "select id, page_id as content_id, content_data, title, description, keywords from cms_pages_content where (lang='{$currLang}' or lang='*') order by content_id"
            )->queryAll();
            header('Content-Type: application/msword');
            $filename = 'cms_pages_content.html';
            header('Content-Disposition: attachment; charset=UTF-8; filename="' . $filename . '"');
            ?>
          <!DOCTYPE html PUBLIC  "-//W3C//DTD XHTML 1.0 Strict//EN"
              "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
          <html xmlns="http://www.w3.org/1999/xhtml">
          <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
          </head>
          <body>
          <table cellspacing="2" border="1" cellpadding="5" width="99%">
              <? foreach ($data as $i => $rec) { ?>
                <tr>
                  <td width="10%">ID:<?= $rec['id'] ?> CID:<?= $rec['content_id'] ?></td>
                    <?
                    $renderedContent = cms::pageContent($rec['content_id']);
                    if (is_object($renderedContent) && isset($renderedContent->content)) {
                        $content = $renderedContent->content;
                    } else {
                        $content = $renderedContent;
                    }
                    ?>
                  <td width="10%"
                      id="<?= 'cms_pages_content-title-' . $rec['id'] ?>"><?= ($rec['title'] ? $rec['title'] :
                        'title'); ?></td>
                  <td width="10%"
                      id="<?= 'cms_pages_content-description-' . $rec['id'] ?>"><?= ($rec['description'] ?
                        $rec['description'] : 'description'); ?></td>
                  <td width="10%"
                      id="<?= 'cms_pages_content-keywords-' . $rec['id'] ?>"><?= ($rec['keywords'] ? $rec['keywords'] :
                        'keywords'); ?></td>
                  <td id="<?= 'cms_pages_content-' . $rec['id'] ?>"><?= $content; ?></td>
                </tr>
                  <?
              }
              ?>
          </table>
          </body>
          </html> <?
            Yii::app()->end();

        } elseif (isset($_FILES['uploadedFile']['tmp_name']) && ($_FILES['uploadedFile']['error'] == 0)) {

            $src = file_get_contents($_FILES['uploadedFile']['tmp_name']);
            $config = [
              'clean' => 'yes',
              'output-html' => 'yes',
//              'show-body-only'=>true,
//              'merge-divs'=>true,
//              'merge-spans'=>true,
            ];
            $tidy = @tidy_parse_string($src, $config, 'utf8');
            if (isset($tidy) && $tidy) {
                $tidy->cleanRepair();
                if (isset($tidy->value) && $tidy->value) {
                    $src = $tidy->value;
                }
            }
            $doc = new DOMDocument();
            $loaded = $doc->loadHTML($src);
            if ($loaded) {
                $arr = $doc->getElementsByTagName("td");
                foreach ($arr as $td) {
                    $id = $td->getAttribute('id');
                    if ($id && preg_match('/catdescr\-/', $id)) {
                        $id = str_replace('catdescr-', '', $id);
                        $text = $td->nodeValue;
                        $text = trim($text);
                        if (!($text) || preg_match('/^none$/i', $text)) {
                            continue;
                        }
                        $cat = MainMenu::model()->findByPk($id);
                        if ($cat) {
                            cms::setMeta($text, $cat->url, 'text', $currLang);
                        }
                    }
                }
            }
            $this->redirect('/admin');
        }

    }

    public function actionGenerateExcel()
    {
        if (Yii::app()->session->contains('CmsPagesContent_records')) {
            $model = Yii::app()->session->get('CmsPagesContent_records');
        } else {
            $model = CmsPagesContent::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'PagesContent-' . date('YmdHis') . '.xls',
          $this->renderPartial(
            'excelReport',
            [
              'model' => $model,
            ],
            true,
            false,
            true
          )
        );
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {


        $model = new CmsPagesContent('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['CmsPagesContent'])) {
            $model->attributes = $_GET['CmsPagesContent'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->page_id)) {
//                $criteria->addCondition('page_id = "' . $model->page_id . '"');
//            }
//
//            if (!empty($model->lang)) {
//                $criteria->addCondition('lang = "' . $model->lang . '"');
//            }
//
//            if (!empty($model->content_data)) {
//                $criteria->addCondition('content_data = "' . $model->content_data . '"');
//            }
//
//            if (!empty($model->title)) {
//                $criteria->addCondition('title = "' . $model->title . '"');
//            }
//
//            if (!empty($model->description)) {
//                $criteria->addCondition('description = "' . $model->description . '"');
//            }
//
//            if (!empty($model->keywords)) {
//                $criteria->addCondition('keywords = "' . $model->keywords . '"');
//            }

        }
//        Yii::app()->session->add('CmsPagesContent_records',CmsPagesContent::model()->findAll($criteria));

        $this->renderPartial(
          'index',
          [
            'model' => $model,
          ],
          false,
          true
        );

    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id = false)
    {
        if ($id == false) {
            $standalone = false;
            $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["CmsPagesContent"]["id"];
        } else {
            $standalone = true;
        }
        $model = $this->loadModel($id, true);
        if (!$model && $id) {
            $page = new CmsPages();
            $page->page_id = $id;
            $page->url = $id;
            $page->enabled = 1;
            if ($page->save()) {
                $pageContent = new CmsPagesContent();
                $pageContent->page_id = $id;
                $pageContent->lang = '*';
                $pageContent->save();
            }
            $model = $this->loadModel($id, true);
        }
        $model->contentdata = $model->content_data;
        if (!$model) {
            $model = new CmsPagesContent();
            $model->contentdata = $model->content_data;
            $model->page_id = $id;
            $model->lang = '*';
        }
        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmspagescontent-update-form");

        if (Yii::app()->request->isAjaxRequest) {

            if (isset($_POST['CmsPagesContent'])) {
                unset($_POST['CmsPagesContent']['created']);
                $model->contentdata = $_POST['CmsPagesContent']['content_data'];
                $model->attributes = $_POST['CmsPagesContent'];
                if ($model->save()) {
                    if (!$standalone) {
                        echo $model->id;
                    } else {
                        echo Yii::t('admin', 'Параметры сохранены');
                    }
                } else {
                    echo "false";
                }
                return;
            }
            if (!$standalone) {
                $this->renderPartial(
                  '_ajax_update_form',
                  [
                    'model' => $model,
                  ]
                );
            } else {
                $this->renderPartial(
                  'update',
                  [
                    'model' => $model,
                  ],
                  false,
                  true
                );
            }

            return;

        }

        if (isset($_POST['CmsPagesContent'])) {
            $model->attributes = $_POST['CmsPagesContent'];
            if ($model->save()) {
                // $this->redirect(array('view', 'id' => $model->id));
            }
        } else {

            $this->renderPartial(
              'update',
              [
                'model' => $model,
              ],
              false,
              true
            );
        }
    }

    public function actionUpdateEx($page_id = false)
    {
        if ($page_id == false) {
            $page_id = isset($_REQUEST["page_id"]) ? $_REQUEST["page_id"] : $_REQUEST["CmsPagesContent"]["page_id"];
        }
        $data = new stdClass();
        $data->page_id = $page_id;
        $records = CmsPagesContent::model()->findAll('page_id=:page_id', [':page_id' => $page_id]);
        $data->records = [];
        if ($records) {
            foreach ($records as $record) {
                $data->records[$record->lang] = $record;
            }
            unset($records);
        }
        if (isset($_POST['PagesContent']) && isset($_POST['page_id'])) {
            $pagesContent = $_POST['PagesContent'];
            if (is_array($pagesContent)) {
                foreach ($pagesContent as $lang => $content) {
                    $model = CmsPagesContent::model()->findByPk($content['id']);
                    if ($model) {
                        $model->title = $content['title'];
                        $model->description = $content['description'];
                        $model->keywords = $content['keywords'];
                        $model->contentdata = $content['text'];
                        $model->save();
                    } else {
                        if ($content['title'] || $content['description'] || $content['keywords'] || $content['text']) {
                            $model = new CmsPagesContent();
                            $model->page_id = $_POST['page_id'];
                            $model->lang = $lang;
                            $model->title = $content['title'];
                            $model->description = $content['description'];
                            $model->keywords = $content['keywords'];
                            $model->contentdata = $content['text'];
                            $model->save();
                        }
                    }
                }
            }
        } else {

            $this->renderPartial(
              '_ajax_updateEx',
              [
                'data' => $data,
              ],
              false,
              true
            );
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView()
    {
        $id = $_REQUEST["id"];

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial(
              'ajax_view',
              [
                'model' => $this->loadModel($id),
              ]
            );

        } else {
            $this->render(
              'view',
              [
                'model' => $this->loadModel($id),
              ]
            );
        }
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id, $force = false)
    {
        if ($force) {
            if (is_numeric($id)) {
                $sql = 'SELECT tt.* FROM cms_pages_content tt WHERE id=:id';
            } else {
                $sql = 'SELECT tt.* FROM cms_pages_content tt WHERE page_id=:id';
            }
            $model = CmsPagesContent::model()->findBySql(
              $sql,
              [':id' => $id]
            );
        } else {
            $model = CmsPagesContent::model()->findByPk($id);
        }
        if ($model === null && (!$force)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
    }

}
