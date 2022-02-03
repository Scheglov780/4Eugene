<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Banners.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "banners".
 * The followings are the available columns in table 'banners':
 * @property integer $id
 * @property string  $img_src
 * @property string  $href
 * @property string  $title
 * @property integer $enabled
 */
class customBanners extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'           => 'ID',
          'img_src'      => Yii::t('admin', 'Путь к изображению'),
          'href'         => Yii::t('admin', 'Ссылка'),
          'title'        => 'Title',
          'enabled'      => Yii::t('admin', 'Вкл'),
          'banner_order' => Yii::t('admin', 'Порядок отображения'),
          'front_theme'  => Yii::t('admin', 'Тема'),
          'html_content' => Yii::t('admin', 'HTML'),
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
            //array('img_src, href, title', 'required'),
          ['enabled', 'numerical', 'integerOnly' => true],
          ['banner_order', 'numerical', 'integerOnly' => true],
          ['img_src, href', 'length', 'max' => 1024],
          ['title', 'length', 'max' => 256],
          ['front_theme', 'length', 'max' => 128],
          ['html_content', 'safe'],
            // The following rule is used by search().

          ['id, front_theme, html_content, img_src, href, title, enabled, banner_order', 'safe', 'on' => 'search'],
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
        $criteria->compare('img_src', $this->img_src, true);
        $criteria->compare('href', $this->href, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('enabled', $this->enabled);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'id'         => 'banners_dataProvider',
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'banner_order' => [
                  'asc'  => 'banner_order ASC',
                  'desc' => 'banner_order DESC',
                ],
                'front_theme'  => [
                  'asc'  => 'front_theme ASC',
                  'desc' => 'front_theme DESC',
                ],
              ],
                // Default order in CGridview
              'defaultOrder' => [
                'front_theme'  => CSort::SORT_ASC,
                'banner_order' => CSort::SORT_ASC,
              ],
            ],
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
        return 'banners';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Banners|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
