# Comparator

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
