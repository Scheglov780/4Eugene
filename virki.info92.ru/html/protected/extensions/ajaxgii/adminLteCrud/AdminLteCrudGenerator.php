<?php

Yii::import('gii.generators.crud.CrudGenerator');

class AdminLteCrudGenerator extends CrudGenerator
{
    public $codeModel = 'application.extensions.ajaxgii.adminLteCrud.BootstrapCode';
}
