<?php

namespace CL\FluidGallery\Test;

use PHPUnit_Framework_TestCase;
use CL\FluidGallery\Images;
use CL\FluidGallery\Image;

/**
 * @coversDefaultClass CL\FluidGallery\Images
 */
class ImagesTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::all
     */
    public function testConstruct()
    {
        $array = [
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
        ];

        $images = new Images($array);

        $this->assertEquals($array, $images->all());
    }

    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $array = [
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
        ];

        $images = new Images($array);

        $images->add(new Image('http://example.com/3.jpg', 100, 100));

        $expected = [
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ];

        $this->assertEquals($expected, $images->all());
    }

    /**
     * @covers ::setWidth
     */
    public function testSetWidth()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $images->setWidth(50);

        $array = $images->all();

        $this->assertEquals(50, $array[0]->getWidth());
        $this->assertEquals(100, $array[0]->getHeight());

        $this->assertEquals(50, $array[1]->getWidth());
        $this->assertEquals(25, $array[1]->getHeight());

        $this->assertEquals(50, $array[2]->getWidth());
        $this->assertEquals(50, $array[2]->getHeight());
    }

    /**
     * @covers ::setHeight
     */
    public function testSetHeight()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $images->setHeight(50);

        $array = $images->all();

        $this->assertEquals(25, $array[0]->getWidth());
        $this->assertEquals(50, $array[0]->getHeight());

        $this->assertEquals(100, $array[1]->getWidth());
        $this->assertEquals(50, $array[1]->getHeight());

        $this->assertEquals(50, $array[2]->getWidth());
        $this->assertEquals(50, $array[2]->getHeight());
    }

    /**
     * @covers ::removeItemsAfterWidth
     */
    public function testRemoveItemsAfterWidth()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $images->removeItemsAfterWidth(400, 15);

        $expected = [
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
        ];

        $this->assertEquals($expected, $images->all());
    }

    /**
     * @covers ::count
     */
    public function testCount()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $this->assertCount(3, $images);
    }

    /**
     * @covers ::getGaps
     */
    public function testGetGaps()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $this->assertEquals(2, $images->getGaps());
    }

    /**
     * @covers ::sumWidths
     */
    public function testSumWidths()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $this->assertEquals(400, $images->sumWidths(15));
    }

    /**
     * @covers ::sumHeights
     */
    public function testSumHeights()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 50),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $this->assertEquals(350, $images->sumHeights(15));
    }

    /**
     * @covers ::getWidth
     */
    public function testGetWidth()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $this->assertEquals(430, $images->getWidth(15));
    }

    /**
     * @covers ::getHeight
     */
    public function testGetHeight()
    {
        $images = new Images([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 50),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $this->assertEquals(380, $images->getHeight(15));
    }

    /**
     * @covers ::rewind
     * @covers ::current
     * @covers ::key
     * @covers ::next
     * @covers ::valid
     */
    public function testIterator()
    {
        $array = [
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ];

        $images = new Images($array);

        foreach ($images as $image) {
            $test []= $image;
        }

        $this->assertEquals($array, $test);
    }
}
