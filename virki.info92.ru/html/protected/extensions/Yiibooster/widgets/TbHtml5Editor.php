<?php
/**
 *## TbHtml5Editor class file
 * @author    : antonio ramirez <antonio@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

/**
 *## TbHtml5Editor widget
 * Implements the bootstrap-wysihtml5 editor
 * @see     https://github.com/jhollingworth/bootstrap-wysihtml5
 * @package booster.widgets.forms.inputs.wysiwyg
 */
class TbHtml5Editor extends CInputWidget
{

    /**
     * Editor options that will be passed to the editor
     */
    public $editorOptions = [];
    /**
     * Editor height
     */
    public $height = '400px';
    /**
     * Html options that will be assigned to the text area
     */
    public $htmlOptions = [];
    /**
     * Editor language
     * Supports: de-DE, es-ES, fr-FR, pt-BR, sv-SE, it-IT
     */
    public $lang = 'en';
    /**
     * Editor width
     */
    public $width = '100%';

    private function insertDefaultStylesheetIfColorsEnabled()
    {
        if (empty($this->editorOptions['color'])) {
            return;
        }

        $defaultStyleSheetUrl = Booster::getBooster()->getAssetsUrl() . '/css/wysiwyg-color.css';
        array_unshift($this->editorOptions['stylesheets'], $defaultStyleSheetUrl); // we want default css to be first
    }

    private function normalizeStylesheetsProperty()
    {
        if (empty($this->editorOptions['stylesheets'])) {
            $this->editorOptions['stylesheets'] = [];
        } else {
            if (is_array($this->editorOptions['stylesheets'])) {
                $this->editorOptions['stylesheets'] = array_filter(
                  $this->editorOptions['stylesheets'],
                  'is_string'
                );
            } else {
                if (is_string($this->editorOptions['stylesheets'])) {
                    $this->editorOptions['stylesheets'] = [$this->editorOptions['stylesheets']];
                } else // presumably if this option is neither an array or string then it's some erroneous value; clean it
                {
                    $this->editorOptions['stylesheets'] = [];
                }
            }
        }
    }

    /**
     * Register required script files
     * @param string $id
     */
    public function registerClientScript($id)
    {

        $booster = Booster::getBooster();
        $booster->registerPackage('wysihtml5');
        //$booster->registerAssetCss('bootstrap-wysihtml5.css');
        //$booster->registerAssetJs('wysihtml5-0.3.0.js');
        //$booster->registerAssetJs('bootstrap-wysihtml5.js');

        if (isset($this->editorOptions['locale'])) {
            $booster->registerAssetJs(
              'locales/bootstrap-wysihtml5.' . $this->editorOptions['locale'] . '.js'
            );
        } elseif (in_array($this->lang, ['de-DE', 'es-ES', 'fr', 'fr-NL', 'pt-BR', 'sv-SE', 'it-IT'])) {
            $booster->registerAssetJs('locales/bootstrap-wysihtml5.' . $this->lang . '.js');
            $this->editorOptions['locale'] = $this->lang;
        }

        $this->normalizeStylesheetsProperty();
        $this->insertDefaultStylesheetIfColorsEnabled();

        $options = CJSON::encode($this->editorOptions);

        $script = [];
        /**
         * The default stylesheet option is incompatible with yii paths so it is reset here.
         * The insertDefaultStylesheetIfColorsEnabled includes the correct stylesheet if needed.
         * Any other changes to defaults should be made here.
         */
        $script[] = "$.fn.wysihtml5.defaultOptions.stylesheets = [];";

        /**
         * Check if we need a deep copy for the configuration.
         */
        if (isset($this->editorOptions['deepExtend']) && $this->editorOptions['deepExtend'] === true) {
            $script[] = "$('#{$id}').wysihtml5('deepExtend', {$options});";
        } else {
            $script[] = "$('#{$id}').wysihtml5({$options});";
        }

        Yii::app()->getClientScript()->registerScript(__CLASS__ . '#' . $id, implode("\n", $script));
    }

    /**
     * Display editor
     */
    public function run()
    {

        [$name, $id] = $this->resolveNameID();

        $this->registerClientScript($id);

        $this->htmlOptions['id'] = $id;

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
