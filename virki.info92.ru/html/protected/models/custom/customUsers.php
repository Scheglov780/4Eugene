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
 * This is the model class for table "users".
 * The followings are the available columns in table 'users':
 * uid email password status role phone default_manager created fullname contacts comments
 * debtor_status post_address personal_data contracts
 * ======== Fields from table users
 * @property integer     $uid
 * @property string      $email
 * @property string      $password
 * @property integer     $status
 * @property integer     $checked
 * @property string      $role
 * @property string      $phone
 * @property integer     $default_manager
 * @property integer     $created
 * @property string      $fullname
 * @property string      $contacts
 * @property string      $comments
 * @property integer     $debtor_status
 * @property string      $post_address
 * @property string      $personal_data
 * @property string      $contracts
 * //debtor_status_name lands devices roleDescr default_manager_name ordersCNT ordersLast
 * ======== Fields from related tables in search scenario
 * @property string      $default_manager_name Name of manager
 * @property string      $debtor_status_name   Debtor status name
 * @property string      $roleDescr            Description of role
 * @property string|json $lands                json of user lands
 * @property string|json $devices              json of user devices
 * @property string|json $payments             json of user payments
 * @property string|json $users                json of users for manager
 */
class customUsers extends DSRelatableActiveRecord
{
    public $confirmationLink;
    public $debtor_status_name;
    public $default_manager_name;
    public $devices;
    public $lands;
    public $new_email;
    public $new_password;
    public $payments; //json of user payments
    public $roleDescr; //user balanse
//============================
//============================
    // !!! public $ordersLast; //?
    // !! public $ordersCNT;
    // !!! public $payments; //?
    public $userBalance; //?
    public $users; //?
    // !!! public $users; //?
    // !!! public $usersOrders; //?
    // !!! public $usersOrdersEvents; //?
    // !!! public $usersOrdersMessages; //?

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
          'uid'                  => Yii::t('main', 'ID'),
          'fullname'             => Yii::t('main', 'ФИО'),
          'status'               => Yii::t('main', 'Статус'),
          'checked'              => Yii::t('main', 'Данные проверены'),
          'password'             => Yii::t('main', 'Пароль'),
          'created'              => Yii::t('main', 'Дата регистрации'),
          'contacts'             => Yii::t('main', 'Контакты'),
          'comments'             => Yii::t('main', 'Комментарии'),
          'debtor_status'        => 'Статус должника',
          'post_address'         => 'Почтовый адрес',
          'personal_data'        => 'Персональные данные',
          'contracts'            => 'Договоры',
//============================
          'new_email'            => Yii::t('main', 'EMail'),
          'new_password'         => Yii::t('main', 'Новый пароль'),
//============================
          'email'                => Yii::t('main', 'EMail'),
          'phone'                => Yii::t('main', 'Телефон'),
          'role'                 => Yii::t('main', 'Роль'),
          'roleDescr'            => Yii::t('main', 'Описание роли'),
            //'paymentsSUM'          => Yii::t('main', 'Введено средств'),
          'userBalance'          => Yii::t('main', 'Баланс'),
            //'ordersCNT'            => Yii::t('main', 'Заказов'),
            //'ordersLast'           => Yii::t('main', 'Активность'),
//============================
          'default_manager'      => Yii::t('main', 'Менеджер'),
          'default_manager_name' => Yii::t('main', 'Менеджер'),
//============================
          'lands'                => Yii::t('main', 'Участки'),
          'devices'              => Yii::t('main', 'Приборы'),
          'payments'             => Yii::t('main', 'Платежи'),
        ];
    }

    public function getAttributes($names = true)
    {
        $attr = parent::getAttributes($names);
        unset($attr['normalized_email']);
        return $attr;
    }

    public function insert($attributes = null)
    {
        if ($this->new_email && ($this->email != $this->new_email)) {
            $this->email = $this->new_email;
            if (is_array($attributes)) {
                $attributes[] = 'email';
            }
        }
        if ($this->new_password) {
            $this->password = md5($this->new_password);
            if (is_array($attributes)) {
                $attributes[] = 'password';
            }
        }
        $newPhone = preg_replace('/[^\d]+/isu', '', $this->phone);
        if ($newPhone !== $this->phone) {
            $this->phone = $newPhone;
            if (is_array($attributes)) {
                $attributes[] = 'phone';
            }
        }
        if (!$attributes) {
            $attributes = $this->getAttributes();
        }
        $res = parent::insert($attributes);
        if ($res && isset($this->lands) && is_array($this->lands)) {
            $res = $this->setRelatable('lands', $this->lands);
        }
        return $res;
    }

    public function login($login, $password, $rememberMe = false, $redirect = true, $silent = false)
    {
        if (isset(Yii::app()->user->returnUrl)) {
            $returnUrl = Yii::app()->user->returnUrl;
        } else {
            $returnUrl = false;
        }
        if (preg_match('/user\//i', $returnUrl)) {
            $returnUrl = false;
        } elseif (preg_match('/' . DSConfig::getVal('site_domain') . '\//i', $returnUrl)) {
            $returnUrl = false;
        }
        //$returnUrl=Yii::app()->request->urlReferrer;
        $identity = new UserIdentity($login, $password);
        if ($identity->authenticate()) {
            if ($rememberMe !== false) {
                Yii::app()->user->login($identity, 3600 * 24 * 365);
            } else {
                Yii::app()->user->login($identity, 3600 * 24);
            }
            if ($redirect && !$silent) {
                if ($returnUrl) {
                    Yii::app()->request->redirect($returnUrl);
                } else {
                    Yii::app()->controller->redirect('/cabinet');
                }
            } else {
                return true;
            }
        } else {
            if (!$silent) {
                Yii::app()->user->setFlash('loginError', $identity->errorMessage);
            }
            if ($identity->errorCode == 200) {
                return null;
            } else {
                return false;
            }
        }
    }

    /**
     * @return array relatable rules.
     */
    public function relatable()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
          'lands' => [
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
            // 'addresses'           => array(self::HAS_MANY, 'Addresses', 'uid'),
            // 'ModuleTabsHistories'  => array(self::HAS_MANY, 'ModuleTabsHistory', 'uid'),
            // 'carts'               => array(self::HAS_MANY, 'Cart', 'uid'),
            // 'eventsLogs'          => array(self::HAS_MANY, 'EventsLog', 'uid'),
            // 'orders'              => array(self::HAS_MANY, 'Orders', 'manager'),
            // 'orders1'             => array(self::HAS_MANY, 'Orders', 'uid'),
            // 'ordersComments'      => array(self::HAS_MANY, 'OrdersComments', 'uid'),
            // 'ordersItemsComments' => array(self::HAS_MANY, 'OrdersItemsComments', 'uid'),
            // 'payments'            => array(self::HAS_MANY, 'Payments', 'uid'),
            // 'questions'           => array(self::HAS_MANY, 'Questions', 'uid'),
            // 'userNotices'         => array(self::HAS_MANY, 'UserNotice', 'uid'),
            // 'role0'               => array(self::BELONGS_TO, 'AccessRights', 'role'),
        ];
    }

    public function requiredRule($attribute, $params)
    {
        if (empty($this->phone)
          && empty($this->email)
        ) {
            $this->addError($attribute, 'Должен быть указан как минимум номер телефона или email');
            return false;
        }
        return true;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        //@todo: заменить сценарий create на insert
        return [
          ['uid, fullname', 'required', 'on' => 'update'],
          ['fullname', 'required', 'on' => 'insert'],
          ['email,phone', 'requiredRule'],
          ['status, checked, default_manager', 'numerical', 'integerOnly' => true],
          ['email,new_email,role', 'length', 'max' => 64],
          [
            'email,new_email',
            'email',
            'allowName' => false,
            'pattern'   => '/[a-z0-9\-\.\+%_]+@[a-z0-9\.\-]+\.[a-z]{2,6}/i',
          ],
          ['password, new_password, fullname', 'length', 'max' => 128],
          ['phone', 'length', 'max' => 32],
          [
            'comments,contacts,default_manager_name,debtor_status,checked,post_address,personal_data,contracts',
            'safe',
            'on' => 'update, insert',
          ],
          [
            'uid,created',
            'unsafe',
            'on'                     => 'update,insert', //
            'safe'                   => true,
            'skipOnError'            => true,
            'enableClientValidation' => false,
          ],
          [
            'lands,devices',
            'safe',
            'on'                     => 'update,insert',
            'skipOnError'            => true,
            'enableClientValidation' => false,
          ],
            // The following rule is used by search().

          [
            'uid, email, status, checked, fullname, created, role, phone, default_manager, debtor_status, post_address, personal_data, contracts, lands, devices',
            'safe',
            'on' => 'search',
          ],
        ];
    }

    public function save($runValidation = true, $attributes = null)
    {
        $res = parent::save($runValidation, $attributes);
        return $res;
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
          "t.uid, t.email, t.password, t.status, t.checked, t.role, t.phone, t.default_manager, t.created,
t.fullname, t.contacts, t.comments, t.debtor_status, t.post_address, t.personal_data, t.contracts,
dc1.val_name as debtor_status_name,
(select jsonb_agg(rlands) from (
select ul.users_lands_id, ul.uid, ll.* from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created
) rlands) as lands,
(select jsonb_agg(rdevices) from (
select ld.lands_devices_id, ld.lands_id, dd.* from obj_lands_devices ld 
join obj_devices_view dd on dd.devices_id = ld.devices_id
where ld.lands_id in
(select ul.lands_id from obj_users_lands ul
where ul.uid = t.uid and ul.deleted is null) and ld.deleted is null
order by ld.created
) rdevices) as devices,
(select jsonb_agg(rpayments) from (
select pp.*, statuses.status_name, uu4.phone, uu4.fullname, uu4.fullname as manager_name from payments pp 
left join (
      values(1, 'Зачисление или возврат средств'),
			(2, 'Снятие средств'),
			(3, 'Ожидание зачисления средств'),
			(4, 'Отмена ожидания зачисления средств'),
			(5, 'Отправка внутреннего перевода средств'),
            (6, 'Получение внутреннего перевода средств'),
			(7, 'Зачисление бонуса или прибыли'),
			(8, 'Вывод средств из системы')
) statuses(status,status_name) on statuses.status = pp.status
left join users uu4 on uu4.uid=pp.uid
where pp.uid=t.uid and pp.status in (1,2,5,6,7,8) order by pp.date desc
) rpayments) as payments,
rr.description as \"roleDescr\",
uu1.fullname as default_manager_name,
(SELECT sum(coalesce(pp3.sum,0)) AS \"sum\"  FROM (SELECT sum(coalesce(pp2.sum, 0)) AS \"sum\"
            FROM payments pp2
           WHERE     pp2.uid = t.uid
                 AND status IN (1,2,5,6,7,8)
/*          UNION ALL
       SELECT sum(0 - coalesce(summ, 0)) AS \"sum\"
            FROM bills_payments op
           WHERE op.bid IN (SELECT oo.id
                              FROM bills_for_statuses_view oo
                             WHERE     oo.uid = t.uid
                                   AND oo.status NOT IN ('EXPIRED','CANCELED_BY_SERVICE')) */
                                   ) pp3) as \"userBalance\"";
        $criteria->join = $criteria->join .
          /** @lang PostgreSQL */
          "
