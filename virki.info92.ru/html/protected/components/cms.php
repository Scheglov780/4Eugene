<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="cms.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

// Класс, реализующий cms-функции
class cms
{
    private static function wrap($content, $type, $intId)
    {
        //http://mall92.ru/admin/main/open?url=admin/users/view/id/2136&tabName=test@mail.ru

//====== SEO ===============
        if (isset($content->keywords) && $content->keywords) {
            Yii::app()->clientScript->registerMetaTag(
              $content->keywords,
              'keywords',
              null,
              ['lang' => Utils::appLang()],
              'page-keywords'
            );
        }
        if (isset($content->description) && $content->description) {
            Yii::app()->clientScript->registerMetaTag(
              $content->description,
              'description',
              null,
              ['lang' => Utils::appLang()],
              'page-description'
            );
        }
        if (isset($content->title) && $content->title) {
            Yii::app()->controller->pageTitle = $content->title;
        }
//==========================

        if (Yii::app()->user->checkAccess('admin/' . $type . '/index')) {
            if (isset($content->content)) {
                $res = $content;
                $res->content = '<span class="editable" title="' .
                  Yii::t(
                    'main',
                    'Двойной клик для редактирования'
                  ) .
                  '" ondblclick="window.open(\'/admin/main/open?url=admin/' .
                  $type .
                  '/update/id/' .
                  $intId .
                  '&tabName=' .
                  $type .
                  ' ' .
                  $intId .
                  '\')">' .
                  $res->content .
                  '</span>';
            } else {
                $res = '<span class="editable" title="' .
                  Yii::t(
                    'main',
                    'Двойной клик для редактирования'
                  ) .
                  '" ondblclick="window.open(\'/admin/main/open?url=admin/' .
                  $type .
                  '/update/id/' .
                  $intId .
                  '&tabName=' .
                  $type .
                  ' ' .
                  $intId .
                  '\')">' .
                  $content .
                  '</span>';
            }
            return $res;
        } else {
            return $content;
        }
    }

    public static function checkPhpSyntax($file)
    {
        if (!file_exists($file)) {
            return false;
        }
        $checkResult = @exec("php -l $file");
        if ($checkResult && (substr($checkResult, 0, 28) != 'No syntax errors detected in')) {
            return false;
        }
        return true;
    }

    public static function customContent(
      $id,
      $SEO = true,
      $plain = false,
      $translate = true,
      $render = true,
      $defaultValue = null
    ) {
        $cache = @Yii::app()->cache->get(
          'cmsCustomContent-' .
          $id .
          '-' .
          ($SEO ? 'true' : 'false')
          .
          '-' .
          ($plain ? 'true' : 'false') .
          '-' .
          ($translate ? 'true' : 'false') .
          '-' .
          ($render ? 'true' : 'false') .
          '-' .
          Utils::appLang()
        );
        $customQuery = Yii::app()->db->createCommand(
          "SELECT cc.id, cc.content_data, cc.lang, cc.enabled FROM cms_custom_content cc
       WHERE cc.content_id=:content_id AND (cc.lang=:lang OR cc.lang='*') ORDER BY cc.enabled DESC,
       cc.lang='*' ASC"
        );
        $customQuery->params = [':content_id' => $id, ':lang' => Utils::appLang()];
        $custom = $customQuery->queryRow();

        if ($custom) {
            if ($custom['enabled'] != 1) {
                return '';
            }
            $intId = $custom['id'];
        } else {
            $intId = $id;
        }
        if ($defaultValue) {
            $custom = [
              'enabled'      => 1,
              'id'           => $id,
              'content_data' => (string) $defaultValue,
              'lang'         => '*',

            ];
        }

        if (($cache == false) || (Yii::app()->user->notInRole(['guest', 'user']))) {
            if ($custom) {
                try {
                    if ($render) {
                        $content = self::render($custom['content_data'], $custom['lang']);
                    } else {
                        $content = $custom['content_data'];
                    }
                    if (!$SEO && !$plain) {
                        $content = '<noindex>' . $content . '</noindex>';
                    }
                    if ($translate) {
                        if ($custom['lang'] == '*') {
                            $content = Yii::app()->DVTranslator->translateHtml(
                              $content,
                              Yii::app()->sourceLanguage,
                              Utils::appLang()
                            );
                        }
                    }
                    @Yii::app()->cache->set(
                      'cmsCustomContent-' .
                      $id .
                      '-' .
                      ($SEO ? 'true' : 'false')
                      .
                      '-' .
                      ($plain ? 'true' : 'false') .
                      '-' .
                      ($translate ? 'true' : 'false') .
                      '-' .
                      ($render ? 'true' : 'false') .
                      '-' .
                      Utils::appLang(),
                      $content,
                      600
                    );
                    return ($plain) ? $content : self::wrap($content, 'cmsCustomContent', $intId);
                } catch (Exception $e) {
                    return self::wrap(print_r($e, true), 'cmsCustomContent', $intId);
                }
            } else {
                if ($plain) {
                    $result = 'cms::customContent(\'' . $id . '\')';
                } else {
                    $result = self::wrap('<div>cms::customContent(' . $id . ')</div>', 'cmsCustomContent', $intId);
                }
                return $result;
            }
        } else {
            return ($plain) ? $cache : self::wrap($cache, 'cmsCustomContent', $intId);
        }
    }

