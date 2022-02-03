<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSMetatagableActiveRecord.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DSMetatagableActiveRecord extends CActiveRecord
{

    public function getDescription()
    {
        if (isset($this->url)) {
            return cms::meta($this->url, 'description');
        } else {
            return '';
        }
    }

    public function getKeywords()
    {
        if (isset($this->url)) {
            return cms::meta($this->url, 'keywords');
        } else {
            return '';
        }
    }

    public function getNametranslation()
    {
        return null;
    }

    public function getText()
    {
        $result = '';
        if (isset($this->url)) {
            $result = cms::meta($this->url, 'text');
        }
        if ($result) {
            return $result;
        }
        if (DSConfig::getVal('seo_use_knowledge_base') == 1) {
            return CmsKnowledgeBase::fullTextSearch($this->getNametranslation());
        } else {
            return '';
        }
    }

    public function getTitle()
    {
        if (isset($this->url)) {
            return cms::meta($this->url, 'title');
        } else {
            return '';
        }
    }

    public function setDescription($value)
    {
        if (isset($this->url)) {
            if (is_array($value)) {
                foreach ($value as $lang => $langVal) {
                    cms::setMeta($langVal, $this->url, 'description', $lang);
                }
            } else {
                cms::setMeta($value, $this->url, 'description');
            }
        }
    }

    public function setKeywords($value)
    {
        if (isset($this->url)) {
            if (is_array($value)) {
                foreach ($value as $lang => $langVal) {
                    cms::setMeta($langVal, $this->url, 'keywords', $lang);
                }
            } else {
                cms::setMeta($value, $this->url, 'keywords');
            }
        }
    }

    public function setNametranslation($value)
    {
        if (isset($this->url)) {
            if (is_array($value)) {
                if (isset($value['ru'])) {
                    $this->ru = $value['ru'];
                }
                if (isset($value['en'])) {
                    $this->en = $value['en'];
                }
                if (isset($value['zh'])) {
                    $this->zh = $value['zh'];
                }
                $src = ($this->zh ? $this->zh : $this->ru);
                $records = Yii::app()->db->createCommand(
                  "SELECT sd.id FROM t_source_category sd
                WHERE sd.message_md5=md5(:source)"
                )->queryAll(
                  true,
                  [
                    ':source' => $src,
                  ]
                );
                if ($records) {
                    foreach ($value as $lang => $langVal) {
                        if (!$langVal) {
                            continue;
                        }
//=====================================================================================
                        foreach ($records as $record) {
                            Yii::app()->db->createCommand(
                              "
         UPDATE t_category dd
         SET status=1, translation=:translation
                WHERE dd.language = :to AND dd.id = :id
         "
                            )->execute(
                              [
                                ':translation' => $langVal,
                                ':to'          => $lang,
                                ':id'          => $record['id'],
                              ]
                            );
                        }
                    }
                }
            }
        }
    }

    public function setText($value)
    {
        if (isset($this->url)) {
            if (is_array($value)) {
                foreach ($value as $lang => $langVal) {
                    cms::setMeta($langVal, $this->url, 'text', $lang);
                }
            } else {
                cms::setMeta($value, $this->url, 'text');
            }
        }
    }

    public function setTitle($value)
    {
        if (isset($this->url)) {
            if (is_array($value)) {
                foreach ($value as $lang => $langVal) {
                    cms::setMeta($langVal, $this->url, 'title', $lang);
                }
            } else {
                cms::setMeta($value, $this->url, 'title');
            }
        }
    }
}