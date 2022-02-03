<?php
/**
 *##  TbButton class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 * @since     0.9.10
 * @author    Amr Bedair <amr.bedair@gmail.com>
 * @since     v4.0.0 - upgraded to bootstrap 3.1.1
 */
Yii::import('booster.widgets.TbWidget');

/**
 * Bootstrap button widget.
 * @see     http://getbootstrap.com/css/#buttons
 * @package booster.widgets.forms.buttons
 */
class TbButton extends TbWidget
{

    // Button callback types.
    const BUTTON_AJAXBUTTON = 'ajaxButton';
    const BUTTON_AJAXLINK = 'ajaxLink';
    const BUTTON_AJAXSUBMIT = 'ajaxSubmit';
    const BUTTON_BUTTON = 'button';
    const BUTTON_INPUTBUTTON = 'inputButton';
    const BUTTON_INPUTSUBMIT = 'inputSubmit';
    const BUTTON_LINK = 'link';
    const BUTTON_RESET = 'reset';
    const BUTTON_SUBMIT = 'submit';
    const BUTTON_SUBMITLINK = 'submitLink';
    const BUTTON_TOGGLE_CHECKBOX = 'checkbox';
    const BUTTON_TOGGLE_RADIO = 'radio';
    const CTX_LINK = 'link';
    const CTX_LINK_CLASS = 'link';

    // Button sizes.
    const SIZE_DEFAULT = 'default';
    const SIZE_EXTRA_SMALL = 'extra_small';
    const SIZE_LARGE = 'large';
    const SIZE_SMALL = 'small';
    /**
     * @var boolean indicates whether the button is active.
     */
    public $active = false;
    /**
     * @var array the button ajax options (used by 'ajaxLink' and 'ajaxButton').
     */
    public $ajaxOptions = [];
    /**
     * @var boolean indicates whether the button should span the full width of the a parent.
     */
    public $block = false;
    /**
     * @var string the button callback types.
     * Valid values are 'link', 'button', 'submit', 'submitLink', 'reset', 'ajaxLink', 'ajaxButton' and 'ajaxSubmit'.
     */
    public $buttonType = self::BUTTON_BUTTON;
    /**
     * @var string the complete text.
     */
    public $completeText;
    /**
     * @var boolean indicates whether the button is disabled.
     */
    public $disabled = false;
    /**
     * @var array the HTML attributes for the dropdown menu.
     * @since 0.9.11
     */
    public $dropdownOptions = [];
    /**
     * @var boolean indicates whether to encode the label.
     */
    public $encodeLabel = true;
    /**
     * @var array the HTML attributes for the widget container.
     */
    public $htmlOptions = [];
    /**
     * @var string the button icon, e.g. 'ok' or 'remove white'.
     */
    public $icon;
    /**
     * @var array the dropdown button items.
     */
    public $items;
    /**
     * @var string the button label.
     */
    public $label;
    /**
     * @var string the loading text.
     */
    public $loadingText;
    /**
     * @var string the button size.
     * Valid values are 'large', 'default', 'small' and 'extra-small'.
     */
    public $size;
    /**
     * @var boolean indicates whether to enable toggle.
     */
    public $toggle;
    /**
     * Tooltip for button
     * @var bool
     * @since 2.1.0
     */
    public $tooltip = false;
    /**
     * Tooltip options
     * @var array
     * @since 2.1.0
     */
    public $tooltipOptions = [];
    /**
     * @var string the button URL.
     */
    public $url;
    /**
     * @var bool whether the button is visible or not
     * @since 0.9.11
     */
    public $visible = true;
    protected static $sizeClasses = [
      self::SIZE_LARGE       => 'btn-lg',
      self::SIZE_DEFAULT     => '',
      self::SIZE_SMALL       => 'btn-sm',
      self::SIZE_EXTRA_SMALL => 'btn-xs',
    ];

    /**
     *### .createButton()
     * Creates the button element.
     * @return string the created button.
     */
    protected function createButton()
    {

        switch ($this->buttonType) {
            case self::BUTTON_LINK:
                return CHtml::link($this->label, $this->url, $this->htmlOptions);

            case self::BUTTON_SUBMIT:
                $this->htmlOptions['type'] = 'submit';
                return CHtml::htmlButton($this->label, $this->htmlOptions);

            case self::BUTTON_RESET:
                $this->htmlOptions['type'] = 'reset';
                return CHtml::htmlButton($this->label, $this->htmlOptions);

            case self::BUTTON_SUBMITLINK:
                return CHtml::linkButton($this->label, $this->htmlOptions);

            case self::BUTTON_AJAXLINK:
                //Alexy
                if (!isset($this->htmlOptions['live'])) {
                    $this->htmlOptions['live'] = false;
                }
                return CHtml::ajaxLink($this->label, $this->url, $this->ajaxOptions, $this->htmlOptions);

            case self::BUTTON_AJAXBUTTON:
                $this->ajaxOptions['url'] = $this->url;
                $this->htmlOptions['ajax'] = $this->ajaxOptions;
                //Alexy
                if (!isset($this->htmlOptions['live'])) {
                    $this->htmlOptions['live'] = false;
                }
                Yii::import('booster.helpers.TbHtml');
                //include_once('TbHtml.php');
                return TbHtml::htmlButton($this->label, $this->htmlOptions);

            case self::BUTTON_AJAXSUBMIT:
                $this->ajaxOptions['type'] = isset($this->ajaxOptions['type']) ? $this->ajaxOptions['type'] : 'POST';
                $this->ajaxOptions['url'] = $this->url;
                $this->htmlOptions['type'] = 'submit';
                //Alexy
                if (!isset($this->htmlOptions['live'])) {
                    $this->htmlOptions['live'] = false;
                }
                $this->htmlOptions['ajax'] = $this->ajaxOptions;
                Yii::import('booster.helpers.TbHtml');
                //include_once('TbHtml.php');
                return TbHtml::htmlButton($this->label, $this->htmlOptions);

            case self::BUTTON_INPUTBUTTON:
                return CHtml::button($this->label, $this->htmlOptions);

            case self::BUTTON_INPUTSUBMIT:
                $this->htmlOptions['type'] = 'submit';
                return CHtml::button($this->label, $this->htmlOptions);

            case self::BUTTON_TOGGLE_RADIO:
                return $this->createToggleButton('radio');

            case self::BUTTON_TOGGLE_CHECKBOX:
                return $this->createToggleButton('checkbox');

            default:
            case self::BUTTON_BUTTON:
                return CHtml::htmlButton($this->label, $this->htmlOptions);
        }
    }

