<?php

/**
 * This is the model class for table "formulas".
 * The followings are the available columns in table 'formulas':
 * @property integer $id
 * @property string  $formula_id
 * @property string  $formula
 * @property string  $description
 */
class customFormulasGetUserPriceResult
{
    public $delivery = 0;
    public $discount = 0;
    public $params = [];
    public $price = 0;
    public $vars = [];

    public function report()
    {
        $res = CVarDumper::dumpAsString($this->params, 6, false) . '</br>' . CVarDumper::dumpAsString(
            $this->vars,
            6,
            false
          );
        return $res;
    }
}
