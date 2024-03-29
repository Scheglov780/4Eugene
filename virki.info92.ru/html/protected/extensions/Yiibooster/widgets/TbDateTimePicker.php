<?php
/**
 *## TbDateTimePicker widget class
 * @author  : Hrumpa
 * @copyright
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */
Yii::import('booster.widgets.TbBaseInputWidget');

/**
 * Bootstrap DateTimePicker widget
 * @see     http://www.malot.fr/bootstrap-datetimepicker/
 * @package booster.widgets.forms.inputs
 */
class TbDateTimePicker extends TbBaseInputWidget
{

    /**
     * @var string[] the JavaScript event handlers.
     */
    public $events = [];
    /**
     * @var TbActiveForm when created via TbActiveForm.
     * This attribute is set to the form that renders the widget
     * @see TbActionForm->inputRow
     */
    public $form;
    /**
     * @var array the options for the Bootstrap JavaScript plugin.
     */
    public $options = [];

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {

        parent::init();

        $this->htmlOptions['type'] = 'text';
        $this->htmlOptions['autocomplete'] = 'off';

        if (!isset($this->options['language'])) {
            $this->options['language'] = substr(Yii::app()->getLanguage(), 0, 2);
        }

    }

    /**
     *### .registerClientScript()
     * Registers required client script for bootstrap datepicker. It is not used through bootstrap->registerPlugin
     * in order to attach events if any
     */
    public function registerClientScript()
    {

        Booster::getBooster()->registerPackage('datetimepicker');
    }

    public function registerLanguageScript()
    {

        if (isset($this->options['language']) && $this->options['language'] != 'en') {
            $file = 'locales/bootstrap-datetimepicker.' . $this->options['language'] . '.js';
            $booster = Booster::getBooster();
            if (@file_exists(Yii::getPathOfAlias('booster.assets.bootstrap-datetimepicker') . '/js/' . $file)) {
                if ($booster->enableCdn) {
                    // Not in CDN yet
                    $booster->registerAssetJs('../bootstrap-datetimepicker/' . '/js/' . $file);
                } else {
                    $booster->registerAssetJs('../bootstrap-datetimepicker/' . '/js/' . $file);
                }
            }
        }
    }

    /**
     *### .run()
     * Runs the widget.
     */
    public function run()
    {

        [$name, $id] = $this->resolveNameID();

        if ($this->hasModel()) {
            if ($this->form) {
                echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
            } else {
                echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
            }

        } else {
            echo CHtml::textField($name, $this->value, $this->htmlOptions);
        }

        $this->registerClientScript();
        $this->registerLanguageScript();
        $options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

        ob_start();
        echo "jQuery('#{$id}').datetimepicker({$options})";
        foreach ($this->events as $event => $handler) {
            echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
        }

        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');

    }
}
