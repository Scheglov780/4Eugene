<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ImgController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customImgController extends CustomFrontController
{

    public function actionBarcode($code)
    {
        $bc = new BarcodeGenerator;
        //$height=50, $thin=2, $thick=3, $fSize=2
        $bc->init('png', 18, 1, 2, 2); //$bc->init('png',50,2,3,5);
        //$text='', $showText=false, $fileName=null
        $bc->build($code, true);
    }

    public function actionCommentAttach($id, $isItem = '0')
    {
        if ($isItem === '0') {
            $attach = OrdersCommentsAttaches::model()->findByPk($id);
        } else {
            $attach = OrdersItemsCommentsAttaches::model()->findByPk($id);
        }
        if ($attach) {
            foreach ($_SERVER as $name => $value) {
                if ($name == 'HTTP_IF_NONE_MATCH') {
                    header('HTTP/1.1 304 Not Modified');

                    header('Cache-Control: max-age=864000');
                    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT");
                    header('Pragma: public');
                    return;
                }
            }
            header('Content-Type: image/jpeg');
            header('Cache-Control: public, max-age=864000');
            header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT");
            header('Etag: ' . md5($isItem . '-' . $id));
            header('Pragma: public');
            echo $attach->attach;
        } else {
            header('HTTP/1.1 404 Not found');
        }
        return;
    }

    public function actionIndex($url)
    {
        //=========================================
//      $cookies=Yii::app()->request->cookies;
        //=================================================================
        /*        header('Content-Type: image/jpeg');
                header('Cache-Control: public, max-age=864000');
                header('Pragma: public');
                echo '';
                return;
        */
        //=================================================================
        try {
            $staticPath = preg_replace('/\/protected$/is', '/assets', Yii::app()->basePath) . '/images.cache';
            if (!is_dir($staticPath)) {
                mkdir($staticPath, 0777, true);
            }//301
            $staticFileName = $staticPath . '/' . $url;
            $hash = $url;
            $start = microtime(true);
            /*
            if (file_exists($staticFileName)) {
                header('Content-Type: image/jpeg');
                header('Cache-Control: max-age=864000');
                header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT");
                $time = microtime(true) - $start;
                header('Connection: ' . $time * 1000);
                header('Pragma: public');
                Yii::app()->request->redirect('/assets/images.cache/'.$url,true,301);
            }
            */
            $watermark_path = Yii::app()->theme->basePath . DSConfig::getVal('seo_img_cache_watermark');
            $command = Yii::app()->db->createCommand(
              "SELECT original_url, static FROM img_hashes WHERE hash=:hash LIMIT 1"
            );
            $row = $command->queryRow(
              true,
              [
                ':hash' => $hash,
              ]
            );
            if ($row != false) {
                if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && !$row['static']) {
                    header('HTTP/1.1 304 Not Modified');
                    header('Cache-Control: max-age=864000');
                    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT");
                    $time = microtime(true) - $start;
                    header('Connection: ' . $time * 1000);
                    header('Pragma: public');
                    return;
                }
                if (isset(Yii::app()->imageCache)) {
                    $cache = @Yii::app()->imageCache->get('img-cache-' . $hash);
                } else {
                    $cache = @Yii::app()->fileCache->get('img-cache-' . $hash);
                }
                //$cache = FALSE;
                if ((($cache == false) || (DSConfig::getVal('seo_img_cache_file_enabled') != 1))) {
                    $res = Img::getData($row['original_url']);
                    if (isset($res->info)) {
                        $timeget = microtime(true) - $start;
                        //=========================================
                        $command = Yii::app()->db->createCommand(
                          "UPDATE img_hashes SET last_access=Now(), size=:size WHERE hash=:hash LIMIT 1"
                        );
                        $command->execute(
                          [
                            ':hash' => $hash,
                            ':size' => $res->info['size_download'],
                          ]
                        );
                        //=========================================
                        if (($res->info['http_code'] == 200) or ($res->info['http_code'] == 206)) {
                            if (isset(Yii::app()->imageCache)) {
                                @Yii::app()->imageCache->set(
                                  'img-cache-' . $hash,
                                  $res->content,
                                  60 * 60 * (int) DSConfig::getVal('search_cache_ttl_search')
                                );
                            } else {
                                @Yii::app()->fileCache->set(
                                  'img-cache-' . $hash,
                                  $res->content,
                                  60 * 60 * (int) DSConfig::getVal('search_cache_ttl_search')
                                );
                            }
                            $image = imagecreatefromstring($res->content);
                            if (is_file($watermark_path)) {
                                $image = Img::add_watermark($image, $watermark_path);
                            }
                            header('Content-Type: image/jpeg');
                            header('Cache-Control: public, max-age=864000');
                            header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT");
                            header('Etag: ' . $hash);
                            $time = microtime(true) - $start;
                            header('Connection: ' . ($time * 1000) . ' , ' . ($timeget * 1000));
                            header('Pragma: public');

                            imagejpeg($image, null, 80);
                            if ($row['static'] && !file_exists($staticFileName)) {
                                imagejpeg($image, $staticFileName, 80);
                            }
                            imagedestroy($image);
                            //echo $res-> content;
                        } else {
                            header('HTTP/1.1 404 Not found');
                        }
                    } else {
                        header('HTTP/1.1 503 Service Temporarily Unavailable');
                        header('Status: 503 Service Temporarily Unavailable');
                        header('Retry-After: 3600');
                    }
                } else {
                    header('Content-Type: image/jpeg');
                    header('Cache-Control: public, max-age=864000');
                    header("Expires: " . gmdate("D, d M Y H:i:s", time() + 864000) . " GMT");
                    header('Etag: ' . $hash);
                    $time = microtime(true) - $start;
                    header('Connection: ' . $time * 1000);
                    header('Pragma: public');
//                    echo($cache);

                    $image = imagecreatefromstring($cache);
                    if (is_file($watermark_path)) {
                        $image = Img::add_watermark($image, $watermark_path);
                    }

                    imagejpeg($image, null, 100);
                    if ($row['static'] && !file_exists($staticFileName)) {
                        imagejpeg($image, $staticFileName, 100);
                    }
                    imagedestroy($image);
                }
            } else {
                header('HTTP/1.1 404 Not found');
            }
        } catch (Exception $e) {
            header('HTTP/1.1 404 Not found');
        }
    }

    public function filters()
    {
        return [];
    }

    public function init()
    {
//        Yii::app()->session->autoStart=false;
//        Yii::app()->session->cookieMode='none';
        //Yii::app()->session->destroy();
        //Yii::
        Yii::app()->request->enableCsrfValidation = false;
        /*       ini_set("session.use_cookies",0);
               ini_set("session.use_only_cookies",1);
               ini_set("session.use_trans_sid",0);
       */
        parent::init();
    }
}