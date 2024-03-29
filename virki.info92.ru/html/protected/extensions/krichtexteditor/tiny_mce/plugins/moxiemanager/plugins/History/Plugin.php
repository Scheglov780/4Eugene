<?php
/**
 * Plugin.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * ...
 */
class MOXMAN_History_Plugin implements MOXMAN_IPlugin, MOXMAN_ICommandHandler
{
    public function add($path)
    {
        $files = MOXMAN_Util_Json::decode(MOXMAN::getUserStorage()->get("history.files", "[]"));

        // If files is larger then max size then crop it
        $max = intval(MOXMAN::getConfig()->get("history.max"));
        if (count($files) >= $max) {
            $files = array_slice($files, count($files) - $max);
        }

        // Remove existing paths
        for ($i = 0; $i < count($files); $i++) {
            if ($files[$i]->path == $path) {
                array_splice($files, $i, 1);
            }
        }

        $file = MOXMAN::getFile($path);

        $files[] = [
          "path"  => $file->getPublicPath(),
          "size"  => $file->getSize(),
          "isdir" => $file->isDirectory(),
          "mdate" => $file->getLastModified(),
        ];

        MOXMAN::getUserStorage()->put("history.files", MOXMAN_Util_Json::encode($files));
    }

    public function execute($name, $params)
    {
        switch ($name) {
            case "history.remove":
                return $this->remove($params);
        }
    }

    public function init()
    {
        MOXMAN::getFileSystemManager()->registerFileSystem("history", "MOXMAN_History_FileSystem");
        MOXMAN::getFileSystemManager()->addRoot("History=history:///");
        MOXMAN::getPluginManager()->get("core")->bind("FileAction", "onFileAction", $this);
    }

    public function onFileAction(MOXMAN_Core_FileActionEventArgs $args)
    {
        if ($args->isAction("insert")) {
            $this->add($args->getFile()->getPublicPath());
        }

        if ($args->isAction("delete")) {
            $this->remove(
              (object) [
                "paths" => [
                  $args->getFile()->getPublicPath(),
                ],
              ]
            );
        }
    }

    public function remove($params)
    {
        if (MOXMAN::getConfig()->get('general.demo')) {
            throw new MOXMAN_Exception(
              "This action is restricted in demo mode.",
              MOXMAN_Exception::DEMO_MODE
            );
        }

        if (isset($params->paths) && is_array($params->paths)) {
            $paths = $params->paths;
            $files = MOXMAN_Util_Json::decode(MOXMAN::getUserStorage()->get("history.files", "[]"));

            // Remove existing paths
            for ($i = 0; $i < count($files); $i++) {
                foreach ($paths as $path) {
                    if ($files[$i]->path == $path) {
                        array_splice($files, $i, 1);
                    }
                }
            }

            MOXMAN::getUserStorage()->put("history.files", MOXMAN_Util_Json::encode($files));
        }

        return true;
    }
}

// Add plugin
MOXMAN::getPluginManager()->add("history", new MOXMAN_History_Plugin());

?>