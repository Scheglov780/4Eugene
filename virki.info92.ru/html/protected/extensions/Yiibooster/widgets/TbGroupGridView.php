<?php
/**
 *## TbGroupGridView class file
 * @author         Vitaliy Potapov <noginsk@rambler.ru>
 * @version        1.1
 * @see            http://groupgridview.demopage.ru/
 * @since          24/09/2012 added to yiibooster library
 * @author         antonio ramirez <antonio@clevertech.biz>
 */

Yii::import('booster.widgets.TbGridView');

/**
 *## TbGroupGridView widget
 * A Grid View that groups rows by any column(s)
 * @property TbDataColumn[] $columns
 * @package booster.widgets.grids
 */
class TbGroupGridView extends TbGridView
{

    const MERGE_FIRSTROW = 'firstrow';
    const MERGE_NESTED = 'nested';
    const MERGE_SIMPLE = 'simple';
    /**
     * @var array the column data changes
     */
    private $_changes;
    /**
     * @var array $extraRowColumns the group column names
     */
    public $extraRowColumns = [];
    /**
     * @var string $extraRowCssClass the class to be used to be set on the extrarow cell tag.
     */
    public $extraRowCssClass = 'extrarow';
    /**
     * @var string $extraRowExpression
     */
    public $extraRowExpression;
    /**
     * @var array the HTML options for the extrarow cell tag.
     */
    public $extraRowHtmlOptions = [];
    /**
     * @var string $mergeCellsCss the styles to apply to merged cells
     */
    public $mergeCellCss = 'text-align: center; vertical-align: middle';
    /**
     * @var array $mergeColumns the columns to merge on the grid
     */
    public $mergeColumns = [];
    /**
     * @var string $mergeType the merge type. Defaults to MERGE_SIMPLE
     */
    public $mergeType = self::MERGE_SIMPLE;

    /**
     * need to rewrite this function as it is protected in CDataColumn: it is strange as all methods inside are public
     * @param TbDataColumn $column
     * @param mixed        $row
     * @param mixed        $data
     * @return string
     */
    private function getDataCellContent($column, $data, $row)
    {
        if ($column->value !== null) {
            $value = $column->evaluateExpression($column->value, ['data' => $data, 'row' => $row]);
        } else {
            if ($column->name !== null) {
                $value = CHtml::value($data, $column->name);
            }
        }

        return !isset($value)
          ? $column->grid->nullDisplay
          : $column->grid->getFormatter()->format(
            $value,
            $column->type
          );
    }

    /**
     * returns array of rendered column values (TD)
     * @param string[]|TbDataColumn[] $columns
     * @param CActiveRecord           $data
     * @param mixed                   $rowIndex
     * @return mixed
     * @throws CException
     */
    private function getRowValues($columns, $data, $rowIndex)
    {
        foreach ($columns as $column) {
            if ($column instanceof TbDataColumn) {
                $result[$column->name] = $this->getDataCellContent($column, $data, $rowIndex);
            } elseif (is_string($column)) {
                if (is_array($data) && array_key_exists($column, $data)) {
                    $result[$column] = $data[$column];
                } elseif ($data instanceof CActiveRecord && $data->hasAttribute($column)) {
                    $result[$column] = $data->getAttribute($column);
                } else {
                    throw new CException('Column or attribute "' . $column . '" not found!');
                }
            }
        }
        return isset($result) ? $result : false;
    }

