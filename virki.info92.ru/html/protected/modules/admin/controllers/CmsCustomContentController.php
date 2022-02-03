<?php

class CmsCustomContentController extends CustomAdminController
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
        $model = new CmsCustomContent;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model, "cmscustomcontent-create-form");
        if (Yii::app()->request->isAjaxRequest) {
            if (isset($_POST['CmsCustomContent'])) {
                $model->attributes = $_POST['CmsCustomContent'];
                if ($model->save()) {
                    echo $model->id;
                } else {
                    echo "false";
                }
                return;
            }
        } else {
            if (isset($_POST['CmsCustomContent'])) {
                $model->attributes = $_POST['CmsCustomContent'];
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
              "select id, content_id, content_data from cms_custom_content where (lang='{$currLang}' or lang='*') order by content_id"
            )->queryAll();
            header('Content-Type: application/msword');
            $filename = 'cms_custom_content.html';
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
                  <td width="20%">ID:<?= $rec['id'] ?> CID:<?= $rec['content_id'] ?></td>
                  <td id="<?= 'cms_custom_content-' . $rec['id'] ?>"><?= cms::customContent(
                        $rec['content_id']
                      ) ?></td>
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
        if (Yii::app()->session->contains('CmsCustomContent_records')) {
            $model = Yii::app()->session->get('CmsCustomContent_records');
        } else {
            $model = CmsCustomContent::model()->findAll();
        }

        Yii::app()->request->sendFile(
          'customContent-' . date('YmdHis') . '.xls',
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


        $model = new CmsCustomContent('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['CmsCustomContent'])) {
            $model->attributes = $_GET['CmsCustomContent'];

//            if (!empty($model->id)) {
//                $criteria->addCondition('id = "' . $model->id . '"');
//            }
//
//            if (!empty($model->content_id)) {
//                $criteria->addCondition('content_id = "' . $model->content_id . '"');
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
//            if (!empty($model->enabled)) {
//                $criteria->addCondition('enabled = "' . $model->enabled . '"');
//            }

        }
//        Yii::app()->session->add('CmsCustomContent_records',CmsCustomContent::model()->findAll($criteria));

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
        try {
            if ($id == false) {
                $standalone = false;
                $id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : $_REQUEST["CmsCustomContent"]["content_id"];
                $enabled =
                  isset($_REQUEST["enabled"]) ? $_REQUEST["enabled"] : $_REQUEST["CmsCustomContent"]["enabled"];
            } else {
                $standalone = true;
            }
            $model = $this->loadModel($id, true);
            if (!$model) {
                $model = new CmsCustomContent();
                $model->content_id = $id;
                $model->enabled =
                  (isset($_REQUEST["CmsCustomContent"]["enabled"]) ? $_REQUEST["CmsCustomContent"]["enabled"] : 0);
                $model->lang =
                  (isset($_REQUEST["CmsCustomContent"]["lang"]) ? $_REQUEST["CmsCustomContent"]["lang"] : '*');
            }
            if (!$standalone) {
                $referer = Yii::app()->request->urlReferrer;
                $standalone = preg_match('/admin\/main\/open\?url=/is', $referer);
            }
            // Uncomment the following line if AJAX validation is needed
            //$this->performAjaxValidation($model, "cmscustomcontent-update-form");

            if (Yii::app()->request->isAjaxRequest) {

                if (isset($_POST['CmsCustomContent'])) {
                    unset($_POST['CmsCustomContent']['created']);
                    $model->attributes = $_POST['CmsCustomContent'];
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

            if (isset($_POST['CmsCustomContent'])) {
                $model->attributes = $_POST['CmsCustomContent'];
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
        } catch (Exception $e) {
            CVarDumper::dump($e, 1, true);
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
                $sql = 'SELECT tt.* FROM cms_custom_content tt WHERE id=:id';
            } else {
                $sql = 'SELECT tt.* FROM cms_custom_content tt WHERE content_id=:id';
            }
            $model = CmsCustomContent::model()->findBySql(
              $sql,
              [':id' => $id]
            );
        } else {
            $model = CmsCustomContent::model()->findByPk($id);
        }
        if ($model === null && (!$force)) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }

        return $model;
    }

}
