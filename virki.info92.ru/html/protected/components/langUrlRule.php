<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="langUrlRule.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class langUrlRule extends CBaseUrlRule
{
    private function processParams($params, $asParams = false)
    {
        $paramStr = '';
        $additionalParams = '';
        if ($params && is_array($params) && count($params)) {
            foreach ($params as $paramName => $paramValue) {
                if (is_array($paramValue)) {
                    foreach ($paramValue as $subparamName => $subparamValue) {
                        if (($subparamValue != '') && ($subparamValue != false)) {
                            //TODO: Разрулить если $subparamValue - массив
                            if (isset($params['ajax'])) {
                                $additionalParams =
                                  $additionalParams . '/' . $paramName . '[' . $subparamName . ']/' . urlencode(
                                    $subparamValue
                                  );
                            } else {
                                $additionalParams =
                                  $additionalParams . '&' . $paramName . '[' . $subparamName . ']=' . urlencode(
                                    $subparamValue
                                  );
                            }
                        }
                    }
                } elseif ($paramName == 'props') {
                    if ($paramValue) {
                        if (preg_match('/^.+?:.+?(?:;|$)/is', $paramValue)) {
                            $intParams = preg_split('/;/is', $paramValue);
                            if (is_array($intParams)) {
                                foreach ($intParams as $intParam) {
                                    if (!$intParam) {
                                        continue;
                                    }
                                    $intParamVal = preg_split('/:/is', $intParam);
                                    if (is_array($intParamVal) && count($intParamVal)) {
                                        $additionalParams =
                                          $additionalParams . '&' . $paramName . '[' . $intParamVal[0] . ']=' .
                                          (isset($intParamVal[1]) ? $intParamVal[1] : '');
                                    }
                                }
                            }
                        }
                    }
                } else {
                    if (($paramValue != '') && ($paramValue != false)) {
                        if ($asParams) {
                            $paramStr = $paramStr . '&' . $paramName . '=' . urlencode($paramValue);
                        } else {
                            $paramStr = $paramStr . '/' . $paramName . '/' . urlencode($paramValue);
                        }
                    }
                }
            }
        }
        if ($additionalParams) {
            if (isset($params['ajax'])) {
                $paramStr = $paramStr . '/' . trim($additionalParams, '&/');
            } else {
                $paramStr = $paramStr . '&' . trim($additionalParams, '&');
            }
        }
        $paramStr = trim($paramStr, '&');
        return $paramStr;
    }

    private function setLang($lang)
    {
        //TODO: Что здесь такое admin[23]* ???
        if (preg_match('/\/admin[23]*(?:\/|$)/', Yii::app()->request->urlReferrer)) {
            $langCookie = 'admin_lang';
        } else {
            $langCookie = 'front_lang';
        }

        $langs = explode(',', DSConfig::getVal('site_language_supported'));

        if (!isset(Yii::app()->request->cookies[$langCookie])) {
            $lang = substr(Yii::app()->request->getPreferredLanguage(), 0, 2);
        }

        if (!in_array($lang, $langs)) {
            $lang = Yii::app()->sourceLanguage;
        }
//        $controllerId = Yii::app()->controller;
//      echo $controllerId;
        Yii::app()->language = $lang;
        if ((Yii::app()->getBaseUrl(true) == 'http://' . DSConfig::getVal('site_domain'))
          || (Yii::app()->getBaseUrl(true) == 'https://' . DSConfig::getVal('site_domain'))
        ) {
            $cookie = new CHttpCookie($langCookie, $lang, ['domain' => '.' . DSConfig::getVal('site_domain')]);
            $cookie->expire = time() + 3600 * 24 * 180;
            Yii::app()->request->cookies[$langCookie] = $cookie;
        }
    }

    public function createUrl($manager, $route, $params, $ampersand)
    {
//        /ru/site/index/recentAll_dataProvider_page/2600/popular_dataProvider_page/436/recommended_dataProvider_page/3
//recentAll_dataProvider_page
//recentUser_dataProvider_page
//popular_dataProvider_page
//recommended_dataProvider_page
//========== Stoplist ====
        if (isset($_SERVER['REQUEST_URI']) && preg_match(
            DSConfig::getVal('stoplist_search_throw'),
            $_SERVER['REQUEST_URI']
          )
        ) {
            $route = preg_replace(DSConfig::getVal('stoplist_search_throw'), '', $route);
            foreach ($params as $i => $param) {
                $params[$i] = preg_replace(DSConfig::getVal('stoplist_search_throw'), '', $param);
            }
        }
//========================
        $route = preg_replace(
          '/^[\/]*(?:az|sq|am|en|ar|hy|af|eu|ba|be|bn|my|bg|bs|cy|hu|vi|ht|gl|nl|el|ka|gu|da|he|yi|id|ga|it|is|es|kk|kn|ca|ky|zh|ko|xh|km|lo|la|lv|lt|lb|mg|ms|ml|mt|mk|mi|mr|mn|de|ne|no|pa|fa|pl|pt|ro|ru|sr|si|sk|sl|sw|su|tg|th|tl|ta|tt|te|tr|uz|uk|ur|fi|fr|hi|hr|cs|sv|gd|et|eo|jv|ja)\//',
          '',
          $route
        );
        $langCount = preg_match_all('/[,]+/', DSConfig::getVal('site_language_block'), $matches);
        $lang = Utils::appLang();
//========================
        if ($route == 'item/index') {
            if (isset($params['catpath']) && $params['catpath']) {
                $url =
                  ($langCount > 0 ? $lang . '/' : '') . 'category/' . $params['catpath'] . '/item' . $params['iid'];
                unset($params['catpath']);
            } else {
                if (isset($params['dsSource']) && $params['dsSource']) {
                    $url = ($langCount > 0 ? $lang . '/' : '') . 'item/' . $params['dsSource'] . '/' . $params['iid'];
                } else {
                    $url = ($langCount > 0 ? $lang . '/' : '') . 'item/' . $params['iid'];
                }
            }
            if (isset($params['recentUser_dataProvider_page'])) {
                $url = $url . '/recentUser_dataProvider_page/' . $params['recentUser_dataProvider_page'];
            }
        } elseif ($route == 'category/index') {
            $url = ($langCount > 0 ? $lang . '/' : '') . 'category/' . urldecode($params['name']);
            unset($params['name'], $params['cid'], $params['cid_query'], $params['ds_source']);
            $urlParams = trim($this->processParams($params, true), '?&');
            if ($urlParams) {
                //$url = rtrim($url, '/') . '?' . $urlParams;
                $url = $url . '?' . $urlParams;
            }
        } elseif ($route == 'brand/index') {
            $url = ($langCount > 0 ? $lang . '/' : '') . 'brand/' . (isset($params['name']) ? $params['name'] : '');
            unset($params['name']);
            $urlParams = trim($this->processParams($params, true), '?&');
            if ($urlParams) {
                //$url = rtrim($url, '/') . '?' . $urlParams;
                $url = $url . '?' . $urlParams;
            }
        } elseif ($route == 'search/index' || $route == 'search') {
            $url = ($langCount > 0 ? $lang . '/' : '') . 'search';
            $urlParams = trim($this->processParams($params, true), '?&');
            if ($urlParams) {
                //$url = rtrim($url, '/') . '?' . $urlParams;
                $url = $url . '?' . $urlParams;
            }
        } elseif ($route == 'favorite/index') {
            $url = ($langCount > 0 ? $lang . '/' : '') . 'favorite/' . (isset($params['name']) ? $params['name'] : '');
            unset($params['name'], $params['cid'], $params['cid_query']);
            $url = $url . $this->processParams($params);
        } elseif ($route == 'shop/index') {
            $url = ($langCount > 0 ? $lang . '/' : '') . 'shop/' . (isset($params['name']) ? $params['name'] : '');
            unset($params['name'], $params['cid'], $params['cid_query']);
            $url = $url . $this->processParams($params);
        } elseif ($route == 'article/index' || $route == 'article') {
            $url = ($langCount > 0 ? $lang . '/' : '') . 'article/' . (isset($params['url']) ? $params['url'] : '');
            unset($params['url']);
            $url = $url . $this->processParams($params);
        } elseif ($route == 'news/index' || $route == 'news') {
            $url =
              ($langCount > 0 ? $lang . '/' : '') .
              'news/' .
              (isset($params['news_dataProvider_page']) ? $params['news_dataProvider_page'] : '1');
            unset($params['news_dataProvider_page']);
            unset($params['ajax']);
            $url = $url . $this->processParams($params);
        } elseif ($route == 'adverts/index' || $route == 'adverts') {
            $url =
              ($langCount > 0 ? $lang . '/' : '') .
              'adverts/' .
              (isset($params['news_dataProvider_page']) ? $params['news_dataProvider_page'] : '1');
            unset($params['news_dataProvider_page']);
            unset($params['ajax']);
            $url = $url . $this->processParams($params);
        } elseif ($route == 'votings/index' || $route == 'votings') {
            $url =
              ($langCount > 0 ? $lang . '/' : '') .
              'votings/' .
              (isset($params['votings_dataProvider_page']) ? $params['votings_dataProvider_page'] : '1');
            unset($params['votings_dataProvider_page']);
            unset($params['ajax']);
            $url = $url . $this->processParams($params);
        } elseif ($route == 'polls/index' || $route == 'polls') {
            $url =
              ($langCount > 0 ? $lang . '/' : '') .
              'polls/' .
              (isset($params['votings_dataProvider_page']) ? $params['votings_dataProvider_page'] : '1');
            unset($params['votings_dataProvider_page']);
            unset($params['ajax']);
            $url = $url . $this->processParams($params);
        } else {
            $url = $this->processParams($params);
            if (strpos($route . $url, $lang . '/') === 0) {
                $url = $route . $url;
            } else {
                if (in_array($route, ['img/index'])) {
                    $url = $route . $url;
                } else {
                    $url = ($langCount > 0 ? $lang . '/' : '') . $route . $url;
                }
            }
        }
        $url = strtr($url, ['//' => '/']);
        return $url;
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if (preg_match('/\/under(?:\/|$)/is', $request->getUrl())) {
            return $pathInfo;
        }
//        if (isset($_REQUEST['ajax'])) {
//            return $request->requestUri;
//        }
        $banRule = Banrules::applyRules();
        if ($banRule !== false) {
            $pathInfo = $banRule;
        }
        if (preg_match('/^[\/]*site\/dsapi[\/]*$/is', $pathInfo)) {
            return $pathInfo;
        }
        if (preg_match('/\/(server\-status|favicon\.ico)/i', $pathInfo)) {
            $url = '/' . preg_replace(
                '/[\/]*(' . str_replace(',', '|', DSConfig::getVal('site_language_supported')) . ')\//i',
                '',
                $pathInfo
              );
            return $url;
        }
        if (preg_match('/bot|\+http/i', Yii::app()->request->userAgent) && Yii::app()->user->isGuest) {
            if (preg_match('/_dataProvider_page/', $rawPathInfo)) {
                throw new CHttpException(404, 'Page not found');
            }
        }
//-- Begin processing ------------
// Удаление странных языков, типа ru_RU или en_US
// $pathInfo=preg_replace('/((?:^|\/)(?:'.str_replace(',','|',DSConfig::getVal('site_language_supported')).'))_[a-z]{2}($|\/)/is','$1$2',$pathInfo);
        if (preg_match_all(
          '/(?:^|\/)(' . str_replace(',', '|', DSConfig::getVal('site_language_supported')) . ')(?:$|\/)/is',
          $pathInfo,
          $matches
        )) {
            $urlLang = $matches[1][0];
            //Удаление языка, чтобы не мешался
            //$pathInfo=preg_replace('/\/(?:'.str_replace(',','|',DSConfig::getVal('site_language_supported')).')(?=$|\/)/is','',$pathInfo);
            $pathInfo = preg_replace(
              '/(?<=^)(?:' . str_replace(',', '|', DSConfig::getVal('site_language_supported')) . ')(?:$|\/)/is',
              '',
              $pathInfo
            );
            $this->setLang($urlLang);
        }
//=========== Categories canonical url with items in format /item123414123123 ==================
//        if (!preg_match('/category\/menu/s', $pathInfo)) {
        $catPathVerified = false;
        if (preg_match(
          '/(?:(?:^|\/)category\/)(.+?\/)item([a-fA-F0-9ikIK\-]+)(?:$|[\/\?])/s',
          $pathInfo,
          $matches
        )) {
            $catPath = $matches[1];
            $iid = $matches[2];
            $catPathSlash = $catPath . '/';
            $ds_source = Yii::app()->db->createCommand(
              "select ds_source from categories_ext where url in ('{$catPath}','{$catPathSlash}') limit 1"
            )
              ->queryScalar();

            $pathInfo = 'item';
            if ($ds_source) {
                $pathInfo = $pathInfo . '/' . $ds_source;
            }
            $pathInfo = $pathInfo . '/' . $iid;
        } elseif (preg_match(
          '/(?:(?:^|\/)category\/)(.+?)(?:$|[\/\?](?:item[a-fA-F0-9ikIK\-]+|name|ajax|query|cid|page|props|price_min|price_max|sales_min|sales_max|rating_min|rating_max|sort_by|original|recommend|not_unique)(?:$|[\/=\?]))/s',
          $pathInfo,
          $matches
        )) {
            $catPath = $matches[1];
            $catPathSlash = $catPath . '/';
            $catPathVerified = Yii::app()->db->createCommand(
              "select url from categories_ext where url in ('{$catPath}','{$catPathSlash}') limit 1"
            )
              ->queryScalar();
            if (!$catPathVerified && !preg_match('/(\/|^)category\/menu\//is', $request->requestUri)) {
//========== fussy and different languages link processing =====================
                if (preg_match(
                    '/(?:\/|^)category\/(?!(?:menu|list))/is',
                    $request->requestUri
                  ) && !$request->isAjaxRequest
                ) {
// make the levenshtein array()
                    $cache = Yii::app()->cache->get('cat-fuzzy-url-search');
                    if (!$cache || (DSConfig::getVal('search_cache_enabled') != 1)) { //
                        $recs = Yii::app()->db->createCommand(
                          "
SELECT (CASE WHEN cp2.id=1 THEN '' ELSE cp2.zh END) AS p2_zh,(CASE WHEN cp1.id=1 THEN '' ELSE cp1.zh END) AS p1_zh, cc.zh, 
(CASE WHEN cp2.id=1 THEN '' ELSE cp2.ru END) AS p2_ru, (CASE WHEN cp1.id=1 THEN '' ELSE cp1.ru END) AS p1_ru, cc.ru, 
(CASE WHEN cp2.id=1 THEN '' ELSE cp2.en END) AS p2_en, (CASE WHEN cp1.id=1 THEN '' ELSE cp1.en END) AS p1_en, cc.en,
cc.url FROM categories_ext cc, categories_ext cp1, categories_ext cp2
 WHERE cc.parent=cp1.id AND cp1.parent=cp2.id AND cc.status != 0
 "
                        )->queryAll(true, []);
                        $catArray = [];
                        foreach ($recs as $rec) {
                            $newRec = [];
                            $newRec['ru'] = strtolower(
                              Utils::translitURL($rec['p2_ru'] . '/' . $rec['p1_ru'] . '/' . $rec['ru'])
                            );
                            $newRec['en'] = strtolower(
                              Utils::translitURL($rec['p2_en'] . '/' . $rec['p1_en'] . '/' . $rec['en'])
                            );
                            $newRec['bg'] = strtolower(
                              Utils::translitURL(
                                Yii::app()->DVTranslator->translateCategory(
                                  $rec['p2_zh'],
                                  'zh-CN',
                                  'bg',
                                  false,
                                  true
                                ) . '/' .
                                Yii::app()->DVTranslator->translateCategory(
                                  $rec['p1_zh'],
                                  'zh-CN',
                                  'bg',
                                  false,
                                  true
                                ) . '/' .
                                Yii::app()->DVTranslator->translateCategory(
                                  $rec['zh'],
                                  'zh-CN',
                                  'bg',
                                  false,
                                  true
                                )
                              )
                            );
                            $catArray[$rec['url']] = $newRec;
                        }
                        $cached = Yii::app()->cache->set('cat-fuzzy-url-search', $catArray, 600);
                    } else {
                        $catArray = $cache;
                    }
// Собственно, поиск похожей ссылки
                    $_similarity = 1000000;
                    $_similarUrl = '';
                    foreach ($catArray as $i => $cat) {
                        foreach ($cat as $rec) {
                            $similarity = levenshtein($request->requestUri, $rec, 1, 1, 1);
                            //$similarity = similar_text($name,$rec);
                            if ($_similarity > $similarity) {
                                $_similarity = $similarity;
                                $_similarUrl = $i;
                            }
                        }
                    }
                    if ($_similarUrl && (strpos($request->requestUri, '/category/' . $_similarUrl) === false)) {
                        $request->redirect('/category/' . $_similarUrl, true, 301);
                    }
                }

//========== end of fussy and different languages link processing ===============
            }
            if ($catPathVerified) {
                $catPathEncoded = urlencode($catPathVerified);
                $pathInfo = str_replace($catPath, $catPathEncoded, $pathInfo);
            }
        }
//        }
//=======================================================
        $pathArray = preg_split('/(\/)/', $pathInfo);
//======================================================================================================================
        if (isset($pathArray[0]) && $pathArray[0] == 'user' && isset($pathArray[1]) && $pathArray[1] == 'setlang') {
            if (isset($pathArray[2])) {
                $pathArray[2] = 'lang/' . $pathArray[2];
            } else {
                $pathArray[2] = 'lang/' . Yii::app()->language;
            }
        }
//======================================================================================================================
        if (isset($pathArray[0])) {
            if ($pathArray[0] == 'category') {
                if (preg_match('/\/virtual\/1/', $pathInfo)) {
                    $newUrl = '/' . preg_replace('/\/virtual\/1/', '', $rawPathInfo);
                    $request->redirect($newUrl, true, 301);
                    return $pathInfo;
                }
                if (isset($pathArray[1]) && $catPathVerified) {
                    $pathArray[0] .= '/index';
                    if (gettype($pathArray[1]) == 'string') {
                        $pathArray[1] = 'name/' . $pathArray[1];
                    } else {
                        $pathArray[1] = 'cid/' . $pathArray[1];
                    }
                }
            } elseif ($pathArray[0] == 'brand') {
                if (isset($pathArray[1]) && !in_array($pathArray[1], ['list'])) {
                    $pathArray[0] .= '/index';
                    if (gettype($pathArray[1]) == 'string') {
                        $pathArray[1] = 'name/' . urlencode($pathArray[1]);
                    } else {
                        $pathArray[1] = 'cid/' . $pathArray[1];
                    }
                }
            } elseif ($pathArray[0] == 'favorite') {
                if (isset($pathArray[1]) && !in_array($pathArray[1], ['list'])) {
                    $pathArray[0] .= '/index';
                    if (gettype($pathArray[1]) == 'string') {
                        $pathArray[1] = 'name/' . urlencode($pathArray[1]);
                    } else {
                        $pathArray[1] = 'cid/' . $pathArray[1];
                    }
                }
            } elseif ($pathArray[0] == 'shop') {
                if (isset($pathArray[1]) && !in_array($pathArray[1], ['list'])) {
                    $pathArray[0] .= '/index';
                    if (gettype($pathArray[1]) == 'string') {
                        $pathArray[1] = 'name/' . urlencode($pathArray[1]);
                    } else {
                        $pathArray[1] = 'cid/' . $pathArray[1];
                    }
                }
            } elseif ($pathArray[0] == 'item') {
                $ds_sources = Yii::app()->db->cache(600)->createCommand(
                  "SELECT cc.ds_source FROM categories_ext cc GROUP BY cc.ds_source"
                )
                  ->queryColumn();
                if ($ds_sources && isset($pathArray[1]) && array_search($pathArray[1], $ds_sources) !== false
                  && isset($pathArray[2]) && preg_match('/^[a-fA-F0-9ikIK\-]+$/', $pathArray[2])
                ) {
                    //$useDsSource = true;
                    $pathArrayIid = $pathArray[2];
                    $pathArrayDsSource = $pathArray[1];
                } elseif (!array_search($pathArray[1], $ds_sources) && isset($pathArray[1]) && preg_match(
                    '/^[a-fA-F0-9ikIK\-]+$/',
                    $pathArray[1]
                  )
                ) {
                    //$useDsSource = false;
                    $pathArrayIid = $pathArray[1];
                } elseif (!array_search($pathArray[1], $ds_sources) && isset($pathArray[2]) && preg_match(
                    '/^[a-fA-F0-9ikIK\-]+$/',
                    $pathArray[2]
                  )
                ) {
                    //$useDsSource = false;
                    $pathArrayIid = $pathArray[2];
                }
                if (isset($pathArrayIid)) {
                    $pathArray[0] .= '/index';
                    $pathArray[1] = 'iid/' . $pathArrayIid;
                    if (isset($pathArrayDsSource)) {
                        $pathArray[2] = 'dsSource/' . $pathArrayDsSource;
                    }
                }
            } elseif ($pathArray[0] == 'search') {
//                if (isset($pathArray[1]) && (int) $pathArray[1]) {
                if (!(isset($pathArray[1]) &&
                  ($pathArray[1] == 'index' || $pathArray[1] == 'searchByImage' || $pathArray[1] == 'searchByList'))) {
                    $pathArray[0] .= '/index';
                }
//                    $pathArray[1] = 'iid/' . $pathArray[1];
//                }
            } elseif ($pathArray[0] == 'article') {
                if (preg_match('/megamaz/i', DSConfig::getVal('site_domain')) && false) {
                    if (!preg_match('/index\/url\//', $pathInfo)) {
                        $pathArray[0] .= '/index/url';
                        $newUrl = '/' . implode('/', $pathArray);
                        $request->redirect($newUrl, true, 301);
                    }
                } else {
                    if (preg_match('/(?:index\/)*url\//', $pathInfo)) {
                        $newUrl = '/' . preg_replace('/(?:index\/)*url\//', '', $rawPathInfo);
                        $request->redirect($newUrl, true, 301);
                        return $pathInfo;
                    }
                    if (preg_match('/\/$/s', $request->requestUri)) {
                        $newUrl = preg_replace('/\/$/', '', $request->requestUri);
                        $request->redirect($newUrl, true, 301);
                        return $pathInfo;
                    }
                }
                $pathArray[0] .= '/index/url';
            } elseif ($pathArray[0] == 'news') {
                if (isset($pathArray[1]) && preg_match('/^\d+$/i', $pathArray[1])) {
                    $pathArray[0] .= '/index';
                    $pathArray[1] = 'news_dataProvider_page/' . $pathArray[1];
                }
            } elseif ($pathArray[0] == 'adverts') {
                if (isset($pathArray[1]) && preg_match('/^\d+$/i', $pathArray[1])) {
                    $pathArray[0] .= '/index';
                    $pathArray[1] = 'news_dataProvider_page/' . $pathArray[1];
                }
            } elseif ($pathArray[0] == 'votings') {
                if (isset($pathArray[1]) && preg_match('/^\d+$/i', $pathArray[1])) {
                    $pathArray[0] .= '/index';
                    $pathArray[1] = 'votings_dataProvider_page/' . $pathArray[1];
                }
            } elseif ($pathArray[0] == 'polls') {
                if (isset($pathArray[1]) && preg_match('/^\d+$/i', $pathArray[1])) {
                    $pathArray[0] .= '/index';
                    $pathArray[1] = 'votings_dataProvider_page/' . $pathArray[1];
                }
            }
        }
//======================================================================================================================
        $res = implode('/', $pathArray);
        return $res;
    }
}