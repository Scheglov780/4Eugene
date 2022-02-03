<?php
/**
 * CDbCache class file
 * @author    Qiang Xue <qiang.xue@gmail.com>
 * @link      http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license   http://www.yiiframework.com/license/
 */

/**
 * CDbCache implements a cache application component by storing cached data in a database.
 * CDbCache stores cache data in a DB table named {@link cacheTableName}.
 * If the table does not exist, it will be automatically created.
 * By setting {@link autoCreateCacheTable} to false, you can also manually create the DB table.
 * CDbCache relies on {@link http://www.php.net/manual/en/ref.pdo.php PDO} to access database.
 * By default, it will use a SQLite3 database under the application runtime directory.
 * You can also specify {@link connectionID} so that it makes use of
 * a DB application component to access database.
 * See {@link CCache} manual for common cache operations that are supported by CDbCache.
 * @property integer       $gCProbability The probability (parts per million) that garbage collection (GC) should be
 *           performed when storing a piece of data in the cache. Defaults to 100, meaning 0.01% chance.
 * @property CDbConnection $dbConnection  The DB connection instance.
 * @author  Qiang Xue <qiang.xue@gmail.com>
 * @package system.caching
 * @since   1.0
 */
class DSGDbCache extends CDbCache
{
    private $_gcProbability = 100;
    private $_gced = false;

    public $cacheTableName = 'cache';

    /**
     * Stores a value identified by a key into cache if the cache does not contain this key.
     * This is the implementation of the method declared in the parent class.
     * @param string  $key    the key identifying the value to be cached
     * @param string  $value  the value to be cached
     * @param integer $expire the number of seconds in which the cached value will expire. 0 means never expire.
     * @return boolean true if the value is successfully stored into cache, false otherwise
     */
    protected function addValue($key, $value, $expire)
    {
        if (!$this->_gced && mt_rand(0, 1000000) < $this->_gcProbability) {
            $this->gc();
            $this->_gced = true;
        }

        if ($expire > 0) {
            $expire += time();
        } else {
            $expire = 0;
        }
        $sql = "INSERT INTO {$this->cacheTableName} (id,expire,value) VALUES ('$key',$expire,:value) 
              ON CONFLICT ON CONSTRAINT cache_pkey DO NOTHING ";
        try {
            $command = $this->getDbConnection()->createCommand($sql);
            $command->bindValue(':value', $value, PDO::PARAM_LOB);
            $command->execute();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Removes the expired data values.
     */
    public function gc()
    {
        parent::gc();
    }

}
