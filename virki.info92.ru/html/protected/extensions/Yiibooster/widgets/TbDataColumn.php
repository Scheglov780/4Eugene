<?php
/**
 *## TbDataColumn class file.
 * @author    Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license   [New BSD License](http://www.opensource.org/licenses/bsd-license.php)
 */

Yii::import('zii.widgets.grid.CDataColumn');

/**
 *## Bootstrap grid data column.
 * @property TbGridView|TbExtendedGridView $grid the grid view object that owns this column.
 * @package booster.widgets.grids.columns
 */
class TbDataColumn extends CDataColumn
{
    /**
     * @var array HTML options for filter input
     * @see TbDataColumn::renderFilterCellContent()
     */
    public $filterInputOptions;

    /**
     *### .renderFilterCellContent()
     * Renders the filter cell content.
     * On top of Yii's default, here we can provide HTML options for actual filter input
     * @author Sergii Gamaiunov <hello@webkadabra.com>
     */
    protected function renderFilterCellContent()
    {
        if (is_string($this->filter)) {
            echo $this->filter;
        } else {
            if ($this->filter !== false && $this->grid->filter !== null && $this->name !== null && strpos(
                $this->name,
                '.'
              ) === false
            ) {
                if ($this->filterInputOptions) {
                    $filterInputOptions = $this->filterInputOptions;
                    if (empty($filterInputOptions['id'])) {
                        $filterInputOptions['id'] = false;
                    }
                } else {
                    $filterInputOptions = [];
                }

                if (!isset($filterInputOptions['class']) || empty($filterInputOptions['class'])) {
                    $filterInputOptions['class'] = 'form-control';
                } else {
                    $filterInputOptions['class'] .= ' form-control';
                }

                if (is_array($this->filter)) {
                    if (!isset($filterInputOptions['prompt'])) {
                        $filterInputOptions['prompt'] = '';
                    }
                    echo CHtml::activeDropDownList(
                      $this->grid->filter,
                      $this->name,
                      $this->filter,
                      $filterInputOptions
                    );
                } else {
                    if ($this->filter === null) {
                        echo CHtml::activeTextField($this->grid->filter, $this->name, $filterInputOptions);
                    }
                }
            } else {
                parent::renderFilterCellContent();
            }
        }
    }

    /**
     *### .renderHeaderCellContent()
     * Renders the header cell content.
     * This method will render a link that can trigger the sorting if the column is sortable.
     */
    protected function renderHeaderCellContent()
    {
        if ($this->grid->enableSorting && $this->sortable && $this->name !== null) {
            $sort = $this->grid->dataProvider->getSort();
            $label = isset($this->header) ? $this->header : $sort->resolveLabel($this->name);

            $booster = Booster::getBooster();

            if ($sort->resolveAttribute($this->name) !== false) {
                $label .= ' <span class="caret"></span>';
            }
            /* {
                if($sort->getDirection($this->name) === CSort::SORT_ASC){
                       $label .= ' <span class="'.($booster->fontAwesomeCss ? 'fa fa-sort-asc' : 'fa fa-chevron-down').'"></span>';
                } elseif($sort->getDirection($this->name) === CSort::SORT_DESC){
                    $label .= ' <span class="'.($booster->fontAwesomeCss ? 'fa fa-sort-desc' : 'fa fa-chevron-up').'"></span>';
                } else {
                    $label .= ' ';
                }
            } */

            echo $sort->link($this->name, $label, ['class' => 'sort-link']);
        } else {
            if ($this->name !== null && $this->header === null) {
                if ($this->grid->dataProvider instanceof CActiveDataProvider) {
                    echo CHtml::encode($this->grid->dataProvider->model->getAttributeLabel($this->name));
                } else {
                    echo CHtml::encode($this->name);
                }
            } else {
                parent::renderHeaderCellContent();
            }
        }
    }

    /**
     * Renders a data cell.
     * @param integer $row the row number (zero-based)
     *                     Overrides the method 'renderDataCell()' of the abstract class CGridColumn
     */
    public function renderDataCell($row)
    {
        $data = $this->grid->dataProvider->data[$row];
        $callable = is_callable($this->htmlOptions);
        if (is_callable($this->htmlOptions)) {
            //$options = $this->evaluateExpression($this->htmlOptions,array('row'=>$row,'data'=>$data));
            $options = call_user_func_array($this->htmlOptions, ['data' => $data, 'row' => $row]);
        } else {
            $options = $this->htmlOptions;
        }
        if ($this->cssClassExpression !== null) {
            $class = $this->evaluateExpression($this->cssClassExpression, ['row' => $row, 'data' => $data]);
            if (!empty($class)) {
                if (isset($options['class'])) {
                    $options['class'] .= ' ' . $class;
                } else {
                    $options['class'] = $class;
                }
            }
        }
        echo CHtml::openTag('td', $options);
        $this->renderDataCellContent($row, $data);
        echo '</td>';
    }

    /**
     *### .renderFilterCell()
     * Renders the filter cell.
     * @author antonio ramirez <antonio@clevertech.biz>
     * @since  24/09/2012 added filterHtmlOptions
     */
    public function renderFilterCell()
    {
        echo CHtml::openTag('td', $this->filterHtmlOptions);
        echo '<div class="filter-container">';
        $this->renderFilterCellContent();
        echo '</div>';
        echo CHtml::closeTag('td');
    }
}