left join dic_custom dc1 on dc1.val_id = t.debtor_status and dc1.val_group = 'DEBTOR_STATUS'
left join access_rights rr on rr.role = t.role
left join users uu1 on uu1.uid=t.default_manager
";
//    $criteria->select = new CDbExpression("DATE_FORMAT(created, '%Y-%m-%d') AS created");

        $criteria->compare('t.uid', $this->uid);
        if ($this->email) {
            $criteria->addSearchCondition('t.email', $this->email, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.checked', $this->checked);
        if ($this->fullname) {
            $criteria->addSearchCondition('t.fullname', $this->fullname, true, 'AND', 'ILIKE');
        }
        $criteria->compare('t.created', $this->created);
        $criteria->compare('t.role', $this->role, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.default_manager', $this->default_manager);
        $criteria->compare('t.debtor_status', $this->debtor_status);

        $dataProvider = new CActiveDataProvider(
          $this, [
            'id'         => $dataProviderId,
            'criteria'   => $criteria,
            'sort'       => [
                // Indicate what can be sorted
              'attributes'   => [
                'uid'                  => [
                  'asc'  => 't.uid ASC',
                  'desc' => 't.uid DESC',
                ],
                'role'                 => [
                  'asc'  => 't.role ASC',
                  'desc' => 't.role DESC',
                ],
                'fullname'             => [
                  'asc'  => 't.fullname ASC',
                  'desc' => 't.fullname DESC',
                ],
                'lands'                => [
                  'asc'  => "(select ll.land_group from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created limit 1) asc, 
(select substring(ll.land_number,'(\d+)')::integer from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created limit 1) asc,
(select ll.land_number from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created limit 1) asc",
                  'desc' => "(select ll.land_group from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created limit 1) desc, 
(select substring(ll.land_number,'(\d+)')::integer from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created limit 1) desc,
(select ll.land_number from obj_users_lands ul
join obj_lands ll on ll.lands_id = ul.lands_id
where ul.uid = t.uid and ul.deleted is null
order by ul.created limit 1) desc",
                ],
                'email'                => [
                  'asc'  => 't.email ASC',
                  'desc' => 't.email DESC',
                ],
                'debtor_status'        => [
                  'asc'  => 't.debtor_status ASC',
                  'desc' => 't.debtor_status DESC',
                ],
                'default_manager_name' => [
                  'asc'  => 't.default_manager_name ASC',
                  'desc' => 't.default_manager_name DESC',
                ],
                'status'               => [
                  'asc'  => 't.status ASC',
                  'desc' => 't.status DESC',
                ],
                'checked'              => [
                  'asc'  => 't.checked ASC',
                  'desc' => 't.checked DESC',
                ],
                'created'              => [
                  'asc'  => 't.created ASC',
                  'desc' => 't.created DESC',
                ],
                'userBalance'          => [
                  'asc'  => '"userBalance" ASC',
                  'desc' => '"userBalance" DESC',
                ],
              ],
              'defaultOrder' => [
                'fullname' => CSort::SORT_ASC,
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
        return 'users';
    }

    public function update($attributes = null)
    {
        if ($this->new_email && ($this->email != $this->new_email)) {
            $this->email = $this->new_email;
            $attributes[] = 'email';
        }
        if ($this->new_password) {
            $this->password = md5($this->new_password);
            $attributes[] = 'password';
        }
        $newPhone = preg_replace('/[^\d]+/isu', '', $this->phone);
        if ($newPhone !== $this->phone) {
            $this->phone = $newPhone;
            $attributes[] = 'phone';
        }
        $res = parent::update($attributes);
        if ($res && isset($this->lands) && is_array($this->lands)) {
            $res = $this->setRelatable('lands', $this->lands);
        }
        return $res;
    }

    public static function afterAuthenticate($user, $authenticated)
    {

    }

    public static function financesDataProvider($uid, $pageSize = 100)
    {
        $sql = "
SELECT fin.type,
fin.summ,
(SELECT round(sum(\"sum\"),2) AS \"sum\"  FROM (SELECT coalesce(\"sum\", 0) AS \"sum\", payments.date
            FROM payments
           WHERE uid = :uid AND 
					 status IN (1,2,5,6,7,8)
          UNION ALL
       SELECT 0-coalesce(summ, 0) AS \"sum\", op.date
            FROM bills_payments op
           WHERE op.bid IN (SELECT oo.id
                              FROM bills_for_statuses_view oo
                             WHERE oo.uid = :uid AND 
                                   oo.uid = op.uid AND -- может быть не нужно
				 oo.status NOT IN ('EXPIRED','CANCELED_BY_SERVICE'))
                                   ) uu2 WHERE \"date\"<=fin.date) AS total,
fin.date, uu.fullname, mm.fullname as manager_name,
trim(concat(fin.status,' ',fin.comment)) AS comment,
fin.uid, fin.manager_id, fin.oid
FROM
(
SELECT '+' AS type, pp.oid AS oid, round(\"sum\",2) AS summ,
CASE WHEN pp.status=1 THEN 'Зачисление или возврат средств'
      WHEN pp.status=2 THEN 'Снятие средств'
      WHEN pp.status=3 THEN 'Ожидание зачисления средств'
      WHEN pp.status=4 THEN 'Отмена ожидания зачисления средств'
      WHEN pp.status=5 THEN 'Отправка внутреннего перевода средств'
      WHEN pp.status=6 THEN 'Получение внутреннего перевода средств'
      WHEN pp.status=7 THEN 'Зачисление бонуса или прибыли'
      WHEN pp.status=8 THEN 'Вывод средств из системы'
      ELSE '' END AS status,
pp.date, uid, manager_id,
trim(coalesce(pp.description,'')||' '||coalesce(comment,'')) AS comment
FROM payments pp
WHERE pp.uid = :uid AND 
pp.status IN (1,2,5,6,7,8)
 UNION ALL
SELECT '-' AS type, bid as oid,round(0-summ,2) AS summ, '' AS status,op.date,uid, uid as manager_id,descr AS comment FROM 
bills_payments op
WHERE op.bid IN (SELECT oo.id
                              FROM bills_for_statuses_view oo
                             WHERE oo.uid = :uid AND 
            					 oo.uid = op.uid and -- может быть не нужно
								 oo.status NOT IN ('EXPIRED','CANCELED_BY_SERVICE'))
UNION ALL
 SELECT '+' AS type,  bid as oid,round(0-sum(summ),2) AS summ, '' AS status,
(SELECT el.date FROM events_log el WHERE el.subject_id = op.bid AND el.event_name = 'Order.beforeUpdate.status'
ORDER BY el.date DESC LIMIT 1) AS \"date\", min(uid) as uid, min(uid) as manager_id,
concat('Отмена счёта №',op.bid) AS comment FROM bills_payments op
WHERE op.bid IN (SELECT oo.id
                              FROM bills_for_statuses_view oo
                             WHERE oo.uid = :uid AND 
									oo.uid = op.uid and -- может быть не нужно
									oo.status IN ('EXPIRED','CANCELED_BY_SERVICE'))
 GROUP BY op.bid 
) fin 
left join users uu on fin.uid = uu.uid
left join users mm on fin.manager_id = mm.uid
ORDER BY fin.date DESC
        ";
        $rows = Yii::app()->db->createCommand($sql)->queryAll(true, [':uid' => $uid]);
        if ($rows) {
            foreach ($rows as $i => $row) {
                $rows[$i]['id'] = $i + 1;
                $formula = '';
                if (isset($rows[$i + 1])) {
                    $oldTotal = $rows[$i + 1]['total'];
                    $summ = $rows[$i]['summ'];
                    $newTotal = $rows[$i]['total'];
                    $formula = $oldTotal . ($summ >= 0 ? ' + ' . $summ : ' - ' . abs($summ)) . ' = ' . $newTotal;
                }
                $rows[$i]['formula'] = $formula;
            }
        }

        $menuDataProvider = new CArrayDataProvider(
          $rows, [
            'id'         => 'finances_dataProvider',
            'keyField'   => 'id',
//            'totalItemCount' => $menuCount,
            'pagination' => [
              'pageSize' => $pageSize,
            ],
          ]
        );
        return $menuDataProvider;
    }

    public static function getAllowedManagersForUser($id, $uid, $manager)
    {
        $alowedManagers = Yii::app()->db->cache(YII_DEBUG ? 0 : 3600)->createCommand(
          "SELECT uu.uid, uu.fullname, uu.email,
                            (SELECT count(0) FROM users uu2 WHERE uu2.default_manager = uu.uid ) AS \"managedUsersCount\"
                             FROM users uu
                            WHERE uu.status=1 AND uu.role IN (
                                    SELECT DISTINCT role FROM access_rights WHERE
                                    role IN ('billManager', 'topManager', 'superAdmin') OR
                                    allow ~* '.*(order|top)manager|superadmin.*'
                            )
                            ORDER BY \"managedUsersCount\" DESC"
        )->queryAll();
        $result = [];
        if ($alowedManagers) {
            foreach ($alowedManagers as $alowedManager) {
                $result[$alowedManager['uid']] =
                  $alowedManager['fullname'] . ' (' . $alowedManager['managedUsersCount'] . ')';
            }
        }
        return $result;
    }

    public static function getBalance($uid, $forceNoUnpayedOrders = true)
    {
        $_uid = $uid;
        $res = Yii::app()->db->createCommand(
          self::getBalanceSql($forceNoUnpayedOrders)
        )->queryScalar(
          [
            ':uid' => $_uid,
          ]
        );
        if ($res) {
            $result = Formulas::cRound($res, false, 2);
        } else {
            $result = 0;
        }
        return $result;
    }

    public static function getBalanceSql($forceNoUnpayedOrders = true)
    {
        if (!$forceNoUnpayedOrders && (DSConfig::getVal('checkout_negative_balance') == 1)) {
            $sql = "SELECT coalesce(sum(\"sum\"),0) AS \"sum\"  FROM (SELECT sum(coalesce(\"sum\", 0)) AS \"sum\"
            FROM payments -- use index (idx_uid_status)
           WHERE     uid = :uid
                 AND status IN (1,2,5,6,7,8)
          UNION ALL
       SELECT sum(0-coalesce(summ, 0)) AS \"sum\"
            FROM orders_payments op
           WHERE op.oid IN (SELECT oo.id
                              FROM orders oo
                             WHERE     oo.uid = :uid
                                   AND oo.status NOT IN ('CANCELED_BY_CUSTOMER','CANCELED_BY_SERVICE'))
          
          UNION ALL                         
SELECT sum(0-round((coalesce(oo.manual_delivery,oo.delivery)+coalesce(oo.manual_sum,oo.sum)),2)) AS \"sum\"
FROM orders oo
  WHERE oo.uid = :uid
 AND oo.status NOT IN ('EXPIRED','CANCELED_BY_SERVICE')
AND NOT exists(SELECT 'x' FROM orders_payments op WHERE op.oid = oo.id)
                                   ) uu";
        } else {
            $sql = "SELECT coalesce(sum(\"sum\"),0) AS \"sum\"  FROM (SELECT sum(coalesce(\"sum\", 0)) AS \"sum\"
            FROM payments -- use index (idx_uid_status)
           WHERE     uid = :uid
                 AND status IN (1,2,5,6,7,8)
          UNION ALL
       SELECT sum(0-coalesce(summ, 0)) AS \"sum\"
            FROM orders_payments op
           WHERE op.oid IN (SELECT oo.id
                              FROM orders oo
                             WHERE     oo.uid = :uid
                                   AND oo.status NOT IN ('EXPIRED','CANCELED_BY_SERVICE'))
                                   ) uu";
        }
        return $sql;
    }

    public static function getFirstSuperAdminId()
    {
        $user = self::model()->findBySql("SELECT * FROM users WHERE status=1 AND role='superAdmin'");
        if ($user) {
            return $user['uid'];
        } else {
            return Yii::app()->user->id;
        }
    }

    public static function getList($id = null, $getParents = false)
    {
        if (is_null($id)) {
            $sql = "select ll.uid, ll.fullname,
(select count(0) from obj_users_lands ul where ul.uid = ll.uid and ul.deleted is null) as lands
from users ll
order by ll.fullname";
            $res = Yii::app()->db->createCommand($sql)->queryAll();
        } else {
            if (!$getParents) {
                $sql = "select ul.uid
from obj_users_lands ul where ul.deleted is null and ul.uid = :id 
group by ul.uid";
                $res = Yii::app()->db->createCommand($sql)->queryColumn(
                  [
                    ':id' => $id,
                  ]
                );
            } else {
                /*
                $sql = "select ul.lands_id
from obj_lands_devices ul where ul.deleted is null and ul.devices_id = :id";
                $res = Yii::app()->db->createCommand($sql)->queryColumn(
                  array(
                    ':id' => $id,
                  )
                );
                */
                $res = [];
            }
        }
        if (!is_array($res)) {
            $res = [];
        }
        foreach ($res as $i => $resRecord) {
            if (isset($resRecord['fullname'])) {
                $res[$i]['fullname'] = Utils::fullNameWithInitials($resRecord['fullname']);
            }
        }
        return $res;
    }

    public static function getListData()
    {
        $res = self::model()->findAllBySql(
          "select ll.uid, ll.fullname
from users ll where ll.role in ('landlord','associate')
order by ll.fullname ",
          []
        );
        $resArr = [];
        if (($res != false) && (!is_null($res))) {
            foreach ($res as $r) {
                $resArr[$r['uid']] = $r['fullname'];
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
        $user = self::model()->findByPk($id);
        $res = '';
        $fields = [
          'uid',
          'fullname',
          'email',
          'phone',
          'role',
        ];
        if ($user) {
            foreach ($fields as $field) {
                if (strlen($user->{$field}) > 0) {
                    $res = $res . '<small>' . $user->getAttributeLabel($field) . ':</small> ' . markup(
                        $user->{$field},
                        $query
                      ) . '&nbsp;';
                }
            }
        }
        return $res;
    }

    public static function getPromoByUid($uid)
    {
        $_uid = $uid;
        if (isset(Yii::app()->memCache)) {
            $res = @Yii::app()->memCache->get('getPromoByUid-' . $_uid);
        }
        if (!isset($res) || !$res) {
            $res = 'FIXITLTR'/* Yii::app()->db->createCommand(
              "SELECT concat(CONV(round(12*created/(uid+1)), 10, 35),CONV(uid, 10, 27)) AS
              res FROM users WHERE uid=:uid"
            )->queryScalar(
              array(
                ':uid' => $_uid,
              )
            )*/
            ;
            if (isset(Yii::app()->memCache)) {
                @Yii::app()->memCache->set('getPromoByUid-' . $_uid, $res, 3600 * 24 * 7);
            }
        }
        return $res;
    }

    public static function getUidByPromo($promo)
    {
        /* $res = self::model()
          ->find('concat(CONV(round(12*created/(uid+1)), 10, 35),CONV(uid, 10, 27))=:promo', array(':promo' => $promo));
        */
        $res = 'FIXITLTR';
        if ($res === false || $res === null) {
            return DSConfig::getValDef('checkout_default_manager_id', 0);
        } elseif ($res === 'FIXITLTR') {
            return DSConfig::getValDef('checkout_default_manager_id', 0);
        } elseif (isset($res->uid)) {
            return $res->uid;
        } else {
            return DSConfig::getValDef('checkout_default_manager_id', 0);
        }
    }

    public static function getUpdateLink($id, $external = false, $user = null, $value = null)
    {
        if (!strlen($id)) {
            return '<a href="#">&dash;</a>';
        }
        if (is_null($user)) {
            $user = self::model()->findByPk($id);
        }
        if ($user) {
            if (is_null($value)) {
                $value = $user->fullname;
            }
            $tabName = Utils::fullNameWithInitials($user->fullname);
            if ($external) {
                return ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']) ? 'https://' : 'http://') . DSConfig::getVal(
                    'site_domain'
                  ) . '/admin/main/open?url=admin/users/view/id/' . $id . '&tabName=' . addslashes(
                    $tabName
                  );
            } else {
                $url = Yii::app()->createUrl('/' . Yii::app()->controller->module->id . '/users/view', ['id' => $id]);
                return '<a href="' . $url . '" title="' . Yii::t(
                    'admin',
                    'Просмотр профиля пользователя'
                  ) . '" onclick="getContent(this,\'' . addslashes(
                    $tabName
                  ) . '\',false);return false;"><i class="fa fa-user"></i>&nbsp;' . $value . '</a>';
            }
        } else {
            return '<a href="#">' . Yii::t('admin', 'Ошибка') . '</a>';
        }
    }

    public static function getUserAsManager($uid)
    {
        $user = self::model()->findByPkEx($uid);
        /*
        if ($user) {
            $user->users = new Users('search');
            $user->users->unsetAttributes(); // clear any default values
            $user->users->default_manager = $uid;
//---------------------------------
            $sqlForCount = "SELECT count(0)
    FROM events_log ee
WHERE (ee.event_name LIKE 'Order.%' OR ee.event_name LIKE 'OrdersItems.%')
AND ee.subject_id IN (SELECT oo.id FROM orders oo WHERE oo.manager=:manager)";

            $sql = "SELECT ee.*, (SELECT uu.email FROM users uu WHERE uu.uid=ee.uid LIMIT 1) AS fromName,
    (SELECT el.event_descr FROM events el WHERE el.event_name= ee.event_name LIMIT 1) AS eventName
    FROM events_log ee
WHERE (ee.event_name LIKE 'Order.%' OR ee.event_name LIKE 'OrdersItems.%')
AND ee.subject_id IN (SELECT oo.id FROM orders oo WHERE oo.manager=:manager)";

            $count = Yii::app()->db->createCommand($sqlForCount)
              ->queryScalar(
                array(
                  ':manager' => $uid,
                )
              );
            $user->usersOrdersEvents = new CSqlDataProvider(
              $sql, array(
                'params'         => array(':manager' => $uid),
                'id'             => 'order_events_manager_related',
                'keyField'       => 'id',
                'sort'           => array(
                  'defaultOrder' => 'ee.date DESC',
                ),
                'totalItemCount' => $count,
                'pagination'     => array(
                  'pageSize' => 20,
                )
              )
            );
*/
//---------------------------------
        /*            $sqlForCount = "SELECT count(0) FROM (
        SELECT 1 -- oc.id
        FROM orders_comments oc
        WHERE oc.oid IN (SELECT oo.id FROM orders oo WHERE oo.manager=:manager)
        UNION ALL
        SELECT ic.id
        FROM orders_items_comments ic
        JOIN orders_items oi ON oi.id=ic.item_id
        WHERE oi.oid IN (SELECT oo.id FROM orders oo WHERE oo.manager=:manager)
        ) rr";

                    $sql = "SELECT row_number() OVER () AS rownum, rr.*, (SELECT uu.email FROM users uu WHERE uu.uid=rr.uid LIMIT 1) AS fromName FROM (
        SELECT oc.id, 'ORDER' AS obj_type, oc.oid AS obj_id, oc.uid, oc.date, oc.message, oc.internal
        FROM orders_comments oc
        WHERE oc.oid IN (SELECT oo.id FROM orders oo WHERE oo.manager=:manager)
        UNION ALL
        SELECT ic.id, 'ITEM' AS obj_type, oi.oid AS obj_id, ic.uid, ic.\"date\", ic.message, ic.internal
        FROM orders_items_comments ic
        JOIN orders_items oi ON oi.id=ic.item_id
        WHERE oi.oid IN (SELECT oo.id FROM orders oo WHERE oo.manager=:manager)
        ORDER BY \"date\" DESC
        ) rr";

                    $count = Yii::app()->db->createCommand($sqlForCount)
                      ->queryScalar(
                        array(
                          ':manager' => $uid,
                        )
                      );
                    $user->usersOrdersMessages = new CSqlDataProvider(
                      $sql, array(
                        'params'         => array(':manager' => $uid),
                        'id'             => 'order_comments_manager_related',
                        'keyField'       => 'rownum',
                        'sort'           => array(
                          'defaultOrder' => 'rr.date DESC',
                        ),
                        'totalItemCount' => $count,
                        'pagination'     => array(
                          'pageSize' => 10,
                        )
                      )
                    );
        //-----------------------------------
                }
                */
        return $user;
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Users|DSRelatableActiveRecord|CActiveRecord the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model(preg_replace('/^custom/', '', $className));
    }

    public static function newUser($userForm, $redirect = true)
    {
        $loginByPhone = (boolean) DSConfig::getVal('login_use_phone_as_login');
        if (!$loginByPhone && isset($userForm->email) && $userForm->email) {
            $login = $userForm->email;
        } elseif ($loginByPhone && isset($userForm->phone) && $userForm->phone) {
            $login = $userForm->phone;
        } else {
            $login = null;
        }
        $exists = UserIdentity::isUserExistsByName($login);
        if ($exists === null) {
            $user = new Users();
            if (isset($userForm->attributes)) {
                $user->attributes = $userForm->attributes;
                $user->default_manager = Users::getUidByPromo($userForm->default_manager);
            }
            $user->email = trim(strtolower($userForm->email));
            $user->password = md5($userForm->password);
            if (isset($userForm->fullname) && $userForm->fullname) {
                $user->fullname = $userForm->fullname;
            }
            if (isset($userForm->phone) && $userForm->phone) {
                $user->phone = $userForm->phone;
            }
            if (!$user->default_manager) {
                $user->default_manager = Users::getFirstSuperAdminId();
            }
            if (DSConfig::getVal('user_registration_confirmation_needed') == 0) {
                $user->status = 1;
            } else {
                $user->status = 0;
            }

            $user->created = date('Y-m-d H:i:s', time());
            //TODO: вот тут спорно присвоение роли
            $user->role = 'user';
            if ($user->save()) {
                if (DSConfig::getVal('user_registration_confirmation_needed') == 1) {
                    Users::sendRegMail($user);
                    if (isset($user->email) && $user->email) {
                        Yii::app()->user->setFlash(
                          'successEmail',
                          Yii::t(
                            'main',
                            cms::customContent(
                              'flashMessage:successEmailRegister',
                              false,
                              false,
                              false,
                              false,
                              'Вы успешно зарегистрированы!'
                            )
                          ) . '<br>' .
                          Yii::t('main', 'На почтовый ящик') . ' ' . $user->email . ' ' . Yii::t(
                            'main',
                            'отправлено сообщение для подтверждения аккаунта'
                          ) . '.<br>' .
                          Yii::t('main', 'Если письмо не приходит, попробуйте проверить папку "Спам"')
                        );
                    } elseif (isset($user->phone) && $user->phone) {
                        Yii::app()->user->setFlash(
                          'successEmail',
                          Yii::t(
                            'main',
                            cms::customContent(
                              'flashMessage:successEmailRegister',
                              false,
                              false,
                              false,
                              false,
                              'Вы успешно зарегистрированы!'
                            )
                          ) . '<br>' .
                          Yii::t('main', 'На номер телефона') . ' ' . $user->phone . ' ' . Yii::t(
                            'main',
                            'отправлено сообщение для подтверждения аккаунта'
                          )
                        );
                    }
                } else {
                    Yii::app()->user->setFlash(
                      'successEmail',
                      Yii::t(
                        'main',
                        cms::customContent(
                          'flashMessage:successEmailRegister',
                          false,
                          false,
                          false,
                          false,
                          'Вы успешно зарегистрированы!'
                        )
                      )
                    );
                }
                $result = Users::model()->login($login, $userForm->password, false, $redirect);
                return $result;
            } else {
                Yii::app()->user->setFlash(
                  'errorRegister',
                  Yii::t('main', 'Произошла ошибка! Попробуйте еще раз (Код 3)')
                );
                return false;
            }
        } else {
            if (!$redirect) {
                $result = Users::model()->login($login, $userForm->password, false, $redirect);
                if ($result) {
                    return true;
                }
            }
            Yii::app()->user->setFlash(
              'emailFinded',
              Yii::t('main', 'Данный Email или номер телефона уже зарегистрирован в базе')
            );
        }
        return false;
    }

    public static function sendPassMail($user)
    {
        $hash = Yii::app()->getSecurityManager();
        $key = $hash->hashData($user->email);
        $user->confirmationLink = Yii::app()->createAbsoluteUrl(
          '/user/password_reset',
          [
            'email' => $user->email,
            'key'   => $key,
          ]
        );
        return CmsEmailEvents::emailProcessEvents($user, 'sendPassMail');
    }

    // public static generatePasswordHash(password)

    public static function sendRegMail($user)
    {
        $hash = Yii::app()->getSecurityManager();
        $key = $hash->hashData(strtotime($user->created));
        $user->confirmationLink = Yii::app()->createAbsoluteUrl(
          '/user/check',
          ['email' => $user->email, 'key' => $key]
        );
        return CmsEmailEvents::emailProcessEvents($user, 'sendRegMail');
    }

}