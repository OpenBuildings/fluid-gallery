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

    /**
     * @param Image[]|null $images
     */
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

    /**
     * @return array
     */
    public function all()
    {
        return $this->images;
    }

    /**
     * Set all widths
     * @param integer $width
     */
    public function setWidth($width)
    {
        foreach ($this->images as $image) {
            $image->setWidth($width);
        }

        return $this;
    }

    /**
     * Set all hights
     * @param integer $height
     */
    public function setHeight($height)
    {
        foreach ($this->images as $image) {
            $image->setHeight($height);
        }

        return $this;
    }

    /**
     * Remove all items that fall outside of width, when aligned horizontally, spaced by $margin
     * @param  integer $width
     * @param  integer $margin
     */
    public function removeItemsAfterWidth($width, $margin = 0)
    {
        $y = 0;

        foreach ($this->images as $i => $image) {

            $y += $image->getWidth() + $margin;

            if ($y > ($width + $margin)) {
                unset($this->images[$i]);
            }
        }

        return $this;
    }

    /**
     * @return integer
     */
    public function getGaps()
    {
        return max(count($this->images) - 1, 0);
    }

    /**
     * @param  integer $margin
     * @return double
     */
    public function getWidth($margin)
    {
        return $this->sumWidths() + $this->getGaps() * $margin;
    }

    /**
     * @param  integer $margin
     * @return double
     */
    public function getHeight($margin)
    {
        return $this->sumHeights() + $this->getGaps() * $margin;
    }

    /**
     * @return double
     */
    public function sumWidths()
    {
        return array_sum(array_map(function(Image $image) {
            return $image->getWidth();
        }, $this->images));
    }

    /**
     * @return double
     */
    public function sumHeights()
    {
        return array_sum(array_map(function(Image $image) {
            return $image->getHeight();
        }, $this->images));
    }

    /**
     * @return integer
     */
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
