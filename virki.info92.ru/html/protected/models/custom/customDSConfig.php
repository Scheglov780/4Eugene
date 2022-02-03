<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSConfig.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "config".
 * The followings are the available columns in table 'config':
 * @property string  $id
 * @property string  $label
 * @property string  $value
 * @property string  $default_value
 * @property integer $in_wizard
 */
class customDSConfig extends CActiveRecord
{
    protected static $_apiKeys = [];
    protected static $_cache = [];
    protected static $_currency = false;
    protected static $_currs = false;
    protected static $_currs_format = false;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'            => Yii::t('main', 'Параметр'),
          'value'         => Yii::t('main', 'Значение'),
          'label'         => Yii::t('main', 'Описание'),
          'default_value' => Yii::t('main', 'По умолчанию'),
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
          ['id', 'required'],
          ['in_wizard', 'numerical', 'integerOnly' => true],
          ['id,label', 'length', 'max' => 256],
          ['value, default_value', 'safe'],
            //array('value','numerical'),
          ['value', 'length', 'max' => 32767],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
          ['id, label, value, default_value, in_wizard', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->condition = "id LIKE '" . $this->id . "%'";
        $criteria->compare('value', $this->value, true);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('default_value', $this->default_value, true);
        $criteria->compare('in_wizard', $this->in_wizard);
        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.id ASC',
            ],
            'pagination' => [
              'pageSize' => 200,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'config';
    }