    public static function getLangList()
    {
        $langs = explode(',', DSConfig::getVal('site_language_block'));
        $res = ['*' => '*'];
        foreach ($langs as $lang) {
            $res[$lang] = $lang;
        }
        return $res;
    }

    public static function menuContent($id, $SEO = true, $plain = false)
    {
        $cache = @Yii::app()->cache->get('cmsMenuContent-' . $id . '-' . Utils::appLang());
        $menuQuery = Yii::app()->db->createCommand(
          "SELECT mm.id, mm.menu_id, mm.menu_data, mm.enabled, mm.\"SEO\" as \"SEO\" FROM cms_menus mm
       WHERE mm.menu_id=:menu_id ORDER BY mm.enabled DESC"
        );
        $menuQuery->params = [':menu_id' => $id];
        $menu = $menuQuery->queryRow();
        if ($menu) {
            if ($menu['enabled'] != 1) {
                return '';
            }
            $intId = $menu['id'];
        } else {
            $intId = $id;
        }
        if (($cache == false) || (Yii::app()->user->notInRole(['guest', 'user']))) {
            if ($menu) {
                try {
                    $content = self::render($menu['menu_data']);
                    if (((!$SEO) || ($menu['SEO'] != 1)) && !$plain) {
                        $content = '<noindex>' . $content . '</noindex>';
                    }
                    @Yii::app()->cache->set('cmsMenuContent-' . $id . '-' . Utils::appLang(), $content, 600);
                    return ($plain) ? $content : self::wrap($content, 'cmsMenus', $intId);
                } catch (Exception $e) {
                    return self::wrap(print_r($e, true), 'cmsMenus', $intId);
                }
            } else {
                return self::wrap('<span>cms::menuContent(' . $id . ')</span>', 'cmsMenus', $intId);
            }
        } else {
            return self::wrap($cache, 'cmsMenus', $intId);
        }
    }

    public static function meta($key, $tag, $lang = false, $selector = false, $query = false)
    {
        if (!$lang) {
            $_lang = Utils::appLang();
        } else {
            $_lang = $lang;//Utils::TransLang($lang);
        }
        $result = Yii::app()->db->createCommand(
          "SELECT \"value\" FROM cms_metatags
       WHERE \"key\"=:key AND tag=:tag AND lang=:lang LIMIT 1"
        )->queryScalar(
          [
            ':key'  => $key,
            ':tag'  => $tag,
            ':lang' => $_lang,
          ]
        );
        if (!$result) {
            if ($tag == 'text' && DSConfig::getVal('seo_use_knowledge_base') == 1 && $query) {
                $result = CmsKnowledgeBase::fullTextSearch($query, $_lang);
            }
        }
        $result = SEOUtils::insertKeywords($result, $_lang, $tag);
        return $result;
    }

