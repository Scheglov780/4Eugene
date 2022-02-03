<?php

/**
 * This is the model class for table "cms_custom_content".
 * The followings are the available columns in table 'cms_custom_content':
 * @property integer $id
 * @property string  $content_id
 * @property string  $lang
 * @property string  $content_data
 */
class customCmsCustomContent extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'           => Yii::t('main', 'id контента'),
          'content_id'   => Yii::t('main', 'Идентификатор кастомного контента'),
          'lang'         => Yii::t('main', 'Язык контента'),
          'content_data' => Yii::t('main', 'php-код контента (синтаксис View)'),
          'enabled'      => Yii::t('main', 'Включено'),
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
          ['content_id', 'length', 'max' => 255],
          ['lang', 'length', 'max' => 8],
          ['content_data', 'safe'],
            // The following rule is used by search().

          ['id, content_id, lang, content_data, enabled', 'safe', 'on' => 'search,update'],
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
//    Yii::app()->cache->set('cmsCustomContent-' . $id, $content, 600);
        return parent::save();
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
        $criteria->compare('content_id', $this->content_id, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('content_data', $this->content_data, true);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 25,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cms_custom_content';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsCustomContent the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
