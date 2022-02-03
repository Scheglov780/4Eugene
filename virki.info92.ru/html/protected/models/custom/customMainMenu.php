<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="MainMenu.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "categories_ext".
 * The followings are the available columns in table 'categories_ext':
 * @property integer         $id
 * @property integer         $cid
 * @property string          $ru
 * @property string          $en
 * @property integer         $parent
 * @property integer         $status
 * @property string          $url
 * @property string          $zh
 * @property string          $query
 * @property integer         $level
 * @property integer         $order_in_level
 * The followings are the available model relations:
 * @property CategoriesExt   $parent0
 * @property CategoriesExt[] $categoriesExts
 */
class customMainMenu extends DSMetatagableActiveRecord
{

    public $catlev = [];
    public $children;
    public $opt = [];
    public $pkid;
    public $view_text;
    private static $appLang = null;
    private static $site_name = null;
    private static $xml = null;

    private function _findChildLine($array, $lineid)
    {
        $flag = false;
        foreach ($array as $key => $ar) {
            if ($key == $lineid) {
                $flag = true;
                $ret = $ar;
                break;
            } else {
                if (is_array($ar['children'])) {
                    $ret = self::model()->_findChildLine($ar['children'], $lineid);
                    if ($ret) {
                        $flag = true;
                        break;
                    }
                }
            }
        }
        if ($flag) {
            return $ret;
        } else {
            return false;
        }
    }

    private function _fromId($array, $fromId)
    {
        return [$fromId => self::model()->_findChildLine($array, $fromId)];
    }

    private function _getMenuArray($rows, $labels, $fromId)
    {
        $totalArray = [];
        $children = []; // children of each ID
        $ids = [];
        $k = 0;

        // Collect who are children of whom.
        foreach ($rows as $i => $r) {
            $element = [];
            foreach ($labels as $lb) {
                $element[$lb] = $rows[$i][$lb];
            }

            $totalArray[$k++] = $element;
            $row =  &$totalArray[$k - 1];
            $id = $row['pkid'];
            if ($id === null) {
                continue;
            }

            $pid = $row['parent'];
            if ($id == $pid) {
                $pid = null;
            }
            $children[$pid][$id] =& $row;
            if (!isset($children[$id])) {
                $children[$id] = [];
            }
            $row['children'] = &$children[$id];
            $ids[$id] = true;
        }

        // Root elements are elements with non-found PIDs.
        $forest = [];
        foreach ($totalArray as $i => $r) {
            $row = &$totalArray[$i];
            $id = $row['pkid'];
            $pid = $row['parent'];
            if ($pid == $id) {
                $pid = null;
            }
            if (!isset($ids[$pid])) {

                $forest[$row['pkid']] =& $row;
            }
        }
        if ($fromId) {
            return self::model()->_fromId($forest, $fromId);
        } else {
            return $forest;
        }
    }

