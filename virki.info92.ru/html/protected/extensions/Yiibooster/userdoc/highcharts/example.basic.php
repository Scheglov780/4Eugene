<?php // Basic usage of TbHighCharts
$this->widget(
  'booster.widgets.TbHighCharts',
  [
    'options' => [
      'series' => [
        [
          'data' => [1, 2, 3, 4, 5, 1, 2, 1, 4, 3, 1, 5],
        ],
      ],
    ],
  ]
);
