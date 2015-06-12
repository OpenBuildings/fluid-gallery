<?php

namespace CL\FluidGallery\Test;

use PHPUnit_Framework_TestCase;
use CL\FluidGallery\Gallery;
use CL\FluidGallery\ItemGroup;
use CL\FluidGallery\Item;

/**
 * @coversDefaultClass CL\FluidGallery\Gallery
 */
class GalleryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getItems
     * @covers ::getMargin
     * @covers ::getMarginPercent
     */
    public function testConstruct()
    {
        $array = [
            new Item(100, 200),
            new Item(200, 100),
        ];

        $gallery = new Gallery($array, 10);

        $this->assertEquals($array, $gallery->getItems());
        $this->assertEquals(10, $gallery->getMargin());
        $this->assertEquals(50, $gallery->getMarginPercent(20));
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

        $gallery = new Gallery($array, 10);

        $gallery->add(new Item(10, 10));

        $array []= new Item(10, 10);

        $this->assertEquals($array, $gallery->getItems());
    }

    /**
     * @covers ::extract
     */
    public function testExtract()
    {
        $gallery = new Gallery(
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
}
