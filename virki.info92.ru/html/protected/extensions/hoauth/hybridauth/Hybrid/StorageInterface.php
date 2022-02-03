<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * HybridAuth storage manager interface
 */
interface Hybrid_Storage_Interface
{

    function clear();

    public function config($key, $value = null);

    function delete($key);

    function deleteMatch($key);

    public function get($key);

    function getSessionData();

    function restoreSessionData($sessiondata = null);

    public function set($key, $value);
}
