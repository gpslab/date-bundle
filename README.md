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

### TimeZone Converter

Sets the date of a user time zone

```php
// create new instance
use GpsLab\Bundle\DateBundle\TimeZone\Converter;
$converter = new Converter($tz_keeper);

// you cat get TimeZone keeper from DI
// $tz_keeper = $this->get('gpslab.date.tz.keeper');

// for simple get the converter from DI
$converter = $this->get('gpslab.date.tz.converter');

// convert value to \DateTime
$converter->getDateTime('2016-12-07 13:56:07');
$converter->getDateTime('now');
$converter->getDateTime('first day of this month');
$converter->getDateTime(1481108167); // Unix Timestamp for 2016-12-07 13:56:07
```

### Comparator

```php
// create new instance
use GpsLab\Bundle\DateBundle\Comparator;
$comparator = new Comparator();

// for simple get comparator from DI
$comparator = $this->get('gpslab.date.comparator');

// you can use the operator constants
$comparator->compareDate(new \DateTime('2016-12-07'), Comparator::EQ, new \DateTime('2016-12-07')); // return true
// or operator as string
$comparator->compareDateTime(new \DateTime('2016-12-07'), '=', new \DateTime('2016-12-07')); // return true
$comparator->compareDate(new \DateTime('2016-12-07'), '=', new \DateTime('2016-12-07')); // return true
$comparator->compareTime(new \DateTime('2016-12-07'), '=', new \DateTime('2016-12-07')); // return true
$comparator->compareWeek(new \DateTime('2016-12-05'), '<', new \DateTime('2016-12-10')); // return false
$comparator->compareMonth(new \DateTime('2016-12-07'), '>=', new \DateTime('2016-12-14')); // return true
$comparator->compareYear(new \DateTime('2017-12-07'), '>', new \DateTime('2016-12-07')); // return true
```

### TimeZone Comparator

Sets the date of a user time zone

```php
// create new instance
use GpsLab\Bundle\DateBundle\TimeZone\Comparator;
$comparator = new Comparator($tz_keeper);

// you cat get TimeZone keeper from DI
// $tz_keeper = $this->get('gpslab.date.tz.keeper');

// for simple get the comparator from DI
$comparator = $this->get('gpslab.date.tz.comparator');

// you can use the operator constants
$comparator->compareDate(new \DateTime('2016-12-07'), Comparator::EQ, new \DateTime('2016-12-07')); // return true
// or operator as string
$comparator->compareDateTime(new \DateTime('2016-12-07'), '=', new \DateTime('2016-12-07')); // return true
$comparator->compareDate(new \DateTime('2016-12-07'), '=', new \DateTime('2016-12-07')); // return true
$comparator->compareTime(new \DateTime('2016-12-07'), '=', new \DateTime('2016-12-07')); // return true
$comparator->compareWeek(new \DateTime('2016-12-05'), '<', new \DateTime('2016-12-10')); // return false
$comparator->compareMonth(new \DateTime('2016-12-07'), '>=', new \DateTime('2016-12-14')); // return true
$comparator->compareYear(new \DateTime('2017-12-07'), '>', new \DateTime('2016-12-07')); // return true
```

### Formatter

`Formatter::format()` is equivalent `\DateTime::format()` method. Available change translations for format chars
`D`, `l`, `M`, `F` and added custom format `f` for get month name in genitive.

```php
// create new instance
use GpsLab\Bundle\DateBundle\Formatter;
$formatter = new Formatter($translator);

// you cat get translator from DI in Symfony
// $translator = $this->get('translator');

// for simple get the formatter from DI
$formatter = $this->get('gpslab.date.formatter');

$date = new \DateTime('2016-07-20 14:06:32', new \DateTimeZone('Europe/Moscow'));

$formatter->format($date, 'c'); // return '2016-07-20T14:06:32+03:00'
$formatter->format($date, 'f'); // return 'Июля'
$formatter->format($date, '\\\\U'); // return '\1469012792'
$formatter->format($date, '\\\\\\U'); // return '\U'
```