    protected function createToggleButton($toggleType)
    {

        $html = '';
        $html .= CHtml::openTag('label', $this->htmlOptions);
        $html .= "<input type='{$toggleType}' name='{$this->id}_options' id='option_{$this->id}'> {$this->label}";
        $html .= CHtml::closeTag('label');

        return $html;
    }

    /**
     *### .hasDropdown()
     * Returns whether the button has a dropdown.
     * @return bool the result.
     */
    protected function hasDropdown()
    {

        return isset($this->items) && !empty($this->items);
    }

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {

        if (false === $this->visible) {
            return;
        }

        $classes = ['btn'];

        if ($this->isValidContext()) {
            $classes[] = 'btn-' . $this->getContextClass();
        }

        $validSizes = [
          self::SIZE_LARGE,
          self::SIZE_DEFAULT,
          self::SIZE_SMALL,
          self::SIZE_EXTRA_SMALL,
        ];

        if (isset($this->size) && in_array($this->size, $validSizes)) {
            $classes[] = self::$sizeClasses[$this->size];
        }

        if ($this->block) {
            $classes[] = 'btn-block';
        }

        if ($this->active) {
            $classes[] = 'active';
        }

        if ($this->disabled) {
            $disableTypes = [
              self::BUTTON_BUTTON,
              self::BUTTON_SUBMIT,
              self::BUTTON_RESET,
              self::BUTTON_AJAXBUTTON,
              self::BUTTON_AJAXSUBMIT,
              self::BUTTON_INPUTBUTTON,
              self::BUTTON_INPUTSUBMIT,
            ];

            if (in_array($this->buttonType, $disableTypes)) {
                $this->htmlOptions['disabled'] = 'disabled';
            }

            $classes[] = 'disabled';
        }

        if (!isset($this->url) && isset($this->htmlOptions['href'])) {
            $this->url = $this->htmlOptions['href'];
            unset($this->htmlOptions['href']);
        }

        if ($this->encodeLabel) {
            $this->label = CHtml::encode($this->label);
        }

        if ($this->hasDropdown()) {
            if (!isset($this->url)) {
                $this->url = '#';
            }

            $classes[] = 'dropdown-toggle';
            $this->label .= ' <span class="caret"></span>';
            $this->htmlOptions['data-toggle'] = 'dropdown';
        }

        if (!empty($classes)) {
            $classes = implode(' ', $classes);
            if (isset($this->htmlOptions['class'])) {
                $this->htmlOptions['class'] .= ' ' . $classes;
            } else {
                $this->htmlOptions['class'] = $classes;
            }
        }

        if (isset($this->icon)) { // no need for implode as newglyphicon only supports one icon
            if (strpos($this->icon, 'icon') === false && strpos($this->icon, 'fa') === false) {
                $this->icon =
                  'glyphicon glyphicon-' . $this->icon; // implode(' glyphicon-', explode(' ', $this->icon));
                $this->label = '<span class="' . $this->icon . '"></span> ' . $this->label;
            } else { // to support font awesome icons
                $this->label = '<i class="' . $this->icon . '"></i> ' . $this->label;
            }
        }

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }

        if (isset($this->toggle)) {
            $this->htmlOptions['data-toggle'] = 'button';
        }

        if (isset($this->loadingText)) {
            $this->htmlOptions['data-loading-text'] = $this->loadingText;
        }

        if (isset($this->completeText)) {
            $this->htmlOptions['data-complete-text'] = $this->completeText;
        }

        if (!empty($this->tooltip) && !$this->toggle) {
            if (!is_array($this->tooltipOptions)) {
                $this->tooltipOptions = [];
            }

            $this->htmlOptions['data-toggle'] = 'tooltip';
            $this->htmlOptions['title'] = $this->tooltip;
            foreach ($this->tooltipOptions as $key => $value) {
                $this->htmlOptions['data-' . $key] = $value;
            }

            /**
             * Encode delay option
             * @link http://getbootstrap.com/2.3.2/javascript.html#tooltips
             */
            if (isset($this->htmlOptions['data-delay']) && is_array($this->htmlOptions['data-delay'])) {
                $this->htmlOptions['data-delay'] = CJSON::encode($this->htmlOptions['data-delay']);
            }
        }
    }

    /**
     *### .run()
     * Runs the widget.
     */
    public function run()
    {
        if (false === $this->visible) {
            return;
        }

        if ($this->hasDropdown()) {

            echo $this->createButton();

            $this->controller->widget(
              'booster.widgets.TbDropdown',
              [
                'encodeLabel' => $this->encodeLabel,
                'items'       => $this->items,
                'htmlOptions' => $this->dropdownOptions,
                'id'          => isset($this->dropdownOptions['id']) ? $this->dropdownOptions['id'] : null,
              ]
            );
        } else {
            echo $this->createButton();
        }
    }
}
