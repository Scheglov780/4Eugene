<?php

/**
 * This is the model class for table "scheduled_jobs".
 * The followings are the available columns in table 'scheduled_jobs':
 * @property string $id
 * @property string $job_script
 * @property string $job_start_time
 * @property string $job_stop_time
 * @property string $job_interval
 * @property string $job_description
 */
class customScheduledJobs extends CActiveRecord
{
    private static $lastExecuted;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'id'              => 'PK',
          'job_script'      => 'Скрипт задания, в формате eval',
          'job_start_time'  => 'Время начала выполнения скрипта',
          'job_stop_time'   => 'Время завершения скрипта',
          'job_interval'    => 'Интервал в секундах для выполнения задания. -1 - выкл, 0 - 1 раз в job_start_time',
          'job_description' => 'Описание скрипта',
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
          ['job_interval', 'length', 'max' => 20],
          ['job_script, job_start_time, job_stop_time, job_description', 'safe'],
            // The following rule is used by search().

          [
            'id, job_script, job_start_time, job_stop_time, job_interval, job_description',
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

        $criteria->compare('id', $this->id, true);
        $criteria->compare('job_script', $this->job_script, true);
        $criteria->compare('job_start_time', $this->job_start_time, true);
        $criteria->compare('job_stop_time', $this->job_stop_time, true);
        $criteria->compare('job_interval', $this->job_interval, true);
        $criteria->compare('job_description', $this->job_description, true);

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
        return 'scheduled_jobs';
    }

    public static function executeImmediate($id)
    {
        $job = self::model()->findByPk($id);
        if ($job) {
            if ($job->job_interval == 0) {
                $job->job_interval = -1;
            }
            $job->job_start_time = Yii::app()->db->createCommand('select Now()')->queryScalar();
            $job->update();
            $result = @eval($job->job_script);
            $job->job_stop_time = Yii::app()->db->createCommand("select Now()+INTERVAL '1 SECOND'")->queryScalar();
            $job->update();
        }
        return;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return ScheduledJobs|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function schedulerEvent()
    {
        $ttl = 120;
        if (true) {
            if (isset(Yii::app()->memCache)) {
                self::$lastExecuted = @Yii::app()->memCache->get('lastSchedulerExec');
                if (!self::$lastExecuted) {
                    self::$lastExecuted = time();
                    @Yii::app()->memCache->set('lastSchedulerExec', self::$lastExecuted, $ttl);
                } else {
                    return;
                }
            } else {
                self::$lastExecuted = @Yii::app()->cache->get('lastSchedulerExec');
                if (!self::$lastExecuted) {
                    self::$lastExecuted = time();
                    @Yii::app()->cache->set('lastSchedulerExec', self::$lastExecuted, $ttl);
                } else {
                    return;
                }
            }
        }

        $jobs = self::model()->findAllBySql(
          'SELECT * FROM scheduled_jobs sj
WHERE
-- для нерегулярных джобов. Выполнили - записали job_start_time и job_stop_time, забыли
(sj.job_start_time <= now() AND sj.job_stop_time IS NULL AND sj.job_interval=0)
-- для регулярных джобов
OR ((sj.job_stop_time IS NULL OR sj.job_stop_time<=(Now()- sj.job_interval * INTERVAL \'1 SECOND\'))
AND (sj.job_start_time IS NULL OR sj.job_start_time<=coalesce(sj.job_stop_time,now()))
AND sj.job_interval>0)'
        );
        if ($jobs) {
            foreach ($jobs as $job) {
                //Yii::app()->db->autoCommit = false;
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    if ($job->job_interval == 0) {
                        $job->job_interval = -1;
                    }
                    $job->job_start_time = Yii::app()->db->createCommand('select Now()')->queryScalar();
                    $job->update();
                    $result = @eval($job->job_script);
                    $job->job_stop_time =
                      Yii::app()->db->createCommand("select Now()+INTERVAL '1 SECOND'")->queryScalar();
                    if ($job->job_stop_time < $job->job_start_time) {
                        $job->job_stop_time = $job->job_start_time;
                    }
                    $job->update();
                    if ($transaction->active) {
                        $transaction->commit();
                    }
                    //Yii::app()->db->autoCommit = true;
                } catch (Exception $e) {
                    if (isset($transaction) && $transaction && $transaction->active) {
                        $transaction->rollback();
                    }
                    //Yii::app()->db->autoCommit = true;
                    Utils::debugLog(CVarDumper::dumpAsString($e));
                }
            }
        }
        return;
    }

}
