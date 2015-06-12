<?php

namespace CL\FluidGallery;

use Closure;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Gallery
{
    /**
     * @var Item[]
     */
    private $items;

    private $margin;

    /**
     * @param Item[] $items
     */
    function __construct(array $items, $margin = 0) {
        $this->items = $items;
        $this->margin = $margin;
    }

    public function add(Item $item)
    {
        $this->items []= $item;

        return $this;
    }

    public function getMargin()
    {
        return $this->margin;
    }

    public function getMarginPercent($total)
    {
        return ($this->margin / $total) * 100;
    }

    public function extract(Closure $extract)
    {
        $extracted = $extract(new ItemGroup($this->items, $this->margin));

        $this->items = array_diff($this->items, $extracted->all());

        return $extracted;
    }

    /**
     * @return Images
     */
    public function getItems()
    {
        return $this->items;
    }
}
