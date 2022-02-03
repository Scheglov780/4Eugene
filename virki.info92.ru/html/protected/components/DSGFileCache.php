<?php
/**
 * CFileCache class file
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

/**
 * CFileCache provides a file-based caching mechanism.
 * For each data value being cached, CFileCache will use store it in a separate file
 * under {@link cachePath} which defaults to 'protected/runtime/cache'.
 * CFileCache will perform garbage collection automatically to remove expired cache files.
 * See {@link CCache} manual for common cache operations that are supported by CFileCache.
 * @property integer $gCProbability The probability (parts per million) that garbage collection (GC) should be performed
 * when storing a piece of data in the cache. Defaults to 100, meaning 0.01% chance.
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.caching
 */
class DSGFileCache extends CFileCache
{
    private $_gcProbability = 100;
    private $_gced = false;
    public $gzip = true;

    /**
     * Retrieves a value from cache with a specified key.
     * This is the implementation of the method declared in the parent class.
     * @param string $key a unique key identifying the cached value
     * @return string|boolean the value stored in cache, false if the value is not in the cache or expired.
     */
    protected function getValue($key)
    {
        $gzresult = parent::getValue($key);
        if ($gzresult) {
            if ($this->isImage($gzresult)) {
                return $gzresult;
            }
            $result = @gzuncompress($gzresult);
            if ($result) {
                return $result;
            } else {
                return $gzresult;
            }
        } else {
            return false;
        }
    }

    protected function isImage($data)
    {
        $isImage = preg_match('/a:2:\{i:0;s:\d+:"(?:(?:\xFF[\x08\xD8])|(?:\x89PNG))/', $data);
        return ($isImage == 0 ? false : true);
    }

    /**
     * Stores a value identified by a key in cache.
     * This is the implementation of the method declared in the parent class.
     * @param string  $key    the key identifying the value to be cached
     * @param string  $value  the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function setValue($key, $value, $expire)
    {
        $df = disk_free_space("/");
        if ($df && $df < 300 * 1024 * 1024) {
            $this->gc(false);
            //return false;
        }
        if (!$this->gzip || $this->isImage($value)) {
            return parent::setValue($key, $value, $expire);
        } else {
            $_value = @gzcompress($value, 7);
            if ($_value) {
                return parent::setValue($key, $_value, $expire);
            } else {
                return false;
            }
        }
    }
}
