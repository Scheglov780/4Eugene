<?php
/**
 * LocalFileUrlResolver.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * Resolves the specified url to a file instance.
 * @package MOXMAN_Vfs_Local
 */
class MOXMAN_Vfs_Local_FileUrlResolver implements MOXMAN_Vfs_IFileUrlResolver
{
    /**
     * Constructs a new FileUrlResolver.
     * @param MOXMAN_Vfs_FileSystem $filesystem File system reference.
     */
    public function __construct($filesystem)
    {
        $this->fileSystem = $filesystem;
    }

    /** @ignore */
    private $fileSystem;

    /**
     * Returns a file object out of the specified URL.
     * @param string Absolute URL for the specified file.
     * @return MOXMAN_Vfs_IFile File that got resolved or null if it wasn't found.
     */
    public function getFile($url)
    {
        $config = $this->fileSystem->getConfig();
        $file = null;

        // Get config items
        $wwwroot = $config->get("filesystem.local.wwwroot");
        $prefix = $config->get("filesystem.local.urlprefix");
        $paths = MOXMAN_Util_PathUtils::getSitePaths();

        // No wwwroot specified try to figure out a wwwroot
        if (!$wwwroot) {
            $wwwroot = $paths["wwwroot"];
        } else {
            // Force the www root to an absolute file system path
            $wwwroot = MOXMAN_Util_PathUtils::toAbsolute(MOXMAN_ROOT, $wwwroot);
        }

        // Add prefix to URL
        if ($prefix == "") {
            $prefix = MOXMAN_Util_PathUtils::combine("{proto}://{host}", $paths["prefix"]);
        }

        // Replace protocol
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
            $prefix = str_replace("{proto}", "https", $prefix);
        } else {
            $prefix = str_replace("{proto}", "http", $prefix);
        }

        // Replace host/port
        $prefix = str_replace("{host}", $_SERVER['HTTP_HOST'], $prefix);
        $prefix = str_replace("{port}", $_SERVER['SERVER_PORT'], $prefix);

        // Remove prefix from url
        if ($prefix && strpos($url, $prefix) === 0) {
            $url = substr($url, strlen($prefix));
        }

        // Parse url and check if path part of the URL is within the root of the file system
        $url = parse_url($url);
        if (isset($url["path"])) {
            $path = MOXMAN_Util_PathUtils::combine($wwwroot, $url["path"]);

            if (MOXMAN_Util_PathUtils::isChildOf($path, $this->fileSystem->getRootPath())) {
                // Crop away root path part and glue it back on again since the case might be different
                // For example: c:/inetpub/wwwroot and C:/InetPub/WWWRoot this will force it into the
                // valid fileSystem root path prefix
                $path = substr($path, strlen($this->fileSystem->getRootPath()));
                $path = MOXMAN_Util_PathUtils::combine($this->fileSystem->getRootPath(), $path);
                $file = $this->fileSystem->getFile($path);
            }
        }

        return $file;
    }
}

?>