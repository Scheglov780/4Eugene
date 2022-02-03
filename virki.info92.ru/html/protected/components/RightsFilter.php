<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="RightsFilter.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class RightsFilter extends CFilter
{
    protected $_allowedActions = [];

    /**
     * Performs the pre-action filtering.
     * @param CFilterChain $filterChain the filter chain that the filter is on.
     * @return boolean whether the filtering process should continue and the action
     *                                  should be executed.
     */
    protected function preFilter($filterChain)
    {
        // By default we assume that the user is allowed access
        if (isset($_SERVER['SCRIPT_URL'])) {
            $_url = $_SERVER['SCRIPT_URL'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            $_url = $_SERVER['REQUEST_URI'];
        } else {
            $_url = '';
        }
        if (preg_match('/\/admin\/main\/backup/', $_url)) {
            return true;
        }
        $allow = true;
        $user = Yii::app()->getUser();
        $controller = $filterChain->controller;
        $action = $filterChain->action;

        // Check if the action should be allowed
        if ($this->_allowedActions !== '*' && in_array($action->id, $this->_allowedActions) === false) {
            // Initialize the authorization item as an empty string
            $authItem = '';

            // Append the module id to the authorization item name
            // in case the controller called belongs to a module
            if (($module = $controller->getModule()) !== null) {
                $authItem .= ucfirst($module->id) . '/';
            }
            // Append the controller id to the authorization item name
            $authItem .= ucfirst($controller->id);
            // Append the action id to the authorization item name
            $authItem .= '/' . ucfirst($action->id);
            // Check if the user has access to the controller action
            if ($user->checkAccess($authItem) !== true) {
                $allow = false;
            }
        }
        // User is not allowed access, deny access
        if ($allow === false) {
            $controller->accessDenied();
            return false;
        }

        // Authorization item did not exist or the user had access, allow access
        return parent::preFilter($filterChain);
    }

    /**
     * Sets the allowed actions.
     * @param string $allowedActions the actions that are always allowed separated by commas,
     *                               you may also use star (*) to represent all actions.
     */
    public function setAllowedActions($allowedActions)
    {
        if ($allowedActions === '*') {
            $this->_allowedActions = $allowedActions;
        } else {
            $this->_allowedActions = preg_split('/[\s,]+/', $allowedActions, -1, PREG_SPLIT_NO_EMPTY);
        }
    }
}
