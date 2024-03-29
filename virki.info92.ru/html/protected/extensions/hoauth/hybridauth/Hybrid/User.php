<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * The Hybrid_User class represents the current logged in user
 */
class Hybrid_User
{

    /**
     * Initialize the user object
     */
    function __construct()
    {
        $this->timestamp = time();
        $this->profile = new Hybrid_User_Profile();
    }

    /**
     * User profile, contains the list of fields available in the normalized user profile structure used by HybridAuth
     * @var Hybrid_User_Profile
     */
    public $profile = null;
    /**
     * The ID (name) of the connected provider
     * @var mixed
     */
    public $providerId = null;
    /**
     * Timestamp connection to the provider
     * @var int
     */
    public $timestamp = null;

}
