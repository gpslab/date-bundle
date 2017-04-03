[![Latest Stable Version](https://img.shields.io/packagist/v/gpslab/date-bundle.svg?maxAge=3600&label=stable)](https://packagist.org/packages/gpslab/date-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/gpslab/date-bundle.svg?maxAge=3600)](https://packagist.org/packages/gpslab/date-bundle)
[![Build Status](https://img.shields.io/travis/gpslab/date-bundle.svg?maxAge=3600)](https://travis-ci.org/gpslab/date-bundle)
[![Coverage Status](https://img.shields.io/coveralls/gpslab/date-bundle.svg?maxAge=3600)](https://coveralls.io/github/gpslab/date-bundle?branch=master)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/gpslab/date-bundle.svg?maxAge=3600)](https://scrutinizer-ci.com/g/gpslab/date-bundle/?branch=master)
[![SensioLabs Insight](https://img.shields.io/sensiolabs/i/e02ff7b3-f7f5-493e-8afc-03317ab7fe8e.svg?maxAge=3600&label=SLInsight)](https://insight.sensiolabs.com/projects/e02ff7b3-f7f5-493e-8afc-03317ab7fe8e)
[![StyleCI](https://styleci.io/repos/75742790/shield?branch=master)](https://styleci.io/repos/75742790)
[![License](https://img.shields.io/packagist/l/gpslab/date-bundle.svg?maxAge=3600)](https://github.com/gpslab/date-bundle)

Util for DateTime and DateTimeZone
==================================

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

## Configuration

```yml
gpslab_date:
    # Is not required
    # As a default used timezone from date_default_timezone_get()
    time_zone: 'Europe/Moscow'

    # HTTP Cookie parameters for store user timezone
    cookie:

        # You can disable use cookie for store user timezone
        used: true

        # HTTP Cookie variable names
        # It's a default values
        name: '_time_zone_name'
        offset: '_time_zone_offset'
```


## Documentation

 * [Installation](docs/installation.md)
 * [Configuration](docs/configuration.md)
 * Usage
    * [Converter](docs/usage/converter.md)
    * [Comparator](docs/usage/comparator.md)
    * [Formatter](docs/usage/formatter.md)
    * Timezone
      * [Converter](docs/usage/tz/converter.md)
      * [Comparator](docs/usage/tz/comparator.md)
      * [Keeper](docs/usage/tz/keeper.md)
      * [Custom timezone resolver](docs/usage/tz/resolver.md)
    * [RoundDate](docs/usage/round_date.md)
    * [Twig extension](docs/usage/twig.md)
    * [Util](docs/usage/util.md)

## License

This bundle is under the [MIT license](http://opensource.org/licenses/MIT). See the complete license in the file: LICENSE
