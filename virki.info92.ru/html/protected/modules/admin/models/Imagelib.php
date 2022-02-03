<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="imagelib.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "cms_knowledge_base_img".
 * The followings are the available columns in table 'cms_knowledge_base_img':
 * @property string  $id
 * @property string  $path
 * @property string  $filename
 * @property integer $enabled
 * @property string  $en
 * @property string  $zh
 * @property string  $ru
 * @property string  $query
 */
class Imagelib extends CActiveRecord
{
    /**
     * @var string Запрос
     */
    public $query = '';

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'       => 'ID',
          'path'     => Yii::t('main', 'Путь к файлам'),
          'filename' => Yii::t('main', 'Имя файла'),
          'enabled'  => Yii::t('main', 'Вкл'),
          'en'       => Yii::t('main', 'Текст для поиска и подбора изображения') . ', en',
          'zh'       => Yii::t('main', 'Текст для поиска и подбора изображения') . ', zh',
          'ru'       => Yii::t('main', 'Текст для поиска и подбора изображения') . ', ru',
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
        ];
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
          ['path, filename', 'required'],
          ['enabled', 'numerical', 'integerOnly' => true],
          ['path', 'length', 'max' => 255],
          ['filename', 'length', 'max' => 256],
          ['en, zh, ru', 'safe'],
            // The following rule is used by search().

          ['id, path, filename, enabled, en, zh, ru', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     * @return CSqlDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($pageSize = 100)
    {
        $params = [
          ':query' => ($this->query ? $this->query : null),
          ':path'  => ($this->path ? $this->path : null),
        ];
        $queryLang = Utils::detectSearchLanguageForSql($this->query);
        if ($queryLang == 'ru') {
            $queryLanguage = 'russian';
        } else {
            $queryLanguage = 'english';
        }

        $sql = " SELECT /* SQL_CALC_FOUND_ROWS */ id, path, filename, enabled, en, ru, zh FROM cms_knowledge_base_img im
                where im.enabled = 1 AND (:path::varchar is null OR im.path like concat(:path::varchar,'%')) 
                AND 
                (
        to_tsvector('{$queryLanguage}',im.{$queryLang}) @@ websearch_to_tsquery('{$queryLanguage}',:query)
                    OR :query::varchar = '' OR :query::varchar IS NULL)
                    order by 
                             ts_rank(
                                 to_tsvector('{$queryLanguage}',im.{$queryLang}), websearch_to_tsquery('{$queryLanguage}',:query)) desc ";
        //Yii::app()->db->createCommand($sql)->execute($params);
        $countSql = "SELECT Count(0) FROM ({$sql}) countSql";
        $sqlCount = Yii::app()->db->createCommand($countSql)->queryScalar($params);
        $dataProvider = new CSqlDataProvider(
          $sql, [
            'id'             => 'image-lib_dataProvider',
            'params'         => $params,
            'keyField'       => 'id',
            'totalItemCount' => $sqlCount,
            'pagination'     => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $dataProvider;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cms_knowledge_base_img';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return imagelib|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
