<?php
/**
 *##  TbSelect2 class file.
 * @author    Antonio Ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

/**
 *## Select2 wrapper widget
 * @see     http://ivaynberg.github.io/select2/
 * @package booster.widgets.forms.inputs
 */
class TbSelect2 extends CInputWidget
{

    /**
     * @var bool whether to display a dropdown select box or use it for tagging
     */
    public $asDropDownList = true;
    /**
     * @var array @param data for generating the list options (value=>display)
     */
    public $data = [];
    /**
     * @var bool
     * @since 2.1.0
     */
    public $disabled = false;
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
     * @var
     */
    public $options;

    /**
     * @var bool
     * @since 2.1.0
     */
    public $readonly = false;
    /**
     * @var string the default value.
     */
    public $val;

    private function addEmptyItemIfPlaceholderDefined()
    {
        if (!empty($this->htmlOptions['placeholder'])) {
            $this->options['placeholder'] = $this->htmlOptions['placeholder'];
        }

        if (!empty($this->options['placeholder']) && empty($this->htmlOptions['multiple'])) {
            $this->prependDataWithEmptyItem();
        }
    }

    private function normalizeData()
    {
        if (!$this->data) {
            $this->data = [];
        }
    }

    private function normalizeOptions()
    {
        if (empty($this->options)) {
            $this->options = [];
        }
    }

    private function prependDataWithEmptyItem()
    {
        $this->data = ['' => ''] + $this->data;
    }

    private function setDefaultWidthIfEmpty()
    {
        if (empty($this->options['width'])) {
            $this->options['width'] = 'resolve';
        }
    }

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {
        $this->normalizeData();

        $this->normalizeOptions();

        $this->addEmptyItemIfPlaceholderDefined();

        $this->setDefaultWidthIfEmpty();

        // disabled & readonly
        if (!empty($this->htmlOptions['readonly'])) {
            $this->readonly = true;
        }
        if (!empty($this->htmlOptions['disabled'])) {
            $this->disabled = true;
        }
    }

    /**
     *### .registerClientScript()
     * Registers required client script for bootstrap select2. It is not used through bootstrap->registerPlugin
     * in order to attach events if any
     */
    public function registerClientScript($id)
    {

        Booster::getBooster()->registerPackage('select2');

        $options = !empty($this->options) ? CJavaScript::encode($this->options) : '';

        if (!empty($this->val)) {
            if (is_array($this->val)) {
                $data = CJSON::encode($this->val);
            } else {
                $data = $this->val;
            }

            $defValue = ".select2('val', $data)";
        } else {
            $defValue = '';
        }

        if ($this->readonly) {
            $defValue .= ".select2('readonly', true)";
        } elseif ($this->disabled) {
            $defValue .= ".select2('enable', false)";
        }

        ob_start();
        echo "jQuery('#{$id}').select2({$options})";
        foreach ($this->events as $event => $handler) {
            echo ".on('{$event}', " . CJavaScript::encode($handler) . ")";
        }
        echo $defValue;

        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $this->getId(), ob_get_clean() . ';');
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
                echo $this->asDropDownList
                  ?
                  $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions)
                  :
                  $this->form->hiddenField($this->model, $this->attribute, $this->htmlOptions);
            } else {
                echo $this->asDropDownList
                  ?
                  CHtml::activeDropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions)
                  :
                  CHtml::activeHiddenField($this->model, $this->attribute, $this->htmlOptions);
            }

        } else {
            echo $this->asDropDownList
              ?
              CHtml::dropDownList($name, $this->value, $this->data, $this->htmlOptions)
              :
              CHtml::hiddenField($name, $this->value, $this->htmlOptions);
        }

        $this->registerClientScript($id);
    }
}
