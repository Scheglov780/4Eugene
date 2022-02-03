<?php
/**
 *## TbGridView class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('zii.widgets.grid.CGridView');
Yii::import('booster.widgets.TbDataColumn');

/**
 *## Bootstrap Zii grid view.
 * @property CActiveDataProvider $dataProvider the data provider for the view.
 * @package booster.widgets.grids
 */
class TbGridView extends CGridView
{
    // Table types.
    const TYPE_BORDERED = 'bordered';
    const TYPE_CONDENSED = 'condensed';
    const TYPE_HOVER = 'hover';
    const TYPE_STRIPED = 'striped';
    private $fixedHeaderScript = '';
    /**
     * @var string the URL of the CSS file used by this grid view.
     * Defaults to false, meaning that no CSS will be included.
     */
    public $cssFile = false;
    /**
     * @var array of additional parameters to pass to values
     */
    public $extraParams = [];
    /**
     * @var bool $fixedHeader if set to true will keep the header fixed  position
     */
    public $fixedHeader = false;
    /**
     * @var integer $headerOffset , when $fixedHeader is set to true, headerOffset will position table header top
     *      position at $headerOffset. If you are using bootstrap and has navigation top fixed, its height is 40px, so
     *      it is recommended to use $headerOffset=40;
     */
    public $headerOffset = 0;
    /**
     * @var array the configuration for the pager.
     * Defaults to <code>array('class'=>'ext.booster.widgets.TbPager')</code>.
     */
    public $pager = ['class' => 'booster.widgets.TbPager'];
    /**
     * @var string the CSS class name for the pager container. Defaults to 'pagination'.
     */
    public $pagerCssClass = 'no-class';
    /**
     * @var bool whether to make the grid responsive
     */
    public $responsiveTable = false;
    public $scrollableArea = '';
    public $showEmptyPager = false;
    /**
     * @var string|array the table type.
     * Valid values are 'striped', 'bordered', 'condensed' and/or 'hover'.
     */
    public $type;

    /**
     *### .createDataColumn()
     * Creates a column based on a shortcut column specification string.
     * @param mixed $text the column specification string
     * @return \TbDataColumn|\CDataColumn the column instance
     * @throws CException if the column format is incorrect
     */
    protected function createDataColumn($text)
    {
        if (!preg_match('/^([\w\.]+)(:(\w*))?(:(.*))?$/', $text, $matches)) {
            throw new CException(
              Yii::t(
                'zii',
                'The column must be specified in the format of "Name:Type:Label", where "Type" and "Label" are optional.'
              )
            );
        }

        $column = new TbDataColumn($this);
        $column->name = $matches[1];

        if (isset($matches[3]) && $matches[3] !== '') {
            $column->type = $matches[3];
        }

        if (isset($matches[5])) {
            $column->header = $matches[5];
        }

        return $column;
    }

    /**
     *### .initColumns()
     * Creates column objects and initializes them.
     */
    protected function initColumns()
    {
        foreach ($this->columns as $i => $column) {
            if (is_array($column) && !isset($column['class'])) {
                $this->columns[$i]['class'] = 'booster.widgets.TbDataColumn';
            }
        }

        parent::initColumns();

        if ($this->responsiveTable) {
            $this->writeResponsiveCss();
        }
    }

    /**
     *### .writeResponsiveCss()
     * Writes responsiveCSS
     */
    protected function writeResponsiveCss()
    {
        $cnt = 1;
        $labels = '';
        foreach ($this->columns as $column) {
            /** @var TbDataColumn $column */
            ob_start();
            $column->renderHeaderCell();
            $name = html_entity_decode(strip_tags(ob_get_clean()));

            $labels .= "#$this->id td:nth-of-type($cnt):before { 
			content: '{$name}'; 
			}\n";
            $cnt++;
        }

        $css = <<<EOD
@media
	only screen and (max-width: 760px),
	(min-device-width: 768px) and (max-device-width: 1024px)  {

		/* Force table to not be like tables anymore */
		#{$this->id} table,#{$this->id} thead,#{$this->id} tbody,#{$this->id} th,#{$this->id} td,#{$this->id} tr {
			display: block;
			word-wrap: anywhere;
		}

		/* Hide table headers (but not display: none;, for accessibility) */
		#{$this->id} thead tr {
			position: absolute;
			top: -9999px;
			left: -9999px;
		}

		#{$this->id} tr { 
		border: 1px solid #ccc; 
		font: normal 1em 'Roboto Condensed','Arial';
		/* font-family: 'Source Sans Pro',Helvetica,Arial,sans-serif; */
		}

		#{$this->id} td {
			/* Behave  like a "row" */
			border: none;
			border-bottom: 1px solid #eee;
			position: relative;
			padding-left: 50%;
			font: normal 1em 'Roboto Condensed','Arial';
		/* font-family: 'Source Sans Pro',Helvetica,Arial,sans-serif; */
		line-height: 1;
		/* font-size: 0.6em; */					
		}

		#{$this->id} td:before {
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
			top: 6px;
			left: 6px;
			width: 45%;
			padding-right: 10px;
			white-space: nowrap;
            font: normal 1em 'Roboto Condensed','Arial';			
		/* font-family: 'Source Sans Pro',Helvetica,Arial,sans-serif; */
		line-height: 1;
		/* font-size: 1.7em; */					
		}

		#{$this->id} tr:after {
			/* Now like a table header */
			position: absolute;
			/* Top/left values mimic padding */
            font: normal 1em 'Roboto Condensed','Arial';			
		/* font-family: 'Source Sans Pro',Helvetica,Arial,sans-serif; */
		line-height: 1;
		/* font-size: 1.7em; */					
		}
				
		.grid-view .button-column {
			text-align: left;
			width:auto;
		}
		/*
		Label the data
		*/
		{$labels}
	}
