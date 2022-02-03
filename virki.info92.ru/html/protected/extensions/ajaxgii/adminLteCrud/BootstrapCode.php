<?php

Yii::import('gii.generators.crud.CrudCode');

class BootstrapCode extends CrudCode
{
    public function generateActiveRow($modelClass, $column, $idSuffix = '')
    {
        if ($idSuffix) {
            $idPart = ", array('id'=>'{$this->class2id($this->modelClass)}_{$column->name}_{$idSuffix}')";
        } else {
            $idPart = '';
        }
        if ($column->type === 'boolean') {
            return "\$form->checkBoxRow(\$model,'{$column->name}'{$idPart})";
        } else {
            if (stripos($column->dbType, 'text') !== false) {
                return "\$form->textAreaRow(\$model,'{$column->name}'{$idPart})";
            } else {
                if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                    $inputField = 'passwordFieldRow';
                } else {
                    $inputField = 'textFieldRow';
                }

                if ($column->type !== 'string' || $column->size === null) {
                    return "\$form->{$inputField}(\$model,'{$column->name}'{$idPart})";
                } else {
                    return "\$form->{$inputField}(\$model,'{$column->name}'{$idPart})";
                }
            }
        }
    }

    public function init()
    {
        parent::init();
//        $this->baseControllerClass='CustomAdminController';
    }

    /*
    $this->baseControllerClass='CustomAdminController';
     */

    public function prepare()
    {
        parent::prepare();
    }
}
