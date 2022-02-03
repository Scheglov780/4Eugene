<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DicCustom.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "dic_custom".
 * The followings are the available columns in table 'dic_custom':
 * @property integer $val_id
 * @property string  $val_group
 * @property string  $val_name
 * @property string  $val_description
 */
class DicCustom extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'val_id'          => 'PK',
          'val_group'       => 'Группа справочника',
          'val_name'        => 'Значение параметра',
          'val_description' => 'Описание параметра',
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
          ['val_id, val_group', 'required'],
          ['val_id', 'numerical', 'integerOnly' => true],
          ['val_group, val_name', 'length', 'max' => 128],
          ['val_description', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          ['val_id, val_group, val_name, val_description', 'safe', 'on' => 'search'],
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
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;
        //$criteria->condition = "id LIKE '" . $this->id . "%'";
        $criteria->compare('val_id', $this->val_id);
        $criteria->compare('val_group', $this->val_group, true);
        $criteria->compare('val_name', $this->val_name, true);
        $criteria->compare('val_description', $this->val_description, true);

        return new CActiveDataProvider(
          $this, [
            'criteria'   => $criteria,
            'sort'       => [
              'defaultOrder' => 't.val_id ASC, t.val_group ASC, t.val_name ASC',
            ],
            'pagination' => [
              'pageSize' => 200,
            ],
          ]
        );
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'dic_custom';
    }

    public static function getVals($valGroup = null)
    {
        $res = self::model()->findAllBySql(
          "SELECT dc.val_id, dc.val_name FROM dic_custom dc
where dc.val_group = :val_group",
          [':val_group' => $valGroup]
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['val_id']] = $r['val_name'];
            }
        }
        return $resArr;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return DicCustom the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
