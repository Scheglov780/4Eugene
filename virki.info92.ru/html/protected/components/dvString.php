<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="dvString.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class dvString
{
    public function __construct($source, $sourceLang = false)
    {
        $this->source = $source;
        $this->sourceLang = $sourceLang;
    }

    public $source = '';
    public $sourceLang = false;
    public $translation = '';
    public $translationLang = false;

    private function replace4byte($string, $replacement = '')
    {
        return $string;
        //return @iconv("UTF-8","UTF-8//IGNORE",$string);
        //preg_replace('/(?:\xF0[\x90-\xBF][\x80-\xBF]{2}|[\xF1-\xF3][\x80-\xBF]{3}|\xF4[\x80-\x8F][\x80-\xBF]{2})/xs', $replacement, $string);
    }

    public function __toString()
    {
        $result = null;
        if ($this->isTranslated() && is_string($this->translation)) {
            $result = $this->translation;
        } elseif (is_string($this->source)) {
            $result = $this->source;
        }
        //$result = utf8_encode($result);
        if ($result) {
            return $this->replace4byte($result); //remove after converting of all strings in DB to utf8mb4
        } else {
            return '';
        }
    }

    public function isTranslated()
    {
        if (!$this->translation) {
            return false;
        } else {
            return true;
        }
    }

    public function plainTranslation()
    {
        if ($this->isTranslated()) {
            return Utils::translationAddClearTag($this->translation);
        } else {
            return $this->source;
        }
    }

}

