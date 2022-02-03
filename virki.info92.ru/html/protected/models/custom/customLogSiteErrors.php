<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="LogSiteErrors.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "log_site_errors".
 * The followings are the available columns in table 'log_site_errors':
 * @property string $id
 * @property string $error_message
 * @property string $error_description
 * @property string $error_label
 * @property string $error_date
 * @property string $error_request
 */
class customLogSiteErrors extends DSEventableActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'                => 'ID',
          'error_message'     => 'Error Message',
          'error_description' => 'Error Description',
          'error_label'       => 'Error Label',
          'error_date'        => 'Error Date',
          'error_request'     => 'Error Request',
          'custom_data'       => 'Custom Data',
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
          ['error_message, error_label', 'length', 'max' => 4000],
          ['error_description, error_date, error_request, custom_data', 'safe'],
            // The following rule is used by search().

          ['id, error_message, error_label, error_date', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        if (!$criteria) {
            $criteria = new CDbCriteria;
        }
        if (!$dataProviderId) {
            $dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()) . '_dataProvider';
        }

        $criteria->compare('id', $this->id, true);
        $criteria->compare('error_message', $this->error_message, true);
        $criteria->compare('error_label', $this->error_label, true);
        $criteria->compare('error_date', $this->error_date, true);
        $criteria->order = 'error_date DESC';

        return new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 100,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'log_site_errors';
    }

    public static function getUpdateLink($id, $external = false)
    {
        /*        $error = self::model()->findByPk($id);
                if ($error) {
                    if ($external) {
                        return 'http://' . DSConfig::getVal(
                          'site_domain'
                        ) . '/admin/main/open?url=admin/orders/view/id/' . $id . '&tabName=' .Yii::t('admin','Заказ '). $order->uid.'-'.$order->id;
                    } else {
                        return '<a href="' . Yii::app()->createUrl(
                          '/admin/orders/view',
                          array('id' => $id)
                        ) . '" title="' . Yii::t(
                          'admin',
                          'Просмотр заказа'
                        ) . '" onclick="getContent(this,\'' . addslashes(Yii::t('admin','Заказ '). $order->uid.'-'.$order->id) . '\');return false;"><i class="fa fa-shopping-cart"></i>&nbsp;' . Yii::t('admin','Заказ '). $order->uid.'-'.$order->id . '</a>';
                    }
                } else {
                    return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
                }
                */
        return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
    }

    public static function getUserLink($id)
    {
        $order = self::model()->findByPk($id);
        if ($order) {
            return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                'site_domain'
              ) . '/cabinet/error/view/id/' . $id;
        } else {
            return '<a href="#">' . Yii::t('main', 'Ошибка') . '</a>';
        }
    }

    public static function logError(
      $error_label,
      $error_message = false,
      $error_description = false,
      $custom_data = false
    ) {
        /*
     `id` bigint(20) NOT NULL AUTO_INCREMENT,
    `error_message` varchar(4000) DEFAULT NULL,
    `error_description` longtext,
    `error_label` varchar(4000) DEFAULT NULL,
    `error_date` date DEFAULT NULL,
    `error_request` longtext,
        'custom_data'
         */
        try {
            $e = new LogSiteErrors();

            if (is_object($error_label)) {
                if (in_array(get_class($error_label), ['Exception', 'CHttpException'])) {
                    $e['error_label'] = substr($error_label->getMessage(), 0, 2000);
                    if (isset($error_label->statusCode)) {
                        if (isset($error_label->statusCode->content)) {
                            $e['error_message'] = $error_label->statusCode->content;
                        } else {
                            $e['error_message'] = CVarDumper::dumpAsString($error_label->statusCode, 6, true);
                        }
                    } else {
                        $e['error_message'] = substr($error_label->getMessage(), 0, 2000);
                    }
                    $data = false;
                    $unserialized = false;
                    if (isset($_POST['data'])) {
                        $log = null;
                        $data = DSGProxy::decodeDataV2($_POST['data'], $log, true);
                        $unserialized = @unserialize($data);
                    }
                    $e['error_description'] = CVarDumper::dumpAsString(
                        $error_label,
                        6,
                        true
                      ) . "\r\n" . CVarDumper::dumpAsString($_SERVER, 10, false)
                      . "\r\n" . CVarDumper::dumpAsString($_GET, 10, false) . "\r\n" . CVarDumper::dumpAsString(
                        $_POST,
                        10,
                        false
                      )
                      . "\r\n" . CVarDumper::dumpAsString(($unserialized ? $unserialized : $data));
                }
            } else {
                $e['error_label'] = substr($error_label, 0, 2000);
                if ($error_message) {
                    $e['error_message'] = substr($error_message, 0, 2000);
                }
                if ($custom_data) {
                    $e['custom_data'] = CVarDumper::dumpAsString($custom_data, 6, true);
                }
                if ($error_description) {
                    $data = false;
                    $unserialized = false;
                    if (isset($_POST['data'])) {
                        $log = null;
                        $data = DSGProxy::decodeDataV2($_POST['data'], $log, true);
                        $unserialized = @unserialize($data);
                    }
                    $e['error_description'] = $error_description . "\r\n" . CVarDumper::dumpAsString(
                        $_SERVER,
                        10,
                        false
                      )
                      . "\r\n" . CVarDumper::dumpAsString($_GET, 10, false) . "\r\n" . CVarDumper::dumpAsString(
                        $_POST,
                        10,
                        false
                      )
                      . "\r\n" . CVarDumper::dumpAsString(($unserialized ? $unserialized : $data));
                }
            }
            if ($custom_data) {
                $e['custom_data'] = CVarDumper::dumpAsString($error_label, 6, true);
            }

            $e['error_date'] = date("Y-m-d H:i:s", time());
            $intGLOBALS = [];
            if (isset($GLOBALS['_POST'])) {
                $intGLOBALS['_POST'] = $GLOBALS['_POST'];
            }
            if (isset($GLOBALS['_GET'])) {
                $intGLOBALS['_GET'] = $GLOBALS['_GET'];
            }
            if (isset($GLOBALS['_REQUEST'])) {
                $intGLOBALS['_REQUEST'] = $GLOBALS['_REQUEST'];
            }
            if (isset($GLOBALS['_SERVER']['HTTP_REFERER'])) {
                $intGLOBALS['HTTP_REFERER'] = $GLOBALS['_SERVER']['HTTP_REFERER'];
            }
            if (isset($GLOBALS['_SERVER']['REQUEST_URI'])) {
                $intGLOBALS['REQUEST_URI'] = $GLOBALS['_SERVER']['REQUEST_URI'];
            }
            $g = CVarDumper::dumpAsString($intGLOBALS, 6, true);
            $e['error_request'] = substr($g, 0, 32767);
//-----------
            $mailVars = [
              '{error_id}' => $e['error_label'],
              '{text}'     => $e['error_request'] . '<hr>' . $e['error_description'],
            ];
            if ($mailVars['{error_id}'] == null) {
                $mailVars['{error_id}'] = 'null';
            }

            if ($mailVars['{text}'] == null) {
                $mailVars['{text}'] = 'null';
            }
            $e->save();
        } catch (Exception $e) {

        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return LogSiteErrors the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
