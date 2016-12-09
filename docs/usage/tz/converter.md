# TimeZone Converter

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
