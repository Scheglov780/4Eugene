<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CustomFrontController.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class CustomFrontController extends CustomController
{
    function __construct($id, $module = null)
    {
        if ($this->id == 'img' && $this->action = 'index') {
            return;
        }
        $preg = '/(?<!img\d\.)' . str_replace('.', '\.', DSConfig::getVal('site_domain')) . '/i';
        $baseUrl = Yii::app()->getBaseUrl(true);
        if (preg_match($preg, $baseUrl)) {
            $langRegexp = '/\/(' . trim(str_replace(',', '|', DSConfig::getVal('site_language_block'))) . ')\//i';
            if (isset(Yii::app()->request->cookies['front_lang'])) {
                Yii::app()->language = Yii::app()->request->cookies['front_lang']->value;
            } elseif (preg_match($langRegexp, Yii::app()->request->requestUri, $langMatches)) {
                Yii::app()->language = $langMatches[1];
            } else {
                $prefLang = Yii::app()->request->getPreferredLanguage();
                $prefLang = substr($prefLang, 0, 2);
                Yii::app()->language = $prefLang;
            }
            $languages = explode(',', DSConfig::getVal('site_language_block'));
            if (!in_array(Yii::app()->language, $languages)) {
                if (count($languages)) {
                    Yii::app()->language = $languages[0];
                } else {
                    Yii::app()->language = Yii::app()->sourceLanguage;
                }
            }
            if ((!isset(Yii::app()->request->cookies['front_lang'])) ||
              (Yii::app()->language !== Yii::app()->request->cookies['front_lang']->value)) {
                $cookie = new CHttpCookie(
                  'front_lang',
                  Yii::app()->language,
                  ['domain' => '.' . DSConfig::getVal('site_domain')]
                );
                $cookie->expire = time() + 60 * 60 * 24 * 180;
                Yii::app()->request->cookies['front_lang'] = $cookie;
            }
//=================================
//        SiteLog::doHttpLog();
//=================================
        }
        parent::__construct($id, $module);
    }

    private $_ifModifiedSince;
    private $_isSendLastModified = false;
    public $body_class = 'default';
    public $breadcrumbs = [];
    public $columns = 'two-col';
    public $frontTheme = '';
    public $frontThemeAbsolutePath = '';
    public $frontThemePath = '';
    public $icon = '';
    public $meta_desc = '';
    public $meta_keyword = '';

//    public $layout =  '';
    public $params = [];

    /**
     * This method is invoked right after an action is executed.
     * You may override this method to do some postprocessing for the action.
     * @param CAction $action the action just executed.
     */
    protected function afterAction($action)
    {
        if ($this->id == 'img' && $this->action = 'index') {
            return;
        }
//=================================
        //SiteLog::doHttpLog();
//=================================
        parent::afterAction($action);
    }

    /**
     * This method is invoked at the beginning of {@link render()}.
     * You may override this method to do some preprocessing when rendering a view.
     * @param string $view the view to be rendered
     * @return boolean whether the view should be rendered.
     * @since 1.1.5
     */
    protected function beforeRender($view)
    {
// jquery publication
        $cs = Yii::app()->clientScript;

        $cs->scriptMap['jquery-ui.js'] = false;
        $cs->scriptMap['jquery-ui.min.js'] = false;
        $cs->scriptMap['jquery-ui.css'] = false;
        $cs->scriptMap['jquery-ui.min.css'] = false;

        //$cs->scriptMap['jquery.js'] = false;
        //$cs->scriptMap['jquery.js']    = $this->frontThemePath .'/js/jquery-1.11.3.js';
        //$cs->scriptMap['jquery.min.js']  = $this->frontThemePath .'/js/jquery-1.11.3.min.js';

        Yii::app()->clientScript->registerScript(YII_DEBUG ? 'jquery.js' : 'jquery.min.js', CClientScript::POS_HEAD);
// define lang var for js
        $jsLang = Utils::appLang();
        Yii::app()->clientScript->registerScript(
          'defineLangVar',
          "
             var lang='" . $jsLang . "';
    ",
          CClientScript::POS_BEGIN
        );
// Поддержка rtl (например, иврит)
        if (Utils::appLang() == 'he') {
            Yii::app()->clientScript->registerCss(
              'defineRTL',
              'html, body {
              height:100%;
              direction:rtl;
              }'
            );
        }
// Делаем правильную поддержку мультиязычности для SEO
        $url = Yii::app()->request->hostInfo . Yii::app()->request->url;
        header('Content-Language: ' . Utils::appLang());
        //Link: <http://ru-ru.example.ru/>; rel="alternate"; hreflang="ru-ru"
        $lang_array = explode(',', DSConfig::getVal('site_language_block'));
        if (count($lang_array) > 1) {
            $lang_links = [];
            foreach ($lang_array as $val) {
                if (Utils::appLang() == $val) {
                    continue;
                }
                $resUrl = preg_replace('/\/(?:' . implode('|', $lang_array) . ')\//', '/', $url);
                $resUrl = str_replace(
                  Yii::app()->request->hostInfo,
                  Yii::app()->request->hostInfo . '/' . $val,
                  $resUrl
                );
                $lang_links[] = '<' . $resUrl . '>; rel="alternate"; hreflang="' . $val . '"';
            }
            header('Link: ' . implode(', ', $lang_links));
        }

//----------------------------------------------------
// meta tags processing
        $geoSEOCityText = Utils::geoSEOCityText();
        if (!$this->pageTitle) {
            $this->pageTitle = cms::customContent('default-meta-title', true, true);
        }
        if ($this->meta_desc) {
            Yii::app()->clientScript->registerMetaTag(
              trim(
                $this->meta_desc .
                ' ' .
                ($geoSEOCityText && isset($geoSEOCityText->description) ? $geoSEOCityText->description : '')
              ),
              'description',
              null,
              ['lang' => Utils::appLang()],
              'page-description'
            );
        } else {
            if (!Yii::app()->clientScript->isMetaTagExists('page-description')) {
                Yii::app()->clientScript->registerMetaTag(
                  trim(
                    cms::customContent(
                      'default-meta-description',
                      true,
                      true
                    ) .
                    ' ' .
                    ($geoSEOCityText && isset($geoSEOCityText->description) ? $geoSEOCityText->description : '')
                  ),
                  'description',
                  null,
                  ['lang' => Utils::appLang()],
                  'page-description'
                );
            }
        }
        if ($this->meta_keyword) {
            Yii::app()->clientScript->registerMetaTag(
              trim(
                $this->meta_keyword .
                ' ' .
                ($geoSEOCityText && isset($geoSEOCityText->keywords) ? $geoSEOCityText->keywords : '')
              ),
              'keywords',
              null,
              ['lang' => Utils::appLang()],
              'page-keywords'
            );
        } else {
            if (!Yii::app()->clientScript->isMetaTagExists('page-keywords')) {
                Yii::app()->clientScript->registerMetaTag(
                  trim(
                    cms::customContent(
                      'default-meta-keywords',
                      true,
                      true
                    ) . ' ' . ($geoSEOCityText && isset($geoSEOCityText->keywords) ? $geoSEOCityText->keywords : '')
                  ),
                  'keywords',
                  null,
                  ['lang' => Utils::appLang()],
                  'page-keywords'
                );
            }
        }
        /*        Yii::app()->clientScript->registerMetaTag(
                  'DropShop team',
                  'author',
                  null,
                  array('lang' => Utils::appLang()),
                  'page-author'
                );
        */
        Yii::app()->clientScript->registerMetaTag(
          '(c)2019-' . date('Y') . ', Virki2 team',
          'copyright',
          null,
          ['lang' => Utils::appLang()],
          'page-copyright'
        );
        return true;
    }

