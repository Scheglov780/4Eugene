<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Suggestions.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class customSuggestions
{
    public static function getSuggestions($q, $transkey = false)
    {
        try {
            $lang = Utils::transLang();
            $command = Yii::app()->db->createCommand(
              "SELECT * FROM (
SELECT 'query_fulltext' AS type, max(rr.query) AS ru, max(rr.query) AS en, max(rr.query) AS zh, rr.cid, rr.query,
max(rr.res_count) AS res_count
     FROM log_queries_requests rr
WHERE to_tsvector('russian',rr.query) @@ websearch_to_tsquery('russian',:q)
GROUP BY rr.ds_source, rr.query 
order by ts_rank(to_tsvector('russian',rr.query), websearch_to_tsquery('russian',:q)) desc
 LIMIT 20) s2
UNION ALL
SELECT  * FROM (
SELECT  'cat_fulltext' AS type, cc.ru, cc.en, cc.zh, cc.cid, cc.query,
null AS res_count
     FROM categories_ext cc
WHERE to_tsvector('russian',cc.ru||' '||cc.en||' '||cc.zh) @@ websearch_to_tsquery('russian',:q) 
order by ts_rank(to_tsvector('russian',cc.ru||' '||cc.en||' '||cc.zh), websearch_to_tsquery('russian',:q)) desc
LIMIT 20) s1"
            );
            $rows = $command->queryAll(true,
              [
                ':q' => $q,
              ]
            );
            $res = '';
            if (count($rows) <= 0) {
                $transQ = self::transkey($q);
                $command = Yii::app()->db->createCommand(
                  "SELECT * FROM (
SELECT 'query_fulltext' AS type, max(rr.query) AS ru, max(rr.query) AS en, max(rr.query) AS zh, rr.cid, rr.query,
max(rr.res_count) AS res_count
     FROM log_queries_requests rr
WHERE to_tsvector('russian',rr.query) @@ websearch_to_tsquery('russian',:q)
GROUP BY rr.ds_source, rr.query 
order by ts_rank(to_tsvector('russian',rr.query), websearch_to_tsquery('russian',:q)) desc
 LIMIT 20) s2
UNION ALL
SELECT  * FROM (
SELECT  'cat_fulltext' AS type, cc.ru, cc.en, cc.zh, cc.cid, cc.query,
null AS res_count
     FROM categories_ext cc
WHERE to_tsvector('russian',cc.ru||' '||cc.en||' '||cc.zh) @@ websearch_to_tsquery('russian',:q) 
order by ts_rank(to_tsvector('russian',cc.ru||' '||cc.en||' '||cc.zh), websearch_to_tsquery('russian',:q)) desc
LIMIT 20) s1"
                );
                $rows = $command->queryAll(true,
                  [
                    ':q' => $transQ,
                  ]
                );
            }
            $duplicatesArray = [];
            foreach ($rows as $row) {
                $params = [];
                $params['type'] = $row['type'];
                $params['cid'] = $row['cid'];
                $params['query'] = $row['query'];
                if (!isset($duplicatesArray[$row[$lang]])) {
                    $res = $res . $row[$lang] . '|' . $row['res_count'] . '|' . json_encode($params) . "\n";
                }
                $duplicatesArray[$row[$lang]] = true;
            }
            return $res;
        } catch (Exception $e) {
            return '';
        }
    }

    public static function transkey($s)
    {
        /*Символы для замены на русские*/
        $arrReplace = [
          'q' => 'й',
          'w' => 'ц',
          'e' => 'у',
          'r' => 'к',
          't' => 'е',
          'y' => 'н',
          'u' => 'г',
          'i' => 'ш',
          'o' => 'щ',
          'p' => 'з',
          '[' => 'х',
          ']' => 'ъ',
          'a' => 'ф',
          's' => 'ы',
          'd' => 'в',
          'f' => 'а',
          'g' => 'п',
          'h' => 'р',
          'j' => 'о',
          'k' => 'л',
          'l' => 'д',
          ';' => 'ж',
          "'" => 'э',
          'z' => 'я',
          'x' => 'ч',
          'c' => 'с',
          'v' => 'м',
          'b' => 'и',
          'n' => 'т',
          'm' => 'ь',
          ',' => 'б',
          '.' => 'ю',
          '/' => '.',
          '`' => 'ё',
          'Q' => 'Й',
          'W' => 'Ц',
          'E' => 'У',
          'R' => 'К',
          'T' => 'Е',
          'Y' => 'Н',
          'U' => 'Г',
          'I' => 'Ш',
          'O' => 'Щ',
          'P' => 'З',
          '{' => 'Х',
          '}' => 'Ъ',
          'A' => 'Ф',
          'S' => 'Ы',
          'D' => 'В',
          'F' => 'А',
          'G' => 'П',
          'H' => 'Р',
          'J' => 'О',
          'K' => 'Л',
          'L' => 'Д',
          ':' => 'Ж',
          '"' => 'Э',
          '|' => '/',
          'Z' => 'Я',
          'X' => 'Ч',
          'C' => 'С',
          'V' => 'М',
          'B' => 'И',
          'N' => 'Т',
          'M' => 'Ь',
          '<' => 'Б',
          '>' => 'Ю',
          '?' => ',',
          '~' => 'Ё',
          '@' => '"',
          '#' => '№',
          '$' => ';',
          '^' => ':',
          '&' => '?',
        ];
        /*Меняем ключ со значением в массиве $arrReplace*/
        $arrReplace2 = array_flip($arrReplace);
        /*Удаляем некоторые символы*/
        unset($arrReplace2['.']);
        unset($arrReplace2[',']);
        unset($arrReplace2[';']);
        unset($arrReplace2['"']);
        unset($arrReplace2['?']);
        unset($arrReplace2['/']);
        /*И соединяем массивы в один*/
        $arrReplace = array_merge($arrReplace, $arrReplace2);
        return strtr($s, $arrReplace);
    }
}