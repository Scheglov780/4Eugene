<?php
/**
 * FileActionEventArgs.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * This class is used with the FileAction events as an argument.
 * @package MOXMAN_Core
 */
class MOXMAN_Core_FileActionEventArgs extends MOXMAN_Util_EventArgs
{
    /**
     * Add file action. For example when a file is uploaded.
     */
    const ADD = "add";
    /**
     * Copy file action.
     */
    const COPY = "copy";
    /**
     * Delete file action.
     */
    const DELETE = "delete";
    /**
     * Insert file action. Will be used when a file is inserted into a form.
     */
    const INSERT = "insert";
    /**
     * List files action. Will be executed when files gets listed in a dir.
     */
    const LIST_FILES = "list_files";
    /**
     * Move file action. Will be used when a file is moved or renamed.
     */
    const MOVE = "move";
    /**
     * Update file action. For example when a file is modified in place.
     */
    const UPDATE = "update";

    /**
     * Constructs a new action event.
     * @param string           $action Action name to create.
     * @param MOXMAN_Vfs_IFile $file   File instance for the action.
     */
    public function __construct($action, MOXMAN_Vfs_IFile $file)
    {
        // Validate action names against the constants
        switch ($action) {
            case self::DELETE:
            case self::ADD:
            case self::UPDATE:
            case self::MOVE:
            case self::COPY:
            case self::INSERT:
            case self::LIST_FILES:
                break;

            default:
                throw new MOXMAN_Exception("Invalid action name: " . $action);
        }

        $this->action = $action;
        $this->file = $file;
        $this->data = new stdClass();
    }

    /**
     * File action name for example delete or add.
     * @var string
     */
    protected $action;
    /**
     * Object with custom data.
     * @var stdClass
     */
    protected $data;
    /**
     * File instance for file action.
     * @var MOXMAN_Vfs_IFile
     */
    protected $file;
    /**
     * Array with files. Used for list_files actions.
     * @var array
     */
    protected $files;
    /**
     * Optional target file instance used in move/copy actions.
     * @var MOXMAN_Vfs_IFile
     */
    protected $targetFile;

    /**
     * Gets the current action name.
     * @return String Current action name.
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Returns the custom data object. This can be used to pass custom information from one listener to another.
     * @return stdClass Class instance with custom data.
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get the file instance for the event.
     * @return MOXMAN_Vfs_IFile File instance for the event.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set the file instance for the event.
     * @param MOXMAN_Vfs_IFile $file File to set as the file.
     */
    public function setFile(MOXMAN_Vfs_IFile $file)
    {
        $this->file = $file;
    }

    /**
     * Returns an array of files for an list_files action.
     * @return array Array of files.
     */
    public function getFileList()
    {
        return $this->files;
    }

    /**
     * Gets the optional target file. This will return null if the target file isn't set.
     * @return MOXMAN_Vfs_IFile Target file instance or null if it's not set.
     */
    public function getTargetFile()
    {
        return $this->targetFile;
    }

    /**
     * Sets the target file for the action. Used in operations like copy or move.
     * @param MOXMAN_Vfs_IFile $file File to set as the target file.
     */
    public function setTargetFile(MOXMAN_Vfs_IFile $file)
    {
        $this->targetFile = $file;
    }

    /**
     * Checks if the action matches the specified action.
     * @param string $action Action to check if it matches with.
     * @return boolean True if the action matches, false if it doesn't.
     */
    public function isAction($action)
    {
        return $this->action === $action;
    }

    /**
     * Sets a list of files for the file event. A file list can be for example in a list_files action.
     * This enables you to alter the list of files before it's getting sent out to the client.
     * @param array $files Array of file to list.
     */
    public function setFileList($files)
    {
        $this->files = $files;
    }
}

?>