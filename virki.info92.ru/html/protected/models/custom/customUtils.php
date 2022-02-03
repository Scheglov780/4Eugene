<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Utils.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

class customUtils
{
    /** Формат работы curl с SSL
     *    CURL_SSLVERSION_DEFAULT 0
     *    CURL_SSLVERSION_TLSv1 1
     *    CURL_SSLVERSION_SSLv2 2
     *    CURL_SSLVERSION_SSLv3 3
     *    CURL_SSLVERSION_TLSv1_0 4
     *    CURL_SSLVERSION_TLSv1_1 5
     *    CURL_SSLVERSION_TLSv1_2 6
     *    CURL_SSLVERSION_TLSv1_3 7
     * @var int
     */
    private static $CURL_SSLVERSION = 0;
    private static $alpha2alpha3Array = [
      'AF' => 'AFG',
      'AX' => 'ALA',
      'AL' => 'ALB',
      'DZ' => 'DZA',
      'AS' => 'ASM',
      'AD' => 'AND',
      'AO' => 'AGO',
      'AI' => 'AIA',
      'AQ' => 'ATA',
      'AG' => 'ATG',
      'AR' => 'ARG',
      'AM' => 'ARM',
      'AW' => 'ABW',
      'AU' => 'AUS',
      'AT' => 'AUT',
      'AZ' => 'AZE',
      'BS' => 'BHS',
      'BH' => 'BHR',
      'BD' => 'BGD',
      'BB' => 'BRB',
      'BY' => 'BLR',
      'BE' => 'BEL',
      'BZ' => 'BLZ',
      'BJ' => 'BEN',
      'BM' => 'BMU',
      'BT' => 'BTN',
      'BO' => 'BOL',
      'BA' => 'BIH',
      'BW' => 'BWA',
      'BV' => 'BVT',
      'BR' => 'BRA',
      'IO' => 'IOT',
      'BN' => 'BRN',
      'BG' => 'BGR',
      'BF' => 'BFA',
      'BI' => 'BDI',
      'KH' => 'KHM',
      'CM' => 'CMR',
      'CA' => 'CAN',
      'CV' => 'CPV',
      'KY' => 'CYM',
      'CF' => 'CAF',
      'TD' => 'TCD',
      'CL' => 'CHL',
      'CN' => 'CHN',
      'CX' => 'CXR',
      'CC' => 'CCK',
      'CO' => 'COL',
      'KM' => 'COM',
      'CG' => 'COG',
      'CD' => 'COD',
      'CK' => 'COK',
      'CR' => 'CRI',
      'CI' => 'CIV',
      'HR' => 'HRV',
      'CU' => 'CUB',
      'CY' => 'CYP',
      'CZ' => 'CZE',
      'DK' => 'DNK',
      'DJ' => 'DJI',
      'DM' => 'DMA',
      'DO' => 'DOM',
      'EC' => 'ECU',
      'EG' => 'EGY',
      'SV' => 'SLV',
      'GQ' => 'GNQ',
      'ER' => 'ERI',
      'EE' => 'EST',
      'ET' => 'ETH',
      'FK' => 'FLK',
      'FO' => 'FRO',
      'FJ' => 'FJI',
      'FI' => 'FIN',
      'FR' => 'FRA',
      'GF' => 'GUF',
      'PF' => 'PYF',
      'TF' => 'ATF',
      'GA' => 'GAB',
      'GM' => 'GMB',
      'GE' => 'GEO',
      'DE' => 'DEU',
      'GH' => 'GHA',
      'GI' => 'GIB',
      'GR' => 'GRC',
      'GL' => 'GRL',
      'GD' => 'GRD',
      'GP' => 'GLP',
      'GU' => 'GUM',
      'GT' => 'GTM',
      'GG' => 'GGY',
      'GN' => 'GIN',
      'GW' => 'GNB',
      'GY' => 'GUY',
      'HT' => 'HTI',
      'HM' => 'HMD',
      'VA' => 'VAT',
      'HN' => 'HND',
      'HK' => 'HKG',
      'HU' => 'HUN',
      'IS' => 'ISL',
      'IN' => 'IND',
      'ID' => 'IDN',
      'IR' => 'IRN',
      'IQ' => 'IRQ',
      'IE' => 'IRL',
      'IM' => 'IMN',
      'IL' => 'ISR',
      'IT' => 'ITA',
      'JM' => 'JAM',
      'JP' => 'JPN',
      'JE' => 'JEY',
      'JO' => 'JOR',
      'KZ' => 'KAZ',
      'KE' => 'KEN',
      'KI' => 'KIR',
      'KP' => 'PRK',
      'KR' => 'KOR',
      'KW' => 'KWT',
      'KG' => 'KGZ',
      'LA' => 'LAO',
      'LV' => 'LVA',
      'LB' => 'LBN',
      'LS' => 'LSO',
      'LR' => 'LBR',
      'LY' => 'LBY',
      'LI' => 'LIE',
      'LT' => 'LTU',
      'LU' => 'LUX',
      'MO' => 'MAC',
      'MK' => 'MKD',
      'MG' => 'MDG',
      'MW' => 'MWI',
      'MY' => 'MYS',
      'MV' => 'MDV',
      'ML' => 'MLI',
      'MT' => 'MLT',
      'MH' => 'MHL',
      'MQ' => 'MTQ',
      'MR' => 'MRT',
      'MU' => 'MUS',
      'YT' => 'MYT',
      'MX' => 'MEX',
      'FM' => 'FSM',
      'MD' => 'MDA',
      'MC' => 'MCO',
      'MN' => 'MNG',
      'ME' => 'MNE',
      'MS' => 'MSR',
      'MA' => 'MAR',
      'MZ' => 'MOZ',
      'MM' => 'MMR',
      'NA' => 'NAM',
      'NR' => 'NRU',
      'NP' => 'NPL',
      'NL' => 'NLD',
      'AN' => 'ANT',
      'NC' => 'NCL',
      'NZ' => 'NZL',
      'NI' => 'NIC',
      'NE' => 'NER',
      'NG' => 'NGA',
      'NU' => 'NIU',
      'NF' => 'NFK',
      'MP' => 'MNP',
      'NO' => 'NOR',
      'OM' => 'OMN',
      'PK' => 'PAK',
      'PW' => 'PLW',
      'PS' => 'PSE',
      'PA' => 'PAN',
      'PG' => 'PNG',
      'PY' => 'PRY',
      'PE' => 'PER',
      'PH' => 'PHL',
      'PN' => 'PCN',
      'PL' => 'POL',
      'PT' => 'PRT',
      'PR' => 'PRI',
      'QA' => 'QAT',
      'RE' => 'REU',
      'RO' => 'ROU',
      'RU' => 'RUS',
      'RW' => 'RWA',
      'SH' => 'SHN',
      'KN' => 'KNA',
      'LC' => 'LCA',
      'PM' => 'SPM',
      'VC' => 'VCT',
      'WS' => 'WSM',
      'SM' => 'SMR',
      'ST' => 'STP',
      'SA' => 'SAU',
      'SN' => 'SEN',
      'RS' => 'SRB',
      'SC' => 'SYC',
      'SL' => 'SLE',
      'SG' => 'SGP',
      'SK' => 'SVK',
      'SI' => 'SVN',
      'SB' => 'SLB',
      'SO' => 'SOM',
      'ZA' => 'ZAF',
      'SS' => 'SSD',
      'GS' => 'SGS',
      'ES' => 'ESP',
      'LK' => 'LKA',
      'SD' => 'SDN',
      'SR' => 'SUR',
      'SJ' => 'SJM',
      'SZ' => 'SWZ',
      'SE' => 'SWE',
      'CH' => 'CHE',
      'SY' => 'SYR',
      'TW' => 'TWN',
      'TJ' => 'TJK',
      'TZ' => 'TZA',
      'TH' => 'THA',
      'TL' => 'TLS',
      'TG' => 'TGO',
      'TK' => 'TKL',
      'TO' => 'TON',
      'TT' => 'TTO',
      'TN' => 'TUN',
      'TR' => 'TUR',
      'TM' => 'TKM',
      'TC' => 'TCA',
      'TV' => 'TUV',
      'UG' => 'UGA',
      'UA' => 'UKR',
      'AE' => 'ARE',
      'GB' => 'GBR',
      'US' => 'USA',
      'UM' => 'UMI',
      'UY' => 'URY',
      'UZ' => 'UZB',
      'VU' => 'VUT',
      'VE' => 'VEN',
      'VN' => 'VNM',
      'VG' => 'VGB',
      'VI' => 'VIR',
      'WF' => 'WLF',
      'EH' => 'ESH',
      'YE' => 'YEM',
      'ZM' => 'ZMB',
      'ZW' => 'ZWE',
    ];
    protected static $_curlObject = false;

