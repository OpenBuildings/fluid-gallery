<?php

namespace CL\FluidGallery\Test;

use PHPUnit\Framework\TestCase;
use CL\FluidGallery\ItemGroup;
use CL\FluidGallery\Item;

/**
 * @coversDefaultClass CL\FluidGallery\ItemGroup
 */
class ItemGroupTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getMargin
     * @covers ::getMarginPercent
     */
    public function testConstruct()
    {
        $array = [
            new Item(100, 200),
            new Item(200, 100),
        ];

        $group = new ItemGroup($array, 10);

        $this->assertEquals($array, $group->getArrayCopy());
        $this->assertEquals(10, $group->getMargin());
        $this->assertEquals(50, $group->getMarginPercent(20));
    }

    /**
     * @covers ::setMargin
     */
    public function testSetMargin()
    {
        $group = new ItemGroup([]);

        $group->setMargin(32);

        $this->assertEquals(32, $group->getMargin());
    }

    /**
     * @covers ::add
     */
    public function testAdd()
    {
        $array = [
            new Item(100, 200),
            new Item(200, 100),
        ];

        $group = new ItemGroup($array);

        $group->add(new Item(100, 100));

        $expected = [
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ];

        $this->assertEquals($expected, $group->getArrayCopy());
    }

    /**
     * @covers ::setWidth
     */
    public function testSetWidth()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ]);

        $group->setWidth(50);

        $this->assertEquals(50, $group[0]->getWidth());
        $this->assertEquals(100, $group[0]->getHeight());

        $this->assertEquals(50, $group[1]->getWidth());
        $this->assertEquals(25, $group[1]->getHeight());

        $this->assertEquals(50, $group[2]->getWidth());
        $this->assertEquals(50, $group[2]->getHeight());
    }

    /**
     * @covers ::setHeight
     */
    public function testSetHeight()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ]);

        $group->setHeight(50);

        $this->assertEquals(25, $group[0]->getWidth());
        $this->assertEquals(50, $group[0]->getHeight());

        $this->assertEquals(100, $group[1]->getWidth());
        $this->assertEquals(50, $group[1]->getHeight());

        $this->assertEquals(50, $group[2]->getWidth());
        $this->assertEquals(50, $group[2]->getHeight());
    }

    /**
     * @covers ::horizontalSlice
     */
    public function testHorizontalSlice()
    {
        $group = new ItemGroup(
            [
                new Item(100, 200),
                new Item(200, 100),
                new Item(100, 100),
            ],
            15
        );

        $sliced = $group->horizontalSlice(400);

        $expected = [
            new Item(100, 200),
            new Item(200, 100),
        ];

        $this->assertEquals($expected, $sliced->getArrayCopy());
    }

    /**
     * @covers ::verticalSlice
     */
    public function testVerticalSlice()
    {
        $group = new ItemGroup(
            [
                new Item(100, 200),
                new Item(200, 100),
                new Item(100, 100),
            ],
            15
        );

        $sliced = $group->verticalSlice(350);

        $expected = [
            new Item(100, 200),
            new Item(200, 100),
        ];

        $this->assertEquals($expected, $sliced->getArrayCopy());
    }

    /**
     * @covers ::filter
     */
    public function testFilter()
    {
        $group = new ItemGroup([
            new Item(100, 200, true),
            new Item(200, 100, false),
            new Item(100, 100, true),
        ]);

        $expected = [
            new Item(100, 200, true),
            new Item(100, 100, true),
        ];

        $filtered = $group->filter(function($item) {
            return $item->getContent();
        });

        $this->assertEquals($expected, $filtered->getArrayCopy());
    }

    /**
     * @covers ::slice
     */
    public function testSlice()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
            new Item(50, 70),
        ]);

        $expected = [
            new Item(200, 100),
            new Item(100, 100),
        ];

        $sliced = $group->slice(1, 2);

        $this->assertEquals($expected, $sliced->getArrayCopy());
    }

    /**
     * @covers ::count
     */
    public function testCount()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ]);

        $this->assertCount(3, $group);
    }

    /**
     * @covers ::getGaps
     */
    public function testGetGaps()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ]);

        $this->assertEquals(2, $group->getGaps());
    }

    /**
     * @covers ::sumWidths
     */
    public function testSumWidths()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ]);

        $this->assertEquals(400, $group->sumWidths());
    }

    /**
     * @covers ::scaleToWidth
     */
    public function testScaleToWidth()
    {
        $group = new ItemGroup(
            [
                new Item(100, 200),
                new Item(200, 100),
                new Item(100, 100),
            ],
            15
        );

        $scaled = $group->scaleToWidth(500);

        $this->assertEquals(500, $group->getWidth());
    }

    /**
    * @covers ::extract
    */
   public function testExtract()
   {
       $gallery = new ItemGroup(
           [
               new Item(100, 200),
               new Item(200, 100),
               new Item(100, 100),
           ],
           15
       );

       $extracted = $gallery->extract(function(ItemGroup $group) {
           return $group
               ->setHeight(50)
               ->horizontalSlice(410)
               ->scaleToWidth(410);
       });

       $this->assertEquals(410, $extracted->getWidth());
   }

    /**
     * @covers ::scaleToHeight
     */
    public function testScaleToHeight()
    {
        $group = new ItemGroup(
            [
                new Item(100, 200),
                new Item(200, 100),
                new Item(100, 100),
            ],
            15
        );

        $scaled = $group->scaleToHeight(500);

        $this->assertEquals(500, $group->getHeight());
    }

    /**
     * @covers ::setScale
     */
    public function testSetScale()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ]);

        $group->setScale(2);

        $this->assertEquals(800, $group->getWidth());
        $this->assertEquals(800, $group->getHeight());
    }

    /**
     * @covers ::sumHeights
     */
    public function testSumHeights()
    {
        $group = new ItemGroup([
            new Item(100, 200),
            new Item(200, 50),
            new Item(100, 100),
        ]);

        $this->assertEquals(350, $group->sumHeights());
    }

    /**
     * @covers ::getWidth
     */
    public function testGetWidth()
    {
        $group = new ItemGroup(
            [
                new Item(100, 200),
                new Item(200, 100),
                new Item(100, 100),
            ],
            15
        );

        $this->assertEquals(430, $group->getWidth());
    }

    /**
     * @covers ::getHeight
     */
    public function testGetHeight()
    {
        $group = new ItemGroup(
            [
                new Item(100, 200),
                new Item(200, 50),
                new Item(100, 100),
            ],
            15
        );

        $this->assertEquals(380, $group->getHeight());
    }

    /**
     * @coverNothing
     */
    public function testIterator()
    {
        $array = [
            new Item(100, 200),
            new Item(200, 100),
            new Item(100, 100),
        ];

        $group = new ItemGroup($array);

        foreach ($group as $i => $image) {
            $test[$i] = $image;
        }

        $this->assertEquals($array, $test);
    }
}
