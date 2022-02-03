<?php
/**
 *## TbCarousel class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 * @since     0.9.10
 * @author    Amr Bedair <amr.bedair@gmail.com>
 * @since     v4.0.0 - modified to work with bootstrap 3.1.1
 */

/**
 *## Bootstrap carousel widget.
 * @see     <http://twitter.github.com/bootstrap/javascript.html#carousel>
 * @package booster.widgets.grouping
 */
class TbCarousel extends CWidget
{

    /**
     * @var boolean indicates whether to display the previous and next links.
     */
    public $displayPrevAndNext = true;
    /**
     * @var string[] the Javascript event handlers.
     */
    public $events = [];
    /**
     * @var array the HTML attributes for the widget container.
     */
    public $htmlOptions = [];
    /**
     * @var array the carousel items configuration.
     */
    public $items = [];
    /**
     * @var string the next button label. Defaults to '&rsaquo;'.
     */
    public $nextLabel = '<span class="glyphicon glyphicon-chevron-right"></span>';
    /**
     * @var array the options for the Bootstrap Javascript plugin.
     */
    public $options = [];
    /**
     * @var string the previous button label. Defaults to '&lsaquo;'.
     */
    public $prevLabel = '<span class="glyphicon glyphicon-chevron-left"></span>';
    /**
     * @var boolean indicates whether the carousel should slide items.
     */
    public $slide = true;

    /**
     *
     */
    protected function renderIndicators()
    {

        echo '<ol class="carousel-indicators">';
        $count = count($this->items);
        for ($i = 0; $i < $count; $i++) {
            echo '<li data-target="#' .
              $this->id .
              '" data-slide-to="' .
              $i .
              '" class="' .
              ($i === 0 ? 'active' : '') .
              '"></li>';
        }
        echo '</ol>';
    }

    /**
     *### .renderItems()
     * Renders the carousel items.
     * @param array $items the item configuration.
     */
    protected function renderItems($items)
    {

        foreach ($items as $i => $item) {
            if (!is_array($item)) {
                continue;
            }

            if (isset($item['visible']) && $item['visible'] === false) {
                continue;
            }

            if (!isset($item['itemOptions'])) {
                $item['itemOptions'] = [];
            }

            $classes = ['item'];

            if ($i === 0) {
                $classes[] = 'active';
            }

            if (!empty($classes)) {
                $classes = implode(' ', $classes);
                if (isset($item['itemOptions']['class'])) {
                    $item['itemOptions']['class'] .= ' ' . $classes;
                } else {
                    $item['itemOptions']['class'] = $classes;
                }
            }

            echo CHtml::openTag('div', $item['itemOptions']);

            if (isset($item['image'])) {
                if (!isset($item['alt'])) {
                    $item['alt'] = '';
                }

                if (!isset($item['imageOptions'])) {
                    $item['imageOptions'] = [];
                }

                /**
                 * Is this image should be a link?
                 * @since 2.1.0
                 */
                if (isset($item['link'])) {
                    // Any kind of link options
                    if (!isset($item['linkOptions']) || !is_array($item['linkOptions'])) {
                        $item['linkOptions'] = [];
                    }

                    // URL
                    if (is_array($item['link'])) {
                        $route = isset($item['link'][0]) ? $item['link'][0] : '';
                        $item['linkOptions']['href'] = Yii::app()->createUrl($route, array_splice($item['link'], 1));
                    } else {
                        $item['linkOptions']['href'] = $item['link'];
                    }

                    // Print out 'A' tag
                    echo CHtml::openTag('a', $item['linkOptions']);
                }

                echo CHtml::image($item['image'], $item['alt'], $item['imageOptions']);

                if (isset($item['link'])) {
                    echo '</a>';
                }
            }

            if (!empty($item['caption']) && (isset($item['label']) || isset($item['caption']))) {
                if (!isset($item['captionOptions'])) {
                    $item['captionOptions'] = [];
                }

                if (isset($item['captionOptions']['class'])) {
                    $item['captionOptions']['class'] .= ' carousel-caption';
                } else {
                    $item['captionOptions']['class'] = 'carousel-caption';
                }

                echo CHtml::openTag('div', $item['captionOptions']);

                if (isset($item['label'])) {
                    echo '<h3>' . $item['label'] . '</h3>';
                }

                if (isset($item['caption'])) {
                    echo '<p>' . $item['caption'] . '</p>';
                }

                echo '</div>';
            }
            echo '</div>';
        }
    }

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {

        if (!isset($this->htmlOptions['id'])) {
            $this->htmlOptions['id'] = $this->getId();
        }

        $classes = ['carousel'];

        if ($this->slide === true) {
            $classes[] = 'slide';
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

        $id = $this->htmlOptions['id'];

        echo CHtml::openTag('div', $this->htmlOptions);
        $this->renderIndicators();
        echo '<div class="carousel-inner">';
        $this->renderItems($this->items);
        echo '</div>';

        if ($this->displayPrevAndNext) {
            echo '<a class="carousel-control left" href="#' . $id . '" data-slide="prev">' . $this->prevLabel . '</a>';
            echo '<a class="carousel-control right" href="#' . $id . '" data-slide="next">' . $this->nextLabel . '</a>';
        }

        echo '</div>';

        /** @var CClientScript $cs */
        $cs = Yii::app()->getClientScript();
        $options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
        $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#{$id}').carousel({$options});");

        foreach ($this->events as $name => $handler) {
            $handler = CJavaScript::encode($handler);
            $cs->registerScript(__CLASS__ . '#' . $id . '_' . $name, "jQuery('#{$id}').on('{$name}', {$handler});");
        }
    }
}
