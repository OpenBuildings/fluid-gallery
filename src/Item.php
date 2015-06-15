<?php

namespace CL\FluidGallery;

/**
 * @author    Ivan Kerin <ikerin@gmail.com>
 * @copyright 2015, Clippings Ltd.
 * @license   http://spdx.org/licenses/BSD-3-Clause
 */
class Item
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
     * @var float|integer
     */
    private $width;

    /**
     * @var float|integer
     */
    private $height;

    /**
     * @var mixed
     */
    private $content;

    /**
     * @param string  $url
     * @param integer $width
     * @param integer $height
     * @param mixed   $content
     */
    function __construct($width, $height, $content = null) {
        $this->originalWidth = $this->width = (int) $width;
        $this->originalHeight = $this->height = (int) $height;
        $this->content = $content;
    }

    /**
     * @return float|integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return float|integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param float $total
     * @return float
     */
    public function getWidthPercent($total)
    {
        return ($this->width / $total) * 100;
    }

    /**
     * @param float $total
     * @return float
     */
    public function getHeightPercent($total)
    {
        return ($this->height / $total) * 100;
    }

    /**
     * set width, keeping aspect ratio
     *
     * @param integer $width
     */
    public function setWidth($width)
    {
        $this->width = $width;
        $this->height = $width / $this->getAspect();
    }

    /**
     * set height, keeping aspect ratio
     *
     * @param integer $height
     */
    public function setHeight($height)
    {
        $this->height = $height;
        $this->width = $height * $this->getAspect();
    }

    /**
     * @return float
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
     * @return float
     */
    public function getAspect()
    {
        return $this->originalWidth / $this->originalHeight;
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
    public function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        return "[Image {$this->originalWidth}x{$this->originalHeight} ({$this->content})]";
    }
}
