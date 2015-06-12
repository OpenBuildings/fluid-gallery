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
     */
    public function testConstruct()
    {
        $array = [
            new Item(100, 200),
            new Item(200, 100),
        ];

        $row = new Gallery($array);

        $this->assertEquals($array, $row->getItems());
    }

    /**
     * @covers ::extract
     */
    public function testExtract()
    {
        $row = new Gallery(
            [
                new Item(100, 200),
                new Item(200, 100),
                new Item(100, 100),
            ],
            15
        );

        $extracted = $row->extract(function(ItemGroup $group) {
            return $group
                ->setHeight(50)
                ->horizontalSlice(410)
                ->scaleToWidth(410);
        });

        $this->assertEquals(410, $extracted->getWidth());
    }
}
