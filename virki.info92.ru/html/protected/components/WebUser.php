<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="WebUser.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class WebUser extends CWebUser
{
    const ACC_PREFIX = '0000-0000';
    private $_access = [];
    private $_model = null;
    public $autoRenewCookie = true;
    public $guestName = 'guest';

    private function getModel()
    {
        if (!$this->isGuest && $this->_model === null) {
            $this->_model = Users::model()->findByPk($this->id);//, array('select' => 'uid, role, password, status')
        }
        return $this->_model;
    }

    /**
     * Renews the identity cookie.
     * This method will set the expiration time of the identity cookie to be the current time
     * plus the originally specified cookie duration.
     * @since 1.1.3
     */
    protected function renewCookie()
    {
        $request = Yii::app()->getRequest();
        $cookies = $request->getCookies();
        $cookie = $cookies->itemAt($this->getStateKeyPrefix());
        if ($cookie && !empty($cookie->value) && ($data = Yii::app()->getSecurityManager()->validateData(
            $cookie->value
          )) !== false) {
            $data = @unserialize($data);
            if (is_array($data) && isset($data[0], $data[1], $data[2], $data[3])) {
                //$lastLoginTime = $data[3]['lastlogin'];
                //$diffLoginTime = (time() - $data[3]['lastlogin']);
                if (isset($data[3]['lastlogin']) && ((time() - $data[3]['lastlogin']) > 3600)) {
                    $this->saveToCookie($data[2]);
                }
            }
        }
    }

    /**
     * Saves necessary user data into a cookie.
     * This method is used when automatic login ({@link allowAutoLogin}) is enabled.
     * This method saves user ID, username, other identity states and a validation key to cookie.
     * These information are used to do authentication next time when user visits the application.
     * @param integer $duration number of seconds that the user can remain in logged-in status. Defaults to 0, meaning
     *                          login till the user closes the browser.
     * @see restoreFromCookie
     */
    protected function saveToCookie($duration)
    {
        $app = Yii::app();
        $cookie = $this->createIdentityCookie($this->getStateKeyPrefix());
        $cookie->expire = time() + $duration;
        $data = [
          $this->getId(),
          $this->getName(),
          $duration,
          $this->saveIdentityStates(),
        ];
        if (isset($data[3])) { //&& isset($data[3]['lastlogin']
            $data[3]['lastlogin'] = time();
        }
        $cookie->value = $app->getSecurityManager()->hashData(serialize($data));
        if ($app->request->cookies->contains($cookie->name)) {
            $app->request->cookies->remove($cookie->name, ['domain' => $cookie->domain]);
        }
        $app->request->cookies->add($cookie->name, $cookie);
    }

    /**
     * PHP magic method.
     * This method is overriden so that persistent states can be accessed like properties.
     * @param string $name property name
     * @return mixed property value
     */
    public function __get($name)
    {
        if ($name == 'role') {
            return $this->getRole();
        } elseif (in_array($name, ['fullname', 'email', 'phone'])) {
            if (!isset($this->_model)) {
                $this->_model = Users::model()->findByPk($this->id);
            }
            if (isset($this->_model->{$name})) {
                return $this->_model->{$name};
            } else {
                return false;//parent::__get($name);
            }
        } else {
            return parent::__get($name);
        }
    }

    /**
     * Performs access check for this user.
     * @param string  $operation    the name of the operation that need access check.
     * @param array   $params       name-value pairs that would be passed to business rules associated
     *                              with the tasks and roles assigned to the user.
     *                              Since version 1.1.11 a param with name 'userId' is added to this array, which holds
     *                              the value of
     *                              {@link getId()} when {@link CDbAuthManager} or {@link CPhpAuthManager} is used.
     * @param boolean $allowCaching whether to allow caching the result of access check.
     *                              When this parameter
     *                              is true (default), if the access check of an operation was performed before,
     *                              its result will be directly returned when calling this method to check the same
     *                              operation. If this parameter is false, this method will always call
     *                              {@link CAuthManager::checkAccess} to obtain the up-to-date access result. Note that
     *                              this caching is effective only within the same request and only works when
     *                              <code>$params=array()</code>.
     * @return boolean whether the operations can be performed by this user.
     */
    public function checkAccess($operation, $params = [], $allowCaching = true)
    {
        if ($allowCaching && $params === [] && isset($this->_access[$operation])) {
            return $this->_access[$operation];
        }

        $access = Yii::app()->getAuthManager()->checkAccess($operation, $this->getId(), $params);
        if ($allowCaching && $params === []) {
            $this->_access[$operation] = $access;
        }

        return $access;
    }

    public function getIdByPersonalAccount($acc)
    {
        $result = preg_replace('/-/is', '', $acc);
        $result = ltrim($result, '0');
        if (is_numeric($result)) {
            return (int) $result;
        } else {
            return null;
        }
    }

    public function getPersonalAccount()
    {
        if (!isset($this->id)) {
            return null;
        }
        $result = str_pad((string) $this->id, 8, '0', STR_PAD_LEFT);
        $result = preg_replace('/(\d{4})(\d{4})/is', '\1-\2', $result);
        return $result;
    }

    public function getRole()
    {
        $user = $this->getModel();
        if ($user) {
            $dstoken = $this->getState('dstoken');
            if ((sha1(DSConfig::getVal('site_domain') . $user->uid . $user->password) != $dstoken)
              && (!in_array($user->role, ['guest', 'user'])) || ($user->status != 1)
            ) {
                Yii::app()->user->logout();
                if (Yii::app()->controller) {
                    Yii::app()->controller->redirect('/');
                }
            }
            return $user->role;
        } else {
            return 'guest';
        }
    }

    public function inRole($roles, $recursive = true)
    {
        $userRole = $this->getRole();
        //TODO Было закомменчено, может и правильно
        if ($userRole == 'superAdmin' && $recursive) {
            return true;
        }
        if (is_array($roles)) {
            if (in_array($userRole, $roles)) {
                return true;
            }
        } else {
            if ($userRole === $roles) {
                return true;
            }
        }
        if ($recursive && (!in_array($userRole, ['guest', 'user']))) {
            $ACL = Yii::app()->authManager->GetACLforUser(Yii::app()->user->id, true);
            if (is_array($roles)) {
                foreach ($roles as $role) {
                    if (in_array($role, ['guest', 'user'])) {
                        continue;
                    }
                    if (in_array('$' . strtolower($role) . '$', $ACL->allow) || in_array('*', $ACL->allow)) {
                        return true;
                    }
                }
            } else {
                if (!in_array($roles, ['guest', 'user'])) {
                    if (in_array('$' . strtolower($roles) . '$', $ACL->allow) || in_array('*', $ACL->allow)) {
                        return true;
                    }
                }
            }
        }
        return false;
    }

    public function init()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $this->autoRenewCookie = false;
        } elseif (preg_replace(
            '/^http[s]*:\/\//i',
            '',
            Yii::app()->getBaseUrl(true)
          ) !== DSConfig::getVal('site_domain')
        ) {
            $this->autoRenewCookie = false;
        }
        parent::init();
    }

    public function isCrawler()
    {
        if (!$this->isGuest) {
            return false;
        }
        $crawlers = [
          'msnbot',
          'Rambler',
          'Yahoo',
          'AbachoBOT',
          'Accoona',
          'AcoiRobot',
          'ASPSeek',
          'CrocCrawler',
          'Dumbot',
          'FAST-WebCrawler',
          'GeonaBot',
          'Gigabot',
          'Lycos',
          'MSRBOT',
          'Scooter',
          'Altavista',
          'IDBot',
          'eStyle',
          'Scrubby',
          'VSAgent',
        ];

        $userAgent = Yii::app()->request->userAgent;
        $remoteIp = CHttpRequest::getUserHostAddress();
        if (preg_match('/\+http/i', $userAgent)) {
            return true;
        }
        if (preg_match(
          '/Yandex(?:Bot|Images|Video|Media|Blogs|Addurl|Favicons|Direct||Metrika|Catalog|News|ImageResizer)/i',
          $userAgent
        )) {
            return true;
        }
        if (preg_match('/googlebot/i', $userAgent)) {
            return true;
        }
        if (preg_match('/MJ12bot|majestic12/i', $userAgent)) {
            return true;
        }
        if (preg_match('/crawl|slurp|spider|robot|VSAgent/i', $userAgent)) {
            return true;
        }
        if (preg_match('/' . implode('|', $crawlers) . '/i', $userAgent)) {
            return true;
        }
        $remoteHost = gethostbyaddr($remoteIp);
        if (preg_match('/google|yandex|baidu|yahoo|mail\.ru|rambler|bing\./i', $remoteHost)) {
            return true;
        }
        return false;
    }

    public function isOwner($objectUid)
    {
        return ($this->id === (int) $objectUid);
    }

    public function notInRole($roles, $recursive = true)
    {
        try {
            $userRole = $this->getRole();
            if (is_array($roles)) {
                if (array_search($userRole, $roles) !== false) {
                    $notInRole = false;
                } else {
                    if (($userRole == 'superAdmin' && $recursive)
                      && !isset($roles['superAdmin'])
                    ) {
                        $notInRole = true;
                    } else {
                        $notInRole = !$this->inRole($roles, $recursive);
                    }
                }
            } elseif (is_string($roles)) {
                if ($userRole == $roles) {
                    $notInRole = false;
                } else {
                    if (($userRole == 'superAdmin' && $recursive)
                      && $roles == 'superAdmin'
                    ) {
                        $notInRole = true;
                    } else {
                        $notInRole = !$this->inRole($roles, $recursive);
                    }
                }
            } else {
                return true;
            }
            return $notInRole;
        } catch (Exception $e) {
            return false;
        }
    }

}