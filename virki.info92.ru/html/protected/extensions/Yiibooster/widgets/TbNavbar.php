<?php
/**
 *## TbNavbar class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('booster.widgets.TbCollapse');

/**
 *## Bootstrap navigation bar widget.
 * @package booster.widgets.navigation
 * @since   0.9.7
 */
class TbNavbar extends CWidget
{

    const CONTAINER_PREFIX = 'yii_booster_collapse_';

    // Navbar types.
    const FIXED_BOTTOM = 'bottom';
    const FIXED_TOP = 'top';

    // Navbar fix locations.
    const TYPE_DEFAULT = 'default';
    const TYPE_INVERSE = 'inverse';
    /**
     * @var string the text for the brand.
     */
    public $brand;
    /**
     * @var array the HTML attributes for the brand link.
     */
    public $brandOptions = [];
    /**
     * @var string the URL for the brand link.
     */
    public $brandUrl;
    /**
     * @var boolean whether to enable collapsing on narrow screens. Default to true.
     */
    public $collapse = true;
    /**
     * @var mixed fix location of the navbar if applicable.
     * Valid values are 'top' and 'bottom'. Defaults to 'top'.
     * Setting the value to false will make the navbar static.
     * @since 0.9.8
     */
    public $fixed = self::FIXED_TOP;
    /**
     * @var boolean whether the nav span over the full width. Defaults to false.
     * @since 0.9.8
     */
    public $fluid = false;
    /**
     * @var array the HTML attributes for the widget container.
     */
    public $htmlOptions = [];
    /**
     * @var array navigation items.
     * @since 0.9.8
     */
    public $items = [];
    /**
     * @var string the navbar type. Valid values are 'inverse'.
     * @since 1.0.0
     */
    public $type = self::TYPE_DEFAULT;

    /**
     *### .getContainerCssClass()
     * Returns the navbar container CSS class.
     * @return string the class
     */
    protected function getContainerCssClass()
    {

        return $this->fluid ? 'container-fluid' : 'container';
    }

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {

        if ($this->brand !== false) {
            if (!isset($this->brand)) {
                $this->brand = CHtml::encode(Yii::app()->name);
            }

            if (!isset($this->brandUrl)) {
                $this->brandUrl = Yii::app()->homeUrl;
            }

            $this->brandOptions['href'] = CHtml::normalizeUrl($this->brandUrl);

            if (isset($this->brandOptions['class'])) {
                $this->brandOptions['class'] .= ' navbar-brand';
            } else {
                $this->brandOptions['class'] = 'navbar-brand';
            }
        }

        $classes = ['navbar'];

        if (isset($this->type) && in_array($this->type, [self::TYPE_DEFAULT, self::TYPE_INVERSE])) {
            $classes[] = 'navbar-' . $this->type;
        } else {
            $classes[] = 'navbar-' . self::TYPE_DEFAULT;
        }

        if ($this->fixed !== false && in_array($this->fixed, [self::FIXED_TOP, self::FIXED_BOTTOM])) {
            $classes[] = 'navbar-fixed-' . $this->fixed;
        }

        if (!empty($classes)) {
            $classes = implode(' ', $classes);
            if (isset($this->htmlOptions['class'])) {
                $this->htmlOptions['class'] .= ' ' . $classes;
            } else {
                $this->htmlOptions['class'] = $classes;
            }
        }
    }

    /**
     *### .run()
     * Runs the widget.
     */
    public function run()
    {

        echo CHtml::openTag('nav', $this->htmlOptions);
        echo '<div class="' . $this->getContainerCssClass() . '">';

        echo '<div class="navbar-header">';
        if ($this->collapse) {
            $this->controller->widget('booster.widgets.TbButton', [
              'label'       => '<span class="fa fa-bar"></span><span class="fa fa-bar"></span><span class="fa fa-bar"></span>',
              'encodeLabel' => false,
              'htmlOptions' => [
                'class'       => 'navbar-toggle',
                'data-toggle' => 'collapse',
                'data-target' => '#' . self::CONTAINER_PREFIX . $this->id,
              ],
            ]);
        }

        if ($this->brand !== false) {
            if ($this->brandUrl !== false) {
                echo CHtml::openTag('a', $this->brandOptions) . $this->brand . '</a>';
            } else {
                unset($this->brandOptions['href']); // spans cannot have a href attribute
                echo CHtml::openTag('span', $this->brandOptions) . $this->brand . '</span>';
            }
        }
        echo '</div>';

        echo '<div class="collapse navbar-collapse" id="' . self::CONTAINER_PREFIX . $this->id . '">';
        foreach ($this->items as $item) {
            if (is_string($item)) {
                echo $item;
            } else {
                if (isset($item['class'])) {
                    $className = $item['class'];
                    unset($item['class']);

                    $this->controller->widget($className, $item);
                }
            }
        }
        echo '</div></div></nav>';
    }
}
