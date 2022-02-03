<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="ModuleNews.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

/**
 * This is the model class for table "t_source_message".
 * The followings are the available columns in table 't_source_message':
 * @property string     $id
 * @property string     $category
 * @property string     $message
 * @property string     $message_md5
 * The followings are the available model relations:
 * @property TMessage[] $tMessages
 */
class TSourceMessage extends CActiveRecord
{//TSourceMessage intTranslationModel
    public $dst_corrected;
    public $dst_language;
    public $dst_translation;
    public $src_id;
    public $src_message;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        //ss.id, mm.`language`, ss.category, ss.message, mm.translation, mm.corrected
        return [
          'src_id'          => Yii::t('admin', 'ID'),
          'category'        => Yii::t('admin', 'Категория'),
          'message'         => Yii::t('admin', 'Сообщение'),
          'dst_translation' => Yii::t('admin', 'Перевод'),
          'dst_corrected'   => Yii::t('admin', 'Исправлено'),
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
            // 'tMessages' => array(self::HAS_MANY, 'TMessage', 'id'),
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
          ['category, message, message_md5', 'required'],
          ['category', 'length', 'max' => 16],
          ['message_md5', 'length', 'max' => 32],
          ['src_id, src_message, message, dst_language, dst_translation, dst_corrected', 'safe'],
            // The following rule is used by search().

          [
            'src_id,category, message, src_message, dst_language,dst_translation,dst_corrected,message_md5',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();
        //$criteria->alias = 'ss';
        $criteria->select = "t.id as src_id, t.category, t.message as src_message, t_message.language as dst_language,
        case 
        when :language = 'en' then t.message
        else concat(t.message,' ',(select gg.translation from t_message gg where gg.id=t.id and gg.language = 'en'))
         end as message, 
        t_message.translation as dst_translation, t_message.corrected as dst_corrected";
        $criteria->condition = "t.category in ('admin','main') and t.message != t_message.translation";
        $criteria->join = "left join t_message on t.id = t_message.id and t_message.\"language\" = :language";
        $criteria->params = [':language' => Utils::appLang()];
        $requestParams = array_merge($_GET, $_POST, $_REQUEST);

        /*        if (isset($requestParams['Order'])) {
                    if (isset($requestParams['Order']['id'])) {
                        $criteria->compare('t.id', $requestParams['Order']['id']);
                    }
                    if (isset($requestParams['Order']['textdate'])) {
                        $criteria->compare("FROM_UNIXTIME(t.date,'%d.%m.%Y %H:%i')", $requestParams['Order']['textdate'], true);
                    }
                }
        */
        $sort = [
            // Indicate what can be sorted
          'attributes' => [
            'category'        => [
              'asc'  => "t_message.corrected is null DESC, t.category ASC, t.message ASC, t_message.corrected DESC",
              'desc' => "t_message.corrected is null DESC, t.category DESC, t.message ASC, t_message.corrected DESC",
            ],
            'message'         => [
              'asc'  => "t.message ASC",
              'desc' => "t.message DESC",
            ],
            'dst_translation' => [
              'asc'  => "t_message.translation ASC",
              'desc' => "t_message.translation DESC",
            ],
            'dst_corrected'   => [
              'asc'  => "t_message.corrected ASC",
              'desc' => "t_message.corrected DESC",
            ],
          ],
            // Default order in CGridview
            //'defaultOrder' => array(
            //  'category' => CSort::SORT_ASC,
            //)
        ];
        $result = new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'id'         => 'translation-correction-dataProvider',
            'sort'       => $sort,
            'pagination' => [
              'pageSize' => 100,
            ],
          ]
        );
        return $result;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 't_source_message';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return intTranslationModel|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function updateList($list)
    {
        foreach ($list as $id => $item) {
            $src = $item['src'];
            foreach ($item as $lang => $translation) {
                if ($lang == 'src') {
                    continue;
                }
                $translation = trim($translation);
                if (preg_match('/^\s/s', $src)) {
                    $translation = ' ' . ltrim($translation);
                }
                if (preg_match('/\s$/s', $src)) {
                    $translation = ' ' . rtrim($translation);
                }
                Yii::app()->db->createCommand(
                  "
                update t_message
                set translation = :translation,
                corrected = Now()
                WHERE id = :id and language = :lang and translation != :translation
AND NOT EXISTS (SELECT 'x' from t_message mm2 WHERE mm2.id = :id and mm2.language = :lang and mm2.translation = :translation)
                "
                )->execute([':translation' => $translation, ':id' => $id, ':lang' => $lang]);
            }
        }
        return true;
    }
}
