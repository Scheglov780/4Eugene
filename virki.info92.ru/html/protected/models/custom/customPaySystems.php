<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="PaySystems.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "pay_systems".
 * The followings are the available columns in table 'pay_systems':
 * @property integer $id
 * @property integer $enabled
 * @property string  $logo_img
 * @property string  $int_name
 * @property string  $name
 * @property string  $descr_ru
 * @property string  $descr_en
 * @property string  $parameters
 */
class customPaySystems extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'         => 'ID',
          'enabled'    => Yii::t('admin', 'Включено'),
          'logo_img'   => Yii::t('admin', 'Логотип'),
          'int_name'   => Yii::t('admin', 'Внутр. имя'),
          'int_type'   => Yii::t('admin', 'Внутр. тип'),
          'name_ru'    => Yii::t('admin', 'Название Ru'),
          'name_en'    => Yii::t('admin', 'Название En'),
          'descr_ru'   => Yii::t('admin', 'Описание Ru'),
          'descr_en'   => Yii::t('admin', 'Описание En'),
          'parameters' => Yii::t('admin', 'Параметры'),
          'form_ru'    => Yii::t('admin', 'Форма Ru'),
          'form_en'    => Yii::t('admin', 'Форма En'),
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
          ['enabled', 'numerical', 'integerOnly' => true],
          ['logo_img', 'length', 'max' => 512],
          ['int_name, int_type, name_ru,name_en', 'length', 'max' => 256],
          [
            'enabled, logo_img, int_name, int_type, name_ru, name_en, descr_ru, descr_en, parameters, form_ru, form_en',
            'safe',
          ],
            // The following rule is used by search().

          [
            'id, enabled, logo_img, int_name, int_type, name_ru, name_en, descr_ru, descr_en, parameters',
            'safe',
            'on' => 'search',
          ],
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
    public function search()
    {


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('logo_img', $this->logo_img, true);
        $criteria->compare('int_name', $this->int_name, true);
        $criteria->compare('int_type', $this->int_type, true);
        $criteria->compare('name_ru', $this->name_ru, true);
        $criteria->compare('name_en', $this->name_en, true);
        $criteria->compare('descr_ru', $this->descr_ru, true);
        $criteria->compare('descr_en', $this->descr_en, true);
        $criteria->compare('parameters', $this->parameters, true);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 50,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'pay_systems';
    }

    public static function getModelByType($type)
    {
// Разбор paySystem на предмет содержания id в формате paySystem[id]
        if (preg_match('/^(.+?)\[(\d+)\]/s', $type, $matches)) {
            $_paySystem = $matches[1];
            $_paySystemId = $matches[2];
            $paySystem = self::model()->findByPk($_paySystemId);
        } else {
            $_paySystem = $type;
            $_paySystemId = null;
            $paySystem = self::model()->find('int_name=:type', [':type' => $type]);
        }
        return $paySystem;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Paysystems|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function preRenderForm($userPayment, $type, $value = false)
    {
        if (preg_match('/^(.+?)\[(\d+)\]/s', $type, $matches)) {
            $_paySystem = $matches[1];
            $_paySystemId = $matches[2];
        } else {
            $_paySystem = $type;
            $_paySystemId = null;
        }
        $paySystem = self::getModelByType($type);
        if ($paySystem) {
            if (!$value) {
                $htmlForm = $paySystem['form_' . 'ru'];//Utils::TransLang()
            } else {
                $htmlForm = $value;
            }
            $htmlForm = Utils::prepareHtmlTemplate($htmlForm, (array) $userPayment);
            $parameters = $paySystem['parameters'];
            $params = (array) simplexml_load_string($parameters, null, LIBXML_NOCDATA);
            $htmlForm = Utils::prepareHtmlTemplate($htmlForm, $params, '{#', '}');
            if ($_paySystem == 'order_alt') {
                $sumInWords = Utils::num2str($userPayment['sum'], 'ua');
            } else {
                $sumInWords = Utils::num2str($userPayment['sum'], 'ru');
            }
            $serviceVars = [
              'Now'         => date('d/m/Y'),
              'dayMonthNow' => date('dm'),
              'sumInWords'  => $sumInWords,
            ];
            $htmlForm = Utils::prepareHtmlTemplate($htmlForm, $serviceVars);
            $htmlForm = cms::render($htmlForm, 'ru');
            return $htmlForm;
        } else {
            return Yii::t('main', 'Платежная система не найдена') . ': ' . $type;
        }
    }
}
