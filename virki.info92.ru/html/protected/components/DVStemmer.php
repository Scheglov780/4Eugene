<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://mall92.ru
 * Copyright (C) 2013-2020, mall92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DVStemmer.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

class DVStemmer
{
    //private static $VOWEL = '/аеиоуыэюя/';
    private static $ADJECTIVE = '/(ее|ие|ые|ое|ими|ыми|ей|ий|ый|ой|ем|им|ым|ом|его|ого|ему|ому|их|ых|ую|юю|ая|яя|ою|ею)$/u';
    private static $DERIVATIONAL = '/[^аеиоуыэюя][аеиоуыэюя]+[^аеиоуыэюя]+[аеиоуыэюя].*(?<=о)сть?$/u';
    private static $NOUN = '/(а|ев|ов|ие|ье|е|иями|ями|ами|еи|ии|и|ией|ей|ой|ий|й|иям|ям|ием|ем|ам|ом|о|у|ах|иях|ях|ы|ь|ию|ью|ю|ия|ья|я)$/u';
    private static $PARTICIPLE = '/((ивш|ывш|ующ)|((?<=[ая])(ем|нн|вш|ющ|щ)))$/u';
    private static $PERFECTIVEGROUND = '/((ив|ивши|ившись|ыв|ывши|ывшись)|((?<=[ая])(в|вши|вшись)))$/u';
    private static $REFLEXIVE = '/(с[яь])$/u';
    private static $RVRE = '/^(.*?[аеиоуыэюя])(.*)$/u';
    private static $VERB = '/((ила|ыла|ена|ейте|уйте|ите|или|ыли|ей|уй|ил|ыл|им|ым|ен|ило|ыло|ено|ят|ует|уют|ит|ыт|ены|ить|ыть|ишь|ую|ю)|((?<=[ая])(ла|на|ете|йте|ли|й|л|ем|н|ло|но|ет|ют|ны|ть|ешь|нно)))$/u';

    function match($source, $rule)
    {
        return preg_match($rule, $source);
    }

    private static function replace(&$source, $rule, $to)
    {
        $orig = $source;
        $source = preg_replace($rule, $to, $source);
        return $orig !== $source;
    }

    public static function stemText(&$text)
    {
        // Split words from noise and remove apostrophes
        $words = $text;
//  $words = strtr($words, 'ё','е');

        $words = preg_split(
          '/([^a-zA-ZабвгдежзийклмнопрстуфхцчшщьыъэюяАБВГДЕЖЗИЙКЛМНОПРСТУФХЦЧШЩЬЫЪЭЮЯ]+)/u',
          str_replace("'", '', $words),
          -1,
          PREG_SPLIT_DELIM_CAPTURE
        );

        // Process each word
        $odd = true;
        foreach ($words as $k => $word) {
            if ($odd) {
                $words[$k] = self::stemWord($word);
            }
            $odd = !$odd;
        }

        // Put it all back together
        return implode('', $words);
    }

    public static function stemWord($word)
    {
        $word = strtolower($word);
//        $word = strtr($word, 'ё', 'е');
        $stem = $word;
        do {
            if (!preg_match(self::$RVRE, $word, $matches)) {
                break;
            }
            $start = $matches[1];
            $RV = $matches[2];
            if (!$RV) {
                break;
            }

            # Step 1
            if (!self::replace($RV, self::$PERFECTIVEGROUND, '')) {
                self::replace($RV, self::$REFLEXIVE, '');

                if (self::replace($RV, self::$ADJECTIVE, '')) {
                    self::replace($RV, self::$PARTICIPLE, '');
                } else {
                    if (!self::replace($RV, self::$VERB, '')) {
                        self::replace($RV, self::$NOUN, '');
                    }
                }
            }

            # Step 2
            self::replace($RV, '/и$/u', '');

            # Step 3
            if (self::match($RV, self::$DERIVATIONAL)) {
                self::replace($RV, '/ость?$/u', '');
            }

            # Step 4
            if (!self::replace($RV, '/ь$/u', '')) {
                self::replace($RV, '/ейше?/u', '');
                self::replace($RV, '/нн$/u', 'н');
            }

            $stem = $start . $RV;
        } while (false);
        return $stem;
    }
}

