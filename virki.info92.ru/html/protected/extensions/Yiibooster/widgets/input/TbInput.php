<?php
/**
 *## TbInput class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

/**
 *## Bootstrap input widget.
 * Used for rendering inputs according to Bootstrap standards.
 * @package booster.widgets.forms.inputs
 */
abstract class TbInput extends CInputWidget
{
    // The different input types.
    const TYPE_CAPTCHA = 'captcha';
    const TYPE_CHECKBOX = 'checkbox';
    const TYPE_CHECKBOXGROUPSLIST = 'checkboxgroupslist';
    const TYPE_CHECKBOXLIST = 'checkboxlist';
    const TYPE_CHECKBOXLIST_INLINE = 'checkboxlist_inline';
    const TYPE_CKEDITOR = 'ckeditor';
    const TYPE_COLORPICKER = 'colorpicker';
    const TYPE_CUSTOM = 'custom';
    const TYPE_DATEPICKER = 'datepicker';
    const TYPE_DATERANGEPICKER = 'daterangepicker';
    const TYPE_DATETIMEPICKER = 'datetimepicker';
    const TYPE_DROPDOWN = 'dropdownlist';
    const TYPE_FILE = 'filefield';
    const TYPE_HTML5EDITOR = 'wysihtml5';
    const TYPE_MARKDOWNEDITOR = 'markdowneditor';
    const TYPE_MASKEDTEXT = 'maskedtextfield';
    const TYPE_NUMBER = 'numberfield';
    const TYPE_PASSFIELD = 'passfield';
    const TYPE_PASSWORD = 'password';
    const TYPE_RADIO = 'radiobutton';
    const TYPE_RADIOBUTTONGROUPSLIST = 'radiobuttongroupslist';
    const TYPE_RADIOLIST = 'radiobuttonlist';
    const TYPE_RADIOLIST_INLINE = 'radiobuttonlist_inline';
    const TYPE_REDACTOR = 'redactor';
    const TYPE_SELECT2 = 'select2';
    const TYPE_TEXT = 'text';
    const TYPE_TEXTAREA = 'textarea';
    const TYPE_TIMEPICKER = 'timepicker';
    const TYPE_TOGGLEBUTTON = 'togglebutton';
    const TYPE_TYPEAHEAD = 'typeahead';
    const TYPE_UNEDITABLE = 'uneditable';
    /**
     * @var array append html attributes.
     */
    public $appendOptions = [];
    /**
     * @var string text to append.
     */
    public $appendText;
    /**
     * @var array captcha html attributes.
     */
    public $captchaOptions = [];
    /**
     * @var array the data for list inputs.
     */
    public $data = [];
    /**
     * This property allows you to disable AJAX valiadtion for certain fields within a form.
     * @var boolean the value to be set as fourth parameter to {@link CActiveForm::error}.
     * @see http://www.yiiframework.com/doc/api/1.1/CActiveForm#error-detail
     */
    public $enableAjaxValidation = true;
    /**
     * This property allows you to disable client valiadtion for certain fields within a form.
     * @var boolean the value to be set as fifth parameter to {@link CActiveForm::error}.
     * @see http://www.yiiframework.com/doc/api/1.1/CActiveForm#error-detail
     */
    public $enableClientValidation = true;
    /**
     * @var array error html attributes.
     */
    public $errorOptions = [];
    /**
     * @var TbActiveForm the associated form widget.
     */
    public $form;
    /**
     * @var array hint html attributes.
     */
    public $hintOptions = [];
    /**
     * @var string the hint text.
     */
    public $hintText;
    /**
     * @var string the input label text.
     */
    public $label;
    /**
     * @var array label html attributes.
     */
    public $labelOptions = [];
    /**
     * @var array prepend html attributes.
     */
    public $prependOptions = [];
    /**
     * @var string text to prepend.
     */
    public $prependText;
    /**
     * @var string the input type.
     * Following types are supported: checkbox, checkboxlist, dropdownlist, filefield, password,
     * radiobutton, radiobuttonlist, textarea, textfield, captcha and uneditable.
     */
    public $type;

    /**
     *### .captcha()
     * Renders a CAPTCHA.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function captcha();

    /**
     *### .checkBox()
     * Renders a checkbox.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function checkBox();

    /**
     *### .checkBoxGroupsList()
     * Renders a list of checkboxes using Button Groups.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function checkBoxGroupsList();

    /**
     *### .checkBoxList()
     * Renders a list of checkboxes.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function checkBoxList();

    /**
     *### .checkBoxListInline()
     * Renders a list of inline checkboxes.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function checkBoxListInline();

    /**
     *### .ckEditor()
     * Renders a bootstrap CKEditor wysiwyg editor.
     * @abstract
     * @return mixed
     */
    abstract protected function ckEditor();