    private function _getTree($rows, $labels, $lang)
    {
        $totalArray = [];
        $children = []; // children of each ID
        $ids = [];
        $k = 0;

        // Collect who are children of whom.
        foreach ($rows as $i => $r) {
            if ($rows[$i]['pkid'] == 1) {
                continue;
            }
            $element = [];
            foreach ($labels as $lb) {
                $element[$lb] = $rows[$i][$lb];
            }
            $tmp = self::renderTreeNode($element, $lang);
            $element['text'] = $tmp['text'];
            $element['hasChildren'] = isset($element['children']);
            $element['expanded'] = false;
            $element['htmlOptions'] = [
              'class' => 'admin-category-tree-node',
              'id'    => 'admin-category-tree-node-' . $element['pkid'],
            ];

            $totalArray[$k++] = $element;
            $row =  &$totalArray[$k - 1];
            $id = $row['pkid'];

            if ($id === null) {
                continue;
            }

            $pid = $row['parent'];
            if ($id == $pid) {
                $pid = null;
            }
            $children[$pid][$id] =& $row;
            if (!isset($children[$id])) {
                $children[$id] = [];
            }
            $row['children'] = &$children[$id];
            $ids[$id] = true;
        }

        // Root elements are elements with non-found PIDs.
        $forest = [];
        foreach ($totalArray as $i => $r) {
            $row = &$totalArray[$i];
            $id = $row['pkid'];
            $pid = $row['parent'];
            if ($pid == $id) {
                $pid = null;
            }
            if (!isset($ids[$pid])) {

                $forest[$row['pkid']] =& $row;
            }
        }
        return $forest;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'             => Yii::t('main', 'Id категории'),
          'cid'            => Yii::t('main', 'cid'),
          'ru'             => Yii::t('main', 'Название ru'),
          'en'             => Yii::t('main', 'Название en'),
          'zh'             => Yii::t('main', 'Название zh'),
          'query'          => Yii::t('main', 'Запрос'),
          'parent'         => Yii::t('main', 'Родительская кат.'),
          'level'          => Yii::t('main', 'Уровень'),
          'status'         => Yii::t('main', 'Вывод'),
          'url'            => Yii::t('main', 'Адрес страницы'),
          'order_in_level' => Yii::t('main', 'Порядок вывода'),
          'manual'         => Yii::t('main', 'Вручную'),
          'decorate'       => Yii::t('main', 'Html-оформление'),
          'ds_source'      => Yii::t('main', 'Источник'),
          'title'          => Yii::t('main', 'meta title'),
          'description'    => Yii::t('main', 'meta description'),
          'keywords'       => Yii::t('main', 'meta keywords'),
          'text'           => Yii::t('main', 'Описание страницы'),
        ];
    }

    public function delete()
    {
        self::clearMenuCache();
        return parent::delete();
    }

    public function getFirstLevel()
    {
        $ret = [];
        $recs = self::model()->findAll(
          [
            'select'    => "\"id\", \"ru\" ",
            'condition' => "\"parent\" = :parentId AND \"status\" != 0 ",
            'params'    => [':parentId' => 1],
            'order'     => "\"order_in_level\" ASC, \"id\" ASC ",
          ]
        );

        foreach ($recs as $rec) {
            if ($rec[Utils::transLang()] == '') {
                continue;
            }
            if ($rec['ru'] == 'Root') {
                continue;
            }
            $ret[$rec['id']] = $rec['ru'];
        }
        return $ret;
    }

    public function getLevelStep($id)
    {
        $ret = $tmp = [];
        $res = self::model()->findAll(
          [
            'select' => 'id, parent',
          ]
        );
        if ($res && is_array($res)) {
            foreach ($res as $r) {
                $tmp[$r['id']] = $r['parent'];
            }
            $ret[0] = $id;

            $flag = true;
            $i = 1;
            $parent = 1;
            while ($flag) {
                if (isset($ret[$i - 1])) {
                    if (isset($tmp[$ret[$i - 1]])) {
                        $parent = $tmp[$ret[$i - 1]];
                    }
                }
                $ret[$i] = $parent;
                $i++;

                if ($parent == 1) {
                    $flag = false;
                }

            }
        }
        return $ret;
    }

    public function getLevelString($id, $lang)
    {
        $ret = $tmp = [];
        $model = new MainMenu();
        $res = $model->findAll();
        /*        $res = self::model()-> findAll(
                  array(
                    'select' => 'id, parent, ' . $lang
                  )
                );
        */
        foreach ($res as $r) {
            $tmp[$r['id']][0] = $r['parent'];
            $tmp[$r['id']][1] = $r['nametranslation'];
        }
        $ret[0] = $id;
        $flag = true;
        $i = 1;
        while ($flag) {
            $parent = $tmp[$ret[$i - 1]][0];
            $ret[$i] = $parent;
            $i++;
            if ($parent == 1) {
                $flag = false;
            }
        }
        $out = '';
        $cnt = count($ret) - 1;
        for ($i = $cnt; $i >= 0; $i--) {
            if ($i == $cnt) {
                $out .= $tmp[$ret[$i]][1] == 'Root' ? Yii::t('main', 'Главная') : $tmp[$ret[$i]][1];
            } else {
                $out .= ' / ' . $tmp[$ret[$i]][1];
            }
        }
        return $out;
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'parent0'        => [self::BELONGS_TO, 'CategoriesExt', 'parent'],
          'categoriesExts' => [self::HAS_MANY, 'CategoriesExt', 'parent'],
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
          ['cid, parent, status, url, ru, en, ds_source', 'required'],
          ['parent, status, level, order_in_level, manual', 'numerical', 'integerOnly' => true],
          [
            'nametranslation, ru, en, url, zh, query',
            'length',
            'max' => 2048,
          ],
          ['title,description,keywords', 'length', 'max' => 2048],
          ['manual,decorate,text', 'safe'],
            // The following rule is used by search().
          [
            'id, cid, ru, en, parent, status, url, zh, query, level, order_in_level, manual, decorate,ds_source',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
        if (!isset($this->zh) || !$this->zh) {
            if (isset($this->ru) && $this->ru) {
                $this->zh = Yii::app()->DVTranslator->translateMessage($this->ru, 'ru', 'zh');
            } elseif (isset($this->en) && $this->en) {
                $this->zh = Yii::app()->DVTranslator->translateMessage($this->ru, 'en', 'zh');
            } else {
                $this->zh = 'Undefined';
            }
        }
        if (!isset($this->ru) || !$this->ru) {
            if (isset($this->zh) && $this->zh) {
                $this->ru = Yii::app()->DVTranslator->translateMessage($this->zh, 'zh', 'ru');
            } elseif (isset($this->en) && $this->en) {
                $this->ru = Yii::app()->DVTranslator->translateMessage($this->en, 'en', 'ru');
            } else {
                $this->ru = 'Undefined';
            }
        }
        if (!isset($this->en) || !$this->en) {
            if (isset($this->zh) && $this->zh) {
                $this->en = Yii::app()->DVTranslator->translateMessage($this->zh, 'zh', 'en');
            } elseif (isset($this->ru) && $this->ru) {
                $this->en = Yii::app()->DVTranslator->translateMessage($this->ru, 'ru', 'en');
            } else {
                $this->en = 'Undefined';
            }
        }
        if ($this->isNewRecord) {
            $this->manual = 1;
            self::updateMetaAndHFURL($this);
        } else {
            $oldRec = MainMenu::findByPk($this->id);
            if ($oldRec) {
                if ($oldRec->parent != $this->parent) {
                    $this->manual = 1;
                }
                if ($oldRec->order_in_level != $this->order_in_level) {
                    $this->manual = 1;
                }
            }
        }
        self::clearMenuCache();
        if (!$this->url) {
            $this->manual = 1;
            self::updateMetaAndHFURL($this);
        }
        $res = parent::save();
        if (!$res) {
            $err = $this->getErrors();
        }
        return $res;
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
    public function search($pageSize = 100)
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('cid', $this->cid);
        $criteria->compare('ru', $this->ru, true);
        $criteria->compare('en', $this->en, true);
        $criteria->compare('parent', $this->parent);
        $criteria->compare('status', $this->status);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('zh', $this->zh, true);
        $criteria->compare('query', $this->query, true);
        $criteria->compare('level', $this->level);
        $criteria->compare('order_in_level', $this->order_in_level);
        $criteria->compare('ds_source', $this->ds_source);

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
        return 'categories_ext';
    }

    /**
     * @param $cat customCategory|customMainMenu|array
     * @return bool
     */
    protected static function updateMetaAndHFURL($cat)
    {
        if (!function_exists('translit')) {
            function translit($s)
            {
                return Utils::translitURL($s);
            }
        }
        try {
            if (!isset(self::$site_name)) //static
            {
                self::$site_name = DSConfig::getVal('site_name');
            }
            $site_name = self::$site_name;
            if (!isset(self::$xml)) //static
            {
                self::$xml = simplexml_load_string(DSConfig::getVal('seo_category_rules'), null, LIBXML_NOCDATA);
            }
            $xml = self::$xml;
            if (!isset(self::$appLang)) //static
            {
                self::$appLang = Utils::appLang();
            }
            $appLang = self::$appLang;
            $parent_cat = MainMenu::model()->findByPk($cat['parent']);
            $level = $cat['level'];
            /*        $name
                    $parent_name
                    $children_names
                    $related_names
            */
            if (isset($cat[$appLang]) && $cat[$appLang]) {
                $name = $cat[$appLang];
            } else {
                $name = Yii::app()->DVTranslator->translateCategory(
                  $cat['ru'] ? $cat['ru'] : $cat['zh'],
                  $cat['ru'] ? 'ru' : 'zh',
                  $appLang
                );
            }
            if ($cat['parent'] != 1) {
                if (isset($parent_cat[$appLang]) && $parent_cat[$appLang]) {
                    $parent_name = $parent_cat[$appLang];
                } else {
                    $parent_name = Yii::app()->DVTranslator->translateCategory(
                      $parent_cat['ru'] ? $parent_cat['ru'] : $parent_cat['zh'],
                      $parent_cat['ru'] ? 'ru' : 'zh',
                      $appLang
                    );
                }
            } else {
                $parent_name = '';
            }
            if ($cat['parent'] != 1) {
                $parent_url = $parent_cat['url'];
            } else {
                $parent_url = '';
            }
            $children_names = [];
            $child_cats = MainMenu::model()->findAll('parent=:parent', [':parent' => $cat['id']]);
            foreach ($child_cats as $child_cat) {
                if (isset($child_cat[$appLang]) && $child_cat[$appLang]) {
                    $children_names[$child_cat['id']] = $child_cat[$appLang];
                } else {
                    $children_names[$child_cat['id']] =
                      Yii::app()->DVTranslator->translateCategory(
                        $child_cat['ru'] ? $child_cat['ru'] : $child_cat['zh'],
                        $child_cat['ru'] ? 'ru' : 'zh',
                        $appLang
                      );
                }
            }
            $related_names = [];
            $related_cats = MainMenu::model()->findAll('parent=:parent', [':parent' => $cat['parent']]);
            foreach ($related_cats as $related_cat) {
                if (isset($child_cat[$appLang]) && $child_cat[$appLang]) {
                    $related_names[$related_cat['id']] = $related_cat[$appLang];
                } else {
                    $related_names[$related_cat['id']] =
                      Yii::app()->DVTranslator->translateCategory(
                        $related_cat['ru'] ? $related_cat['ru'] : $related_cat['zh'],
                        $related_cat['ru'] ? 'ru' : 'zh',
                        $appLang
                      );
                }
            }
            $parent_names = self::getParentsNames($cat);
            $parent_urls = self::getParentsUrls($cat);
            $ds_source = $cat['ds_source'];
//--------------------
            $evalCommand = (string) $xml->HFURL;
            try {
                $hfurl = eval($evalCommand);
            } catch (Exception $e) {
                $hfurl = $e->getMessage() . "\r\n" . $evalCommand;
            }
            if (MainMenu::model()->count(
                'url=:url and id<>:id',
                [':url' => $hfurl, 'id' => $cat['id']]
              ) > 0
            ) {
                if (preg_match('/\/$/s', $hfurl)) {
                    $hfurl = preg_replace('/\/$/s', '-' . $cat['id'] . '/', $hfurl);
                } else {
                    $hfurl = $hfurl . '-' . $cat['id'];
                }
            }
            $cat['url'] = $hfurl;
            if ($cat['url']) {
                if (!$cat->isNewRecord) {
                    $cat->update(['url']);
                }
            }
//--------------------

            $langsArray = explode(',', DSConfig::getVal('site_language_supported'));
            foreach ($langsArray as $langVal) {
                if (isset($cat[$langVal]) && $cat[$langVal]) {
                    $name = $cat[$langVal];
                } else {
                    $name =
                      Yii::app()->DVTranslator->translateCategory(
                        $cat['ru'] ? $cat['ru'] : $cat['zh'],
                        $cat['ru'] ? 'ru' : 'zh',
                        $langVal
                      );
                }
                if ($cat['parent'] != 1) {
                    if (isset($parent_cat[$langVal]) && $parent_cat[$langVal]) {
                        $parent_name = $parent_cat[$langVal];
                    } else {
                        $parent_name =
                          Yii::app()->DVTranslator->translateCategory(
                            $parent_cat['ru'] ? $parent_cat['ru'] : $parent_cat['zh'],
                            $parent_cat['ru'] ? 'ru' : 'zh',
                            $langVal
                          );
                    }
                } else {
                    $parent_name = '';
                }
                $children_names = [];
                $child_cats = MainMenu::model()->findAll('parent=:parent', [':parent' => $cat['id']]);
                foreach ($child_cats as $child_cat) {
                    if (isset($child_cat[$langVal]) && $child_cat[$langVal]) {
                        $children_names[$child_cat['id']] = $child_cat[$langVal];
                    } else {
                        $children_names[$child_cat['id']] =
                          Yii::app()->DVTranslator->translateCategory(
                            $child_cat['ru'] ? $child_cat['ru'] : $child_cat['zh'],
                            $child_cat['ru'] ? 'ru' : 'zh',
                            $langVal
                          );
                    }
                }
                $related_names = [];
                $related_cats = MainMenu::model()->findAll('parent=:parent', [':parent' => $cat['parent']]);
                foreach ($related_cats as $related_cat) {
                    if (isset($related_cat[$langVal]) && $related_cat[$langVal]) {
                        $related_names[$related_cat['id']] = $related_cat[$langVal];
                    } else {
                        $related_names[$related_cat['id']] =
                          Yii::app()->DVTranslator->translateCategory(
                            $related_cat['ru'] ? $related_cat['ru'] : $related_cat['zh'],
                            $related_cat['ru'] ? 'ru' : 'zh',
                            $langVal
                          );
                    }
                }
                if (isset($xml->{$langVal})) {
                    try {
                        $cmd = (string) $xml->{$langVal}->description;
                        $res = @eval($cmd);
                        if (!$res) {
                            echo 'Err in:' . (string) $xml->{$langVal}->description;
                        }
                        cms::setMeta(
                          $res,
                          $cat['url'],
                          'description',
                          $langVal
                        );
                    } catch (Exception $e) {
                        echo $e->getMessage() . "\r\n" . (string) $xml->{$langVal}->description;
                    }
                    try {
                        $cmd = (string) $xml->{$langVal}->title;
                        $res = @eval($cmd);
                        if (!$res) {
                            echo 'Err in:' . (string) $xml->{$langVal}->title;
                        }
                        cms::setMeta($res, $cat['url'], 'title', $langVal);
                    } catch (Exception $e) {
                        echo $e->getMessage() . "\r\n" . (string) $xml->{$langVal}->title;
                    }
                    try {
                        $cmd = (string) $xml->{$langVal}->keywords;
                        $res = @eval($cmd);
                        if (!$res) {
                            echo 'Err in:' . (string) $xml->{$langVal}->keywords;
                        }
                        cms::setMeta($res, $cat['url'], 'keywords', $langVal);
                    } catch (Exception $e) {
                        echo $e->getMessage() . "\r\n" . (string) $xml->{$langVal}->keywords;
                    }
                } else {
                    try {
                        $cmd = (string) $xml->en->description;
                        $res = @eval($cmd);
                        if (!$res) {
                            echo 'Err in:' . (string) $xml->en->description;
                        }
                        cms::setMeta($res, $cat['url'], 'description', $langVal);
                    } catch (Exception $e) {
                        echo $e->getMessage() . "\r\n" . (string) $xml->en->description;
                    }
                    try {
                        $cmd = (string) $xml->en->title;
                        $res = @eval($cmd);
                        if (!$res) {
                            echo 'Err in:' . (string) $xml->en->title;
                        }
                        cms::setMeta($res, $cat['url'], 'title', $langVal);
                    } catch (Exception $e) {
                        echo $e->getMessage() . "\r\n" . (string) $xml->en->title;
                    }
                    try {
                        $cmd = (string) $xml->en->keywords;
                        $res = @eval($cmd);
                        if (!$res) {
                            echo 'Err in:' . (string) $xml->en->keywords;
                        }
                        cms::setMeta($res, $cat['url'], 'keywords', $langVal);
                    } catch (Exception $e) {
                        echo $e->getMessage() . "\r\n" . (string) $xml->en->keywords;
                    }
                }
            }
        } catch (Exception $e) {
            //LogSiteErrors::logError($e['type'] . ' ' . $e['source'] . ' ' . $e['file'] . ': ' . $e['line'], $e['message'], $e['trace']);
            //logError($error_label,$error_message=false,$error_description=false,$custom_data=false)
            echo $e->getMessage();
            return false;
        }
//=========================================================================================================
        return true;
    }

    public static function MainMenuDataProvider($rootId)
    {
        $sql = "
        select \"id\",\"parent\",\"order_in_level\",
        (select count(0) from categories_ext cc2 where cc.id = cc2.parent)+
        (select count(0) from categories_ext cc3 where cc3.parent in (select id from categories_ext cc2 where cc.id = cc2.parent))
         as children,
        \"cid\",\"zh\", \"ru\", \"en\", -- \"zh\",\"ru\",\"en\",
        \"parent\",\"status\",\"url\",\"query\",
        \"manual\",\"decorate\",\"ds_source\" -- , \"level\",\"order_in_level\",
          from \"categories_ext\" cc
          -- where (cc.id <> '{$rootId})
        order by cc.parent='{$rootId}' desc, cc.parent, cc.order_in_level, cc.id
        ";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $workRows = [];
        if ($rows) {
            foreach ($rows as $i => $row) {
                $workRows[$row['id']] = $row;
            }
            if (isset($workRows[$rootId]['parent'])) {
                $rootParent = $workRows[$rootId]['parent'];
            } else {
                $rootParent = null;
            }
            unset($workRows[$rootId]);
            if ($rootParent != $rootId) {
                foreach ($workRows as $i => $row) {
                    if ($row['parent'] == $rootParent) {
                        unset($workRows[$i]);
                    }
                }
                foreach ($workRows as $i => $row) {
                    if ($row['parent'] != $rootId && !isset($workRows[$row['parent']])) {
                        unset($workRows[$i]);
                    }
                }
            }
        }

        $menuDataProvider = new CArrayDataProvider(
          $workRows, [
            'id'         => 'menu_dataProvider',
            'keyField'   => 'id',
//            'totalItemCount' => $menuCount,
            'pagination' => [
              'pageSize' => 100000,
            ],
          ]
        );
        return $menuDataProvider;
    }

    public static function MainMenuSourcesDataProvider($rootId)
    {
        $sql = "
        select \"id\",\"parent\",\"order_in_level\",
        (select count(0) from categories_ext_source cc2 where cc.id = cc2.parent)+
        (select count(0) from categories_ext_source cc3 where cc3.parent in (select id from categories_ext_source cc2 where cc.id = cc2.parent))
        as children,
        \"cid\",\"zh\", \"ru\", \"en\", -- \"zh\",\"ru\",\"en\",
        \"parent\",\"status\",\"url\",\"query\",
        \"manual\",\"decorate\",\"ds_source\" -- , \"level\",\"order_in_level\",
          from \"categories_ext_source\" cc
          -- where (cc.id <> '{$rootId})
        order by cc.parent='{$rootId}' desc, cc.parent, cc.order_in_level, cc.id
        ";
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
        $workRows = [];
        if ($rows) {
            foreach ($rows as $i => $row) {
                $workRows[$row['id']] = $row;
            }
            if (isset($workRows[$rootId])) {
                $rootParent = $workRows[$rootId]['parent'];
                unset($workRows[$rootId]);
            } else {
                $rootParent = $rootId;
            }
            if ($rootParent != $rootId) {
                foreach ($workRows as $i => $row) {
                    if ($row['parent'] == $rootParent) {
                        unset($workRows[$i]);
                    }
                }
                foreach ($workRows as $i => $row) {
                    if ($row['parent'] != $rootId && !isset($workRows[$row['parent']])) {
                        unset($workRows[$i]);
                    }
                }
            }
        }

        $menuDataProvider = new CArrayDataProvider(
          $workRows, [
            'id'         => 'menuSources_dataProvider',
            'keyField'   => 'id',
//            'totalItemCount' => $menuCount,
            'pagination' => [
              'pageSize' => 100000,
            ],
          ]
        );
        return $menuDataProvider;
    }

    public static function clearMenuCache($topLevelCount = 1000)
    {
//TODO Обработать статусы
        $refererIsSiteRoot = preg_match('/^http[s]*:\/\/[a-z0-9\-\.]+?[\/]*$/i', Yii::app()->request->urlReferrer);
        $refererIsAdmin = preg_match('/\/admin\//i', Yii::app()->request->urlReferrer);
        if ((YII_DEBUG && Yii::app()->user->role == 'superAdmin' && $refererIsSiteRoot) || ($refererIsAdmin)) {
            Yii::app()->db->createCommand("truncate table \"cache\"")->execute();
            $languages = explode(',', DSConfig::getVal('site_language_supported'));
            $languagesFrom = $languages;
            if (is_array($languages)) {
                foreach ($languages as $to) {
                    Yii::app()->cache->delete(
                      'MainMenu-getTree-' . $to . '-' . '1' . '-' . DSConfig::getVal('site_front_theme')
                    );
                    Yii::app()->cache->delete(
                      'MainMenu-getTree-' . $to . '-' . '2' . '-' . DSConfig::getVal('site_front_theme')
                    );
                    Yii::app()->cache->delete(
                      'MainMenu-getTree-' . $to . '-' . '3' . '-' . DSConfig::getVal('site_front_theme')
                    );
                    Yii::app()->cache->delete('MainMenu-getList-' . $to . '-' . DSConfig::getVal('site_front_theme'));
                    Yii::app()->cache->delete(
                      'MainMenu-getTree-rendering-' . $to . '-' . $topLevelCount . '-' . DSConfig::getVal(
                        'site_front_theme'
                      )
                    );
                    Yii::app()->cache->delete(
                      'MainMenu-getTree-rendering-' . $to . '-1000-' . DSConfig::getVal('site_front_theme')
                    );
                    if (isset(Yii::app()->controller->frontTheme)) {
                        Yii::app()->cache->delete(
                          'MainMenu-getTree-rendering-' .
                          $to .
                          '-' .
                          $topLevelCount .
                          '-' .
                          Yii::app()->controller->frontTheme
                        );
                    }
                    if (isset(Yii::app()->controller->frontTheme)) {
                        Yii::app()->cache->delete(
                          'MainMenu-getTree-rendering-' . $to . '-1000-' . Yii::app()->controller->frontTheme
                        );
                    }
                    Yii::app()->cache->delete('categories-getTree-' . $to . '-' . DSConfig::getVal('site_front_theme'));
                    if (isset(Yii::app()->controller->frontTheme)) {
                        Yii::app()->cache->delete(
                          'categories-getTree-' . $to . '-' . Yii::app()->controller->frontTheme
                        );
                    }
                    foreach ($languagesFrom as $from) {
                        $cacheTag = 'translateCategory-' . $from . '->' . $to;
                        if (isset(Yii::app()->memCache)) {
                            Yii::app()->memCache->delete($cacheTag);
                        } else {
                            Yii::app()->cache->delete($cacheTag);
                        }
                    }
                }
            }
            Yii::app()->cache->delete('MainMenu-admin-getTree');
        }
    }

    public static function getAddLevels($id, $status = [1, 2, 3])
    {

        $lang = Utils::appLang();
        return self::model()->getMainMenu(0, $lang, $id, $status);
    }

    public static function getCatList()
    {
        $recs = Yii::app()->db->createCommand(
          "SELECT cc2.id, cc4.ru AS parent_ru,cc2.ru, cc4.en  AS parent_en,cc2.en, cc4.zh  AS parent_zh,cc2.zh, cc2.parent
FROM categories_ext cc2
LEFT JOIN categories_ext cc4 ON cc4.id = cc2.parent
WHERE cc2.parent IN (SELECT cc1.id FROM categories_ext cc1
WHERE cc1.parent=1)
ORDER BY cc2.status DESC, cc2.order_in_level, cc2.id"
        )->queryAll();
        $res = [];
        if ($recs) {
            foreach ($recs as $rec) {
                if ($rec[Utils::transLang()] == '') {
                    continue;
                }
                if ($rec['parent_' . Utils::transLang()] == 'Root') {
                    $prefix = '';
                } else {
                    $prefix = '   -- ';
                }
                $res[$rec['id']] =
                  $prefix .
                  '(' .
                  $rec['id'] .
                  ') ' .
                  $rec['parent_' . Utils::transLang()] .
                  '\\' .
                  $rec[Utils::transLang()];
            }
        }
        return $res;
    }

    public static function getCatListRow($id, $tags = false, $sel = 0)
    {
        $lang = Utils::transLang();
        $recs = self::model()->findAll(
          [
            'select'    => "\"id\", \"cid\", \"parent\", \"status\", \"" . $lang . "\" ",
            'condition' => "\"parent\" = :parentId ",
            'params'    => [':parentId' => $id],
            'order'     => "\"status\" DESC, \"ru\" ",
          ]
        );

        $res = [];
        $rr = [0 => 0, 1 => ''];
        $flag = true;
        if ($recs) {
            foreach ($recs as $rec) {
                if ($rec[Utils::transLang()] == '') {
                    continue;
                }
                if ($tags) {
                    if ($flag) {
                        $flag = false;
                        $rr[0] = $rec['id'];
                    }
                    $rr[1] .= '<option value=' . $rec['id'];
                    if ($sel == $rec['id']) {
                        $rr[0] = $rec['id'];
                        $rr[1] .= ' selected="selected" ';
                    }
                    $rr[1] .= ' >(' . $rec['id'] . ') ' . $rec[$lang] . '</option>';
                } else {
                    $res[$rec['id']] = '(' . $rec['id'] . ') ' . $rec[$lang];
                }
            }
        }
        if ($tags) {
            return $rr;
        } else {
            return $res;
        }
    }

    public static function getCategoryImage($childCategories, $imageFormat)
    {
        if (!is_array($childCategories)) {
            return false;
        }
        if (count($childCategories) <= 4) {
            return false;
        }
        $result = false;
        $lastParentCat = end($childCategories);
        $parentCatId = $lastParentCat['parent'];
        if (isset(Yii::app()->memCache)) {
            $cachedVal = @Yii::app()->memCache->get('category-image-' . $parentCatId);
        } else {
            $cachedVal = @Yii::app()->cache->get('category-image-' . $parentCatId);
        }
        if ($cachedVal) {
            $staticPath = preg_replace('/\/protected$/is', '/assets', Yii::app()->basePath) . '/images.cache';
            $url = preg_replace('/^.+?\/([a-f0-9]{32}\.jpg)$/is', '\1', $cachedVal);
            $staticFileName = $staticPath . '/' . $url;
            if (file_exists($staticFileName)) {
                //http://img1.777.danvit.ru/img/index/url/dfb8d23e8350aa86268f3b7ab3848b89.jpg
                $cachedVal = preg_replace('/\/img\/index\/url\//is', '/assets/images.cache/', $cachedVal);
            }
            return $cachedVal;
        }
        shuffle($childCategories);
        foreach ($childCategories as $cat) {
            if (!isset($cat['cid']) || !isset($cat['query'])) {
                continue;
            }
            $res = Yii::app()->db->createCommand(
              "
        SELECT li.pic_url FROM log_items_requests li WHERE (li.cid=:cid OR :cid='0') AND (li.query = :query OR :query = '')
        -- group by li.num_iid
        -- ORDER BY random()  -- li.\"date\" desc -- count(0)
        LIMIT 1
        "
            )->queryScalar([':cid' => $cat['cid'], ':query' => $cat['query']]);
            if ($res) {
                $result = Img::getImagePath($res, $imageFormat, true, true);
                break;
            }
        }
        if (isset(Yii::app()->memCache)) {
            @Yii::app()->memCache->set('category-image-' . $parentCatId, $result, 3600);
        } else {
            @Yii::app()->cache->set('category-image-' . $parentCatId, $result, 3600);
        }
        return $result;
    }

    public static function getMainMenu(
      $callbackType,
      $lang,
      $fromId = 1,
      $status = [1, 2, 3],
      $depth = 3,
      $fromAPI = false
    ) {
        $result = [];
        $int_id_field = 'pkid';
        $data = Yii::app()->db->createCommand(
          "
SELECT
 id AS pkid,cid,ru,en,parent,status,url,zh,query,level,order_in_level, manual, decorate, ds_source
FROM categories_ext WHERE (id!=:id AND parent = :id) AND status IN (" . (implode(',', $status) !== '' ? implode(
            ',',
            $status
          ) : 'null') . ")
ORDER BY status DESC, order_in_level ASC, id ASC"
        )->queryAll(
          true,
          [
            ':id' => $fromId,
          ]
        );
        foreach ($data as $menucat) {
//------------------------------------------------------------
            if ($callbackType == 0) {
                if ($fromAPI) {
                    if ($lang == Utils::transLang($lang)) {
                        $menucat['view_text'] = $menucat[$lang];
                    } else {
                        $menucat['view_text'] = Yii::t(
                          '~category',
                          $menucat['zh'] ? $menucat['zh'] : $menucat['ru']
                        ); //$menucat[$lang];
                    }
                    unset($menucat['ru']);
                    unset($menucat['en']);
                    unset($menucat['zh']);
                    unset($menucat['manual']);
                    unset($menucat['status']);
                    unset($menucat['decorate']);
                    unset($menucat['url']);
                } else {
                    if ($lang == Utils::transLang($lang)) {
                        $menucat['view_text'] = $menucat[$lang];
                    } else {
                        $menucat['view_text'] = Yii::t('~category', $menucat['zh'] ? $menucat['zh'] : $menucat['ru']);
                    }
                    unset($menucat['ru']);
                    unset($menucat['en']);
                    unset($menucat['zh']);
                    unset($menucat['manual']);
                }
            } elseif ($callbackType == 1) {
                $menucat = self::renderTreeNode($menucat, $lang);
                $menucat['hasChildren'] = isset($menucat['children']);
                $menucat['expanded'] = false;
                $menucat['htmlOptions'] = [
                  'class' => 'admin-category-tree-node',
                  'id'    => 'admin-category-tree-node-' . $menucat['pkid'],
                ];
            }
//============================================================
            $result[$menucat['pkid']] = $menucat;
            //@todo: здесь может быть не < а <= ?
            if ($menucat['level'] < $depth) {
                $result[$menucat['pkid']]['children'] = self::getMainMenu(
                  $callbackType,
                  $lang,
                  $menucat[$int_id_field],
                  $status,
                  $depth,
                  $fromAPI
                );
            }
        }
        return $result;
    }

    public static function getMainMenuRecord($lang, $Id)
    {
        $result = [];
        $data = Yii::app()->db->createCommand(
          "SELECT id AS pkid,cid,ru,en,parent,status,url,zh,query,level,order_in_level, manual, decorate, ds_source
FROM categories_ext WHERE (id = :id) LIMIT 1"
        )->queryRow(
          true,
          [
            ':id' => $Id,
          ]
        );
        if ((count($data) > 0) && ($data != false)) {
            $result[$data['pkid']] = $data;
            $result[$data['pkid']]['view_text'] = $data[$lang];
            if ($data['status'] == 0) {
                $result[$data['pkid']]['text'] = CHtml::link(
                  '<i>' . $data[$lang] . '</i>',
                  [
                    "category/update",
                    "id" => $data['pkid'],
                  ],
                  [
                    "onclick" => "getContent(this,\"" . addslashes(
                        Yii::t(
                          'main',
                          'Категория'
                        ) . " №" . $data['pkid']
                      ) . "\",false);return false;",
                    "title"   => Yii::t('main', "Изменить параметры категории"),
                  ]
                );
            } else {
                $result[$data['pkid']]['text'] = CHtml::link(
                  $data[$lang],
                  [
                    "category/update",
                    "id" => $data['pkid'],
                  ],
                  [
                    "onclick" => "getContent(this,\"" . addslashes(
                        Yii::t(
                          'main',
                          'Категория'
                        ) . " №" . $data['pkid']
                      ) . "\",false);return false;",
                    "title"   => Yii::t('main', "Изменить параметры категории"),
                  ]
                );
            }
            $result[$data['pkid']]['hasChildren'] = true;
            $result[$data['pkid']]['expanded'] = true;
        }
        return $result;
    }

    public static function getMenuMain($callbackType, $lang, $fromId = 0, $status = [1, 2, 3], $fromAPI = false)
    {
        $ret = [];
        switch ($callbackType) {
            case 0:
                if ($fromAPI) {
                    $sel = ['cid', 'parent', 'query', 'level', 'order_in_level'];
                } else {
                    $sel = [
                      'cid',
                      'parent',
                      'url',
                      'query',
                      'level',
                      'status',
                      'order_in_level',
                      'decorate',
                      'ds_source',
                    ];
                }
                if ($lang == Utils::transLang($lang)) {
                    $select = 'id as pkid, ' . implode(',', $sel) . ', ' . $lang . ' as view_text ';
                    array_push($sel, 'view_text');
                } else {
                    $select = 'id as pkid, ' . implode(',', $sel) . ', ru, zh ';
                    array_push($sel, 'ru', 'zh');
                }
                array_unshift($sel, 'pkid');
                $res = self::model()->findAll(
                  [
                    'select' => $select,
                    'order'  => ' status DESC, order_in_level ASC, id ASC',
                  ]
                );
                return self::_getMenuArray($res, $sel, $fromId);
                break;
            default:
                $sel = [
                  'cid',
                  'parent',
                  'query',
                  'status',
                  'manual',
                  'ru',
                  'en',
                  'zh',
                  'order_in_level',
                  'ds_source',
                ];
                $res = self::model()->findAll(
                  [
                    'select' => 'id as pkid, ' . implode(',', $sel),
                    'order'  => ' status DESC, order_in_level ASC, id ASC',
                  ]
                );
                array_unshift($sel, 'pkid');
//				return self::_getMenuArray($res, $sel);
                return self::_getTree($res, $sel, $lang);
        }
//		$res = self::_getMenu($_menu, )
    }

    /*
     * Получить уровень каталога // для админки
     */

    public static function getParents($cat, $result, $level)
    {
        //TODO: тут потом сделать рекурсивный запрос вместо нескольких подзапросов и рекурсии на php
        $model = MainMenu::model()->find('id=:id', [':id' => $cat->parent]);
        if ($model) {
            $res = new stdClass();
            $res->id = $model->id;
            $res->cid = $model->cid;
            $res->url = self::getUrl($model);
            $res->parent = $model->parent;
            if (Utils::appLang() == Utils::transLang(Utils::appLang())) {
                $res->name = $model->{Utils::transLang()};
            } else {
                $res->name = Yii::t('~category', $model->zh ? $model->zh : $model->ru); //$model->{Utils::TransLang()};
            }
            $res->query = $model->query;
            $result[$level] = $res;

            if (($model->cid != -1)) {
                $result = self::getParents($res, $result, $level + 1);
            } else {
                array_pop($result);
            }
        }
        return $result;
    }

    /*
     * Получить последовательность родитель-потомок каталога в сторону root
     */

    public static function getParentsNames($cat)
    {
        $res = array_reverse(self::getParents($cat, [$cat], 1));
        array_pop($res);
        $result = [];
        foreach ($res as $r) {
            $result[] = $r->name;
        }
        return $result;
    }

    /*
* Получить последовательность каталогов
*/

    public static function getParentsUrls($cat)
    {
        $res = array_reverse(self::getParents($cat, [$cat], 1));
        array_pop($res);
        $result = [];
        foreach ($res as $r) {
            $result[] = $r->url;
        }
        return $result;
    }

    /*
     * Получить пункты каталога 1 уровня
     */

    public static function getUrl($model)
    {
        //TODO: Здесь может замутить рекурсию из базы, или как-то кэшить
        if (isset($model->url) && $model->url !== '') {
            return $model->url;
        } else {
            return '';
        }
    }

    /*
     * Получить остальные пункты каталога
     */

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MainMenu|DSMetatagableActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function renderTreeNode($menucat, $lang)
    {
        $menucat['text'] = Yii::app()->controller->widget(
          'application.modules.' . Yii::app()->controller->module->id . '.components.widgets.CatTreeNodeBlock',
          [
            'nodeData' => $menucat,
            'lang'     => $lang,
          ],
          true
        );
        /*
            [pkid] => 2
            [cid] => 0
            [ru] => Одежда
            [en] => Female attire men's clothing
            [parent] => 1
            [status] => 1
            [url] => mainmenu-odezhda
            [zh] => 女装男装
            [query] => 女装男装
            [level] => 2
            [text] => Одежда id:2 cid:0 q:女装男装 taobao:女装男装
            [hasChildren] =>
            [expanded] =>
        */
        unset($menucat['cid']);
        unset($menucat['ru']);
        unset($menucat['en']);
        unset($menucat['parent']);
        unset($menucat['status']);
        unset($menucat['url']);
        unset($menucat['zh']);
        unset($menucat['query']);
        return $menucat;
    }

    public static function storageCommand($command, $name)
    {

        $_name = $name;
        if ($command == 'save') {
            $res = Yii::app()->db->createCommand(
              'DELETE FROM \"categories_ext_storage\" WHERE \"store_name\" = :name;
INSERT INTO \"categories_ext_storage\" (\"store_name\",\"store_date\",\"id\",\"cid\",\"ru\",\"en\",\"parent\",\"status\",
 \"url\",\"zh\",\"query\",\"level\",\"order_in_level\",\"manual\",\"decorate\", \"ds_source\")
  SELECT :name, Now(), ce.\"id\",ce.\"cid\",ce.\"ru\",ce.\"en\",ce.\"parent\",ce.\"status\",
 ce.\"url\",ce.\"zh\",ce.\"query\",ce.\"level\",ce.\"order_in_level\",ce.\"manual\",ce.\"decorate\", ce.\"ds_source\" FROM categories_ext ce;'
            )->execute(
              [
                ':name' => $_name,
              ]
            );
            return $name . ': ' . Yii::t('admin', 'категории сохранены!');
        } elseif ($command == 'restore') {
            Yii::app()->db->createCommand(
              "DELETE FROM categories_ext"
            )->execute();
            Yii::app()->db->createCommand(
              "
-- SET FOREIGN_KEY_CHECKS=0;
INSERT INTO \"categories_ext\" (\"id\",\"cid\",\"ru\",\"en\",\"parent\",\"status\",
 \"url\",\"zh\",\"query\",\"level\",\"order_in_level\",\"manual\",\"decorate\",\"ds_source\")
SELECT \"id\",\"cid\",\"ru\",\"en\",\"parent\",\"status\",
 \"url\",\"zh\",\"query\",\"level\",\"order_in_level\",\"manual\",\"decorate\",\"ds_source\" FROM categories_ext_storage
WHERE \"store_name\"=:name
-- SET FOREIGN_KEY_CHECKS=1;"
            )->execute(
              [
                ':name' => $_name,
              ]
            );
            return $name . ': ' . Yii::t('admin', 'категории восстановлены!');
        } elseif ($command == 'delete') {
            Yii::app()->db->createCommand('DELETE FROM \"categories_ext_storage\" WHERE \"store_name\" = :name;')
              ->execute(
                [
                  ':name' => $_name,
                ]
              );
            return $name . ': ' . Yii::t('admin', 'категории удалены!');
        }
    }

    public static function updateMetaAndHFURLs($offset, $count)
    {
        if ($offset <= 0) {
            Yii::app()->db->createCommand(
              "UPDATE categories_ext cc
            SET parent=1 WHERE cc.id!=1 AND cc.parent=cc.id"
            )->execute();
        }
        $cats = MainMenu::model()->findAll("cid != '-1' order by parent limit " . $count . " OFFSET " . $offset);
        if ($cats == null || $cats == false) {
            MainMenu::clearMenuCache();
            Yii::app()->db->createCommand(
              "
DELETE FROM cms_metatags
WHERE 
(
cms_metatags.\"key\" NOT IN (SELECT categories_ext.url FROM categories_ext)
AND
cms_metatags.\"key\" NOT IN (SELECT brands.url FROM brands)
)
OR
(SELECT config.\"value\" FROM config WHERE config.id = 'site_language_supported') NOT LIKE concat('%',cms_metatags.lang,'%')
OR cms_metatags.\"value\" = ''
"
            )->execute();
//========== Немного приводим в порядок категоризатор ==================
            Yii::app()->db->createCommand(
              "
            UPDATE classifier cc
            SET url = '';
            UPDATE classifier cc
            SET url = (SELECT ca.url FROM categories_ext ca WHERE cc.ds_source = ca.ds_source AND cc.cid = ca.cid ORDER BY cc.level LIMIT 1)
            WHERE EXISTS (SELECT 'x' FROM categories_ext ca WHERE cc.ds_source = ca.ds_source AND cc.cid = ca.cid);
UPDATE classifier cc
SET url =
CONCAT(
TRIM( BOTH '/' FROM
CONCAT(
TRIM(BOTH '-' FROM REGEXP_REPLACE( 
LOWER(
 coalesce(cc2.en,'')
)
,'(?is)[^a-z\d\-]+','-')
),'/',
TRIM(BOTH '-' FROM REGEXP_REPLACE( 
LOWER(
 coalesce(cc.en,'')
)
,'(?is)[^a-z\d\-]+','-')
))),'/')
FROM classifier cc2
WHERE cc2.cid = cc.parent AND cc2.cid !='0'
AND cc.url = '' AND cc.cid != '0' AND cc.en NOT LIKE '%to be deleted%';       
            "
            )->execute();
//======================================================================
            return 'DONE';
        }
        foreach ($cats as $cat) {
            Utils::debugLog(CVarDumper::dumpAsString($cat));
            try {
                self::updateMetaAndHFURL($cat);
            } catch (Exception $e) {
                continue;
            }
        }
        return $offset + $count;
    }
}