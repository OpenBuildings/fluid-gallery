<?php

namespace CL\FluidGallery;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Image
{
    private $originalWidth;

    private $originalHeight;

    private $url;

    private $caption;

    function __construct($url, $width, $height, $caption = null) {
        $this->url = $url;
        $this->originalWidth = $this->width = (int) $width;
        $this->originalHeight = $this->height = (int) $height;
        $this->caption = $caption;
    }

    public function getWidth()
    {
        return $this->width;
    }

    public function getHeight()
    {
        return $this->height;
    }

    public function setWidth($width)
    {
        $this->width = $width;
        $this->height = $width * ($this->originalHeight/$this->originalWidth);
    }

    public function setHeight($height)
    {
        $this->height = $height;
        $this->width = $height * ($this->originalWidth/$this->originalHeight);
    }

    public function getScale()
    {
        return $this->width/$this->originalWidth;
    }

    public function getOriginalWidth()
    {
        return $this->originalWidth;
    }

    public function getOriginalHeight()
    {
        return $this->originalHeight;
    }

    public function getAspect()
    {
        return $this->width / $this->height;
    }

    public function isLandscape()
    {
        return $this->getAspect() > 1;
    }

    public function isPortrait()
    {
        return $this->getAspect() < 1;
    }

    public function isSquare()
    {
        return $this->getAspect() == 1;
    }

    public function getCaption()
    {
        return $this->caption;
    }

    public function getUrl()
    {
        return $this->url;
    }
}
