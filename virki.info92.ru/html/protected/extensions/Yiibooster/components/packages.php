<?php
/**
 * Built-in client script packages.
 * Please see {@link CClientScript::packages} for explanation of the structure
 * of the returned array.
 * @author Ruslan Fadeev <fadeevr@gmail.com>
 * @var Bootstrap $this
 */
return [
  'font-awesome'         => [
    'baseUrl' => $this->enableCdn ? '//netdna.bootstrapcdn.com/font-awesome/4.7.0/' :
      $this->getAssetsUrl() . '/font-awesome/',
    'css'     => [($this->minify || $this->enableCdn) ? 'css/font-awesome.min.css' : 'css/font-awesome.css'],
  ],
  'bootstrap.js'         => [
    'baseUrl' => $this->enableCdn ? '//netdna.bootstrapcdn.com/bootstrap/3.4.1/' :
      $this->getAssetsUrl() . '/bootstrap/',
    'js'      => [$this->minify ? 'js/bootstrap.min.js' : 'js/bootstrap.js'],
    'depends' => ['jquery'],
  ],
  'bootstrap-yii'        => [
    'baseUrl' => $this->getAssetsUrl(),
    'css'     => ['css/bootstrap-yii.css'],
  ],
  'jquery-css'           => [
    'baseUrl' => $this->getAssetsUrl(),
    'css'     => ['css/jquery-ui-bootstrap.css'],
  ],
  'bootbox'              => [
    'baseUrl' => $this->getAssetsUrl() . '/bootbox/',
    'js'      => [$this->minify ? 'bootbox.min.js' : 'bootbox.js'],
  ],
  'notify'               => [
    'baseUrl' => $this->getAssetsUrl() . '/notify/',
    'js'      => [$this->minify ? 'notify.min.js' : 'notify.js'],
  ],
  'bootstrap-noconflict' => [
    'baseUrl' => $this->getAssetsUrl(),
    'js'      => ['js/bootstrap-noconflict.js'],
    'depends' => ['jquery'],
  ],

    //widgets start
  'ui-layout'            => [
    'baseUrl' => $this->getAssetsUrl() . '/ui-layout/',
    'css'     => ['css/layout-default.css'],
    'js'      => [$this->minify ? 'js/jquery.layout.min.js' : 'js/jquery.layout.js'],
    'depends' => ['jquery', 'jquery.ui'],
  ],
  'datepicker'           => [
    'depends' => ['jquery'],
    'baseUrl' => $this->enableCdn ? '//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.2.0/' :
      $this->getAssetsUrl() . '/bootstrap-datepicker/',
    'css'     => ['css/datepicker3.css'],
      // $this->minify ? 'css/datepicker.min.css' : 'css/datepicker.css'),
    'js'      => [
      $this->minify ? 'js/bootstrap-datepicker.min.js' : 'js/bootstrap-datepicker.js',
      'js/bootstrap-datepicker-noconflict.js',
    ]
      // ... the noconflict code is in its own file so we do not want to touch the original js files to ease upgrading lib
  ],
  'datetimepicker'       => [
    'depends' => ['jquery'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-datetimepicker/', // Not in CDN yet
    'css'     => [$this->minify ? 'css/bootstrap-datetimepicker.css' : 'css/bootstrap-datetimepicker.css'],
    'js'      => [$this->minify ? 'js/bootstrap-datetimepicker.min.js' : 'js/bootstrap-datetimepicker.js'],
  ],
  'date'                 => [
    'baseUrl' => $this->enableCdn ? '//cdnjs.cloudflare.com/ajax/libs/datejs/1.0/' : $this->getAssetsUrl() . '/js/',
    'js'      => ['date.min.js'],
  ],
  'colorpicker'          => [
    'depends' => ['jquery'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-colorpicker/',
    'css'     => [$this->minify ? 'css/bootstrap-colorpicker.min.css' : 'css/bootstrap-colorpicker.css'],
    'js'      => [$this->minify ? 'js/bootstrap-colorpicker.min.js' : 'js/bootstrap-colorpicker.js'],
  ],
  'x-editable'           => [
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-editable/',
    'css'     => ['css/bootstrap-editable.css'],
    'js'      => [$this->minify ? 'js/bootstrap-editable.min.js' : 'js/bootstrap-editable.js'],
    'depends' => ['jquery', 'bootstrap.js', 'datepicker']
      /* this is to ensure that datepicker always come before editable */
  ],
  'moment'               => [
    'baseUrl' => $this->getAssetsUrl(),
    'js'      => ['js/moment.min.js'],
  ],
  'picker'               => [
    'baseUrl' => $this->getAssetsUrl() . '/picker',
    'js'      => ['bootstrap.picker.js'],
    'css'     => ['bootstrap.picker.css'],
    'depends' => ['bootstrap.js'],
  ],
  'bootstrap.wizard'     => [
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-wizard',
    'js'      => [$this->minify ? 'jquery.bootstrap.wizard.min.js' : 'jquery.bootstrap.wizard.js'],
  ],
  'ajax-cache'           => [
    'baseUrl' => $this->getAssetsUrl() . '/ajax-cache',
    'js'      => ['jquery.ajax.cache.js'],
  ],
  'jqote2'               => [
    'baseUrl' => $this->getAssetsUrl() . '/jqote2',
    'js'      => ['jquery.jqote2.min.js'],
  ],
  'json-grid-view'       => [
    'baseUrl' => $this->getAssetsUrl() . '/json-grid-view',
    'js'      => ['jquery.json.yiigridview.js'],
    'depends' => ['jquery', 'jqote2', 'ajax-cache'],
  ],
  'group-grid-view'      => [
    'baseUrl' => $this->getAssetsUrl() . '/group-grid-view',
    'js'      => ['jquery.group.yiigridview.js'],
    'depends' => ['jquery', 'jqote2', 'ajax-cache'],
  ],
  'redactor'             => [
    'baseUrl' => $this->getAssetsUrl() . '/redactor',
    'js'      => [$this->minify ? 'redactor.min.js' : 'redactor.js'],
    'css'     => ['redactor.css'],
    'depends' => ['jquery'],
  ],
  'passfield'            => [
    'depends' => ['jquery'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-passfield', // Not in CDN yet
    'css'     => [$this->minify ? 'css/passfield.min.css' : 'css/passfield.min.css'],
    'js'      => [$this->minify ? 'js/passfield.min.js' : 'js/passfield.min.js'],
  ],
  'timepicker'           => [
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-timepicker',
    'js'      => ['js/bootstrap-timepicker.js'],
    'css'     => [$this->minify ? 'css/bootstrap-timepicker.min.css' : 'css/bootstrap-timepicker.css'],
    'depends' => ['bootstrap.js'],
  ],
  'ckeditor'             => [
    'baseUrl' => $this->getAssetsUrl() . '/ckeditor',
    'js'      => ['ckeditor.js'],
  ],
  'highcharts'           => [
    'baseUrl' => $this->enableCdn ? '//code.highcharts.com' : $this->getAssetsUrl() . '/highcharts',
    'js'      => [$this->minify ? 'highcharts.js' : 'highcharts.src.js'],
  ],
  'wysihtml5'            => [
    'depends' => ['bootstrap.js'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap3-wysihtml5',
    'css'     => ['bootstrap-wysihtml5.css'],
    'js'      => ['wysihtml5-0.3.0.js', 'bootstrap3-wysihtml5.js'],
  ],
  'markdown'             => [
    'depends' => ['bootstrap.js'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-markdown',
    'css'     => ['css/bootstrap-markdown.min.css'],
    'js'      => ['js/bootstrap-markdown.js'],
  ],
  'switch'               => [
    'depends' => ['bootstrap.js'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-switch',
    'css'     => [$this->minify ? 'css/bootstrap3/bootstrap-switch.min.css' : 'css/bootstrap3/bootstrap-switch.css'],
    'js'      => [$this->minify ? 'js/bootstrap-switch.min.js' : 'js/bootstrap-switch.js'],
  ],
  'typeahead'            => [
    'depends' => ['jquery'],
    'baseUrl' => $this->getAssetsUrl() . '/typeahead',
    'css'     => ['css/typeahead.css'],
    'js'      => [$this->minify ? 'js/typeahead.bundle.min.js' : 'js/typeahead.bundle.js'],
  ],
  'bootstrap-tags'       => [
    'depends' => ['jquery'],
    'baseUrl' => $this->getAssetsUrl() . '/bootstrap-tags',
    'css'     => ['css/bootstrap-tags.css'],
    'js'      => [$this->minify ? 'js/bootstrap-tags.min.js' : 'js/bootstrap-tags.js'],
  ],
];
