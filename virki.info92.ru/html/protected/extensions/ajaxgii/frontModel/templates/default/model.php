<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo '<?' ?>
/*******************************************************************************************************************
* This file is the part of VPlatform project https://info92.ru
* Copyright (C) 2013-2020, info92 team
* All rights reserved and protected by law.
* You can't use this file without of the author's permission.
* =================================================================================================================
*
<description file="<?= $modelClass ?>.php">
  *
</description>
*******************************************************************************************************************/
<?php echo '?>' ?>

<?php echo "<?php\n"; ?>

/**
* This is the model class for table "<?php echo $tableName; ?>".
*
*/
class <?php echo $modelClass; ?> extends custom<?php echo $modelClass . "\n"; ?>
{
/*=================================================================================================
* Please use OOP (add, hide, override or overload any method or property) to implement
* any of your own functionality needed. This file never will be overwritten or changed
* with updates to protect your custom functionality.
* Warning: don't change anything in "custom" folder - all your changes will be lost after update!
=================================================================================================*/
/*
* Returns the static model of the specified AR class.
* Please note that you should have this exact method in all your CActiveRecord descendants!
* @param string $className active record class name.
* @return CmsCustomContent the static model class
*/
public static function model($className = __CLASS__)
{
return parent::model($className);
}
}
