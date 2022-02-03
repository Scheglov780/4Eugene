<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="Users.php">
 * </description>
 **********************************************************************************************************************/
?>
<?php

/**
 * This is the model class for table "obj_lands".
 * The followings are the available columns in table 'obj_lands':
 * @property integer $lands_id
 * @property string  $land_number
 * @property string  $land_number_cadastral
 * @property integer $land_type
 * @property integer $status
 * @property string  $address
 * @property string  $created
 * @property string  $comments
 * @property string  $land_group
 * @property double  $land_area
 * @property double  $land_geo_latitude
 * @property double  $land_geo_longitude
 * The followings are the available model relations:
 * @property string  $devices
 * @property string  $users
 * @property string  $tariffs
 */
class customLands extends DSRelatableActiveRecord
{
    public $devices;
    public $land_type_name;
    public $tariffs;
    public $users;

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'lands_id'              => Yii::t('main', 'ID'),
          'land_number'           => Yii::t('main', 'Номер участка'),
          'land_number_cadastral' => Yii::t('main', 'Кадастровый номер'),
          'land_type'             => Yii::t('main', 'Статус'),
          'status'                => Yii::t('main', 'Проверен'),
          'address'               => Yii::t('main', 'Адрес'),
          'created'               => Yii::t('main', 'Создан'),
          'comments'              => Yii::t('main', 'Комментарии'),
          'land_group'            => Yii::t('main', 'Группа'),
          'land_area'             => Yii::t('main', 'Площадь'),
          'land_geo_latitude'     => Yii::t('main', 'Широта'),
          'land_geo_longitude'    => Yii::t('main', 'Долгота'),
          'users'                 => Yii::t('main', 'Пользователи'),
          'devices'               => Yii::t('main', 'Приборы'),
          'tariffs'               => Yii::t('main', 'Тарифы'),
        ];
    }

    public function getAttributes($names = true)
    {
        $attr = parent::getAttributes($names);
        return $attr;
    }

    public function insert($attributes = null)
    {
        $res = parent::insert($attributes);
        if ($res && isset($this->devices) && is_array($this->devices)) {
            $res = $this->setRelatable('devices', $this->devices);
        }
        if ($res && isset($this->tariffs) && is_array($this->tariffs)) {
            $res = $this->setRelatable('tariffs', $this->tariffs);
        }
        if ($res && isset($this->users) && is_array($this->users)) {
            $res = $this->setRelatable('parent_users', $this->users);
        }
        return $res;
    }

    /*
public static function getLand($id)
{
    $device = self::model()->findByPk($id);
    if ($device) {
        $device->userBalance = self::getBalance($user->uid);
        $device->payments = new Payment('search');
        $device->payments->unsetAttributes(); // clear any default values
        $device->payments->uid = $uid;

        //$user->addresses = new Addresses('search');
        //$user->addresses->unsetAttributes(); // clear any default values
        //$user->addresses->uid = $uid;

        $user->manager = self::model()
          ->find("uid=:manager and role not in ('user','guest')", array('manager' => $user->default_manager));
    }
    return $user;
}
*/

    /**
     * @return array relatable rules.
     */
    public function relatable()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'devices'      => [
            'detailTable'            => 'obj_devices_manual',
            'detailTablePK'          => 'devices_id',
            'relatableTable'         => 'obj_lands_devices',
            'relatableTablePK'       => 'lands_devices_id',
            'relatableTableMasterId' => 'lands_id',
            'relatableTableDetailId' => 'devices_id',
          ],
          'tariffs'      => [
            'detailTable'            => 'obj_tariffs',
            'detailTablePK'          => 'tariffs_id',
            'relatableTable'         => 'obj_lands_tariffs',
            'relatableTablePK'       => 'lands_tariffs_id',
            'relatableTableMasterId' => 'lands_id',
            'relatableTableDetailId' => 'tariffs_id',
          ],
          'parent_users' => [
            'detailTable'            => 'obj_lands',
            'detailTablePK'          => 'lands_id',
            'relatableTable'         => 'obj_users_lands',
            'relatableTablePK'       => 'users_lands_id',
            'relatableTableMasterId' => 'uid',
            'relatableTableDetailId' => 'lands_id',
          ],
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
          'objLandsDevices' => [self::HAS_MANY, 'ObjLandsDevices', 'lands_id'],
          'objLandsTariffs' => [self::HAS_MANY, 'ObjLandsTariffs', 'lands_id'],
          'objUsersLands'   => [self::HAS_MANY, 'ObjUsersLands', 'lands_id'],
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
          ['lands_id,land_group,land_number', 'required'],
          ['lands_id, status, land_type', 'numerical', 'integerOnly' => true],
          ['land_number, land_group', 'length', 'max' => 64],
          ['land_number_cadastral', 'length', 'max' => 128],
          ['land_area', 'length', 'max' => 8],
          ['land_geo_latitude, land_geo_longitude', 'length', 'max' => 10],
          ['address, comments', 'safe', 'on' => 'update'],
          [
            'lands_id, created',
            'unsafe',
            'on'                     => 'update',
            'safe'                   => true,
            'skipOnError'            => true,
            'enableClientValidation' => false,
          ],
          [
            'users, devices, tariffs',
            'safe',
            'on'                     => 'update,create',
            'skipOnError'            => true,
            'enableClientValidation' => false,
          ],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
          [
            'lands_id, users, devices, tariffs, land_number, land_number_cadastral, status, address,land_type, created, comments, uid, land_group, land_area, land_geo_latitude, land_geo_longitude',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null)
    {
        if (!$criteria) {
            $criteria = new CDbCriteria;
        }
        if (!$dataProviderId) {
            $dataProviderId = lcfirst((new ReflectionClass($this))->getShortName()) . '_dataProvider';
        }

//    $criteria->select ="select SUM(payments.sum) as payments_sum";
        //where uid=". Topic.topicId, Topic.extension from Topic order by Topic.startDate desc limit 1,2) as Topic ON Topic.topicId = Rant.topicId LEFT JOIN User on User.userId = Rant.userId';
//    $criteria->join='LEFT JOIN payments pp ON pp.uid=t.uid';
        $criteria->select =
          /** @lang PostgreSQL */
          "t.*,
(select dc.val_name from dic_custom dc where dc.val_id = t.land_type and dc.val_group = 'LAND_TYPE') as land_type_name,
(select jsonb_agg(rdevices) from (
select ul.lands_devices_id, ul.lands_id, ll.* from obj_lands_devices ul
left join obj_devices_view ll on ll.devices_id = ul.devices_id
where ul.lands_id = t.lands_id and ul.deleted is null
order by ul.created
) rdevices) as devices,
(select jsonb_agg(rtariffs) from (
select ul.lands_tariffs_id, ul.lands_id, ll.* from obj_lands_tariffs ul
left join obj_tariffs ll on ll.tariffs_id = ul.tariffs_id
where ul.lands_id = t.lands_id and ul.deleted is null
order by ul.created
) rtariffs) as tariffs,
(select jsonb_agg(rusers) from (
select ld.users_lands_id, ld.lands_id, dd.* from obj_users_lands ld 
left join users dd on dd.uid = ld.uid
where ld.lands_id = t.lands_id and ld.deleted is null
order by ld.created
) rusers ) as users
  ";
//    $criteria->select = new CDbExpression("DATE_FORMAT(created, '%Y-%m-%d') AS created");

        // $criteria->compare('lands_id',$this->lands_id);
        if ($this->land_number) {
            $criteria->addSearchCondition('land_number', $this->land_number, true, 'AND', 'ILIKE');
        }
        $criteria->compare('land_number_cadastral', $this->land_number_cadastral, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('land_type', $this->land_type);
        if ($this->address) {
            $criteria->addSearchCondition('address', $this->address, true, 'AND', 'ILIKE');
        }
        $criteria->compare('created', $this->created, true);
        if ($this->comments) {
            $criteria->addSearchCondition('comments', $this->comments, true, 'AND', 'ILIKE');
        }
//        $criteria->compare('uid',$this->uid);
        if ($this->land_group) {
            $criteria->addSearchCondition('land_group', $this->land_group, true, 'AND', 'ILIKE');
        }
        /*
        * lands_id
        * land_group
        * land_number
        * land_number_cadastral
        * address
        * land_area
        * land_geo_latitude
        * land_geo_longitude
        * created
        * status
        * comments
        */
        $dataProvider = new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'land_group'            => [
                  'asc'  => 'land_group ASC',
                  'desc' => 'land_group DESC',
                ],
                'land_number'           => [
                  'asc'  => 'substring(t.land_number,\'(\d+)\')::integer ASC, t.land_number ASC',
                  'desc' => 'substring(t.land_number,\'(\d+)\')::integer DESC, t.land_number DESC',
                ],
                'land_number_cadastral' => [
                  'asc'  => 'land_number_cadastral ASC',
                  'desc' => 'land_number_cadastral DESC',
                ],
                'address'               => [
                  'asc'  => 'address ASC',
                  'desc' => 'address DESC',
                ],
                'status'                => [
                  'asc'  => 'status ASC',
                  'desc' => 'status DESC',
                ],
                'created'               => [
                  'asc'  => 't.created ASC',
                  'desc' => 't.created DESC',
                ],
              ],
              'defaultOrder' => [
                'land_number' => CSort::SORT_ASC,
              ],
            ],
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $dataProvider;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'obj_lands';
    }

    public function update($attributes = null)
    {
        $res = parent::update($attributes);
        if ($res && isset($this->devices) && is_array($this->devices)) {
            $res = $this->setRelatable('devices', $this->devices);
        }
        if ($res && isset($this->tariffs) && is_array($this->tariffs)) {
            $res = $this->setRelatable('tariffs', $this->tariffs);
        }
        if ($res && isset($this->users) && is_array($this->users)) {
            $res = $this->setRelatable('parent_users', $this->users);
        }
        return $res;
    }

    public static function getGroups()
    {
        $res = self::model()->findAllBySql("SELECT land_group FROM obj_lands GROUP BY land_group", []);
        $resArr = [];
        if (($res != false) && ($res != null)) {
            foreach ($res as $r) {
                $resArr[$r['land_group']] = $r['land_group'];
            }
        }
        return $resArr;
    }

    public static function getList($id = null, $getParents = false)
    {
        if (is_null($id)) {
            $sql = "select ll.lands_id, ll.land_group, ll.land_number,
(select count(0) from obj_users_lands ul where ul.lands_id = ll.lands_id and ul.deleted is null) as users
from obj_lands ll
order by ll.land_group, substring(ll.land_number,'(\d+)')::integer, ll.land_number";
            $res = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            if (!$getParents) {
                $sql = "select ul.lands_id
from obj_users_lands ul where ul.deleted is null and ul.uid = :id";
                $res = Yii::app()->db->createCommand($sql)->queryColumn(
                  [
                    ':id' => $id,
                  ]
                );
            } else {
                $sql = "select ul.uid
from obj_users_lands ul where ul.deleted is null and ul.lands_id = :id";
                $res = Yii::app()->db->createCommand($sql)->queryColumn(
                  [
                    ':id' => $id,
                  ]
                );
            }
        }
        if (!is_array($res)) {
            $res = [];
        }
        return $res;
    }

    public static function getListForDropDown()
    {
        $res = self::model()->findAllBySql(
          "select ll.lands_id, ll.land_group, ll.land_number
                from obj_lands ll
               order by ll.land_group, substring(ll.land_number,'(\d+)')::integer, ll.land_number",
          []
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['lands_id']] = $r['land_group'] . '/№' . $r['land_number'];
            }
        }
        return $resArr;
    }

    public static function getListForFilter()
    {
        $res = self::model()->findAllBySql(
          "select t.lands_id, t.land_group||'/№'||t.land_number as land_number
                      from obj_lands t order by t.land_group ASC, substring(t.land_number,'(\d+)')::integer ASC, t.land_number",
          []
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['lands_id']] = $r['land_number'];
            }
        }
        return $resArr;
    }

    public static function getModelSearchSnippet($id, $query)
    {
        if (!function_exists('markup')) {
            function markup($val, $query)
            {
                $result = @preg_replace('/' . $query . '/i', '<strong>' . $query . '</strong>', $val);
                if (isset($result) && $result) {
                    return $result;
                } else {
                    return $val;
                }
            }
        }
        $land = self::model()->findByPk($id);
        $res = '';
        $fields = [
          'land_group',
          'land_number',
          'address',
        ];
        if ($land) {
            foreach ($fields as $field) {
                if (strlen($land->{$field}) > 0) {
                    $res = $res . '<small>' . $land->getAttributeLabel($field) . ':</small> ' . markup(
                        $land->{$field},
                        $query
                      ) . '&nbsp;';
                }
            }
        }
        return $res;
    }

    public static function getUpdateLink($id, $external = false, $land = null, $value = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($land)) {
            $land = self::model()->findByPk($id);
        }
        if ($land) {
            if (is_null($value)) {
                $value = $land->land_group . '/№' . $land->land_number;
            }
            $tabName = $land->land_group . '/№' . $land->land_number;
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/lands/view/id/' . $id . '&tabName=' . addslashes($tabName);
            } else {
                $url = Yii::app()->createUrl(
                  '/' . Yii::app()->controller->module->id . '/lands/view',
                  ['id' => $id]
                );
                return '<a href="' . $url . '" title="' . Yii::t(
                    'admin',
                    'Просмотр профиля участка'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    $tabName
                  ) . '\',false);return false;"><i class="fa fa-fort-awesome"></i>&nbsp;' . addslashes($value) . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Lands|DSRelatableActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

}