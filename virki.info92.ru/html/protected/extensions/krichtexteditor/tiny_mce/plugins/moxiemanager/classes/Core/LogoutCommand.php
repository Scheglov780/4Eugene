<?php
/**
 * LogoutCommand.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * Command that logs out the user.
 * @package MOXMAN_Core
 */
class MOXMAN_Core_LogoutCommand extends MOXMAN_Core_BaseCommand
{
    /**
     * Executes the command logic with the specified RPC parameters.
     * @param Object $params Command parameters sent from client.
     * @return Object Result object to be passed back to client.
     */
    public function execute($params)
    {
        MOXMAN::getAuthManager()->logout();
        return true;
    }
}

?>