    /**
     *### .colorpickerField()
     * Renders a colorpicker field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function colorpickerField();

    /**
     *### . customField()
     * Renders a pre-rendered custom field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function customField();

    /**
     *### .dateRangeField()
     * Renders a daterange picker field
     * @abstract
     * @return mixed
     */
    abstract protected function dateRangeField();

    /**
     *### .datepicketField()
     * Renders a datepicker field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function datepickerField();

    /**
     *### .datetimepicketField()
     * Renders a datetimepicker field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function datetimepickerField();

    /**
     *### .dropDownList()
     * Renders a drop down list (select).
     * @return string the rendered content
     * @abstract
     */
    abstract protected function dropDownList();

    /**
     *### .fileField()
     * Renders a file field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function fileField();

    /**
     *### .html5Editor()
     * Renders a bootstrap wysihtml5 editor.
     * @abstract
     * @return mixed
     */
    abstract protected function html5Editor();

    /**
     *### .markdownEditorJs()
     * Renders a markdownEditorJS wysiwyg field.
     * @abstract
     * @return mixed
     */
    abstract protected function markdownEditorJs();

    /**
     *### .maskedTextField()
     * Renders a masked text field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function maskedTextField();

    /**
     *### . numberField()
     * Renders a number field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function numberField();

    /**
     *### .passfieldField()
     * Renders a Pass*Field field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function passfieldField();

    /**
     *### .passwordField()
     * Renders a password field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function passwordField();

    /**
     *### .radioButton()
     * Renders a radio button.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function radioButton();

    /**
     *### .radioButtonGroupsList()
     * Renders a list of radio buttons using Button Groups.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function radioButtonGroupsList();

    /**
     *### .radioButtonList()
     * Renders a list of radio buttons.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function radioButtonList();

    /**
     *### .radioButtonListInline()
     * Renders a list of inline radio buttons.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function radioButtonListInline();

    /**
     *### .redactorJs()
     * Renders a redactorJS wysiwyg field.
     * @abstract
     * @return mixed
     */
    abstract protected function redactorJs();

    /**
     *### .select2Field()
     * Renders a select2 field.
     * @return mixed
     */
    abstract protected function select2Field();

    /**
     *### .textArea()
     * Renders a textarea.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function textArea();

    /**
     *### .textField()
     * Renders a text field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function textField();

    /**
     *### .timepickerField()
     * Renders a timepicker field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function timepickerField();

    /**
     *### .toggleButton()
     * Renders a toggle button.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function toggleButton();

    /**
     * Renders a typeAhead field.
     * @return mixed
     */
    abstract protected function typeAheadField();

    /**
     *### .uneditableField()
     * Renders an uneditable field.
     * @return string the rendered content
     * @abstract
     */
    abstract protected function uneditableField();

    /**
     *### .getAddonCssClass()
     * Returns the input container CSS classes.
     * @return string the CSS class
     */
    protected function getAddonCssClass()
    {
        $classes = [];
        if (isset($this->prependText)) {
            $classes[] = 'input-prepend';
        }
        if (isset($this->appendText)) {
            $classes[] = 'input-append';
        }

        return implode(' ', $classes);
    }

    /**
     *### .getAppend()
     * Returns the append element for the input.
     * @return string the element
     */
    protected function getAppend()
    {
        if ($this->hasAddOn()) {
            $htmlOptions = $this->appendOptions;

            if (isset($htmlOptions['class'])) {
                $htmlOptions['class'] .= ' add-on';
            } else {
                $htmlOptions['class'] = 'add-on';
            }

            ob_start();
            if (isset($this->appendText)) {
                if (isset($htmlOptions['isRaw']) && $htmlOptions['isRaw']) {
                    echo $this->appendText;
                } else {
                    echo CHtml::tag('span', $htmlOptions, $this->appendText);
                }
            }

            echo '</div>';
            return ob_get_clean();
        } else {
            return '';
        }
    }

    /**
     *### .getAppend()
     * Returns the id that should be used for the specified attribute
     * @param string $attribute the attribute
     * @return string the id
     */
    protected function getAttributeId($attribute)
    {
        return isset($this->htmlOptions['id'])
          ? $this->htmlOptions['id']
          : CHtml::getIdByName(CHtml::resolveName($this->model, $attribute));
    }

    /**
     *### .getContainerCssClass()
     * Returns the container CSS class for the input.
     * @return string the CSS class
     */
    protected function getContainerCssClass()
    {
        return $this->model->hasErrors($this->attribute) ? CHtml::$errorCss : '';
    }

    /**
     *### .getError()
     * Returns the error text for the input.
     * @return string the error text
     */
    protected function getError()
    {
        return $this->form->error(
          $this->model,
          $this->attribute,
          $this->errorOptions,
          $this->enableAjaxValidation,
          $this->enableClientValidation
        );
    }

