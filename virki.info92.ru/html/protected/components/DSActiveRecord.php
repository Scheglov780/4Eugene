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

abstract class DSActiveRecord extends CActiveRecord
{
    private $previousAttributes = null;

    abstract function search($criteria = null, $pageSize = 100, $cacheDependency = null, $dataProviderId = null);

    /**
     * This method is invoked after saving a record successfully.
     * The default implementation raises the {@link onAfterSave} event.
     * You may override this method to do postprocessing after record saving.
     * Make sure you call the parent implementation so that the event is raised properly.
     */
    protected function afterSave()
    {
        parent::afterSave();
    }

    /**
     * This method is invoked before saving a record (after validation, if any).
     * The default implementation raises the {@link onBeforeSave} event.
     * You may override this method to do any preparation work for record saving.
     * Use {@link isNewRecord} to determine whether the saving is
     * for inserting or updating record.
     * Make sure you call the parent implementation so that the event is raised properly.
     * @return boolean whether the saving should be executed. Defaults to true.
     */
    protected function beforeSave()
    {
        return parent::beforeSave();
    }

    /**
     * Finds a single active record with the specified primary key.
     * See {@link find()} for detailed explanation about $condition and $params.
     * @param mixed $pk        primary key value(s). Use array for multiple primary keys. For composite key, each key
     *                         value must be an array (column name=>column value).
     * @param mixed $condition query condition or criteria.
     * @param array $params    parameters to be bound to an SQL statement.
     * @return static|null the record found. Null if none is found.
     */
    public function findByPkEx($pk, $condition = '', $params = [])
    {
        Yii::trace(get_class($this) . '.findByPk()', 'system.db.ar.CActiveRecord');
        $prefix = $this->getTableAlias(true) . '.';
        $criteria =
          $this->getCommandBuilder()->createPkCriteria($this->getTableSchema(), $pk, $condition, $params, $prefix);
        $dataProvider = $this->search($criteria, 1);
        if (is_array($dataProvider->data) && isset($dataProvider->data[0])) {
            return $dataProvider->data[0];
        } else {
            return null;
        }
    }

    public function getUpdatedAttributesNames($optimize = true)
    {
        if (!$optimize) {
            return null;
        }
        $result = [];
        $attributes = $this->getAttributes();
        $skipped = '';
        $validators = new CList;
        foreach ($this->rules() as $rule) {
            if (isset($rule[0], $rule[1]))  // attributes, validator name
            {
                $validator = CValidator::createValidator($rule[1], $this, $rule[0], array_slice($rule, 2));
                if (is_a($validator, 'CUnsafeValidator')) {
                    $validators->add($validator);
                }
            } else {
                throw new CException(
                  Yii::t(
                    'yii',
                    '{class} has an invalid validation rule. The rule must specify attributes to be validated and the validator name.',
                    ['{class}' => get_class($this)]
                  )
                );
            }
        }
        unset ($validator, $rule);
        $PKs = $this->tableSchema->primaryKey;
        //  $cols = $this->tableSchema->columns;
        if (is_array($attributes)) {
            foreach ($attributes as $name => $value) {
                if (Utils::is_string($value)) {
                    if (isset($this->previousAttributes[$name]) || is_null($this->previousAttributes[$name])) {
                        $skip = false;
                        // if field is PK
                        if (is_array($PKs) && isset($PKs[0])) {
                            if ($PKs[0] == $name) {
                                $skip = true;
                            }
                        } elseif ($PKs) {
                            if ($PKs == $name) {
                                $skip = true;
                            }
                        }
                        // if field is unsafe
                        if (!$skip) {
                            foreach ($validators as $validator) {
                                if (is_a($validator, 'CUnsafeValidator')) {
                                    /** @var CUnsafeValidator $validator */
                                    if (in_array($name, $validator->attributes)) {
                                        $skip = true;
                                        break;
                                    }
                                }
                            }
                        }
                        // if field unchanged
                        if (!$skip && $this->previousAttributes[$name] == $value) {
                            $skip = true;
                        }
                        if (!$skip) {
                            $result[] = $name;
                        } else {
                            $skipped = $skipped . ' ' . $name . '(0)';
                        }
                    } else {
                        $skipped = $skipped . ' ' . $name . '(1)';
                    }
                } else {
                    $skipped = $skipped . ' ' . $name . '(2)';
                }
            }
        }
        unset($skip, $name, $value, $validators, $PKs);
        if (count($result) <= 0) {
            $result = null;
        }
        return $result;
    }

    public function searchRecord($condition = '', $params = [])
    {
        $this->unsetAttributes();
        $criteria = $this->getCommandBuilder()->createCriteria($condition, $params);
        /** @var CActiveDataProvider $dataProvider */
        $dataProvider = $this->search($criteria, 1);
        if (is_array($dataProvider->data) && isset($dataProvider->data[0])) {
            return $dataProvider->data[0];
        } else {
            return null;
        }
    }

    /**
     * Sets the attribute values in a massive way.
     * @param array   $values   attribute values (name=>value) to be set.
     * @param boolean $safeOnly whether the assignments should only be done to the safe attributes.
     *                          A safe attribute is one that is associated with a validation rule in the current
     *                          {@link scenario}.
     * @see getSafeAttributeNames
     * @see attributeNames
     */
    public function setAttributes($values, $safeOnly = true)
    {
        if (is_null($this->previousAttributes)) {
            $this->previousAttributes = $this->attributes;
        }
        parent::setAttributes($values, $safeOnly);
    }

}