<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="DSEventableActiveRecord.php">
 * </description>
 **********************************************************************************************************************/ ?>
<?php

abstract class DSRelatableActiveRecord extends DSEventableActiveRecord
{
    private $_relatable = null;                    // attribute name => related objects

    /**
     * PHP getter magic method.
     * This method is overridden so that AR attributes can be accessed like properties.
     * @param string $name property name
     * @return mixed property value
     * @see getAttribute
     */

    public function __get($name)
    {
        if (isset($this->_relatable[$name])) {
            return $this->_relatable[$name];
        } elseif (isset($this->getMetaData()->relatable[$name])) {
            return $this->getRelatable($name);
        } else {
            return parent::__get($name);
        }
    }

    /**
     * PHP setter magic method.
     * This method is overridden so that AR attributes can be accessed like properties.
     * @param string $name  property name
     * @param mixed  $value property value
     * @throws CException
     */
    public function __set($name, $value)
    {
        /*
        if ($this->setAttribute($name, $value) === false) {
            if (isset($this->relatable[$name])) {
                $this->_relatable[$name] = $value;
            }
        } else {
        */
        parent::__set($name, $value);
        /* } */
    }

    /**
     * Checks if a property value is null.
     * This method overrides the parent implementation by checking
     * if the named attribute is null or not.
     * @param string $name the property name or the event name
     * @return boolean whether the property value is null
     */
    public function __isset($name)
    {
        if (isset($this->_relatable[$name])) {
            return true;
        } elseif (isset($this->getMetaData()->relatable[$name])) {
            return $this->getRelatable($name) !== null;
        } else {
            return parent::__isset($name);
        }
    }

    /**
     * Returns the relatable record(s).
     * This method will return the relatable record(s) of the current record.
     * If the relation is HAS_ONE or BELONGS_TO, it will return a single object
     * or null if the object does not exist.
     * If the relation is HAS_MANY or MANY_MANY, it will return an array of objects
     * or an empty array.
     * @param string $name   the relation name (see {@link relatable})
     * @param mixed  $params array or CDbCriteria object with additional parameters that customize the query conditions
     *                       as specified in the relation declaration. If this is supplied the related record(s) will
     *                       be retrieved from the database regardless of the value. The related record(s) retrieved
     *                       when this is supplied will only be returned by this method and will not be loaded into the
     *                       current record's relation. The value of the relation prior to running this method will
     *                       still be available for the current record if this is supplied.
     * @return mixed the related object(s).
     * @throws CDbException if the relation is not specified in {@link relatable}.
     */
    public function getRelatable($name, $params = '')
    {
        if (!isset($this->_relatable)) {
            $this->_relatable = $this->relatable();
        }
        $relatable = null;
        $result = [];
        if (isset($this->_relatable[$name]) || array_key_exists($name, $this->_relatable)) {
            $relatable = $this->_relatable[$name];
        }

        if (!isset($relatable)) {
            throw new CDbException(
              Yii::t(
                'yii',
                '{class} does not have relatable "{name}".',
                ['{class}' => get_class($this), '{name}' => $name]
              )
            );
        }

        if ($this->getIsNewRecord()) {
            return [];
        }

        /*
          'lands' => array(
            'detailTable'             => 'obj_lands',
            'detailTablePK'           => 'lands_id',
            'relatableTable'       => 'obj_users_lands',
            'relatableTablePK'     => 'users_lands_id',
            'relatableTableMasterId' => 'uid',
            'relatableTableDetailId'  => 'lands_id'
          ),
select tt.users_lands_id, tt.uid, rr.*
                from obj_users_lands tt
								left join obj_lands rr on tt.lands_id = rr.lands_id
                where tt.uid=3
                and tt.deleted is not null
                order by tt.created
         */
        if ($params) {
            $where = 'and ' . $params;
        } else {
            $where = '';
        }
        /** @noinspection SqlResolve */
        $sql = "select tt.{$relatable['relatableTablePK']},
                tt.{$relatable['relatableTableMasterId']},
                rr.*
                from {$relatable['relatableTable']} tt
                left join {$relatable['detailTable']} rr on tt.{$relatable['relatableTableDetailId']} = rr.{$relatable['detailTablePK']}
                where tt.{$relatable['relatableTableMasterId']}={$this->primaryKey}
                  {$where}
                and tt.deleted is null
                order by tt.created";
        $result = Yii::app()->db->createCommand($sql)->queryAll();
        return $result;
    }

