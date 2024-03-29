<?php
/**
 *## TbHighCharts class file
 * @author    : antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 *## TbHighCharts widget class
 * TbHighCharts is a layer of the amazing {@link http://www.highcharts.com/ Highcharts}
 * To use this widget, you may insert the following code in a view:
 * <pre>
 * $this->widget('booster.widgets.TbHighCharts', array(
 *    'options'=>array(
 *       'title' => array('text' => 'Fruit Consumption'),
 *       'xAxis' => array(
 *          'categories' => array('Apples', 'Bananas', 'Oranges')
 *       ),
 *       'yAxis' => array(
 *          'title' => array('text' => 'Fruit eaten')
 *       ),
 *       'series' => array(
 *          array('name' => 'Jane', 'data' => array(1, 0, 4)),
 *          array('name' => 'John', 'data' => array(5, 7, 3))
 *       )
 *    )
 * ));
 * </pre>
 * To find out more about the possible {@link $options} attribute please refer to
 * {@link http://www.hightcharts.com/ Highcharts site}
 * @package booster.widgets.charts
 */
class TbHighCharts extends CWidget
{
    /**
     * @var array $htmlOptions the HTML tag attributes
     */
    public $htmlOptions = [];
    /**
     * @var array $options the highcharts js configuration options
     */
    public $options = [];

    /**
     * Publishes and registers the necessary script files.
     */
    protected function registerClientScript()
    {
        $assets = Booster::getBooster()->cs;

        $assets->registerPackage('highcharts');

        $baseUrl = $assets->packages['highcharts']['baseUrl'];

        $this->options = CMap::mergeArray(['exporting' => ['enabled' => true]], $this->options);

        if (isset($this->options['exporting']) && @$this->options['exporting']['enabled']) {
            $assets->registerScriptFile($baseUrl . '/modules/exporting.js');
        }
        if (isset($this->options['theme'])) {
            $assets->registerScriptFile($baseUrl . '/themes/' . $this->options['theme'] . '.js');
        }

        $options = CJavaScript::encode($this->options);

        $assets->registerScript(
          __CLASS__ . '#' . $this->getId(),
          "var highchart{$this->getId()} = new Highcharts.Chart({$options});"
        );
    }

    /**
     * Renders the widget.
     */
    public function run()
    {
        $id = $this->getId();

        // if there is no renderTo id, build the layer with current id and initialize renderTo option
        if (!isset($this->options['chart']) || !isset($this->options['chart']['renderTo'])) {
            $this->htmlOptions['id'] = $id;
            echo '<div ' . CHtml::renderAttributes($this->htmlOptions) . ' ></div>';

            if (isset($this->options['chart']) && is_array($this->options['chart'])) {
                $this->options['chart']['renderTo'] = $id;
            } else {
                $this->options['chart'] = ['renderTo' => $id];
            }
        }
        $this->registerClientScript();
    }
}