    public static function pageContent($id, $SEO = true, $translate = true)
    {
        $cache = @Yii::app()->cache->get('cmsPageContent-' . $id . '-' . Utils::appLang());
//    $pageQuery = Yii::app()->db->createCommand("select pc.id, pp.type, pp.published_at, pp.page_id, pp.url, pp.SEO, pc.lang, pc.title,
        $pageQuery = Yii::app()->db->createCommand(
          "SELECT pc.id, pp.page_id, pp.url, pp.\"SEO\" as \"SEO\", pc.lang, pc.title,
       pc.description,pc.keywords,pc.content_data, pp.enabled
       FROM cms_pages_content pc, cms_pages pp
       WHERE pp.page_id=:page_id AND pp.page_id=pc.page_id AND (pc.lang=:lang OR pc.lang='*') ORDER BY pp.enabled DESC,
       pc.lang='*' ASC"
        );
        $pageQuery->params = [':page_id' => $id, ':lang' => Utils::appLang()];
        $page = $pageQuery->queryRow();
        if ($page) {
            if ($page['enabled'] != 1) {
                return '';
            }
            $intId = $page['id'];
        } else {
            $intId = $id;
        }
        if (($cache == false) || (Yii::app()->user->notInRole(['guest', 'user']))) {
            if ($page) {
                try {
                    $content = self::render($page['content_data'], $page['lang']);
                    if ((!$SEO) || ($page['SEO'] != 1)) {
                        $content = '<noindex>' . $content . '</noindex>';
                    }
                    $result = new stdClass();
                    /*          $result->type = $page['type'];
                              $result->published_at = $page['published_at'];
                              $result->page_id = $page['page_id'];
                              $result->url = $page['url'];
                              */
                    $result->title = $page['title'];
                    $result->description = $page['description'];
                    $result->keywords = $page['keywords'];
                    $result->content = $content;
                    if ($translate) {
                        if ($page['lang'] == '*') {
                            $result->title = Yii::t('cms', $result->title);
                            $result->description = Yii::t('cms', $result->description);
                            $result->keywords = Yii::t('cms', $result->keywords);
                            $result->content = Yii::app()->DVTranslator->translateHtml(
                              $result->content,
                              Yii::app()->sourceLanguage,
                              Utils::appLang()
                            );
                        }
                    }
                    @Yii::app()->cache->set('cmsPageContent-' . $id . '-' . Utils::appLang(), $result, 600);
                    return self::wrap($result, 'cmsPagesContent', $intId);
                } catch (Exception $e) {
                    return self::wrap(print_r($e, true), 'cmsPagesContent', $intId);
                }
            } else {
                return self::wrap('<div>cms::pageContent(' . $id . ')</div>', 'cmsPagesContent', $intId);
            }
        } else {
            return self::wrap($cache, 'cmsPagesContent', $intId);
        }
    }

    public static function pageLink($id, $label = false, $htmlOptions = [], $translate = true)
    {
        $res = preg_split('/#/', $id);
        if (count($res) == 1) {
            $page_id = $res[0];
            $anchor = [];
        } elseif (count($res) == 2) {
            $page_id = $res[0];
            $anchor = ['#' => $res[1]];
        } else {
            $page_id = $id;
            $anchor = [];
        }
        $pageQuery = Yii::app()->db->createCommand(
          "SELECT pp.id, pp.page_id, pp.url, pp.\"SEO\" as \"SEO\", pc.lang, pc.title, pc.description, pp.enabled
       -- pc.description,pc.keywords,pc.content_data
       FROM cms_pages_content pc, cms_pages pp
       WHERE pp.page_id=:page_id AND pp.page_id=pc.page_id AND (pc.lang=:lang OR pc.lang='*') ORDER BY pp.enabled DESC,
       pc.lang='*' ASC"
        );
        $pageQuery->params = [':page_id' => $page_id, ':lang' => Utils::appLang()];
        $page = $pageQuery->queryRow();
        if ($page) {
//      $intId=$page['id'];
            if ($page['enabled'] != 1) {
                return '<a href="#"></a>';
            }
            $href = Yii::app()->controller->createUrl('/article/' . $page['url'], $anchor);
            $labelText = $page['title'];
            if ($page['SEO'] != 1) {
                $htmlOptions['rel'] = 'nofollow';
            }
            $htmlOptions['title'] = $page['description'];
        } else {
//      $intId=$id;
            $href = '#';
            $labelText = '';
        }
        if (!isset($htmlOptions['href'])) {
            $htmlOptions['href'] = $href;
        }
        if ($label) {
            $labelText = $label;
        }
        $link = '<a ' . join(
            ' ',
            array_map(
              function ($sKey) use ($htmlOptions) {
                  if (is_bool($htmlOptions[$sKey])) {
                      return $htmlOptions[$sKey] ? $sKey : '';
                  }
                  return $sKey . '="' . $htmlOptions[$sKey] . '"';
              },
              array_keys($htmlOptions)
            )
          ) . '>' . $labelText . '</a>';
        if ($translate) {
            if ($page['lang'] == '*') {
                $link = Yii::app()->DVTranslator->translateHtml(
                  $link,
                  Yii::app()->sourceLanguage,
                  Utils::appLang()
                );
            }
        }
        return $link;
    }