    /**
     *### .getHint()
     * Returns the hint text for the input.
     * @return string the hint text
     */
    protected function getHint()
    {
        if (isset($this->hintText)) {
            $htmlOptions = $this->hintOptions;

            if (isset($htmlOptions['class'])) {
                $htmlOptions['class'] .= ' help-block';
            } else {
                $htmlOptions['class'] = 'help-block';
            }

            return CHtml::tag('p', $htmlOptions, $this->hintText);
        } else {
            return '';
        }
    }

    /**
     *### .getLabel()
     * Returns the label for the input.
     * @return string the label
     */
    protected function getLabel()
    {
        if ($this->label !== false && !in_array($this->type, ['checkbox', 'radio']) && $this->hasModel()) {
            return $this->form->labelEx($this->model, $this->attribute, $this->labelOptions);
        } else {
            if ($this->label !== null) {
                return $this->label;
            } else {
                return '';
            }
        }
    }

    /**
     *### .getPrepend()
     * Returns the prepend element for the input.
     * @return string the element
     */
    protected function getPrepend()
    {
        if ($this->hasAddOn()) {
            $htmlOptions = $this->prependOptions;

            if (isset($htmlOptions['class'])) {
                $htmlOptions['class'] .= ' add-on';
            } else {
                $htmlOptions['class'] = 'add-on';
            }

            ob_start();
            echo '<div class="' . $this->getAddonCssClass() . '">';
            if (isset($this->prependText)) {
                if (isset($htmlOptions['isRaw']) && $htmlOptions['isRaw']) {
                    echo $this->prependText;
                } else {
                    echo CHtml::tag('span', $htmlOptions, $this->prependText);
                }
            }

            return ob_get_clean();
        } else {
            return '';
        }
    }

    /**
     * Obtain separately hidden and visible field
     * @return array
     * @throws CException
     * @see TbInputVertical::radioButton
     * @see TbInputHorizontal::radioButton
     * @see TbInputVertical::checkBox
     * @see TbInputHorizontal::checkBox
     */
    protected function getSeparatedSelectableInput()
    {
        switch ($this->type) {
            case self::TYPE_CHECKBOX:
                $method = 'checkBox';
                break;
            case self::TYPE_RADIO:
                $method = 'radioButton';
                break;
            default:
                throw new CException('This method can be used with only selectable control', E_USER_ERROR);
        }

        $control = $this->form->{$method}($this->model, $this->attribute, $this->htmlOptions);
        $hidden = '';

        $hasHiddenField =
          (array_key_exists('uncheckValue', $this->htmlOptions) && $this->htmlOptions['uncheckValue'] === null)
            ? false
            : true;

        if ($hasHiddenField && preg_match('/\<input .*?type="hidden".*?\/\>/', $control, $matches)) {
            $hidden = $matches[0];
            $control = str_replace($hidden, '', $control);
        }

        return [$hidden, $control];
    }

    /**
     *### .hasAddOn()
     * Returns whether the input has an add-on (prepend and/or append).
     * @return boolean the result
     */
    protected function hasAddOn()
    {
        return isset($this->prependText) || isset($this->appendText);
    }

    /**
     *### .processHtmlOptions()
     * Processes the html options.
     */
    protected function processHtmlOptions()
    {
        if (isset($this->htmlOptions['label'])) {
            $this->label = $this->htmlOptions['label'];
            unset($this->htmlOptions['label']);
        }

        if (isset($this->htmlOptions['prepend'])) {
            $this->prependText = $this->htmlOptions['prepend'];
            unset($this->htmlOptions['prepend']);
        }

        if (isset($this->htmlOptions['append'])) {
            $this->appendText = $this->htmlOptions['append'];
            unset($this->htmlOptions['append']);
        }

        if (isset($this->htmlOptions['hint'])) {
            $this->hintText = $this->htmlOptions['hint'];
            unset($this->htmlOptions['hint']);
        }

        if (isset($this->htmlOptions['labelOptions'])) {
            $this->labelOptions = $this->htmlOptions['labelOptions'];
            unset($this->htmlOptions['labelOptions']);
        }

        if (isset($this->htmlOptions['prependOptions'])) {
            $this->prependOptions = $this->htmlOptions['prependOptions'];
            unset($this->htmlOptions['prependOptions']);
        }

        if (isset($this->htmlOptions['appendOptions'])) {
            $this->appendOptions = $this->htmlOptions['appendOptions'];
            unset($this->htmlOptions['appendOptions']);
        }

        if (isset($this->htmlOptions['hintOptions'])) {
            $this->hintOptions = $this->htmlOptions['hintOptions'];
            unset($this->htmlOptions['hintOptions']);
        }

        if (isset($this->htmlOptions['errorOptions'])) {
            $this->errorOptions = $this->htmlOptions['errorOptions'];
            if (isset($this->htmlOptions['errorOptions']['enableAjaxValidation'])) {
                $this->enableAjaxValidation = (boolean) $this->htmlOptions['errorOptions']['enableAjaxValidation'];
            }

            if (isset($this->htmlOptions['errorOptions']['enableClientValidation'])) {
                $this->enableClientValidation = (boolean) $this->htmlOptions['errorOptions']['enableClientValidation'];
            }
            unset($this->htmlOptions['errorOptions']);
        }

        if (isset($this->htmlOptions['captchaOptions'])) {
            $this->captchaOptions = $this->htmlOptions['captchaOptions'];
            unset($this->htmlOptions['captchaOptions']);
        }
    }

