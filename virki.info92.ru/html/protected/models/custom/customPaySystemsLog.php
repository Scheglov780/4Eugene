<?php

/**
 * This is the model class for table "pay_systems_log".
 * The followings are the available columns in table 'pay_systems_log':
 * @property string $id
 * @property string $date
 * @property string $from_ip
 * @property string $action
 * @property string $data
 */
class customPaySystemsLog extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'      => 'PK',
          'date'    => 'Время транзакции',
          'from_ip' => 'IP-адрес, с которого вызывается транзакция',
          'action'  => 'Тип транзакции',
          'sender'  => 'Имя платёжной системы',
          'data'    => 'Данные',
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
          ['date, action, sender', 'required'],
          ['from_ip, action, sender', 'length', 'max' => 255],
            // The following rule is used by search().

          ['id, date, from_ip, action, sender, data', 'safe', 'on' => 'search'],
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
        $criteria->compare('date', $this->date, true);
        $criteria->compare('from_ip', $this->from_ip, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('sender', $this->action, true);
        $criteria->compare('data', $this->data, true);

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
        return 'pay_systems_log';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return PaySystemsLog the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