    public function setRelatable($name, $values = [])
    {
        if (!isset($this->_relatable)) {
            $this->_relatable = $this->relatable();
        }
        $relatable = null;
        $result = false;
        if (isset($this->_relatable[$name]) || array_key_exists($name, $this->_relatable)) {
            $relatable = $this->_relatable[$name];
        }

        if (!isset($relatable)) {
            throw new CDbException(
              Yii::t(
                'yii',
                '{class} does not have relatable "{name}".',
                ['{class}' => get_class($this), '{name}' => $name]
              )
            );
        }

        /*
          'parent_lands' => array(
            'detailTable'            => 'obj_devices_manual',
            'detailTablePK'          => 'id',
            'relatableTable'         => 'obj_lands_devices',
            'relatableTablePK'       => 'lands_devices_id',
            'relatableTableMasterId' => 'lands_id',
            'relatableTableDetailId' => 'devices_id'
          ),
*/
        /*        Выбрать имеющиеся, пометить deleted для отсутствующих, добавить новые. */
        if (preg_match('/^parent_/i', $name)) {
            /** @noinspection SqlResolve */
            $sqlExists = "select dd.{$relatable['relatableTableMasterId']}
                from {$relatable['detailTable']} tt
                  join {$relatable['relatableTable']} dd 
                      on tt.{$relatable['detailTablePK']} = dd.{$relatable['relatableTableDetailId']} 
                where tt.{$relatable['detailTablePK']}= :detailTablePK
                 and dd.deleted is null";
            $exists = Yii::app()->db->createCommand($sqlExists)->queryColumn(
              [
                ':detailTablePK' => $this->primaryKey,
              ]
            );
            $valuesToDelete = array_diff($exists, $values);
            $valuesToInsert = array_diff($values, $exists);
            foreach ($valuesToDelete as $valueToDelete) {
                /** @noinspection SqlResolve */
                $sqlToDelete = "update {$relatable['relatableTable']}
            set deleted = Now()
            where 
            {$relatable['relatableTableMasterId']}= :relatableTableMasterId
            and {$relatable['relatableTableDetailId']}= :relatableTableDetailId";
                Yii::app()->db->createCommand($sqlToDelete)->execute(
                  [
                    ':relatableTableMasterId' => $valueToDelete,
                    ':relatableTableDetailId' => $this->primaryKey,
                  ]
                );
            }
            foreach ($valuesToInsert as $valueToInsert) {
                /** @noinspection SqlResolve */
                $sqlToInsert = "insert into {$relatable['relatableTable']} 
                             ({$relatable['relatableTableMasterId']},{$relatable['relatableTableDetailId']}, created)
                             values(:relatableTableMasterId,:relatableTableDetailId,Now())";
                Yii::app()->db->createCommand($sqlToInsert)->execute(
                  [
                    ':relatableTableMasterId' => $valueToInsert,
                    ':relatableTableDetailId' => $this->primaryKey,
                  ]
                );
            }
        } else {
            /** @noinspection SqlResolve */
            $sqlExists = "select dd.{$relatable['detailTablePK']}
                from {$relatable['relatableTable']} tt
                  join {$relatable['detailTable']} dd 
                      on dd.{$relatable['detailTablePK']} = tt.{$relatable['relatableTableDetailId']} 
                where tt.{$relatable['relatableTableMasterId']}= :relatableTableMasterId
                 and tt.deleted is null";
            $exists = Yii::app()->db->createCommand($sqlExists)->queryColumn(
              [
                ':relatableTableMasterId' => $this->primaryKey,
              ]
            );
            $valuesToDelete = array_diff($exists, $values);
            $valuesToInsert = array_diff($values, $exists);
            foreach ($valuesToDelete as $valueToDelete) {
                /** @noinspection SqlResolve */
                $sqlToDelete = "update {$relatable['relatableTable']}
            set deleted = Now()
            where 
            {$relatable['relatableTableMasterId']}= :relatableTableMasterId
            and {$relatable['relatableTableDetailId']}= :relatableTableDetailId";
                Yii::app()->db->createCommand($sqlToDelete)->execute(
                  [
                    ':relatableTableMasterId' => $this->primaryKey,
                    ':relatableTableDetailId' => $valueToDelete,
                  ]
                );
            }
            foreach ($valuesToInsert as $valueToInsert) {
                /** @noinspection SqlResolve */
                $sqlToInsert = "insert into {$relatable['relatableTable']} 
                             ({$relatable['relatableTableMasterId']},{$relatable['relatableTableDetailId']}, created)
                             values(:relatableTableMasterId,:relatableTableDetailId,Now())";
                Yii::app()->db->createCommand($sqlToInsert)->execute(
                  [
                    ':relatableTableMasterId' => $this->primaryKey,
                    ':relatableTableDetailId' => $valueToInsert,
                  ]
                );
            }
        }
        return true;
    }

    /**
     * @return array relatable rules.
     */
    public function relatable()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [];
    }

}