    public static function render($text, $lang = false)
    {
        if (preg_match('/<!--\?(.+?)\?-->/s', $text)) {
            $text = preg_replace('/<!--\?(.+?)\?-->/s', '<?\1?>', $text);
        }
        if (!preg_match('/<\?/i', $text)) {
            return $text;
        }
        if ($lang && ($lang != '*') && (Yii::app()->sourceLanguage !== $lang)) {
            $originalLang = Yii::app()->sourceLanguage;
            Yii::app()->sourceLanguage = $lang;
        } else {
            $originalLang = false;
        }
        $open_basedir = ini_get('open_basedir');
        $safe_mode = false; //ini_get('safe_mode');
        try {
            if ($open_basedir || $safe_mode) {
                $tFileName = tempnam(
                  YiiBase::getPathOfAlias('webroot') . '/upload/',
                  'php'
                ) or die('could not create file');
                $tempFile = fopen($tFileName, 'w+');
            } else {
                $tempFile = tmpfile();
            }
            if (!$tempFile) {
                return ('error to open temp file');
            }
            $metaDatas = stream_get_meta_data($tempFile);
            $tmpFilename = $metaDatas['uri'];
            fwrite($tempFile, $text);
//      fseek($tempFile, 0);
            $phpRes = @self::checkPhpSyntax($tmpFilename);
            if (!isset($phpRes) || !$phpRes) {
                @fclose($tempFile); // this removes the file
                if (isset($tFileName)) {
                    @unlink($tFileName);
                }
                return 'Syntax error in content!';
            }
            ob_start();
            ob_implicit_flush(false);
            try {
                $phpRes = @include($tmpFilename);
            } catch (Exception $e) {
                CVarDumper::dump($e);
                ob_get_clean();
            }
            if (!isset($phpRes) || !$phpRes) {
                ob_get_clean();
                fclose($tempFile); // this removes the file
                if (isset($tFileName)) {
                    unlink($tFileName);
                }
                return 'Error in content!';
            }
            $content = ob_get_clean();
            fclose($tempFile); // this removes the file
            if (isset($tFileName)) {
                unlink($tFileName);
            }
            if ($originalLang) {
                Yii::app()->sourceLanguage = $originalLang;
            }
            return $content;
        } catch (Exception $e) {
            if (isset($originalLang) && $originalLang) {
                Yii::app()->sourceLanguage = $originalLang;
            }
            return CVarDumper::dumpAsString($e, 3, true);
        }
    }

    public static function setMeta($value, $key, $tag, $lang = false)
    {
        if ($key && $tag) {
            $_lang = ($lang ? $lang : Utils::appLang());//Utils::TransLang($lang);
            $exists = Yii::app()->db->createCommand(
              "SELECT count(0) AS cnt FROM cms_metatags
            WHERE lang=:lang AND tag=:tag AND \"key\"=:key"
            )->queryScalar(
              [
                ':key'  => $key,
                ':tag'  => $tag,
                ':lang' => $_lang,
              ]
            );
            if (!$exists) {
                Yii::app()->db->createCommand(
                  "INSERT INTO cms_metatags (lang,tag,\"key\",\"value\")
            VALUES (:lang,:tag,:key,:value)
            ON CONFLICT ON CONSTRAINT idx_uniquekeys_constrain 
DO NOTHING"
                )->execute(
                  [
                    ':key'   => $key,
                    ':tag'   => $tag,
                    ':lang'  => $_lang,
                    ':value' => $value,
                  ]
                );
            } else {
                Yii::app()->db->createCommand(
                  "UPDATE cms_metatags
                  SET \"value\"=:value
            WHERE lang=:lang AND tag=:tag AND \"key\"=:key"
                )->execute(
                  [
                    ':key'   => $key,
                    ':tag'   => $tag,
                    ':lang'  => $_lang,
                    ':value' => $value,
                  ]
                );
            }
        }
    }

}