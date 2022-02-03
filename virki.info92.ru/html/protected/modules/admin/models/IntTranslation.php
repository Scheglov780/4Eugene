<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="IntSearch.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class IntTranslation
{
    private $tables = ['t_category', 't_dictionary', 't_dictionary_long', 't_message', 't_sentences', 't_pinned'];
    public $replace = '';
    public $search = '';

    public function Replace()
    {
        $search = $this->search;
        $replace = $this->replace;
        $similarSearch = '%' . trim($this->search) . '%';
        if (!$search) {
            return false;
        } else {
            /*
             * table,changed,similar
            */
            $resultArray = [];
            $lang = Yii::app()->getLanguage();
            foreach ($this->tables as $table) {
                $changed = Yii::app()->db->createCommand(
                  "
                select count(0) as cnt from \"{$table}\" where translation=:search and language = '{$lang}'
                "
                )->queryScalar([':search' => $search]);
                if ($replace) {
                    $changed = $changed . ' ' . Yii::t('main', 'из') . ' ' . $changed;
                    $updated = Yii::app()->db->createCommand(
                      "
                update \"{$table}\"
                set translation = :replace
                where translation=:search and language = '{$lang}'
                "
                    )->execute([':replace' => $replace, ':search' => $search]);
                } else {
                    $changed = '0 ' . Yii::t('main', 'из') . ' ' . $changed;
                }
                $similar = Yii::app()->db->createCommand(
                  "
                select translation from \"{$table}\" where translation like :search and language = '{$lang}' limit 10
                "
                )->queryColumn([':search' => $similarSearch]);
                if (is_array($similar)) {
                    $similar = implode('<br/>', $similar);
                } else {
                    $similar = '';
                }
                $resultArray[] = ['table' => $table, 'changed' => $changed, 'similar' => $similar];
            }
            $result = new CArrayDataProvider(
              $resultArray, [
                'id'         => 'translationResults',
                'keyField'   => 'table',
                'pagination' => [
                  'pageSize' => 100,
                ],
              ]
            );
            return $result;
        }
    }
}