EOD;
        Yii::app()->clientScript->registerCss(__CLASS__ . '#' . $this->id, $css);
    }

    /**
     *### .init()
     * Initializes the widget.
     */
    public function init()
    {
        $this->summaryText = Yii::t('main', 'Записи') . ' {start}-{end} ' . Yii::t('main', 'из') . ' {count}';
        parent::init();
        $classes = ['table']; //,'dataTable'
        if (isset($this->type)) {
            if (is_string($this->type)) {
                $this->type = explode(' ', $this->type);
            }

            if (!empty($this->type)) {
                $validTypes = [self::TYPE_STRIPED, self::TYPE_BORDERED, self::TYPE_CONDENSED, self::TYPE_HOVER];

                foreach ($this->type as $type) {
                    if (in_array($type, $validTypes)) {
                        $classes[] = 'table-' . $type;
                    }
                }
            }
        }

        if (!empty($classes)) {
            $classes = implode(' ', $classes);
            if (isset($this->itemsCssClass)) {
                $this->itemsCssClass .= ' ' . $classes;
            } else {
                $this->itemsCssClass = $classes;
            }
        }

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

    public function registerClientScript()
    {
        $this->registerCustomClientScript();

        $id = $this->getId();

        if ($this->ajaxUpdate === false) {
            $ajaxUpdate = false;
        } else {
            $ajaxUpdate = array_unique(preg_split('/\s*,\s*/', $this->ajaxUpdate . ',' . $id, -1, PREG_SPLIT_NO_EMPTY));
        }
        $options = [
          'ajaxUpdate'     => $ajaxUpdate,
          'ajaxVar'        => $this->ajaxVar,
          'pagerClass'     => $this->pagerCssClass,
          'loadingClass'   => $this->loadingCssClass,
          'filterClass'    => $this->filterCssClass,
          'tableClass'     => $this->itemsCssClass,
          'selectableRows' => $this->selectableRows,
          'enableHistory'  => $this->enableHistory,
          'updateSelector' => $this->updateSelector,
          'filterSelector' => $this->filterSelector,
        ];
        if ($this->ajaxUrl !== null) {
            $options['url'] = CHtml::normalizeUrl($this->ajaxUrl);
        }
        if ($this->ajaxType !== null) {
            $options['ajaxType'] = strtoupper($this->ajaxType);
        }
        if ($this->enablePagination) {
            $options['pageVar'] = $this->dataProvider->getPagination()->pageVar;
        }
        foreach (['beforeAjaxUpdate', 'afterAjaxUpdate', 'ajaxUpdateError', 'selectionChanged'] as $event) {
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
          $assetsUrl . (YII_DEBUG ? '/js/jquery.dsyiigridview.js' : '/js/jquery.dsyiigridview.min.js'),
          CClientScript::POS_END
        );
        $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').yiiGridView($options);");
    }

    /**
     *### .registerCustomClientScript()
     * This script must be run at the end of content rendering not at the beginning as it is common with normal
     * CGridViews
     */
    public function registerCustomClientScript()
    {
        /** @var $cs CClientScript */
        $cs = Yii::app()->getClientScript();
        $assetsPath = Yii::getPathOfAlias('booster.assets');
        $assetsUrl = Yii::app()->assetManager->publish($assetsPath, true, -1, false);
        $cs->registerScriptFile(
          $assetsUrl . '/js/' . 'jquery.stickytableheaders' . (!YII_DEBUG ? '.min' : '') . '.js',
          CClientScript::POS_END
        );
        if ($this->fixedHeader) {
            $scrollableJs = '';
            if ($this->scrollableArea) {
                $scrollableJs = ",scrollableArea: $('{$this->scrollableArea}')";
            }
            $this->fixedHeaderScript =
              "$('#{$this->id} table.items').stickyTableHeaders({cacheHeaderHeight: true,fixedOffset:{$this->headerOffset}{$scrollableJs}});";
            if ($this->afterAjaxUpdate) {
                $this->afterAjaxUpdate =
                  preg_replace(
                    '/\{(.*)\}/is',
                    "{\\1;{$this->fixedHeaderScript}}",
                    $this->afterAjaxUpdate
                  ); //"function(id,data){{$this->fixedHeaderScript}}";
            } else {
                $this->afterAjaxUpdate = "function(id,data){{$this->fixedHeaderScript}}";
            }
        }
        $cs->registerScript(__CLASS__ . '#' . $this->id . 'Ex', $this->fixedHeaderScript, CClientScript::POS_END);
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

        if ($pager['pages']->getPageCount() > 1 || $this->showEmptyPager) {
            echo '<div class="' . $this->pagerCssClass . '">';
            $this->widget($class, $pager);
            echo '</div>';
        } else {
            $this->widget($class, $pager);
        }
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
