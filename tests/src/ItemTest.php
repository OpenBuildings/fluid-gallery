<?php

namespace CL\FluidGallery\Test;

use PHPUnit\Framework\TestCase;
use CL\FluidGallery\Item;
use stdClass;

/**
 * @coversDefaultClass CL\FluidGallery\Item
 */
class ItemTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getWidth
     * @covers ::getHeight
     * @covers ::getOriginalWidth
     * @covers ::getOriginalHeight
     * @covers ::getContent
     * @covers ::getAspect
     * @covers ::getWidthPercent
     * @covers ::getHeightPercent
     * @covers ::__toString
     */
    public function testConstruct()
    {
        $content = 'test!';
        $item = new Item(100, 200, $content);

        $this->assertSame(100, $item->getWidth());
        $this->assertSame(100, $item->getOriginalWidth());
        $this->assertSame(200, $item->getHeight());
        $this->assertSame(200, $item->getOriginalHeight());
        $this->assertSame(0.5, $item->getAspect());
        $this->assertEquals(25, $item->getWidthPercent(400));
        $this->assertEquals(50, $item->getHeightPercent(400));
        $this->assertSame('test!', $item->getContent());
        $this->assertSame('[Image 100x200 (test!)]', (string) $item);
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
        $item = new Item($width, $height);

        $this->assertSame($isPortrait, $item->isPortrait());
        $this->assertSame($isLandscape, $item->isLandscape());
        $this->assertSame($isSquare, $item->isSquare());
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
        $item = new Item(100, 200);

        $item->setWidth(50);

        $this->assertEquals(50, $item->getWidth());
        $this->assertEquals(100, $item->getHeight());
        $this->assertEquals(100, $item->getOriginalWidth());
        $this->assertEquals(200, $item->getOriginalHeight());
        $this->assertEquals(0.5, $item->getScale());
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
        $item = new Item(100, 200);

        $item->setHeight(300);

        $this->assertEquals(150, $item->getWidth());
        $this->assertEquals(300, $item->getHeight());
        $this->assertEquals(100, $item->getOriginalWidth());
        $this->assertEquals(200, $item->getOriginalHeight());
        $this->assertEquals(1.5, $item->getScale());
    }
}
