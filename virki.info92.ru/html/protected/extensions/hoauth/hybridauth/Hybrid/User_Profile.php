<?php

/**
 * HybridAuth
 * http://hybridauth.sourceforge.net | http://github.com/hybridauth/hybridauth
 * (c) 2009-2015, HybridAuth authors | http://hybridauth.sourceforge.net/licenses.html
 */

/**
 * Hybrid_User_Profile object represents the current logged in user profile.
 * The list of fields available in the normalized user profile structure used by HybridAuth.
 * The Hybrid_User_Profile object is populated with as much information about the user as
 * HybridAuth was able to pull from the given API or authentication provider.
 * http://hybridauth.sourceforge.net/userguide/Profile_Data_User_Profile.html
 */
class Hybrid_User_Profile
{

    /**
     * Complete user address
     * @var string
     */
    public $address = null;
    /**
     * User age, we don't calculate it. we return it as is if the IDp provide it.
     * @var int
     */
    public $age = null;
    /**
     * User birth Day
     * @var int
     */
    public $birthDay = null;
    /**
     * User birth Month
     * @var int
     */
    public $birthMonth = null;
    /**
     * User birth Year
     * @var int
     */
    public $birthYear = null;
    /**
     * City
     * @var string
     */
    public $city = null;
    /**
     * User country
     * @var string
     */
    public $country = null;
    /**
     * A short about_me
     * @var string
     */
    public $description = null;
    /**
     * User displayName provided by the IDp or a concatenation of first and last name.
     * @var string
     */
    public $displayName = null;
    /**
     * User email. Note: not all of IDp grant access to the user email
     * @var string
     */
    public $email = null;
    /**
     * Verified user email. Note: not all of IDp grant access to verified user email
     * @var string
     */
    public $emailVerified = null;
    /**
     * User's first name
     * @var string
     */
    public $firstName = null;
    /**
     * Male or female
     * @var string
     */
    public $gender = null;
    /**
     * The Unique user's ID on the connected provider
     * @var mixed
     */
    public $identifier = null;
    /**
     * Job title
     * @var string
     */
    public $job_title = null;
    /**
     * Language
     * @var string
     */
    public $language = null;
    /**
     * User's last name
     * @var string
     */
    public $lastName = null;
    /**
     * Organization name
     * @var string
     */
    public $organization_name = null;
    /**
     * Phone number
     * @var string
     */
    public $phone = null;
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
     * Region
     * @var string
     */
    public $region = null;
    /**
     * User website, blog, web page
     * @var string
     */
    public $webSiteURL = null;
    /**
     * Postal code
     * @var string
     */
    public $zip = null;
}