    /**
     *### .init()
     * Initializes the widget.
     * @throws CException if the widget could not be initialized.
     */
    public function init()
    {
        if (!isset($this->form)) {
            throw new CException(__CLASS__ . ': Failed to initialize widget! Form is not set.');
        }

        if (!isset($this->model)) {
            throw new CException(__CLASS__ . ': Failed to initialize widget! Model is not set.');
        }

        if (!isset($this->type)) {
            throw new CException(__CLASS__ . ': Failed to initialize widget! Input type is not set.');
        }

        // todo: move this logic elsewhere, it doesn't belong here ...
        if ($this->type === self::TYPE_UNEDITABLE) {
            if (isset($this->htmlOptions['class'])) {
                $this->htmlOptions['class'] .= ' uneditable-input';
            } else {
                $this->htmlOptions['class'] = 'uneditable-input';
            }
        }

        $this->processHtmlOptions();
    }

    /**
     *### .run()
     * Runs the widget.
     * @throws CException if the widget type is invalid.
     */
    public function run()
    {
        switch ($this->type) {
            case self::TYPE_CHECKBOX:
                $this->checkBox();
                break;

            case self::TYPE_CHECKBOXLIST:
                $this->checkBoxList();
                break;

            case self::TYPE_CHECKBOXLIST_INLINE:
                $this->checkBoxListInline();
                break;

            case self::TYPE_CHECKBOXGROUPSLIST:
                $this->checkBoxGroupsList();
                break;

            case self::TYPE_DROPDOWN:
                $this->dropDownList();
                break;

            case self::TYPE_FILE:
                $this->fileField();
                break;

            case self::TYPE_PASSWORD:
                $this->passwordField();
                break;

            case self::TYPE_PASSFIELD:
                $this->passfieldField();
                break;

            case self::TYPE_RADIO:
                $this->radioButton();
                break;

            case self::TYPE_RADIOLIST:
                $this->radioButtonList();
                break;

            case self::TYPE_RADIOLIST_INLINE:
                $this->radioButtonListInline();
                break;

            case self::TYPE_RADIOBUTTONGROUPSLIST:
                $this->radioButtonGroupsList();
                break;

            case self::TYPE_TEXTAREA:
                $this->textArea();
                break;

            case 'textfield': // backwards compatibility
            case self::TYPE_TEXT:
                $this->textField();
                break;

            case self::TYPE_MASKEDTEXT:
                $this->maskedTextField();
                break;

            case self::TYPE_CAPTCHA:
                $this->captcha();
                break;

            case self::TYPE_UNEDITABLE:
                $this->uneditableField();
                break;

            case self::TYPE_DATEPICKER:
                $this->datepickerField();
                break;

            case self::TYPE_DATETIMEPICKER:
                $this->datetimepickerField();
                break;

            case self::TYPE_REDACTOR:
                $this->redactorJs();
                break;

            case self::TYPE_MARKDOWNEDITOR:
                $this->markdownEditorJs();
                break;

            case self::TYPE_HTML5EDITOR:
                $this->html5Editor();
                break;

            case self::TYPE_DATERANGEPICKER:
                $this->dateRangeField();
                break;

            case self::TYPE_TOGGLEBUTTON:
                $this->toggleButton();
                break;

            case self::TYPE_COLORPICKER:
                $this->colorpickerField();
                break;

            case self::TYPE_CKEDITOR:
                $this->ckEditor();
                break;

            case self::TYPE_TIMEPICKER:
                $this->timepickerField();
                break;

            case self::TYPE_SELECT2:
                $this->select2Field();
                break;

            case self::TYPE_TYPEAHEAD:
                $this->typeAheadField();
                break;

            case self::TYPE_NUMBER:
                $this->numberField();
                break;

            case self::TYPE_CUSTOM:
                $this->customField();
                break;

            default:
                throw new CException(__CLASS__ . ': Failed to run widget! Type is invalid.');
        }
    }
}
