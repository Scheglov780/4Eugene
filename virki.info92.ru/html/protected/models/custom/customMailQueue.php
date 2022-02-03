<?php

/**
 * This is the model class for table "mail_queue".
 * The followings are the available columns in table 'mail_queue':
 * @property integer $id
 * @property string  $from
 * @property string  $from_name
 * @property string  $to
 * @property string  $subj
 * @property string  $body
 * @property integer $priority
 * @property string  $created
 * @property string  $processed
 * @property string  $result
 * @property string  $event_id
 * @property string  $posting_id
 */
class customMailQueue extends CActiveRecord
{
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'         => 'ID',
          'from'       => 'From',
          'from_name'  => 'From Name',
          'to'         => 'To',
          'subj'       => 'Subj',
          'body'       => 'Body',
          'priority'   => 'Больше -> выше',
          'created'    => 'Created',
          'processed'  => 'Processed',
          'result'     => 'Result',
          'event_id'   => 'Event',
          'posting_id' => 'Posting',
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
          ['from, to, subj, body, created', 'required'],
          ['priority', 'numerical', 'integerOnly' => true],
          ['from, from_name, to', 'length', 'max' => 512],
          ['subj', 'length', 'max' => 1024],
          ['result', 'length', 'max' => 255],
          ['event_id', 'length', 'max' => 10],
          ['posting_id', 'length', 'max' => 32],
          ['processed', 'safe'],
            // The following rule is used by search().

          [
            'id, from, from_name, to, subj, body, priority, created, processed, result, event_id, posting_id',
            'safe',
            'on' => 'search',
          ],
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

        $criteria->compare('id', $this->id);
        $criteria->compare('from', $this->from, true);
        $criteria->compare('from_name', $this->from_name, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('subj', $this->subj, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('priority', $this->priority);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('processed', $this->processed, true);
        $criteria->compare('result', $this->result, true);
        $criteria->compare('event_id', $this->event_id, true);
        $criteria->compare('posting_id', $this->posting_id, true);

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
        return 'mail_queue';
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return MailQueue the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }
}
