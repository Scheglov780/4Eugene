<?php
/**
 * ## TbListView class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('zii.widgets.CListView');

/**
 * Bootstrap Zii list view.
 * @package booster.widgets.grouping
 */
class TbListView extends CListView
{

    /**
     * @var string the URL of the CSS file used by this detail view.
     * Defaults to false, meaning that no CSS will be included.
     */
    public $cssFile = false;
    /**
     * @var array the configuration for the pager.
     * Defaults to <code>array('class'=>'ext.booster.widgets.TbPager')</code>.
     */
    public $pager = ['class' => 'booster.widgets.TbPager'];
    /**
     * @var string the CSS class name for the pager container. Defaults to 'pagination'.
     */
    public $pagerCssClass = 'no-class';
    public $showEmptyPager = false;

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {

        parent::init();

        $booster = Booster::getBooster();
        $popover = $booster->popoverSelector;
        $tooltip = $booster->tooltipSelector;
        $scriptCode = '';
        if ($booster->enablePopover) {
            $scriptCode = "
            jQuery('#'+id+' .popover').remove();
			jQuery('#'+id+' {$popover}').popover();";
        }
        if ($booster->enableTooltip) {
            $scriptCode = $scriptCode . "
			jQuery('#'+id+' .tooltip').remove();
			jQuery('#'+id+' {$tooltip}').tooltip();";
        }
        if ($scriptCode) {
            $afterAjaxUpdate = "js:function(id,data) {
                {$scriptCode}
		}";

            if (!isset($this->afterAjaxUpdate)) {
                $this->afterAjaxUpdate = $afterAjaxUpdate;
            }
        }
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerClientScript()
    {
        $id = $this->getId();

        if ($this->ajaxUpdate === false) {
            $ajaxUpdate = [];
        } else {
            $ajaxUpdate = array_unique(preg_split('/\s*,\s*/', $this->ajaxUpdate . ',' . $id, -1, PREG_SPLIT_NO_EMPTY));
        }
        $options = [
          'ajaxUpdate'    => $ajaxUpdate,
          'ajaxVar'       => $this->ajaxVar,
          'pagerClass'    => $this->pagerCssClass,
          'loadingClass'  => $this->loadingCssClass,
          'sorterClass'   => $this->sorterCssClass,
          'enableHistory' => $this->enableHistory,
        ];
        if ($this->ajaxUrl !== null) {
            $options['url'] = CHtml::normalizeUrl($this->ajaxUrl);
        }
        if ($this->ajaxType !== null) {
            $options['ajaxType'] = strtoupper($this->ajaxType);
        }
        if ($this->updateSelector !== null) {
            $options['updateSelector'] = $this->updateSelector;
        }
        foreach (['beforeAjaxUpdate', 'afterAjaxUpdate', 'ajaxUpdateError'] as $event) {
            if ($this->$event !== null) {
                if ($this->$event instanceof CJavaScriptExpression) {
                    $options[$event] = $this->$event;
                } else {
                    $options[$event] = new CJavaScriptExpression($this->$event);
                }
            }
        }

        $options = CJavaScript::encode($options);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerCoreScript('bbq');
        if ($this->enableHistory) {
            $cs->registerCoreScript('history');
        }
        $assetsPath = Yii::getPathOfAlias('booster.assets');
        $assetsUrl = Yii::app()->assetManager->publish($assetsPath, true, -1, false);
        $cs->registerScriptFile(
          $assetsUrl . (YII_DEBUG ? '/js/jquery.dsyiilistview.js' : '/js/jquery.dsyiilistview.min.js'),
          CClientScript::POS_END
        );
        $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').yiiListView($options);");
    }

    /**
     * Renders the pager.
     */
    public function renderPager()
    {
        if (!$this->enablePagination) {
            return;
        }
        $pager = [];
        $class = 'CLinkPager';
        if (is_string($this->pager)) {
            $class = $this->pager;
        } elseif (is_array($this->pager)) {
            $pager = $this->pager;
            if (isset($pager['class'])) {
                $class = $pager['class'];
                unset($pager['class']);
            }
        }
        $pager['pages'] = $this->dataProvider->getPagination();

        if ($pager['pages']->getPageCount() > 1) {
            echo '<div' . ($this->pagerCssClass ? " class=\"{$this->pagerCssClass}\"" : ' class="no-class"') . '>';
            $this->widget($class, $pager);
            echo '</div>';
        } elseif ($this->showEmptyPager) {
            echo '<div' . ($this->pagerCssClass ? " class=\"{$this->pagerCssClass}\"" : ' class="no-class"') . '>';
            $pager['showEmptyPager'] = $this->showEmptyPager;
            $this->widget($class, $pager);
            echo '</div>';
        } else {
            $this->widget($class, $pager);
        }
    }

    /**
     * Renders the sorter.
     */
    public function renderSorter()
    {
        if ($this->dataProvider->getItemCount() <= 0 || !$this->enableSorting || empty($this->sortableAttributes)) {
            return;
        }
        echo CHtml::openTag('div', ['class' => $this->sorterCssClass]) . "\n";
        echo $this->sorterHeader === null ?
          '<span class="label label-default">' . Yii::t('zii', 'Sort by: ') . '</span>' : $this->sorterHeader;
        echo "<ul class=\"nav nav-pills\">\n";
        $sort = $this->dataProvider->getSort();
        foreach ($this->sortableAttributes as $name => $label) {
            echo "<li role=\"presentation\">";//class="active"
            if (is_integer($name)) {
                echo $sort->link($label);
            } else {
                echo $sort->link($name, $label);
            }
            echo "</li>\n";
        }
        echo "</ul>";
        echo $this->sorterFooter;
        echo CHtml::closeTag('div');
    }

    public function renderSummaryPager()
    {
        echo "<div class='row'>
                  <div class='col-md-7 summaryPager'>";
        $this->renderSummary();
        echo "</div>
                  <div class='col-md-5 summaryPager'>";
        $this->renderPager();
        echo "</div>
              </div>";
    }

}
