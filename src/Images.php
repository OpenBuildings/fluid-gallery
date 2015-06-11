<?php

namespace CL\FluidGallery;

use Iterator;
use Countable;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Images implements Iterator, Countable {

    private $position = 0;
    private $images;

    public function __construct(array $images = null)
    {
        if ($images) {
            foreach ($images as $image) {
                $this->add($image);
            }
        }
    }

    public function add(Image $image)
    {
        $this->images []= $image;
    }

    public function all()
    {
        return $this->images;
    }

    public function setWidth($width)
    {
        foreach ($this->images as $image) {
            $image->setWidth($width);
        }

        return $this;
    }

    public function setHeight($height)
    {
        foreach ($this->images as $image) {
            $image->setHeight($height);
        }

        return $this;
    }

    public function removeItemsAfterWidth($width, $margin = 0)
    {
        $y = 0;

        foreach ($this->images as $i => $image) {

            $y += $image->width + $margin;

            if ($y > ($width + $margin)) {
                unset($this->images[$i]);
            }
        }

        return $this;
    }

    public function getGaps()
    {
        return max(count($this->images) - 1, 0);
    }

    public function getWidth($margin)
    {
        return $this->sumWidths() + $this->getGaps() * $margin;
    }

    public function getHeight($margin)
    {
        return $this->sumHeights() + $this->getGaps() * $margin;
    }

    public function sumWidths()
    {
        return array_sum(array_map(function(Image $image) {
            return $image->getWidth();
        }, $this->images));
    }

    public function sumHeights()
    {
        return array_sum(array_map(function(Image $image) {
            return $image->getHeight();
        }, $this->images));
    }

    public function count()
    {
        return count($this->images);
    }

    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->images[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->images[$this->position]);
    }
}
