<?php
/**
 * File.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * Memory file instance.
 * @package MOXMAN_Vfs_Memory
 */
class MOXMAN_Vfs_Memory_File extends MOXMAN_Vfs_BaseFile
{
    /**
     * Returns true if the files is readable.
     * @return boolean true if the files is readable.
     */
    public function canRead()
    {
        if (!parent::canRead()) {
            return false;
        }

        return $this->getEntry() ? $this->getEntry()->canRead : true;
    }

    /**
     * Returns true if the files is writable.
     * @return boolean true if the files is writable.
     */
    public function canWrite()
    {
        if (!parent::canWrite()) {
            return false;
        }

        return $this->getEntry() ? $this->getEntry()->canWrite : true;
    }

    /**
     * Copies this file to the specified file instance.
     * @param MOXMAN_Vfs_IFile $dest File to copy to.
     */
    public function copyTo(MOXMAN_Vfs_IFile $dest)
    {
        $entries = $this->fileSystem->getEntries($this->path);

        foreach ($entries as $entry) {
            $toPath = MOXMAN_Util_PathUtils::combine($dest->getPath(), substr($entry->path, strlen($this->getPath())));
            $this->fileSystem->addEntry($toPath, [
              "isFile"       => $entry->isFile,
              "lastModified" => $entry->lastModified,
              "data"         => $entry->data,
              "canRead"      => $entry->canRead,
              "canWrite"     => $entry->canWrite,
            ]);
        }
    }

    /**
     * Deletes the file.
     * @param boolean $deep If this option is enabled files will be deleted recurive.
     */
    public function delete($deep = false)
    {
        $this->fileSystem->deleteEntry($this->path);
    }

    /**
     * Returns true if the file exists.
     * @return boolean true if the file exists.
     */
    public function exists()
    {
        return $this->getEntry() !== null;
    }

    /**
     * Exports the file to a local path. This is used by some operations that can be done in memory.
     * @param string $localPath Local path to export file to.
     * @return string Local path that the file was exported to.
     */
    public function exportTo($localPath)
    {
        if ($this->isFile()) {
            file_put_contents($localPath, $this->getEntry()->data);
        }
    }

    /** @ignore */
    public function getEntry()
    {
        return $this->fileSystem->getEntry($this->path);
    }

    /**
     * Returns last modification date in ms as an long.
     * @return long last modification date in ms as an long.
     */
    public function getLastModified()
    {
        return $this->exists() ? $this->getEntry()->lastModified : 0;
    }

    /**
     * Returns file size as an long.
     * @return long file size as an long.
     */
    public function getSize()
    {
        return $this->getEntry() ? strlen($this->getEntry()->data) : 0;
    }

    /**
     * Imports a local file into the file system.
     * @param string $localPath Local file system path to import.
     */
    public function importFrom($localPath)
    {
        $stream = $this->open(MOXMAN_Vfs_IFileStream::WRITE);
        $stream->write(file_get_contents($localPath));
        $stream->close();
    }

    /**
     * Returns true if the file is a file.
     * @return boolean true if the file is a file.
     */
    public function isFile()
    {
        return $this->exists() && $this->getEntry()->isFile;
    }

    /**
     * Returns an array of BaseFile instances based on the specified filter instance.
     * @param MOXMAN_Vfs_IFileFilter $filter FileFilter instance to filter files by.
     * @return array array of File instances based on the specified filter instance.
     */
    public function listFilesFiltered(MOXMAN_Vfs_IFileFilter $filter)
    {
        $entries = $this->fileSystem->getChildEntries($this->path);
        $files = [];

        foreach ($entries as $entry) {
            $file = new MOXMAN_Vfs_Memory_File($this->fileSystem, $entry->path);
            if ($filter->accept($file) === MOXMAN_Vfs_IFileFilter::ACCEPTED) {
                $files[] = $file;
            }
        }

        return $files;
    }

    /**
     * Creates a new directory.
     */
    public function mkdir()
    {
        $this->fileSystem->addEntry($this->path, ["isFile" => false]);
    }

    /**
     * Renames/Moves this file to the specified file instance.
     * @param MOXMAN_Vfs_IFile $dest File to rename/move to.
     */
    public function moveTo(MOXMAN_Vfs_IFile $dest)
    {
        $entries = $this->fileSystem->getEntries($this->path);

        foreach ($entries as $entry) {
            $toPath = MOXMAN_Util_PathUtils::combine($dest->getPath(), substr($entry->path, strlen($this->getPath())));
            $this->fileSystem->addEntry($toPath, [
              "isFile"       => $entry->isFile,
              "lastModified" => $entry->lastModified,
              "data"         => $entry->data,
              "canRead"      => $entry->canRead,
              "canWrite"     => $entry->canWrite,
            ]);
        }

        $this->fileSystem->deleteEntry($this->path);
    }

    /**
     * Opens a file stream by the specified mode. The default mode is rb.
     * @param string $mode Mode to open file by, r, rb, w, wb etc.
     * @return MOXMAN_Vfs_IStream File stream implementation for the file system.
     */
    public function open($mode = MOXMAN_Vfs_IStream::READ)
    {
        $stream = new MOXMAN_Vfs_Memory_FileStream($this, $mode);

        return $stream;
    }
}

?>