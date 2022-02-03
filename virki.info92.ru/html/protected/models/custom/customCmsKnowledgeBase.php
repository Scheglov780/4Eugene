<?php

/**
 * This is the model class for table "cms_knowledge_base".
 * The followings are the available columns in table 'cms_knowledge_base':
 * @property string $id
 * @property string $lang
 * @property string $tag
 * @property string $key
 * @property string $value
 * @property string $search
 */
class customCmsKnowledgeBase extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'    => 'ID',
          'lang'  => Yii::t('admin', 'Язык'),
          'tag'   => 'Tag',
          'key'   => Yii::t('admin', 'Ключ'),
          'value' => Yii::t('admin', 'Контент'),
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
          ['key, value', 'required'],
          ['lang', 'length', 'max' => 2],
          ['tag', 'length', 'max' => 255],
          ['search', 'safe'],
            // The following rule is used by search().

          ['id, lang, tag, key, value, search', 'safe', 'on' => 'search'],
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('lang', $this->lang, true);
        $criteria->compare('tag', $this->tag, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('value', $this->value, true);

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
        return 'cms_knowledge_base';
    }

    public static function fullTextSearch($query, $lang = false, $tag = false, $count = 1)
    {
//TODO: в редактировании категорий разобраться с функцией dv_stem и вобще.
        try {
            if (!$query) {
                return '';
            }
            $res = Yii::app()->db->createCommand(
              "
SELECT kb.lang, kb.tag, kb.key, kb.value FROM cms_knowledge_base kb
WHERE \"key\"=:query
AND (:lang IS NULL OR lang=:lang) AND (:tag IS NULL OR tag=:tag)
UNION ALL
        SELECT kb.lang, kb.tag, kb.key, kb.value FROM cms_knowledge_base kb
WHERE 
  to_tsvector('russian',\"key\") @@ websearch_to_tsquery('russian',:query)  
AND (:lang IS NULL OR lang=:lang) AND (:tag IS NULL OR tag=:tag)
order by ts_rank(to_tsvector('russian',\"key\"), websearch_to_tsquery('russian',:query)) desc
 "
            )->queryAll(
              true,
              [
                ':lang'  => ($lang ? $lang : null),
                ':tag'   => ($tag ? $tag : null),
                ':query' => $query,
              ]
            );
            if ($res) {
                if ($count == 1) {
                    return $res[0]['value'];
                }
                $resArray = [];
                foreach ($res as $i => $record) {
                    $resArray[] = $record['value'];
                    if ($i + 1 >= $count) {
                        break;
                    }
                }
                return $resArray;
            } else {
                return '';
            }
        } catch (Exception $e) {
            return '';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return CmsKnowledgeBase the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
