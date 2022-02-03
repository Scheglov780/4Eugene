<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="CustomFrontController.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class CustomController extends CController
{
    protected $vars;
    /**
     * @var Mobile_Detect
     */
    public $mobile = null;
    private static $_checkPhpSyntaxResults = [];

    private function checkPhpSyntax($view)
    {
        $result = true;
        if (YII_DEBUG) {
            if (isset(self::$_checkPhpSyntaxResults[$view])) {
                $result = self::$_checkPhpSyntaxResults[$view];
            } else {
                $file = $this->getViewFile($view);
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
                echo "<pre>Error in file or view: {$file} in " .
                  Yii::app()->controller->id .
                  "\\" .
                  Yii::app()->controller->action->id .
                  ' (' .
                  $file .
                  ')' .
                  "</pre>";
            }
            self::$_checkPhpSyntaxResults[$view] = $result;
        }
        return $result;
    }

    private function markupReport($report)
    {
//    if (strpos($report,'<!DOCTYPE')!==false) {
        return "\r\n<!--\r\n" . $report . "-->\r\n";
//    } else {
//    return "\r\n<description hidden=\"true\">\r\n".$report."</description>\r\n";
//    }
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

    protected function dbLog()
    {
        if (!Yii::app()->user->isGuest) {
            try {
                $uid = Yii::app()->user->id;
                $controller = $this->id ?? 'unknown';
                if (isset($this->module)) {
                    $module = $this->module->id ?? 'main';
                } else {
                    $module = 'main';
                }
                if (isset($this->action)) {
                    $action = $this->action->id ?? 'index';
                } else {
                    $action = 'unknown';
                }
                Yii::app()->db->createCommand(
                  "
        insert into log_user_activity (uid, date, module, controller, action) 
        values (:uid, now()::date + (date_trunc('hour', now()::time) +
        ceil(date_part('minute', now()::time)::decimal / 15) * interval '15 min')::time, :module, :controller, :action)
        ON CONFLICT ON CONSTRAINT log_user_activity_uid_date_module_controller_action_key
        DO UPDATE SET \"count\" = coalesce(excluded.count,1)+1 
        "
                )->execute(
                  [
                    ':uid'        => $uid,
                    ':module'     => $module,
                    ':controller' => $controller,
                    ':action'     => $action,
                  ]
                );
            } catch (Exception $e) {
                return;
            }
        }
    }

    /**
     * Denies the access of the user.
     * @param string $message the message to display to the user.
     *                        This method may be invoked when access check fails.
     * @throws CHttpException when called unless login is required.
     */
    public function accessDenied($message = null)
    {
        if ($message === null) {
            $message = Yii::t('main', 'У Вас нет доступа к этой странице.');
        }

        $user = Yii::app()->user;
        if ($user->isGuest === true) {
            $user->loginRequired();
        } else {
//    if (Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(403, $message);
        }
    }

    public function ajaxRender($view)
    {
        return $this->renderPartial($view, null, true, false);
    }

    /**
     * @return string the actions that are always allowed separated by commas.
     */
    public function allowedActions()
    {
        return '';
    }

//=========================================================================
// Access rights management
//=========================================================================

    /**
     * The filter method for 'rights' access filter.
     * This filter is a wrapper of {@link CAccessControlFilter}.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     */
    public function filterRights($filterChain)
    {
        $filter = new RightsFilter;
        $filter->allowedActions = $this->allowedActions();
        $filter->filter($filterChain);
    }

//=========================================================================
// Access rights management
//=========================================================================

    public function init()
    {
        // register class paths for extension captcha extended
        if (is_dir(Yii::getPathOfAlias('ext.captchaExtended'))) {
            Yii::$classMap = array_merge(
              Yii::$classMap,
              [
                'CaptchaExtendedAction'    => Yii::getPathOfAlias(
                    'ext.captchaExtended'
                  ) . DIRECTORY_SEPARATOR . 'CaptchaExtendedAction.php',
                'CaptchaExtendedValidator' => Yii::getPathOfAlias(
                    'ext.captchaExtended'
                  ) . DIRECTORY_SEPARATOR . 'CaptchaExtendedValidator.php',
              ]
            );
        }
        if (!Yii::app()->request->isAjaxRequest && (is_a($this, 'SearchController') || is_a(
              $this,
              'ArticleController'
            ) || is_a($this, 'CategoryController')) // || is_a($this, 'SiteController')
        ) {
            $cache = false;
            if (isset(Yii::app()->memCache)) {
                $cache = @Yii::app()->memCache->get('Scheduler-executed-last');
            }
            if (!$cache) {
                //ScheduledJobs::schedulerEvent();
                $url = Yii::app()->createUrl('/site/scheduler', []);
                Yii::app()->clientScript->registerScript(
                  'scheduler_event',
                  "try {
            $.ajaxq('Scheduler-Event',{
			type: 'GET',
			cache: false,
			url: '{$url}',
            xhrFields: {
                withCredentials: true
            },			
			timeout: 60000,
			success: function(data, textStatus, request){
			console.log('Scheduled events: processed');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
			console.log('Scheduled events: error');
			}
		    });
		    } catch (e) {
			console.log('Scheduled events: error');
		    }
       ",
                  CClientScript::POS_END
                );
                if (isset(Yii::app()->memCache)) {
                    @Yii::app()->memCache->set('Scheduler-executed-last', microtime(true), 60);
                }
            }
        }
        $this->vars = new CustomControllerVars();
        $this->mobile = new Mobile_Detect();
        parent::init();
    }

    /**
     * Renders a view with a layout.
     * This method first calls {@link renderPartial} to render the view (called content view).
     * It then renders the layout view which may embed the content view at appropriate place.
     * In the layout view, the content view rendering result can be accessed via variable
     * <code>$content</code>. At the end, it calls {@link processOutput} to insert scripts
     * and dynamic contents if they are available.
     * By default, the layout view script is "protected/views/layouts/main.php".
     * This may be customized by changing {@link layout}.
     * @param string  $view   name of the view to be rendered. See {@link getViewFile} for details
     *                        about how the view script is resolved.
     * @param array   $data   data to be extracted into PHP variables and made available to the view script
     * @param boolean $return whether the rendering result should be returned instead of being displayed to end users.
     * @return string the rendering result. Null if the rendering result is not required.
     * @see renderPartial
     * @see getLayoutFile
     */
    public function render($view, $data = null, $return = false, $forceNoDebug = false)
    {
        if (is_string($view) && $view[0] == '@') {
            $output = substr($view, 1);
            if (($layoutFile = $this->getLayoutFile($this->layout)) !== false) {
                $output = $this->renderFile($layoutFile, ['content' => $output], true);
            }
            $output = $this->processOutput($output);
            echo $output;
            return;
        }
        $footReport = '';
        $headReport = '';
        if (YII_DEBUG && !$forceNoDebug) {
            $this->renderVars($view, $data);
            $thisAction = get_class($this) . '.' . $this->action->id;
            $reflector = new ReflectionClass(get_class($this));
            $thisFileName = $reflector->getFileName();
            $controllerReport = "Action: " . $thisAction . "\r\nFile: " . $thisFileName;
            $viewReport = "View file: " . $this->getViewFile($view);
            $varsReport = "View parameters:\r\n" . $this->vars->report;
            $headReport = $this->markupReport($controllerReport . "\r\n" . $viewReport . "\r\n" . $varsReport);
            $footReport = $this->markupReport('End of action ' . $thisAction);
            if ($return) {
                return preg_replace(
                    '/(<!DOCTYPE\s.+?>)/is',
                    '\1' . "\r\n" . $headReport,
                    parent::render($view, $data, true)
                  ) . $footReport;
            } else {
                echo preg_replace(
                    '/(<!DOCTYPE\s.+?>)/is',
                    '\1' . "\r\n" . $headReport,
                    parent::render($view, $data, true)
                  ) . $footReport;
                return;
            }
        }
        if ($return) {
            return parent::render($view, $data, $return);
        } else {
            parent::render($view, $data, $return);
        }
    }

    /**
     * Renders a view.
     * The named view refers to a PHP script (resolved via {@link getViewFile})
     * that is included by this method. If $data is an associative array,
     * it will be extracted as PHP variables and made available to the script.
     * This method differs from {@link render()} in that it does not
     * apply a layout to the rendered result. It is thus mostly used
     * in rendering a partial view, or an AJAX response.
     * @param string  $view          name of the view to be rendered. See {@link getViewFile} for details
     *                               about how the view script is resolved.
     * @param array   $data          data to be extracted into PHP variables and made available to the view script
     * @param boolean $return        whether the rendering result should be returned instead of being displayed to end
     *                               users
     * @param boolean $processOutput whether the rendering result should be postprocessed using {@link processOutput}.
     * @return string the rendering result. Null if the rendering result is not required.
     * @throws CException if the view does not exist
     * @see getViewFile
     * @see processOutput
     * @see render
     */
    public function renderPartial($view, $data = null, $return = false, $processOutput = false, $forceNoDebug = false)
    {
        /*    if(($viewFile=$this->getViewFile($view))!==false)
            {
              $output=$this->renderFile($viewFile,$data,true);
              if($processOutput)
                $output=$this->processOutput($output);
              if($return)
                return $output;
              else
                echo $output;
            }
            else
              throw new CException(Yii::t('yii','{controller} cannot find the requested view "{view}".',
                array('{controller}'=>get_class($this), '{view}'=>$view)));
        */
        if (!$forceNoDebug) {
            if (!$this->checkPhpSyntax($view)) {
                return;
            }
        }
        $footReport = '';
        $headReport = '';
        try {
            if (YII_DEBUG && !$forceNoDebug) {
                $this->renderVars($view, $data);
                $thisAction = get_class($this) . '.' . $this->action->id;
                $reflector = new ReflectionClass(get_class($this));
                $thisFileName = $reflector->getFileName();
                $controllerReport = "Action: " . $thisAction . "\r\nFile: " . $thisFileName;
                $viewReport = "View file: " . $this->getViewFile($view);
                $varsReport = "View parameters:\r\n" . $this->vars->report;
                $headReport = $this->markupReport($controllerReport . "\r\n" . $viewReport . "\r\n" . $varsReport);
                $footReport = $this->markupReport('End of action ' . $thisAction);
                if ($return) {
                    return $headReport . parent::renderPartial($view, $data, true, $processOutput) . $footReport;
                } else {
                    echo $headReport . parent::renderPartial($view, $data, true, $processOutput) . $footReport;
                    return;
                }
            }
            if ($return) {
                return parent::renderPartial($view, $data, $return, $processOutput);
            } else {
                parent::renderPartial($view, $data, $return, $processOutput);
            }
        } catch (Exception $e) {
            if (isset($e->xdebug_message)) {
                $xdebug_message = $e->xdebug_message;
                unset($e->xdebug_message);
            } else {
                $xdebug_message = null;
            }
            echo '<pre>Error from CustomController rendering in ' . ($this->getViewFile($view) ? $this->getViewFile(
                $view
              ) : $view . ' - not found!') . '</pre><br>';
            CVarDumper::dump($e, (YII_DEBUG ? 10 : 1), true);
            if (YII_DEBUG && $xdebug_message) {
                echo '<br><table>' . $xdebug_message . '</table>';
            }
        }
    }

    /**
     * Runs the action after passing through all filters.
     * This method is invoked by {@link runActionWithFilters} after all possible filters have been executed
     * and the action starts to run.
     * @param CAction $action action to run
     */
    public function runAction($action)
    {
        parent::runAction($action);
        $this->dbLog();
    }

}