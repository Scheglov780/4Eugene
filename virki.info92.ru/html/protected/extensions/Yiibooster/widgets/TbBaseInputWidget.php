<?php
/**
 *## TbBaseInputWidget class file.
 * @author    : amr bedair <amr@clevertech.biz>
 * @copyright Copyright &copy; Clevertech 2012-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

/**
 *## A Base class of all Input Widgets
 * @package booster.widgets.forms.inputs
 */
class TbBaseInputWidget extends CInputWidget
{

    protected function setDefaultPlaceholder()
    {

        if (!$this->model) {
            return;
        }

        if (!isset($this->htmlOptions['placeholder'])) {
            $this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
        }

    }

    public function init()
    {

        $this->setDefaultPlaceholder();

        if (!isset($this->htmlOptions['class']) || empty($this->htmlOptions['class'])) {
            $this->htmlOptions['class'] = 'ct-form-control';
        } else {
            $this->htmlOptions['class'] .= ' ct-form-control';
        }
    }
}