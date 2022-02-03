<?php
/**
 *## EditableSaver class file.
 * @author    Vitaliy Potapov <noginsk@rambler.ru>
 * @link      https://github.com/vitalets/x-editable-yii
 * @copyright Copyright &copy; Vitaliy Potapov 2012
 * @version   1.1.0
 */

/**
 * EditableSaver helps to update model by editable widget submit request.
 * @package booster.widgets.supplementary
 */
class TbEditableSaver extends CComponent
{
    /**
     *### ._construct()
     * Constructor
     * @param $modelClass
     * @return \TbEditableSaver
     * @throws CException
     * @internal param mixed $modelName
     */
    public function __construct($modelClass)
    {
        if (empty($modelClass)) {
            throw new CException(
              Yii::t(
                'TbEditableSaver.editable',
                'You should provide modelClass in constructor of EditableSaver.'
              )
            );
        }

        $this->modelClass = $modelClass;

        //for non-namespaced models do ucfirst (for backwards compability)
        //see https://github.com/vitalets/x-editable-yii/issues/9
        if (strpos($this->modelClass, '\\') === false) {
            $this->modelClass = ucfirst($this->modelClass);
        }
    }

    /**
     * name of changed attributes. Used when saving model
     * @var mixed
     */
    protected $changedAttributes = [];
    /**
     * name of attribute to be updated
     * @var mixed
     */
    public $attribute;
    /**
     * http status code returned in case of error
     */
    public $errorHttpCode = 400;
    /**
     * model instance
     * @var CActiveRecord
     */
    public $model;
    /**
     * name of model
     * @var mixed
     */
    public $modelClass;
    /**
     * primaryKey value
     * @var mixed
     */
    public $primaryKey;
    /**
     * scenarion used in model for update
     * @var mixed
     */
    public $scenario = 'editable';
    /**
     * @var mixed new value of attribute
     */
    public $value;

    /**
     *### .afterUpdate()
     * afterUpdate
     */
    protected function afterUpdate()
    {
        $this->onAfterUpdate(new CModelEvent($this));
    }

    /**
     *### .beforeUpdate()
     * beforeUpdate
     */
    protected function beforeUpdate()
    {
        $this->onBeforeUpdate(new CModelEvent($this));
    }

    /**
     *### .checkErros()
     * errors as CHttpException
     * @throws CHttpException
     * @internal param $msg
     */
    public function checkErrors()
    {
        if ($this->model->hasErrors()) {
            $msg = [];
            foreach ($this->model->getErrors() as $attribute => $errors) {
                // TODO: make use of $attribute elements
                $msg = array_merge($msg, $errors);
            }
            // TODO: show several messages. should be checked in x-editable js
            //$this->error(join("\n", $msg));
            $this->error($msg[0]);
        }
    }

    /**
     *### .error()
     * errors as CHttpException
     * @param $msg
     * @throws CHttpException
     */
    public function error($msg)
    {
        throw new CHttpException($this->errorHttpCode, $msg);
    }

    /**
     *### .onAfterUpdate()
     * This event is raised after the update is performed.
     * @param CModelEvent $event the event parameter
     */
    public function onAfterUpdate($event)
    {
        $this->raiseEvent('onAfterUpdate', $event);
    }

    /**
     *### .onBeforeUpdate()
     * This event is raised before the update is performed.
     * @param CModelEvent $event the event parameter
     */
    public function onBeforeUpdate($event)
    {
        $this->raiseEvent('onBeforeUpdate', $event);
    }

    /**
     *### .setAttribute()
     * setting new value of attribute.
     * Attrubute name also stored in array to save only changed attributes
     * @param mixed $name
     * @param mixed $value
     */
    public function setAttribute($name, $value)
    {
        $this->model->$name = $value;
        if (!in_array($name, $this->changedAttributes)) {
            $this->changedAttributes[] = $name;
        }
    }

    /**
     *### .update()
     * main function called to update column in database
     */
    public function update()
    {
        //get params from request
        $this->primaryKey = yii::app()->request->getParam('pk');
        $this->attribute = yii::app()->request->getParam('name');
        $this->value = yii::app()->request->getParam('value');

        //checking params
        if (empty($this->attribute)) {
            throw new CException(Yii::t('TbEditableSaver.editable', 'Property "attribute" should be defined.'));
        }
        if (empty($this->primaryKey)) {
            throw new CException(Yii::t('TbEditableSaver.editable', 'Property "primaryKey" should be defined.'));
        }

        //loading model
        $this->model = CActiveRecord::model($this->modelClass)->findByPk($this->primaryKey);
        if (!$this->model) {
            throw new CException(
              Yii::t(
                'TbEditableSaver.editable',
                'Model {class} not found by primary key "{pk}"',
                [
                  '{class}' => get_class($this->model),
                  '{pk}'    => is_array($this->primaryKey) ? CJSON::encode($this->primaryKey) : $this->primaryKey,
                ]
              )
            );
        }

        //set scenario
        $this->model->setScenario($this->scenario);

        //commented to be able to work with virtual attributes
        //see https://github.com/vitalets/yii-bootstrap-editable/issues/15
        /*
        //is attribute exists
        if (!$this->model->hasAttribute($this->attribute)) {
            throw new CException(Yii::t('EditableSaver.editable', 'Model {class} does not have attribute "{attr}"', array(
              '{class}'=>get_class($this->model), '{attr}'=>$this->attribute)));
        }
        */

        //is attribute safe
        if (!$this->model->isAttributeSafe($this->attribute)) {
            throw new CException(
              Yii::t(
                'editable',
                'Model {class} rules do not allow to update attribute "{attr}"',
                [
                  '{class}' => get_class($this->model),
                  '{attr}'  => $this->attribute,
                ]
              )
            );
        }

        //setting new value
        $this->setAttribute($this->attribute, $this->value);

        //validate attribute
        $this->model->validate([$this->attribute]);
        $this->checkErrors();

        //trigger beforeUpdate event
        $this->beforeUpdate();
        $this->checkErrors();

        //saving (no validation, only changed attributes)
        if ($this->model->save(false, $this->changedAttributes)) {
            //trigger afterUpdate event
            $this->afterUpdate();
        } else {
            $this->error(Yii::t('TbEditableSaver.editable', 'Error while saving record!'));
        }
    }
}
