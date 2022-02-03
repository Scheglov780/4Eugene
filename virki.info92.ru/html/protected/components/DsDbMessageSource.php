<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DsDbMessageSource.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class DsDbMessageSource extends CDbMessageSource
{
    public $cacheID = 'memCache';
    public $cachingDuration = 3600;

    private function isChinese($text)
    {
        return !(!preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $text) && (preg_match(
              "/[а-яА-Я]{1}/iu",
              $text
            ) || preg_match("/[a-zA-Z]{1}/iu", $text))
        );
    }

    protected function loadMessages($category, $language)
    {
        if ($this->cachingDuration > 0 && $this->cacheID !== false && ($cache = Yii::app()->getComponent(
            $this->cacheID
          )) !== null
        ) {
            $key = self::CACHE_KEY_PREFIX . '.messages.' . $category . '.' . $language;
            if (($data = $cache->get($key)) !== false) {
                return unserialize($data);
            }
        }

        $messages = $this->loadMessagesFromDb($category, $language);

        if (isset($cache)) {
            $cache->set($key, serialize($messages), $this->cachingDuration);
        }

        return $messages;
    }

    protected function loadMessagesFromDb($category, $language)
    {
        /** @noinspection SqlResolve */
        $sql = <<<EOD
SELECT t1.message AS message, t2.translation AS translation
FROM {$this->sourceMessageTable} t1, {$this->translatedMessageTable} t2
WHERE t1.id=t2.id AND t1.category=:category AND t2.language=:language
EOD;
        $command = $this->getDbConnection()->createCommand($sql);
        $command->bindValue(':category', $category);
        $command->bindValue(':language', $language);
        $messages = [];
        foreach ($command->queryAll() as $row) {
            $messages[$row['message']] = $row['translation'];
        }
        return $messages;
    }

    /**
     * @param string          $category
     * @param string|tmessage $message
     * @param string          $language
     * @return string
     */
    protected function translateMessage($category, $message, $language)
    {
        if (is_a($message, 'tmessage')) {
            if (isset($message[$language])) {
                return $message[$language];
            }
            if (isset($message[Yii::app()->sourceLanguage])) {
                $_message = $message[Yii::app()->sourceLanguage];
            } else {
                $_message = 'Unknown message';
            }
        } else {
            $_message = $message;
        }
        if (!$category || !$language || !trim($_message) || !preg_match('/\S/s', $_message)) {
            return $_message;
        }
        if ($category[0] == '~') {
            $_category = ltrim($category, '~');
//   translateText($query = '',$from = 'zh-CN',$to = 'ru',$category = '*',$strong = false,$intOnly = false,
//   $extOutput = true,$editable = false,$clear = false
            if ($_category == 'category') {
                if (!$this->isChinese($_message)) {
                    $source = Yii::app()->sourceLanguage;
                } else {
                    $source = 'zh-CN';
                }
                $result = Yii::app()->DVTranslator->translateCategory(
                  $_message,
                  $source,
                  $language
                );
            } elseif (in_array($_category, ['*'])) {
                $result = Yii::app()->DVTranslator->translateText(
                  $_message,
                  Yii::app()->sourceLanguage,
                  $language,
                  $_category,
                  false,
                  false,
                  false,
                  false
                );
            } else {
                if (Yii::app()->sourceLanguage == 'zh') {
                    return $_message;
                }
                if (!$this->isChinese($_message)) {
                    return $_message;
                }
                $result = Yii::app()->DVTranslator->translateText(
                  $_message,
                  'zh-CN',
                  $language,
                  $_category,
                  false,
                  false,
                  false,
                  false
                );
            }

            if (!$result) {
                $result = $_message;
            }
        } else {
            $result = parent::translateMessage($category, trim($_message), $language);
        }
        return $result;
    }

    public function translate($category, $message, $language = null)
    {
        if ($language === null) {
            $language = Yii::app()->getLanguage();
        }
        $currLanguage = $this->getLanguage();
        if ($category[0] == '~') {
            $result = $this->translateMessage($category, $message, $language);
        } elseif ($this->forceTranslation || $language !== $currLanguage) {
            $result = $this->translateMessage($category, $message, $language);
        } else {
            $result = $message;
        }
        if ((strpos($result, '\'') !== false) || (strpos($result, '"') !== false)) {
            $result = preg_replace('/(?<=[a-zа-я0-9])[\'"](?=[a-zа-я0-9])/isu', '`', $result);
        }
        return $result;
    }

    public static function addTranslation($language, $category, $message, $translation = false)
    {
        $_language = $language;
        $_category = $category;
        $_message = trim($message);
        $_translation = $translation;
        $id = Yii::app()->db->createCommand(
          "SELECT sm.id FROM t_source_message sm WHERE sm.category=:category AND sm.message_md5=md5(:message)  LIMIT 1"
        )->queryScalar(
          [
            ':category' => $_category,
            ':message'  => $_message,
          ]
        );
        if (!$id) {
            Yii::app()->db->createCommand(
              'INSERT INTO  t_source_message (category,message,message_md5)
                     VALUES(:category,:message,md5(:message))
                     ON CONFLICT ON CONSTRAINT t_source_message_unique_constr 
                     DO NOTHING                     
                     '
            )->execute(
              [
                ':category' => $_category,
                ':message'  => $_message,
              ]
            );
            $id = Yii::app()->db->getLastInsertID();
        }
        if ($id && $translation) {
            Yii::app()->db->createCommand(
              'DELETE FROM t_message WHERE id=:id AND language=:language;
               INSERT INTO  t_message (id,language,translation)
                     VALUES(:id,:language,:translation)
                     ON CONFLICT ON CONSTRAINT t_message_unique_constr 
                     DO NOTHING;'
            )->execute(
              [
                ':id'          => $id,
                ':language'    => $_language,
                ':translation' => $_translation,
              ]
            );
        }
    }
}

class TranslationEventHandler
{
    private static function umlaute($text)
    {
        $returnvalue = "";
        for ($i = 0; $i < mb_strlen($text); $i++) {
            $teil = hexdec(rawurlencode(mb_substr($text, $i, 1)));
            if ($teil < 32 || $teil > 1114111) {
                $returnvalue .= mb_substr($text, $i, 1);
            } else {
                $returnvalue .= "&#" . str_pad($teil, 8, '0', STR_PAD_LEFT) . ";";
            }
        }
        return $returnvalue;
    }

    public static function handleMissingTranslation($event)
    {
        if ($event->message == '...') {
            return;
        }
        // обрабатываем отсутствие перевода
        $srcLang = Yii::app()->sourceLanguage;
        $translation = Yii::app()->DVTranslator->translateMessage(
          $event->message,
          Yii::app()->sourceLanguage,
          $event->language
        );
        $translation = trim($translation);
        if ($translation && ((strlen($translation)) > 0) && (strtoupper($translation) != 'FALSE')) {
            //$translation = htmlspecialchars($translation, ENT_COMPAT|ENT_IGNORE|, 'utf-8');
            $translation = htmlentities($translation, ENT_COMPAT | ENT_IGNORE, 'UTF-8');
            /*            if (in_array($event->language, array('de', 'fr', 'es'))) {
                            $translation = rawurlencode(utf8_encode($translation));
                        }
            */
            if (ltrim($event->message) != $event->message) {
                $translation = ' ' . $translation;
            }
            if (rtrim($event->message) != $event->message) {
                $translation = $translation . ' ';
            }
        } else {
            $translation = false;
        }
        DsDbMessageSource::addTranslation($event->language, $event->category, $event->message, $translation);
        $event->message = (($translation) ? $translation : $event->message);
        $event->handled = true;
    }
}