    private static function getRemoteHost($Ip = false)
    {
        if (!$Ip) {
            $_ip = static::getRemoteIp();
        } else {
            $_ip = $Ip;
        }
        $host = gethostbyaddr($_ip);
        if (!$host || ($host == $_ip)) {
            return null;
        }
        return $host;
    }

    private static function getRemoteHostWithDNS($ip, $dns = '127.0.0.1', $timeout = 7)
    {
        // random transaction number (for routers etc to get the reply back)
        $data = rand(0, 99);
        // trim it to 2 bytes
        $data = substr($data, 0, 2);
        // request header
        $data .= "\1\0\0\1\0\0\0\0\0\0";
        // split IP up
        $bits = explode(".", $ip);
        // error checking
        if (count($bits) != 4) {
            return null;
        }
        // there is probably a better way to do this bit...
        // loop through each segment
        for ($x = 3; $x >= 0; $x--) {
            // needs a byte to indicate the length of each segment of the request
            switch (strlen($bits[$x])) {
                case 1: // 1 byte long segment
                    $data .= "\1";
                    break;
                case 2: // 2 byte long segment
                    $data .= "\2";
                    break;
                case 3: // 3 byte long segment
                    $data .= "\3";
                    break;
                default: // segment is too big, invalid IP
                    return null;
            }
            // and the segment itself
            $data .= $bits[$x];
        }
        // and the final bit of the request
        $data .= "\7in-addr\4arpa\0\0\x0C\0\1";
        // create UDP socket
        $handle = @fsockopen("udp://$dns", 53);
        // send our request (and store request size so we can cheat later)
        $requestsize = @fwrite($handle, $data);

        @socket_set_timeout($handle, $timeout);
        // hope we get a reply
        $response = @fread($handle, 1000);
        @fclose($handle);
        if ($response == "") {
            return $ip;
        }
        // find the response type
        $type = @unpack("s", substr($response, $requestsize + 2));
        if ($type[1] == 0x0C00)  // answer
        {
            // set up our variables
            $host = "";
            $len = 0;
            // set our pointer at the beginning of the hostname
            // uses the request size from earlier rather than work it out
            $position = $requestsize + 12;
            // reconstruct hostname
            do {
                // get segment size
                $len = unpack("c", substr($response, $position));
                // null terminated string, so length 0 = finished
                if ($len[1] == 0) // return the hostname, without the trailing .
                {
                    return substr($host, 0, strlen($host) - 1);
                }
                // add segment to our host
                $host .= substr($response, $position + 1, $len[1]) . ".";
                // move pointer on to the next segment
                $position += $len[1] + 1;
            } while ($len != 0);
            // error - return the hostname we constructed (without the . on the end)
            return null; //$ip
        }
        return null; //$ip
    }

    /**
     * Служебная функция.
     * Выполняет запрос, обрабатывая редиректы.
     * Есть параметр CURLOPT_FOLLOWLOCATION, который нельзя применять в safe_mode
     * или когда задано open_basedir. Эта функция полвзояет обойти данное ограничение
     **/
    protected static function download( /*resource*/
      $ch, /*int*/
      $maxredirect = null
    ) {
        $mr = $maxredirect === null ? 20 : intval($maxredirect);
        $open_basedir = ini_get('open_basedir');
        //TODO: php7 Alexys Deprecated
        $safe_mode = false;//ini_get('safe_mode');
        if (($open_basedir == '') && (in_array($safe_mode, ['0', 'Off', '']))) {
            curl_setopt($ch, CURLOPT_MAXREDIRS, $mr);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $mr > 0);
        } else {
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
            if ($mr > 0) {
                $newurl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
                $originalUrl = $newurl;
                $rch = curl_copy_handle($ch);
                curl_setopt($rch, CURLOPT_HEADER, true);
                curl_setopt($rch, CURLOPT_NOBODY, true);
                curl_setopt($rch, CURLOPT_FORBID_REUSE, false);
                curl_setopt($rch, CURLOPT_RETURNTRANSFER, true);
                do {
                    curl_setopt($rch, CURLOPT_URL, $newurl);
                    $header = curl_exec($rch);
                    if (curl_errno($rch)) {
                        $code = 0;
                    } else {
                        $code = curl_getinfo($rch, CURLINFO_HTTP_CODE);
                        if ($code == 301 || $code == 302) {
                            preg_match('/Location:(.*?)[\n\r]/i', $header, $matches);
                            $url = trim(array_pop($matches));
                            if (preg_match('/http[s]*:\/\/.+?(?=\/)/i', $url)) {
                                $newurl = $url;
                            } else {
                                preg_match('/http[s]*:\/\/.+?(?=\/)/i', $newurl, $m);
                                $newurl = trim(array_pop($m)) . $url;
                            }
                        } else {
                            $code = 0;
                        }
                    }
                } while ($code && --$mr);
                curl_close($rch);
                if (!$mr) {
                    if ($maxredirect === null) {
                        trigger_error(
                          'Too many redirects. When following redirects, libcurl hit the maximum amount.',
                          E_USER_WARNING
                        );
                    }
                    return false;
                }
                $debug = DSConfig::getVal('site_debug') == 1;
                if ($debug) {
                    echo '<div>';
                    echo '<pre>' . $originalUrl . '</pre>';
                }
                if ($debug) {
                    echo '</div>';
                }
                curl_setopt($ch, CURLOPT_URL, $newurl);
            }
        }
        $execRes = curl_exec($ch);
        if (curl_errno($ch) > 0) {
            //throw new CHttpException(500, curl_error($ch));
            $err = curl_error($ch);
            return $execRes;
        }
        return $execRes;
    }

    protected static function getTanslationArrayHash($translationsArray)
    {
        return md5(print_r($translationsArray, true));
    }

    /**
     * Склоняем словоформу
     */
    protected static function morph($n, $f1, $f2, $f5)
    {
        $n = abs(intval($n)) % 100;
        if ($n > 10 && $n < 20) {
            return $f5;
        }
        $n = $n % 10;
        if ($n > 1 && $n < 5) {
            return $f2;
        }
        if ($n == 1) {
            return $f1;
        }
        return $f5;
    }

    public static function ARtoXMLnode($model, $attribute)
    {
        if (is_a($model, 'CActiveRecord')) {
            $labels = $model->attributeLabels();
            $label = isset($labels[$attribute]) ? $labels[$attribute] : '';
        } else {
            $label = '';
        }
        $begin = '<' . $attribute
          . ' title="'
          . $label
          . '"'
          . '>';
        $end = '</' . $attribute . '>';
        if (is_array($model) && isset($model[$attribute])) {
            $res = $model[$attribute];
        } elseif (isset($model->$attribute)) {
            $res = $model->$attribute;
        } else {
            $res = '';
        }
        if (preg_match("/[<>&\\\]/s", $res, $m) != 0) {
            $res = '<![CDATA[' . $res . ']]>';
        }
        return $begin . $res . $end . "\n";
    }

    public static function alpha2toAlpha3($alpha2)
    {
        if (isset(self::$alpha2alpha3Array[strtoupper($alpha2)])) {
            return self::$alpha2alpha3Array[strtoupper($alpha2)];
        } else {
            return $alpha2;
        }
    }

    public static function alpha3toAlpha2($alpha3)
    {
        $found = array_search(strtoupper($alpha3), self::$alpha2alpha3Array);
        if ($found) {
            return $found;
        } else {
            return $alpha3;
        }
    }

