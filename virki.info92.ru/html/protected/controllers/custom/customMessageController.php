<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="MessageController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customMessageController extends CustomFrontController
{
    public function actionAddImage()
    {
        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '20M');
        $isOrder = null;
//    $itemId=0;
        if (!function_exists('processAddImageResult')) {
            function processAddImageResult($error, $blockId, $message = false)
            {
                if ($error) {
                    if (!$message) {
                        echo '<script>alert("' . Yii::t('main', 'Ошибка загрузки изображения') . '");</script>';
                    } else {
                        echo '<script>alert("' . Yii::t('main', 'Ошибка загрузки изображения') . '");</script>';
                    }
                    Yii::app()->end();
                } else {
                    echo '<script>alert("' . Yii::t(
                        'main',
                        'Изображение загружено, подождите несколько секунд, чтобы его увидеть'
                      ) . '");</script>';
                    Yii::app()->end();
                }
            }
        }

        if (isset($_POST['OrdersCommentsAttaches'])) {
            $isOrder = true;
            $model = new OrdersCommentsAttaches();
            $model->attributes = $_POST['OrdersCommentsAttaches'];
        } elseif (isset($_POST['OrdersItemsCommentsAttaches'])) {
            $isOrder = false;
            $model = new OrdersItemsCommentsAttaches();
            $model->attributes = $_POST['OrdersItemsCommentsAttaches'];
        } elseif (isset($_POST['isItem']) && isset($_POST['itemId']) && isset($_POST['blockId']) && $_POST['itemId']) {
            $newCommentId = OrdersItemsComments::addOrderItemComment(
              $_POST['itemId'],
              (isset($_POST['message']) ? $_POST['message'] : Yii::t('main', 'Фотоотчет')),
              0
            );
            $model = new OrdersItemsCommentsAttaches();
            $model->comment_id = $newCommentId;
            $model->uploadedFile = '';
        } else {
            processAddImageResult(true, null);
        }
        if ($model->validate()) {
            try {
                $model->scenario = 'insert';
                $itemId = $model->comment_id;
                $file = CUploadedFile::getInstance($model, 'uploadedFile');
                if ($file && ($file->error == 0)) {
                    $model->attach = file_get_contents($file->tempName);
                    $model->save();
                    processAddImageResult(false, $_POST['blockId']);
                } else {
                    processAddImageResult(true, null);
                }
            } catch (Exception $e) {
                processAddImageResult(true, null);
            }
        } else {
            processAddImageResult(true, null, $model->getErrors('uploadedFile'));
        }
    }

    public function actionCreate()
    {
        try {
            if (isset($_POST['message'])) {
                if (isset($_POST['message']['isItem']) &&
                  (isset($_POST['message']['parentId'])) &&
                  isset($_POST['message']['message'])) {
                    if (((int) $_POST['message']['isItem'] >= 0) &&
                      ((int) $_POST['message']['parentId'] > 0) &&
                      (strlen(
                          $_POST['message']['message']
                        ) > 0)
                    ) {
                        if (isset($_POST['message']['public'])) {
                            if ($_POST['message']['public'] == 1) {
                                $internal = 0;
                            } else {
                                $internal = 1;
                            }
                        } else {
                            $internal = 1;
                        }
                        if ((int) $_POST['message']['isItem'] == 0) {
                            OrdersComments::addOrderComment(
                              (int) $_POST['message']['parentId'],
                              $_POST['message']['message'],
                              $internal
                            );
                        } else {
                            OrdersItemsComments::addOrderItemComment(
                              (int) $_POST['message']['parentId'],
                              $_POST['message']['message'],
                              $internal
                            );
                        }
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            } else {
                return false;
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function filters()
    {
        return array_merge(
          [
            'Rights', // perform access control for CRUD operations
          ],
          parent::filters()
        );
    }

}