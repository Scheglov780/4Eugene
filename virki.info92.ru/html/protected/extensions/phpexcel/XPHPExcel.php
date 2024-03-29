<?php

/**
 * Wrapper for the PHPExcel library.
 * @see README.md
 */
class XPHPExcel extends CComponent
{
    private static $_isInitialized = false;

    /**
     * Returns new PHPExcel object. Automatically registers autoloader.
     * @return PHPExcel
     */
    public static function createPHPExcel()
    {
        self::init();
        return new PHPExcel;
    }

    /**
     * Register autoloader.
     */
    public static function init()
    {
        if (!self::$_isInitialized) {
            spl_autoload_unregister(['YiiBase', 'autoload']);
            require(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'PHPExcel.php');
            spl_autoload_register(['YiiBase', 'autoload']);

            self::$_isInitialized = true;
        }
    }
}