    /**
     * renders extra row
     * @param mixed $beforeRow
     * @param mixed $change
     * @param array $columnsInExtra
     */
    private function renderExtraRow($beforeRow, $change, $columnsInExtra)
    {
        $data = $this->dataProvider->data[$beforeRow];
        if ($this->extraRowExpression) { //user defined expression, use it!
            $content = $this->evaluateExpression(
              $this->extraRowExpression,
              ['data' => $data, 'row' => $beforeRow, 'values' => $change['columns']]
            );
        } else { //generate value
            $values = [];
            foreach ($columnsInExtra as $c) {
                $values[] = $change['columns'][$c]['value'];
            }

            $content = '<strong>' . implode(' :: ', $values) . '</strong>';
        }

        $colspan = count($this->columns);

        echo '<tr class="extrarow">';
        $this->extraRowHtmlOptions['colspan'] = $colspan;
        echo CHtml::openTag('td', $this->extraRowHtmlOptions);
        echo $content;
        echo CHtml::closeTag('td');
        echo '</tr>';
    }

    /**
     * find and store changing of group columns
     */
    public function groupByColumns()
    {
        $data = $this->dataProvider->getData();
        if (count($data) == 0) {
            return;
        }

        if (!is_array($this->mergeColumns)) {
            $this->mergeColumns = [$this->mergeColumns];
        }
        if (!is_array($this->extraRowColumns)) {
            $this->extraRowColumns = [$this->extraRowColumns];
        }

        //store columns for group. Set object for existing columns in grid and string for attributes
        $groupColumns = array_unique(array_merge($this->mergeColumns, $this->extraRowColumns));
        foreach ($groupColumns as $key => $colName) {
            foreach ($this->columns as $column) {
                if (property_exists($column, 'name') && $column->name == $colName) {
                    $groupColumns[$key] = $column;
                    break;
                }
            }
        }

        //values for first row
        $lastStored = $this->getRowValues($groupColumns, $data[0], 0);
        foreach ($lastStored as $colName => $value) {
            $lastStored[$colName] = [
              'value' => $value,
              'count' => 1,
              'index' => 0,
            ];
        }

        //iterate data
        $rowcount = count($data);
        for ($i = 1; $i < $rowcount; $i++) {
            //save row values in array
            $current = $this->getRowValues($groupColumns, $data[$i], $i);

            //define is change occured. Need this extra foreach for correctly proceed extraRows
            $changedColumns = [];
            foreach ($current as $colName => $curValue) {
                if ($curValue != $lastStored[$colName]['value']) {
                    $changedColumns[] = $colName;
                }
            }

            /**
             * if this flag = true -> we will write change (to $this->_changes) for all grouping columns.
             * It's required when change of any column from extraRowColumns occurs
             */
            $saveChangeForAllColumns = (count(array_intersect($changedColumns, $this->extraRowColumns)) > 0);

            /**
             * this changeOccurred related to foreach below. It is required only for mergeType == self::MERGE_NESTED,
             * to write change for all nested columns when change of previous column occurred
             */
            $changeOccurred = false;
            foreach ($current as $colName => $curValue) {
                //value changed
                $valueChanged = ($curValue != $lastStored[$colName]['value']);
                //change already occured in this loop and mergeType set to MERGETYPE_NESTED
                $saveChange = $valueChanged || ($changeOccurred && $this->mergeType == self::MERGE_NESTED);

                if ($saveChangeForAllColumns || $saveChange) {
                    $changeOccurred = true;

                    //store in class var
                    $prevIndex = $lastStored[$colName]['index'];
                    $this->_changes[$prevIndex]['columns'][$colName] = $lastStored[$colName];
                    if (!isset($this->_changes[$prevIndex]['count'])) {
                        $this->_changes[$prevIndex]['count'] = $lastStored[$colName]['count'];
                    }

                    //update lastStored for particular column
                    $lastStored[$colName] = [
                      'value' => $curValue,
                      'count' => 1,
                      'index' => $i,
                    ];

                } else {
                    $lastStored[$colName]['count']++;
                }
            }
        }

        //storing for last row
        foreach ($lastStored as $colName => $v) {
            $prevIndex = $v['index'];
            $this->_changes[$prevIndex]['columns'][$colName] = $v;

            if (!isset($this->_changes[$prevIndex]['count'])) {
                $this->_changes[$prevIndex]['count'] = $v['count'];
            }
        }
    }

