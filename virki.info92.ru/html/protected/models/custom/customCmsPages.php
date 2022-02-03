<?php

/**
 * This is the model class for table "cms_pages".
 * The followings are the available columns in table 'cms_pages':
 * @property integer           $id
 * @property string            $page_id
 * @property string            $url
 * @property integer           $enabled
 * @property integer           $SEO
 * The followings are the available model relations:
 * @property CmsPagesContent[] $cmsPagesContents
 */
class customCmsPages extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        $domain = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
            'site_domain'
          );
        return [
          'id'             => Yii::t('main', 'id ссылки\страницы'),
          'page_id'        => Yii::t('main', 'Идентификатор страницы\ссылки (eng)'),
          'url'            => Yii::t(
            'main',
            'url на страницу (eng, путь {domain}/article/ добавляется автоматически)',
            ['{domain}' => $domain]
          ),
          'enabled'        => Yii::t('main', 'Включено'),
          'SEO'            => Yii::t('main', 'Контент доступен поисковикам'),
          'parent'         => Yii::t('main', 'ID родительской страницы'),
          'order_in_level' => Yii::t('main', 'Порядок'),
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
          'cmsPagesContents' => [self::HAS_MANY, 'CmsPagesContent', 'page_id'],
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
          ['parent,page_id, url, enabled, SEO', 'required'],
          ['enabled, SEO, parent, order_in_level', 'numerical', 'integerOnly' => true],
          ['page_id, url', 'length', 'max' => 255],
            // The following rule is used by search().

          ['id, parent, order_in_level, page_id, url, enabled, SEO', 'safe', 'on' => 'search,update'],
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
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
//		$criteria->compare('type', $this->type);
        $criteria->compare('page_id', $this->page_id, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('enabled', $this->enabled);
        $criteria->compare('SEO', $this->SEO);

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
        return 'cms_pages';
    }

    public static function cmsPagesDataProvider($rootId)
    {
        $sql = "
        select \"id\",\"parent\",\"order_in_level\",
        (select count(0) from cms_pages pp2 where pp.id = pp2.parent) as children,
        (select cc.title from cms_pages_content cc where cc.page_id = pp.page_id
          order by cc.lang=:lang desc, cc.lang='*' desc limit 1) as title,
        (select string_agg(concat(pc2.id,'-',pc2.lang),',') from cms_pages_content pc2 where pc2.page_id = pp.page_id) as content,
        \"page_id\",\"url\", \"enabled\", \"SEO\"
          from \"cms_pages\" pp
          -- where (cc.id <> '{$rootId})
        order by pp.parent='{$rootId}' desc, pp.parent, pp.order_in_level, pp.id
        ";
        $rows = Yii::app()->db->createCommand($sql)->queryAll(true, [':lang' => Utils::appLang()]);
        $workRows = [];
        if ($rows) {
            foreach ($rows as $i => $row) {
                $workRows[$row['id']] = $row;
            }
        }
        unset($workRows[$rootId]);
        $cmsPagesDataProvider = new CArrayDataProvider(
          $workRows, [
            'id'         => 'cmsPages_dataProvider',
            'keyField'   => 'id',
//            'totalItemCount' => $menuCount,
            'pagination' => [
              'pageSize' => 100000,
            ],
          ]
        );
        return $cmsPagesDataProvider;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsPages the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
