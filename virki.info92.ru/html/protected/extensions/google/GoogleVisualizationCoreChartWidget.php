<?php
/*
 * Google Visualization Widgets
 * Robert Antoine
 * rob@musingmonkeys.com
 * @author Robert Antoine <rob@musingmonkeys.com>
 * @version 0.1
 */

/* Use :
   $this->Widget('ext.google.GoogleVisualizationCoreChartWidget', array(
        'visualization' => 'PieChart',
        'options'=>array(
            'data'=>array(
                array('Task', 'Hours per Day'),
               array('Work' , 11),
               array('Eat', 2),
               array('Commute', 2),
                array('Watch TV', 2),
                array('Sleep', 7)
            ),
            'options' => array('title'=>'My Daily Activities')
        ), 
        'htmlOptions'=>array('style'=>'width: 900px; height: 500px;')
   ));
 */

class GoogleVisualizationCoreChartWidget extends CWidget
{

    public $htmlOptions = [];
    public $options = [];
    public $visualization;

    public function run()
    {
        $id = $this->getId();
        $this->htmlOptions['id'] = $id;

        echo CHtml::openTag('div', $this->htmlOptions);
        echo CHtml::closeTag('div');

        $jsData = CJSON::encode($this->options['data']);
        $jsOptions = CJSON::encode($this->options['options']);

        $script = '
            google.setOnLoadCallback(drawChart' . $id . ');
            function drawChart' . $id . '() {
                var data = google.visualization.arrayToDataTable(' . $jsData . ');

                var options = ' . $jsOptions . ';

                var chart = new google.visualization.' . $this->visualization . '(document.getElementById("' . $id . '"));
                chart.draw(data, options);
            }';

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile("https://www.google.com/jsapi");
        $cs->registerScript(
          'GoogleVisualizationWidget',
          'google.load("visualization", "1", {packages:["corechart"]});',
          CClientScript::POS_HEAD
        );
        $cs->registerScript($id, $script, CClientScript::POS_HEAD);
    }
}