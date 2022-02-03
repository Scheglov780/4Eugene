<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DVAuthManager.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DVAuthManager extends CAuthManager
{
    public static $aceessRoles = ['normal' => false, 'preserved' => false];

    private function GetACLForRole($userRole, $preserveRoles = false)
    {
        $result = false;
        if (self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')] == false) {
            $allRoles = AccessRights::model()->findAll();
            if (($allRoles != false) && ($allRoles != null)) {
                self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')] = [];
                foreach ($allRoles as $role) {
                    self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$role['role']] = new stdClass();
                    self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$role['role']]->allow =
                      self::removeRightsComments($role['allow']);
                    self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$role['role']]->deny =
                      self::removeRightsComments($role['deny']);
                }
            }
        }
        if (isset(self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$userRole])) {
            $rawACL = self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$userRole];
            $this->GetACLRecursive($rawACL, $preserveRoles);
            $result = $rawACL;
        }
        return $result;
    }

    private function GetACLRecursive($rawACL, $preserveRoles = false)
    {
        for ($i = 1; $i <= 10; $i++) {
            $haveChildRolesAllow = preg_match_all('/%(.+)%/im', $rawACL->allow, $childRolesAllow);
            if ($haveChildRolesAllow > 0) {
                foreach ($childRolesAllow[1] as $childRole) {
                    if (isset(self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$childRole])) {
                        if ($preserveRoles) {
                            $rawACL->allow = str_replace(
                              '%' . $childRole . '%',
                              '$' . $childRole . '$',
                              $rawACL->allow
                            );
                            //@todo: Тут потом проверять регекспом на пустые строки
                            $rawACL->allow =
                              $rawACL->allow .
                              "\r\n" .
                              self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$childRole]->allow;
                        } else {
                            $rawACL->allow = str_replace(
                              '%' . $childRole . '%',
                              self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$childRole]->allow,
                              $rawACL->allow
                            );
                        }
                    } else {
                        if ($preserveRoles) {
                            $rawACL->allow = str_replace($childRole, '', $rawACL->allow);
                        } else {
                            $rawACL->allow = str_replace($childRole, '', $rawACL->allow);
                        }
                    }
                }
            }
            $haveChildRolesDeny = preg_match_all('/%(.+)%/im', $rawACL->deny, $childRolesDeny);
            if ($haveChildRolesDeny > 0) {
                foreach ($childRolesDeny[1] as $childRole) {
                    if (isset(self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$childRole])) {
                        $rawACL->deny = str_replace(
                          '%' . $childRole . '%',
                          self::$aceessRoles[($preserveRoles ? 'preserved' : 'normal')][$childRole]->deny,
                          $rawACL->deny
                        );
                    } else {
                        $rawACL->deny = str_replace($childRole, '', $rawACL->deny);
                    }
                }
            }
            if ((($haveChildRolesAllow <= 0) && ($haveChildRolesDeny <= 0)) || ($i > 10)) {
                break;
            }
        }
    }

    private function inRights($itemName, $rightsArray)
    {
        if (!is_array($rightsArray) || !count($rightsArray)) {
            return false;
        }
        $search = strtolower($itemName);
        if (in_array($search, $rightsArray)) {
            return true;
        }
        foreach ($rightsArray as $right) {
            $qright = str_replace('/*', '*', $right);
            $qright = str_replace('/', '\/', $qright);
            $qright = str_replace('.', '\.', $qright);
            $qright = str_replace('*', '.*', $qright);
            $qright = trim($qright);
            if (preg_match('/^' . $qright . '$/m', $search)) {
                return true;
            }
        }
        return false;
    }

    public function GetACLforUser($userId, $preserveRoles = false)
    {
        $acl = false;
        if (($userId === false) || (is_null($userId))) {
            $userRole = Yii::app()->user->getRole();
        } else {
            $user = Users::model()->findByPk($userId);
            if (($user != false) && ($user != null)) {
                $userRole = $user['role'];
            } else {
                $userRole = false;
            }
        }
        if ($userRole == false) {
            $userRole = 'guest';
        }
        if ($userRole) {
            $acl = new stdClass();
            $acl->allow = [];
            $acl->deny = [];
            $rawACL = $this->GetACLForRole($userRole, $preserveRoles);
            if ($rawACL) {
                $rawACL->allow = strtolower($rawACL->allow);
                $rawACL->deny = strtolower($rawACL->deny);
                $acl->allow = array_unique(preg_split('/\s/', $rawACL->allow, null, PREG_SPLIT_NO_EMPTY));
                $acl->deny = array_unique(preg_split('/\s/', $rawACL->deny, null, PREG_SPLIT_NO_EMPTY));
            }
        }
        return $acl;
    }

    /**
     * Adds an item as a child of another item.
     * @param string $itemName  the parent item name
     * @param string $childName the child item name
     * @return boolean whether the item is added successfully
     * @throws CException if either parent or child doesn't exist or if a loop has been detected.
     */
    public function addItemChild($itemName, $childName)
    {
        return true;
    }

    /**
     * Assigns an authorization item to a user.
     * @param string $itemName the item name
     * @param mixed  $userId   the user ID (see {@link IWebUser::getId})
     * @param string $bizRule  the business rule to be executed when {@link checkAccess} is called
     *                         for this particular authorization item.
     * @param mixed  $data     additional data associated with this assignment
     * @return CAuthAssignment the authorization assignment information.
     * @throws CException if the item does not exist or if the item has already been assigned to the user
     */
    public function assign($itemName, $userId, $bizRule = null, $data = null)
    {
        if (!isset($this->_items[$itemName])) {
            throw new CException(Yii::t('yii', 'Unknown authorization item "{name}".', ['{name}' => $itemName]));
        } elseif (isset($this->_assignments[$userId][$itemName])) {
            throw new CException(
              Yii::t(
                'yii',
                'Authorization item "{item}" has already been assigned to user "{user}".',
                ['{item}' => $itemName, '{user}' => $userId]
              )
            );
        } else {
            return $this->_assignments[$userId][$itemName] = new CAuthAssignment(
              $this,
              $itemName,
              $userId,
              $bizRule,
              $data
            );
        }
    }

    /**
     * Performs access check for the specified user.
     * @param string $itemName the name of the operation that need access check
     * @param mixed  $userId   the user ID. This can be either an integer or a string representing
     *                         the unique identifier of a user. See {@link IWebUser::getId}.
     * @param array  $params   name-value pairs that would be passed to biz rules associated
     *                         with the tasks and roles assigned to the user.
     *                         Since version 1.1.11 a param with name 'userId' is added to this array, which holds the
     *                         value of <code>$userId</code>.
     * @return boolean whether the operations can be performed by the user.
     */
    public function checkAccess($itemName, $userId, $params = [])
    {
        Yii::trace('Checking permission "' . $itemName . '"', 'DVAuthManager');
        if (!isset($params['userId'])) {
            $params['userId'] = $userId;
        }

        $acl = $this->GetACLforUser($userId);
        if ($this->inRights($itemName, $acl->deny)) {
            return false;
        }
        if ($this->inRights($itemName, $acl->allow)) {
            return true;
        }
        return false;
    }

    /**
     * Removes all authorization data.
     */
    public function clearAll()
    {
        $this->clearAuthAssignments();
        $this->_children = [];
        $this->_items = [];
    }

    /**
     * Removes all authorization assignments.
     */
    public function clearAuthAssignments()
    {
        $this->_assignments = [];
    }

    /**
     * Creates an authorization item.
     * An authorization item represents an action permission (e.g. creating a post).
     * It has three types: operation, task and role.
     * Authorization items form a hierarchy. Higher level items inheirt permissions representing
     * by lower level items.
     * @param string  $name        the item name. This must be a unique identifier.
     * @param integer $type        the item type (0: operation, 1: task, 2: role).
     * @param string  $description description of the item
     * @param string  $bizRule     business rule associated with the item. This is a piece of
     *                             PHP code that will be executed when {@link checkAccess} is called for the item.
     * @param mixed   $data        additional data associated with the item.
     * @return CAuthItem the authorization item
     * @throws CException if an item with the same name already exists
     */
    public function createAuthItem($name, $type, $description = '', $bizRule = null, $data = null)
    {
        if (isset($this->_items[$name])) {
            throw new CException(Yii::t('yii', 'Unable to add an item whose name is the same as an existing item.'));
        }
        return $this->_items[$name] = new CAuthItem($this, $name, $type, $description, $bizRule, $data);
    }

    /**
     * Returns the item assignment information.
     * @param string $itemName the item name
     * @param mixed  $userId   the user ID (see {@link IWebUser::getId})
     * @return CAuthAssignment the item assignment information. Null is returned if
     *                         the item is not assigned to the user.
     */
    public function getAuthAssignment($itemName, $userId)
    {
        return isset($this->_assignments[$userId][$itemName]) ? $this->_assignments[$userId][$itemName] : null;
    }

    /**
     * Returns the item assignments for the specified user.
     * @param mixed $userId the user ID (see {@link IWebUser::getId})
     * @return array the item assignment information for the user. An empty array will be
     *                      returned if there is no item assigned to the user.
     */
    public function getAuthAssignments($userId)
    {
        return isset($this->_assignments[$userId]) ? $this->_assignments[$userId] : [];
    }

    /**
     * Returns the authorization item with the specified name.
     * @param string $name the name of the item
     * @return CAuthItem the authorization item. Null if the item cannot be found.
     */
    public function getAuthItem($name)
    {
        return isset($this->_items[$name]) ? $this->_items[$name] : null;
    }

    /**
     * Returns the authorization items of the specific type and user.
     * @param integer $type   the item type (0: operation, 1: task, 2: role). Defaults to null,
     *                        meaning returning all items regardless of their type.
     * @param mixed   $userId the user ID. Defaults to null, meaning returning all items even if
     *                        they are not assigned to a user.
     * @return array the authorization items of the specific type.
     */
    public function getAuthItems($type = null, $userId = null)
    {
        $items = [];
        return $items;
    }

    /**
     * Returns the children of the specified item.
     * @param mixed $names the parent item name. This can be either a string or an array.
     *                     The latter represents a list of item names.
     * @return array all child items of the parent
     */
    public function getItemChildren($names)
    {
        if (is_string($names)) {
            return isset($this->_children[$names]) ? $this->_children[$names] : [];
        }

        $children = [];
        foreach ($names as $name) {
            if (isset($this->_children[$name])) {
                $children = array_merge($children, $this->_children[$name]);
            }
        }
        return $children;
    }

    /**
     * Returns a value indicating whether a child exists within a parent.
     * @param string $itemName  the parent item name
     * @param string $childName the child item name
     * @return boolean whether the child exists
     */
    public function hasItemChild($itemName, $childName)
    {
        return true;
    }

    public function init()
    {
        parent::init();
        // Для гостей у нас и так роль по умолчанию guest.
        /*    if(!Yii::app()->user->isGuest){
              // Связываем роль, заданную в БД с идентификатором пользователя,
              // возвращаемым UserIdentity.getId().
              if (!$this->isAssigned(Yii::app()->user->role, Yii::app()->user->id)) {
              $this->assign(Yii::app()->user->role, Yii::app()->user->id);
              }
            }
        */
    }

    /**
     * Returns a value indicating whether the item has been assigned to the user.
     * @param string $itemName the item name
     * @param mixed  $userId   the user ID (see {@link IWebUser::getId})
     * @return boolean whether the item has been assigned to the user.
     */
    public function isAssigned($itemName, $userId)
    {
        return isset($this->_assignments[$userId][$itemName]);
    }

    /**
     * Removes the specified authorization item.
     * @param string $name the name of the item to be removed
     * @return boolean whether the item exists in the storage and has been removed
     */
    public function removeAuthItem($name)
    {
        if (isset($this->_items[$name])) {
            foreach ($this->_children as &$children) {
                unset($children[$name]);
            }
            foreach ($this->_assignments as &$assignments) {
                unset($assignments[$name]);
            }
            unset($this->_items[$name]);
            return true;
        } else {
            return false;
        }
    }
