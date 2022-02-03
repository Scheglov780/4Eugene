<?php

/**
 * This is the model class for table "formulas".
 * The followings are the available columns in table 'formulas':
 * @property integer $id
 * @property string  $formula_id
 * @property string  $formula
 * @property string  $description
 */
class CustomControllerVar
{
    function __construct($value, $description = '')
    {
        $this->val = $value;
        $this->description = $description;
    }

    public $description;
    public $val;
}
