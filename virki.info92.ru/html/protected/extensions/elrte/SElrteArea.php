<?php

class SElrteArea extends CInputWidget
{
    static $initialized = false;

    /**
     * Initialize component
     */
    public function init()
    {
        if (self::$initialized === false) {
            self::$initialized = true;
            $assetsUrl = Yii::app()->getAssetManager()->publish(
              Yii::getPathOfAlias('ext.elrte.lib'),
              false,
              -1,
              YII_DEBUG
            );

            $cs = Yii::app()->clientScript;
            $build = (YII_DEBUG) ? 'full' : 'min';
            // Elrte
            $cs->registerCssFile($assetsUrl . '/elrte/css/elrte.' . $build . '.css');
            $cs->registerScriptFile($assetsUrl . '/elrte/js/elrte.' . $build . '.js');
            $basePath = Yii::getPathOfAlias('webroot') . $assetsUrl;
            if (file_exists($basePath . '/elfinder/js/i18n/elrte.' . Utils::appLang() . '.js')) {
                $cs->registerScriptFile($assetsUrl . '/elrte/js/i18n/elrte.' . Utils::transLang() . '.js');
            }
            // Elfinder
            $cs->registerCssFile($assetsUrl . '/elfinder/css/elfinder.' . $build . '.css');
            $cs->registerCssFile($assetsUrl . '/elfinder/css/theme.css');
            $cs->registerScriptFile($assetsUrl . '/elfinder/js/elfinder.' . $build . '.js');
            if (file_exists($basePath . '/elfinder/js/i18n/elfinder.' . Utils::appLang() . '.js')) {
                $cs->registerScriptFile($assetsUrl . '/elfinder/js/i18n/elfinder.' . Utils::appLang() . '.js');
            }
            $cs->registerScriptFile($assetsUrl . '/helper.js');
        }

        parent::init();
    }

    public function run($forceWYSIWYG = false, $id = false)
    {
        $theme = 'yii';
        $height = 'auto';
        $this->htmlOptions['height'] = 'auto';
        $this->htmlOptions['width'] = '100%';
        if (!$id) {
            if (isset($this->model->id)) {
                $this->htmlOptions['id'] = $this->attribute . $this->model->id;
            }
            [$name, $id] = $this->resolveNameID();
            $useRTF = false;
            $useTextField = false;
            if ($this->hasModel()) {
                $useRTF = strpos($this->model[$this->attribute], '?xml') <= 0;
                if (!$forceWYSIWYG) {
                    $useTextField = (mb_strlen($this->model[$this->attribute], 'UTF-8') <= 256);
                }
                if (!$useTextField) {
                    if (!$useRTF) {
                        $this->htmlOptions['cols'] = '140';
                        $this->htmlOptions['rows'] = '25';
                    }
                    echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
                } else {
                    echo CHtml::activeTextField($this->model, $this->attribute, $this->htmlOptions);
                }
            } else {
                $useRTF = strpos($this->value, '?xml') <= 0;
                $useTextField = (mb_strlen($this->value, 'UTF-8') <= 256);
                if (!$useRTF) {
                    $this->htmlOptions['cols'] = '140';
                    $this->htmlOptions['rows'] = '25';
                }
                if (!$useTextField) {
                    echo CHtml::textArea($name, $this->value, $this->htmlOptions);
                } else {
                    echo CHtml::textField($name, $this->value, $this->htmlOptions);
                }
            }
            if ($useRTF && (!$useTextField)) {
                Yii::app()->clientScript->registerScript(
                  __CLASS__ . $id,
                  "
	  try {
	  setupElrteEditor('{$id}', this, '{$theme}', '{$height}');
	  } catch (err) {
             console.log('ElRTE runtime recoverable error');
      }
	  ",
                  CClientScript::POS_READY
                );
            }
        } else {
// Собственно, оборачиваем уже существующий input или textarea в elrte
            Yii::app()->clientScript->registerScript(
              __CLASS__ . $id,
              /** @lang javaScript */ "
                  try {
	                setupElrteEditor('{$id}', this, '{$theme}', '{$height}');
	              } catch (err) {
                     console.log('ElRTE runtime recoverable error');
                     //console.log(err);
                  }
	              ",
              CClientScript::POS_READY
            );
        }
        echo '<div class="hint">' .
          Yii::t('admin', 'Перед сохранением активируйте вкладку "исходник (source)"') .
          '</div>';
    }

}
