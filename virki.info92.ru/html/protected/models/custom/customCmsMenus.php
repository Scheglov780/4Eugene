<?php

/**
 * This is the model class for table "cms_menus".
 * The followings are the available columns in table 'cms_menus':
 * @property integer $id
 * @property string  $menu_id
 * @property string  $menu_data
 * @property integer $enabled
 * @property integer $SEO
 */
class customCmsMenus extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'        => Yii::t('main', 'PK навигационного меню'),
          'menu_id'   => Yii::t('main', 'Идентификатор меню'),
          'menu_data' => Yii::t('main', 'php-код меню (синтаксис View)'),
          'enabled'   => Yii::t('main', 'Включено'),
          'SEO'       => Yii::t('main', 'Контент доступен поисковикам'),
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
          ['enabled, SEO', 'numerical', 'integerOnly' => true],
          ['menu_id', 'length', 'max' => 255],
          ['menu_data', 'safe'],
            // The following rule is used by search().

          ['id, menu_id, menu_data, enabled, SEO', 'safe', 'on' => 'search,update'],
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
        $criteria->compare('menu_id', $this->menu_id, true);
        $criteria->compare('menu_data', $this->menu_data, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('SEO', $this->SEO);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'pagination' => [
              'pageSize' => 10,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cms_menus';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsMenus the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
