<?php

namespace CL\FluidGallery;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class FluidRow
{
    /**
     * @var Image[]
     */
    private $images;

    /**
     * @param Image[] $images
     */
    function __construct(array $images) {
        $this->images = new Images($images);
    }

    /**
     * @param  integer $width
     * @param  integer $height
     * @param  integer $margin
     */
    public function constrain($width, $height, $margin = 0)
    {
        $this->images->setHeight($height);

        $this->images->removeItemsAfterWidth($width, $margin);

        $widthWithoutMargins = $width - $this->images->getGaps() * $margin;

        if ($this->images->sumWidths() and $this->images->sumWidths() < $widthWithoutMargins) {
            $difference = $widthWithoutMargins / $this->images->sumWidths();
            $this->images->setHeight($height * $difference);
        }

        return $this;
    }

    /**
     * @return Images
     */
    public function getImages()
    {
        return $this->images;
    }
}
