{%title%}
{%title_underline%}

[![Build Status](https://travis-ci.org/{%repository_name%}.png?branch=master)](https://travis-ci.org/clippings/fluid-gallery)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/{%repository_name%}/badges/quality-score.png)](https://scrutinizer-ci.com/g/clippings/fluid-gallery/)
[![Code Coverage](https://scrutinizer-ci.com/g/{%repository_name%}/badges/coverage.png)](https://scrutinizer-ci.com/g/clippings/fluid-gallery/)
[![Latest Stable Version](https://poser.pugx.org/{%repository_name%}/v/stable.png)](https://packagist.org/packages/clippings/fluid-gallery)

Arrange Images with percentages

Instalation
-----------

Install via composer

```
composer require clippings/fluid-gallery
```

Usage
-----

```php
$gallery = new Gallery([
    new Item(100, 200, 'http://example.com/1.jpg'),
    new Item(200, 100, 'http://example.com/2.jpg'),
    new Item(100, 100, 'http://example.com/3.jpg'),
    new Item(300, 200, 'http://example.com/4.jpg'),
]);

$gallery->setMargin(15);

// extract some of the images into a group
$group = $row->extract(function($group) {
    return $group
        ->setHeight(50)
        ->horizontalSlice(200)
        ->scaleToWidth(200);
});

foreach ($group as $item) {
    echo $item->getContent();
}

// Get the remaining items
$gallery->getItems();
```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
