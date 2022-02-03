<?php // Initially empty TbSelect2 (data is null)
$this->widget(
  'bootstrap.widgets.TbSelect2',
  [
    'name' => 'emptydata',
    'data' => null,
    'options' => [
      'placeholder' => 'type clever, or is, or just type!',
      'width'       => '40%',
    ],
  ]
);

