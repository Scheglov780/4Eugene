<?php

/**
 * HighstockWidget class file.
 * @author  Milo Schuman <miloschuman@gmail.com>
 * @link    https://github.com/miloschuman/yii-highcharts/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'HighchartsWidget.php');

/**
 * @see HighchartsWidget
 */
class HighstockWidget extends HighchartsWidget
{
    protected $_baseScript = 'highstock';
    protected $_constr = 'StockChart';
}