    private static function getValOverload($Pk, $val)
    {
        switch ($Pk) {
            case $Pk == 'seo_img_cache_enabled':
                {
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) {
                        return 0;
                    }
                }
                return $val;
                break;
            default:
                return $val;
        }
    }

    public static function formatXML($src)
    {
        $res = preg_replace('/&gt;(.+?)&lt;/i', '&gt;<b>$1</b>&lt;', $src);
        return $res;
    }

    public static function getApiKey($name)
    {
        if (isset(self::$_apiKeys[$name])) {
            return self::$_apiKeys[$name];
        }
        $xmlData = simplexml_load_string(DSConfig::getVal('api_keys'), null, LIBXML_NOCDATA);
        $xmlKey = $xmlData->xpath('/keys/key[@name="' . $name . '" and @enabled="1"]');
        if (isset($xmlKey[0])) {
            $result = (array) $xmlKey[0];
        } else {
            $result = false;
        }
        self::$_apiKeys[$name] = $result;
        return $result;
    }

    public static function getCurrency($symbol = false, $mask = false, $currency = false)
    {
        if ((!self::$_currency) && (!$currency)) {
            if (self::$_currs == false) {
                self::$_currs = explode(',', DSConfig::getVal('site_currency_block'));
            }
            $currs = self::$_currs;

            if (isset(Yii::app()->request->cookies['currency'])) {
                $currency = Yii::app()->request->cookies['currency']->value;
                if (!in_array($currency, $currs)) {
                    if (isset($currs[0])) {
                        $currency = $currs[0];
                    } else {
                        $currency = DSConfig::getVal('site_currency');
                    }
                }
            } elseif (isset($currs[0])) {
                $currency = $currs[0];
            } else {
                $currency = DSConfig::getVal('site_currency');
            }
            self::$_currency = $currency;
        }
        if (!$currency) {
            $currency = self::$_currency;
        }
        if (!$symbol) {
            return $currency;
        } else {
            if (self::$_currs_format == false) {
                self::$_currs_format = simplexml_load_string(
                  DSConfig::getVal('site_currency_format'),
                  null,
                  LIBXML_NOCDATA
                );
            }
            $currxml = self::$_currs_format->xpath('/currencies/currency[@name="' . $currency . '"]');
            $symb = '$';
            $symbMask = '%s%d';
            if (is_array($currxml)) {
                if (isset($currxml[0])) {
                    $symb = (string) $currxml[0]->symbol;
                    $symbMask = (string) $currxml[0]->mask;
                }
            }
            if ($mask) {
                $symb = str_replace('%s', $symb, $symbMask);
            }
            return $symb;
        }
    }

    public static function getDays()
    {
        $days = [];
        for ($i = 1; $i <= 31; $i++) {
            if ($i < 10) {
                $days['0' . $i] = $i;
            } else {
                $days[$i] = $i;
            }
        }
        return $days;
    }

    public static function getKeyTranslatorXML()
    {
        $xml = simplexml_load_string(DSConfig::getVal('keys_translator'), null, LIBXML_NOCDATA);
        $key = new stdClass();
        $keysCount = count($xml->translator_key);
        if ($keysCount > 1) {
            $keyIdx = rand(0, $keysCount - 1);
            $key->type = (string) $xml->translator_key[$keyIdx]->type;
            $key->appId = (string) $xml->translator_key[$keyIdx]->appId;
        } else {
            $key->type = (string) $xml->translator_key->type;
            $key->appId = (string) $xml->translator_key->appId;
        }
//    print_r($key); die;
        SiteLog::doAPIKeyLog($key->type, $key->appId);
        return $key;
    }

    public static function getMounthes()
    {
        return [
          '01' => Yii::t('main', 'Январь'),
          '02' => Yii::t('main', 'Февраль'),
          '03' => Yii::t('main', 'Март'),
          '04' => Yii::t('main', 'Апрель'),
          '05' => Yii::t('main', 'Май'),
          '06' => Yii::t('main', 'Июнь'),
          '07' => Yii::t('main', 'Июль'),
          '08' => Yii::t('main', 'Август'),
          '09' => Yii::t('main', 'Сентябрь'),
          '10' => Yii::t('main', 'Октябрь'),
          '11' => Yii::t('main', 'Ноябрь'),
          '12' => Yii::t('main', 'Декабрь'),
        ];
    }

    public static function getSiteCurrency()
    {
        return self::getVal('site_currency');
    }

    public static function getVal($Pk, $throwError = true)
    {
        if (is_array(self::$_cache)) {
            if (isset(self::$_cache[$Pk])) {
                return self::getValOverload($Pk, self::$_cache[$Pk]);
            }
        }
        $res_object = self::model()->findByPk($Pk);
        if (!$res_object) {
            if ($throwError) {
                throw new CHttpException(
                  500,
                  Yii::t(
                    'main',
                    'Фатальная ошибка: нарушена целостность конфигурации системы. Обратитесь к разработчикам'
                  ) . ' (' . $Pk . ')'
                );
            } else {
                $res = null;
            }
        }
        if (!is_object($res_object)) {
            if ($throwError) {
                throw new CHttpException(
                  500,
                  Yii::t(
                    'main',
                    'Фатальная ошибка: нарушена целостность конфигурации системы. Обратитесь к разработчикам'
                  ) . ' (' . $Pk . ')'
                );
            } else {
                $res = null;
            }
        } else {
            $res = $res_object->value;
        }
        if (!isset($res)) {
            if ($throwError) {
                throw new CHttpException(
                  500,
                  Yii::t(
                    'main',
                    'Фатальная ошибка: нарушена целостность конфигурации системы. Обратитесь к разработчикам'
                  ) . ' (' . $Pk . ')'
                );
            } else {
                $res = null;
            }
        }
        if (strlen($res) <= 1024 * 16) {
            if (!is_array(self::$_cache)) {
                self::$_cache = [];
            }
            self::$_cache[$Pk] = $res;
        }
        return self::getValOverload($Pk, $res);
    }

    public static function getValDef($Pk, $defaulValue)
    {
        $res = self::getVal($Pk, false);
        if (is_null($res)) {
            return $defaulValue;
        } else {
            return $res;
        }
    }

    public static function getYears()
    {
        $start_year = intval(date('Y') - 70);
        $end_year = intval(date('Y'));
        $years = [];
        for ($i = $start_year; $i <= $end_year; $i++) {
            $years[$i] = $i;
        }
        return $years;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return DSConfig|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function setVal($Pk, $Val)
    {
        $sql = " INSERT INTO config (id, [[value]])
  VALUES (:id::varchar, :value::text)  
  ON CONFLICT ON CONSTRAINT config_pkey 
                                          DO UPDATE SET 
                                          [[value]]=:value::text";
        Yii::app()->db->createCommand($sql)->execute(
          [
            ':id'    => $Pk,
            ':value' => $Val,
          ]
        );
    }
}