//==================================================================

    public static function appLang()
    {
        return Yii::app()->language;
    }

//==================================================================

    public static function array2string(array $array)
    {
        $result = '';
        foreach ($array as $record) {
            if (is_string($record)) {
                $result = $result . '-' . $record;
            } elseif (is_numeric($record)) {
                $result = $result . '-' . $record;
            } elseif (is_bool($record)) {
                $result = $result . '-' . ($record ? 'true' : 'false');
            } elseif (is_null($record)) {
                $result = $result . '-null';
            } else {
                $result = $result . '-' . md5(CVarDumper::dumpAsString($record));
            }
        }
        return trim($result, '-');
    }

    public static function clearSqlInjections($str)
    {
        //TODO: php7 Alexys Deprecated
        if (false && function_exists('mysqli_escape_string')) {
            //TODO: php7Alexys Deprecated
            return mysqli_escape_string($str);
        } else {
            return trim(Yii::app()->db->quoteValue($str), "'");
        }
    }

    public static function closeCurl()
    {
        if (gettype(self::$_curlObject) == 'resource') {
            curl_close(self::$_curlObject);
            Profiler::message('curl', 'closed');
        }
    }
//===============================================================================
// CURL functions
//===============================================================================

    public static function debugLog($val)
    {
        try {
            $res = Yii::app()->db->createCommand(
              "INSERT INTO debug_log (\"date\",val)
                  VALUES (Now(),:val)"
            )->execute([':val' => $val]);
        } catch (Exception $e) {
            return;
        }
    }

    public static function detectSearchLanguageForSql($text)
    {
        return 'ru';
        if (!$text) {
            return 'en';
        }
        if (preg_match("/[" . DSGParserClass::pcreCharsetChinese . "]{1}/u", $text)) {
            $result = 'zh';
        } elseif (preg_match("/[а-яА-Я]{1}/iu", $text)) {
            $result = 'ru';
        } else {
            $result = 'en';
        }
        return $result;
    }

    public static function formatDeviceValue($value, $asHtml = true)
    {
        return preg_replace(
          '/^(0*)(\d+)\.(\d+)$/is',
          '<span>\1</span><span>\2</span><span>,</span><span>\3</span>',
          sprintf('%014.3f', $value)
        );
    }

    public static function fullNameWithInitials($fullName)
    {
        $result = preg_replace(
          '/^.*?([a-zа-я\-]+)[\.,\s]+([a-zа-я]{0,1})[a-zа-я]*[\.,\s]*([a-zа-я]{0,1})[a-zа-я]*.*$/isu',
          '\1 \2.\3.',
          $fullName
        );
        $result = trim($result);
        //$result = ucwords($result);
        if (!$result) {
            $result = preg_replace(
              '/^.*?([a-zа-я\-]+).*$/isu',
              '\1',
              $fullName
            );
        }
        return $result;
    }

    public static function geoIP($ip = false)
    {
        try {
            $SxGeo = new SxGeo(Yii::getPathOfAlias('application.components') . '/SxGeoCity.dat');
            if (!$ip) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $result = $SxGeo->getCityFull($ip); // Вся информация о городе
//        $res= $SxGeo->about();          // Информация о базе данных
            unset($SxGeo);
            return $result;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function geoIPCity($ip = false)
    {
        try {
            $SxGeo = new SxGeo(Yii::getPathOfAlias('application.components') . '/SxGeoCity.dat');
            if (!$ip) {
                $ip = $_SERVER['REMOTE_ADDR'];
            }
            $result = $SxGeo->getCityFull($ip); // Вся информация о городе
//        $res= $SxGeo->about();          // Информация о базе данных
            unset($SxGeo);
            if (isset($result['city']['name_ru'])) {
                return $result['city']['name_ru'];
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public static function geoSEOCity()
    {
        $result = false;
        $countries = DSConfig::getVal('seo_geo_targeting_countries');
        if (!$countries) {
            return $result;
        }
        $countries = explode(',', $countries);
        foreach ($countries as $i => $country) {
            $countries[$i] = "'" . trim($country) . "'";
        }
        $countries = implode(',', $countries);
        if ($countries === '') {
            $countries = 'null';
        }
        if ((preg_match('/bot|\+http/i', Yii::app()->request->userAgent) && Yii::app()->user->isGuest)) {
            $hexHash = substr(md5(DSConfig::getVal('site_domain') . Yii::app()->request->requestUri), 1, 5);
            $integerHash = hexdec($hexHash);
            $cities = Yii::app()->db->createCommand(
              "select city from geo_cities where country in ({$countries}) order by city"
            )->queryColumn();
            if ($cities) {
                $count = count($cities);
                $cityNumber = $integerHash % $count;
                $result = $cities[$cityNumber];
            }
        } else {
            $result = self::geoIPCity();
        }
        return $result;
    }

    public static function geoSEOCityText()
    {
        $city = self::geoSEOCity();
        if ($city) {
            $xml = simplexml_load_string(DSConfig::getVal('seo_geo_targeting_rules'), null, LIBXML_NOCDATA);
            $langVal = self::appLang();
            $result = new stdClass();
            if (isset($xml->{$langVal})) {
                $cmd = (string) $xml->{$langVal}->description;
                $result->description = @eval($cmd);
                $cmd = (string) $xml->{$langVal}->keywords;
                $result->keywords = @eval($cmd);
            }

        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * Возвращает ресурс curl c базовыми настройкми
     **/
    public static function getCurl(
      $path,
      $referer = '',
      $cacheKey = null
    ) {
        $_path = DSGDownloader::normalizeUrl($path);
        try {
            if (gettype(self::$_curlObject) != 'resource') {
                $ch = curl_init($_path);
                Profiler::message('curl', 'new');
                self::$_curlObject = $ch;
            } else {
                $ch = self::$_curlObject;
                Profiler::message('curl', 'reuse');
                curl_setopt($ch, CURLOPT_URL, $_path);
            }
            curl_setopt(
              $ch,
              CURLOPT_USERAGENT,
              'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.113 Safari/537.36'
            );
            curl_setopt($ch, CURLINFO_HEADER_OUT, true);
//      curl_setopt($ch, CURLOPT_HEADER, TRUE); // Ото ж выводить ли хэдер в контент
            curl_setopt($ch, CURLOPT_ENCODING, ''); //gzip,deflate
            //curl_setopt($ch, CURLOPT_ENCODING, '');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_TIMEOUT, (int) DSConfig::getValDef('curl_timeout_default', 30));//120
            curl_setopt($ch, CURLOPT_FORBID_REUSE, false);
// Speed-up
//      curl_setopt($ch, CURLOPT_TCP_NODELAY, TRUE);
            curl_setopt($ch, CURLOPT_NOPROGRESS, true);
            curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, (YII_DEBUG ? 120 : 3600));
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            if (defined('CURLOPT_CERTINFO')) {
                curl_setopt($ch, CURLOPT_CERTINFO, false);
            }
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, false);
            //curl_setopt($ch, CURLOPT_TCP_NODELAY, false);
//      curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
//---------
            curl_setopt($ch, CURLOPT_COOKIEJAR, '/dev/null');
            curl_setopt($ch, CURLOPT_SSLVERSION, self::$CURL_SSLVERSION);//CURL_SSLVERSION_DEFAULT
            $headers = ["Referer: " . $referer];
            if (preg_match('/(?:\&(?:ajax|json)=)/i', $_path)) {
                $headers[] = "X-Requested-With: XMLHttpRequest";
            }
            $headers[] = "Connection: keep-alive";
            $headers[] = "Keep-Alive: 30";
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            return $ch;
        } catch (Exception $e) {
            throw new Exception (500, 'System error: curl not installed or inited.');
        }
    }

    public static function getCurrencyRatesFromBank($cur = false)
    {
        $autoUpdate = DSConfig::getVal('rates_auto_update') && ((time() - DSConfig::getVal(
                'rates_auto_update_last_time'
              )) > 60 * 60 * 8);
//  http://www.cbr.ru/scripts/XML_daily_eng.asp?date_req='||TO_CHAR(sysdate,'dd/mm/yyyy')
        $cache = @Yii::app()->fileCache->get('currency-rates-from-bank');
        if (($cache == false)) {
            //http://www.cbr.ru/scripts/XML_daily_eng.asp?date_req=24/12/2013
            $resp = self::getHttpDocument('http://www.cbr.ru/scripts/XML_daily_eng.asp?date_req=' . date("d/m/Y"));
            $res = [];
            if (isset($resp->body) && ($resp->body != false)) {
                $resp_xml = @simplexml_load_string($resp->body);
                if (isset($resp_xml->Valute)) {
                    foreach ($resp_xml->Valute as $val) {
                        $res[strtolower((string) $val->CharCode)] = (float) str_replace(
                            ",",
                            ".",
                            (string) $val->Value
                          ) / (float) $val->Nominal;
                    }
                }
                @Yii::app()->fileCache->set('currency-rates-from-bank', $res, 60 * 60);
            }
        } else {
            $res = $cache;
        }
        $confLastUpd = DSConfig::model()->findByPk('rates_auto_update_last_time');
        $confLastUpd->value = time();
        $confLastUpd->update();
        if (is_array($res) && (count($res) > 0)) {
            if (!$cur) {
                if ($autoUpdate) {
                    $rates_auto_base_currency_margin = DSConfig::getVal('rates_auto_base_currency_margin');
                    $rates_auto_site_currency_margin = DSConfig::getVal('rates_auto_site_currency_margin');
                    $site_currency = DSConfig::getVal('site_currency');

                    foreach ($res as $currName => $curr) {
                        $confCurr = DSConfig::model()->findByPk('rate_' . $currName);
                        if ($confCurr) {
                            if ($curr != 1 && $rates_auto_base_currency_margin != 1) {
                                $curr = $curr * $rates_auto_base_currency_margin;
                            }
                            if ($currName == $site_currency && $rates_auto_site_currency_margin != 1) {
                                $curr = $curr * $rates_auto_site_currency_margin;
                            }
                            $confCurr->value = $curr;
                            $confCurr->update();
                        }
                    }
                }
                return $res;
            } else {
                if (isset($res[str_replace('rate_', '', $cur)])) {
                    return $res[str_replace('rate_', '', $cur)];
                } else {
                    return 1;
                }
            }
        } else {
            return 1;
        }
    }

    /**
     * Returns contextual URL to wiki.
     * $id must to start with ':'
     * @param string $id $id must to start with ':'
     * @return string
     * @throws CDbException
     */
    public static function getHelp($id, $asHtml = false)
    {
        $url = preg_replace('/\?.*/', '', Yii::app()->request->getRequestUri()) . '/' . $id;
        $url = preg_replace('/\/\d+/', '', $url);
        $url = preg_replace('/\/+/', ':', $url);
        if (!preg_match('/^:/', $url)) {
            $url = ':' . $url;
        }
        $result = DSConfig::getVal('support_wiki_base_url') . $url;
        if ($asHtml) {
            $result = '<a class="btn pull-right" href="' . $result . '" target="_blank" 
            title="' . Yii::t('admin', 'Справка') . '"><i class="fa fa-question"></i></a>';
        }
        return $result;
        /*
        echo "<span class='get-help'><a href='javascript:void(0);' onclick='helpGoTo(\"" . $url . "\",true); return false;' title='" . Yii::t(
            'main',
            'Справка'
          ) . "'><i class='fa fa-question-circle'></i></a></span>";
        */
    }

    /**
     * Возвращает содержимое внешнего файла
     **/
    public static function getHttpDocument($path, $decode = false)
    {
        $ch = self::getCurl($path);
        $ret = self::download($ch, 20);
        $res = new stdClass();
        $res->info = curl_getinfo($ch);
        if ($res->info['http_code'] >= 400) {
            if (isset($ret)) {
                $res->body = $ret;
            } else {
                $res->body = false;
            }
        } else {
            try {
                $res->body = ($decode) ? @iconv('GBK', 'UTF-8//IGNORE', $ret) : $ret;
            } catch (Exception $e) {
                if (isset($ret)) {
                    $res->body = $ret;
                } else {
                    $res->body = false;
                }
            }
        }
        unset ($ret);
        return $res;
    }

    public static function getOriginalFromTranslation($s)
    {
        $t = preg_match('/plain\[\d+\]:\s*(.*?)".*?\>/s', $s, $m);
        if ($t > 0) {
            return $m[1];
        } else {
            return $s;
        }
    }

    public static function getRandomString($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return $string;
    }

    public static function getRemoteHostEx($ip)
    {
        //if (class_exists('UsersHosts', false)) {
        if (is_file(Yii::getPathOfAlias('application.models.UsersHosts') . '.php')) {
            $host = UsersHosts::getRemoteHostWithDB($ip);
        }
        if (!isset($host) || !$host) {
            try {
                if (isset(Yii::app()->memCache)) {
                    $cache = @Yii::app()->memCache->get('getRemoteHostEx-' . $ip);
                } else {
                    $cache = @Yii::app()->cache->get('getRemoteHostEx-' . $ip);
                }

                if (!$cache) {
//            $host = static::getRemoteHost($ip);
//            if (!$host) {
                    $host = static::getRemoteHostWithDNS($ip, $ip);
                    if (!$host) {
                        $host = static::getRemoteHostWithDNS($ip);
                    }
                    if (!$host) {
                        $host = static::getRemoteHost($ip);
                    }
//            }
                    if (isset(Yii::app()->memCache)) {
                        @Yii::app()->memCache->set('getRemoteHostEx-' . $ip, (($host) ? $host : $ip), 300);
                    } else {
                        @Yii::app()->cache->set('getRemoteHostEx-' . $ip, (($host) ? $host : $ip), 300);
                    }
                } else {
                    $host = $cache;
                }
                if (!$host || ($host == $ip)) {
                    return null;
                } else {
                    return $host;
                }
            } catch (Exception $e) {
                return null;
            }
        } else {
            return $host;
        }
    }

    public static function getRemoteIp()
    {
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $remoteIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
            $remoteIP = $_SERVER['HTTP_X_REAL_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR']) and isset($_SERVER['HTTP_CLIENT_IP'])) {
            $remoteIP = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $remoteIP = $_SERVER['REMOTE_ADDR'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $remoteIP = $_SERVER['HTTP_CLIENT_IP'];
        } else {
            $remoteIP = Yii::app()->request->userHostAddress;
        }
        if (strstr($remoteIP, ', ')) {
            $ips = explode(', ', $remoteIP);
            $remoteIP = $ips[0];
        }
        return $remoteIP;
    }

    public static function getRemoteTranslation($translationsArray)
    {
        // ==== post and get data to translator ===========================
        $tanslationArrayHash = self::getTanslationArrayHash($translationsArray);
        if (isset(Yii::app()->memCache)) {
            $cache = @Yii::app()->memCache->get('translationArray-' . $tanslationArrayHash);
        } else {
            $cache = @Yii::app()->cache->get('translationArray-' . $tanslationArrayHash);
        }
        if (isset(Yii::app()->request->cookies['reset-translations-cache'])) {
            $resetTranslationCache = true;
            Yii::app()->request->cookies->remove('reset-translations-cache');
        } else {
            $resetTranslationCache = false;
        }
        if (($cache == false) || $resetTranslationCache) { // || Yii::app()->user->notInRole(array('guest', 'user'))
            $translator_block_mode_url = DSConfig::getVal('translator_block_mode_url');
            $url = $translator_block_mode_url;
            //$post = urlencode(convert_uuencode(gzcompress(serialize($translationsArray), 9)));
            $post = urlencode(base64_encode(gzcompress(serialize($translationsArray), 9)));
            $ch = Utils::getCurl($url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_POST, true);
            if (defined('FORCE_XDEBUG')) {
                curl_setopt($ch, CURLOPT_COOKIE, 'XDEBUG_SESSION=Alexy_proxy2');
            }
//=============================
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['translationArray' => $post]);
//===============================================
            $fHeader = fopen('php://temp', 'w+');
            $fBody = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_WRITEHEADER, $fHeader);
            curl_setopt($ch, CURLOPT_FILE, $fBody);
//===============================================
            curl_exec($ch);
            $info = curl_getinfo($ch);
            if (curl_errno($ch) > 0) {
                throw new CHttpException(500, curl_error($ch));
            }
            fseek($fBody, 0);
            $fStat = fstat($fBody);
            $ret = false;
            if ($fStat['size'] > 0) {
                $ret = fread($fBody, $fStat['size']);
            }
//===============================================
            fseek($fHeader, 0);
            $fStat = fstat($fHeader);
            if ($fStat['size'] > 0) {
                $headers = fread($fHeader, $fStat['size']);
                if (preg_match('/Content\-Time:\s*([\d\.\-]+)/i', $headers, $headerVal)) {
                    Profiler::message('Proxy Content-Time', $headerVal[1]);
                }
            }
            fclose($fHeader);
            fclose($fBody);
            unset ($fStat);
//===============================================
            $res = new stdClass();
            $res->info = curl_getinfo($ch);
            if (($res->info['http_code'] >= 400)) {
                if (isset($ret)) {
                    $res->data = $ret;
                } else {
                    $res->data = false;
                }
            } else {
                $res->data = $ret;
            }
            unset ($ret);
            Utils::closeCurl();
            if (isset(Yii::app()->memCache)) {
                @Yii::app()->memCache->set('translationArray-' . $tanslationArrayHash, $res, 600);
            } else {
                @Yii::app()->cache->set('translationArray-' . $tanslationArrayHash, $res, 600);
            }
        } else {
            $res = $cache;
        }
        return $res;
    }

    public static function getRemoteTranslationPlain($query, $from, $to)
    {
        $remoteQuery = [
          [
            0 => Yii::app()->DVTranslator->markupTranslation(
              $query,
              $from,
              $to,
              $query,
              'remote',
              0,
              '',
              false
            ),
          ],
        ];
        $res = self::getRemoteTranslation($remoteQuery);
// ==== end of post and get data to translator ====================
        if (($res->data) && ($res->info['http_code'] < 400)) {
            $translations = unserialize($res->data);
            if (isset($translations[0][1])) {
                $result = $translations[0][1];
            } else {
                $result = $remoteQuery[0][0];
            }
        } else {
            $result = $remoteQuery[0][0];
        }
        $res = self::removeOnlineTranslation($result);
        return $res;
    }

    public static function hex2rgba($color, $opacity = false)
    {
        $default = 'rgb(0,0,0)';

        //Return default if no color provided
        if (empty($color)) {
            return $default;
        }

        //Sanitize $color if "#" is provided
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
            $hex = [$color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5]];
        } elseif (strlen($color) == 3) {
            $hex = [$color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]];
        } else {
            return $default;
        }

        //Convert hexadec to rgb
        $rgb = array_map('hexdec', $hex);

        //Check if opacity is set(rgba or rgb)
        if ($opacity) {
            if (abs($opacity) > 1) {
                $opacity = 1.0;
            }
            $output = 'rgba(' . implode(",", $rgb) . ',' . $opacity . ')';
        } else {
            $output = 'rgb(' . implode(",", $rgb) . ')';
        }

        //Return rgb(a) color string
        return $output;
    }

    public static function isDeveloperIp()
    {
        if (in_array($_SERVER['REMOTE_ADDR'], ['31.28.227.21'])) {
            return true;
        } else {
            return false;
        }
    }

    public static function is_string($val)
    {
        if (
          (!is_array($val)) &&
          ((!is_object($val) && settype($val, 'string') !== false) ||
            (is_object($val) && method_exists($val, '__toString')))
        ) {
            return true;

        } else {
            return false;
        }
    }

    public static function langToCountry($lang)
    {
        $langsData = [
          'ae' => 'ae',
          'am' => 'am',
          'ar' => 'ar',
          'av' => 'av',
          'ay' => 'ay',
          'az' => 'az',
          'ba' => 'ba',
          'be' => 'be',
          'bg' => 'bg',
          'bm' => 'bm',
          'bn' => 'bn',
          'bo' => 'bo',
          'br' => 'br',
          'bs' => 'bs',
          'ca' => 'ca',
          'ce' => 'ce',
          'co' => 'co',
          'cr' => 'cr',
          'cs' => 'cs',
          'cu' => 'cu',
          'cv' => 'cv',
          'cy' => 'cy',
          'da' => 'da',
          'de' => 'de',
          'ee' => 'ee',
          'el' => 'el',
          'en' => 'en',
          'eo' => 'eo',
          'es' => 'es',
          'et' => 'et',
          'eu' => 'eu',
          'fa' => 'fa',
          'fi' => 'fi',
          'fj' => 'fj',
          'fo' => 'fo',
          'fr' => 'fr',
          'fy' => 'fy',
          'ga' => 'ga',
          'gd' => 'gd',
          'gn' => 'gn',
          'gu' => 'gu',
          'gv' => 'gv',
          'ha' => 'ha',
          'he' => 'he',
          'hi' => 'hi',
          'hr' => 'hr',
          'ht' => 'ht',
          'hu' => 'hu',
          'hy' => 'hy',
          'hz' => 'hz',
          'ia' => 'ia',
          'id' => 'id',
          'ie' => 'ie',
          'ig' => 'ig',
          'io' => 'io',
          'is' => 'is',
          'it' => 'it',
          'iu' => 'iu',
          'ja' => 'ja',
          'jv' => 'jv',
          'ka' => 'ka',
          'kk' => 'kk',
          'kl' => 'kl',
          'km' => 'km',
          'kn' => 'kn',
          'ko' => 'ko',
          'kr' => 'kr',
          'ks' => 'ks',
          'ku' => 'ku',
          'kv' => 'kv',
          'ky' => 'ky',
          'la' => 'la',
          'lb' => 'lb',
          'ln' => 'ln',
          'lo' => 'lo',
          'lt' => 'lt',
          'lv' => 'lv',
          'mg' => 'mg',
          'mi' => 'mi',
          'mk' => 'mk',
          'ml' => 'ml',
          'mn' => 'mn',
          'mo' => 'mo',
          'mr' => 'mr',
          'ms' => 'ms',
          'mt' => 'mt',
          'my' => 'mm',
          'na' => 'na',
          'ne' => 'ne',
          'nl' => 'nl',
          'no' => 'no',
          'nv' => 'nv',
          'or' => 'or',
          'os' => 'os',
          'pa' => 'pa',
          'pl' => 'pl',
          'pt' => 'pt',
          'qu' => 'qu',
          'rm' => 'rm',
          'rn' => 'rn',
          'ro' => 'ro',
          'ru' => 'ru',
          'sa' => 'sa',
          'sc' => 'sc',
          'sg' => 'sg',
          'sk' => 'sk',
          'sl' => 'sl',
          'so' => 'so',
          'sq' => 'sq',
          'sr' => 'sr',
          'sv' => 'sv',
          'sw' => 'sw',
          'te' => 'te',
          'tg' => 'tg',
          'th' => 'th',
          'ti' => 'ti',
          'tj' => 'tj',
          'tk' => 'tk',
          'tr' => 'tr',
          'tt' => 'tt',
          'ug' => 'ug',
          'uk' => 'uk',
          'ur' => 'ur',
          'uz' => 'uz',
          'vi' => 'vi',
          'wa' => 'wa',
          'wo' => 'wo',
          'yi' => 'yi',
          'yo' => 'yo',
          'zh' => 'zh',
          'zu' => 'zu',
        ];

        if (isset($langsData[$lang])) {
            return $langsData[$lang];
        }
        return 'ru';
    }

    public static function langToLangName($lang)
    {
        $langsData = [
          'ae' => 'AVE',
          'am' => 'AMH',
          'ar' => 'ARA',
          'av' => 'AVA',
          'ay' => 'AYM',
          'az' => 'AZE',
          'ba' => 'BAK',
          'be' => 'BEL',
          'bg' => 'BUL',
          'bm' => 'BAM',
          'bn' => 'BEN',
          'bo' => 'BOD',
          'br' => 'BRE',
          'bs' => 'BOS',
          'ca' => 'CAT',
          'ce' => 'CHE',
          'co' => 'COS',
          'cr' => 'CRE',
          'cs' => 'CES',
          'cu' => 'CHU',
          'cv' => 'CHV',
          'cy' => 'CYM',
          'da' => 'DAN',
          'de' => 'DEU',
          'ee' => 'EWE',
          'el' => 'ELL',
          'en' => 'ENG',
          'eo' => 'EPO',
          'es' => 'SPA',
          'et' => 'EST',
          'eu' => 'EUS',
          'fa' => 'FAS',
          'fi' => 'FIN',
          'fj' => 'FIJ',
          'fo' => 'FAO',
          'fr' => 'FRA',
          'fy' => 'FRY',
          'ga' => 'GLE',
          'gd' => 'GLA',
          'gn' => 'GRN',
          'gu' => 'GUJ',
          'gv' => 'GLV',
          'ha' => 'HAU',
          'he' => 'HEB',
          'hi' => 'HIN',
          'hr' => 'HRV',
          'ht' => 'HAT',
          'hu' => 'HUN',
          'hy' => 'HYE',
          'hz' => 'HER',
          'ia' => 'INA',
          'id' => 'IND',
          'ie' => 'ILE',
          'ig' => 'IBO',
          'io' => 'IDO',
          'is' => 'ISL',
          'it' => 'ITA',
          'iu' => 'IKU',
          'ja' => 'JPN',
          'jv' => 'JAV',
          'ka' => 'KAT',
          'kk' => 'KAZ',
          'kl' => 'KAL',
          'km' => 'KHM',
          'kn' => 'KAN',
          'ko' => 'KOR',
          'kr' => 'KAU',
          'ks' => 'KAS',
          'ku' => 'KUR',
          'kv' => 'KOM',
          'ky' => 'KIR',
          'la' => 'LAT',
          'lb' => 'LTZ',
          'ln' => 'LIN',
          'lo' => 'LAO',
          'lt' => 'LIT',
          'lv' => 'LAV',
          'mg' => 'MLG',
          'mi' => 'MRI',
          'mk' => 'MKD',
          'ml' => 'MAL',
          'mn' => 'MON',
          'mo' => 'MOL',
          'mr' => 'MAR',
          'ms' => 'MSA',
          'mt' => 'MLT',
          'my' => 'MYA',
          'na' => 'NAU',
          'ne' => 'NEP',
          'nl' => 'NLD',
          'no' => 'NOR',
          'nv' => 'NAV',
          'or' => 'ORI',
          'os' => 'OSS',
          'pa' => 'PAN',
          'pl' => 'POL',
          'pt' => 'POR',
          'qu' => 'QUE',
          'rm' => 'ROH',
          'rn' => 'RUN',
          'ro' => 'RON',
          'ru' => 'RUS',
          'sa' => 'SAN',
          'sc' => 'SRD',
          'sg' => 'SAG',
          'sk' => 'SLK',
          'sl' => 'SLV',
          'so' => 'SOM',
          'sq' => 'ALB',
          'sr' => 'SRP',
          'sv' => 'SWE',
          'sw' => 'SWA',
          'te' => 'TEL',
          'tg' => 'TGK',
          'th' => 'THA',
          'ti' => 'TIR',
          'tj' => 'TJK',
          'tk' => 'TUK',
          'tr' => 'TUR',
          'tt' => 'TAT',
          'ug' => 'UIG',
          'uk' => 'UKR',
          'ur' => 'URD',
          'uz' => 'UZB',
          'vi' => 'VIE',
          'wa' => 'WLN',
          'wo' => 'WOL',
          'yi' => 'YID',
          'yo' => 'YOR',
          'zh' => 'CHS',
          'zu' => 'ZUL',
        ];

        if (isset($langsData[$lang])) {
            return $langsData[$lang];
        }
        return 'RUS';
    }

    /**
     * Возвращает сумму прописью
     * @author runcore
     * @uses   morph(...)
     */
    public static function num2str($num, $lang)
    {
        $nul = Yii::t('main', 'ноль');
        $ten = [
          [
            '',
            Yii::t('main', 'один'),
            Yii::t('main', 'два'),
            Yii::t('main', 'три'),
            Yii::t('main', 'четыре'),
            Yii::t('main', 'пять'),
            Yii::t('main', 'шесть'),
            Yii::t('main', 'семь'),
            Yii::t('main', 'восемь'),
            Yii::t('main', 'девять'),
          ],
          [
            '',
            Yii::t('main', 'одна'),
            Yii::t('main', 'две'),
            Yii::t('main', 'три'),
            Yii::t('main', 'четыре'),
            Yii::t('main', 'пять'),
            Yii::t('main', 'шесть'),
            Yii::t('main', 'семь'),
            Yii::t('main', 'восемь'),
            Yii::t('main', 'девять'),
          ],
        ];
        $a20 = [
          Yii::t('main', 'десять'),
          Yii::t('main', 'одиннадцать'),
          Yii::t('main', 'двенадцать'),
          Yii::t('main', 'тринадцать'),
          Yii::t('main', 'четырнадцать'),
          Yii::t('main', 'пятнадцать'),
          Yii::t('main', 'шестнадцать'),
          Yii::t('main', 'семнадцать'),
          Yii::t('main', 'восемнадцать'),
          Yii::t('main', 'девятнадцать'),
        ];
        $tens = [
          2 => Yii::t('main', 'двадцать'),
          Yii::t('main', 'тридцать'),
          Yii::t('main', 'сорок'),
          Yii::t('main', 'пятьдесят'),
          Yii::t('main', 'шестьдесят'),
          Yii::t('main', 'семьдесят'),
          Yii::t('main', 'восемьдесят'),
          Yii::t('main', 'девяносто'),
        ];
        $hundred = [
          '',
          Yii::t('main', 'сто'),
          Yii::t('main', 'двести'),
          Yii::t('main', 'триста'),
          Yii::t('main', 'четыреста'),
          Yii::t('main', 'пятьсот'),
          Yii::t('main', 'шестьсот'),
          Yii::t('main', 'семьсот'),
          Yii::t('main', 'восемьсот'),
          Yii::t('main', 'девятьсот'),
        ];
        if ($lang == 'ru') {
            $unit = [ // Units
              [Yii::t('main', 'копейка'), Yii::t('main', 'копейки'), Yii::t('main', 'копеек'), 1],
              [Yii::t('main', 'рубль'), Yii::t('main', 'рубля'), Yii::t('main', 'рублей'), 0],
              [Yii::t('main', 'тысяча'), Yii::t('main', 'тысячи'), Yii::t('main', 'тысяч'), 1],
              [Yii::t('main', 'миллион'), Yii::t('main', 'миллиона'), Yii::t('main', 'миллионов'), 0],
              [Yii::t('main', 'миллиард'), Yii::t('main', 'милиарда'), Yii::t('main', 'миллиардов'), 0],
            ];
        } elseif ($lang == 'ua') {
            $unit = [ // Units
              [Yii::t('main', 'копейка'), Yii::t('main', 'копейки'), Yii::t('main', 'копеек'), 1],
              [Yii::t('main', 'грн'), Yii::t('main', 'грн'), Yii::t('main', 'грн'), 0],
              [Yii::t('main', 'тысяча'), Yii::t('main', 'тысячи'), Yii::t('main', 'тысяч'), 1],
              [Yii::t('main', 'миллион'), Yii::t('main', 'миллиона'), Yii::t('main', 'миллионов'), 0],
              [Yii::t('main', 'миллиард'), Yii::t('main', 'милиарда'), Yii::t('main', 'миллиардов'), 0],
            ];
        } else {
            $unit = [ // Units
              [Yii::t('main', 'копейка'), Yii::t('main', 'копейки'), Yii::t('main', 'копеек'), 1],
              [Yii::t('main', 'р.'), Yii::t('main', 'р.'), Yii::t('main', 'р.'), 0],
              [Yii::t('main', 'тысяча'), Yii::t('main', 'тысячи'), Yii::t('main', 'тысяч'), 1],
              [Yii::t('main', 'миллион'), Yii::t('main', 'миллиона'), Yii::t('main', 'миллионов'), 0],
              [Yii::t('main', 'миллиард'), Yii::t('main', 'милиарда'), Yii::t('main', 'миллиардов'), 0],
            ];
        }
        //
        [$rub, $kop] = explode('.', sprintf("%015.2f", floatval($num)));
        $out = [];
        if (intval($rub) > 0) {
            foreach (str_split($rub, 3) as $uk => $v) { // by 3 symbols
                if (!intval($v)) {
                    continue;
                }
                $uk = sizeof($unit) - $uk - 1; // unit key
                $gender = $unit[$uk][3];
                [$i1, $i2, $i3] = array_map('intval', str_split($v, 1));
                // mega-logic
                $out[] = $hundred[$i1]; # 1xx-9xx
                if ($i2 > 1) {
                    $out[] = $tens[$i2] . ' ' . $ten[$gender][$i3];
                } # 20-99
                else {
                    $out[] = $i2 > 0 ? $a20[$i3] : $ten[$gender][$i3];
                } # 10-19 | 1-9
                // units without rub & kop
                if ($uk > 1) {
                    $out[] = self::morph($v, $unit[$uk][0], $unit[$uk][1], $unit[$uk][2]);
                }
            } //foreach
        } else {
            $out[] = $nul;
        }
        $out[] = self::morph(intval($rub), $unit[1][0], $unit[1][1], $unit[1][2]); // rub
        $out[] = $kop . ' ' . self::morph($kop, $unit[0][0], $unit[0][1], $unit[0][2]); // kop
        return trim(preg_replace('/ {2,}/', ' ', join(Yii::t('main', ' '), $out)));
    }

    public static function pgDateToLeftSec($pgDateStr)
    {
        if (!$pgDateStr) {
            return null;
        }
        $dateTimeLeft = new DateTime($pgDateStr);
        $timestamp = (new DateTime())->getTimestamp() - $dateTimeLeft->getTimestamp();
        return $timestamp;
    }

    public static function pgDateToStr($pgDateStr, $format = 'Y-m-d H:i')
    {
        if (!$pgDateStr) {
            return '';
        }
        return date($format, strtotime($pgDateStr));
    }

