<?php

/**
 * This is the model class for table "formulas".
 * The followings are the available columns in table 'formulas':
 * @property integer $id
 * @property string  $formula_id
 * @property string  $formula
 * @property string  $description
 */
class customFormulasVar
{
    function __construct($value, $vars = [], $description = '')
    {
        $this->val = $value;
        $this->description = $description;
        $this->params = $vars;
    }

    public $description = '';
    public $params = [];
    public $val = 0;
    public $vars = [];

    public function __get($property)
    {
        switch ($property) {
            case 'cval':
                if ($this->val == null) {
                    return null;
                } else {
                    return sprintf('%01.2f', $this->val);
                }
            default:
                if (isset($this->$property)) {
                    return $this->$property;
                } else {
                    throw new CException('FormulasVar prop ' . $property . ' not fount!');
                }
        }
    }

    /*  public function __set($property, $value)
      {
        switch ($property)
        {
          case 'val':
            $this->val = $value;
            break;
        }
      }
    */
    public function report()
    {
        $res = '';
        if (isset($this->params) && is_array($this->params)) {
            foreach ($this->params as $name => $param) {
                if (isset($param->val) && ($param->description)) {
                    $res = $res . "<br/>$" . $name . '=<b>' . $param->val . '</b> <i>' . $param->description . '</i>';
                }
            }
        }
        return $res;
    }
}
