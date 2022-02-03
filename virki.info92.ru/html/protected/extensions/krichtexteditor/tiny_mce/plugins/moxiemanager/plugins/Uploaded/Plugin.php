<?php
/**
 * Plugin.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * ...
 */
class MOXMAN_Uploaded_Plugin implements MOXMAN_IPlugin, MOXMAN_ICommandHandler
{
    public function add($path)
    {
        $files = MOXMAN_Util_Json::decode(MOXMAN::getUserStorage()->get("uploaded.files", "[]"));

        // If files is larger then max size then crop it
        $max = intval(MOXMAN::getConfig()->get("uploaded.max", 20));
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

        MOXMAN::getUserStorage()->put("uploaded.files", MOXMAN_Util_Json::encode($files));
    }

    public function execute($name, $params)
    {
        switch ($name) {
            case "uploaded.remove":
                return $this->remove($params);
        }
    }

    public function init()
    {
        MOXMAN::getFileSystemManager()->registerFileSystem("uploaded", "MOXMAN_Uploaded_FileSystem");
        MOXMAN::getFileSystemManager()->addRoot("Uploaded=uploaded:///");
        MOXMAN::getPluginManager()->get("core")->bind("FileAction", "onFileAction", $this);
    }

    public function onFileAction(MOXMAN_Core_FileActionEventArgs $args)
    {
        if ($args->isAction("add") && (!isset($args->getData()->thumb) || !$args->getData()->thumb)) {
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
        if (isset($params->paths) && is_array($params->paths)) {
            $paths = $params->paths;
            $files = MOXMAN_Util_Json::decode(MOXMAN::getUserStorage()->get("uploaded.files", "[]"));

            // Remove existing paths
            for ($i = 0; $i < count($files); $i++) {
                foreach ($paths as $path) {
                    if ($files[$i]->path == $path) {
                        array_splice($files, $i, 1);
                    }
                }
            }

            MOXMAN::getUserStorage()->put("uploaded.files", MOXMAN_Util_Json::encode($files));
        }

        return true;
    }
}

// Add plugin
MOXMAN::getPluginManager()->add("uploaded", new MOXMAN_Uploaded_Plugin());

?>