//======================================================================================================================

    /**
     * Removes a child from its parent.
     * Note, the child item is not deleted. Only the parent-child relationship is removed.
     * @param string $itemName  the parent item name
     * @param string $childName the child item name
     * @return boolean whether the removal is successful
     */
    public function removeItemChild($itemName, $childName)
    {
        return true;
    }

    /**
     * Revokes an authorization assignment from a user.
     * @param string $itemName the item name
     * @param mixed  $userId   the user ID (see {@link IWebUser::getId})
     * @return boolean whether removal is successful
     */
    public function revoke($itemName, $userId)
    {
        return true;
    }

    /**
     * Saves authorization data into persistent storage.
     * If any change is made to the authorization data, please make
     * sure you call this method to save the changed data into persistent storage.
     */
    public function save()
    {
    }

    /**
     * Saves the changes to an authorization assignment.
     * @param CAuthAssignment $assignment the assignment that has been changed.
     */
    public function saveAuthAssignment($assignment)
    {
    }

    /**
     * Saves an authorization item to persistent storage.
     * @param CAuthItem $item    the item to be saved.
     * @param string    $oldName the old item name. If null, it means the item name is not changed.
     */
    public function saveAuthItem($item, $oldName = null)
    {
    }

    private static function removeRightsComments($value)
    {
        $result = preg_replace('/\#.*?(?=$)/im', '', $value);
        $result = preg_replace('/(?:\s+(?=$)|(?<=^)\s+)/im', '', $result);
        return $result;
    }
//======================================================================================================================
}
