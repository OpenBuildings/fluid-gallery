<?php

namespace CL\FluidGallery\Test;

use PHPUnit_Framework_TestCase;
use CL\FluidGallery\FluidRow;
use CL\FluidGallery\Images;
use CL\FluidGallery\Image;

/**
 * @coversDefaultClass CL\FluidGallery\FluidRow
 */
class FluidRowTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getImages
     */
    public function testConstruct()
    {
        $array = [
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
        ];

        $row = new FluidRow($array);

        $this->assertEquals(new Images($array), $row->getImages());
    }

    /**
     * @covers ::constrain
     */
    public function testConstrain()
    {
        $row = new FluidRow([
            new Image('http://example.com/1.jpg', 100, 200),
            new Image('http://example.com/2.jpg', 200, 100),
            new Image('http://example.com/3.jpg', 100, 100),
        ]);

        $row->constrain(410, 50, 15);

        $this->assertEquals(410, $row->getImages()->sumWidths() + $row->getImages()->getGaps() * 15);
    }
}
