<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Hybrid_User_Contact
 * used to provider the connected user contacts list on a standardized structure across supported social apis.
 * http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Contacts.html
 */
class Hybrid_User_Contact
{

    /**
     * A short about_me
     * @var string
     */
    public $description = null;
    /**
     * User displayName provided by the IDp or a concatenation of first and last name
     * @var string
     */
    public $displayName = null;
    /**
     * User email. Not all of IDp grant access to the user email
     * @var string
     */
    public $email = null;
    /**
     * The Unique contact user ID
     * @var mixed
     */
    public $identifier = null;
    /**
     * URL link to user photo or avatar
     * @var string
     */
    public $photoURL = null;
    /**
     * URL link to profile page on the IDp web site
     * @var string
     */
    public $profileURL = null;
    /**
     * User website, blog, web page
     * @var string
     */
    public $webSiteURL = null;

}
