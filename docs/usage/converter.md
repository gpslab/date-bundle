Converter
=========

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
