<?php
/**
 *##  TbBreadcrumbs class file.
 * @license [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('zii.widgets.CBreadcrumbs');

/**
 * Bootstrap breadcrumb widget.
 * @see     http://twitter.github.io/bootstrap/components.html#breadcrumbs
 * @package booster.widgets.navigation
 */
class TbBreadcrumbs extends CBreadcrumbs
{

    /**
     * The HTML attributes for the breadcrumbs container tag.
     * @var array
     */
    public $htmlOptions = ['class' => 'breadcrumb'];
    /**
     * String, specifies how each inactive item is rendered. Defaults to
     * "{label}", where "{label}" will be replaced by the corresponding item label.
     * Note that inactive template does not have "{url}" parameter.
     * @var string
     */
    public $inactiveLinkTemplate = '{label}';
    /**
     * @var string the separator between links in the breadcrumbs. Defaults to '/'.
     */
    public $separator = '/';
    /**
     * The tag name for the breadcrumbs container tag. Defaults to 'ul'.
     * @var string
     */
    public $tagName = 'ul';

    /**
     *### .run()
     * Renders the content of the widget.
     */
    public function run()
    {
        $result = '';
        if (empty($this->links)) {
            return;
        }

        $result = $result . CHtml::openTag($this->tagName, $this->htmlOptions);

        if ($this->homeLink === null) {
            $this->homeLink = CHtml::link(Yii::t('zii', 'Home'), Yii::app()->homeUrl);
        }
        if ($this->homeLink !== false) {
            // check whether home link is not a link
            $active = (stripos($this->homeLink, '<a') === false) ? ' class="active"' : '';
            $result = $result . '<li' . $active . '>' . $this->homeLink . '</li>';
        }

        end($this->links);
        $lastLink = key($this->links);

        foreach ($this->links as $label => $url) {
            if (is_string($label) || is_array($url)) {
                $result = $result . '<li>';
                $result = $result . strtr($this->activeLinkTemplate, [
                    '{url}'   => CHtml::normalizeUrl($url),
                    '{label}' => $this->separator . ($this->encodeLabel ? CHtml::encode($label) : $label),
                  ]);
            } else {
                $result = $result . '<li class="active">';
                $result =
                  $result .
                  str_replace(
                    '{label}',
                    $this->separator . ($this->encodeLabel ? CHtml::encode($url) : $url),
                    $this->inactiveLinkTemplate
                  );
            }

            $result = $result . '</li>';
        }

        $result = $result . CHtml::closeTag($this->tagName);
        echo $result;
    }
}
