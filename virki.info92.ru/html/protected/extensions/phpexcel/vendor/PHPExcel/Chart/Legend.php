<?php

/**
 * PHPExcel_Chart_Legend
 * Copyright (c) 2006 - 2015 PHPExcel
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 * @category       PHPExcel
 * @package        PHPExcel_Chart
 * @copyright      Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license        http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version        ##VERSION##, ##DATE##
 */
class PHPExcel_Chart_Legend
{
    const POSITION_BOTTOM = 'b';    //    Below the chart.
    const POSITION_LEFT = 'l';        //    In the upper right-hand corner of the chart border.
    const POSITION_RIGHT = 'r';    //    A custom position.
    const POSITION_TOP = 't';    //    Left of the chart.
    const POSITION_TOPRIGHT = 'tr';    //    Right of the chart.
    /** Legend positions */
    const xlLegendPositionBottom = -4107;    //    Above the chart.
    const xlLegendPositionCorner = 2;
    const xlLegendPositionCustom = -4161;
    const xlLegendPositionLeft = -4131;
    const xlLegendPositionRight = -4152;
    const xlLegendPositionTop = -4160;

    /**
     *    Create a new PHPExcel_Chart_Legend
     */
    public function __construct(
      $position = self::POSITION_RIGHT,
      PHPExcel_Chart_Layout $layout = null,
      $overlay = false
    ) {
        $this->setPosition($position);
        $this->layout = $layout;
        $this->setOverlay($overlay);
    }

    /**
     * Legend Layout
     * @var    PHPExcel_Chart_Layout
     */
    private $layout = null;
    /**
     * Allow overlay of other elements?
     * @var    boolean
     */
    private $overlay = true;
    /**
     * Legend position
     * @var    string
     */
    private $position = self::POSITION_RIGHT;
    private static $positionXLref = [
      self::xlLegendPositionBottom => self::POSITION_BOTTOM,
      self::xlLegendPositionCorner => self::POSITION_TOPRIGHT,
      self::xlLegendPositionCustom => '??',
      self::xlLegendPositionLeft   => self::POSITION_LEFT,
      self::xlLegendPositionRight  => self::POSITION_RIGHT,
      self::xlLegendPositionTop    => self::POSITION_TOP,
    ];

    /**
     * Get Layout
     * @return PHPExcel_Chart_Layout
     */
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * Get allow overlay of other elements?
     * @return    boolean
     */
    public function getOverlay()
    {
        return $this->overlay;
    }

    /**
     * Set allow overlay of other elements?
     * @param boolean $overlay
     * @return    boolean
     */
    public function setOverlay($overlay = false)
    {
        if (!is_bool($overlay)) {
            return false;
        }

        $this->overlay = $overlay;
        return true;
    }

    /**
     * Get legend position as an excel string value
     * @return    string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Get legend position using an excel string value
     * @param string $position
     */
    public function setPosition($position = self::POSITION_RIGHT)
    {
        if (!in_array($position, self::$positionXLref)) {
            return false;
        }

        $this->position = $position;
        return true;
    }

    /**
     * Get legend position as an Excel internal numeric value
     * @return    number
     */
    public function getPositionXL()
    {
        return array_search($this->position, self::$positionXLref);
    }

    /**
     * Set legend position using an Excel internal numeric value
     * @param number $positionXL
     */
    public function setPositionXL($positionXL = self::xlLegendPositionRight)
    {
        if (!array_key_exists($positionXL, self::$positionXLref)) {
            return false;
        }

        $this->position = self::$positionXLref[$positionXL];
        return true;
    }
}