<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Profiler.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DSGLog extends CComponent
{
    function __construct($url, $cacheId = null)
    {
        $this->startTime = microtime(true);
        $this->date = date('Y-m-d H:i:s');
        $this->type = $this->urlToType($url);
        $this->_cacheId = $cacheId;
        $this->fromIp = Utils::getRemoteIp();
        $this->fromHost = Utils::getRemoteHostEx($this->fromIp);
        // $this->extData = $_SERVER;

    }

    private $_cacheId;
    private $endTime;
    private $startTime;
    public $DSProxy;
    public $date;
    public $debug = null;
    public $duration;
    public $extData = [];
    public $fromHost;
    public $fromIp;
    public $httpProxy;
    public $result;
    public $type;

    private function save()
    {
        try {
            $this->result = preg_replace('/(?<=milliseconds).+/is', '', $this->result);
            $this->result = preg_replace('/(?<=Unknown SSL protocol error in connection).+/is', '', $this->result);
            $originalResult = $this->result;
            if ((strlen($this->result) > 64)) {
                $this->result = preg_replace('/error:\d{5,}:/is', '', $this->result);
            }
            if (!$this->result) {
                $this->result = $originalResult;
            }
            if (!isset($this->result) || !is_string($this->result) || !$this->result || !trim($this->result)) {
                if (is_string($originalResult)) {
                    $this->result = substr($originalResult, 0, 64);
                } else {
                    $this->result = 'Unknown';
                }
            } elseif (strlen($this->result) > 64) {
                $this->result = preg_replace('/^(.{1,64})[\s\.:\-,;].*/s', '\1', $this->result);
                if (!$this->result) {
                    $this->result = substr($originalResult, 0, 64);
                }
            }
            $params = [
              ':date'       => $this->date,
              ':duration'   => $this->duration,
              ':cache_id'   => $this->_cacheId,
              ':result'     => $this->result,
              ':type'       => $this->type,
              ':from_host'  => $this->fromHost,
              ':from_ip'    => $this->fromIp,
              ':ds_proxy'   => $this->DSProxy,
              ':http_proxy' => $this->httpProxy,
              ':debug'      => $this->debug,
            ];

            if (Yii::app()->db->cache(3600)->createCommand(
                "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 'log_dsg_buffer'"
              )->queryRow() &&
              !(isset($this->extData) && is_array($this->extData) && count($this->extData))
            ) {
                Yii::app()->db->createCommand(
                  "INSERT INTO log_dsg_buffer (\"date\",\"duration\",\"cache_id\",\"result\",\"type\",\"from_host\",\"from_ip\",\"ds_proxy\",\"http_proxy\",\"debug\")
        VALUES (:date,:duration,:cache_id,:result,:type,:from_host,:from_ip,:ds_proxy,:http_proxy,:debug)"
                )
                  ->execute($params);
                $cnt = Yii::app()->db->createCommand("select count(0) from log_dsg_buffer")
                  ->queryScalar();
                if ($cnt > 1000) {
                    Yii::app()->db->createCommand(
                      "INSERT INTO log_dsg (\"date\",\"date_day\",\"duration\",\"cache_id\",\"result\",\"type\",\"from_host\",\"from_ip\",\"ds_proxy\",\"http_proxy\",\"debug\")
        SELECT \"date\",extract(day from \"date\"),\"duration\",\"cache_id\",\"result\",\"type\",\"from_host\",\"from_ip\",\"ds_proxy\",\"http_proxy\",\"debug\" FROM log_dsg_buffer bb
        where bb.result!='';
                  TRUNCATE TABLE log_dsg_buffer;"
                    )->execute();
                }
            } else {
                Yii::app()->db->createCommand(
                  "INSERT INTO log_dsg (\"date\",\"date_day\",\"duration\",\"cache_id\",\"result\",\"type\",\"from_host\",\"from_ip\",\"ds_proxy\",\"http_proxy\",\"debug\")
        VALUES (:date,extract (day from \"date\"),:duration,:cache_id,:result,:type,:from_host,:from_ip,:ds_proxy,:http_proxy,:debug)"
                )
                  ->execute($params);
                if (isset($this->extData) && is_array($this->extData) && count($this->extData)) {
                    $lastId = Yii::app()->db->getLastInsertID();
                    $data = CVarDumper::dumpAsString($this->extData);
                    ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
                    ini_set('pcre.recursion_limit', 1024 * 1024);
                    $data = preg_replace('/<parser_sections.+<\/parser_sections>/is', '', $data);
                    /*
                    Yii::app()->db->createCommand("insert into log_dsg_details (log_dsg_id, data)
                     values (:log_dsg_id, :data)")->execute(
                      array(':log_dsg_id'=>$lastId,
                        ':data'=>$data
                      )
                    );
                    */
                }
            }
        } catch (Exception $e) {
            return;
//            Yii::log(CVarDumper::dumpAsString($e));
        }
    }

    function __destruct()
    {
        $this->endTime = microtime(true);
        $this->duration = round($this->endTime - $this->startTime, 2);
        $this->save();
    }

    public function getCacheId()
    {
        return $this->_cacheId;
    }

    public function setCacheId($cacheId)
    {
//        if (!isset($this->_cacheId)) {
        $this->_cacheId = $cacheId;
//        }
    }

    public function urlToType($url)
    {
        $type = preg_replace('/http[s]*:\/\/(.+?)[\/].*/i', '\1', $url);
        return $type;
    }
}