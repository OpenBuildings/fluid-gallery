<?php

namespace CL\FluidGallery;

use Iterator;
use Countable;
use Closure;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class ItemGroup implements Iterator, Countable {

    private $position = 0;
    private $margin;
    private $items = [];

    /**
     * @param Item[]|null $items
     */
    public function __construct(array $items, $margin = 0)
    {
        foreach ($items as $item) {
            $this->add($item);
        }

        $this->margin = $margin;
    }

    public function getMargin()
    {
        return $this->margin;
    }

    public function getMarginPercent($total)
    {
        return ($this->margin / $total) * 100;
    }

    public function setMargin($margin)
    {
        $this->margin = $margin;

        return $this;
    }

    public function add(Item $item)
    {
        $this->items []= $item;
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Set all widths
     * @param integer $width
     */
    public function setWidth($width)
    {
        foreach ($this->items as $item) {
            $item->setWidth($width);
        }

        return $this;
    }

    /**
     * Set all hights
     * @param integer $height
     */
    public function setHeight($height)
    {
        foreach ($this->items as $item) {
            $item->setHeight($height);
        }

        return $this;
    }

    /**
     * Multiple the width/height of all the items by $scale
     * @param double $scale
     */
    public function setScale($scale)
    {
        foreach ($this->items as $item) {
            $item->setWidth($item->getWidth() * $scale);
        }

        return $this;
    }

    /**
     * Return a new ItemGroup with items, filtered by the Closure
     * @param  Closure $filter
     * @return ItemGroup
     */
    public function filter(Closure $filter)
    {
        return new ItemGroup(array_filter($this->items, $filter), $this->margin);
    }

    /**
     * Return a new ItemGroup with items, sliced by the $offcet and $limit
     * @param  Closure $filter
     * @return ItemGroup
     */
    public function slice($offset, $limit)
    {
        return new ItemGroup(array_slice($this->items, $offset, $limit), $this->margin);
    }

    /**
     * Scale all of the widths of the items to match an overall width, respecting margins
     * @param  double $width
     * @return ItemGroup
     */
    public function scaleToWidth($width)
    {
        $items = clone $this;
        $widthWithoutMargins = $width - $items->getGaps() * $this->margin;
        $sumWidths = $items->sumWidths();

        if ($sumWidths and $sumWidths < $widthWithoutMargins) {
            $difference = $widthWithoutMargins / $sumWidths;
            $items->setScale($difference);
        }

        return $items;
    }

    /**
     * Scale all of the widths of the items to match an overall height, respecting margins
     * @param  double $height
     * @return ItemGroup
     */
    public function scaleToHeight($height)
    {
        $items = clone $this;
        $heightWithoutMargins = $height - $items->getGaps() * $this->margin;
        $sumHeights = $items->sumHeights();

        if ($sumHeights and $sumHeights < $heightWithoutMargins) {
            $difference = $heightWithoutMargins / $sumHeights;
            $items->setScale($difference);
        }

        return $items;
    }

    /**
     * Remove all items that fall outside of width, when aligned horizontally, spaced by $margin
     * @param  integer $width
     * @param  integer $margin
     */
    public function horizontalSlice($width)
    {
        $current = 0;

        return $this
            ->filter(function(Item $item) use ($width, &$current) {
                $current += $item->getWidth() + $this->margin;

                return $current <= ($width + $this->margin);
            });
    }

    /**
     * Remove all items that fall outside of height, when aligned horizontally, spaced by $margin
     * @param  integer $height
     * @param  integer $margin
     */
    public function verticalSlice($height)
    {
        $current = 0;

        return $this->filter(function(Item $item) use ($height, &$current) {
            $current += $item->getHeight() + $this->margin;

            return $current <= ($height + $this->margin);
        });
    }

    /**
     * @return integer
     */
    public function getGaps()
    {
        return max(count($this->items) - 1, 0);
    }

    /**
     * @return double
     */
    public function getWidth()
    {
        return $this->sumWidths() + $this->getGaps() * $this->margin;
    }

    /**
     * @return double
     */
    public function getHeight()
    {
        return $this->sumHeights() + $this->getGaps() * $this->margin;
    }

    /**
     * @return double
     */
    public function sumWidths()
    {
        return array_sum(array_map(function(Item $item) {
            return $item->getWidth();
        }, $this->items));
    }

    /**
     * @return double
     */
    public function sumHeights()
    {
        return array_sum(array_map(function(Item $item) {
            return $item->getHeight();
        }, $this->items));
    }

    /**
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->items[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->items[$this->position]);
    }
}
