<?php
/**
 *## TbMarkdownEditorJs class file
 * @author    : antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 *## Class TbMarkdownEditorJS
 * @see        <https://code.google.com/p/pagedown/wiki/PageDown>
 * @see        <https://github.com/arhpreston/jquery-markdown>
 * @package    booster.widgets.forms.inputs.wysiwyg
 * @deprecated replaced with TbMarkdownEditor
 */
class TbMarkdownEditorJS extends CInputWidget
{
    /**
     * Editor height
     */
    public $height = '400px';
    /**
     * Editor width
     */
    public $width = '100%';

    /**
     * Register required script files
     * @param integer $id
     */
    public function registerClientScript($id)
    {
        $booster = Booster::getBooster();
        $booster->registerAssetCss('markdown.editor.css');
        $booster->registerAssetJs('markdown.converter.js', CClientScript::POS_HEAD);
        $booster->registerAssetJs('markdown.sanitizer.js', CClientScript::POS_HEAD);
        $booster->registerAssetJs('markdown.editor.js', CClientScript::POS_HEAD);
        Yii::app()->clientScript->registerScript(
          $id,
          "var converter = Markdown.getSanitizingConverter();
			var editor = new Markdown.Editor(converter, '" . $id . "');
			editor.run();",
          CClientScript::POS_END
        );
    }

    /**
     * Display editor
     */
    public function run()
    {

        [$name, $id] = $this->resolveNameID();

        $this->registerClientScript($id);

        // Markdown Editor looks for an id of wmd-input...
        $this->htmlOptions['id'] = $id;

        $this->htmlOptions['class'] = (isset($this->htmlOptions['class']))
          ? $this->htmlOptions['class'] . ' wmd-input'
          : 'wmd-input';

        if (!array_key_exists('style', $this->htmlOptions)) {
            $this->htmlOptions['style'] = "width:{$this->width};height:{$this->height};";
        }
        // Do we have a model?
        if ($this->hasModel()) {
            echo CHtml::activeTextArea($this->model, $this->attribute, $this->htmlOptions);
        } else {
            echo CHtml::textArea($name, $this->value, $this->htmlOptions);
        }
    }
}
