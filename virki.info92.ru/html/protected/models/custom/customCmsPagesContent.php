<?php

/**
 * This is the model class for table "cms_pages_content".
 * The followings are the available columns in table 'cms_pages_content':
 * @property integer  $id
 * @property string   $page_id
 * @property string   $lang
 * @property string   $content_data
 * @property string   $title
 * @property string   $description
 * @property string   $keywords
 * The followings are the available model relations:
 * @property CmsPages $page
 */
class customCmsPagesContent extends CActiveRecord
{
    public $contentdata;
    public $link;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'           => Yii::t('main', 'id контента страницы'),
          'page_id'      => Yii::t('main', 'id страницы контента'),
          'lang'         => Yii::t('main', 'Язык контента страницы (* - любой)'),
          'content_data' => Yii::t('main', 'php-код контента (синтаксис View)'),
          'title'        => Yii::t('main', 'title страницы'),
          'description'  => Yii::t('main', 'description страницы'),
          'keywords'     => Yii::t('main', 'keywords страницы'),
        ];
    }

    public function beforeValidate()
    {
        $this->content_data = $this->contentdata;
        parent::beforeValidate();
        return true;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'page' => [self::BELONGS_TO, 'CmsPages', 'page_id'],
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
          ['page_id', 'required'],
          ['page_id', 'length', 'max' => 255],
          ['lang', 'length', 'max' => 8],
          ['title, description, keywords', 'length', 'max' => 1024],
          ['content_data, contentdata', 'safe'],
            // The following rule is used by search().

          [
            'id, page_id, lang, content_data, contentdata, content_data, title, description, keywords',
            'safe',
            'on' => 'search,update',
          ],
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
        $criteria->select =
          "t.*,concat(case when lang<>'*' then concat('/',lang) else '' end,'/article/',(select url from cms_pages where cms_pages.page_id=t.page_id LIMIT 1)) as link";
        $criteria->compare('id', $this->id);
        $criteria->compare('page_id', $this->page_id, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('content_data', $this->content_data, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('keywords', $this->keywords, true);

        return new CActiveDataProvider(
          $this, [
            'criteria' => $criteria,
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'cms_pages_content';
    }

    public static function getUpdateLink($id, $external = false)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        $pageContent = self::model()->findByPk($id);
        if ($pageContent) {
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/cmsPagesContent/update/id/' . $id . '&tabName=' . Yii::t(
                    'admin',
                    'Страница '
                  ) . $pageContent->page_id;
            } else {
                return '<a href="' . Yii::app()->createUrl(
                    '/' . Yii::app()->controller->module->id . '/cmsPagesContent/update',
                    ['id' => $id]
                  ) . '" title="' . Yii::t(
                    'admin',
                    'Редактирование страницы'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    Yii::t(
                      'admin',
                      'Страница '
                    ) . $pageContent->page_id
                  ) . '\',false);return false;"><i class="fa fa-pencil"></i>&nbsp;' . Yii::t(
                    'admin',
                    'Страница '
                  ) . $pageContent->page_id . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsPagesContent the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}
