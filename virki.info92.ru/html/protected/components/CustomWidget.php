<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CustomWidget.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CustomWidget extends CWidget
{
    protected $vars;
    public $frontTheme = '';
    public $frontThemePath = '';
    public $mobile = null;
    private static $_checkPhpSyntaxResults = [];

    private function checkPhpSyntax($view)
    {
        $result = true;
        if (YII_DEBUG) {
            if (isset(self::$_checkPhpSyntaxResults[$view])) {
                $result = self::$_checkPhpSyntaxResults[$view];
            } else {
                $reflector = new ReflectionClass(get_class($this));
                $file = $reflector->getFileName();
                if (!$file) {
                    $file = $view;
                }
                if (!file_exists($file)) {
                    $result = false;
                } else {
                    $checkResult = @exec("php -l $file");
                    if ($checkResult && (substr($checkResult, 0, 28) != 'No syntax errors detected in')) {
                        $result = false;
                    }
                }
            }
            if (!$result) {
                echo "<pre>Error in file or view: {$file}</pre>";
            }
            self::$_checkPhpSyntaxResults[$view] = $result;
        }
        return $result;
    }

    private function markupReport($report)
    {
        return "\r\n<description hidden=\"true\">\r\n" . $report . "</description>\r\n";
    }

    private function renderVars($view, $data)
    {
        if (is_array($data)) {
            foreach ($data as $name => $var) {
                $this->vars[$name] = $var;
            }
        }
        $this->vars->prepareReport();
    }

    public function init()
    {
        $this->vars = new CustomControllerVars();
        $this->frontTheme = Yii::app()->theme->name;
        if ($this->frontTheme == 'admin') {
            $this->frontTheme = DSConfig::getVal('site_front_theme');
        }
        $this->frontThemePath = Yii::app()->request->baseUrl . '/themes/' . $this->frontTheme;
        Yii::setPathOfAlias(
          'themeBlocks',
          Yii::getPathOfAlias('webroot.themes') . '/' . $this->frontTheme . '/views/widgets'
        );
        $this->mobile = new Mobile_Detect();
        parent::init();
    }

    /**
     * Renders a view.
     * The named view refers to a PHP script (resolved via {@link getViewFile})
     * that is included by this method. If $data is an associative array,
     * it will be extracted as PHP variables and made available to the script.
     * @param string  $view   name of the view to be rendered. See {@link getViewFile} for details
     *                        about how the view script is resolved.
     * @param array   $data   data to be extracted into PHP variables and made available to the view script
     * @param boolean $return whether the rendering result should be returned instead of being displayed to end users
     * @return string the rendering result. Null if the rendering result is not required.
     * @throws CException if the view does not exist
     * @see getViewFile
     */
    public function render($view, $data = null, $return = false, $forceNoDebug = false)
    {
        /*    if(($viewFile=$this->getViewFile($view))!==false)
              return $this->renderFile($viewFile,$data,$return);
            else
              throw new CException(Yii::t('yii','{widget} cannot find the view "{view}".',
                array('{widget}'=>get_class($this), '{view}'=>$view)));
        */
        if (!$this->checkPhpSyntax($view)) {
            return;
        }
// jquery publication
        $cs = Yii::app()->clientScript;
        $cs->scriptMap['jquery-ui.js'] = false;
        $cs->scriptMap['jquery-ui.min.js'] = false;
        $cs->scriptMap['jquery-ui.css'] = false;
        $cs->scriptMap['jquery-ui.min.css'] = false;
        //$cs->scriptMap['jquery.js'] = false;
        //$cs->scriptMap['jquery.js']    = $this->frontThemePath .'/js/jquery-1.11.3.js';
        //$cs->scriptMap['jquery.min.js']  = $this->frontThemePath .'/js/jquery-1.11.3.min.js';
        try {
            if (YII_DEBUG && !$forceNoDebug) {
                $this->renderVars($view, $data);
                $reflector = new ReflectionClass(get_class($this));
                $thisFileName = $reflector->getFileName();
                $controllerReport = "Widget: " . get_class($this) . "\r\nFile: " . $thisFileName;
                $viewReport = "View file: " . $this->getViewFile($view);
                $varsReport = "View parameters:\r\n" . $this->vars->report;
                $headReport = $this->markupReport($controllerReport . "\r\n" . $viewReport . "\r\n" . $varsReport);
                $footReport = $this->markupReport('End of widget ' . get_class($this));
                echo $headReport . parent::render($view, $data, true) . $footReport;
                return;
            }
            return parent::render($view, $data, $return);
        } catch (Exception $e) {
            if (isset($e->xdebug_message)) {
                $xdebug_message = $e->xdebug_message;
                unset($e->xdebug_message);
            } else {
                $xdebug_message = null;
            }
            echo '<pre>Error from CustomWidget rendering in ' . ($this->getViewFile($view) ? $this->getViewFile(
                $view
              ) : $view . ' - not found!') . '</pre><br>';
            CVarDumper::dump($e, (YII_DEBUG ? 10 : 1), true);
            if (YII_DEBUG && $xdebug_message) {
                echo '<br><table>' . $xdebug_message . '</table>';
            }
            return;
        }
    }

}