<?php

namespace CL\FluidGallery\Test;

use PHPUnit_Framework_TestCase;
use CL\FluidGallery\Image;

/**
 * @coversDefaultClass CL\FluidGallery\Image
 */
class ImageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getWidth
     * @covers ::getHeight
     * @covers ::getOriginalWidth
     * @covers ::getOriginalHeight
     * @covers ::getCaption
     * @covers ::getUrl
     * @covers ::getAspect
     */
    public function testConstruct()
    {
        $image = new Image('http://example.com/image.jpg', 100, 200, 'Caption');

        $this->assertEquals('http://example.com/image.jpg', $image->getUrl());
        $this->assertEquals(100, $image->getWidth());
        $this->assertEquals(100, $image->getOriginalWidth());
        $this->assertEquals(200, $image->getHeight());
        $this->assertEquals(200, $image->getOriginalHeight());
        $this->assertEquals(0.5, $image->getAspect());
        $this->assertEquals('Caption', $image->getCaption());
    }

    public function dataTypes()
    {
        return [
            [300, 100, true, false, false],
            [100, 200, false, true, false],
            [300, 300, false, false, true],
        ];
    }

    /**
     * @dataProvider dataTypes
     * @covers ::isLandscape
     * @covers ::isPortrait
     * @covers ::isSquare
     */
    public function testTypes($width, $height, $isLandscape, $isPortrait, $isSquare)
    {
        $image = new Image('http://example.com/image.jpg', $width, $height);

        $this->assertSame($isPortrait, $image->isPortrait());
        $this->assertSame($isLandscape, $image->isLandscape());
        $this->assertSame($isSquare, $image->isSquare());
    }

    /**
     * @covers ::setWidth
     * @covers ::getWidth
     * @covers ::getOriginalWidth
     * @covers ::getHeight
     * @covers ::getOriginalHeight
     * @covers ::getScale
     */
    public function testWidthScaling()
    {
        $image = new Image('http://example.com/image.jpg', 100, 200);

        $image->setWidth(50);

        $this->assertEquals(50, $image->getWidth());
        $this->assertEquals(100, $image->getHeight());
        $this->assertEquals(100, $image->getOriginalWidth());
        $this->assertEquals(200, $image->getOriginalHeight());
        $this->assertEquals(0.5, $image->getScale());
    }

    /**
     * @covers ::setHeight
     * @covers ::getHeight
     * @covers ::getOriginalHeight
     * @covers ::getWidth
     * @covers ::getOriginalWidth
     * @covers ::getScale
     */
    public function testHeightScaling()
    {
        $image = new Image('http://example.com/image.jpg', 100, 200);

        $image->setHeight(300);

        $this->assertEquals(150, $image->getWidth());
        $this->assertEquals(300, $image->getHeight());
        $this->assertEquals(100, $image->getOriginalWidth());
        $this->assertEquals(200, $image->getOriginalHeight());
        $this->assertEquals(1.5, $image->getScale());
    }
}
