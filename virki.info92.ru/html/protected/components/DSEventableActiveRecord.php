<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSEventableActiveRecord.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

abstract class DSEventableActiveRecord extends DSActiveRecord
{

    abstract function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null);

    /**
     * This method is invoked after saving a record successfully.
     * The default implementation raises the {@link onAfterSave} event.
     * You may override this method to do postprocessing after record saving.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    protected function afterSave()
    {
        parent::afterSave();
        /* if ($this->hasEventHandler('onAfterSave')) {
             $this->onAfterSave(new CEvent($this));
         } */
        CmsEmailEvents::emailProcessEvents($this, ($this->isNewRecord) ? 'afterInsert' : 'afterUpdate');
        Events::processEvents($this, get_class($this) . '.' . (($this->isNewRecord) ? 'afterInsert' : 'afterUpdate'));
    }

    protected function beforeSave()
    {

        CmsEmailEvents::emailProcessEvents($this, ($this->isNewRecord) ? 'beforeInsert' : 'beforeUpdate');
        Events::processEvents($this, get_class($this) . '.' . (($this->isNewRecord) ? 'beforeInsert' : 'beforeUpdate'));
        return parent::beforeSave();
        /*
        if ($this->hasEventHandler('onBeforeSave')) {
            $event = new CModelEvent($this);
            $this->onBeforeSave($event);
            return $event->isValid;
        } else {
            return true;
        }
        */
    }

}