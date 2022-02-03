<?php

/**
 * KRichTextEditor generates a rich text editor interface using tiny mce.
 * An example usage would be:
 *    Yii::import('ext.krichtexteditor.KRichTextEditor');
 *    $this->widget('KRichTextEditor', array(
 *        'model' => $model,
 *        'value' => $model->isNewRecord ? $model->content : '',
 *        'attribute' => 'content',
 *        'options' => array(
 *            'theme_advanced_resizing' => 'true',
 *            'theme_advanced_statusbar_location' => 'bottom',
 *        ),
 *    ));
 * Assigning options would overwrite the default options that will be
 * passed to tiny mce jquery plugin.
 * The default options are:
 * public $defaultOptions = array(
 *    'theme' => 'advanced',
 *    'theme_advanced_toolbar_location' => 'top',
 *    'theme_advanced_toolbar_align' => 'left',
 *    'theme_advanced_buttons1' => "bold,italic,underline,strikethrough,|,fontselect,fontsizeselect",
 *    'theme_advanced_buttons2' =>
 *    "bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,backcolor",
 *    'theme_advanced_buttons3' => '',
 * );
 * (see {@link http://www.tinymce.com/tryit/jquery_plugin.php}).
 * @author    KahWee Teng <t@kw.sg>
 * @version   1.0
 * @link      http://kw.sg/
 * @copyright Copyright &copy; 2011 KahWee Teng
 * @license   http://www.opensource.org/licenses/mit-license.php
 */
class KRichTextEditor extends CInputWidget
{

    /**
     * @var array default options to be passed to tiny mce
     * @link http://www.tinymce.com/tryit/jquery_plugin.php
     */
    public $defaultOptions = [
      'theme'              => 'modern',
      'language'           => 'ru',
      'plugins'            => 'autolink, link, anchor, code, hr, image, table, textcolor, moxiemanager, fullscreen, colorpicker ',
      'height'             => 300,
      'table_grid'         => true,
      'tools'              => 'inserttable',
      'relative_urls'      => false,
      'allow_script_urls'  => true,
      'remove_script_host' => false,
      'document_base_url'  => 'http://smartex24.ru/images/tiny/',
      'image_advtab'       => true,
      'image_description'  => true,
      'image_dimensions'   => true,
      'target_list'        => [
        ['title' => 'Same page', 'value' => '_self'],
        ['title' => 'New page', 'value' => '_blank'],
      ],

      'toolbar1' => 'undo, redo, |, removeformat, bold, italic, underline, strikethrough, subscript, superscript, |, forecolor, backcolor, |, alignleft, aligncenter, alignright, alignjustify, |, fontsizeselect, |, bullist, numlist, outdent, indent, blockquote ',
      'toolbar2' => 'anchor, link, unlink, hr, |, image, |, code, fullscreen',
    ];
    /**
     * @var array options to be passed to tiny mce
     * @link http://www.tinymce.com/tryit/jquery_plugin.php
     */
    public $options;

    /**
     * Registers the needed CSS and JavaScript.
     */
    public function registerClientScript()
    {
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $asset_url =
          Yii::app()->assetManager->publish(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'tiny_mce', false, -1, true);

        $cs->registerScriptFile("$asset_url/jquery.tinymce.min.js", CClientScript::POS_END); //POS_END);

        $id = $this->htmlOptions['id'];
        $this->options = CMap::mergeArray($this->defaultOptions, $this->options);
        $this->options['script_url'] = "$asset_url/tinymce.min.js";
        $options = $this->options !== [] ? CJavaScript::encode($this->options) : '';

        $js = "jQuery(\"#{$id}\").tinymce({$options});";
        $cs->registerScript('KahWee.KRichTextEditor#' . $id, $js);
    }

    /**
     * Executes the widget.
     * This method registers all needed client scripts and renders
     * the text area.
     */
    public function run()
    {
        [$name, $id] = $this->resolveNameID();
        if (isset($this->htmlOptions['id'])) {
            $id = $this->htmlOptions['id'];
        } else {
            $this->htmlOptions['id'] = $id;
        }
        if (isset($this->htmlOptions['name'])) {
            $name = $this->htmlOptions['name'];
        }

        $this->registerClientScript();
        if ($this->hasModel()) {
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
        }
    }

}
