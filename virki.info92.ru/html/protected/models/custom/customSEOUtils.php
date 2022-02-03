<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="AccessRights.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "access_rights".
 * The followings are the available columns in table 'access_rights':
 * @property string  $role
 * @property string  $description
 * @property string  $allow
 * @property string  $deny
 * The followings are the available model relations:
 * @property Users[] $users
 */
class customSEOUtils
{
    public static function GetSitemap($adaptation = false)
    {
        //--------------------------------------
        header('Content-Type: application/xml');

        $lang = Utils::appLang();
        $cache = @Yii::app()->cache->get('sitemap--' . ($adaptation ? $adaptation : 'false') . '-' . $lang);
        if (($cache == false) || (DSConfig::getVal('search_cache_enabled') != 1)) {
            /*		  $xml = '<?xml version="1.0" encoding="utf-8"?>
                    <urlset
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
                    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
            */
            $xml = '<?xml version="1.0" encoding="utf-8"?>
		  <urlset 
		  xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
          xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
          xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
          xmlns:xhtml="http://www.w3.org/1999/xhtml">';

            $xml = $xml . "\n" . DSConfig::getVal('seo_sitemap_static');
            $seo_sitemap_patern = DSConfig::getVal('seo_sitemap_patern');
            /*
             <url>
               <loc>$URL</loc>
               <lastmod>$LASTMOD</lastmod>
               <changefreq>$FREQ</changefreq>
               <priority>$PRIORITY</priority>
            </url>
             */
//-- Обрабатываем статические страницы
            $command = Yii::app()->db->createCommand(
              "SELECT url FROM cms_pages WHERE url IS NOT NULL AND enabled=1 AND \"SEO\"=1 GROUP BY url"
            );
//        ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $rows = $command->queryAll();
            foreach ($rows as $row) {
                $res = "\n" . $seo_sitemap_patern . "\n";
                $res = str_replace('$URL', self::createAbsoluteUrl('/article/' . $row['url'], [], ''), $res);
                $res = str_replace(
                  '$LASTMOD',
                  date(DATE_W3C, floor((time() - (3600 * 24 * 30)) / (3600 * 24 * 30)) * (3600 * 24 * 30)),
                  $res
                ); //),$res);
                $res = str_replace('$FREQ', 'monthly', $res);
                $res = str_replace('$PRIORITY', '0.8', $res);
                $xml = $xml . $res;
            }
//-- Обрабатываем блоги
            if (DSConfig::getVal('blogs_enabled')) {
                $command = Yii::app()->db->createCommand(
                  "SELECT id FROM blog_posts WHERE enabled=1"
                );
                $rows = $command->queryAll();
                foreach ($rows as $row) {
                    $res = "\n" . $seo_sitemap_patern . "\n";
                    $res = str_replace(
                      '$URL',
                      self::createAbsoluteUrl('/blog/posts', ['id' => $row['id']], ''),
                      $res
                    );
                    $res = str_replace(
                      '$LASTMOD',
                      date(DATE_W3C, floor((time() - (3600 * 24 * 30)) / (3600 * 24 * 30)) * (3600 * 24 * 30)),
                      $res
                    ); //),$res);
                    $res = str_replace('$FREQ', 'weekly', $res);
                    $res = str_replace('$PRIORITY', '0.8', $res);
                    $xml = $xml . $res;
                }
            }
//-- Обрабатываем меню
            $seo_catalog_depth = DSConfig::getVal('seo_catalog_depth');
            $command = Yii::app()->db->createCommand(
              "SELECT url, level FROM (
SELECT cc.url, 1 AS level FROM categories_ext cc WHERE cc.status IN (1,2,3) AND cc.url NOT LIKE '%#%' AND cc.parent = 1
UNION ALL
SELECT cc.url, 2 AS level FROM categories_ext cc WHERE cc.status IN (1,2,3) AND cc.url NOT LIKE '%#%' 
AND cc.parent IN (SELECT cc2.id FROM categories_ext cc2 WHERE cc2.status IN (1,2,3) AND cc2.url NOT LIKE '%#%' 
AND cc2.parent = 1)
UNION ALL
SELECT cc.url, 3 AS level FROM categories_ext cc WHERE cc.status IN (1,2,3) AND cc.url NOT LIKE '%#%' 
AND cc.parent IN (
SELECT cc3.id FROM categories_ext cc3 WHERE cc3.status IN (1,2,3) AND cc3.url NOT LIKE '%#%' 
AND cc3.parent IN (SELECT cc2.id FROM categories_ext cc2 WHERE cc2.status IN (1,2,3) AND cc2.url NOT LIKE '%#%' 
AND cc2.parent = 1)
)
) ccc GROUP BY ccc.url"
            );
//        ->bindParam(':text', $textEn, PDO::PARAM_STR);
            $rows = $command->queryAll();
            foreach ($rows as $row) {
                if ($row['level'] > $seo_catalog_depth) {
                    continue;
                }
                $res = "\n" . $seo_sitemap_patern . "\n";
                $res = str_replace('$URL', self::createAbsoluteUrl('/category/' . $row['url'], [], ''), $res);
                $res = str_replace(
                  '$LASTMOD',
                  date(DATE_W3C, floor((time() - (3600 * 24 * 7)) / (3600 * 24 * 7)) * (3600 * 24 * 7)),
                  $res
                ); //),$res);
                $res = str_replace('$FREQ', 'weekly', $res);
                if ($row['level'] == 1) {
                    $priority = '0.64';
                } elseif ($row['level'] == 2) {
                    $priority = '0.5';
                } else {
                    $priority = '0.32';
                }

                $res = str_replace('$PRIORITY', $priority, $res);
                $xml = $xml . $res;
            }
            $xml = $xml . "\n" . '</urlset>';
            if ($adaptation == 'yandex') {
                $xml = preg_replace('/<xhtml:link.*?\/>\s*/is', '', $xml);
            }
            @Yii::app()->cache->set(
              'sitemap--' . ($adaptation ? $adaptation : 'false') . '-' . $lang,
              [$xml],
              60 * 60 * 24
            );
        } else {
            [$xml] = $cache;
        }
        return $xml;
//--------------------------------------
    }

    public static function createAbsoluteUrl($route, $params = [], $lang = '', $schema = '', $ampersand = '&')
    {
        $result = Yii::app()->createAbsoluteUrl($route, $params, $schema, $ampersand);
        if ($lang) {
            $result = preg_replace(
              '/\/(?:az|sq|am|en|ar|hy|af|eu|ba|be|bn|my|bg|bs|cy|hu|vi|ht|gl|nl|el|ka|gu|da|he|yi|id|ga|it|is|es|kk|kn|ca|ky|zh|ko|xh|km|lo|la|lv|lt|lb|mg|ms|ml|mt|mk|mi|mr|mn|de|ne|no|pa|fa|pl|pt|ro|ru|sr|si|sk|sl|sw|su|tg|th|tl|ta|tt|te|tr|uz|uk|ur|fi|fr|hi|hr|cs|sv|gd|et|eo|jv|ja)(?:\/|$)/',
              "/{$lang}/",
              $result
            );
        } else {
            $result = preg_replace(
              '/\/(?:az|sq|am|en|ar|hy|af|eu|ba|be|bn|my|bg|bs|cy|hu|vi|ht|gl|nl|el|ka|gu|da|he|yi|id|ga|it|is|es|kk|kn|ca|ky|zh|ko|xh|km|lo|la|lv|lt|lb|mg|ms|ml|mt|mk|mi|mr|mn|de|ne|no|pa|fa|pl|pt|ro|ru|sr|si|sk|sl|sw|su|tg|th|tl|ta|tt|te|tr|uz|uk|ur|fi|fr|hi|hr|cs|sv|gd|et|eo|jv|ja)(?:\/|$)/',
              "/",
              $result
            );
        }
        return $result;
    }

    public static function insertKeywords($text, $lang, $type = '', $filter = '')
    {
        $result = $text;
        if (!in_array($type, ['keywords'])) {
            if (Yii::app()->db->cache(3600)->createCommand(
              "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 'seo_keywords'"
            )->queryRow()) {
                $keywords = Yii::app()->db->createCommand(
                  "SELECT keyword FROM seo_keywords 
                 WHERE lang = :lang AND (keyword LIKE :filter OR :filter = '') ORDER BY cnt DESC"
                )
                  ->queryAll(true, [':lang' => $lang, ':filter' => $filter]);
                if ($keywords) {
                    $keywordsCount = count($keywords);
                    $hash = md5(Yii::app()->request->requestUri . $text);
                    $hashSelector = (hexdec($hash) / hexdec('ffffffffffffffffffffffffffffffff'));
                    $keywordNum = (int) (
                      $hashSelector * ($keywordsCount)
                    );
                    if (isset($keywords[$keywordNum])) {
                        $keyword = $keywords[$keywordNum]['keyword'];
                    }
                    if (isset($keyword) && $keyword) {
                        $sentences = preg_split('/(?<=[\.\?\!])(?:\s)/is', $text);
                        $sentencesCount = count($sentences);
                        $afterSentenceNum = (int) (
                          $hashSelector * ($sentencesCount)
                        );
                        $result = '';
                        foreach ($sentences as $i => $sentence) {
                            $result = $result . ' ' . $sentence;
                            if ($i == $afterSentenceNum) {
                                $result = $result . ' ' . $keyword;
                            }
                        }
                    }
                }
            }
        }
        return trim($result);
    }
}
