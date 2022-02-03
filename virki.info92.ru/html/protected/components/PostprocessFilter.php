<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="PostprocessFilter.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class PostprocessFilter extends CFilter
{
    protected $_allowedActions = [];
    private static $_useTranslationTag = null;

    protected function postFilter($filterChain)
    {
        $content = ob_get_clean();
        $content = $this->filterTranslation($content);
        echo $content;
        return parent::postFilter($filterChain);
    }

    /**
     * Performs the pre-action filtering.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action
     *                                  should be executed.
     */
    protected function preFilter($filterChain)
    {
        ob_start();
        return parent::preFilter($filterChain);
    }

    public static function filterTranslation($content)
    {
        if (isset(Yii::app()->controller->preLoading) && Yii::app()->controller->preLoading) {
            return $content;
        }
        if (!strpos($content, '</translation>')) {
            return $content;
        }
        $startTime = microtime(true);
        $result = $content;
        try {
            ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
            ini_set('pcre.recursion_limit', 1 * 1024 * 1024);
            ini_set('memory_limit', '256M');
            $checkRemoteTranslatorVal = DSGDownloader::checkRemoteTranslator();
            $checkRemoteTranslator = $checkRemoteTranslatorVal == 'OK';
            //$checkRemoteTranslator &&
            /*
             <translation editable="1" translated="1" url="pim.mall92.ru:8090/site/translate" type="prop" from="zh" to="ru" id="prop10820484S" title="prop[10820484][S]: 尺寸" >Размер<translate  onclick="editTranslation(event,this.parentNode,'prop','10820484','S'); stopPropagation(event); return false;" ><span class="ui-icon ui-icon-pencil"></span></translate></translation>
            */
            $res = preg_match_all(
              '/(?:<|&lt;)translation.*?\stranslated=(?:[\'"]|&quot;)0(?:[\'"]|&quot;)\s.*?(?:<|&lt;)\/translation(?:>|&gt;)/i',
              $result,
              $matches,
              PREG_SET_ORDER
            );
            $lang = Utils::appLang();
            foreach ($matches as $i => $match) {
                if (strpos($match[0], "to=\"{$lang}\"") === false) {
                    if (strpos($match[0], "from=\"zh")) {
                        $matches[$i][0] = preg_replace('/to=".+?"/', "to=\"{$lang}\"", $match[0]);
                        $result = str_replace($match, $matches[$i][0], $result);
                    }
                }
            }
            if ($checkRemoteTranslator && (DSConfig::getVal('translator_block_mode_enabled') == 1)) {
//      unset($content);
//        return $content;
                if ($res) {
                    $res = Utils::getRemoteTranslation($matches);
                    unset($matches);
// ==== end of post and get data to translator ====================
                    if (($res->data) && ($res->info['http_code'] < 400)) {
                        $translations = unserialize($res->data);
                        unset($res);
                        if (($translations) && (is_array($translations))) {
                            Yii::app()->DVTranslator->translatePinnedArray($translations);
                            $startTimeForLoop = microtime(true);
                            foreach ($translations as $i => $translation) {
                                //continue;
                                //$mem=memory_get_usage(true);
                                //$memPeak=memory_get_peak_usage(true);
                                try {
                                    if (isset($translation[1])) {
                                        //continue;
                                        $translationView = self::renderTranslation(
                                          $translation[1],
                                          $i,
                                          (($i == count($translations) - 1) ? true : false)
                                        );
                                        $result = str_replace($translation[0], $translationView, $result);
                                        unset($translations[$i][0], $translations[$i][1], $translation[0], $translation[1], $translationView);
                                    }
                                } catch (Excception $e) {
                                    continue;
                                }
                            }
                            $endTimeForLoop = microtime(true) - $startTimeForLoop;
                            $endLoopTime = $endTimeForLoop;
                        }
                    }
                }
                $endTime = microtime(true) - $startTime;
                return $result;
            } else {
                /*
                <translation editable="1" translated="0" url="/site/translate" type="prop" from="zh" to="ru" id="prop0S" title="prop[0][S]: 鞋头款式" >鞋头款式<translate  onclick="editTranslation(event,this.parentNode,'prop','0','S'); stopPropagation(event); return false;" ><span class="ui-icon ui-icon-pencil"></span></translate></translation>
                */
                if (($matches) && (is_array($matches))) {
                    foreach ($matches as $match) {
                        if (isset($match[0])) {
                            $result = str_replace(
                              $match[0],
                              Yii::app()->DVTranslator->removeOnlineTranslation($match[0]),
                              $result
                            );
                        }
                    }
                }
                $endTime = microtime(true) - $startTime;
                return $result;
            }
        } catch (Exception $e) {
            return $content;
        }
    }

    public static function renderTranslation($srcTranslation, $index, $last)
    {
        if (!strpos($srcTranslation, '</translation>')) {
            return $srcTranslation;
        }
        if (!isset(Yii::app()->controller->frontTheme)) {
            self::$_useTranslationTag = false;
        }
        try {
            $cacheKey =
              'render-translation-' .
              md5($srcTranslation) .
              '-' .
              (Yii::app()->user->checkAccess('site/translate') ? 'true' : 'false');
            if (isset(Yii::app()->memCache)) {
                $cache = @Yii::app()->memCache->get($cacheKey);
            } else {
                $cache = @Yii::app()->cache->get($cacheKey);
            }
            if (!$cache) {
                if (is_null(self::$_useTranslationTag)) {
                    //$view = 'themeBlocks.translationTag.translationTag';
                    $view =
                      'webroot.themes.' .
                      Yii::app()->controller->frontTheme .
                      '.views.widgets.translationTag.translationTag';
                    $viewPath = YiiBase::getPathOfAlias($view) . '.php';
                    if (file_exists($viewPath)) {
                        self::$_useTranslationTag = $viewPath;
                    }
                }
                if (self::$_useTranslationTag) {
                    $result = Yii::app()->controller->renderFile(
                      self::$_useTranslationTag,
                      ['srcTranslation' => $srcTranslation, 'index' => $index, 'last' => $last],
                      true
                    );
                } else {
                    $result = $srcTranslation;
                }
                if (isset(Yii::app()->memCache)) {
                    @Yii::app()->memCache->set($cacheKey, $result, 600);
                } else {
                    @Yii::app()->cache->set($cacheKey, $result, 600);
                }
            } else {
                $result = $cache;
            }
        } catch (Exception $e) {
            return $srcTranslation;
        }
        return $result;
    }

}
