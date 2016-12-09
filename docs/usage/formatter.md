# Formatter

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
