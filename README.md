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
$row = new FluidRow(new FluidRow([
    new Image('http://example.com/1.jpg', 100, 200),
    new Image('http://example.com/2.jpg', 200, 100),
    new Image('http://example.com/3.jpg', 100, 100),
]);

// constrain within width / height / margin
$row->constrain(200, 50, 10);

foreach ($row->getImages() as $image) {
    echo ...
}
```

License
-------

Copyright (c) 2015, Clippings Ltd. Developed by Ivan Kerin

Under BSD-3-Clause license, read LICENSE file.
