<?php

/**
 * This is the model class for table "cms_content_history".
 * The followings are the available columns in table 'cms_content_history':
 * @property string $id
 * @property string $table_name
 * @property string $content_id
 * @property string $lang
 * @property string $date
 * @property string $content
 */
class customCmsContentHistory extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'         => 'PK',
          'table_name' => Yii::t('main', 'Имя таблицы CMS'),
          'content_id' => Yii::t('main', 'id контента'),
          'lang'       => Yii::t('main', 'Язык'),
          'date'       => Yii::t('main', 'Дата'),
          'content'    => Yii::t('main', 'Контент'),
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
          ['table_name, content_id, date', 'required'],
          ['table_name, content_id', 'length', 'max' => 255],
          ['lang', 'length', 'max' => 8],
          ['content', 'safe'],
            // The following rule is used by search().

          ['id, table_name, content_id, lang, date, content', 'safe', 'on' => 'search'],
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
    public function search($pageSize = 20)
    {


        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('table_name', $this->table_name);
        $criteria->compare('content_id', $this->content_id);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('date', $this->date, true);
        $criteria->compare('content', $this->content, true);
        $criteria->order = 't.date DESC';

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cms_content_history';
    }

    public static function getContentHistory($tableName, $contentId, $lang, $pageSize = 20)
    {

        $params = ['tableName' => $tableName, 'contentId' => $contentId, 'lang' => ($lang ? $lang : null)];
        $searchCount = Yii::app()->db->createCommand(
          "SELECT count(0) as cnt FROM cms_content_history hh where hh.table_name=:tableName and hh.content_id = :contentId 
and (hh.lang=:lang or :lang is null)"
        )->queryScalar($params);
        $sql = "SELECT hh.* FROM cms_content_history hh where hh.table_name=:tableName and hh.content_id = :contentId 
and (hh.lang=:lang or :lang is null) order by hh.date desc";
        $storedDataProvider = new CSqlDataProvider(
          $sql, [
            'id'             => urlencode($tableName . '-' . $contentId . '-' . $lang . '-dataProvider'),
            'params'         => $params,
            'keyField'       => 'id',
            'totalItemCount' => $searchCount,
            'pagination'     => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $storedDataProvider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsContentHistory the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
