<?php
/**
 * ChPolar class file.
 * @author  Stefan Meiwald <stefanmeiwald@yahoo.com>
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package chartjs.widgets
 * @since   0.0.1
 */

/**
 * ChartJs Polar Chart widget.
 * @see http://www.chartjs.org/docs/#polarAreaChart
 */
class ChPolar extends CWidget
{
    const CONTAINER_PREFIX = 'yii_chartjs_polar_';
    /**
     * @var array data and color information for the chart
     */
    public $datasets = [];
    /**
     * @var draw labels for this chart if true
     */
    public $drawLabels = false;
    /**
     * @var chart height
     */
    public $height = 400;
    /**
     * @var html id of canvas element
     */
    public $htmlId;
    /**
     * @var array the HTML attributes for the widget container.
     */
    public $htmlOptions = [];
    /**
     * @var array labels for the chart
     */
    public $labels = [];
    /**
     * @var array the options for the ChartJS Javascript plugin.
     */
    public $options = [];
    /**
     * @var chart width
     */
    public $width = 400;
    /**
     * @var widget count to generate html id
     */
    private static $_containerId = 0;

    /**
     * Draws the labels for the chart
     */
    private function drawLabels()
    {
        echo CHtml::openTag('div', ['class' => 'labels']);
        foreach ($this->datasets as $dataset) {
            if (isset($dataset['label'])) {
                $attributes['class'] = 'chart-label';
                $attributes['style'] = 'background-color: ' . $dataset['color'] . ';';
                echo CHtml::openTag('span', $attributes);
                echo $dataset['label'];
                echo CHtml::closeTag('span');
            }
        }
        echo CHtml::closeTag('div');
    }

    /**
     * Initializes the widget.
     */
    public function init()
    {
        if (!empty($this->htmlOptions['id'])) {
            $this->htmlId = $this->htmlOptions['id'];
        } else {
            $this->htmlId = self::CONTAINER_PREFIX . self::getNextId();
        }

        $this->htmlOptions['width'] = $this->width;
        $this->htmlOptions['height'] = $this->height;
        $this->htmlOptions['id'] = $this->htmlId;

        echo CHtml::openTag('canvas', $this->htmlOptions);
    }

    /**
     * Runs the widget.
     */
    public function run()
    {
        echo CHtml::closeTag('canvas');

        if ($this->drawLabels) {
            $this->drawLabels();
        }

        $data = CJSON::encode($this->datasets);
        $options = CJSON::encode($this->options);

        $cs = Yii::app()->getClientScript();
        $cs->registerScript(
          __CLASS__ . '#' . $this->htmlId,
          "var chartId=$(\"#" . $this->htmlId . "\").get(0);
            if (typeof chartId != 'undefined') {
            var chart = new Chart(chartId.getContext(\"2d\")).PolarArea(" . $data . "," . $options . ");
            }"
        );
    }

    /**
     * Returns the next html id to avoid duplicated ids
     */
    static public function getNextId()
    {
        return self::$_containerId++;
    }
}
