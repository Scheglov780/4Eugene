<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Category.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "categories".
 * The followings are the available columns in table 'categories':
 * @property integer $cid
 * @property string  $ru
 * @property string  $en
 * @property integer $parent
 * @property integer $is_parent
 * @property integer $onmain
 * @property integer $status
 */
class customCategory extends DSMetatagableActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'cid'         => Yii::t('main', 'Id категории'),
          'ru'          => Yii::t('main', 'Русский перевод'),
          'en'          => Yii::t('main', 'Англ. перевод'),
          'parent'      => Yii::t('main', 'Родительская кат.'),
          'is_parent'   => Yii::t('main', 'Является родителем'),
          'onmain'      => Yii::t('main', 'На главной'),
          'status'      => Yii::t('main', 'Включено'),
          'url'         => Yii::t('main', 'Адрес страницы'),
          'query'       => Yii::t('main', 'Запрос'),
          'title'       => Yii::t('main', 'meta title'),
          'description' => Yii::t('main', 'meta description'),
          'keywords'    => Yii::t('main', 'meta keywords'),
          'text'        => Yii::t('main', 'Описание страницы'),
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
          'ww' => [self::HAS_MANY, 'Weights', 'cid'],
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
          ['is_parent', 'numerical', 'integerOnly' => true],
          ['url, query', 'safe'],
          ['onmain, status', 'boolean'],
          ['ru, en', 'length', 'max' => 256],
          ['title, description, keywords', 'length', 'max' => 512],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
          ['cid, ru, en, parent, is_parent, onmain, status', 'safe', 'on' => 'search'],
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

        $criteria->compare('cid', $this->cid);
        $criteria->compare('ru', $this->ru, true);
        $criteria->compare('en', $this->en, true);
        $criteria->compare('parent', $this->parent);
        $criteria->compare('is_parent', $this->is_parent);
        $criteria->compare('onmain', $this->onmain);
        $criteria->compare('status', $this->status);
        $criteria->compare('url', $this->url);

        return new CActiveDataProvider(
          $this, [
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
        return 'classifier';
    }

    public static function getParents($ds_source, $cat, $result, $level)
    {
        $model = Category::model()->find(
          "ds_source=:ds_source AND cid=:cid and cid!='0'",
          [
            'ds_source' => $ds_source,
            ':cid'      => $cat->parent,
          ]
        );
        if ($model) {
            $res = new stdClass();
            $res->cid = $model->cid;
            $res->url = self::getUrl($model);
            $res->parent = $model->parent;
            if (Utils::appLang() == Utils::transLang(Utils::appLang())) {
                $res->name = $model->{Utils::transLang()};
            } else {
                $res->name = Yii::t('~category', $model->zh ? $model->zh : $model->ru); //$model->{Utils::TransLang()};
            }
            $result[$level] = $res;

            if ($model->parent != 0) {
                $result = self::getParents($ds_source, $res, $result, $level + 1);
            }
        }
        return $result;
    }

    public static function getPath($ds_source, $cat, $result = '')
    {
        $model = Category::model()->find(
          "((ds_source = :ds_source) or (:ds_source is null)) and cid=:cid and cid!='0'",
          [':ds_source' => $ds_source, ':cid' => $cat]
        );
        if ($model) {
            if ($result == '') {
                if (Utils::appLang() == Utils::transLang(Utils::appLang())) {
                    $result = $model[Utils::transLang()];
                } else {
                    $result = Yii::t('~category', (!empty($model['zh']) ? $model['zh'] : $model['ru']));
                }
            } else {
                if (Utils::appLang() == Utils::transLang(Utils::appLang())) {
                    $result = $model[Utils::transLang()] . ', ' . $result;
                } else {
                    $result = Yii::t(
                        '~category',
                        (!empty($model['zh']) ? $model['zh'] : $model['ru'])
                      ) . ', ' . $result;
                }
            }
            if ($model->parent != 0 && $model->parent != $model->cid) {
                $result = self::getPath($model->ds_source, $model->parent, $result);
            }
        }
        return $result;
    }

    public static function getTree($compact, $lang, $fromId = 1, $status = 1, $depth = 3, $currlevel = 0)
    {
        $result = [];
        $currlevel = $currlevel + 1;
        $data = Yii::app()->db->createCommand(
          "
SELECT
 id AS pkid,cid AS id,cid,ru,en,parent,status,onmain,url,zh,query,level
FROM classifier WHERE (parent = CASE WHEN :id=1 THEN 0 ELSE :id END AND cid != :id) AND (status=1 OR :status=0) AND (onmain=1 OR :status=0)
ORDER BY cid"
        )->queryAll(
          true,
          [
            ':id'     => $fromId,
            ':status' => $status,
          ]
        );
        foreach ($data as $menucat) {
            $result[$menucat['id']] = $menucat;
            //if ($menucat['level'] <= $depth) {
            if ($currlevel < $depth) {
                $result[$menucat['id']]['children'] = self::getTree(
                  $compact,
                  $lang,
                  $menucat['cid'],
                  $status,
                  $depth,
                  $currlevel
                );
            }
            $result[$menucat['id']]['view_text'] = $menucat[$lang];
            if ($compact) {
                unset($result[$menucat['id']]['ru']);
                unset($result[$menucat['id']]['en']);
                unset($result[$menucat['id']]['zh']);
            }
            if (!$compact) {
                if ($menucat['onmain'] == 1 and $menucat['status'] == 1) {
                    $result[$menucat['id']]['text'] = CHtml::link(
                      '<b>' . $menucat[$lang] . '</b>',
                      [
                        "category/update",
                        "id" => $menucat['pkid'],
                      ],
                      [
                        "onclick" => "getContent(this,\"" . addslashes(
                            Yii::t('main', 'Категория') . " №" .
                            $menucat['cid']
                          ) . "\",false);return false;",
                        "title"   => Yii::t('main', "Изменить параметры категории"),
                      ]
                    );
                } elseif ($menucat['status'] == 0) {
                    $result[$menucat['id']]['text'] = CHtml::link(
                      '<i>' . $menucat[$lang] . '</i>',
                      [
                        "category/update",
                        "id" => $menucat['pkid'],
                      ],
                      [
                        "onclick" => "getContent(this,\"" . addslashes(
                            Yii::t('main', 'Категория') . " №" .
                            $menucat['cid']
                          ) . "\",false);return false;",
                        "title"   => Yii::t('main', "Изменить параметры категории"),
                      ]
                    );
                } else {
                    $result[$menucat['id']]['text'] = CHtml::link(
                      $menucat[$lang],
                      [
                        "category/update",
                        "id" => $menucat['pkid'],
                      ],
                      [
                        "onclick" => "getContent(this,\"" . addslashes(
                            Yii::t('main', 'Категория') . " №" .
                            $menucat['cid']
                          ) . "\",false);return false;",
                        "title"   => Yii::t('main', "Изменить параметры категории"),
                      ]
                    );
                }
            }
            $result[$menucat['id']]['hasChildren'] = isset($result[$menucat['id']]['children']);
            $result[$menucat['id']]['expanded'] = false;
        }
        return $result;
    }

    public static function getUrl($model)
    {
        if ($model) {
            return $model->url;
        } else {
            return '';
        }
    }

    public static function model($className = __CLASS__)
        /**@return customCategory|CActiveRecord */
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}