<? /*******************************************************************************************************************
 * This file is the part of VPlatform project https://info92.ru
 * Copyright (C) 2013-2020, info92 team
 * All rights reserved and protected by law.
 * You can't use this file without of the author's permission.
 * ====================================================================================================================
 * <description file="price_table.php">
 * </description>
 * График цен
 **********************************************************************************************************************/
?>
<?=
cms::customContent('item_economy_table');
$this->widget(
  'chartjs.widgets.ChLine',
  [
    'width'       => 555,
    'height'      => 150,
    'htmlOptions' => [],
    'labels'      => $prices->pricesX,
    'datasets'    => [
      [
        "fillColor"        => "rgba(220,220,220,0.5)",
        "strokeColor"      => "rgba(220,220,220,1)",
        "pointColor"       => "rgba(220,220,220,1)",
        "pointStrokeColor" => "#ffffff",
        "data"             => $prices->pricesYprice,
      ],
      [
        "fillColor"        => "rgba(220,220,120,0.5)",
        "strokeColor"      => "rgba(220,220,120,1)",
        "pointColor"       => "rgba(220,120,120,1)",
        "pointStrokeColor" => "#dddddd",
        "data"             => $prices->pricesYeconomy,
      ],
    ],
    'options'     => [
//Boolean - If we show the scale above the chart data
      'scaleOverlay'        => false,
//Boolean - If we want to override with a hard coded scale
      'scaleOverride'       => false,
//** Required if scaleOverride is true **
//Number - The number of steps in a hard coded scale
      'scaleSteps'          => null,
//Number - The value jump in the hard coded scale
      'scaleStepWidth'      => null,
//Number - The scale starting value
      'scaleStartValue'     => null,
//String - Colour of the scale line
      'scaleLineColor'      => "rgba(0,0,0,.1)",
//Number - Pixel width of the scale line
      'scaleLineWidth'      => 2,
//Boolean - Whether to show labels on the scale
      'scaleShowLabels'     => true,
//Interpolated JS string - can access value
      'scaleLabel'          => "<%=value%>",
//String - Scale label font declaration for the scale label
      'scaleFontFamily'     => "'Arial'",
//Number - Scale label font size in pixels
      'scaleFontSize'       => 11,
//String - Scale label font weight style
      'scaleFontStyle'      => "normal",
//String - Scale label font colour
      'scaleFontColor'      => "#666",
///Boolean - Whether grid lines are shown across the chart
      'scaleShowGridLines'  => true,
//String - Colour of the grid lines
      'scaleGridLineColor'  => "rgba(0,0,0,.05)",
//Number - Width of the grid lines
      'scaleGridLineWidth'  => 1,
//Boolean - Whether the line is curved between points
      'bezierCurve'         => true,
//Boolean - Whether to show a dot for each point
      'pointDot'            => true,
//Number - Radius of each point dot in pixels
      'pointDotRadius'      => 4,
//Number - Pixel width of point dot stroke
      'pointDotStrokeWidth' => 2,
//Boolean - Whether to show a stroke for datasets
      'datasetStroke'       => true,
//Number - Pixel width of dataset stroke
      'datasetStrokeWidth'  => 2,
//Boolean - Whether to fill the dataset with a colour
      'datasetFill'         => true,
//Boolean - Whether to animate the chart
      'animation'           => true,
//Number - Number of animation steps
      'animationSteps'      => 40,
//String - Animation easing effect
        // 'animationEasing'     => "easeOutQuart",
//Function - Fires when the animation is complete
      'onAnimationComplete' => null,
    ],
  ]
);