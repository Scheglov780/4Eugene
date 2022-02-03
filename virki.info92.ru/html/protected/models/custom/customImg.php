<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Img.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customImg
{
    protected static $_curlObject = false;

    private static function resizeImage($imagePath, $filter, $stratch = false)
    {
        $result = $imagePath;
        if (!$filter) {
            return $result;
        }
        if (!preg_match('/^_(\d+)x(\d+)\.(jpg|jpeg|png)/i', $filter, $matches)) {
            return $result;
        }
        $neededWeight = $matches[1];
        $neededHeight = $matches[2];
        $neededFormat = $matches[3];
        if (preg_match('/\.png$/i', $imagePath)) {
            $neededFormat = 'png';
        }
        $newFileName = $imagePath . '_' . $neededWeight . 'x' . $neededHeight . '.' . $neededFormat;
        if (file_exists($newFileName)) {
            $result = $newFileName;
        } else {
            try {
                $img = file_get_contents($imagePath);
                if ($img) {
                    $im = @imagecreatefromstring($img);
                    if ($im) {
                        unset($img);
                        $width = imagesx($im);
                        $height = imagesy($im);
                        if ($width >= $height && $width >= $neededWeight) {
                            $newwidth = $neededWeight;
                            $newheight = round($height * $newwidth / $width);

                        } elseif ($height > $width && $height > $neededHeight) {
                            $newheight = $neededHeight;
                            $newwidth = round($width * $newheight / $height);

                        } elseif ($width <= $height && $width < $neededWeight && $stratch) {
                            $newwidth = $neededWeight;
                            $newheight = round($height * $newwidth / $width);

                        } elseif ($height < $width && $height < $neededHeight && $stratch) {
                            $newheight = $neededHeight;
                            $newwidth = round($width * $newheight / $height);

                        }
                        if (isset($newheight) && isset($newwidth)) {
                            $thumb = imagecreatetruecolor($newwidth, $newheight);
                            imagealphablending($thumb, false);
                            imagesavealpha($thumb, true);
                            imagecopyresampled($thumb, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            $im = $thumb;
                            unset($thumb);
                        }
                        if ($neededFormat == 'png') {
                            imagepng($im, $newFileName, 9); //save image as png
                        } else {
                            imagejpeg($im, $newFileName, 100); //save image as jpg
                        }
                        imagedestroy($im);
                        if (file_exists($newFileName) && filesize($newFileName) > 0) {
                            $result = $newFileName;
                        }
                    }
                } else {
                    $result = '#';
                }
            } catch (Exception $e) {
                return $result;
            }
        }
        return $result;
    }

    public static function add_watermark($img, $wpath)
    {
        // создаём водяной знак
        //$watermark_path = Yii::app()->theme->basePath . DSConfig::getVal('seo_img_cache_watermark');
        $watermark = imagecreatefrompng($wpath);
        // получаем значения высоты и ширины водяного знака
        $watermark_width = imagesx($watermark);
        $watermark_height = imagesy($watermark);
        // помещаем водяной знак на изображение
        $dest_x = imagesx($img) - $watermark_width - 10;
        $dest_y = imagesy($img) - $watermark_height - 10;
        imagealphablending($img, true);
        imagealphablending($watermark, true);
        // создаём новое изображение
        imagecopy($img, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);
        imagedestroy($watermark);
        return $img;
    }

    public static function getData($url)
    { //Get data from curl
        $result = new stdClass();
        $result->content = null;
        $result->info = null;
        $_url = DSGDownloader::normalizeUrl($url);
        if (gettype(self::$_curlObject) != 'resource') {
            $ch = curl_init($_url);
            self::$_curlObject = $ch;
        } else {
            $ch = self::$_curlObject;
            curl_setopt($ch, CURLOPT_URL, $_url);
        }

        $fp = fopen('php://temp', 'w+');
        curl_setopt(
          $ch,
          CURLOPT_USERAGENT,
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
        );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
        curl_setopt($ch, CURLOPT_NOPROGRESS, true);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
//---------
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        $result->info = curl_getinfo($ch);
        if (!curl_errno($ch)) {
            fseek($fp, 0);
            $fs = fstat($fp);
            if ($fs['size'] > 0) {
                $result->content = fread($fp, $fs['size']);
            }
        };
        fclose($fp);
//    curl_close($ch);
        return $result;
    }

    public static function getDataToTempFile($url)
    { //Get data from curl
        $_url = DSGDownloader::normalizeUrl($url);
        if (gettype(self::$_curlObject) != 'resource') {
            $ch = curl_init($_url);
            self::$_curlObject = $ch;
        } else {
            $ch = self::$_curlObject;
            curl_setopt($ch, CURLOPT_URL, $_url);
        }

        $fp = tmpfile();
        curl_setopt(
          $ch,
          CURLOPT_USERAGENT,
          'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2228.0 Safari/537.36'
        );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
        curl_setopt($ch, CURLOPT_NOPROGRESS, true);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_exec($ch);
        if (!curl_errno($ch)) {
            fseek($fp, 0);
            $metaData = stream_get_meta_data($fp);
            $filename = $metaData["uri"];
            if ($filename) {
                return $filename;
            }
        };
//    curl_close($ch);
        return false;
    }

    public static function getImagePath(
      $originalImagePath,
      $format,
      $useCache = true,
      $useStaticContent = false,
      $defaultImagePath = false,
      $stratch = false
    ) {
//$originalImagePath = '//gd1.alicdn.com/bao/uploaded/i1/248229567/T2YEuHXPtXXXXXXXXX_!!248229567.jpeg_30x30.jpg';

        // Если нет картинки по умолчанию
        if (!$defaultImagePath) {
            if (isset(Yii::app()->controller->frontThemePath)) {
                $defaultImagePath = Yii::app()->controller->frontThemePath . '/images/Hourglass.png';
            } else {
                $defaultImagePath =
                  Yii::app()->baseUrl . '/themes/' . Yii::app()->controller->module->id . '/images/Hourglass.png';
            }
        }
        // Если нет оригинального изображения
        if (!$originalImagePath) {
            $originalImagePath = $defaultImagePath;
        }
//=======================================
        // Если изображение является локальным
        if (!preg_match('/^(?:http[s]*:)*\/\//is', $originalImagePath)) {
            $baseUrl = Yii::app()->baseUrl;
            $homePath = Yii::getPathOfAlias('webroot');
            $localOriginalImagePath = '/' . trim($homePath, '/\\') . '/' . trim($originalImagePath, '/\\');
            if (file_exists($localOriginalImagePath)) {
                if (!$format) {
                    $result = preg_replace('/\_\d{2,3}x\d{2,3}(?:\.(?:jpg|jpeg|png|gif))*$/im', '', $originalImagePath);
                    return $result;
                } else {
                    $localOriginalImagePath = self::resizeImage($localOriginalImagePath, $format, $stratch);
                    $result = preg_replace('/^' . preg_quote($homePath, '/') . '/', $baseUrl, $localOriginalImagePath);
                }
            } else {
                $result = $originalImagePath;
            }
            return $result;
        }
//=======================================
        if (!$format) {
            $result = preg_replace('/\_\d{2,3}x\d{2,3}(?:\.(?:jpg|jpeg|png|gif))*$/im', '', $originalImagePath);
            return $result;
        }
        $isPaginated = preg_match('/page[s]*[\/=](\d+)/i', Yii::app()->request->getRequestUri(), $matches);
        if ($isPaginated > 0) {
            if ($matches[1] == 1) {//<= 10
                $isPaginated = 0;
            }
        }
        if (preg_match('/\/admin\//i', Yii::app()->request->getRequestUri())) {
            $isPaginated = 1;
        }
        $newPath = preg_replace('/((.+?)\.(jpg|jpeg|png|gif)).*/i', '$1', $originalImagePath);
        $newPath = DSGDownloader::normalizeUrl($newPath);
        if (preg_match('/\_\d{2,3}x\d{2,3}(?=[\.|$])/im', $newPath)) {
            // Не нужно, пожалуйста, здесь менять размеры картинки. Это можно и нужно делать в представлениях (views)
            $newPath = preg_replace('/\_\d{2,3}x\d{2,3}(?=[\.|$])/im', '_160x160', $newPath);
        } else {
            $newPath = $newPath . $format;
        }
//====================================
        if (DSConfig::getVal('seo_img_cache_enabled') == 1) {
            $clearHash = md5(Yii::app()->name . $newPath);
            $hash = $clearHash . '.jpg';
            $imgsubdomains = explode(',', DSConfig::getVal('seo_img_cache_subdomains'));
            $domain = Yii::app()->getBaseUrl(true);
            if (is_array($imgsubdomains) && (count($imgsubdomains) > 0)) {
                $d = 0;
                for ($i = 0; $i <= 31; $i++) {
                    $d = $d ^ hexdec($clearHash{$i});
                }
                $n = (int) ((count($imgsubdomains) / 16) * $d);
                $s = $imgsubdomains[$n];

                //$subdomain = preg_replace('/(http[s]*:\/\/)(?:(?:item\d|data)\.)*/i', '$1' . $s . '.', $domain);
                $subdomain = preg_replace('/(http[s]*:\/\/)(?:(?:item\d|data)\.)*/i', '//' . $s . '.', $domain);
            } else {
                $subdomain = $domain . '.';
            }
            $subdomain = preg_replace('/www\./', '', $subdomain);
//===================================
            if ($useStaticContent) {
                $staticPath = preg_replace('/\/protected$/is', '/assets', Yii::app()->basePath) . '/images.cache';
                $staticFileName = $staticPath . '/' . $hash;
                if (file_exists($staticFileName) && $useStaticContent) {
                    $imgURL = $subdomain . '/assets/images.cache/' . $hash;
                    return $imgURL;
                }
            }
//===================================
            if ($useCache && ($isPaginated <= 0)) {
                if ((DSConfig::getVal('site_images_lazy_load') == 1)) {

                    $res = Yii::app()->db->createCommand(
                      "INSERT INTO img_hashes (original_url,hash,created,last_access, static)
        VALUES (:original_url,:hash,Now(),Now(),:static)
        ON CONFLICT ON CONSTRAINT img_hashes_constr
        DO UPDATE SET
        last_access = Now(), static=:static"
                    )->execute(
                      [
                        ':original_url' => $newPath,
                        ':hash'         => $hash,
                        ':static'       => ($useStaticContent ? 1 : 0),
                      ]
                    );
                    $imgURL = $subdomain . Yii::app()->createUrl('/img/index', ['url' => $hash]);
                    return $imgURL;
                }
            }
        }
//===================================
        /*  if (Yii::app()->request->isSecureConnection) {
              $newPath = preg_replace('/^http[s]*:/is','',$newPath);
          }
        */
        return $newPath;
    }

    public static function getSubdomainPath($url)
    {
        //return $url;
        $clearHash = md5($url);
        if (DSConfig::getVal('seo_img_cache_subdomains')) {
            $imgsubdomains = explode(',', DSConfig::getVal('seo_img_cache_subdomains'));
        } else {
            $imgsubdomains = [];
        }
        $domain = Yii::app()->getBaseUrl(true);
        if (is_array($imgsubdomains) && (count($imgsubdomains) > 0)) {
            $d = 0;
            for ($i = 0; $i <= 31; $i++) {
                $d = $d ^ hexdec($clearHash{$i});
            }
            $n = (int) ((count($imgsubdomains) / 16) * $d);
            $s = $imgsubdomains[$n];
            $subdomain = preg_replace('/(http[s]*:\/\/)/i', '$1' . $s . '.', $domain);
        } else {
            $subdomain = $domain . '.';
        }
        $subdomain = preg_replace('/www\./', '', $subdomain);
        $newUrl = $subdomain . $url;
        return $newUrl;
    }

    public static function imglibGetPath($path, $filename)
    {
        $homePath = Yii::getPathOfAlias('webroot');
        $imgLibs = ['/themes/' . DSConfig::getVal('site_front_theme') . '/images/library', '/images/library'];
        foreach ($imgLibs as $imgLib) {
            $imglibFileName = $homePath . $imgLib . $path . '/' . $filename;
            if (file_exists($imglibFileName)) {
                return $imglibFileName;
            }
        }
        return false;
    }

    public static function imglibPathToUrl($filename)
    {
        $baseUrl = Yii::app()->baseUrl;
        $homePath = Yii::getPathOfAlias('webroot');
        $result = preg_replace('/^' . preg_quote($homePath, '/') . '/', $baseUrl, $filename);
        return $result;
    }

    public static function imglibSearchUrl($path, $query)
    {
        $result = '';
        $params = [
          ':query' => $query,
          ':path'  => $path,
        ];
        $queryLang = Utils::detectSearchLanguageForSql($query);
        if ($queryLang == 'ru') {
            $queryLanguage = 'russian';
        } else {
            $queryLanguage = 'english';
        }

        $sql = "SELECT path, filename, im.{$queryLang} FROM cms_knowledge_base_img im
                where im.enabled = 1 AND (:path::varchar is null OR im.path like concat(:path::varchar,'%')) 
order by ts_rank(to_tsvector('{$queryLanguage}',im.{$queryLang}), websearch_to_tsquery('{$queryLanguage}',:query)) desc
LIMIT 1";
        $res = Yii::app()->db->createCommand($sql)->queryRow(true, $params);
        if ($res) {
            $fileName = self::imglibGetPath($res['path'], $res['filename']);
            $result = self::imglibPathToUrl($fileName);
        }
        return $result;
    }

    public static function normalizeUrl($url)
    {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
            $protocol = 'https://';
        } else {
            $protocol = 'http://';
        }
        if (!preg_match('/^http[s]*:\/\/.+/', $url)) {
            return $protocol . preg_replace('/^\/\//', '', $url);
        } else {
            return $url;
        }
    }

}