// Transfered from DSGDownloaderCurl - be patient!!!

    public static function pgIntervalToStr($pgIntervalStr, $pattern = '/:\d{2}[\.]*\d*$/')
    {
        if (!$pgIntervalStr) {
            return '';
        }
        return preg_replace($pattern, '', $pgIntervalStr);
    }

    public static function phonePretty($phone, $callable = false)
    {
        $res = '';
        if ($phone) {
            $res = preg_replace('/(?:\+7|8)(\d{3}?)(\d{3})(\d{2})(\d{2})/is', '+7 $1 $2-$3-$4', $phone);
            if ($callable && $res) {
                $resCallable = preg_replace('/(?:\+7|8)(\d{3}?)(\d{3})(\d{2})(\d{2})/is', '+7-$1-$2-$3-$4', $phone);
                if ($resCallable) {
                    $res = "<a href = \"tel:{$resCallable}\">{$res}</a>";
                }
            }
        }
        if ($res) {
            return $res;
        } else {
            return $phone;
        }
    }

    public static function prepareHtmlTemplate($templateHtml, $templateVars, $prefix = '{', $postfix = '}')
    {
        if (is_array($templateVars)) {
            foreach ($templateVars as $key => $value) {
                if (!is_object($value) && !is_array(
                    $value
                  )
                ) { //TODO: Вот эта проврка на is_array - а с чего бы здесь вобще быть array или object ?
                    $templateHtml = str_replace($prefix . $key . $postfix, (string) $value, $templateHtml);
                }
            }
        }
        return $templateHtml;
    }

    public static function removeOnlineTranslation($s)
    {
        $res = preg_replace(
          '/\<translation.*?\>(.*?)(?:<translate.*?\>.*?<\/translate\>)*\<\/translation\>/is',
          '$1',
          $s
        );
        $res = preg_replace('/\<span.*\>(.*)\<\/span\>/is', '$1', $res);
        $res = trim($res);
        return $res;
    }

    public static function safe($string)
    {
        return $string;
    }

    /**
     * @param string $text   - контент
     * @param int    $length - максимальная длина текста
     * @return mixed|string - подготовленный исходный код контента
     */
    public static function textSnippet($text, $length = 0)
    {
        // http://api.html-tidy.org/tidy/quickref_5.1.25.html
        if (extension_loaded('tidy')) {
            $config = [
              'clean'          => 'yes',
              'output-html'    => 'yes',
              'hide-comments'  => 'yes',
              'show-body-only' => true,
            ];
            $tidy = @tidy_parse_string($text, $config, 'utf8');
            if (isset($tidy) && $tidy) {
                $tidy->cleanRepair();
                if (isset($tidy->value) && $tidy->value) {
                    $text = $tidy->value;
                }
            }
        }
        if ($length > 0) {
            ini_set('pcre.backtrack_limit', 4 * 1024 * 1024);
            ini_set('pcre.recursion_limit', 1024 * 1024);
            $text = preg_replace('/src\s*=\s*["\']\s*data:.*?["\']/isu', 'src=""', $text);
            $path = Yii::getPathOfAlias('application.extensions.simple_html_dom.simple_html_dom') . '.php';
            if (file_exists($path)) {
                include_once($path);
                $Html = @str_get_html($text);
                if ($Html) {
                    $text = $Html->plaintext;
                    if (mb_strlen($text) > $length) {
                        $res = preg_match('/(.{' . $length . ',}?)(?:[><\s]|$)/s', $text, $matches);
                        if ($res) {
                            $text = trim($matches[1]) . '...';
                        }
                    }
                    $Html->clear();
                }
                unset($Html);
            }
            $text = htmlentities($text);
        }
        return $text;
    }

    public static function themePath()
    {
        return Yii::app()->request->baseUrl . '/themes/' . Yii::app()->theme->name;
    }

    public static function transLang($lang = false)
    {
        if ($lang) {
            $l = $lang;
        } else {
            $l = Yii::app()->language;
        }
        if (in_array($l, ['zh', 'en', 'ru'])) { //explode(',',DSConfig::getVal('site_language_supported'))
            return $l;
        } else {
            return 'ru';
        }
    }

    public static function translateFuzzyBrand($s)
    {
        if (!Yii::app()->db->cache(YII_DEBUG ? 0 : 3600)->createCommand(
          "SELECT '1' FROM pg_catalog.pg_tables where schemaname = current_schema () and tablename like 'brands'"
        )->queryRow()) {
            return $s;
        }
        $tryWord = strtolower(self::translit($s));
        if ($tryWord == strtolower($s)) {
            return $s;
        }
        $brands = Brands::model()->findAllBySql(
          'SELECT lower(name) AS name, lower(query) AS query FROM brands',
          []
        );

        $possibleWords = [];
        foreach ($brands as $brand) {
            if (levenshtein(metaphone($tryWord), metaphone($brand->name)) < mb_strlen(metaphone($tryWord)) / 2) {
                if (levenshtein($tryWord, $brand->name) < mb_strlen($tryWord) / 3) {
                    $possibleWords[] = $brand->name;
                }
            }
        }

        $similarity = 0;
        $meta_similarity = 0;
        $min_levenshtein = 1000;
        $meta_min_levenshtein = 1000;

        foreach ($possibleWords as $possibleWord) {
            $min_levenshtein = min($min_levenshtein, levenshtein($possibleWord, $tryWord));
        }

        foreach ($possibleWords as $possibleWord) {
            if (levenshtein($possibleWord, $tryWord) == $min_levenshtein) {
                $similarity = max($similarity, similar_text($possibleWord, $tryWord));
            }
        }

        $result = [];

        foreach ($possibleWords as $possibleWord) {
            if (levenshtein($possibleWord, $tryWord) <= $min_levenshtein) {
                if (similar_text($possibleWord, $tryWord) >= $similarity) {
                    $result[] = $possibleWord;
                }
            }
        }

        foreach ($result as $n) {
            $meta_min_levenshtein = min($meta_min_levenshtein, levenshtein(metaphone($n), metaphone($tryWord)));
        }

        foreach ($result as $n) {
            if (levenshtein($n, $tryWord) == $meta_min_levenshtein) {
                $meta_similarity = max($meta_similarity, similar_text(metaphone($n), metaphone($tryWord)));
            }
        }

        $meta_result = [];
        foreach ($result as $k) {
            if (levenshtein(metaphone($k), metaphone($tryWord)) <= $meta_min_levenshtein) {
                $keySimilarity = similar_text(metaphone($k), metaphone($tryWord));
                if ($keySimilarity >= $meta_similarity) {
                    $meta_result[$k] = $keySimilarity;
                }
            }
        }
        if (count($meta_result) > 0) {
            $res = array_search(max($meta_result), $meta_result);
        } else {
            $res = $s;
        }

        return $res;
    }

    public static function translationAddClearTag($translation)
    {
        if (DSConfig::getVal('translator_block_mode_enabled') == 1) {
            $res = preg_replace('/(editable\s*=\s*(?:"|&quot;)[01](?:"|&quot;))/is', '$1 clear="1"', $translation);
        } else {
            $res = Utils::removeOnlineTranslation($translation);
        }
        return $res;
    }

    public static function translit($s)
    {
        return self::translitURL($s);
    }

    public static function translitURL($s)
    {
        $tr = [
          'а' => 'a',
          'б' => 'b',
          'в' => 'v',
          'г' => 'g',
          'д' => 'd',
          'е' => 'e',
          'ё' => 'yo',
          'ж' => 'zh',
          'з' => 'z',
          'и' => 'i',
          'й' => 'j',
          'к' => 'k',
          'л' => 'l',
          'м' => 'm',
          'н' => 'n',
          'о' => 'o',
          'п' => 'p',
          'р' => 'r',
          'с' => 's',
          'т' => 't',
          'у' => 'u',
          'ф' => 'f',
          'х' => 'x',
          'ц' => 'c',
          'ч' => 'ch',
          'ш' => 'sh',
          'щ' => 'shh',
          'ь' => "",
          'ы' => "y",
          'ъ' => "",
          'э' => "e",
          'ю' => 'yu',
          'я' => 'ya',
          'А' => 'A',
          'Б' => 'B',
          'В' => 'V',
          'Г' => 'G',
          'Д' => 'D',
          'Е' => 'E',
          'Ё' => 'YO',
          'Ж' => 'Zh',
          'З' => 'Z',
          'И' => 'I',
          'Й' => 'J',
          'К' => 'K',
          'Л' => 'L',
          'М' => 'M',
          'Н' => 'N',
          'О' => 'O',
          'П' => 'P',
          'Р' => 'R',
          'С' => 'S',
          'Т' => 'T',
          'У' => 'U',
          'Ф' => 'F',
          'Х' => 'X',
          'Ц' => 'C',
          'Ч' => 'CH',
          'Ш' => 'SH',
          'Щ' => 'SHH',
          'Ь' => "",
          'Ы' => "Y",
          'Ъ' => "",
          'Э' => "E",
          'Ю' => 'YU',
          'Я' => 'YA',
        ];

        return strtr($s, $tr);
    }
}