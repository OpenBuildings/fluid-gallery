<?php

namespace CL\FluidGallery;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Image
{
    /**
     * @var integer
     */
    private $originalWidth;

    /**
     * @var integer
     */
    private $originalHeight;

    /**
     * @var double|integer
     */
    private $width;

    /**
     * @var double|integer
     */
    private $height;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $caption;

    /**
     * @param string  $url
     * @param integer $width
     * @param integer $height
     * @param string  $caption
     */
    function __construct($url, $width, $height, $caption = null) {
        $this->url = $url;
        $this->originalWidth = $this->width = (int) $width;
        $this->originalHeight = $this->height = (int) $height;
        $this->caption = $caption;
    }

    /**
     * @return double|integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return double|integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * set width, keeping aspect ratio
     *
     * @param integer $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        $this->height = $width * ($this->originalHeight/$this->originalWidth);
    }

    /**
     * set height, keeping aspect ratio
     *
     * @param integer $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        $this->width = $height * ($this->originalWidth/$this->originalHeight);
    }

    /**
     * @return double
     */
    public function getScale()
    {
        return $this->width/$this->originalWidth;
    }

    /**
     * @return integer
     */
    public function getOriginalWidth()
    {
        return $this->originalWidth;
    }

    /**
     * @return integer
     */
    public function getOriginalHeight()
    {
        return $this->originalHeight;
    }

    /**
     * @return double
     */
    public function getAspect()
    {
        return $this->width / $this->height;
    }

    /**
     * @return boolean
     */
    public function isLandscape()
    {
        return $this->getAspect() > 1;
    }

    /**
     * @return boolean
     */
    public function isPortrait()
    {
        return $this->getAspect() < 1;
    }

    /**
     * @return boolean
     */
    public function isSquare()
    {
        return $this->getAspect() == 1;
    }

    /**
     * @return string
     */
    public function getCaption()
    {
        return $this->caption;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
