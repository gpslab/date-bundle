Util
====

## Bugfix

[Bugfix](https://bugs.php.net/bug.php?id=63740) for get monday of this week

```php
use GpsLab\Bundle\DateBundle\Util;

// return 2015-07-06
$monday = Util::getMondayThisWeek(new \DateTime('2015-07-12'));
```
