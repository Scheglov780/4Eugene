<?php
/**
 * This is the configuration for generating message translations
 * for the Yii requirement checker. It is used by the 'yiic message' command.
 */
return [
  'sourcePath'  => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
  'messagePath' => dirname(__FILE__),
  'languages'   => [
    'zh_cn',
    'zh_tw',
    'de',
    'es',
    'el',
    'sv',
    'he',
    'nl',
    'pt',
    'ru',
    'it',
    'fr',
    'ja',
    'pl',
    'hu',
    'ro',
    'id',
    'vi',
    'bg',
    'uk',
    'cs',
  ],
  'fileTypes'   => ['php'],
  'overwrite'   => true,
  'translator'  => 't',
  'exclude'     => [
    '.gitignore',
    '/messages',
    '/views',
  ],
];
