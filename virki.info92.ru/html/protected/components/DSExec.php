<?php

class DSExec
{
    public static function exec($cmd, $wait = true, $srcEncoding = 'UTF-8', $asText = true)
    {
        if ($wait) {
            exec($cmd, $output, $exitCode);
            if ($asText) {
                $result = implode("\n", $output);
                $result = @iconv($srcEncoding, 'UTF-8//IGNORE', $result);
                return $result;
            } else {
                foreach ($output as $i => $rec) {
                    $output[$i] = @iconv($srcEncoding, 'UTF-8//IGNORE', $rec);
                }
                return $output;
            }
        } else {
            pclose(popen('start /MIN ' . $cmd, 'r'));
            return true;
        }
    }

    public static function execBatch($cmd, $wait = true, $srcEncoding = 'CP866', $asText = true)
    {
        $commands = explode("\r", $cmd);
        $result = '';
        foreach ($commands as $command) {
            if (trim($command) && !(preg_match('/^[\s@]*rem\s/is', $command))) {
                $res = self::exec(trim($command), $wait, $srcEncoding, $asText);
                if (!trim($res)) {
                    $res = trim($command);
                }
                $result = $result . "\r\n" . $res;
            }
        }
        return $result;
    }
}