`Formatter::passed()` method for get passed date from current date.

```php
// current date is '2016-12-07 15:27:44'

// return '16 minutes ago'
$formatter->passed(new \DateTime('2016-12-07 15:12:24'));
// return 'In 3 minutes'
$formatter->passed(new \DateTime('2016-12-07 15:30:44'));
// return 'Today at 10:24'
$formatter->passed(new \DateTime('2016-12-07 10:24:44'));
// return 'Yesterday at 15:27'
$formatter->passed(new \DateTime('2016-12-06 15:27:44'));
// return 'Tomorrow at 15:27'
$formatter->passed(new \DateTime('2016-12-08 15:27:44'));
// return '24 January at 15:27'
$formatter->passed(new \DateTime('2016-12-24 15:27:44'));
// return '24 April 2016 at 15:27'
$formatter->passed(new \DateTime('2016-04-07 15:27:44'));
```

In Russian

```php
// return '24 Января в 15:27'
$formatter->passed(
    new \DateTime('2016-12-24 15:27:44'),
    Formatter::DEFAULT_PASSED_TIME_FORMAT,
    'd f в H:i'
);
// return '24 Апреля 2016 в 15:27'
$formatter->passed(
    new \DateTime('2016-04-07 15:27:44'),
    Formatter::DEFAULT_PASSED_TIME_FORMAT,
    Formatter::DEFAULT_PASSED_MONTH_FORMAT,
    'd f Y в H:i'
);
```

## Twig extension

`date` filter is overridden and use a `Formatter::format()`.

```twig
{# return 'Июля' #}
{{ '2016-07-20' | date('f') }}
```

Added functions for compare dates and times in Twig

```twig
{{ compare_date_time($x, '>', $y) }}
{{ compare_date($x, '>', $y) }}
{{ compare_time($x, '>', $y) }}
{{ compare_week($x, '>', $y) }}
{{ compare_month($x, '>', $y) }}
{{ compare_year($x, '>', $y) }}
```

## TimeZone Keeper

Timezone Keeper is a service for get default/system timezone and get user timezone and date from it.

As a default used `ResolveAndKeep` timezone keeper, but you can override it and implement `KeeperInterface`. This
service use `CollectionResolver` service for get all available timezone resolvers and use it for get user timezone.

### Custom TimeZone resolver

For add custom resolver you need create service and implement `ResolverInterface`. Example service for get timezone
for authorized user:

```php
namespace Acme\Bundle\DemoBundle\Date\TimeZone\Resolver;

class UserResolver implements ResolverInterface
{
    protected $storage;

    public function __construct(TokenStorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getUserTimeZone()
    {
        if (
            ($token = $this->storage->getToken()) &&
            ($user = $token->getUser()) &&
            $user instanceof User &&
            $user->getTimezone()
        ) {
            return new \DateTimeZone($user->getTimezone());
        }

        return null;
    }
}
```

Configure tagged service

```yml
services:
    acme.demo.date.tz.resolver.user:
        class: Acme\Bundle\DemoBundle\Date\TimeZone\Resolver\UserResolver
        arguments: [ '@security.token_storage' ]
        tags:
            - { name: gpslab.date.tz.resolver, priority: 10 }
        public: false
```

### How get it?

How get timezone keeper from DI?

```php
$tz_keeper = $this->get('gpslab.date.tz.keeper');
```

### Parameters

You can change DI parameter `%time_zone%` for change default timezone. As a default used timezone from
[date_default_timezone_get()](http://php.net/manual/en/function.date-default-timezone-get.php).

User timezone as a default stored in HTTP Cookies. DI parameter is store cookies var name:

  * Parameter `%date.time_zone.param.name%` is var name for `\DateTimeZone::getName()`;
  * Parameter `%date.time_zone.param.offset%` is var name for `\DateTimeZone::getOffset()`.

## License

This bundle is under the [MIT license](http://opensource.org/licenses/MIT). See the complete license in the file: LICENSE
