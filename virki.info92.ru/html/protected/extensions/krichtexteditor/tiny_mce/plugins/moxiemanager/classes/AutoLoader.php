<?php
/**
 * AutoLoader.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

if (!defined('MOXMAN_CLASSES')) {
    /**
     * @ignore
     */
    define('MOXMAN_CLASSES', dirname(__FILE__));
}

// @codeCoverageIgnoreStart

/**
 * This class registers a class auto loader and loads classes.
 * @package MOXMAN
 */
class MOXMAN_AutoLoader
{
    /** @ignore */
    static private $prefixPaths = [];

    /**
     * Adds a specific path for a class prefix.
     * @param string $prefix Class prefix to load class by.
     * @param string $path   Path to where to look for files for a specific prefix.
     */
    static public function addPrefixPath($prefix, $path)
    {
        self::$prefixPaths[$prefix] = $path;
    }

    /**
     * Handles autoloading of classes.
     * @param string $class A class name.
     */
    static public function autoload($class)
    {
        if (strpos($class, 'MOXMAN_') !== 0) {
            return;
        }

        // Load prefix specifc class for example plugin classes
        $prefix = substr($class, 0, strpos($class, '_', strlen('MOXMAN_')));
        if (isset(self::$prefixPaths[$prefix])) {
            require self::$prefixPaths[$prefix] . '/' . strtr(substr($class, strlen($prefix)), '_', '/') . '.php';
            return;
        }

        // Load core API class
        require MOXMAN_CLASSES . '/' . strtr(substr($class, strlen('MOXMAN_')), '_', '/') . '.php';
    }

    /**
     * Registers PHPParser_Autoloader as an SPL autoloader.
     */
    static public function register()
    {
        ini_set('unserialize_callback_func', 'spl_autoload_call');
        spl_autoload_register([__CLASS__, 'autoload']);
    }
}

// @codeCoverageIgnoreEnd

?>