//=========================================================================

    /**
     * Проверяет изменился ли документ с даты в IF_MODIFIED_SINCE
     * Если нет, то сообщает, что документ не изменился
     * @param $time время последнего изменения в формате UNIX
     */
    protected function ifModifiedSince($time)
    {
        if ($this->_ifModifiedSince >= $time) {
            $this->sendHeaderNotModified();
        }
    }

    /**
     * Проверяет пришёл ли IF_MODIFIED_SINCE
     * Возвращает либо ложь, если не пришёл, либо пришедшее для проверки время
     * @return bool|int
     */
    protected function issetIfModifiedSince()
    {
        header('Cache-Control: public, max-age=864000');
        header('Pragma: public');
        $this->_ifModifiedSince = false;
        if (isset($_ENV['HTTP_IF_MODIFIED_SINCE'])) {
            $this->_ifModifiedSince = strtotime(substr($_ENV['HTTP_IF_MODIFIED_SINCE'], 5));
        }
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            $this->_ifModifiedSince = strtotime(substr($_SERVER['HTTP_IF_MODIFIED_SINCE'], 5));
        }
        return $this->_ifModifiedSince;
    }

    /**
     * Отправляет хидер last_modified
     * @param $time int время последнего изменения в формате UNIX
     */
    protected function lastModified($time)
    {
        $this->_isSendLastModified = true;
        header('Last-Modified: ' . gmdate("D, d M Y H:i:s \G\M\T", $time));
    }

    /* ===============================================================
     * HTTP - кэширование
     * ===================================================================== */

    /**
     * Отправляет код Документ не изменился
     */
    protected function sendHeaderNotModified()
    {
        header('HTTP/1.1 304 Not Modified');
        Yii::app()->end();
    }

    public function filters()
    {
        return [
          ['application.components.AjaxRenderFilter'],
          ['application.components.PostprocessFilter'],
        ];
    }

    /**
     * Returns the directory containing view files for this controller.
     * The default implementation returns 'protected/views/ControllerID'.
     * Child classes may override this method to use customized view path.
     * If the controller belongs to a module, the default view path
     * is the {@link CWebModule::getViewPath module view path} appended with the controller ID.
     * @return string the directory containing the view files for this controller. Defaults to
     *                'protected/views/ControllerID'.
     */
    public function getViewPath()
    {
        if (($module = $this->getModule()) === null) {
            $module = Yii::app();
        }
//        return $module->getViewPath() . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $this->getId();
        return $module->getViewPath() . DIRECTORY_SEPARATOR . $this->getId();
    }

    public function httpCache($lastModified = null)
    {
        $uid = Yii::app()->user->id;
        if (is_null($uid) && preg_match('/bot|\+http/i', Yii::app()->request->userAgent)) {
            if (!$lastModified) {
                $lastModified = strtotime('last Monday');
            }
            if ($this->issetIfModifiedSince()) {
                $this->ifModifiedSince($lastModified);
            } else {
                $this->lastModified($lastModified);
            }
        }
    }

    public function init()
    {
        //  header('Access-Control-Allow-Origin: *');
//        if (!Yii::app()->theme->name) {
        Yii::app()->theme = DSConfig::getVal('site_front_theme');
//        }
        if (isset(Yii::app()->request->cookies['frontTheme'])) {
            $cookieTheme = (string) Yii::app()->request->cookies['frontTheme'];
        } else {
            $cookieTheme = false;
        }
        if ($cookieTheme) {
            Yii::app()->theme = $cookieTheme;
        }
        if (isset(Yii::app()->theme->name)) {
            $this->frontTheme = Yii::app()->theme->name;
        } else {
            $this->frontTheme = 'default';
        }
        $themePath = Yii::getPathOfAlias('webroot') . '/themes/' . $this->frontTheme;
        if (!file_exists($themePath)) {
            $this->frontTheme = 'default';
        }
        $this->frontThemePath = Yii::app()->request->baseUrl . '/themes/' . $this->frontTheme;
        $this->frontThemeAbsolutePath = Yii::getPathOfAlias('webroot') . '/themes/' . $this->frontTheme;
//=================================
//=================================
        if ($this->id == 'img' && $this->action = 'index') {
            return;
        }
        if (isset($_SERVER['REQUEST_URI']) && preg_match(
            DSConfig::getVal('stoplist_search_throw'),
            urldecode($_SERVER['REQUEST_URI'])
          )
        ) {
            $this->redirect($this->createUrl('site/error', ['code' => 404]), true, 301);
            //throw new CHttpException(404, Yii::t('main', 'Not Found'));
        }
        $userId = Yii::app()->user->id;
        if ($userId != null) {
            $user = Users::model()->findByPk($userId);
            if (($user === false) || ($user == null)) {
                Yii::app()->user->logout();
                Yii::app()->user->clearStates();
            }
        }
        $this->pageTitle = '';
        parent::init();
    }
}