Fluid Gallery
=============

[![Build Status](https://travis-ci.org/clippings/fluid-gallery.svg?branch=master)](https://travis-ci.org/clippings/fluid-gallery)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/clippings/fluid-gallery/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/clippings/fluid-gallery/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/clippings/fluid-gallery/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/clippings/fluid-gallery/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/clippings/fluid-gallery/v/stable)](https://packagist.org/packages/clippings/fluid-gallery)

Arrange Images with percentages

Installation
------------

Install via composer

```
composer require clippings/fluid-gallery
```

Usage
-----
Conseptually, you pile images (or videos) into a ItemGroup and then line by line extract using custom sizing logic.

```php
$gallery = new ItemGroup([
    new Item(100, 200, 'http://example.com/1.jpg'),
    new Item(200, 100, 'http://example.com/2.jpg'),
    new Item(100, 100, 'http://example.com/3.jpg'),
    new Item(300, 200, ['url' => 'http://example.com/video.mov', 'type' => 'video']),
]);

$gallery->setMargin(15);

// extract some of the images into another group
$group = $gallery->extract(function ($group) {

    // The returned items are removed from the parent gallery
    return $group
        // get only images with text urls
        ->filter(function (Item $item) {
            return is_string($item->getContent());
        })
        // set the hight of all the images to 50, preserving the aspect ratios
        ->setHeight(50)
        // Get a slice of the images, arranged horizontally, no wider than 200 pixels
        ->horizontalSlice(200)
        // Scale horizontally arranged images to exactly 200, keeping aspect ratios
        ->scaleToWidth(200);
});

foreach ($group as $item) {
    echo $item->getContent();
}

// Get the remaining items
echo $gallery[0]->getContent()['url'];
```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
