<?php // Basic usage of Select2 widget
$this->widget(
  'bootstrap.widgets.TbSelect2',
  [
    'asDropDownList' => false,
    'name'           => 'clevertech',
    'options'        => [
      'tags'            => ['clever', 'is', 'better', 'clevertech'],
      'placeholder'     => 'type clever, or is, or just type!',
      'width'           => '40%',
      'tokenSeparators' => [',', ' '],
    ],
  ]
);