    /**
     * Widget initialization
     */
    public function init()
    {
        parent::init();

        /**
         * check whether we have extraRowColumns set, forbid filters
         */
        if (!empty($this->extraRowColumns)) {
            foreach ($this->columns as $column) {
                if ($column instanceof CDataColumn && in_array($column->name, $this->extraRowColumns)) {
                    $column->filterHtmlOptions = ['style' => 'display:none'];
                    $column->filter = false;
                }
            }
        }
        /**
         * setup extra row options
         */
        if (isset($this->extraRowHtmlOptions['class']) && !empty($this->extraRowCssClass)) {
            $this->extraRowHtmlOptions['class'] .= ' ' . $this->extraRowCssClass;
        } else {
            $this->extraRowHtmlOptions['class'] = $this->extraRowCssClass;
        }
    }

    /**
     * Registers necessary client scripts.
     */
    public function registerClientScript()
    {
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
        // $cs->registerScriptFile($this->baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
        $cs->registerPackage('group-grid-view');
        $cs->registerScript(__CLASS__ . '#' . $id, "jQuery('#$id').yiiGroupGridView($options);");
    }

    /**
     * Renders the table body.
     */
    public function renderTableBody()
    {
        if (!empty($this->mergeColumns) || !empty($this->extraRowColumns)) {
            $this->groupByColumns();
        }

        parent::renderTableBody();
    }

    /**
     * Renders a table body row.
     * @param int $row
     */
    public function renderTableRow($row)
    {
        $change = false;
        if ($this->_changes && array_key_exists($row, $this->_changes)) {
            $change = $this->_changes[$row];
            //if change in extracolumns --> put extra row
            $columnsInExtra = array_intersect(array_keys($change['columns']), $this->extraRowColumns);
            if (count($columnsInExtra) > 0) {
                $this->renderExtraRow($row, $change, $columnsInExtra);
            }
        }

        // original CGridView code
        if ($this->rowCssClassExpression !== null) {
            $data = $this->dataProvider->data[$row];
            echo '<tr class="' . $this->evaluateExpression(
                $this->rowCssClassExpression,
                ['row' => $row, 'data' => $data]
              ) . '">';
        } else {
            if (is_array($this->rowCssClass) && ($n = count($this->rowCssClass)) > 0) {
                echo '<tr class="' . $this->rowCssClass[$row % $n] . '">';
            } else {
                echo '<tr>';
            }
        }

        if (!$this->_changes) { //standart CGridview's render
            foreach ($this->columns as $column) {
                $column->renderDataCell($row);
            }
        } else { //for grouping
            foreach ($this->columns as $column) {
                $isGroupColumn = property_exists($column, 'name') && in_array($column->name, $this->mergeColumns);
                if (!$isGroupColumn) {
                    $column->renderDataCell($row);
                    continue;
                }

                $isChangedColumn = $change && array_key_exists($column->name, $change['columns']);

                //for rowspan show only changes (with rowspan)
                switch ($this->mergeType) {
                    case self::MERGE_SIMPLE:
                    case self::MERGE_NESTED:
                        if ($isChangedColumn) {
                            $options = $column->htmlOptions;
                            $column->htmlOptions['rowspan'] = $change['columns'][$column->name]['count'];
                            $column->htmlOptions['class'] = 'merge';
                            $style = isset($column->htmlOptions['style']) ? $column->htmlOptions['style'] : '';
                            $column->htmlOptions['style'] = $style . ';' . $this->mergeCellCss;
                            $column->renderDataCell($row);
                            $column->htmlOptions = $options;
                        }
                        break;

                    case self::MERGE_FIRSTROW:
                        if ($isChangedColumn) {
                            $column->renderDataCell($row);
                        } else {
                            echo '<td></td>';
                        }
                        break;
                }

            }
        }

        echo "</tr>\n";
    }
}
