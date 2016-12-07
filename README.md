[![Latest Stable Version](https://img.shields.io/packagist/v/gpslab/date-bundle.svg?maxAge=3600&label=stable)](https://packagist.org/packages/gpslab/date-bundle)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/gpslab/date-bundle.svg?maxAge=3600&label=unstable)](https://packagist.org/packages/gpslab/date-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/gpslab/date-bundle.svg?maxAge=3600)](https://packagist.org/packages/gpslab/date-bundle)
[![Build Status](https://img.shields.io/travis/gpslab/date-bundle.svg?maxAge=3600)](https://travis-ci.org/gpslab/date-bundle)
[![Coverage Status](https://img.shields.io/coveralls/gpslab/date-bundle.svg?maxAge=3600)](https://coveralls.io/github/gpslab/date-bundle?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/gpslab/date-bundle.svg?maxAge=3600)](https://scrutinizer-ci.com/g/gpslab/date-bundle/?branch=master)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/e02ff7b3-f7f5-493e-8afc-03317ab7fe8e.svg?maxAge=3600&label=SLInsight)](https://insight.sensiolabs.com/projects/e02ff7b3-f7f5-493e-8afc-03317ab7fe8e)
[![StyleCI](https://styleci.io/repos/75742790/shield?branch=master)](https://styleci.io/repos/75742790)
[![License](https://img.shields.io/packagist/l/gpslab/date-bundle.svg?maxAge=3600)](https://github.com/gpslab/date-bundle)

Util for DateTime
===================

## Installation

Pretty simple with [Composer](http://packagist.org), run:

```sh
composer require gpslab/date-bundle
```

Add GpsLabDateBundle to your application kernel

```php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new GpsLab\Bundle\DateBundle\GpsLabDateBundle(),
        // ...
    );
}
```

## Usage

### Util

[Bugfix](https://bugs.php.net/bug.php?id=63740) for get monday of this week

```php
use GpsLab\Bundle\DateBundle\Util;

// return 2015-07-06
$monday = Util::getMondayThisWeek(new \DateTime('2015-07-12'));
```

Round date. It can be useful for caching the SQL queries.

```php
// return 12:30:00
$date = Util::roundDate(new \DateTime('12:30:24', 60));
// return 12:31:00
$date = Util::roundDate(new \DateTime('12:30:54', 60));
// return 2016-12-07 12:00:00
$date = Util::roundDate(new \DateTime('2016-12-07 12:26:24', 3600));
// return 2016-12-08 00:00:00
$date = Util::roundDate(new \DateTime('2016-12-07 23:50:22', 3600));
```

### Converter

```php
// create new instance
use GpsLab\Bundle\DateBundle\Converter;
$converter = new Converter();

// or get from DI
$converter = $this->get('gpslab.date.converter');

// convert value to \DateTime
$converter->getDateTime('2016-12-07 13:56:07');
$converter->getDateTime('now');
$converter->getDateTime('first day of this month');
$converter->getDateTime(1481108167); // Unix Timestamp for 2016-12-07 13:56:07
```

## License

This bundle is under the [MIT license](http://opensource.org/licenses/MIT). See the complete license in the file: LICENSE
