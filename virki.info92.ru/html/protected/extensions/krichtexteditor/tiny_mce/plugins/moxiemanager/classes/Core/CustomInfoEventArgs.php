<?php
/**
 * CustomInfoEventArgs.php
 * Copyright 2003-2013, Moxiecode Systems AB, All rights reserved.
 */

/**
 * Instances of this event arguments class will be passed to custom info events. This enables you to add your own custom
 * data when for example a file is inserted into a form/editor or when files are listed.
 * @package MOXMAN_Core
 */
class MOXMAN_Core_CustomInfoEventArgs extends MOXMAN_Util_EventArgs
{
    /**
     * Type when a file is selected to be inserted back to a form or TinyMCE.
     */
    const INSERT_TYPE = "insert";
    /**
     * Type when a file is added to a file list.
     */
    const LIST_TYPE = "list";

    /**
     * Constructs a new custom info event.
     * @param string           $type Custom info type to create.
     * @param MOXMAN_Vfs_IFile $file File instance for the custom info.
     */
    public function __construct($type, MOXMAN_Vfs_IFile $file)
    {
        $this->type = $type;
        $this->file = $file;
        $this->customInfo = [];
    }

    /**
     * Custom info data for the specified file.
     * @var array
     */
    protected $customInfo;
    /**
     * File instance associated with the event.
     * @var MOXMAN_Vfs_IFile
     */
    protected $file;
    /**
     * Tyoe of custom info event.
     * @var string
     */
    protected $type;

    /**
     * Extends the custom info data with new items.
     * @param Array $info Array with custom info to extend the existing one with.
     * @return MOXMAN_CustomInfoEventArgs Instance reference.
     */
    public function extendInfo($info)
    {
        if (is_array($info)) {
            $this->customInfo = array_merge($this->customInfo, $info);
        }

        return $this;
    }

    /**
     * Returns the file instance that the custom info is to be added for.
     * @return MOXMAN_Vfs_IFile File instance for the custom info.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Returns the custom info array. Custom info will be passed out when you insert
     * a file and can include extra details about the file.
     * @return Array Custom info data for the action.
     */
    public function getInfo()
    {
        return $this->customInfo;
    }

    /**
     * Returns the custom info type. For example "insert" or "list".
     * @return String Custom info type name.
     */
    public function getType()
    {
        return $this->type;
    }
}

?>