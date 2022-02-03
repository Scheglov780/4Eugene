<?php

class DSBackup
{
    private static $_db;
    private static $basePath;
    /**
     * @var string the path to the mysqldump binary.
     */
    private static $binPath = 'mysqldump';
    /**
     * @var string the component ID for the database connection to use.
     */
    private static $connectionID = 'db';
    /**
     * @var string the name of the dump-file.
     */
    private static $dumpFile = 'dump.sql';
    /**
     * @var string the path to the directory where the dump-file should be created.
     */
    private static $dumpPath = false;
    /**
     * @var array the options for mysqldump.
     * @see http://dev.mysql.com/doc/refman/5.1/en/mysqldump.html
     */
    private static $options = [];

    /**
     * Returns the database connection component.
     * @return CDbConnection the component.
     * @throws CException if the component is not found.
     */
    private static function getDb()
    {
        if (isset(self::$_db)) {
            return self::$_db;
        } else {
            if (($db = Yii::app()->getComponent(self::$connectionID)) === null) {
                throw new CException(
                  sprintf(
                    'Failed to get database connection. Component %s not found.',
                    self::$connectionID
                  )
                );
            }
            return self::$_db = $db;
        }
    }

    /**
     * Reversing $this->connectionString = $this->driverName.':host='.$this->hostName.';dbname='.$this->dbName;
     * Ugly but will have to do in short of better options
     * (http://www.yiiframework.com/forum/index.php/topic/7984-where-to-get-the-name-of-the-database/)
     * @param $connectionString
     */
    private static function parseConnectionString($connectionString)
    {
        $parsed = [];
        $_ = explode(":", $connectionString, 2);
        $parsed["driverName"] = $_[0];
        $__ = explode(";", $_[1]);
        foreach ($__ as $v) {
            $___ = explode("=", $v);
            $parsed[$___[0]] = $___[1];
        }
        // For staying true to the original variable names
        $parsed["hostName"] = (isset($parsed["host"]) ? $parsed["host"] : 'localhost');
        $parsed["dbName"] = $parsed["dbname"];
        return $parsed;
    }

    /**
     * Returns the name of the database.
     * @return string the name.
     */
    private static function resolveDatabaseName()
    {
        $db = self::getDb();
        $res = $db->createCommand('SELECT current_catalog;')->queryScalar();
        return $res;
    }

    /**
     * Returns the path to the dump-file.
     * @return string the path.
     */
    private static function resolveDumpPath()
    {
        if (self::$dumpPath) {
            $path = self::$basePath . '/' . self::$dumpPath;
            $res = $path . '/' . self::$dumpFile;
        } else {
            $path = sys_get_temp_dir();
            $res = $path . '/' . self::$dumpFile;
        }
        return $res;
    }

    public static function getBackup()
    {
        //TODO: Сделать бэкап новых данных и таблиц (local_*, parcels_* и т.п.)
        @ini_set('max_execution_time', 3000);
        set_time_limit(3000);
        $tables = [
          'access_rights',
          'users',
          'cms_custom_content',
          'cms_email_events',
          'cms_menus',
          'cms_pages',
          'cms_pages_content',
          'cms_metatags',
          'config',
          'currency_log',
          'events',
          'formulas',
          'scheduled_jobs',
          'translator_keys',
        ];
        self::$basePath = Yii::getPathOfAlias('webroot');
        self::$basePath = rtrim(self::$basePath, '/');

        $db = self::getDb();
        self::$options['user'] = $db->username;
        self::$options['password'] = $db->password;
        $parsed = self::parseConnectionString($db->connectionString);
        self::$options['host'] = $parsed['hostName'];
        if (isset($parsed['port'])) {
            self::$options['port'] = $parsed['port'];
        }
        $binPath = self::$binPath;
        $options = self::$options;
        $database = self::resolveDatabaseName();
        self::$dumpFile = $database . '_' . date("Y-m-d_H-i-s") . '.sql';

        $dumpPath = self::resolveDumpPath();

        $dumpCommand =
          $binPath .
          ' --single-transaction --force --compact --skip-add-drop-table --complete-insert --extended-insert=FALSE --insert-ignore';
        $dumpCommand =
          $dumpCommand .
          ' ' .
          (isset($options['port']) ? " -P{$options['port']} " : '') .
          "-h{$options['host']} -u{$options['user']} -p{$options['password']} {$database}";
        $dumpCommand = $dumpCommand . ' --tables ' . implode(' ', $tables);
        $dumpCommand = $dumpCommand . ' >> ' . $dumpPath;
//====================================
        $preDump = '';// "SET FOREIGN_KEY_CHECKS=0;\r\n";
        $preDump = $preDump . "TRUNCATE TABLE " . implode(', ', $tables) . ";\r\n";
        file_put_contents($dumpPath, $preDump);
//====================================
        $res = DSExec::exec($dumpCommand);
        //file_put_contents($dumpPath, "\r\nSET FOREIGN_KEY_CHECKS=1;\r\n", FILE_APPEND);
// zip the dump file

        $zipfname = sys_get_temp_dir() . '/' . $database . "_" . date("Y-m-d_H-i-s") . ".zip";
        $zip = new ZipArchive();
        if ($zip->open($zipfname, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $zip->addFile($dumpPath, self::$dumpFile);

            $themePath = DSConfig::getVal('site_front_theme');
            $rootPath = self::$basePath . '/themes/' . $themePath;

// Create recursive directory iterator
            $files = new RecursiveIteratorIterator(
              new RecursiveDirectoryIterator($rootPath),
              RecursiveIteratorIterator::LEAVES_ONLY
            );

            foreach ($files as $name => $file) {
                // Skip directories (they would be added automatically)
                if (!$file->isDir()) {
                    // Get real and relative path for current file
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($rootPath) + 1);

                    // Add current file to archive
                    $zip->addFile($filePath, $themePath . '/' . $relativePath);
                }
            }

// Zip archive will be created only after closing object
            $zip->close();
        }
        unlink($dumpPath);
// read zip file and send it to standard output
        if (file_exists($zipfname)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            //header('Location: '.$zipfname);
            header('Content-Disposition: attachment; filename=' . basename($zipfname));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zipfname));

            ignore_user_abort(false);
            ini_set('output_buffering', 0);
            ini_set('zlib.output_compression', 0);

            $chunk = 10 * 1024 * 1024; // bytes per chunk (10 MB)
            $fh = fopen($zipfname, "rb");
            if ($fh === false) {
                echo 'Unable open file';
            }
            ob_end_clean();
// Repeat reading until EOF
            while (!feof($fh)) {
                echo fread($fh, $chunk);
                ob_flush();  // flush output
                flush();
            }
            fclose($fh);
            unlink($zipfname);
        } else {
            echo Yii::t('admin', 'Ошибка создания архива!');
        }
        Yii::app()->end();
    }

}